<?php
include_once "config.php";
include_once "input.php";

function connect_server()
{
  try {
    return new PDO(DB_DSN_S, DB_USER_S, DB_PASS_S);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

function connect_local()
{
  try {
    return new PDO(DB_DSN_L, DB_USER_L, DB_PASS_L);
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
  return $stmt->fetch(PDO::FETCH_ASSOC);
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
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_user_by_user_id($conn, $user_id)
{
    if ($conn == null || $user_id == null) {
        return null;
    }
    $sql = "select * from User where ID = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $user_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
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
    if ($conn == null || $user_id == null) {
        return null;
    }
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

function set_ingredients($conn, $ingredients, $user_id){
  $ingredients = validate_input($ingredients);
  $ingredients = str_replace("&quot;", '"', $ingredients);
  $sql = "insert into Ingredients(IngredientsAtHome, User_ID) values (:ingredients, :user_id);";
  $stmt = $conn->prepare($sql);
  return $stmt->execute(array(":ingredients" => $ingredients, ":user_id" => $user_id));
}

function set_password_reset($conn, $user_id, $password_reset){
  $sql = "update User set PasswordReset = ? where ID = ?;";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(1, $password_reset);
  $stmt->bindParam(2, $user_id);
  return $stmt->execute();
}

function get_password_reset($conn, $user_id){
  $sql = "select PasswordReset from User where ID = ?;";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(1, $user_id);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

function reset_password($conn, $user_id, $new_password){
  $sql = "update User set Password = ? where ID = ?;";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(1, $new_password);
  $stmt->bindParam(2, $user_id);
  return $stmt->execute();
}

function clear_password_reset($conn, $user_id){
  $sql = "update User set PasswordReset = null where ID = ?;";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(1, $user_id);
  return $stmt->execute();
}

function change_username($conn, $user_id, $new_username)
{
  if ($conn == null || $user_id == null || $new_username == null) {
    return null;
  }
  $sql = "UPDATE user SET Username=? WHERE ID=?;";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(1, $new_username);
  $stmt->bindParam(2, $user_id);
  return  $stmt->execute();
}

function change_user_information($conn, $user_id, $new_firstname, $new_lastname, $new_username, $new_email, $new_date_of_birth){
    if ($conn == null || $user_id == null || $new_firstname == null || $new_lastname == null || $new_username == null || $new_email == null || $new_date_of_birth == null){
        return null;
    }
    $sql = "UPDATE user SET FirstName = :FirstName, LastName = :LastName, Username = :Username, EMail = :EMail, DateOfBirth = :DateOfBirth  WHERE ID = :ID;";
    $stmt = $conn->prepare($sql);
    return $stmt->execute(["FirstName" => $new_firstname, "LastName" => $new_lastname, "Username" => $new_username, "EMail" => $new_email, "DateOfBirth" => $new_date_of_birth, "ID" => $user_id]);
}

function change_preferences($conn, $user_id, $diet_type, $intolerances, $calories){
    if ($conn == null || $user_id == null || $diet_type == null || $intolerances == null || $calories == null){
        return null;
    }
    $sql = "UPDATE preferences SET DietType = :DietType, intolerances = :intolerances, Calories = :Calories WHERE User_ID = :User_ID;";
    $stmt = $conn->prepare($sql);
    return $stmt->execute(["DietType" => $diet_type, "intolerances" => $intolerances, "Calories" => $calories, "User_ID" => $user_id]);
}

function change_ingredients($conn, $ingredients, $user_id){
    $ingredients = validate_input($ingredients);
    $ingredients = str_replace("&quot;", '"', $ingredients);
    $sql = "UPDATE ingredients SET IngredientsAtHome = :IngredientsAtHome WHERE User_ID = :User_ID;";
    $stmt = $conn->prepare($sql);
    return $stmt->execute(["IngredientsAtHome" => $ingredients, "User_ID" => $user_id]);
}