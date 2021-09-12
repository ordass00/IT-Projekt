<?php
require_once("../shared/php/database.php");

function try_to_login()
{
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        session_destroy();
        //To Do: needs to point to main page after login
        //header("location: welcome.php");
        exit;
    }
    $conn = connect_local_or_server();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "SELECT id, firstname, lastname, username, email, dateofbirth, password FROM user WHERE email= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $_POST["email"]);
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                if ($row = $stmt->fetch()) {
                    $user_id = $row["id"];
                    $hashed_password = $row["password"];
                    $password = $_POST["password"];
                    if (password_verify($password, $hashed_password)) {
                        $_SESSION["loggedin"] = true;
                        $_SESSION["userid"] = $user_id;
                        $_SESSION["firstname"] = $row["firstname"];
                        $_SESSION["lastname"] = $row["lastname"];
                        $_SESSION["username"] = $row["username"];
                        $_SESSION["email"] = $row["email"];
                        $_SESSION["dateofbirth"] = $row["dateofbirth"];
                        $preferences = get_preferences_by_user_id($conn, $user_id);
                        if ($preferences == false) {
                            header("location: ../save_preferences/save_preferences.php");
                        } else {
                            $_SESSION["intolerances"] = $preferences["Intolerances"];
                            $_SESSION["diettype"] = $preferences["DietType"];
                            $_SESSION["calories"] = $preferences["Calories"];
                            //TODO redirect to user overview. At the moment it will redirect to meal_plan_overview
                            header("location: ../meal_plan_overview/meal_plan_overview.php");
                        }
                    } else {
                        $_POST["login_err"] = "Invalid email or password.";
                    }
                }
            } else {
                $_POST["login_err"] = "Invalid email or password.";
            }
        } else {
            echo "Something went wrong. Please try again later.";
        }
        unset($stmt);
    }
    unset($conn);
}
