<?php

require_once('../src/user.php');
require_once('../connection.php');

//$testuser = new User;

//var_dump ($testuser->loadUserById(1));
// to jest źle

var_dump(User::loadUserById($conn, 1));
