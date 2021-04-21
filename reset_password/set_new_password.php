<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
    <link rel="stylesheet" href="reset_password.css" />

    <title>Set new password</title>

    <script type="module">
        import {
            showToastErrorMessage
        } from "../shared/js/shared_functions.js";
        window.showToastErrorMessage = showToastErrorMessage;
        window.request_password_reset = request_password_reset;
    </script>
</head>

<body>
    <div class="background_image"></div>
    <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center m-2 toasts">
        <div class="toast-container">
            <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true"
                id="password_reset_toast">
                <div class="d-flex alert-success rounded">
                    <div class="toast-body">
                        <b>Success! </b> Instructions on how to reset your password were sent to the specified address.
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    <main class="reset_password_form">
        <form action="set_new_password.php" method="post">
            <h1 class="h3 mb-3 fw-normal">Forgot your password?</h1>
            <p class="m-3">Don't worry, we'll send you instructions on how to reset your password.</p>
            <div class="d-flex justify-content-center">
                <input type="email" class="form-control w-75" placeholder="name@example.com" id="email_input" required
                    autocomplete="email" maxlength="45" />
            </div>
            <div class="d-flex justify-content-center m-3">
                <button class="btn btn-lg btn-primary m-2" type="submit">
                    Reset password
                </button>
            </div>

            <p class="m-3" style="color: grey">&copy; 2021 individumeal.com</p>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>
</body>

</html>