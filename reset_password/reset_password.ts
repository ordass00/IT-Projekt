import { showToastErrorMessage, showToastMessage } from "../shared/js/shared_functions.js";
export function request_password_reset(): boolean {
    let email = (document.getElementById("email_input") as HTMLInputElement).value;

    let reqObj = {
        method: "reset_password_request",
        email: email,
    };
    fetch("reset_password.php", {
        method: "POST",
        body: JSON.stringify(reqObj),
    })
        .then(function (response: Response) {
            if (response.ok) {
                return response.json();
            }
            throw new Error("Error in response. (request_password_reset)");
        })
        .then(function (data: { error: string; errorText: string; }) {
            if (data.error) {
                showToastErrorMessage("error_toast", "error_text", data.errorText);
            } else {
                update_instructions();
            }
        })
    ["catch"](function (error) {
        showToastErrorMessage("error_toast", "error_text", error.errorText);
    });

    return false;
}
function update_instructions(): void {
    let reset_password_elem = document.querySelector(".reset_password_content");
    if (reset_password_elem != null) {
        reset_password_elem.innerHTML = "<p>Instructions on how to reset your password were sent to the specified address.</p>";
        reset_password_elem.innerHTML += "<p><b>Please make sure to check your spam folder.</b></p><br>";
        reset_password_elem.innerHTML += "<p>You can leave this page now.</p>";
    }
    else {
        showToastErrorMessage("error_toast", "error_text", "Please try again later!");
    }

}
export function set_new_password():boolean{
    let id = document.getElementById("u_id")?.innerHTML;
    let token = document.getElementById("token")?.innerHTML;
    if(id == "" || token == ""){
        showToastErrorMessage("error_toast", "error_text", "The process to reset the password was not started yet.");
        return false;
    }
    let password = (document.getElementById("new_password") as HTMLInputElement).value;
    let password_check = (document.getElementById("new_password_check") as HTMLInputElement).value;
    if(password != password_check){
        showToastErrorMessage("error_toast", "error_text", "The passwords did not match.");
        return false;
    }
    let reqObj = {
        method: "reset_password",
        password: password,
        token: token,
        id: id
    };
    fetch("reset_password.php", {
        method: "POST",
        body: JSON.stringify(reqObj),
    })
        .then(function (response: Response) {
            if (response.ok) {
                return response.json();
            }
            throw new Error("Error in response. (set_new_password)");
        })
        .then(function (data: { error: string; errorText: string; }) {
            if (data.error) {
                showToastErrorMessage("error_toast", "error_text", data.errorText);
            } else {
                localStorage.setItem('password_reset', 'success');
                window.location.href = "../login/login_form.php";
            }
        })
    ["catch"](function (error) {
        showToastErrorMessage("error_toast", "error_text", error.errorText);
    });

    return false;
}