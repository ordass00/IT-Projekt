import { showToastErrorMessage, showToastMessage } from "../shared/js/shared_functions.js";

export function changeAccountSettings() {
    let firstname = document.getElementById("first_name_input").value;
    let lastname = document.getElementById("last_name_input").value;
    let username = document.getElementById("username_input").value;
    let email = document.getElementById("email_input").value;
    let dateOfBirth = document.getElementById("date_of_birth_input").value;
    let userid = document.getElementById("user_id").value;
    changeUserInformation(firstname, lastname, username, email, dateOfBirth, userid);
}

function updateDisplayedAccountSettings(data){
    let firstname_input =  data["firstname"];
    let lastname_input =  data["lastname"];
    let username_input =  data["username"];
    let email_input =  data["email"];
    let dateofbirth_input = data["dateofbirth"]
    document.getElementById("username").setAttribute("value", username_input);
    document.getElementById("first_name").setAttribute("value", firstname_input);
    document.getElementById("last_name").setAttribute("value", lastname_input);
    document.getElementById("email").setAttribute("value", email_input);
    document.getElementById("date_of_birth").setAttribute("value", dateofbirth_input);
}

function changeUserInformation(firstname, lastname, username, email, dateOfBirth, userid) {
    let reqObj = {
        method: "change_user_information",
        firstname: firstname,
        lastname: lastname,
        username: username,
        email: email,
        dateOfBirth: dateOfBirth,
        userid: userid,
    };
    fetch("change_settings_functionality.php", {
        method: "POST",
        body: JSON.stringify(reqObj),
    })
        .then(function (response) {
            if (response.ok) {
                return response.json();
            }
            throw new Error("Error in response. (change_user_information)");
        })
        .then(function (data) {
            if (data.error) {
                showToastErrorMessage("error_toast", "error_text", data.errorText);
            } else {
                data = data["account_information"];
                updateDisplayedAccountSettings(data);
                showToastMessage("successfully_changed_personal_information_toast");
            }
        })["catch"](function (error) {
        showToastErrorMessage("error_toast", "error_text", error.errorText);
    });
}

export function changePassword() {
    let password = document.getElementById("new_password_input").value;
    let password_repeat = document.getElementById("repeat_new_password_input").value;
    let userid = document.getElementById("user_id").value;

    let reqObj = {
        method: "change_password",
        password: password,
        password_repeat: password_repeat,
        userid: userid,
    };
    fetch("change_settings_functionality.php", {
        method: "POST",
        body: JSON.stringify(reqObj),
    })
        .then(function (response) {
            if (response.ok) {
                return response.json();
            }
            throw new Error("Error in response. (change_password)");
        })
        .then(function (data) {
            if (data.error) {
                showToastErrorMessage("error_toast_password", "error_text_password", data.errorText);
            } else {
                showToastMessage("successfully_changed_password_toast");
            }
        })["catch"](function (error) {
        showToastErrorMessage("error_toast_password", "error_text_password", error.errorText);
    });
}

export function changePreferences() {
    let dietType = document.getElementById("diet_type").value;
    let intolerancesCheckbox = document.getElementsByName("intolerances[]");
    let intolerances = [];
    for (var i=0; i<intolerancesCheckbox.length; i++){
        if (intolerancesCheckbox[i].checked){
            intolerances.push(intolerancesCheckbox[i].value);
        }
    }
    let calories = document.getElementById("calories").value;
    let userid = document.getElementById("user_id").value;

    let reqObj = {
        method: "change_preferences",
        dietType: dietType,
        intolerances: intolerances,
        calories: calories,
        userid: userid,
    };
    fetch("change_settings_functionality.php", {
        method: "POST",
        body: JSON.stringify(reqObj),
    })
        .then(function (response) {
            if (response.ok) {
                return response.json();
            }
            throw new Error("Error in response. (change_preferences)");
        })
        .then(function (data) {
            if (data.error) {
                showToastErrorMessage("error_toast_preferences", "error_text_preferences", data.errorText);
            } else {
                showToastMessage("successfully_changed_preferences_toast");
            }
        })["catch"](function (error) {
        showToastErrorMessage("error_toast_preferences", "error_text_preferences", error.errorText);
    });
}

