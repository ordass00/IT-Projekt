function register_user() {
    var firstname = document.getElementById("firstname_input").value;
    var lastname = document.getElementById("lastname_input").value;
    var gender = document.getElementById("sex_input").value;
    var date_of_birth = document.getElementById("date_of_birth_input").value;
    window.localStorage["firstName"] = firstname;
    window.localStorage["lastName"] = lastname;
    window.localStorage["gender"] = gender;
    window.localStorage["date_of_birth"] = date_of_birth;
}
