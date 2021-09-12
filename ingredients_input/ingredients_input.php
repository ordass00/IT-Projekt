<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
    <link rel="stylesheet" href="ingredients_input.css" />
    <link rel="stylesheet" href="../shared/css/shared_toasts.css"/>
    <link rel="stylesheet" href="../shared/css/shared_background.css"/>
    <link rel="stylesheet" href="../shared/css/shared_form.css"/>
    <link rel="stylesheet" href="../shared/css/shared_nav.css"/>

    <title>Ingredients</title>

    <script type="module">
        import {
            validateAndSaveIngredients
        } from "./validate_input.js";
        import {
            showToastErrorMessage
        } from "../shared/js/shared_functions.js";
        window.validateAndSaveIngredients = validateAndSaveIngredients;
        window.showToastErrorMessage = showToastErrorMessage;
    </script>
</head>

<body>
    <div class="background_image_blur"></div>
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent d-flex">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="../index/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../imprint/imprint.html">Support & Imprint</a>
                    </li>
                </ul>
                <!-- Hier Logout -->
                <form class="form-inline my-2 my-lg-0 mr-sm-2" action="">
                    <button class="btn btn-primary" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </nav>
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
    <main class="form">
        <form  method="post" id="ingredients_form">
            <h1 class="m-2">Ingredients</h1>
            <p class="m-2">Tell us, which ingredients you have at home.</p>
            <textarea form="ingredients_form" required name="ingredients" id="ingredients_input" class="form-group rounded" style="resize: none;" cols="30" rows="10" placeholder="ham, cheese, eggs"></textarea>
            <div class="d-flex justify-content-center" style="clear: right">
                <input class="btn btn-lg btn-primary m-2" type="button" onclick="validateAndSaveIngredients(<?php echo $_SESSION['userid']; ?>)"
                    value="Submit"/>
            </div>

            <p class="m-3" style="color: grey">&copy; 2021 individumeal.com</p>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>