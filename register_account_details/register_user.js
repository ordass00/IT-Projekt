import { showToastErrorMessage } from "../shared/js/shared_functions.js";
export function registerUser() {
    let email = document.getElementById("email_input").value;
    let username = document.getElementById("username_input").value;
    let password = document.getElementById("password_input").value;
    let gender = window.localStorage["gender"];
    let firstName = window.localStorage["firstName"];
    let lastName = window.localStorage["lastName"];
    let dateOfBirthString = window.localStorage["dateOfBirth"];
    let dateOfBirth = new Date(dateOfBirthString);
    setUser(firstName, lastName, dateOfBirth, gender, username, email, password);
}
function setUser(firstName, lastName, dateOfBirth, gender, username, email, password) {
    let reqObj = {
        method: "register_user",
        firstName: firstName,
        lastName: lastName,
        dateOfBirth: dateOfBirth,
        gender: gender,
        username: username,
        email: email,
        password: password,
    };
    fetch("register_account_details.php", {
        method: "POST",
        body: JSON.stringify(reqObj),
    })
        .then(function (response) {
        if (response.ok) {
            return response.json();
        }
        throw new Error("Error in response. (register_user)");
    })
        .then(function (data) {
        if (data.error) {
            showToastErrorMessage("error_toast", "error_text", data.errorText);
        }
    })["catch"](function (error) {
        showToastErrorMessage("error_toast", "error_text", error.errorText);
    });
}
