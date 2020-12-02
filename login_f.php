<?php

//login_f.php
//Ryzeson Maravich
//logs the user in if they have a verified account
//from hw4, will need changed for project
session_start();
include_once("../db_connect.php");
include("hw4utils.php");

$login = $_POST['login'];
$pass = $_POST['pass'];


//$userType = $_GET['user']; //this would change depending on which form from login the user selected, for now we can select which
$userType = "stud";

//$resCheckUser = checkUser($db, $login, $pass); //would actually need to change hw4 to correspond with our project
$resCheckUser = 1;

if ($resCheckUser == 1) {
	$_SESSION['login'] = $login; //we would get this from the login page, if it were implemented, for now we will just set it to custge01
	//$_SESSION['login'] = "custge01"; //swtich this and line above if you want to work with one person

	/* //tests to see if sesssion is working properly
	$isSet = isset($_SESSION['login']);
	if ($isSet == TRUE) {
		print("It is set");
	}
	else {
		print("It is not set");
	}
	print("<H2>Successfully logged in!</H2>");
	*/
	if ($userType == "stud") {
		header("Location:stud_home.php");
	}
	else {
		header("Location:admin_search.php");
	}
}

if ($resCheckUser ==  -1) {
	print("<H2>Login not recognized, please <a href='login.html'>try again</a> or <a href='signup.html'>sign up</a></H2>");
}

if ($resCheckUser == -2) {
	print("<H2>First check your email to verify your account, then <a href='login.html'>login</a> again</H2>");
}

if ($resCheckUser == -3) {
	print("<H2>Incorrect password, please <a href='login.html'> try again </a></H2>");
}

?>
