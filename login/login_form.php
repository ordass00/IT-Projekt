<?php
require_once("login_functionality.php");
try_to_login();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
         integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="login.css">
    <script type="module">
        import {successfullyRegisteredToast, successfullyResetedToast} from "./login.js";
        import {showHidePassword} from "../shared/js/shared_functions.js";
        window.successfullyRegisteredToast = successfullyRegisteredToast;
        window.successfullyResetedToast = successfullyResetedToast;
        window.showHidePassword = showHidePassword;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <title>Login</title>
</head>

<body onload="successfullyRegisteredToast();">
    <div class="login-image"></div>
    <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center m-2 toasts">
        <div class="toast-container">
            <div class="toast rounded" role="alert" aria-live="assertive" aria-atomic="true" id="successfully_registered_toast">
                <div class="d-flex alert-success rounded">
                    <div class="toast-body">
                        <b>Success!</b> You have been successfully registered.
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>

            <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="error_toast">
                <div class="d-flex alert-danger rounded">
                    <div class="toast-body">
                        <b>Something went wrong!</b><br><span id="error_text"></span>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            
            <div class="toast rounded" role="alert" aria-live="assertive" aria-atomic="true" id="successfully_reseted_password_toast">
                <div class="d-flex alert-success rounded">
                    <div class="toast-body">
                        <b>Success!</b> Your password has been successfully reseted!
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>

    <main class="login-form">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <h1 class="h3 mb-3 fw-normal">Please log in</h1>
            <input type="email" class="form-control mb-3" name="email" placeholder="name@example.com" autocomplete="email" required>
            <input type="password" class="form-control" name="password" placeholder="Password" id="password_input" autocomplete="current-password" required>
            <span class="show-hide-pwd-eye" onclick="showHidePassword()">
                <img src="../shared/img/eye.svg" alt="Eye to show/hide password">
            </span>
            <div class="checkbox mb-3 align-center">
                <input type="checkbox" value="remember-me"> Remember me
            </div>
            <div class="mb-3">
                <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
            </div>
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-column">
                    <label>Don't have an account?</label>
                    <a href="../register_personal_details/register_personal_details.html">Sign up</a>
                </div>
                <a href="../reset_password/reset_password.html">Forgot your password?</a>
            </div>
            <p class="mt-3 mb-3 text-muted">&copy; 2021 individumeal.com</p>
        </form>
        <?php
        if (!empty($_POST['login_err'])) {
            $login_err = $_POST['login_err'];
            echo "<script type='module'>
                    import {showToastErrorMessage} from '../shared/js/shared_functions.js';
                    window.showToastErrorMessage = showToastErrorMessage;
                    showToastErrorMessage('error_toast','error_text','$login_err');
                 </script>";
        }
        ?>
    </main>
</body>

</html>