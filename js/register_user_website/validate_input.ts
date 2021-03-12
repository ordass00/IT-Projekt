function validateInput(): boolean {
  let email = (document.getElementById("email_input") as HTMLInputElement)
    .value;
  let username = (document.getElementById("username_input") as HTMLInputElement)
    .value;

  checkDuplicatesEmail(email);
  checkDuplicatesUsername(username);
  registerUser();
  setTimeout(() => checkRegistrationSuccess(), 100);
  return false;
}
function showHidePwd(): void {
  var passwordElement = document.getElementById(
    "password_input"
  ) as HTMLInputElement;
  if (passwordElement.type === "password") {
    passwordElement.type = "text";
  } else {
    passwordElement.type = "password";
  }
}
function checkRegistrationSuccess(): void {
  if (window.localStorage["email_success"] == "true" && window.localStorage["username_success"] == "true") {
    localStorage.setItem("registered", "true")
    window.location.href = "../php/login.php";
  }
}
function checkDuplicatesEmail(email: string): void {
  localStorage.setItem("email_success", "false");
  let reqObj = {
    method: "check_duplicates_email",
    email: email,
  };
  fetch("../php/register_account_details/register_account_details.php", {
    method: "POST",
    body: JSON.stringify(reqObj),
  })
    .then(function (response: Response) {
      if (response.ok) {
        return response.json();
      }
      throw new Error("Error in response. (check_duplicates_email)");
    })
    .then(function (data: { error: string; errorText: string }) {
      if (data.errorText == "The email is already registered.") {
        let toastHTMLElement = document.getElementById("email_duplicate_toast");
        let toastElement = new bootstrap.Toast(toastHTMLElement);
        toastElement.show();
      } else if (data.error) {
        let toastHTMLElement = document.getElementById("error_toast");
        document.getElementById("error_text").textContent = data.errorText;
        let toastElement = new bootstrap.Toast(toastHTMLElement);
        toastElement.show();
      } else {
        localStorage.setItem("email_success", "true");
      }
    })
    ["catch"](function (error) {
      let toastHTMLElement = document.getElementById("error_toast");
      document.getElementById("error_text").textContent = error.errorText;
      let toastElement = new bootstrap.Toast(toastHTMLElement);
      toastElement.show();
    });
}
function checkDuplicatesUsername(username: string): void {
  localStorage.setItem("username_success", "false");
  let reqObj = {
    method: "check_duplicates_username",
    username: username,
  };
  fetch("../php/register_account_details/register_account_details.php", {
    method: "POST",
    body: JSON.stringify(reqObj),
  })
    .then(function (response: Response) {
      if (response.ok) {
        return response.json();
      }
      throw new Error("Error in response. (check_duplicates_username)");
    })
    .then(function (data: { error: string; errorText: string }) {
      if (data.errorText == "The username is already registered.") {
        let toastHTMLElement = document.getElementById(
          "username_duplicate_toast"
        );
        let toastElement = new bootstrap.Toast(toastHTMLElement);
        toastElement.show();
      } else if (data.error) {
        let toastHTMLElement = document.getElementById("error_toast");
        document.getElementById("error_text").textContent = data.errorText;
        let toastElement = new bootstrap.Toast(toastHTMLElement);
        toastElement.show();
      } else {
        localStorage.setItem("username_success", "true");
      }
    })
    ["catch"](function (error) {
      let toastHTMLElement = document.getElementById("error_toast");
      document.getElementById("error_text").textContent = error.errorText;
      let toastElement = new bootstrap.Toast(toastHTMLElement);
      toastElement.show();
    });
}
