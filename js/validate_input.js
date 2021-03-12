function hide_alert(event) {
    event.target.parentNode.parentNode.setAttribute("style", "visibility: hidden !important;");
    event.target.previousElementSibling.innerHTML = "";
}
function validate_fields() {
    var email = document.getElementById("email_input").value;
    var username = document.getElementById("username_input").value;
    var password = document.getElementById("password_input").value;
    if (password == "" || username == "" || email == "") {
        var alerts_text = document.getElementsByClassName("alert_text");
        for (var i = 0; i < alerts_text.length; i++) {
            if (alerts_text[i].innerHTML == "") {
                alerts_text[i].innerHTML = "All fields need to be filled out by you.";
                alerts_text[i].parentElement.parentElement.setAttribute("style", "visibility: visible !important;");
                break;
            }
        }
    }
    else {
        check_duplicates_email(email);
        check_duplicates_username(username);
    }
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
            var alerts_text = document.getElementsByClassName("alert_text");
            for (var i = 0; i < alerts_text.length; i++) {
                if (alerts_text[i].innerHTML == "") {
                    alerts_text[i].innerHTML = "The E-Mail you have entered is already registered.";
                    alerts_text[i].parentElement.parentElement.setAttribute("style", "visibility: visible !important;");
                    break;
                }
            }
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
            var alerts_text = document.getElementsByClassName("alert_text");
            for (var i = 0; i < alerts_text.length; i++) {
                if (alerts_text[i].innerHTML == "") {
                    alerts_text[i].innerHTML = "The Username you have entered is already taken.";
                    alerts_text[i].parentElement.parentElement.setAttribute("style", "visibility: visible !important;");
                    break;
                }
            }
        }
    })["catch"](function (error) {
        console.log({
            error: true,
            duplicate: null,
            errorText: error
        });
    });
}
function register_user(firstName, lastName, dateOfBirth, username, email, password) {
    if (firstName == "" || lastName == "" || dateOfBirth == null || username == "" || email == "" || password == "") {
        console.log("Input parameter(s) is/are missing");
        return;
    }
    var reqObj = {
        method: "register_user",
        firstName: firstName,
        lastName: lastName,
        dateOfBirth: dateOfBirth,
        username: username,
        email: email,
        password: password
    };
    fetch("../php/register_account_details/register_account_details.php", {
        method: "POST",
        body: JSON.stringify(reqObj)
    })
        .then(function (response) {
        if (response.ok) {
            return response.json();
        }
        throw new Error("Error in response. (register_user)");
    })
        .then(function (data) {
    })["catch"](function (error) {
        console.log({
            error: true,
            errorText: error
        });
    });
}
