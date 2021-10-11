import { showToastErrorMessage, showToastMessage } from "../shared/js/shared_functions.js";
function checkIngredientList() {
    let ingredientInput = document.getElementById("ingredients_input").value;
    var letters = /^[A-Za-z]+$/;
    for (let i = 0; i < ingredientInput.length; i++) {
        if (!ingredientInput[i].match(letters) && ingredientInput[i] !== "," && ingredientInput[i] !== " ") {
            showToastMessage("wrong_ingredient_format_toast");
            return false;
        }
    }
    return true;
}
export function validateAndSaveIngredients(userId, fetch_url, redirect_url, error_toast_id, error_toast_text_id) {
    let ingredientInput = document.getElementById("ingredients_input").value;
    if (!checkIngredientList()) {
        return;
    }
    fetch(fetch_url, {
        method: "POST",
        body: JSON.stringify({ userId: userId, ingredients: ingredientInput }),
    }).then(function (response) {
        if (response.ok) {
            return response.json();
        }
        throw new Error("Error in response.");
    })
        .then(function (data) {
        if (data.error) {
            showToastErrorMessage(error_toast_id, error_toast_text_id, data.errorText);
        }
        else {
            if(redirect_url == ""){
                showToastMessage("successfully_changed_ingredients_toast");
            } else {
                window.location.href = redirect_url;
            }
        }
    })["catch"](function (error) {
        showToastErrorMessage(error_toast_id, error_toast_text_id, error.errorText);
    });
}
