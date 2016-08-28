<?php 
session_start();
?>


<?php
require_once('src/user.php');
require_once('connection.php');


if($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(isset($_POST['email']) && strlen(trim($_POST['email'])) > 0 && isset($_POST['password']) && strlen(trim($_POST['password'])) > 5) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    $user = User::login($conn, $email, $password);
    
    if ($user) {
      $_SESSION['userId'] = $user->getId();
    } else {
    die('Nie udało się zalogować!');
      }
  }
}
?>

<html>
  <head>
    <title>Pseudotwitt : strona logowania</title>
    <meta charset="utf-8">
  </head>
  <body>
    <form method="POST">
      <input name="email" placeholder="email">
      <input name="password" type="password" placeholder="pass">
      <input type="submit">
    </form>
  </body>
</html>