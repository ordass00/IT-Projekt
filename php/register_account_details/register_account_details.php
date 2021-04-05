<?php
include "../database.php";

$conn = connect_local();

header("Content-Type: application/json");

$request = file_get_contents("php://input");

if (isset($request) && !empty($request)) {
    $reqObj = json_decode($request);
    //Checking for duplicates depending on input
    switch ($reqObj->method) {
        case "check_duplicates_email":
            $user = get_user_by_mail($conn, $reqObj->email);
            if ($user == false) {
                echo json_encode(["error" => false, "errorText" => ""]);
            } else if ($user != false || $user == null) {
                echo json_encode(["error" => true, "errorText" => "The email is already registered."]);
            } else {
                echo json_encode(["error" => true, "errorText" => "An unknown error occured."]);
            }
            break;
        case "check_duplicates_username":
            $user = get_user_by_username($conn, $reqObj->username);
            if ($user == false || $user == null) {
                echo json_encode(["error" => false, "errorText" => ""]);
            } else if ($user != false) {
                echo json_encode(["error" => true, "errorText" => "The username is already registered."]);
            } else {
                echo json_encode(["error" => true, "errorText" => "An unknown error occured."]);
            }
            break;
        case "register_user":
            $success = set_user($conn, $reqObj->firstName, $reqObj->lastName, $reqObj->dateOfBirth, $reqObj->gender, $reqObj->username, $reqObj->password, $reqObj->email);
            if ($success) {
                echo json_encode(["error" => false, "errorText" => ""]);
            } else {
                echo json_encode(["error" => true, "errorText" => "Not able to create user account."]);
            }
            break;
    }
}
