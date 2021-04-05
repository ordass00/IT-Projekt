"use strict";
exports.__esModule = true;
var shared_functions_js_1 = require("../shared/js/shared_functions.js");
function successfullyRegisteredToast() {
    if (window.localStorage["registered"] == "true") {
        shared_functions_js_1.showToastMessage("successfully_registered_toast");
        localStorage.clear();
    }
}
