<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
    <link rel="stylesheet" href="reset_password.css" />
    <link rel="stylesheet" href="../shared/css/shared_background.css">
    <link rel="stylesheet" href="../shared/css/shared_toasts.css">
    <link rel="stylesheet" href="../shared/css/shared_form.css">

    <title>Reset password</title>

    <script type="module">
        import {
            set_new_password
        } from "./reset_password.js";
        import {
            showToastErrorMessage
        } from "../shared/js/shared_functions.js";
        window.showToastErrorMessage = showToastErrorMessage;
        window.showToastErrorMessage = showToastErrorMessage;
        window.set_new_password = set_new_password;
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
    <div class="background_image"></div>
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
                <div class="d-flex justify-content-center mb-3">
                    <input type="password" class="form-control w-75" placeholder="New password"  id="new_password" required autocomplete="new-password" minlength="8" />
                </div>
                <div class="d-flex justify-content-center">
                    <input type="password" class="form-control w-75" placeholder="Repeat password" id="new_password_check" required autocomplete="new-password" minlength="8" />
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