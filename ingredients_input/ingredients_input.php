<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
    <link rel="stylesheet" href="ingredients_input.css" />

    <title>Ingredients</title>

    <script type="module">
        import {
            validateInput
        } from "./validate_input.js";
        import {
            showToastErrorMessage
        } from "../shared/js/shared_functions.js";
        window.validateInput = validateInput;
        window.showToastErrorMessage = showToastErrorMessage;
    </script>
</head>

<body>
    <?php
    include_once "../shared/php/database.php";
    error_reporting(0);
    session_start();
    //Empty check für Session
    if (isset($_POST["ingredients"]) && !empty($_POST["ingredients"])) {
        $success = set_ingredients(connect_local(), $_POST["ingredients"], $_SESSION["userid"]);
        if ($success === 0) {
            echo "<script>showToastErrorMessage('error_toast', 'error_text', ' Not able to set user ingredients.');</script>";
        } else {
            //TODO Umleiten
        }
    }
    ?>
    <div class="ingredients_image"></div>
    <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center m-2 toasts">
        <div class="toast-container">
            <div class="toast rounded" role="alert" aria-live="assertive" aria-atomic="true" id="wrong_ingredient_format_toast">
                <div class="d-flex alert-warning rounded">
                    <div class="toast-body">
                        <b>Something went wrong!</b> Please only use letters and commas for your ingredients list.
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="error_toast">
                <div class="d-flex alert-danger rounded">
                    <div class="toast-body">
                        <b>Something went wrong! </b><span id="error_text"></span>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </div>
    <main class="ingredients_form">
        <form onsubmit="return validateInput();" method="post" id="ingredients_form" action="ingredients_input.php">
            <h1 class="h3 mb-3 fw-normal">Ingredients</h1>
            <p class="m-2">Tell us, which ingredients you have at home.</p>
            <textarea form="ingredients_form" required name="ingredients" id="ingredients_input" class="form-group rounded" style="resize: none;" cols="30" rows="10" placeholder="ham, cheese, eggs"></textarea>
            <div class="d-flex justify-content-center" style="clear: right">
                <button class="btn btn-lg btn-primary m-2" type="submit">
                    Submit
                </button>
            </div>

            <p class="m-3" style="color: grey">&copy; 2021 individumeal.com</p>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>