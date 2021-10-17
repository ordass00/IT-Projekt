<?php
include "../shared/php/database.php";

$conn = connect_local_or_server();

header("Content-Type: application/json");

$request = file_get_contents("php://input");

if (isset($request) && !empty($request)) {
  $reqObj = json_decode($request);
  switch ($reqObj->method) {
    case "reset_password_request":
      $email = get_user_by_mail($conn, $reqObj->email);
      if (!$email) {
        echo json_encode(["error" => true, "errorText" => "E-Mail not found."]);
        exit;
      } else {
        $id = $email["ID"];
        $email = $email["EMail"];

        $older_password_reset = get_password_reset($conn, $id);
        $password_reset = json_decode($older_password_reset["PasswordReset"]);
        if (isset($password_reset->last_reset)) {
          if (( $password_reset->last_reset + (10 * 60)) > time()) {
            echo json_encode(["error" => true, "errorText" => "A request to reset your password has already been made. Please try again in about 10 minutes."]);
            exit;
          }
        }

        $random_token = random_bytes(64);
        $random_token = password_hash($random_token, PASSWORD_DEFAULT);
        $expire_time = time() + (15 * 60);
        $password_reset_db = json_encode(["random_token" => $random_token, "expire_time" => $expire_time, "last_reset" => time()]);
        $conn = connect_local_or_server();
        $success = set_password_reset($conn, $id, $password_reset_db);
        if (!$success) {
          echo json_encode(["error" => true, "errorText" => "Failed to set reset-token."]);
          exit;
        }

        $subject = "Reset password | individumeal.com";
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: noreply@individumeal.com\r\n";
        $message = ' 
      <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
      
        <title>Reset password</title>
      </head>
      
      <body>
        <div class="background_image" style="background-image: url(https://individumeal.com/shared/img/background.jpg); filter: blur(8px); -webkit-filter: blur(8px);
        height: 100%; background-position: center; background-repeat: no-repeat; background-size: cover;"></div>
        <main class="reset_password_form"
          style="display: flex; justify-content: center; align-items: center; text-align: center;">
          <form action="http://localhost/IT-Projekt/reset_password/set_new_password.php?token=' . $random_token . '&id=' . $id . '" style="background-color: rgb(0, 0, 0); background-color: rgba(152, 149, 158, 0.25); 
          color: white; font-weight: bold; border-radius: 5px;position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2; padding: 15px; 
          margin: auto; text-align: center;">
            <h1>Forgot your password?</h1>
            <div class="reset_password_content">
              <p>Just click the button below to reset it.</p>
              <br>
              <button type="submit">
                Reset password
              </button>
            </div>
            <p style="color: grey;">&copy; 2021 individumeal.com</p>
          </form>
        </main>
      </body>
      
      </html>';
        $success = mail($email, $subject, $message, $headers);
        if ($success == $email) {
          echo json_encode(["error" => false, "errorText" => ""]);
          exit;
        } else {
          echo json_encode(["error" => true, "errorText" => "Failed to send email."]);
          exit;
        }
      }
    case "reset_password":
      $password = $reqObj->password;
      $password = password_hash($password, PASSWORD_DEFAULT);

      $password_reset_db = get_password_reset($conn, $reqObj->id);
      $password_reset_dbObj = json_decode($password_reset_db["PasswordReset"]);
      if ($password_reset_dbObj == null) {
        echo json_encode(["error" => true, "errorText" => "Unable to load reset token/expiry time."]);
        exit;
      }
      $token_db = $password_reset_dbObj->random_token;
      $timestamp_db = $password_reset_dbObj->expire_time;

      if ($token_db != $reqObj->token) {
        echo json_encode(["error" => true, "errorText" => "Reset token did not match."]);
        exit;
      } else if ($timestamp_db < time()) {
        echo json_encode(["error" => true, "errorText" => "The reset token was expired."]);
        exit;
      } else {
        $success = reset_password($conn, $reqObj->id, $password);
        clear_password_reset($conn, $reqObj->id);
        if (!$success) {
          echo json_encode(["error" => true, "errorText" => "Failed to reset password."]);
        }
        echo json_encode(["error" => false, "errorText" => ""]);
      }
      break;
  }
}
