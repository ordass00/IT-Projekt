import {showToastErrorMessage} from "../shared/js/shared_functions.js";


function renderCard(meal: string, data: object) {
    document.getElementById(meal + "_image_id")?.setAttribute("src", data.Image);
    document.getElementById(meal + "_title_card_id").textContent = data.Title;
    document.getElementById(meal + "_title_print_id").textContent = data.Title;
    addListToCard(meal + "_used_ingredients_list_id", data, "UsedIngredients")
    addListToCard(meal + "_missed_ingredients_list_id", data, "MissedIngredients")
}

function addListToCard(id: string, json_object: object, json_key: string) {
    json_object[json_key].split(";").forEach(value => {
        const list_element = document.createElement("li")
        list_element.setAttribute("class", "list-group-item")
        const input_element = document.createElement("input");
        input_element.setAttribute("class", "form-check-input me-1")
        input_element.setAttribute("type", "checkbox")
        input_element.setAttribute("value", "")
        input_element.setAttribute("aria-label", "...")
        const text_element = document.createTextNode(value)
        list_element.appendChild(input_element)
        list_element.appendChild(text_element)
        document.getElementById(id).appendChild(list_element)
    })
}

export function getRecipesByUserId(userId: number) {
    fetch("recipes.php", {
        method: "POST",
        body: JSON.stringify({userId: userId, function_name: "get_recipes_by_user_id"}),
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
                data = data["result"]
                localStorage.setItem("breakfast_id", data["breakfast"].MealID)
                localStorage.setItem("lunch_id", data["lunch"].MealID)
                localStorage.setItem("dinner_id", data["dinner"].MealID)

                renderCard("breakfast", data["breakfast"])
                renderCard("lunch", data["lunch"])
                renderCard("dinner", data["dinner"])

                document.getElementById("overlay").setAttribute("style", "display:none")
                document.getElementById("anchor").setAttribute("style", "display:visible");
            }
        })
        ["catch"](function (error: { error: string; errorText: string }) {
        showToastErrorMessage("error_toast", "error_text", error.errorText);
    });
}

export function printDiv(divName: string) {
    const printContents = document.getElementById(divName).innerHTML;
    const originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

export function changeWebsiteToTasteAndNutritionVisualization(meal_type: string) {
    localStorage.setItem("meal_type", meal_type);
    window.location.href = "./taste_and_nutrition_visualization.html";
}

export function tasteAndNutrientVisualization() {
    const meal_id = localStorage.getItem(localStorage.getItem("meal_type") + "_id");

    fetch("recipes.php", {
        method: "POST",
        body: JSON.stringify({meal_id: meal_id, function_name: "get_taste_and_nutrient_visualization"}),
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
                setTimeout(() => {
                    document.getElementById("anchor").innerHTML = data["result"];
                    document.getElementById("overlay").setAttribute("style", "display:none")
                    document.getElementById("anchor").setAttribute("style", "display:visible");
                }, 0);
            }
        })
        ["catch"](function (error: { error: string; errorText: string }) {
        showToastErrorMessage("error_toast", "error_text", error.errorText);
    });
}

export function incrementCurrentMealNr(userId: number, meal_type_nr: string) {
    fetch("recipes.php", {
        method: "POST",
        body: JSON.stringify({userId: userId, meal_type_nr: meal_type_nr, function_name: "increment_current_meal_nr"}),
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
                if (data["result"]) {
                    getRecipesByUserId(userId);
                } else {
                    showToastErrorMessage("error_toast", "error_text", "Current meal nr wasn't increased. Can't load next meal");
                }
            }
        })
        ["catch"](function (error: { error: string; errorText: string }) {
        showToastErrorMessage("error_toast", "error_text", error.errorText);
    });
}

