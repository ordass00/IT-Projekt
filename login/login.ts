import { showToastErrorMessage, showToastMessage } from "../shared/js/shared_functions.js";
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
export function loginValidation() {
    let email: string = (document.getElementById("email_input") as HTMLInputElement).value;
    let password: string = (document.getElementById("password_input") as HTMLInputElement).value;
    let reqObj = {
        method: "login_validation",
        email: email,
        password: password,
    };
    fetch("login_functionality.php", {
        method: "POST",
        body: JSON.stringify(reqObj),
    })
        .then(function (response: Response) {
            if (response.ok) {
                return response.json();
            }
            throw new Error("Error in response. (login_validation)");
        })
        .then(function (data: any) {
            if (data.error) {
                showToastErrorMessage("error_toast", "error_text", data.errorText);
            } else {
                if(data["preferences_set"] == false){
                    window.location.href = "../save_preferences/save_preferences.php";
                } else if(data["ingredients_set"] == false) {
                    window.location.href = "../ingredients_input/ingredients_input.php";
                } else {
                    window.location.href = "../meal_plan_overview/meal_plan_overview.php";
                }
            }
        })["catch"](function (error) {
        showToastErrorMessage("error_toast", "error_text", error.errorText);
    });
}