<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <link rel="stylesheet" href="save_preferences.css">

  <title>Save preferences</title>
</head>

<body>
  <?php
  error_reporting(0);
  if ($_GET["duplicate"] == "true") {
    echo "<script type='module'>
            import {showToastErrorMessage} from '../shared/js/shared_functions.js';
            window.showToastErrorMessage = showToastErrorMessage;
            showToastErrorMessage('error_toast','error_text','You have already set your preferences!');
          </script>";
  }
  ?>
  <div class="login-image"></div>
  <nav class="navbar navbar-expand-lg navbar-light bg-transparent d-flex">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" href="../index/index.html">Home</a>
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
      <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="error_toast">
        <div class="d-flex alert-danger rounded">
          <div class="toast-body">
            <b>Something went wrong!</b><br><span id="error_text"></span>
          </div>
          <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>
  </div>
  <main class="save-preferences-form">
    <form action="save_preferences_functionality.php" method="POST" name="preferences_form">
      <h3 class="h3 mb-3 fw-normal text-center">Select your preferences</h3>
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Diet type</label>
        <div class="col-sm-9">
          <select class="form-select" name="state">
            <option value="Omnivore">Omnivore (everything)</option>
            <option value="Vegetarian">Vegetarian</option>
            <option value="Vegan">Vegan</option>
          </select>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-sm-3">
          <label>Intolerances</label>
        </div>
        <div class="col-3">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="intolerances[]" value="dairy">
            <label class="form-check-label">Dairy</label>
          </div>
        </div>
        <div class="col-3">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="intolerances[]" value="gluten">
            <label class="form-check-label">Gluten</label>
          </div>
        </div>
        <div class="col-3">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="intolerances[]" value="grain">
            <label class="form-check-label">Grain</label>
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-3 offset-md-3">
          <div class="form-check form-switch col">
            <input class="form-check-input" type="checkbox" name="intolerances[]" value="wheat">
            <label class="form-check-label">Wheat</label>
          </div>
        </div>
        <div class="col-3">
          <div class="form-check form-switch col">
            <input class="form-check-input" type="checkbox" name="intolerances[]" value="peanut">
            <label class="form-check-label">Peanut</label>
          </div>
        </div>
        <div class="col-3">
          <div class="form-check form-switch col">
            <input class="form-check-input" type="checkbox" name="intolerances[]" value="egg">
            <label class="form-check-label">Egg</label>
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-sm-3">
          <label>Calories</label>
        </div>
        <div class="col-sm-9">
          <div class="range-wrap">
            <input type="range" class="range" min="500" max="5000" value="2750" step="10">
            <input name="calories" id="calories" type="hidden">
            <output class="bubble"></output>
          </div>
        </div>
      </div>
      <div class="mb-3 d-flex justify-content-center">
        <button type="submit" class="btn btn-primary btn-cursor">Confirm</button>
      </div>
    </form>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  <script src="save_preferences.js"></script>
</body>

</html>