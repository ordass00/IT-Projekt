import { showToastErrorMessage } from "../shared/js/shared_functions.js";

function renderCard(meal: string, data: { Image: string; Title: string | null; }) {
    document.getElementById(meal + "_image_id")?.setAttribute("src", data.Image);
    document.getElementById(meal + "_title_card_id").textContent = data.Title;
}

function createShoppingList(json_object: object, json_key: string) {
    let ingredientsArray = []
    if(json_object[json_key].length!=0){
        ingredientsArray = json_object[json_key].split("; ");;
    }
    else{
        return;
    }

    let unorderedListElement = document.createElement("ul");
    unorderedListElement.setAttribute("class", "list-group");
    let i = 0;
    if(json_key==="UsedIngredients"){
        let heading = document.createElement("h6");
        document.getElementById("anchor")?.appendChild(heading)
        heading.appendChild(document.createTextNode("Used Ingredients:"));
        heading.setAttribute("class", "my-2");
    }
    else if(json_key==="MissedIngredients"){
        i = json_object["UsedIngredients"].split("; ").length;
        if((i + 1) % 19 === 0) {
            createPageBreak();
            i++;
        }
        let heading = document.createElement("h6");
        document.getElementById("anchor")?.appendChild(heading)
        heading.appendChild(document.createTextNode("Missed Ingredients:"));
        heading.setAttribute("class", "my-2");
    }

    document.getElementById("anchor")?.appendChild(unorderedListElement)
    ingredientsArray.forEach((value: string) => {
        if((i + 1) % 19 === 0){
            createPageBreak()
            unorderedListElement = document.createElement("ul");
            unorderedListElement.setAttribute("class", "list-group");
            document.getElementById("anchor")?.appendChild(unorderedListElement);
        }
        const list_element = document.createElement("li");
        list_element.setAttribute("class", "list-group-item");
        const input_element = document.createElement("input");
        input_element.setAttribute("class", "form-check-input me-1");
        input_element.setAttribute("type", "checkbox");
        input_element.setAttribute("value", "");
        input_element.setAttribute("aria-label", "...");
        const text_element = document.createTextNode(value);
        list_element.appendChild(input_element);
        list_element.appendChild(text_element);
        unorderedListElement.appendChild(list_element);
        i++;
    });
}

function createPageBreak(){
    const page_break_div_element = document.createElement("div");
    page_break_div_element.style.pageBreakAfter = "always";
    const empty_div = document.createElement("div");
    document.getElementById("anchor")?.appendChild(page_break_div_element);
    document.getElementById("anchor")?.appendChild(empty_div);
}

export function getRecipesByUserId(userId: number) {
    fetch("recipes.php", {
        method: "POST",
        body: JSON.stringify({ userId: userId, function_name: "get_recipes_by_user_id" }),
    }).then(function (response: Response) {
        if (response.ok) {
            return response.json();
        }
        throw new Error("Error in response.");
    })
        .then(function (data: any) {
            if (data.error) {
                showToastErrorMessage("error_toast", "error_text", data.errorText);
                if(data.errorText==="\nCan't find enough recipes.\nPlease adjust your preferences or ingredients.\n\nYou will be forwarded to the settings page"){
                    setTimeout(()=>window.location.href = "../change_settings/change_settings.php", 5000)
                }
            }
            else {
                data = data["result"];
                localStorage.setItem("breakfast_id", data["breakfast"].MealID);
                localStorage.setItem("lunch_id", data["lunch"].MealID);
                localStorage.setItem("dinner_id", data["dinner"].MealID);
                renderCard("breakfast", data["breakfast"]);
                renderCard("lunch", data["lunch"]);
                renderCard("dinner", data["dinner"]);
                document.getElementById("overlay")?.setAttribute("style", "display:none");
                document.getElementById("anchor")?.setAttribute("style", "display:visible");
            }
        })["catch"](function (error: { error: string; errorText: string }) {
        showToastErrorMessage("error_toast", "error_text", error.errorText);
    });
}

export function changeWebsiteToTasteAndNutritionVisualization(meal_type: string) {
    localStorage.setItem("meal_type", meal_type);
    window.location.href = "./taste_and_nutrition_visualization.html";
}

