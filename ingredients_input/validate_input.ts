import {showToastErrorMessage, showToastMessage} from "../shared/js/shared_functions.js";

function checkIngredientList(): boolean {
    let ingredientInput = (document.getElementById("ingredients_input") as HTMLInputElement).value;
    var letters = /^[A-Za-z]+$/;
    for (let i = 0; i < ingredientInput.length; i++) {
        if (!ingredientInput[i].match(letters) && ingredientInput[i] !== "," && ingredientInput[i] !== " ") {
            showToastMessage("wrong_ingredient_format_toast");
            return false;
        }
    }
    return true;
}

export function validateAndSaveIngredients(userId: number, fetch_url: string, redirect_url: string, error_toast_id: string, error_toast_text_id: string) {
    let ingredientInput = (document.getElementById("ingredients_input") as HTMLInputElement).value;
    if(!checkIngredientList()){
        return;
    }
    fetch(fetch_url, {
        method: "POST",
        body: JSON.stringify({userId: userId, ingredients: ingredientInput}),
    }).then(function (response: Response) {
        if (response.ok) {
            return response.json();
        }
        throw new Error("Error in response.");
    })
        .then(function (data: any) {
            if (data.error) {
                showToastErrorMessage(error_toast_id, error_toast_text_id, data.errorText);
            } else {
                window.location.href = redirect_url;
            }
        })
        ["catch"](function (error: { error: string; errorText: string }) {
        showToastErrorMessage(error_toast_id, error_toast_text_id, error.errorText);
    });
}
