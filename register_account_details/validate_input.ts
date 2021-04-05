import {showToastErrorMessage, showToastMessage} from "../shared/js/shared_functions.js";
import {registerUser} from "./register_user";

function validateInput(): boolean {
  let email = (document.getElementById("email_input") as HTMLInputElement).value;
  let username = (document.getElementById("username_input") as HTMLInputElement).value;

  checkDuplicatesEmail(email);
  checkDuplicatesUsername(username);
  registerUser();
  setTimeout(() => checkRegistrationSuccess(), 100);
  return false;
}

function checkRegistrationSuccess(): void {
  if (window.localStorage["email_success"] == "true" && window.localStorage["username_success"] == "true") {
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
        showToastErrorMessage("error_toast", data.errorText);
      } else {
        localStorage.setItem("email_success", "true");
      }
    })
    ["catch"](function (error) {
    showToastErrorMessage("error_toast", error.errorText);
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
        showToastErrorMessage("error_toast", data.errorText);
      } else {
        localStorage.setItem("username_success", "true");
      }
    })
    ["catch"](function (error) {
    showToastErrorMessage("error_toast", error.errorText);
    });
}
