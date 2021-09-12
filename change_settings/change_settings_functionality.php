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
    }
}