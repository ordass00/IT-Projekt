<?php
require_once("../shared/php/database.php");

session_start();
$conn = connect_local();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["userid"];
    $diet_type = $_POST["state"];
    $calories = $_POST["calories"];
    $intolerances = "";
    if(isset($_POST["intolerances"]) and !empty($_POST["intolerances"])){
        $checkbox = $_POST["intolerances"];
        foreach ($checkbox as $chk) {
            $intolerances .= $chk . ", ";
        }
        $intolerances = rtrim($intolerances, ", ");
    }
    $sql = "SELECT COUNT(*) from preferences WHERE User_ID = :userid";
    $statement = $conn->prepare($sql);
    $statement->execute(array(":userid" => $user_id));
    if ($statement->fetchColumn()) {
        header("location: save_preferences.php?duplicate=true");
    } else {
        insert_preferences($conn, $intolerances, $diet_type, $calories, $user_id);
        //To Do: needs to point to main page after saving the preferences
        header("location: welcome.php");
    }
}
