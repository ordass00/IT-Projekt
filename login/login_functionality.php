<?php
session_start();
include "../shared/php/database.php";

header("Content-Type: application/json");
$request = file_get_contents("php://input");
$conn = connect_local_or_server();

if (isset($request) && !empty($request)) {
    $reqObj = json_decode($request);
    switch ($reqObj->method) {
        case "login_validation":
            $email = $reqObj->email;
            $password = $reqObj->password;
            if (!empty($email) && !empty($password)){
                $user_information = get_user_by_mail($conn, $email);
                if($user_information == false) {
                    echo json_encode(["error" => true, "errorText" => "Invalid email or email is not yet registered."]);
                    break;
                }
                $user_id = $user_information["ID"];
                $hashed_password = $user_information["Password"];
                if(password_verify($password, $hashed_password)) {
                    $_SESSION["loggedin"] = true;
                    $_SESSION["userid"] = $user_id;
                    $_SESSION["firstname"] = $user_information["FirstName"];
                    $_SESSION["lastname"] = $user_information["LastName"];
                    $_SESSION["username"] = $user_information["Username"];
                    $_SESSION["email"] = $user_information["EMail"];
                    $_SESSION["dateofbirth"] = $user_information["DateOfBirth"];
                    $preferences = get_preferences_by_user_id($conn, $user_id);
                    $ingredients = get_ingredients_by_user_id($conn, $user_id);
                    if ($preferences == false) {
                        echo json_encode(["error" => false, "errorText" => "", "preferences_set" => false]);
                    } else if ($ingredients == false) {
                        echo json_encode(["error" => false, "errorText" => "", "ingredients_set" => false]);
                    } else {
                        echo json_encode(["error" => false, "errorText" => "", "preferences_set" => true,"ingredients_set" => true]);
                    }
                } else {
                    echo json_encode(["error" => true, "errorText" => "Invalid password."]);
                }
            } else {
                echo json_encode(["error" => true, "errorText" => "Please fill out both input fields."]);
            }
            break;
    }
}
?>
