function register_user():void{
    let firstname: string = (document.getElementById("firstname_input") as HTMLInputElement).value;
    let lastname: string = (document.getElementById("lastname_input") as HTMLInputElement).value;
    let gender : string = (document.getElementById("sex_input") as HTMLInputElement).value;
    let date_of_birth: string = (document.getElementById("date_of_birth_input") as HTMLInputElement).value;

    window.localStorage["firstName"] = firstname;
    window.localStorage["lastName"] = lastname;
    window.localStorage["gender"] = gender;
    window.localStorage["date_of_birth"] = date_of_birth;
}