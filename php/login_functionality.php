<?php
require_once("database.php");

function try_to_login()
{
    session_start();
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        session_destroy();
        //To Do: needs to point to main page after login
        header("location: welcome.php");
        exit;
    }

    $conn = connect_local();
    $email = $password = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $sql = "SELECT email, password FROM user WHERE email= ? AND password= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $_POST["email"]);
        $stmt->bindParam(2, $_POST["password"]);
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                if ($row = $stmt->fetch()) {
                    $user_id = $row["id"];
                    $email = $row["email"];
                    $username = $row["username"];
                    $hashed_password = $row["password"];
                    //To Do: password is not yet hashed in the db
                    #if(password_verify($password, $hashed_password)){
                    if ($password === $hashed_password) {
                        session_start();
                        $preferences = get_preferences_by_user_id($user_id, $conn);
                        $_SESSION["diettype"] = $preferences[1];
                        $_SESSION["glutenfree"] = $preferences[2];
                        $_SESSION["sugarfree"] = $preferences[3];
                        $_SESSION["calories"] = $preferences[4];
                        $_SESSION["loggedin"] = true;
                        $_SESSION["email"] = $email;
                        $_SESSION["username"] = $username;
                        //To Do: needs to be point to main page after login
                        header("location: welcome.php");
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
