import {showToastMessage} from "../shared/js/shared_functions.js";

export function successfullyLoggedOutToast(): void {
    if (window.localStorage["loggedOut"] == "true") {
        showToastMessage("successfully_logged_out_toast");
    }
    if (window.localStorage["deletedAccount"] == "true") {
        showToastMessage("successfully_deleted_account_toast");
    }
    localStorage.clear();
}