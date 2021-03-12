function hide_alert(event): void {
	event.target.parentNode.parentNode.setAttribute("style", "visibility: hidden !important;");
	event.target.previousElementSibling.innerHTML = "";
}

function validate_fields() {
	let email: string = (document.getElementById("email_input") as HTMLInputElement).value;
	let username: string = (document.getElementById("username_input") as HTMLInputElement).value;
	let password: string = (document.getElementById("password_input") as HTMLInputElement).value;

	if (password == "" || username == "" || email == "") {
		let alerts_text: HTMLCollectionOf < Element > = document.getElementsByClassName("alert_text");

		for (let i: number = 0; i < alerts_text.length; i++) {
			if (alerts_text[i].innerHTML == "") {
				alerts_text[i].innerHTML = "All fields need to be filled out by you.";
				alerts_text[i].parentElement.parentElement.setAttribute("style", "visibility: visible !important;")
				break;
			}
		}
	} else {
		check_duplicates_email(email);
		check_duplicates_username(username);
	}
}

function check_duplicates_email(email: string): void {
	let reqObj: {
		method: string,
		email: string
	} = {
		method: "check_duplicates_email",
		email: email
	};
	fetch("../php/register_account_details/register_account_details.php", {
			method: "POST",
			body: JSON.stringify(reqObj)
		})
		.then(function(response: Response) {
			if (response.ok) {
				return response.json();
			}
			throw new Error("Error in response. (check_duplicates_email)");
		})
		.then(function(data: {
			error: string,
			duplicate: boolean
		}) {
			if (data.duplicate) {
				let alerts_text = document.getElementsByClassName("alert_text");

				for (let i: number = 0; i < alerts_text.length; i++) {
					if (alerts_text[i].innerHTML == "") {
						alerts_text[i].innerHTML = "The E-Mail you have entered is already registered.";
						alerts_text[i].parentElement.parentElement.setAttribute("style", "visibility: visible !important;")
						break;
					}
				}
			}
		})["catch"](function(error) {
			console.log({
				error: true,
				duplicate: null,
				errorText: error
			});
		});
}

function check_duplicates_username(username: string): void {
	let reqObj: {
		method: string,
		username: string
	} = {
		method: "check_duplicates_username",
		username: username
	};
	fetch("../php/register_account_details/register_account_details.php", {
			method: "POST",
			body: JSON.stringify(reqObj)
		})
		.then(function(response: Response) {
			if (response.ok) {
				return response.json();
			}
			throw new Error("Error in response. (check_duplicates_username)");
		})
		.then(function(data: {
			error: string,
			duplicate: boolean
		}) {
			if (data.duplicate) {
				let alerts_text = document.getElementsByClassName("alert_text");

				for (let i = 0; i < alerts_text.length; i++) {
					if (alerts_text[i].innerHTML == "") {
						alerts_text[i].innerHTML = "The Username you have entered is already taken.";
						alerts_text[i].parentElement.parentElement.setAttribute("style", "visibility: visible !important;")
						break;
					}
				}
			}
		})["catch"](function(error) {
			console.log({
				error: true,
				duplicate: null,
				errorText: error
			});
		});
}

function register_user(firstName: string, lastName: string, dateOfBirth: Date, username: string, email: string, password: string): void {
	if (firstName == "" || lastName == "" || dateOfBirth == null || username == "" || email == "" || password == "") {
		console.log("Input parameter(s) is/are missing");
		return;
	}

	let reqObj: {
		method: string,
		firstName: string,
		lastName: string,
		dateOfBirth: Date,
		username: string,
		email: string,
		password: string
	} = {
		method: "register_user",
		firstName: firstName,
		lastName: lastName,
		dateOfBirth: dateOfBirth,
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