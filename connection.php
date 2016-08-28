<?php

$hostname = "localhost";
$user = "root";
$pass = "coderslab";
$database = "pseudotwitt";

$conn = new mysqli($hostname, $user, $pass, $database);

$conn->set_charset('utf8');

if($conn->connect_error) {
    die('Connect error:'.$conn->connect_error);
}
