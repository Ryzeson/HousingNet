<?php

//hw4utils.php
//Ryzeson Maravich
//utility class for login/signup fucntionality

// returns 1 if (1) the user exists, (2) user's email is verified, and (3) the given password's hash matches the hash stored in user table
// return -1 if user does not exist in user table
// return -2 if user exist in user table but is also in unverified table
// return -3 if the user exists in user table but the password hash does not match
function checkUser($db, $login, $pass) {
	//check if user exists
	$qLogin = $db->query("SELECT login FROM user WHERE login='$login';");
	if ($qLogin == FALSE) {
		print("<H2>Sorry, something went wrong</H2>");
	}
	if($qLogin->rowCount() == 1) {
		//see if the user is verified
		$qResUnverified = $db->query("SELECT ulogin FROM unverified WHERE ulogin='$login';");
		if ($qResUnverified == FALSE) {
			print("<H2>Sorry, something went wrong</H2>");
		}
		if ($qResUnverified->rowCount() == 1) {
			return -2;
		}

		//get all logins with that password
		$passHash = md5($pass);
		$qPass = $db->query("SELECT login FROM user WHERE passHash='$passHash' AND login='$login';");
		if ($qPass == FALSE) {
			print("<H2>Sorry, something went wrong</H2>");
		}
		//if there is one row, then correct password was entered
		while ($qPass->rowCount() == 1) {
			return 1;
		}
		return -3;
	}
	return -1;
}

// adds a new user to user table and user's login to unverified table
function addUser($db, $login, $pass, $bdate, $email) {
	$passHash = md5($pass);
	$q1 = "INSERT INTO user VALUE('$login', '$passHash', '$bdate', '$email');";
	$q1Res = $db->query($q1);
	//printf("query 1 = %s\n", $q1);

	$q2 = "INSERT INTO unverified VALUE('$login');";
	$q2Res = $db->query($q2);
	//printf("query 2 = %s\n", $q2);

	if($q1 == FALSE || $q2 == FALSE) {
		print("<H2>Sorry, something went wrong</H2>");
	}
}

// a) checks if this user exists in user table already, if yes, return False
// b) if not a user yet, call addUser function to add to user and unverified tables
// c) compose a link (verify.php?uid=) and email the link to user with appropraite message
// d) return false
function registerUser ($db, $input) {
	//if the user already exists, return false
	$login = $input['login'];
	$pass = $input['pass'];
	$bdate = $input['bdate'];
	$email = $input['email'];

	$sameUser = $db->query("SELECT login FROM user WHERE login='$login';");
	if($sameUser == FALSE) {
		print("<H2>Sorry, something went wrong</H2>");
	}
	if($sameUser->rowCount() == 1) {
		return FALSE;
	}

	//add user
	addUser($db, $login, $pass, $bdate, $email);

	//email verification link
	//tags were showing up in this version:
	//$link = "<a href='http://www.cs.gettysburg.edu/~marary01/cs360/hw4/verify.php?login=$login'>Click here to verify your email.</a>";
	$link = "Click here to verify your account: http://www.cs.gettysburg.edu/~marary01/cs360/hw4/verify.php?login=$login";
	mail($email, "Verification email", $link);
	return true;
}

// remove the given login from unverified table if it exists and return true. Return false if it did not exist in the table
function verifyEmail($db, $userlogin) {
	$q1 = ("SELECT ulogin FROM unverified WHERE ulogin='$userlogin'");
	$qRes = $db->query($q1);
	if($qRes == FALSE) {
		print("<H2>Sorry, something went wrong</H2>");
	}
	if ($qRes->rowCount() == 1) {
		$rem = ("DELETE FROM unverified WHERE ulogin='$userlogin'");
		$remRes = $db->query($rem);
		if($qRes == FALSE) {
			print("<H2>Sorry, something went wrong</H2>");
		}
		return TRUE;
	}
	return FALSE;
}
?>
