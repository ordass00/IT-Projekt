export function showHidePassword(inputFieldId: string): void {
    let password = document.getElementById(inputFieldId) as HTMLInputElement;
    if (password.type === "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
}

export function showToastErrorMessage(id: string, textFieldId: string, err_message: string): void {
    if (err_message == "" || err_message == null) {
        err_message = "An unknown error occured.";
    }
    let toastHTMLElement = document.getElementById(id);
    document.getElementById(textFieldId)!.textContent = err_message;
    let toastElement = new bootstrap.Toast(toastHTMLElement);
    toastElement.show();
}

export function showToastMessage(id: string): void {
    let toastHTMLElement = document.getElementById(id);
    let toastElement = new bootstrap.Toast(toastHTMLElement);
    toastElement.show();
}
export function show_password_validation(password_input_field_or_password_repeat_input_field: string): void {
    if(password_input_field_or_password_repeat_input_field == "password_input_field"){
        (document.getElementsByClassName("pwd-validation")[0] as HTMLInputElement).style.visibility = "visible";
    } else {
        (document.getElementsByClassName("pwd-validation")[1] as HTMLInputElement).style.visibility = "visible";
    }
}
export function hide_password_validation(password_input_field_or_password_repeat_input_field: string): void{
    if(password_input_field_or_password_repeat_input_field == "password_input_field"){
        (document.getElementsByClassName("pwd-validation")[0] as HTMLInputElement).style.visibility = "hidden";
    } else {
        (document.getElementsByClassName("pwd-validation")[1] as HTMLInputElement).style.visibility = "hidden";
    }
}
export function validate_password(input_id: string): void{
    let pwd_input = (document.getElementById(input_id) as HTMLInputElement);
    let lower_case_letters_error_msg = (document.getElementById("lower_case") as HTMLInputElement);
    let upper_case_letters_error_msg = (document.getElementById("upper_case") as HTMLInputElement);
    let numbers_error_msg = (document.getElementById("one_number") as HTMLInputElement);
    let min_eight_chars_error_msg = (document.getElementById("min_eight_chars") as HTMLInputElement);
    let lower_case_letters = /[a-z]/g;
    let upper_case_letters = /[A-Z]/g;
    let numbers = /[0-9]/g;
    if (pwd_input.value.match(lower_case_letters)) {
        lower_case_letters_error_msg.classList.remove("bi-x-lg");
        lower_case_letters_error_msg.classList.add("bi-check-lg");
        lower_case_letters_error_msg.style["color"] = "green";
    }
    else {
        lower_case_letters_error_msg.classList.remove("bi-check-lg");
        lower_case_letters_error_msg.classList.add("bi-x-lg");
        lower_case_letters_error_msg.style["color"] = "red";
    }
    if (pwd_input.value.match(upper_case_letters)) {
        upper_case_letters_error_msg.classList.remove("bi-x-lg");
        upper_case_letters_error_msg.classList.add("bi-check-lg");
        upper_case_letters_error_msg.style["color"] = "green";
    }
    else {
        upper_case_letters_error_msg.classList.remove("bi-check-lg");
        upper_case_letters_error_msg.classList.add("bi-x-lg");
        upper_case_letters_error_msg.style["color"] = "red";
    }
    if (pwd_input.value.match(numbers)) {
        numbers_error_msg.classList.remove("bi-x-lg");
        numbers_error_msg.classList.add("bi-check-lg");
        numbers_error_msg.style["color"] = "green";
    }
    else {
        numbers_error_msg.classList.remove("bi-check-lg");
        numbers_error_msg.classList.add("bi-x-lg");
        numbers_error_msg.style["color"] = "red";
    }
    if (pwd_input.value.length >= 8) {
        min_eight_chars_error_msg.classList.remove("bi-x-lg");
        min_eight_chars_error_msg.classList.add("bi-check-lg");
        min_eight_chars_error_msg.style["color"] = "green";
    }
    else {
        min_eight_chars_error_msg.classList.remove("bi-check-lg");
        min_eight_chars_error_msg.classList.add("bi-x-lg");
        min_eight_chars_error_msg.style["color"] = "red";
    }
}
export function validate_password_repeat(input_id: string, repeat_input_id: string): void {
    let pwd_input = (document.getElementById(input_id) as HTMLInputElement);
    let repeat_pwd_input = (document.getElementById(repeat_input_id) as HTMLInputElement);
    let pwd_match_error_msg = (document.getElementById("password_match") as HTMLInputElement);
    if (repeat_pwd_input.value != pwd_input.value) {
        pwd_match_error_msg.classList.remove("bi-check-lg");
        pwd_match_error_msg.classList.add("bi-x-lg");
        pwd_match_error_msg.style["color"] = "red";
    }
    else {
        pwd_match_error_msg.classList.remove("bi-x-lg");
        pwd_match_error_msg.classList.add("bi-check-lg");
        pwd_match_error_msg.style["color"] = "green";
    }
}