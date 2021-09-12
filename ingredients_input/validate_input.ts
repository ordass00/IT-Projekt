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

export function validateAndSaveIngredients(userId: number) {
    let ingredientInput = (document.getElementById("ingredients_input") as HTMLInputElement).value;
    if(!checkIngredientList()){
        return;
    }
    fetch("validate_input.php", {
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
                showToastErrorMessage("error_toast", "error_text", data.errorText);
            } else {
                window.location.href = "../meal_plan_overview/meal_plan_overview.php";
            }
        })
        ["catch"](function (error: { error: string; errorText: string }) {
        showToastErrorMessage("error_toast", "error_text", error.errorText);
    });
}
