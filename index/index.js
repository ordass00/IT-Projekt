import { showToastMessage } from "../shared/js/shared_functions.js";
export function successfullyLoggedOutToast() {
    if (window.localStorage["loggedOut"] == "true") {
        showToastMessage("successfully_logged_out_toast");
        localStorage.clear();
    }
}
