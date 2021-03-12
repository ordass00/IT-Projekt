function register_user():void{
	if(check_alerts_activated()){
		return;
	}
	let email: string = (document.getElementById("email_input") as HTMLInputElement).value;
	let username: string = (document.getElementById("username_input") as HTMLInputElement).value;
	let password: string = (document.getElementById("password_input") as HTMLInputElement).value;
	let gender:string = window.localStorage["gender"];
	let firstName:string = window.localStorage["firstName"];
	let lastName:string = window.localStorage["lastName"];
	let dateOfBirth:Date = window.localStorage["dateOfBirth"];

	if(gender != "" && firstName != "" && lastName != "" && dateOfBirth != null)
	{
	set_user(firstName, lastName, dateOfBirth, gender, username, email, password);
	}
	else{
		console.log("Not all user details were provided");
		return;
	}
	location.href = "";
}
function set_user(firstName: string, lastName: string, dateOfBirth: Date, gender:string, username: string, email: string, password: string): void {
	if (firstName == "" || lastName == "" || dateOfBirth == null || username == "" || email == "" || password == "") {
		console.log("Input parameter(s) is/are missing");
		return;
	}

	let reqObj: {
		method: string,
		firstName: string,
		lastName: string,
		dateOfBirth: Date,
		gender: string,
		username: string,
		email: string,
		password: string
	} = {
		method: "register_user",
		firstName: firstName,
		lastName: lastName,
		dateOfBirth: dateOfBirth,
		gender: gender,
		username: username,
		email: email,
		password: password
	};

	fetch("../php/register_account_details/register_account_details.php", {
			method: "POST",
			body: JSON.stringify(reqObj)
		})
		.then(function(response: Response) {
			if (response.ok) {
				return response.json();
			}
			throw new Error("Error in response. (register_user)");
		})
		.then(function(data: any) {
			if(data.error){
				console.log({error: data.error, errorText: data.errorText
				});
			}
		})["catch"](function(error: {
			error: string,
			errorText: string
		}) {
			console.log({
				error: true,
				errorText: error
			});
		});
}
function check_alerts_activated():boolean{
	let alerts_text: HTMLCollectionOf < Element > = document.getElementsByClassName("d-flex align-items-center justify-content-center m-2");
	for(let i:number = 0; i<alerts_text.length; i++){
		if((alerts_text[i]as HTMLElement).style.visibility == "visible"){
			return true;
		}
	}
	return false;
}