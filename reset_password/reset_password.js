import { showToastErrorMessage } from "../shared/js/shared_functions.js";
export function request_password_reset() {
    let email = document.getElementById("email_input").value;
    if (true) {
        update_instructions();
    }
    return false;
}
function update_instructions() {
    let reset_password_elem = document.querySelector(".reset_password_content");
    if (reset_password_elem != null) {
        reset_password_elem.innerHTML = "<p>Instructions on how to reset your password were sent to the specified address.</p>";
        reset_password_elem.innerHTML += "<p>You can leave this page now.</p>";
    }
    else {
        showToastErrorMessage("error_toast", "error_text", "Please try again later!");
    }
}
