import { showToastMessage } from "../shared/js/shared_functions.js";

export function validateInput(): boolean {
    if (checkIngredientList()) {
        return true;
    }
    return false;
}
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
