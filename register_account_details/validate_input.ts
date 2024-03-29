import {showToastErrorMessage, showToastMessage} from "../shared/js/shared_functions.js";
import {registerUser} from "./register_user.js";

export function validateInput(): boolean {
  let email = (document.getElementById("email_input") as HTMLInputElement).value;
  let username = (document.getElementById("username_input") as HTMLInputElement).value;
  let password = (document.getElementById("password_input") as HTMLInputElement).value;
  checkDuplicatesEmail(email);
  checkDuplicatesUsername(username);
  checkPassword(password);
  setTimeout(() => checkPasswordValidation(), 500);
  setTimeout(() => checkRegistrationSuccess(), 500);
  return false;
}
function checkPasswordValidation(): void {
  if(window.localStorage["password_success"] == "true"){
    registerUser();
  } else {
    showToastErrorMessage("error_toast", "error_text", "Your password must match the required format.");
  }
}

function checkRegistrationSuccess(): void {
  if (window.localStorage["email_success"] == "true" && window.localStorage["username_success"] == "true"  && window.localStorage["password_success"] == "true") {
    localStorage.setItem("registered", "true")
    window.location.href = "../login/login_form.php";
  }
}

function checkDuplicatesEmail(email: string): void {
  localStorage.setItem("email_success", "false");
  let reqObj = {
    method: "check_duplicates_email",
    email: email,
  };
  fetch("register_account_details.php", {
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
        showToastMessage("email_duplicate_toast");
      } else if (data.error) {
        showToastErrorMessage("error_toast", "error_text", data.errorText);
      } else {
        localStorage.setItem("email_success", "true");
      }
    })
    ["catch"](function (error) {
    showToastErrorMessage("error_toast", "error_text", error.errorText);
    });
}
function checkDuplicatesUsername(username: string): void {
  localStorage.setItem("username_success", "false");
  let reqObj = {
    method: "check_duplicates_username",
    username: username,
  };
  fetch("register_account_details.php", {
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
        showToastMessage("username_duplicate_toast");
      } else if (data.error) {
        showToastErrorMessage("error_toast", "error_text", data.errorText);
      } else {
        localStorage.setItem("username_success", "true");
      }
    })
    ["catch"](function (error) {
    showToastErrorMessage("error_toast", "error_text", error.errorText);
    });
}
function checkPassword(password: string): void {
  localStorage.setItem("password_success", "false");
  let reqObj = {
    method: "change_password",
    password: password,
  };
  fetch("register_account_details.php", {
    method: "POST",
    body: JSON.stringify(reqObj),
  })
      .then(function (response: Response) {
        if (response.ok) {
          return response.json();
        }
        throw new Error("Error in response. (change_password)");
      })
      .then(function (data: any) {
        if (data.error) {
          showToastErrorMessage("error_toast", "error_text", data.errorText);
        }
        else {
          localStorage.setItem("password_success", "true");
        }
      })["catch"](function (error) {
    showToastErrorMessage("error_toast", "error_text", error.errorText);
  });
}