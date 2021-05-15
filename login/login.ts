import {showToastMessage} from "../shared/js/shared_functions.js";

export function successfullyRegisteredToast(): void {
    if (window.localStorage["registered"] == "true") {
        showToastMessage("successfully_registered_toast");
        localStorage.clear();
    }
}

export function successfullyResetToast(): void {
    if (window.localStorage["password_reset"] == "success") {
        showToastMessage("successfully_reset_password_toast");
        localStorage.clear();
    }
}