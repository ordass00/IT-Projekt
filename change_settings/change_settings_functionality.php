<?php
session_start();
include "../shared/php/database.php";

header("Content-Type: application/json");
$request = file_get_contents("php://input");
$conn = connect_local_or_server();

if (isset($request) && !empty($request)) {
    $reqObj = json_decode($request);
    switch ($reqObj->method) {
        case "change_user_information":
            $updated_user_information = change_user_information($conn, $reqObj->userid, $reqObj->firstname, $reqObj->lastname, $reqObj->username, $reqObj->email, $reqObj->dateOfBirth);
            if (!$updated_user_information) {
                echo json_encode(["error" => true, "errorText" => "Failed to change personal information."]);
            } else {
                $user_information = get_user_by_user_id($conn, $reqObj->userid);
                $updated_account_information = array();
                $updated_account_information["username"] = $user_information["Username"];
                $updated_account_information["firstname"] = $user_information["FirstName"];
                $updated_account_information["lastname"] = $user_information["LastName"];
                $updated_account_information["email"] = $user_information["EMail"];
                $updated_account_information["dateofbirth"] = $user_information["DateOfBirth"];
                echo json_encode(["error" => false, "errorText" => "", "account_information" => $updated_account_information]);
            }
            break;

        case "change_password":
            $pattern = "/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/";
            $password = $reqObj->password;
            $password_repeat = $reqObj->password_repeat;
            if ((!empty($password) && !empty($password_repeat))) {
                if ($password == $password_repeat) {
                    if (preg_match($pattern, $password) == 1 && preg_match($pattern, $password_repeat) == 1) {
                        $password_encrypted = password_hash($reqObj->password, PASSWORD_BCRYPT);
                        $success = reset_password($conn, $_SESSION["userid"], $password_encrypted);
                        if ($success) {
                            echo json_encode(["error" => false, "errorText" => ""]);
                        } else {
                            echo json_encode(["error" => true, "errorText" => "Could not reset password. Try again later."]);
                        }
                    } else {
                        echo json_encode(["error" => true, "errorText" => "Your input must match the required format."]);
                    }
                } else {
                    echo json_encode(["error" => true, "errorText" => "Passwords do not match."]);
                }
            } else {
                echo json_encode(["error" => true, "errorText" => "Please fill out both input fields."]);
            }
            break;

        case "change_preferences":
            $intolerances_string = "";
            $intolerances_array = $reqObj->intolerances;
            if(!empty($intolerances_array)){
                foreach($intolerances_array as $intolerance) {
                    $intolerances_string .= $intolerance . ", ";
                }
                $intolerances_string = rtrim($intolerances_string, ", ");
            }

            $success = change_preferences($conn, $reqObj->userid, $reqObj->dietType, $intolerances_string, $reqObj->calories);
            if (!$success){
                echo json_encode(["error" => true, "errorText" => "Failed to change preferences."]);
            } else {
                $successfully_deleted_old_meals = delete_meals_by_user_id($conn, $reqObj->userid);
                if (!$successfully_deleted_old_meals){
                    echo json_encode(["error" => true, "errorText" => "Failed to delete meals with old preferences."]);
                } else {
                    echo json_encode(["error" => false, "errorText" => ""]);
                }
            }
            break;

        case "display_settings":
            $preferences = get_preferences_by_user_id($conn, $reqObj->userid);
            $ingredients = get_ingredients_by_user_id($conn, $reqObj->userid);
            $user_information = get_user_by_user_id($conn, $reqObj->userid);
            if ($preferences != false && $ingredients != false && $user_information != false) {
                $displayed_preferences = array();
                $displayed_ingredients = array();
                $displayed_general_information = array();
                $displayed_preferences["diet_type"] = $preferences["DietType"];
                $displayed_preferences["intolerances"] = $preferences["Intolerances"];
                $displayed_preferences["calories"] = $preferences["Calories"];
                $displayed_ingredients["ingredients"] = $ingredients["IngredientsAtHome"];
                $displayed_general_information["dateofbirth"] = $user_information["DateOfBirth"];
                $displayed_general_information["username"] = $user_information["Username"];
                $displayed_general_information["firstname"] = $user_information["FirstName"];
                $displayed_general_information["lastname"] = $user_information["LastName"];
                $displayed_general_information["email"] = $user_information["EMail"];
                echo json_encode(["error" => false, "errorText" => "", "preferences" => $displayed_preferences, "ingredients" => $displayed_ingredients, "user_information" => $displayed_general_information]);
            } else {
                echo json_encode(["error" => true, "errorText" => "Failed to retrieve information."]);
            }
            break;

        case "delete_account":
            $hashed_password_from_db = get_hashed_password_by_user_id($conn, $reqObj->userid);
            $hashed_password_from_db = $hashed_password_from_db["Password"];
            $current_password_input = $reqObj->current_password;
            if(empty($current_password_input)){
                echo json_encode(["error" => true, "errorText" => "Please fill out the input field."]);
                exit;
            }
            if (password_verify($current_password_input, $hashed_password_from_db)) {
                $deleted_account = delete_account_by_user_id($conn, $reqObj->userid);
                if ($deleted_account != false ) {
                    echo json_encode(["error" => false, "errorText" => ""]);
                } else {
                    echo json_encode(["error" => true, "errorText" => "Failed to delete the account."]);
                }
            } else {
                echo json_encode(["error" => true, "errorText" => "Entered password is not your current password. Please try again."]);
            }
            break;
    }
}