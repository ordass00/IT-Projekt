<?php
include "../shared/php/database.php";

$conn = connect_local_or_server();
header("Content-Type: application/json");
$request = file_get_contents("php://input");

if (isset($request) && !empty($request)) {
    if (isset(json_decode($request)->function_name)) {
        $function_name = json_decode($request)->function_name;
        if ($function_name == "get_recipes_by_user_id") {
            $result = get_recipes_by_user_id($conn, json_decode($request)->userId);
        } else if ($function_name == "get_taste_and_nutrient_visualization") {
            $result = get_taste_and_nutrient_visualization(json_decode($request)->meal_id);
        } else if ($function_name == "increment_current_meal_nr") {
            $result = increment_current_meal_nr($conn, json_decode($request)->userId, json_decode($request)->meal_type_nr);
        } else {
            $result["errorText"] = "Can't call function: " . $function_name . ".";
        }
    } else {
        $result["errorText"] = "Function_name is not set or is empty.";
    }

    if (isset($result["errorText"])) {
        echo json_encode(["result" => null, "error" => true, "errorText" => $result["errorText"]]);
    } else {
        echo json_encode(["result" => $result, "error" => false, "errorText" => ""], JSON_INVALID_UTF8_IGNORE);
    }
} else {
    echo json_encode(["result" => null, "error" => true, "errorText" => "Request is not set or is empty."]);
}

function get_recipes_by_user_id($conn, $user_id): array|bool|string
{
    $ingredientsAtHome = get_ingredients_by_user_id($conn, $user_id);
    $preferences = get_preferences_by_user_id($conn, $user_id);

    if ($ingredientsAtHome == null || $preferences == null || $conn == null || $user_id == null) {
        return ["errorText" => "The server couldn't connect to the database."];
    } elseif ($ingredientsAtHome == false) {
        return ["errorText" => "Couldn't find any ingredients."];
    } elseif ($preferences == false) {
        return ["errorText" => "Couldn't find any preferences."];
    }

    $response_array = array();
    if (!empty(get_meals($conn, "breakfast", $user_id))) {
        $response_array["breakfast"] = get_meals($conn, "breakfast", $user_id)[get_current_meal_nr($conn, $user_id, "BreakfastNr")];
    }
    if (!empty(get_meals($conn, "lunch", $user_id))) {
        $response_array["lunch"] = get_meals($conn, "lunch", $user_id)[get_current_meal_nr($conn, $user_id, "LunchNr")];
    }
    if (!empty(get_meals($conn, "dinner", $user_id))) {
        $response_array["dinner"] = get_meals($conn, "dinner", $user_id)[get_current_meal_nr($conn, $user_id, "DinnerNr")];
    }

    if (empty($response_array["breakfast"])) {
        $response_array["breakfast"] = get_meals_from_api_and_insert_in_db_and_return_first_meal($conn, $user_id, $preferences, $ingredientsAtHome, "breakfast");
    }
    if (empty($response_array["lunch"])) {
        $response_array["lunch"] = get_meals_from_api_and_insert_in_db_and_return_first_meal($conn, $user_id, $preferences, $ingredientsAtHome, "lunch");
    }
    if (empty($response_array["dinner"])) {
        $response_array["dinner"] = get_meals_from_api_and_insert_in_db_and_return_first_meal($conn, $user_id, $preferences, $ingredientsAtHome, "dinner");
    }
    return $response_array;
}

function generate_complex_search_url($preferences, $ingredientsAtHome, $type): string
{
    $url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/complexSearch?diet=";
    $url .= $preferences["DietType"];
    $url .= "&intolerances=";
    $intolerances = explode(", ", $preferences["intolerances"]);
    for ($i = 0; $i < count($intolerances) - 1; $i++) {
        $url .= $intolerances[$i] . ",";
    }
    $url .= $intolerances[count($intolerances) - 1];

    $ingredientsAtHome = explode(", ", $ingredientsAtHome["IngredientsAtHome"]);
    $url .= "&includeIngredients=";
    for ($i = 0; $i < count($ingredientsAtHome) - 1; $i++) {
        $url .= $ingredientsAtHome[$i] . ",";
    }
    $url .= $ingredientsAtHome[count($ingredientsAtHome) - 1];
    $url .= "&type=" . $type;
    $url .= "&fillIngredients=true&sort=max-used-ingredients";
    $url .= "&maxCalories=" . intdiv($preferences["Calories"], 3) . "&number=10";
    return $url;
}

