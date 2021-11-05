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
function updateDisplayedAccountSettings(data) {
    let firstname_input = data["firstname"];
    let lastname_input = data["lastname"];
    let username_input = data["username"];
    let email_input = data["email"];
    let dateofbirth_input = data["dateofbirth"];
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
        }
        else {
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
        }
        else {
            showToastMessage("successfully_changed_password_toast");
        }
    })["catch"](function (error) {
        showToastErrorMessage("error_toast_password", "error_text_password", error.errorText);
    });
}
export function updateDisplayedSettingsOnLoad() {
    let userid = document.getElementById("user_id").value;
    let reqObj = {
        method: "display_settings",
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
        throw new Error("Error in response. (display_preferences)");
    })
        .then(function (data) {
        if (data.error) {
            showToastErrorMessage("error_toast_preferences", "error_text_preferences", data.errorText);
        }
        else {
            let user_information = data["user_information"];
            updateDisplayedAccountSettings(user_information);
            let preferences = data["preferences"];
            let ingredients = data["ingredients"];
            document.getElementById("ingredients_input").value = ingredients["ingredients"];
            let intolerances = preferences["intolerances"].split(", ");
            let diet_type = preferences["diet_type"];
            let calories = preferences["calories"];
            for (let i = 0; i < intolerances.length; i++) {
                if (intolerances[i] == "dairy") {
                    document.getElementById("chk_dairy")?.setAttribute("checked", "checked");
                }
                if (intolerances[i] == "gluten") {
                    document.getElementById("chk_gluten")?.setAttribute("checked", "checked");
                }
                if (intolerances[i] == "grain") {
                    document.getElementById("chk_grain")?.setAttribute("checked", "checked");
                }
                if (intolerances[i] == "wheat") {
                    document.getElementById("chk_wheat")?.setAttribute("checked", "checked");
                }
                if (intolerances[i] == "peanut") {
                    document.getElementById("chk_peanut")?.setAttribute("checked", "checked");
                }
                if (intolerances[i] == "egg") {
                    document.getElementById("chk_egg")?.setAttribute("checked", "checked");
                }
            }
            document.getElementById("diet_type").value = diet_type;
            let range = document.querySelector(".range");
            let bubble = document.querySelector(".bubble");
            const val = calories;
            const min = range.min ? range.min : 0;
            const max = range.max ? range.max : 100;
            const sliderRange = Number(((val - min) * 100) / (max - min));
            bubble.innerHTML = val;
            document.getElementById("calories").value = val;
            bubble.style.left = `calc(${sliderRange}% + (${8 - sliderRange * 0.15}px))`;
            document.getElementById("input_calories_range").value = calories;
        }
    })["catch"](function (error) {
        showToastErrorMessage("error_toast_preferences", "error_text_preferences", error.errorText);
    });
}
export function changePreferences() {
    let dietType = document.getElementById("diet_type").value;
    let intolerancesCheckbox = document.getElementsByName("intolerances[]");
    let intolerances = [];
    for (let i = 0; i < intolerancesCheckbox.length; i++) {
        if (intolerancesCheckbox[i].checked) {
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
        }
        else {
            showToastMessage("successfully_changed_preferences_toast");
        }
    })["catch"](function (error) {
        showToastErrorMessage("error_toast_preferences", "error_text_preferences", error.errorText);
    });
}
export function deleteAccount() {
    let userid = document.getElementById("user_id").value;
    let current_password = document.getElementById("current_password_input").value;
    let reqObj = {
        method: "delete_account",
        current_password: current_password,
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
            showToastErrorMessage("error_toast_delete_account", "error_text_delete_account", data.errorText);
        }
        else {
            localStorage.setItem("deletedAccount", "true");
            window.location.href = "../index/index.html";
        }
    })["catch"](function (error) {
        showToastErrorMessage("error_toast_delete_account", "error_text_delete_account", error.errorText);
    });
}
export function pwdValidation() {
    let pwd_input = document.getElementById("new_password_input");
    let repeat_pwd_input = document.getElementById("repeat_new_password_input");
    if (repeat_pwd_input.value.length == 0 || pwd_input.value.length == 0) {
        return false;
    }
    return repeat_pwd_input.value == pwd_input.value;
}
