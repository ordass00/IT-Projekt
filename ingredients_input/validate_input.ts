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
/*function getIngredients(): void {
    let ingredientInput = (document.getElementById("ingredients_input") as HTMLInputElement).value;
    let ingredientsList: string[] = [];
    let count = 0;
    let ingredient: string = "";
    for (let i = 0; i < ingredientInput.length; i++) {
        if (ingredientInput[i] !== "," && ingredientInput[i] !== " ") {
            ingredient += ingredientInput[i];
        }
        if (ingredientInput[i] === "," || ingredientInput.length - 1 == i) {
            ingredientsList[count] = ingredient;
            count++;
            ingredient = "";
        }
    }
    (document.getElementById("ingredients_input") as HTMLInputElement).value = JSON.stringify(ingredientsList);
}*/