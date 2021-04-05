import { showToastMessage } from "../shared/js/shared_functions.js";
export function successfullyRegisteredToast() {
    if (window.localStorage["registered"] == "true") {
        showToastMessage("successfully_registered_toast");
        localStorage.clear();
    }
}
