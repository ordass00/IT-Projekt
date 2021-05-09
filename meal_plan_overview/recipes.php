<?php
include "../shared/php/database.php";

$conn = connect_local();
header("Content-Type: application/json");
$request = file_get_contents("php://input");

if (isset($request) && !empty($request)) {
    $recipes = get_recipes_by_user_id($conn, json_decode($request)->userId);
    if (isset($recipes["errorText"])) {
        echo json_encode(["recipes" => null, "error" => true, "errorText" => $recipes["errorText"]]);
    }
    else {
        echo json_encode(["recipes" => $recipes, "error" => false, "errorText" => ""]);
    }
} else {
    echo json_encode(["recipes" => null, "error" => true, "errorText" => "Request is not set or is empty"]);
}

function get_recipes_by_user_id($conn, $user_id): array|bool|string
{
    $ingredientsAtHome = get_ingredients_by_user_id($conn, $user_id);
    $preferences = get_preferences_by_user_id($conn, $user_id);

    if($ingredientsAtHome == null || $preferences == null || $conn == null || $user_id == null){
        return ["errorText" => "The server couldn't connect to the database."];
    }
    elseif ($ingredientsAtHome == false){
        return ["errorText" => "Couldn't find any ingredients."];
    }
    elseif ($preferences == false){
        return ["errorText" => "Couldn't find any preferences."];
    }

    $response_array = array();
    $response_array["breakfast"] = json_decode(api_call(generate_complex_search_url($preferences, $ingredientsAtHome, "breakfast")))->results[0];
    $response_array["lunch"] = json_decode(api_call(generate_complex_search_url($preferences, $ingredientsAtHome, "lunch")))->results[0];
    $response_array["dinner"] = json_decode(api_call(generate_complex_search_url($preferences, $ingredientsAtHome, "dinner")))->results[0];
    return $response_array;
}

function generate_complex_search_url($preferences, $ingredientsAtHome, $type): string
{
    $url = "https://spoonacular-recipe-food-nutrition-v1.p.rapidapi.com/recipes/complexSearch?diet=";
    $url .= $preferences["DietType"];
    $url .= "&intolerances=";
    $intolerances = explode(", ", $preferences["intolerances"]);
    for($i = 0; $i < count($intolerances) - 1; $i++)
    {
        $url .= $intolerances[$i] . ",";
    }
    $url .= $intolerances[count($intolerances) - 1];

    $ingredientsAtHome = explode(", ", $ingredientsAtHome["IngredientsAtHome"]);
    $url .= "&includeIngredients=";
    for($i = 0; $i < count($ingredientsAtHome) - 1; $i++)
    {
        $url .= $ingredientsAtHome[$i] . ",";
    }

    $url .= $ingredientsAtHome[count($ingredientsAtHome) - 1];
    $url .= "&type=" . $type;
    $url .= "&fillIngredients=true&sort=max-used-ingredients";
    $url .= "&maxCalories=" . intdiv ($preferences["Calories"], 3) . "&number=1";
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

function get_ingredients_by_user_id($conn, $user_id){
    if ($conn == null || $user_id == null) {
        return null;
    }
    $sql = "SELECT IngredientsAtHome from ingredients WHERE user_id= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();
    return $stmt ->fetch(PDO::FETCH_ASSOC);
}