<?php

//signup_f.php
//Ryzeson Maravich
//registers the user into the user and unverified databases
//from hw4, needs changed for project

include_once("../db_connect.php");
include("hw4utils.php");

$login = $_POST['login'];
$pass = $_POST['pass'];
$bdate = $_POST['bdate'];
$email = $_POST['email'];

$resRegister = registerUser($db, $_POST);

if ($resRegister == TRUE) {
	print("<H2>Your account is created, please check your email to verify your account, then <a href=login.html>login</a>\n</H2>");
}
else {
	print("<H2>An account with that username already exists, please <a href=signup.html>try again</a>\n</H2>");
}
?>
