<?php

class User {
  private $id;
  private $username;
  private $hashedpassword;
  private $email;
  
  public function __construct() {
    $this->id = -1;
    $this->username = '';
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
    } else {
      $sql = "UPDATE Users SET username='$this->username',
        email='$this->email',
        hashed_password='$this->hashedPassword'
        WHERE id=$this->id";
        $result = $connection->query($sql);
        if($result == true){
          return true;
        }
    }
  return false;
  }
  
  static public function loadUserById(mysqli $connection, $id) {
    $query = "SELECT * FROM Users WHERE id=" . $connection->real_escape_string($id);
    
    $res = $connection->query($query);
  
    if($res && $res->num_rows == 1) {
      $row = $res->fetch_assoc();
      $user = new User();
      $user->id = $row['id'];
      $user->setUsername($row['username']);
      $user->setEmail($row['email']);
      $user->hashedpassword = $row['hashed_password'];
      
      return $user;
    }
    return NULL;
  }
  
  static public function loadUserByEmail(mysqli $connection, $email) {
    $query = "SELECT * FROM Users WHERE email='" . $connection->real_escape_string($email) . "'";
    
    $res = $connection->query($query);
  
    if($res && $res->num_rows == 1) {
      $row = $res->fetch_assoc();
      $user = new User();
      $user->id = $row['id'];
      $user->setUsername($row['username']);
      $user->setEmail($row['email']);
      $user->hashedpassword = $row['hashed_password'];
      
      return $user;
    }
    return NULL;
  }

  static public function login(mysqli $connection, $email, $password) {
    
    $user = self::loadUserByEmail($connection, $email);
    
    if ($user) {
      if (password_verify($password, $user->hashedpassword)) {
        return $user;
      }
    }
    return false; 
  }
  
  static public function loadAllUsers(mysqli $connection){
    $sql = "SELECT * FROM Users";
    $ret = [];
    $result = $connection->query($sql);
    if($result == true && $result->num_rows != 0){
      foreach($result as $row){
      $loadedUser = new User();
      $loadedUser->id = $row['id'];
      $loadedUser->username = $row['username'];
      $loadedUser->hashedPassword = $row['hashed_password'];
      $loadedUser->email = $row['email'];
      $ret[] = $loadedUser;
    }
    }
  return $ret;
  }
  
  public function delete(mysqli $connection){
    if($this->id != -1){
      $sql = "DELETE FROM Users WHERE id=$this->id";
      $result = $connection->query($sql);
      if($result == true){
        $this->id = -1;
        return true;
        }
      return false;
      }
    return true;
    }
}