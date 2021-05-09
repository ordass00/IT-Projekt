import { showToastErrorMessage } from "../shared/js/shared_functions.js";
export function request_password_reset() {
    let email = document.getElementById("email_input").value;
    let reqObj = {
        method: "reset_password_request",
        email: email,
    };
    fetch("reset_password.php", {
        method: "POST",
        body: JSON.stringify(reqObj),
    })
        .then(function (response) {
        if (response.ok) {
            return response.json();
        }
        throw new Error("Error in response. (request_password_reset)");
    })
        .then(function (data) {
        if (data.error) {
            showToastErrorMessage("error_toast", "error_text", data.errorText);
        }
        else {
            update_instructions();
        }
    })["catch"](function (error) {
        showToastErrorMessage("error_toast", "error_text", error.errorText);
    });
    return false;
}
function update_instructions() {
    let reset_password_elem = document.querySelector(".reset_password_content");
    if (reset_password_elem != null) {
        reset_password_elem.innerHTML = "<p>Instructions on how to reset your password were sent to the specified address.</p>";
        reset_password_elem.innerHTML += "<p>You can leave this page now.</p>";
    }
    else {
        showToastErrorMessage("error_toast", "error_text", "Please try again later!");
    }
}
export function set_new_password() {
    let id = document.getElementById("u_id")?.innerHTML;
    let token = document.getElementById("token")?.innerHTML;
    if (id == "" || token == "") {
        showToastErrorMessage("error_toast", "error_text", "The process to reset the password was not started yet.");
        return false;
    }
    let password = document.getElementById("new_password").value;
    let password_check = document.getElementById("new_password_check").value;
    if (password != password_check) {
        showToastErrorMessage("error_toast", "error_text", "The passwords did not match.");
        return false;
    }
    let reqObj = {
        method: "reset_password",
        password: password,
        token: token,
        id: id
    };
    fetch("reset_password.php", {
        method: "POST",
        body: JSON.stringify(reqObj),
    })
        .then(function (response) {
        if (response.ok) {
            return response.json();
        }
        throw new Error("Error in response. (set_new_password)");
    })
        .then(function (data) {
        if (data.error) {
            showToastErrorMessage("error_toast", "error_text", data.errorText);
        }
        else {
            localStorage.setItem('password_reset', 'success');
            window.location.href = "../login/login_form.php";
        }
    })["catch"](function (error) {
        showToastErrorMessage("error_toast", "error_text", error.errorText);
    });
    return false;
}
