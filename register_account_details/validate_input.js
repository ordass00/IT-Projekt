function validateInput() {
    var email = document.getElementById("email_input").value;
    var username = document.getElementById("username_input").value;
    checkDuplicatesEmail(email);
    checkDuplicatesUsername(username);
    registerUser();
    setTimeout(function () { return checkRegistrationSuccess(); }, 100);
    return false;
}
function showHidePwd() {
    var passwordElement = document.getElementById("password_input");
    if (passwordElement.type === "password") {
        passwordElement.type = "text";
    }
    else {
        passwordElement.type = "password";
    }
}
function checkRegistrationSuccess() {
    if (window.localStorage["email_success"] == "true" && window.localStorage["username_success"] == "true") {
        localStorage.setItem("registered", "true");
        window.location.href = "../login/login_form.php";
    }
}
function checkDuplicatesEmail(email) {
    localStorage.setItem("email_success", "false");
    var reqObj = {
        method: "check_duplicates_email",
        email: email
    };
    fetch("register_account_details.php", {
        method: "POST",
        body: JSON.stringify(reqObj)
    })
        .then(function (response) {
        if (response.ok) {
            return response.json();
        }
        throw new Error("Error in response. (check_duplicates_email)");
    })
        .then(function (data) {
        if (data.errorText == "The email is already registered.") {
            var toastHTMLElement = document.getElementById("email_duplicate_toast");
            var toastElement = new bootstrap.Toast(toastHTMLElement);
            toastElement.show();
        }
        else if (data.error) {
            var toastHTMLElement = document.getElementById("error_toast");
            document.getElementById("error_text").textContent = data.errorText;
            var toastElement = new bootstrap.Toast(toastHTMLElement);
            toastElement.show();
        }
        else {
            localStorage.setItem("email_success", "true");
        }
    })["catch"](function (error) {
        var toastHTMLElement = document.getElementById("error_toast");
        document.getElementById("error_text").textContent = error.errorText;
        var toastElement = new bootstrap.Toast(toastHTMLElement);
        toastElement.show();
    });
}
function checkDuplicatesUsername(username) {
    localStorage.setItem("username_success", "false");
    var reqObj = {
        method: "check_duplicates_username",
        username: username
    };
    fetch("register_account_details.php", {
        method: "POST",
        body: JSON.stringify(reqObj)
    })
        .then(function (response) {
        if (response.ok) {
            return response.json();
        }
        throw new Error("Error in response. (check_duplicates_username)");
    })
        .then(function (data) {
        if (data.errorText == "The username is already registered.") {
            var toastHTMLElement = document.getElementById("username_duplicate_toast");
            var toastElement = new bootstrap.Toast(toastHTMLElement);
            toastElement.show();
        }
        else if (data.error) {
            var toastHTMLElement = document.getElementById("error_toast");
            document.getElementById("error_text").textContent = data.errorText;
            var toastElement = new bootstrap.Toast(toastHTMLElement);
            toastElement.show();
        }
        else {
            localStorage.setItem("username_success", "true");
        }
    })["catch"](function (error) {
        var toastHTMLElement = document.getElementById("error_toast");
        document.getElementById("error_text").textContent = error.errorText;
        var toastElement = new bootstrap.Toast(toastHTMLElement);
        toastElement.show();
    });
}
