<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
    <link rel="stylesheet" href="reset_password.css" />
    <link rel="stylesheet" href="../shared/css/shared_background.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../shared/css/shared_pwd_hide_eye.css" />
    <link rel="stylesheet" href="../shared/css/shared_toasts.css">
    <link rel="stylesheet" href="../shared/css/shared_form.css">
    <link rel="stylesheet" href="../shared/css/shared_pwd_validation.css">

    <title>Reset password</title>

    <script type="module">
        import {
            set_new_password
        } from "./reset_password.js";
        import {
            showToastErrorMessage,
            showHidePassword, show_password_validation, hide_password_validation, validate_password, validate_password_repeat
        } from "../shared/js/shared_functions.js";
        window.showToastErrorMessage = showToastErrorMessage;
        window.showToastErrorMessage = showToastErrorMessage;
        window.set_new_password = set_new_password;
        window.showHidePassword = showHidePassword;
        window.show_password_validation = show_password_validation;
        window.hide_password_validation = hide_password_validation;
        window.validate_password = validate_password;
        window.validate_password_repeat = validate_password_repeat;
    </script>
</head>

<body>
    <?php
    error_reporting(0);
    ini_set('display_errors', 0); 
    $token = $_GET["token"];
    $id = $_GET["id"];
    echo "<span hidden id='u_id'>".$id."</span>";
    echo "<span hidden id='token'>".$token."</span>";
    ?>
    <div class="background_image_blur"></div>
    <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center m-2 toasts">
        <div class="toast-container">
            <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="error_toast">
                <div class="d-flex alert-danger rounded">
                    <div class="toast-body">
                        <b>Something went wrong! </b><span id="error_text"></span>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="password_reset_toast">
                <div class="d-flex alert-success rounded">
                    <div class="toast-body">
                        <b>Success! </b> Instructions on how to reset your password were sent to the specified address.
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    <main class="form">
        <form onsubmit="return set_new_password();">
            <h1 class="h3 mb-3 fw-normal">Set a new password.</h1>
            <div class="reset_password_content">
                <p class="m-3">You can now set your new password.</p>
                    <input type="password" class="form-control" placeholder="New password"  id="new_password_input" required autocomplete="new-password"
                           onfocus="show_password_validation('password_input_field')" onblur="hide_password_validation('password_input_field')"
                           onkeyup="validate_password('new_password_input')"/>
                    <span class="show-hide-pwd-eye" onclick="showHidePassword('new_password_input');">
                        <img src="../shared/img/eye.svg" alt="Eye to show/hide password">
                    </span>
                    <div class="row pwd-validation mt-1 mb-2">
                    <div class="col-sm-6 mt-1">
                        <span id="min_eight_chars" class="bi bi-x-lg" style="color: red;"></span> 8 characters long<br>
                        <span id="upper_case" class="bi bi-x-lg" style="color: red;"></span> 1 uppercase letter<br>
                    </div>
                    <div class="col-sm-6 mt-1 mb-2">
                        <span id="lower_case" class="bi bi-x-lg" style="color: red;"></span> 1 lowercase letter<br>
                        <span id="one_number" class="bi bi-x-lg" style="color: red;"></span> 1 number<br>
                    </div>
                    </div>
                    <input type="password" class="form-control" placeholder="Repeat password" id="repeat_new_password_input" required autocomplete="new-password"
                           onfocus="show_password_validation('repeat_password_input_field')" onblur="hide_password_validation('repeat_password_input_field')"
                           onkeyup="validate_password_repeat('new_password_input','repeat_new_password_input')"/>
                    <span class="show-hide-pwd-eye" onclick="showHidePassword('repeat_new_password_input');">
                        <img src="../shared/img/eye.svg" alt="Eye to show/hide password">
                    </span>
                    <div class="row pwd-validation mt-1">
                        <div class="col-sm-12 mt-1">
                        <span id="password_match" class="bi bi-x-lg" style="color: red;"></span> Passwords match<br>
                        </div>
                    </div>
                <div class="d-flex justify-content-center m-3">
                    <button class="btn btn-lg btn-primary m-2" type="submit">
                        Reset password
                    </button>
                </div>
            </div>
            <p class="m-3" style="color: grey">&copy; 2021 individumeal.com</p>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>