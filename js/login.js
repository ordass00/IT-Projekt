function show_hide_password() {
    var p = document.getElementById("password_input");
    if (p.type === "password") {
        p.type = "text";
    }
    else {
        p.type = "password";
    }
}
function toast_error_msg(login_err_message) {
    var toastHTMLElement = document.getElementById("error_toast");
    document.getElementById("error_text").textContent = login_err_message;
    var toastElement = new bootstrap.Toast(toastHTMLElement);
    toastElement.show();
}
function successfully_registered_toast() {
    if (window.localStorage["registered"] == "true") {
        var toastHTMLElement = document.getElementById("successfully_registered_toast");
        var toastElement = new bootstrap.Toast(toastHTMLElement);
        toastElement.show();
        localStorage.clear();
    }
}
