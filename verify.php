<?php

//verify.php
//Ryzeson Maravich
//removes the user from the unverified database after they click the verify link

include_once("../db_connect.php"); //this is needed to acces $db (?)
include("hw4utils.php");

$userlogin = $_GET['login'];

$verified = verifyEmail($db, $userlogin);

if ($verified == TRUE) {
	print("<H2>Successfully verfied, you can now <a href='login.html'>login</a></H2>");
}
else {
	print("<H2>Unable to verify email</H2>");
}
?>
