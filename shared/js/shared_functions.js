export function showHidePassword() {
    let password = document.getElementById("password_input");
    if (password.type === "password") {
        password.type = "text";
    }
    else {
        password.type = "password";
    }
}
export function showToastErrorMessage(id, textFieldId, err_message) {
    if (err_message == "") {
        err_message = "An uknown error occured";
    }
    let toastHTMLElement = document.getElementById(id);
    document.getElementById(textFieldId).textContent = err_message;
    let toastElement = new bootstrap.Toast(toastHTMLElement);
    toastElement.show();
}
export function showToastMessage(id) {
    let toastHTMLElement = document.getElementById(id);
    let toastElement = new bootstrap.Toast(toastHTMLElement);
    toastElement.show();
}
