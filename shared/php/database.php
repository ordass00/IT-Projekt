<?php
include "config.php";
include "input.php";

function connect_server()
{
  try {
    $conn = new PDO(DB_DSN_S, DB_USER_S, DB_PASS_S);
    return $conn;
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function connect_local()
{
  try {
    $conn = new PDO(DB_DSN_L, DB_USER_L, DB_PASS_L);
    return $conn;
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function get_user_by_mail($conn, $email)
{
  if ($conn == null || $email == null) {
    return null;
  }
  $email = validate_input($email);
  //Preventing Sql-Injection with prepared statements
  $sql = "select * from User where EMail = ?;";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(1, $email);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function get_user_by_username($conn, $username)
{
  if ($conn == null || $username == null) {
    return null;
  }
  $username = validate_input($username);
  //Preventing Sql-Injection with prepared statements
  $sql = "select * from User where Username = ?;";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(1, $username);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function set_user($conn, $firstName, $lastName, $dateOfBirth, $gender, $username, $password, $email)
{
  if ($firstName == null || $lastName == null || $dateOfBirth == null || $gender == null || $password == null || $email == null || $username == null) {
    return false;
  }
  $password = password_hash($password, PASSWORD_BCRYPT);
  $firstName = validate_input($firstName);
  $lastName = validate_input($lastName);
  $dateOfBirth = validate_input($dateOfBirth);
  $gender = validate_input($gender);
  $email = validate_input($email);
  $username = validate_input($username);

  //Checking for duplicates
  if (get_user_by_mail(connect_local(), $email)) {
    return false;
  }
  if (get_user_by_username(connect_local(), $username)) {
    return false;
  }

  //Preventing Sql-Injection with prepared statements
  $sql = "insert into User (FirstName, LastName, Username, Gender, Password, EMail, DateOfBirth)
  values (:firstName, :lastName, :username, :gender, :password, :EMail, :dateOfBirth);";
  $stmt = $conn->prepare($sql);
  $result = $stmt->execute(array(
    ":firstName" => $firstName, ":lastName" => $lastName, ":username" => $username, ":gender" => $gender,
    ":password" => $password, ":EMail" => $email, ":dateOfBirth" => $dateOfBirth
  ));
  if (!$result) {
    return false;
  }
  return true;
}

function get_preferences_by_user_id($conn, $user_id)
{
  $sql = "SELECT * from preferences WHERE user_id= ?";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(1, $user_id);
  $stmt->execute();
  if ($stmt->rowCount() == 1) {
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  } else {
    return false;
  }
}

function insert_preferences($conn, $intolerances, $diet_type, $calories, $user_id){
  $sql = "INSERT INTO preferences(intolerances, DietType, Calories, User_ID) VALUES (:intolerances, :diettype, :calories, :userid)";
  $statement = $conn->prepare($sql);
  $statement->execute(["intolerances" => $intolerances, "diettype" => $diet_type, "calories" => $calories, "userid" => $user_id]);
}