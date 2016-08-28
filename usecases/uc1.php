<?php

require_once('../src/user.php');
require_once('../connection.php');

$user1 = new User();

$user1->setUsername("Kuba");
$user1->setEmail("Kuba@kuba.org");
$user1->setPassword("KubaKuba");

var_dump($user1->saveToDB($conn));

$conn->close();
$conn = NULL;