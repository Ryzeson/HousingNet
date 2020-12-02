<?php

$host="ada.cc.gettysburg.edu";
$dbase="f20_2";
$user="marary01";
$pass="marary01";

try {
	$db = new PDO("mysql:host=$host;dbname=$dbase", $user, $pass);
}

catch(PDOException $e) {
	die("ERROR connecting to MYSQL database " . $e->getMessage());
}

?>
