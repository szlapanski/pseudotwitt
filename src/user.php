<?php

class User {
  private $id;
  private $username;
  private $hashedpassword;
  private $email;
  
  public function __construct() {
    $this->id = -1;
    $this->name = '';
    $this->email = '';
    $this->hashedpassword = '';
  }
  
  public function setPassword($newPassword) {
  if (is_string($newPassword) && strlen(trim($newPassword)) > 5) {  
    $newHashedPassword = password_hash($newPassword,PASSWORD_DEFAULT);
    $this->hashedPassword = $newHashedPassword;
    }
  }
  public function setUsername($name) {
  if (is_string($name) && strlen(trim($name)) > 0) {
    $this->username = $name;
    } else {
    $this->username = 'undefined';
    }
  }
  
  public function setEmail($email) {
  if (is_string($email) && strlen(trim($email)) > 0) {
    $this->email = $email;
    } else {
    $this->email = 'undefined';
    }
  }
  
  public function getId() {
    return $this->id;
  }
  
  public function getEmail() {
    return $this->email;
  }
  
  public function getUsername(){
    return $this->username;
  }
  
  public function saveToDB(mysqli $connection){
    if($this->id == -1){
      //Saving new user to DB
      $sql = "INSERT INTO Users(username, email, hashed_password)
      VALUES ('$this->username', '$this->email', '$this->hashedPassword')";
      $result = $connection->query($sql);
        if($result == true){
        $this->id = $connection->insert_id;
        return true;
        }
    }
  return false;
  }
  
}