export function tasteAndNutrientVisualization() {
    const meal_id = localStorage.getItem(localStorage.getItem("meal_type") + "_id");
    fetch("recipes.php", {
        method: "POST",
        body: JSON.stringify({ meal_id: meal_id, function_name: "get_taste_and_nutrient_visualization" }),
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
                setTimeout(() => {
                    data = data["result"];
                    let divAndScriptNutritionWidget = seperateDivAndScript(data["nutritionWidget"])
                    let divAndScriptTasteWidget = seperateDivAndScript(data["tasteWidget"])
                    document.getElementById("anchor_nutrition_widget")?.appendChild(divAndScriptNutritionWidget[0]);
                    document.getElementById("anchor_nutrition_widget")?.appendChild(divAndScriptNutritionWidget[1]);
                    document.getElementById("anchor_taste_widget")?.appendChild(divAndScriptTasteWidget[0]);
                    document.getElementById("anchor_taste_widget")?.appendChild(divAndScriptTasteWidget[1]);
                    document.getElementById("overlay")?.setAttribute("style", "display:none");
                    document.getElementById("anchor_nutrition_widget")?.setAttribute("style", "display:block");
                    document.getElementById("backButton")?.setAttribute("style", "display:block");
                }, 0);
            }
        })["catch"](function (error: { error: string; errorText: string }) {
        showToastErrorMessage("error_toast", "error_text", error.errorText);
    });
}

function seperateDivAndScript(elementsString: string){
    let substring_div_end = elementsString.search(/<script>/);
    let substring = elementsString.substring(0, substring_div_end)
    let substring_div = document.createElement("div")
    substring_div.innerHTML = substring;

    let substring_script_end = elementsString.search(/<\/script>/);
    substring = elementsString.substring(substring_div_end + "<script>".length, substring_script_end)
    if(substring.includes("fontSize:20") && substring.includes("rgb(75,192,192")){
        substring = substring.replaceAll("rgb(75,192,192", "rgb(38,159,202")
        substring = substring.replace("fontSize:20}", "fontSize:30, fontStyle: \"bold\"}, gridLines:{color:'black'}")
    }
    let substring_script = document.createElement("script")
    substring_script.innerHTML = substring;
    return [substring_div, substring_script]
}

export function incrementCurrentMealNr(userId: number, meal_type_nr: number) {
    fetch("recipes.php", {
        method: "POST",
        body: JSON.stringify({ userId: userId, meal_type_nr: meal_type_nr, function_name: "increment_current_meal_nr" }),
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
                if (data["result"]) {
                    getRecipesByUserId(userId);
                }
                else {
                    showToastErrorMessage("error_toast", "error_text", "Current meal nr wasn't increased. Can't load next meal");
                }
            }
        })["catch"](function (error: { error: string; errorText: string }) {
        showToastErrorMessage("error_toast", "error_text", error.errorText);
    });
}

export function changeWebsiteToPrintShoppingList(meal_type: string) {
    localStorage.setItem("meal_type", meal_type);
    window.location.href = "./print_shopping_list.php";
}

export function printShoppingList(userId: number) {
    const meal_id = localStorage.getItem(localStorage.getItem("meal_type") + "_id");

    fetch("recipes.php", {
        method: "POST",
        body: JSON.stringify({userId: userId, meal_id: meal_id, function_name: "print_shopping_list"}),
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
                data = data["result"];
                document.getElementById("title_id").textContent = data.Title;
                createShoppingList(data, "UsedIngredients");
                createShoppingList(data, "MissedIngredients");
                window.print();
            }
        })
        ["catch"](function (error: { error: string; errorText: string }) {
        showToastErrorMessage("error_toast", "error_text", error.errorText);
    });
}

export function changeWebsiteToRecipeCard(meal_type: string) {
    localStorage.setItem("meal_type", meal_type);
    window.location.href = "./recipe_card.html";
}

export function recipeCard() {
    const meal_id = localStorage.getItem(localStorage.getItem("meal_type") + "_id");

    fetch("recipes.php", {
        method: "POST",
        body: JSON.stringify({ meal_id: meal_id, function_name: "get_recipe_card" }),
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
                const image = document.createElement("img");
                image.src = data["result"];
                document.getElementById("anchor")?.appendChild(image);
                document.getElementById("overlay")?.setAttribute("style", "display:none");
                document.getElementById("anchor")?.setAttribute("style", "display:block");
                document.getElementById("backButton")?.setAttribute("style", "display:block");
            }
        })["catch"](function (error: { error: string; errorText: string }) {
        showToastErrorMessage("error_toast", "error_text", error.errorText);
    });
}