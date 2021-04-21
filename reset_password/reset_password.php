<?php
include "../shared/php/database.php";

$conn = connect_local();

header("Content-Type: application/json");

$request = file_get_contents("php://input");

if (isset($request) && !empty($request)) {
    $reqObj = json_decode($request);
    $email = get_user_by_mail($conn, $reqObj->email);
    if (!$email) {
        echo json_encode(["error" => true, "errorText" => "E-Mail not found", "resetToken" => ""]);
    } else {
        $random_token = random_bytes(64);
        $expire_time = time() + (15*60);
        echo json_encode(["error" => false, "errorText" => "", "resetToken" => $random_token]);
    }
}
