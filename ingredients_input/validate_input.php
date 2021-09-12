<?php
include "../shared/php/database.php";

$conn = connect_local_or_server();
header("Content-Type: application/json");
$request = file_get_contents("php://input");

if (isset($request) && !empty($request)) {
    $existing_entry = get_ingredients_by_user_id($conn, json_decode($request)->userId);
    if($existing_entry){
        $success = change_ingredients($conn, json_decode($request)->ingredients, json_decode($request)->userId);
    }
    else{
        $success = set_ingredients($conn, json_decode($request)->ingredients, json_decode($request)->userId);
    }

    if ($success === 0) {
        $result["errorText"] = "Not able to set user ingredients.";
    }

    if (isset($result["errorText"])) {
        echo json_encode(["error" => true, "errorText" => $result["errorText"]]);
    } else {
        echo json_encode(["error" => false, "errorText" => ""]);
    }
} else {
    echo json_encode(["error" => true, "errorText" => "Request is not set or is empty."]);
}