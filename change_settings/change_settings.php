<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="change_settings.css" />
    <link rel="stylesheet" href="../shared/css/shared_toasts.css" />
    <link rel="stylesheet" href="../shared/css/shared_pwd_hide_eye.css" />
    <link rel="stylesheet" href="../save_preferences/save_preferences.css" />
    <link rel="stylesheet" href="../shared/css/shared_nav.css" />

    <script type="module">
        import {changeAccountSettings, changePassword, changePreferences, changeIngredients, pwdValidation} from "./change_settings.js";
        import {showHidePassword} from "../shared/js/shared_functions.js";
        import {validateInput} from "../ingredients_input/validate_input.js";
        window.changeAccountSettings = changeAccountSettings;
        window.changePassword = changePassword;
        window.changePreferences = changePreferences;
        window.changeIngredients = changeIngredients;
        window.pwdValidation = pwdValidation;
        window.showHidePassword = showHidePassword;
        window.validateInput = validateInput;
    </script>

    <title>Account Settings</title>
</head>
<body>
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
                    <li class="nav-item">
                        <a class="nav-link" href="../meal_plan_overview/meal_plan_overview.php">Meal Plan Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../imprint/imprint.html">Support & Imprint</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0 mr-sm-2" action="../shared/logout.php">
                    <button class="btn btn-primary" name="logout" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-4 d-none d-md-block sidebar">
                <div class="card">
                    <div class="card-header">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-item nav-link active" id="v-pills-general-tab" data-bs-toggle="pill" data-bs-target="#v-pills-general" type="button" role="tab" aria-controls="v-pills-general" aria-selected="true"><i class="bi bi-person-circle"></i> General Information</button>
                            <button class="nav-link" id="v-pills-password-tab" data-bs-toggle="pill" data-bs-target="#v-pills-password" type="button" role="tab" aria-controls="v-pills-password" aria-selected="false"><i class="bi bi-key"></i> Change Password</button>
                            <button class="nav-link" id="v-pills-preferences-tab" data-bs-toggle="pill" data-bs-target="#v-pills-preferences" type="button" role="tab" aria-controls="v-pills-preferences" aria-selected="false"><i class="bi bi-sliders"></i> Change Preferences</button>
                            <button class="nav-link " id="v-pills-ingredients-tab" data-bs-toggle="pill" data-bs-target="#v-pills-ingredients" type="button" role="tab" aria-controls="v-pills-ingredients" aria-selected="false"><i class="bi bi-card-text"></i> Change Ingredients</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel" aria-labelledby="v-pills-general-tab">
                            <div aria-live="polite" aria-atomic="true" class="toasts-center">
                                <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="successfully_changed_personal_information_toast">
                                    <div class="d-flex alert-success rounded">
                                        <div class="toast-body">
                                            <b>Success!</b> Your personal information has been successfully updated!
                                        </div>
                                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                            <div aria-live="polite" aria-atomic="true" class="toasts-center">
                                <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="error_toast">
                                    <div class="d-flex alert-danger rounded">
                                        <div class="toast-body">
                                            <b>Something went wrong! </b><span id="error_text"></span>
                                        </div>
                                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                            <h6>PERSONAL INFORMATION</h6>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="post">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h6 class="mb">First name</h6>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input id="first_name" type="text" class="form-control" value="<?php echo $_SESSION["firstname"] ?>" readonly=True>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h6 class="mb">Last <br>name</h6>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input id="last_name" type="text" class="form-control" value="<?php echo $_SESSION["lastname"] ?>" readonly=True>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h6 class="mb">User name</h6>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input id="username" type="text" class="form-control" value="<?php echo $_SESSION["username"] ?>" autocomplete="off" readonly=True>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h6 class="mb">Email</h6>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input id="email" type="text" class="form-control" value="<?php echo $_SESSION["email"] ?>" readonly=True>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <h6 class="mb">Birth <br>day</h6>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input id="user_id" value="<?php echo $_SESSION["userid"] ?>" type="hidden">
                                                        <input id="date_of_birth" type="date" class="form-control" value="<?php echo $_SESSION["dateofbirth"] ?>" name="date_of_birth" readonly=True>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="post">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <h6 class="mb">First name</h6>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input id="first_name_input" type="text" class="form-control" placeholder="Firstname" name="firstname" autocomplete="given-name" required minlength="2" maxlength="10">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <h6 class="mb">Last <br>name</h6>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input id="last_name_input" type="text" class="form-control" placeholder="Lastname" name="lastname" autocomplete="family-name" required minlength="2" maxlength="10">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <h6 class="mb">User name</h6>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input id="username_input" type="text" class="form-control" placeholder="Username" name="username" required minlength="3" maxlength="45">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <h6 class="mb">Email</h6>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="email" class="form-control" placeholder="name@example.com" id="email_input" required autocomplete="email" maxlength="45"/>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <h6 class="mb">Birth <br>day</h6>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input id="date_of_birth_input" type="date" class="form-control" placeholder="Date of birth" name="date_of_birth" autocomplete="bday" required min="1921-01-01" step="1" max="2008-01-01">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col"></div>
                                <div class="col">
                                    <div class="d-flex justify-content-center m-3">
                                        <button class="btn btn-primary btn-cursor" type="submit" onclick="changeAccountSettings()">Save Changes</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab">
                            <div aria-live="polite" aria-atomic="true" class="toasts-center">
                                <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="successfully_changed_password_toast">
                                    <div class="d-flex alert-success rounded">
                                        <div class="toast-body">
                                            <b>Success!</b> Your password has been successfully changed!
                                        </div>
                                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                            <div aria-live="polite" aria-atomic="true" class="toasts-center">
                                <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="error_toast_password">
                                    <div class="d-flex alert-danger rounded">
                                        <div class="toast-body">
                                            <b>Something went wrong! </b><span id="error_text_password"></span>
                                        </div>
                                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                            <h6>CHANGE PASSWORD</h6>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="post" onsubmit="return pwdValidation();">
                                                <div class="container">
                                                    <input type="password" class="form-control" name="new_password" placeholder="New password"
                                                           id="new_password_input" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                                                    <span class="show-hide-pwd-eye" onclick="showHidePassword('new_password_input');">
                                                         <img src="../shared/img/eye.svg" alt="Eye to show/hide password">
                                                     </span>
                                                    <div class="row pwd-validation">
                                                        <div class="col-sm-6 mt-1">
                                                            <span id="min_eight_chars" class="bi bi-x-lg" style="color: red;"></span> 8 characters long<br>
                                                            <span id="upper_case" class="bi bi-x-lg" style="color: red;"></span> One uppercase letter<br>
                                                        </div>
                                                        <div class="col-sm-6 mt-1">
                                                            <span id="lower_case" class="bi bi-x-lg" style="color: red;"></span> One lowercase letter<br>
                                                            <span id="one_number" class="bi bi-x-lg" style="color: red;"></span> One number<br>
                                                        </div>
                                                    </div>
                                                    <input type="password" class="form-control mt-2" name="repeat_password" placeholder="Repeat password"
                                                           id="repeat_new_password_input">
                                                    <span class="show-hide-pwd-eye" onclick="showHidePassword('repeat_new_password_input');">
                                                        <img src="../shared/img/eye.svg" alt="Eye to show/hide password">
                                                    </span>
                                                    <div class="row pwd-validation">
                                                        <div class="col-sm-12 mt-1">
                                                            <span id="password_match" class="bi bi-x-lg" style="color: red;"></span> Passwords match<br>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <button class="w-100 btn btn-lg btn-primary" type="submit" onclick="changePassword()">Change password</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="v-pills-preferences" role="tabpanel" aria-labelledby="v-pills-preferences-tab">
                            <div aria-live="polite" aria-atomic="true" class="toasts-center">
                                <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="successfully_changed_preferences_toast">
                                    <div class="d-flex alert-success rounded">
                                        <div class="toast-body">
                                            <b>Success!</b> Your preferences have been successfully updated!
                                        </div>
                                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                            <div aria-live="polite" aria-atomic="true" class="toasts-center">
                                <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="error_toast_preferences">
                                    <div class="d-flex alert-danger rounded">
                                        <div class="toast-body">
                                            <b>Something went wrong! </b><span id="error_text_preferences"></span>
                                        </div>
                                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                            <h6>CHANGE PREFERENCES</h6>
                            <hr>
                            <div class="row">
                                <div class="column">
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="post">
                                                <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label">Diet type</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-select" name="state" id="diet_type">
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
                                                    <button type="submit" class="btn btn-primary btn-cursor" onclick="changePreferences()">Confirm</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-ingredients" role="tabpanel" aria-labelledby="v-pills-ingredients-tab">
                            <div aria-live="polite" aria-atomic="true" class="toasts-center">
                                <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="wrong_ingredient_format_toast">
                                    <div class="d-flex alert-danger rounded">
                                        <div class="toast-body">
                                            <b>Something went wrong! </b> Please only use letters and commas for your ingredients list.
                                        </div>
                                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                            <div aria-live="polite" aria-atomic="true" class="toasts-center">
                                <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="error_toast_ingredients">
                                    <div class="d-flex alert-danger rounded">
                                        <div class="toast-body">
                                            <b>Something went wrong! </b><span id="error_text_ingredients"></span>
                                        </div>
                                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                            <div aria-live="polite" aria-atomic="true" class="toasts-center">
                                <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" id="successfully_changed_ingredients_toast">
                                    <div class="d-flex alert-success rounded">
                                        <div class="toast-body">
                                            <b>Success!</b> Your ingredients have been successfully changed!
                                        </div>
                                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                            <h6>CHANGE INGREDIENTS</h6>
                            <hr>
                            <div class="row">
                                <div class="column">
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="post" onsubmit="return validateInput();" id="ingredients_form">
                                                <div class="row mb-3">
                                                    <div class="col-sm-5">
                                                        <p class="m-2">Ingredients you have at home.</p>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <textarea form="ingredients_form" required name="ingredients" id="ingredients_input" class="form-group rounded" style="resize: none;" cols="40" rows="10" placeholder="ham, cheese, eggs"></textarea>
                                                    </div>
                                                </div>
                                                <div class="mb-3 d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-primary btn-cursor" onclick="changeIngredients()">Confirm</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="../save_preferences/save_preferences.js"></script>
</body>
</html>

