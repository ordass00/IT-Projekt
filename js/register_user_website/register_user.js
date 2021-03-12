function register_user() {
    if (check_alerts_activated()) {
        return;
    }
    var email = document.getElementById("email_input").value;
    var username = document.getElementById("username_input").value;
    var password = document.getElementById("password_input").value;
    var gender = window.localStorage["gender"];
    var firstName = window.localStorage["firstName"];
    var lastName = window.localStorage["lastName"];
    var dateOfBirth = window.localStorage["dateOfBirth"];
    if (gender != "" && firstName != "" && lastName != "" && dateOfBirth != null) {
        set_user(firstName, lastName, dateOfBirth, gender, username, email, password);
    }
    else {
        console.log("Not all user details were provided");
        return;
    }
    location.href = "";
}
function set_user(firstName, lastName, dateOfBirth, gender, username, email, password) {
    if (firstName == "" || lastName == "" || dateOfBirth == null || username == "" || email == "" || password == "") {
        console.log("Input parameter(s) is/are missing");
        return;
    }
    var reqObj = {
        method: "register_user",
        firstName: firstName,
        lastName: lastName,
        dateOfBirth: dateOfBirth,
        gender: gender,
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
        if (data.error) {
            console.log({ error: data.error, errorText: data.errorText
            });
        }
    })["catch"](function (error) {
        console.log({
            error: true,
            errorText: error
        });
    });
}
function check_alerts_activated() {
    var alerts_text = document.getElementsByClassName("d-flex align-items-center justify-content-center m-2");
    for (var i = 0; i < alerts_text.length; i++) {
        if (alerts_text[i].style.visibility == "visible") {
            return true;
        }
    }
    return false;
}
