import {showToastMessage} from "../shared/js/shared_functions.js";

function successfullyRegisteredToast(): void {
    if (window.localStorage["registered"] == "true") {
        showToastMessage("successfully_registered_toast")
        localStorage.clear();
    }
}