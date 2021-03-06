<?php
include "config.php";
include "input.php";

function connect_server(){
    try{
      $conn = new PDO(DB_DSN_S, DB_USER_S, DB_PASS_S);
      return $conn;
    }
    catch(PDOException $e){
      echo $e->getMessage();
    }
}

function connect_local(){
    try{
      $conn = new PDO(DB_DSN_L, DB_USER_L, DB_PASS_L);
      return $conn;
    }
    catch(PDOException $e){
      echo $e->getMessage();
    }
}

function get_user_by_mail($conn, $email){
  if($conn == null || $email == null){
    echo "Input parameter(s) is/are missing";
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

function set_user($conn, $firstName, $lastName, $dateOfBirth, $gender, $password, $email){
  if($firstName == null || $lastName == null || $dateOfBirth == null || $gender == null || $password == null || $email == null){
    echo "Input parameter(s) is/are missing";
    return false;
  }
  $password = hash("sha256", $password);
  $firstName = validate_input($firstName);
  $lastName = validate_input($lastName);
  $dateOfBirth = validate_input($dateOfBirth);
  $gender = validate_input($gender);
  $email = validate_input($email);
  //Preventing Sql-Injection with prepared statements
  $sql = "insert into User (FirstName, LastName, Gender, Password, EMail, DateOfBirth)
  values (:firstName, :lastName, :gender, :password, :email, :dateOfBirth);";
  $stmt = $conn->prepare($sql);
  $result = $stmt->execute(array(":firstName" => $firstName, ":lastName" => $lastName, ":gender" => $gender, ":password" => $password, "email" => $email, ":dateOfBirth" => $dateOfBirth));
  if(!$result){
    return false;
  }
  return true;
}
?>
