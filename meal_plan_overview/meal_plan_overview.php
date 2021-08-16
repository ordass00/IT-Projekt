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
    <link rel="stylesheet" href="meal_plan_overview.css">
    <script type="module">
        import {getRecipesByUserId} from "./get_recipes.js";
        getRecipesByUserId(<?php echo $_SESSION['userid']; ?>);
    </script>

    <title>Meal Plan Overview</title>
</head>
<body>
<div class="meal-plan-overview-image"></div>
<div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center m-2 toasts">
    <div class="toast-container">
        <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true"
             id="error_toast">
            <div class="d-flex alert-danger rounded">
                <div class="toast-body">
                    <b>Something went wrong! </b><span id="error_text"></span>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>
<main class="d-flex align-items-center justify-content-center card-design">
    <div>
        <div class="d-flex align-items-center justify-content-center">
            <h1 class="m-3" style="color:white;">Meal plan overview</h1>
        </div>
        <div class="card-group mx-5">
            <div class="card text-center d-flex">
                <h3 class="card-header">Breakfast</h3>
                <img id="breakfast_image_id" src="../shared/img/background.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h3 id="breakfast_title_id" class="card-title">Card title</h3>
                    <h6 class="mt-4">Used Ingredients:</h6>
                    <ul id="breakfast_used_ingredients_list_id" class="list-group"></ul>
                    <h6 class="mt-4">Missed Ingredients:</h6>
                    <ul id="breakfast_missed_ingredients_list_id" class="list-group"></ul>
                    <a href="#" class="btn btn-primary mt-4">Go somewhere</a>
                </div>
            </div>
            <div class="card text-center d-flex">
                <h3 class="card-header">Lunch</h3>
                <img id="lunch_image_id" src="../shared/img/background.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h3 id="lunch_title_id" class="card-title">Card title</h3>
                    <h6 class="mt-4">Used Ingredients:</h6>
                    <ul id="lunch_used_ingredients_list_id" class="list-group"></ul>
                    <h6 class="mt-4">Missed Ingredients:</h6>
                    <ul id="lunch_missed_ingredients_list_id" class="list-group"></ul>
                    <a href="#" class="btn btn-primary mt-4">Go somewhere</a>
                </div>
            </div>
            <div class="card text-center d-flex">
                <h3 class="card-header">Dinner</h3>
                <img id="dinner_image_id" src="../shared/img/background.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h3 id="dinner_title_id" class="card-title">Card title</h3>
                    <h6 class="mt-4">Used Ingredients:</h6>
                    <ul id="dinner_used_ingredients_list_id" class="list-group"></ul>
                    <h6 class="mt-4">Missed Ingredients:</h6>
                    <ul id="dinner_missed_ingredients_list_id" class="list-group"></ul>
                    <a href="#" class="btn btn-primary mt-4">Go somewhere</a>
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