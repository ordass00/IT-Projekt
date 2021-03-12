function validate_fields() {
    hide_alert_all();
    var email = document.getElementById("email_input").value;
    var username = document.getElementById("username_input").value;
    var password = document.getElementById("password_input").value;
    if (password == "" || username == "" || email == "") {
        fill_warnings("All fields need to be filled out by you.");
    }
    else if (!check_username(username)) {
        return;
    }
    else if (!check_email_length(email)) {
        return;
    }
    else if (!check_password(password)) {
        return;
    }
    else {
        check_duplicates_email(email);
        check_duplicates_username(username);
    }
}
function hide_alert_with_button(event) {
    event.target.parentNode.parentNode.setAttribute("style", "visibility: hidden !important;");
    event.target.previousElementSibling.innerHTML = "";
}
function hide_alert_all() {
    var alerts_text = document.getElementsByClassName("d-flex align-items-center justify-content-center m-2");
    for (var i = 0; i < alerts_text.length; i++) {
        alerts_text[i].setAttribute("style", "visibility: hidden !important;");
        alerts_text[i].firstElementChild.firstElementChild.nextElementSibling.textContent = "";
    }
}
function fill_warnings(warning_text) {
    var alerts_text = document.getElementsByClassName("alert_text");
    //Check if alert is already being displayed
    for (var i = 0; i < alerts_text.length; i++) {
        if (alerts_text[i].textContent == warning_text) {
            return;
        }
    }
    for (var i = 0; i < alerts_text.length; i++) {
        if (alerts_text[i].textContent == "") {
            alerts_text[i].textContent = warning_text;
            alerts_text[i].parentElement.parentElement.setAttribute("style", "visibility: visible !important;");
            break;
        }
    }
}
function check_username(username) {
    if (username.length < 3) {
        fill_warnings("Your username needs to be at least three characters");
        return false;
    }
    else if (username.length >= 45) {
        fill_warnings("Your your username needs to be less than 45 characters");
        return false;
    }
    return true;
}
//Kann weiter ausgebaut werden
function check_password(password) {
    if (password.length < 8) {
        fill_warnings("Your password needs to be at least eight characters");
        return false;
    }
    return true;
}
//Kann weiter ausgebaut werden
function check_email_length(email) {
    if (email.length < 4) {
        fill_warnings("Your your E-Mail needs to be at least four characters");
        return false;
    }
    else if (email.length >= 45) {
        fill_warnings("Your your E-Mail needs to be less than 45 characters");
        return false;
    }
    return true;
}
function check_duplicates_email(email) {
    var reqObj = {
        method: "check_duplicates_email",
        email: email
    };
    fetch("../php/register_account_details/register_account_details.php", {
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
        if (data.duplicate) {
            fill_warnings("The E-Mail you have entered is already registered.");
        }
    })["catch"](function (error) {
        console.log({
            error: true,
            duplicate: null,
            errorText: error
        });
    });
}
function check_duplicates_username(username) {
    var reqObj = {
        method: "check_duplicates_username",
        username: username
    };
    fetch("../php/register_account_details/register_account_details.php", {
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
        if (data.duplicate) {
            fill_warnings("The Username you have entered is already taken.");
        }
    })["catch"](function (error) {
        console.log({
            error: true,
            duplicate: null,
            errorText: error
        });
    });
}
