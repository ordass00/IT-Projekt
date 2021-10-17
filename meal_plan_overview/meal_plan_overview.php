<?php
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="../shared/css/shared_toasts.css"/>
    <link rel="stylesheet" href="../shared/css/shared_overlay.css"/>
    <link rel="stylesheet" href="../shared/css/shared_background2.css"/>
    <link rel="stylesheet" href="meal_plan_overview.css">
    <link rel="stylesheet" href="../shared/css/shared_nav.css" />
    <script type="module">
        import {
            getRecipesByUserId,
            changeWebsiteToTasteAndNutritionVisualization,
            incrementCurrentMealNr,
            changeWebsiteToPrintShoppingList,
            changeWebsiteToRecipeCard
        } from "./get_recipes.js";

        getRecipesByUserId(<?php echo $_SESSION['userid']; ?>);
        window.changeWebsiteToTasteAndNutritionVisualization = changeWebsiteToTasteAndNutritionVisualization;
        window.incrementCurrentMealNr = incrementCurrentMealNr;
        window.changeWebsiteToPrintShoppingList = changeWebsiteToPrintShoppingList;
        window.changeWebsiteToRecipeCard = changeWebsiteToRecipeCard;
    </script>

    <title>Meal Plan Overview</title>
</head>
<body class="background_image_normal">
<nav class="navbar navbar-expand-lg navbar-light bg-transparent d-flex">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="./meal_plan_overview.php">Meal Plan Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../change_settings/change_settings.php">Settings</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0 mr-sm-2" action="../shared/php/logout.php">
                <button id="logout_button" class="btn btn-primary" name="logout" type="submit">Logout</button>
            </form>
        </div>
    </div>
</nav>
<div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center m-2 toasts">
    <div class="toast-container">
        <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true"
             id="error_toast">
            <div class="d-flex alert-danger rounded">
                <div class="toast-body">
                    <b>Something went wrong! </b><span id="error_text" style="white-space: pre-line;"></span>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>
<div id="overlay" class="overlay">
    <div class="d-flex justify-content-center">
        <div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem; z-index: 20;">
        </div>
    </div>
</div>
<main class="d-flex align-items-center justify-content-center card-design">
    <div id="anchor" style="display:none">
        <div class="d-flex align-items-center justify-content-center">
            <h1 class="m-3">Meal Plan Overview</h1>
        </div>
        <div class="card-group">
            <div class="card text-center d-flex border-0">
                <h3 class="card-header">Breakfast</h3>
                <img id="breakfast_image_id" src="../shared/img/background.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h3 id="breakfast_title_card_id"
                        class="card-title d-flex align-items-center justify-content-center">Card title</h3>
                    <input type="button" class="btn btn-primary mt-4"
                           onclick="changeWebsiteToPrintShoppingList('breakfast')" value="Print Shopping List"/>
                    <input type="button" class="btn btn-primary mt-4"
                           onclick="changeWebsiteToTasteAndNutritionVisualization('breakfast')"
                           value="Taste And Nutrition Visualization"/>
                    <input type="button" class="btn btn-primary mt-4"
                           onclick="changeWebsiteToRecipeCard('breakfast')"
                           value="Cook Instructions"/>
                    <input type="button" class="btn btn-primary mt-4"
                           onclick="incrementCurrentMealNr(<?php echo $_SESSION['userid']; ?>, 'BreakfastNr')"
                           value="Reroll Meal"/>
                </div>
            </div>
            <div class="card text-center d-flex border-0  mx-4">
                <h3 class="card-header">Lunch</h3>
                <img id="lunch_image_id" src="../shared/img/background.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h3 id="lunch_title_card_id" class="card-title d-flex align-items-center justify-content-center">
                        Card title</h3>
                    <input type="button" class="btn btn-primary mt-4"
                           onclick="changeWebsiteToPrintShoppingList('lunch')" value="Print Shopping List"/>
                    <input type="button" class="btn btn-primary mt-4"
                           onclick="changeWebsiteToTasteAndNutritionVisualization('lunch')"
                           value="Taste And Nutrition Visualization"/>
                    <input type="button" class="btn btn-primary mt-4"
                           onclick="changeWebsiteToRecipeCard('lunch')"
                           value="Cook Instructions"/>
                    <input type="button" class="btn btn-primary mt-4"
                           onclick="incrementCurrentMealNr(<?php echo $_SESSION['userid']; ?>, 'LunchNr')"
                           value="Reroll Meal"/>
                </div>
            </div>
            <div class="card text-center d-flex border-0">
                <h3 class="card-header">Dinner</h3>
                <img id="dinner_image_id" src="../shared/img/background.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h3 id="dinner_title_card_id" class="card-title d-flex align-items-center justify-content-center">
                        Card title</h3>
                    <input type="button" class="btn btn-primary mt-4 myDivToPrint"
                           onclick="changeWebsiteToPrintShoppingList('dinner')" value="Print Shopping List"/>
                    <input type="button" class="btn btn-primary mt-4"
                           onclick="changeWebsiteToTasteAndNutritionVisualization('dinner')"
                           value="Taste And Nutrition Visualization"/>
                    <input type="button" class="btn btn-primary mt-4"
                           onclick="changeWebsiteToRecipeCard('dinner')"
                           value="Cook Instructions"/>
                    <input type="button" class="btn btn-primary mt-4"
                           onclick="incrementCurrentMealNr(<?php echo $_SESSION['userid']; ?>, 'DinnerNr')"
                           value="Reroll Meal"/>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>
</body>
</html>