export function changeIngredients() {
    let ingredients = document.getElementById("ingredients_input").value;
    let userid = document.getElementById("user_id").value;

    let reqObj = {
        method: "change_ingredients",
        ingredients: ingredients,
        userid: userid,
    };
    fetch("change_settings_functionality.php", {
        method: "POST",
        body: JSON.stringify(reqObj),
    })
        .then(function (response) {
            if (response.ok) {
                return response.json();
            }
            throw new Error("Error in response. (change_preferences)");
        })
        .then(function (data) {
            if (data.error) {
                showToastErrorMessage("error_toast_ingredients", "error_text_ingredients", data.errorText);
            } else {
                showToastMessage("successfully_changed_ingredients_toast");
            }
        })["catch"](function (error) {
        showToastErrorMessage("error_toast_ingredients", "error_text_ingredients", error.errorText);
    });
}

let pwd_input = document.getElementById("new_password_input");
let repeat_pwd_input = document.getElementById("repeat_new_password_input");
let lower_case_letters_error_msg = document.getElementById("lower_case");
let upper_case_letters_error_msg = document.getElementById("upper_case");
let numbers_error_msg = document.getElementById("one_number");
let min_eight_chars_error_msg = document.getElementById("min_eight_chars");
let pwd_match_error_msg = document.getElementById("password_match");

export function pwdValidation() {
    if (repeat_pwd_input.value.length == 0 || pwd_input.value.length == 0){
        return false;
    }
    return repeat_pwd_input.value == pwd_input.value;
}

pwd_input.onfocus = function() {
    document.getElementsByClassName("pwd-validation")[0].style.display = "flex";
}

repeat_pwd_input.onfocus = function() {
    document.getElementsByClassName("pwd-validation")[1].style.display = "flex";
}

pwd_input.onblur = function() {
    document.getElementsByClassName("pwd-validation")[0].style.display = "none";
}

repeat_pwd_input.onblur = function() {
    document.getElementsByClassName("pwd-validation")[1].style.display = "none";
}

pwd_input.onkeyup = function() {
    let lower_case_letters = /[a-z]/g;
    let upper_case_letters = /[A-Z]/g;
    let numbers = /[0-9]/g;

    if (pwd_input.value.match(lower_case_letters)){
        lower_case_letters_error_msg.classList.remove("bi-x-lg");
        lower_case_letters_error_msg.classList.add("bi-check-lg");
        lower_case_letters_error_msg.style["color"] = "green";
    } else {
        lower_case_letters_error_msg.classList.remove("bi-check-lg");
        lower_case_letters_error_msg.classList.add("bi-x-lg");
        lower_case_letters_error_msg.style["color"] = "red";
    }

    if (pwd_input.value.match(upper_case_letters)){
        upper_case_letters_error_msg.classList.remove("bi-x-lg");
        upper_case_letters_error_msg.classList.add("bi-check-lg");
        upper_case_letters_error_msg.style["color"] = "green";
    } else {
        upper_case_letters_error_msg.classList.remove("bi-check-lg");
        upper_case_letters_error_msg.classList.add("bi-x-lg");
        upper_case_letters_error_msg.style["color"] = "red";
    }

    if (pwd_input.value.match(numbers)){
        numbers_error_msg.classList.remove("bi-x-lg");
        numbers_error_msg.classList.add("bi-check-lg");
        numbers_error_msg.style["color"] = "green";
    } else {
        numbers_error_msg.classList.remove("bi-check-lg");
        numbers_error_msg.classList.add("bi-x-lg");
        numbers_error_msg.style["color"] = "red";
    }

    if (pwd_input.value.length >= 8){
        min_eight_chars_error_msg.classList.remove("bi-x-lg");
        min_eight_chars_error_msg.classList.add("bi-check-lg");
        min_eight_chars_error_msg.style["color"] = "green";
    } else {
        min_eight_chars_error_msg.classList.remove("bi-check-lg");
        min_eight_chars_error_msg.classList.add("bi-x-lg");
        min_eight_chars_error_msg.style["color"] = "red";
    }

    if (pwd_input.value != repeat_pwd_input.value){
        pwd_match_error_msg.classList.remove("bi-check-lg");
        pwd_match_error_msg.classList.add("bi-x-lg");
        pwd_match_error_msg.style["color"] = "red";
    } else {
        pwd_match_error_msg.classList.remove("bi-x-lg");
        pwd_match_error_msg.classList.add("bi-check-lg");
        pwd_match_error_msg.style["color"] = "green";
    }
}

repeat_pwd_input.onkeyup = function() {
    if (repeat_pwd_input.value != pwd_input.value) {
        pwd_match_error_msg.classList.remove("bi-check-lg");
        pwd_match_error_msg.classList.add("bi-x-lg");
        pwd_match_error_msg.style["color"] = "red";
    } else {
        pwd_match_error_msg.classList.remove("bi-x-lg");
        pwd_match_error_msg.classList.add("bi-check-lg");
        pwd_match_error_msg.style["color"] = "green";
    }
}