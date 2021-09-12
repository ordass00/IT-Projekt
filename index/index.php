<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous" />
  <link rel="stylesheet" href="index.css" />
  <link rel="stylesheet" href="../shared/css/shared_nav.css" />
  <link rel="stylesheet" href="../shared/css/shared_toasts.css" />

  <script type="module">
    import {
      successfullyLoggedOutToast
    } from "./index.js";
    window.successfullyLoggedOutToast = successfullyLoggedOutToast;
  </script>

  <title>Welcome to IndividuMeal</title>
</head>

<body onload="successfullyLoggedOutToast();">
  <nav class="navbar navbar-expand-lg navbar-light bg-transparent d-flex">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" href="../index/index.php">Home</a>
          </li>
            <?php
            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
                echo '<li class="nav-item"><a class="nav-link" href="../change_settings/change_settings.php">Change Settings</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="../meal_plan_overview/meal_plan_overview.php">Meal Plan Overview</a></li>';
            }
            ?>
          <li class="nav-item">
            <a class="nav-link" href="../imprint/imprint.html">Support & Imprint</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0 mr-sm-2" action="../login/login_form.php">
          <button class="btn btn-primary" type="submit">Login</button>
        </form>
      </div>
    </div>
  </nav>

  <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center m-2 toasts">
    <div class="toast-container d-flex justify-content-center align-items-center m-2 toasts">
      <div class="toast rounded" role="alert" aria-live="assertive" aria-atomic="true"
        id="successfully_logged_out_toast">
        <div class="d-flex alert-success rounded">
          <div class="toast-body">
            <b>Success!</b> You have been successfully logged out.
          </div>
          <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>
  </div>

  <main class="d-flex align-items-center justify-content-center">
    <div>
      <div class="d-flex align-items-center justify-content-center">
        <p>
          <b>Create your individual meal plan based on your preferences and
            the ingredients you have at home.</b>
        </p>
      </div>
      <div class="d-flex align-items-center justify-content-center">
        <form style="display: inline" action="../register_personal_details/register_personal_details.html">
          <button type="submit" class="btn btn-primary btn-lg row mt-3">
            Get Started
          </button>
        </form>
      </div>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
    crossorigin="anonymous"></script>
</body>

</html>