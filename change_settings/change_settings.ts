import { showToastErrorMessage, showToastMessage } from "../shared/js/shared_functions.js";

export function changeAccountSettings(): void {
    let firstname: string = (document.getElementById("first_name_input") as HTMLInputElement).value;
    let lastname: string = (document.getElementById("last_name_input") as HTMLInputElement).value;
    let username: string = (document.getElementById("username_input") as HTMLInputElement).value;
    let email: string = (document.getElementById("email_input") as HTMLInputElement).value;
    let dateOfBirth: string = (document.getElementById("date_of_birth_input") as HTMLInputElement).value;
    let userid: string = (document.getElementById("user_id") as HTMLInputElement).value;
    changeUserInformation(firstname, lastname, username, email, dateOfBirth, userid);
}

function updateDisplayedAccountSettings(data:any){
    let firstname_input: string =  data["firstname"];
    let lastname_input: string =  data["lastname"];
    let username_input: string =  data["username"];
    let email_input: string =  data["email"];
    let dateofbirth_input: string = data["dateofbirth"];
    (document.getElementById("username") as HTMLInputElement).setAttribute("value", username_input);
    (document.getElementById("first_name") as HTMLInputElement).setAttribute("value", firstname_input);
    (document.getElementById("last_name") as HTMLInputElement).setAttribute("value", lastname_input);
    (document.getElementById("email") as HTMLInputElement).setAttribute("value", email_input);
    (document.getElementById("date_of_birth") as HTMLInputElement).setAttribute("value", dateofbirth_input);
}

function changeUserInformation(firstname:string, lastname:string, username:string, email:string, dateOfBirth:string, userid:string) {
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
        .then(function (data: any) {
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
    let password: string = (document.getElementById("new_password_input") as HTMLInputElement).value;
    let password_repeat: string = (document.getElementById("repeat_new_password_input") as HTMLInputElement).value;
    let userid: string = (document.getElementById("user_id") as HTMLInputElement).value;

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
        .then(function (data: any) {
            if (data.error) {
                showToastErrorMessage("error_toast_password", "error_text_password", data.errorText);
            } else {
                showToastMessage("successfully_changed_password_toast");
            }
        })["catch"](function (error) {
        showToastErrorMessage("error_toast_password", "error_text_password", error.errorText);
    });
}

export function updateDisplayedSettingsOnLoad(): void {
    let userid = (document.getElementById("user_id") as HTMLInputElement).value;
    let reqObj = {
        method: "display_settings",
        userid: userid,
    };
    fetch("change_settings_functionality.php", {
        method: "POST",
        body: JSON.stringify(reqObj),
    })
        .then(function (response: Response) {
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
                (document.getElementById("ingredients_input") as HTMLInputElement).value = ingredients["ingredients"];
                let intolerances = preferences["intolerances"].split(", ");
                let diet_type = preferences["diet_type"];
                let calories = preferences["calories"];
                for (var i = 0; i < intolerances.length; i++) {
                    if (intolerances[i] == "dairy") {
                        document.getElementById("chk_dairy").setAttribute("checked", "checked");
                    }
                    if (intolerances[i] == "gluten") {
                        document.getElementById("chk_gluten").setAttribute("checked", "checked");
                    }
                    if (intolerances[i] == "grain") {
                        document.getElementById("chk_grain").setAttribute("checked", "checked");
                    }
                    if (intolerances[i] == "wheat") {
                        document.getElementById("chk_wheat").setAttribute("checked", "checked");
                    }
                    if (intolerances[i] == "peanut") {
                        document.getElementById("chk_peanut").setAttribute("checked", "checked");
                    }
                    if (intolerances[i] == "egg") {
                        document.getElementById("chk_egg").setAttribute("checked", "checked");
                    }
                }
                (document.getElementById("diet_type") as HTMLInputElement).value = diet_type;
                let range = document.querySelector(".range") as HTMLInputElement;
                let bubble = document.querySelector(".bubble");
                const val = calories;
                const min: any = range.min ? range.min : 0;
                const max: any = range.max ? range.max : 100;
                const sliderRange = Number(((val - min) * 100) / (max - min));
                bubble.innerHTML = val;
                (document.getElementById("calories") as HTMLInputElement).value = val;
                (bubble as HTMLInputElement).style.left = `calc(${sliderRange}% + (${8 - sliderRange * 0.15}px))`;
                (document.getElementById("input_calories_range") as HTMLInputElement).value = calories;
            }
        })["catch"](function (error) {
        showToastErrorMessage("error_toast_preferences", "error_text_preferences", error.errorText);
    });
}

export function changePreferences() {
    let dietType: string = (document.getElementById("diet_type") as HTMLInputElement).value;
    let intolerancesCheckbox = document.getElementsByName("intolerances[]");
    let intolerances = [];
    for (var i=0; i<intolerancesCheckbox.length; i++){
        if ((intolerancesCheckbox[i] as HTMLInputElement).checked){
            intolerances.push((intolerancesCheckbox[i] as HTMLInputElement).value);
        }
    }
    let calories: string = (document.getElementById("calories") as HTMLInputElement).value;
    let userid: string = (document.getElementById("user_id") as HTMLInputElement).value;

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

export function deleteAccount() {
    let userid = (document.getElementById("user_id") as HTMLInputElement).value;
    let current_password = (document.getElementById("current_password_input") as HTMLInputElement).value;
    let reqObj = {
        method: "delete_account",
        current_password: current_password,
        userid: userid,
    };
    fetch("change_settings_functionality.php", {
        method: "POST",
        body: JSON.stringify(reqObj),
    })
        .then(function (response: Response) {
            if (response.ok) {
                return response.json();
            }
            throw new Error("Error in response. (change_preferences)");
        })
        .then(function (data: any) {
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

let pwd_input = (document.getElementById("new_password_input") as HTMLInputElement);
let repeat_pwd_input = (document.getElementById("repeat_new_password_input") as HTMLInputElement);
let lower_case_letters_error_msg = (document.getElementById("lower_case") as HTMLInputElement);
let upper_case_letters_error_msg = (document.getElementById("upper_case") as HTMLInputElement);
let numbers_error_msg = (document.getElementById("one_number") as HTMLInputElement);
let min_eight_chars_error_msg = (document.getElementById("min_eight_chars") as HTMLInputElement);
let pwd_match_error_msg = (document.getElementById("password_match") as HTMLInputElement);

export function pwdValidation() {
    if (repeat_pwd_input.value.length == 0 || pwd_input.value.length == 0){
        return false;
    }
    return repeat_pwd_input.value == pwd_input.value;
}

pwd_input.onfocus = function() {
    (document.getElementsByClassName("pwd-validation")[0] as HTMLInputElement).style.display = "flex";
}

repeat_pwd_input.onfocus = function() {
    (document.getElementsByClassName("pwd-validation")[1] as HTMLInputElement).style.display = "flex";
}

pwd_input.onblur = function() {
    (document.getElementsByClassName("pwd-validation")[0] as HTMLInputElement).style.display = "none";
}

repeat_pwd_input.onblur = function() {
    (document.getElementsByClassName("pwd-validation")[1] as HTMLInputElement).style.display = "none";
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