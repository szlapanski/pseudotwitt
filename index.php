<?php 
session_start();
if (!$_SESSION['userId']) {
  header("Location: login.php");
  die();
}

?>

<html>
  <head>
    <title>Pseudotwitt : strona główna</title>
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