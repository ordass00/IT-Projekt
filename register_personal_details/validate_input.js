"use strict";
function register_user() {
    let firstname = document.getElementById("firstname_input").value;
    let lastname = document.getElementById("lastname_input").value;
    let gender = document.getElementById("sex_input").value;
    let date_of_birth = document.getElementById("date_of_birth_input").value;
    window.localStorage["firstName"] = firstname;
    window.localStorage["lastName"] = lastname;
    window.localStorage["gender"] = gender;
    window.localStorage["dateOfBirth"] = date_of_birth;
}
