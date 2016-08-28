<?php 
session_start();

if (isset($_SESSION['userId'])) {
  header("Location: index.php");
  die();
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['password_repeat'])) {
    die('Wypełnij wszystkie pola!');
  }
  elseif(trim($_POST['password_repeat']) != trim($_POST['password'])) {
    die('Hasła się od siebie różnią');
  }
  elseif(strlen(trim($_POST['password']))<5) {
    die('Wybrane hasło jest za krótkie!');
  } else {

    require_once('src/user.php');
    require_once('connection.php');

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $user = new User();
    
    $user->setPassword(trim($_POST['password']));
    $user->setUsername(trim($_POST['name']));
    $user->setEmail(trim($_POST['email']));
    
    if($user->saveToDB($conn)) {
      echo 'Udało się zarejestrować użytkownika!'; 
    } else {
    die('Nie udało się utworzyć użytkownika!');
      }
  }
}
?>

<html>
  <head>
    <title>Pseudotwitt : REJESTRACJA</title>
    <meta charset="utf-8">
  </head>
  <body>
    <form method="POST">
      <input name="name" placeholder="username">
      <input name="email" placeholder="email">
      <input name="password" type="password" placeholder="pass">
      <input name="password_repeat" type="password" placeholder="pass">
      <input type="submit">
    </form>
  </body>
</html>