import { showToastErrorMessage, showToastMessage } from "../shared/js/shared_functions.js";
export function request_password_reset(): boolean {
    let email = (document.getElementById("email_input") as HTMLInputElement).value;

    let reqObj = {
        method: "reset_password",
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
        .then(function (data: { error: string; errorText: string; resetToken: string}) {
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
        reset_password_elem.innerHTML += "<p>You can leave this page now.</p>";
    }
    else {
        showToastErrorMessage("error_toast", "error_text", "Please try again later!");
    }

}