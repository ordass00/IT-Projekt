export function showHidePassword(): void {
    let password = document.getElementById("password_input") as HTMLInputElement;
    if (password.type === "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
}

export function showToastErrorMessage(id: string, textFieldId:string err_message: string): void {
    let toastHTMLElement = document.getElementById(id);
    document.getElementById(textFieldId).textContent = err_message;
    let toastElement = new bootstrap.Toast(toastHTMLElement);
    toastElement.show();
}

export function showToastMessage(id: string): void {
    let toastHTMLElement = document.getElementById(id);
    let toastElement = new bootstrap.Toast(toastHTMLElement);
    toastElement.show();
}