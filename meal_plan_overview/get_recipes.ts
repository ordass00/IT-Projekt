import {showToastErrorMessage} from "../shared/js/shared_functions.js";

function renderCard(meal: string, data: object) {
    document.getElementById(meal + "_image_id")?.setAttribute("src", data.image);
    document.getElementById(meal + "_title_id").textContent = data.title;
    addListToCard(meal + "_used_ingredients_list_id", data, "usedIngredients")
    addListToCard(meal + "_missed_ingredients_list_id", data, "missedIngredients")
}

function addListToCard(id: string, json_object: object, json_key: string) {
    Array.from(json_object[json_key]).forEach(value => {
        const list_element = document.createElement("li")
        list_element.setAttribute("class", "list-group-item")
        const input_element = document.createElement("input");
        input_element.setAttribute("class", "form-check-input me-1")
        input_element.setAttribute("type", "checkbox")
        input_element.setAttribute("value", "")
        input_element.setAttribute("aria-label", "...")
        const text_element = document.createTextNode(value.originalString)
        list_element.appendChild(input_element)
        list_element.appendChild(text_element)
        document.getElementById(id).appendChild(list_element)
    })
}

export function getRecipesByUserId(userId: number) {
    fetch("recipes.php", {
        method: "POST",
        body: JSON.stringify({userId: userId}),
    }).then(function (response: Response) {
        if (response.ok) {
            return response.json();
        }
        throw new Error("Error in response.");
    })
    .then(function (data: any) {
            if (data.error) {
                showToastErrorMessage("error_toast", "error_text", data.errorText);
            }
            else {
                data = data["recipes"]
                renderCard("breakfast", data["breakfast"])
                renderCard("lunch", data["lunch"])
                renderCard("dinner", data["dinner"])
            }
    })
    ["catch"](function (error: { error: string; errorText: string }) {
           showToastErrorMessage("error_toast", "error_text", error.errorText);
    });
}