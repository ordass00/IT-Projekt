function registerUser(): void {
  let email: string = (document.getElementById(
    "email_input"
  ) as HTMLInputElement).value;
  let username: string = (document.getElementById(
    "username_input"
  ) as HTMLInputElement).value;
  let password: string = (document.getElementById(
    "password_input"
  ) as HTMLInputElement).value;

  let gender: string = window.localStorage["gender"];
  let firstName: string = window.localStorage["firstName"];
  let lastName: string = window.localStorage["lastName"];
  let dateOfBirth: Date = window.localStorage["dateOfBirth"];

  setUser(firstName, lastName, dateOfBirth, gender, username, email, password);
}
function setUser(
  firstName: string,
  lastName: string,
  dateOfBirth: Date,
  gender: string,
  username: string,
  email: string,
  password: string
): void {
  let reqObj = {
    method: "register_user",
    firstName: firstName,
    lastName: lastName,
    dateOfBirth: dateOfBirth,
    gender: gender,
    username: username,
    email: email,
    password: password,
  };

  fetch("../php/register_account_details/register_account_details.php", {
    method: "POST",
    body: JSON.stringify(reqObj),
  })
    .then(function (response: Response) {
      if (response.ok) {
        return response.json();
      }
      throw new Error("Error in response. (register_user)");
    })
    .then(function (data: any) {
      if (data.error) {
        let toastHTMLElement = document.getElementById("error_toast");
        document.getElementById("error_text").textContent = data.errorText;
        let toastElement = new bootstrap.Toast(toastHTMLElement);
        toastElement.show();
      }
    })
    ["catch"](function (error: { error: string; errorText: string }) {
      let toastHTMLElement = document.getElementById("error_toast");
      document.getElementById("error_text").textContent = error.errorText;
      let toastElement = new bootstrap.Toast(toastHTMLElement);
      toastElement.show();
    });
}