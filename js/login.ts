function show_hide_password(): void {
    let p = document.getElementById("password_input") as HTMLInputElement;
    if (p.type === "password") {
        p.type = "text";
    } else {
        p.type = "password";
    }
}

function toast_error_msg(login_err_message: string): void {
    let toastHTMLElement = document.getElementById("error_toast");
    document.getElementById("error_text").textContent = login_err_message;
    let toastElement = new bootstrap.Toast(toastHTMLElement);
    toastElement.show();
}

function successfully_registered_toast(): void {
    if (window.localStorage["registered"] == "true") {
        let toastHTMLElement = document.getElementById("successfully_registered_toast");
        let toastElement = new bootstrap.Toast(toastHTMLElement);
        toastElement.show();
        localStorage.clear();
    }
}
