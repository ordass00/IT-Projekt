"use strict";
exports.__esModule = true;
exports.showToastMessage = exports.showToastErrorMessage = void 0;
function showHidePassword() {
    var password = document.getElementById("password_input");
    if (password.type === "password") {
        password.type = "text";
    }
    else {
        password.type = "password";
    }
}
function showToastErrorMessage(id, login_err_message) {
    var toastHTMLElement = document.getElementById(id);
    document.getElementById(id).textContent = login_err_message;
    var toastElement = new bootstrap.Toast(toastHTMLElement);
    toastElement.show();
}
exports.showToastErrorMessage = showToastErrorMessage;
function showToastMessage(id) {
    var toastHTMLElement = document.getElementById(id);
    var toastElement = new bootstrap.Toast(toastHTMLElement);
    toastElement.show();
}
exports.showToastMessage = showToastMessage;
