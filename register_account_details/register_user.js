function registerUser() {
    var email = document.getElementById("email_input").value;
    var username = document.getElementById("username_input").value;
    var password = document.getElementById("password_input").value;
    var gender = window.localStorage["gender"];
    var firstName = window.localStorage["firstName"];
    var lastName = window.localStorage["lastName"];
    var dateOfBirth = window.localStorage["dateOfBirth"];
    setUser(firstName, lastName, dateOfBirth, gender, username, email, password);
}
function setUser(firstName, lastName, dateOfBirth, gender, username, email, password) {
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
    fetch("register_account_details.php", {
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
            var toastHTMLElement = document.getElementById("error_toast");
            document.getElementById("error_text").textContent = data.errorText;
            var toastElement = new bootstrap.Toast(toastHTMLElement);
            toastElement.show();
        }
    })["catch"](function (error) {
        var toastHTMLElement = document.getElementById("error_toast");
        document.getElementById("error_text").textContent = error.errorText;
        var toastElement = new bootstrap.Toast(toastHTMLElement);
        toastElement.show();
    });
}
