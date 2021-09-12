<?php
include "../shared/php/database.php";

$conn = connect_local_or_server();
header("Content-Type: application/json");
$request = file_get_contents("php://input");

if (isset($request) && !empty($request)) {
    $reqObj = json_decode($request);
    if(empty($reqObj->ingredients)){
        echo json_encode(["error" => true, "errorText" => "Please fill out the textarea."]);
    } else {
        $existing_entry = get_ingredients_by_user_id($conn, json_decode($request)->userId);
        if($existing_entry){
            $success = change_ingredients($conn, json_decode($request)->ingredients, json_decode($request)->userId);
            if (!$success){
//                echo json_encode(["error" => true, "errorText" => "Failed to change ingredients."]);
                $result["errorText"] = "Failed to change ingredients.";
            } else {
                $successfully_deleted_old_meals = delete_meals_by_user_id($conn, json_decode($request)->userId);
                if (!$successfully_deleted_old_meals){
//                    echo json_encode(["error" => true, "errorText" => "Failed to delete meals with old preferences."]);
                    $result["errorText"] = "Failed to delete meals with old preferences.";
                }
            }
        }
        else{
            $success = set_ingredients($conn, json_decode($request)->ingredients, json_decode($request)->userId);
            if (!$success) {
                $result["errorText"] = "Not able to set user ingredients.";
            }
        }
        if (isset($result["errorText"])) {
            echo json_encode(["error" => true, "errorText" => $result["errorText"]]);
        } else {
            echo json_encode(["error" => false, "errorText" => ""]);
        }
    }
} else {
    echo json_encode(["error" => true, "errorText" => "Request is not set or is empty."]);
}