function api_call($url): array|bool|string
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: spoonacular-recipe-food-nutrition-v1.p.rapidapi.com",
            "x-rapidapi-key: e6d9c374c2msh9c2a2f9d2af8c82p1e7711jsnb468ded3ed69"
        ],
    ]);

    $response = curl_exec($curl);
    $errorText = curl_error($curl);

    curl_close($curl);

    return $errorText ? ["errorText" => "cURL Error #:" . $errorText] : $response;
}

function get_taste_and_nutrient_visualization($id)
{
    return api_call("https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/" . $id . "/nutritionWidget?defaultCss=true");
}

function insert_meal($conn, $meal_id, $meal_type, $title, $image, $used_ingredients, $missed_ingredients, $user_id)
{
    $used_ingredients_string = create_ingredients_string($used_ingredients);
    $missed_ingredients_string = create_ingredients_string($missed_ingredients);

    $sql = "INSERT INTO meals(MealID, MealType, Title, Image, UsedIngredients, MissedIngredients, User_ID) VALUES (:meal_id, :meal_type, :title, :image, :used_ingredients, :missed_ingredients, :user_id)";
    $statement = $conn->prepare($sql);
    $statement->execute(["meal_id" => $meal_id, "meal_type" => $meal_type, "title" => $title, "image" => $image, "used_ingredients" => $used_ingredients_string, "missed_ingredients" => $missed_ingredients_string, "user_id" => $user_id]);
}

function create_ingredients_string($ingredients): string
{
    $ingredients_string = "";
    if (!empty($ingredients)) {
        for ($i = 0; $i < count($ingredients) - 1; $i++) {
            $ingredients_string .= $ingredients[$i]["originalString"] . "; ";
        }
        $ingredients_string .= $ingredients[count($ingredients) - 1]["originalString"];
    }
    return $ingredients_string;
}

function get_meals($conn, $meal_type, $user_id)
{
    $sql = "select * from meals where MealType = ? and User_ID = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $meal_type);
    $stmt->bindParam(2, $user_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_meals_from_api_and_insert_in_db_and_return_first_meal($conn, $user_id, $preferences, $ingredientsAtHome, $meal_type)
{
    $result_array = json_decode(api_call(generate_complex_search_url($preferences, $ingredientsAtHome, $meal_type)), true)["results"];
    if ($meal_type == "breakfast" || $meal_type == "lunch") {
        for ($i = 0; $i < 5; $i++) {
            insert_meal($conn, $result_array[$i]["id"], $meal_type, $result_array[$i]["title"], $result_array[$i]["image"], $result_array[$i]["usedIngredients"], $result_array[$i]["missedIngredients"], $user_id);
        }
    } else {
        for ($i = 5; $i < 10; $i++) {
            insert_meal($conn, $result_array[$i]["id"], $meal_type, $result_array[$i]["title"], $result_array[$i]["image"], $result_array[$i]["usedIngredients"], $result_array[$i]["missedIngredients"], $user_id);
        }
    }
    return get_meals($conn, $meal_type, $user_id)[0];
}

function get_current_meal_nr($conn, $user_id, $meal_type_nr)
{
    $sql = "select " . $meal_type_nr . " from user where ID = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();
    $nr = $stmt->fetch(PDO::FETCH_ASSOC);
    return $nr[$meal_type_nr];
}

function increment_current_meal_nr($conn, $user_id, $meal_type_nr)
{
    $nr = get_current_meal_nr($conn, $user_id, $meal_type_nr);
    $sql = "update user set " . $meal_type_nr . " = ? where ID = ?;";
    $stmt = $conn->prepare($sql);
    $incremented_nr = ($nr + 1) % 5;
    $stmt->bindParam(1, $incremented_nr);
    $stmt->bindParam(2, $user_id);
    return $stmt->execute();
}