<?php

//projectUtils.php
//Utility class

//outputs the names (and ...) of  students that match the specified search conditions
function search_student($db) {
	//print_r($_POST);
	$qStr = "SELECT fname, mname, lname, login, bname, floor, number FROM student JOIN room ON student.roomid=room.roomid JOIN building ON room.bname=building.name WHERE (";
	$firstAtr = "";
	$atr = "";
	$newGroup = FALSE;
	foreach($_POST as $key => $atrVal) {
		if(($key == "fname" || $key == "lname")  && $atrVal == "") {
			continue;
		}
		$explodedArray = explode("-", $key);
		$currAtr = $explodedArray[0];
		//print($currAtr);
		if ($currAtr != $atr) {
			if ($newGroup == TRUE) {
				$qStr = rtrim($qStr, " OR ");
				$qStr .= ") AND (";
			}
			$atr = $currAtr;
			$newGroup = TRUE;
		}
		if ($atr == "name") {
			$qStr .= "bname='$atrVal' OR ";
		}
		else {
			$qStr .= "$atr='$atrVal' OR ";
		}
	}
	$qStr = rtrim($qStr, " OR");
	$qStr .= ");";
	//print($qStr);
	$qRes = $db->query($qStr);
	$allEmails = "";
	/*
	print("<a href='mailto:$allEmails'>Email all</a>");
	$allEmails .= "marary01@gettysburg.edu, ";
	$allEmails .= "sherwi01@gettysburg.edu, ";
	$allEmails .= "abcdfe02@gettysburg.edu";
	print("<a href='mailto:$allEmails'>Email all</a>");
	*/

	if ($qRes != FALSE) {
		if($qRes->rowCount() == 0) {
			print("<H3>No results matched your search, try picking fewer options.</H3>");
		}
		else {
			print("<TABLE>");
			print("<TH>First name</TH><TH>Middle name</TH><TH>Last name</TH><TH>Building</TH><TH>Floor</TH><TH>Room Number</TH><TH>Email</TH>");
			while ($row = $qRes->fetch()) {
				$fname = $row['fname'];
				$mname = $row['mname'];
				$lname = $row['lname'];
				$bname = $row['bname'];
				$floor = $row['floor'];
				$number = $row['number'];
				$email = $row['login']."@gettysburg.edu";
				$allEmails .= $email.";" ;
				print("<TR>");
				print("<TD>$fname</TD>");
				print("<TD>$mname</TD>");
				print("<TD>$lname</TD>");
				print("<TD>$bname</TD>");
				print("<TD>$floor</TD>");
				print("<TD>$number</TD>");
				print("<TD><a href='mailto:$email'>$email</a></TD>");
				print("</TR>");
			}
		print("</TABLE>");
		print("<br/><a class='email-all button' href='mailto:$allEmails'>Email All</a>");
	}
	return true;
	}
	return false;
}

function search_room($db) {
	//print_r($_POST);
	$qStr = "SELECT bname, floor, number, numstudents, COUNT(student.ssn) AS occupancy, bath, ac FROM room LEFT JOIN student ON room.roomid=student.roomid ";

	$emptyRoom = FALSE;
	$onlyEmptyRoom = TRUE;
	foreach($_POST as $key => $val) {
		//$explodedArray = explode("-", $key);
		//$firstAtr = $explodedArray[0];
		if ($key == "emptyroom") {
			//$qStr .= " LEFT JOIN student ON room.roomid=student.roomid ";
			$emptyRoom = TRUE;
			unset($_POST['emptyroom']); // TODO- manipulating POST is a bad idea, but I can't think of a better way at the moment...
			break;
		}
		$onlyEmptyRoom = FALSE;
	}

	if (!$emptyRoom || !$onlyEmptyRoom) {
		$qStr .= "WHERE (";
	}

	$first = TRUE;
	$atr = "";
	foreach($_POST as $key => $atrVal) {
		$explodedArray = explode("-", $key);
		$currAtr = $explodedArray[0];
		if ($currAtr != $atr) {
			if ($first != TRUE) {
				$qStr = rtrim($qStr, " OR ");
				$qStr .= ") AND (";
			}
			else {
				$first = FALSE;
			}
			$atr = $currAtr;
		}
		if ($atr == "name") {
			$qStr .= "bname='$atrVal' OR ";
		}
		else {
			$qStr .= "$atr='$atrVal' OR ";
		}
	}
	$qStr = rtrim($qStr, " OR");
	if (!$emptyRoom || !$onlyEmptyRoom) {
		$qStr .= ")";
	}
	$qStr .= " GROUP BY room.roomid";
	if ($emptyRoom == TRUE) {
		$qStr .= " HAVING numstudents > COUNT(student.ssn)";
	}
	$qStr .= ";";
	//print($qStr);
	$qRes = $db->query($qStr);

	if ($qRes != FALSE) {
		if($qRes->rowCount() == 0) {
			print("<H3>No results matched your search, try picking fewer options.</H3>");
		}
		else {
			print("<TABLE>");
			print("<TH>Building</TH><TH>Floor</TH><TH>Room Number</TH><TH>Capacity</TH><TH>Occupancy</TH><TH>Bath</TH><TH>Air Conditioning</TH>");
			while ($row = $qRes->fetch()) {
				$bname = $row['bname'];
				$floor = $row['floor'];
				$number = $row['number'];
				$capacity = $row['numstudents'];
				$occupancy = $row['occupancy'];
				$bath = $row['bath'];
				$ac = $row['ac'];
				print("<TR>");
				print("<TD>$bname</TD>");
				print("<TD>$floor</TD>");
				print("<TD>$number</TD>");
				print("<TD>$capacity</TD>");
				print("<TD>$occupancy</TD>");
				if ($bath == 0) {
					print("<TD>No</TD>");
				}
				else {
					print("<TD>Yes</TD>");
				}
				if ($ac == 0) {
					print("<TD>No</TD>");
				}
				else {
					print("<TD>Yes</TD>");
				}
				print("</TR>");
			}
			print("</TABLE>");
			print("<br/>"); //for search again button to be on next line
		}
	return true;
	}
	return false;
}

function search_building($db) {
	$qStr = "SELECT name, type, stnum, stname, kitchen, laundry FROM building WHERE (";

	$first = TRUE;
	$atr = "";
	foreach($_POST as $key => $atrVal) {
		$explodedArray = explode("-", $key);
		$currAtr = $explodedArray[0];
		if ($currAtr != $atr) {
			if ($first != TRUE) {
				$qStr = rtrim($qStr, " OR ");
				$qStr .= ") AND (";
			}
			else {
				$first = FALSE;
			}
			$atr = $currAtr;
		}
		$qStr .= "$atr='$atrVal' OR ";
	}
	$qStr = rtrim($qStr, " OR");
	$qStr .= ");";
	//print($qStr);
	$qRes = $db->query($qStr);

	if ($qRes != FALSE) {
		if($qRes->rowCount() == 0) {
			print("<H3>No results matched your search, try picking fewer options.</H3>");
		}
		else {
			print("<TABLE>");
			print("<TH>Building</TH><TH>Type</TH><TH>Address</TH><TH>Kitchen</TH><TH>Laundry</TH>");
			while ($row = $qRes->fetch()) {
				$name = $row['name'];
				$type = $row['type'];
				$address = $row['stnum']." ".$row['stname'];
				$kitchen = $row['kitchen'];
				$laundry = $row['laundry'];
				print("<TR>");
				print("<TD>$name</TD>");
				print("<TD>$type</TD>");
				print("<TD>$address</TD>");
				if ($kitchen == 0) {
					print("<TD>No</TD>");
				}
				else {
					print("<TD>Yes</TD>");
				}
				if ($laundry == 0) {
					print("<TD>No</TD>");
				}
				else {
					print("<TD>Yes</TD>");
				}
				print("</TR>");
			}
			print("</TABLE>");
			print("<br/>"); //for search again button to be on next line
		}
	return true;
	}
	return false;
}

function search_options($db, $searchType) {
	print("<h3>By building:</h3>");
        $atr = "name";
        $table = "building";
	echo load_cb($db, $atr, $table);
	if ($searchType == "student") {
	        print("<h3>By year:</h3>");
	        $atr = "year";
	        $table = "student";
	        echo load_cb($db, $atr, $table);
	        print("<h3>By status:</h3>");
	        $atr = "status";
		$table = "student";
	        echo load_cb($db, $atr, $table);
	}
	else if ($searchType == "room") {
		print("<h3>By Number of students:</h3>");
                $atr = "numstudents";
                $table = "room";
                echo load_cb($db, $atr, $table);
                print("<h3>Has bath:</h3>");
                $atr = "bath";
                $table = "room";
                echo load_cb($db, $atr, $table);
                print(" <h3>Has air conditioning:</h3>");
                $atr = "ac";
                $table = "room";
                echo load_cb($db, $atr, $table);
                print("<h3>Has a vacancy (not full capacity):</h3>");
                print("<input type='checkbox' id='emptyroom' name='emptyroom' value='emptyoom'> <label for='emptyroom'> Yes</label><br>");
	}
	else if ($searchType == "building") {
		print("<h3>By type:</h3>");
	        $atr = "type";
	        $table = "building";
		echo load_cb($db, $atr, $table);
		print("<h3>By street name:</h3>");
	        $atr = "stname";
 	        $table = "building";
		echo load_cb($db, $atr, $table);
		print("<h3>Has kitchen:</h3>");
	        $atr = "kitchen";
	        $table = "building";
		echo load_cb($db, $atr, $table);
		print("<h3>Has laundry:</h3>");
	        $atr = "laundry";
	        $table = "building";
		echo load_cb($db, $atr, $table);
	}
	else {
		print("That search type is not recognized");
	}

}

//Retrieves the names from the building table and returns a list of them as option values (to form a dropdown menu in signup.html) NOT WORKING
function load_building_dd($db) {
	$output = '';
	$sql = "SELECT name FROM building;";
	//print($sql);
	$result = $db->query($sql);
	if($result == TRUE) {
		while($row = $result->fetch()) {
			$output .= '<option value="'.$row["name"].'">'.$row["name"].'</option>';
			//$output .= $row["name"];
		}
	}
	else {
		print("False");
	}
	return $output;
}

function load_cb($db, $atr, $table) {
	$sql = "SELECT DISTINCT $atr FROM $table ORDER BY $atr;";
	//print($sql);
	$result = $db->query($sql);
	if($result == TRUE) {
		$output = '';
		while($row = $result->fetch()) {
			//print($atrVal);
			//print("type='checkbox' id='".$row["$atr"]."' name='".$atr.'-'.$row["$atr"]."' value='".$row["$atr"]."'");
			$optionDisplayed  = $row["$atr"];
			if ($optionDisplayed == "0") {
				$optionDisplayed = "No";
			}
			if ($optionDisplayed == "1") {
				$optionDisplayed = "Yes";
			}
			$output .= "<input type='checkbox' id='".$row["$atr"]."' name='".$atr."-".$row["$atr"]."' value='".$row["$atr"]."'>";
			$output .= '<label for='.$row["$atr"].'>'.$optionDisplayed.'</label><br>';
		}
	}
	else {
		print("False");
	}
	return $output;
}


//given the user's login, returns the corresponding string of their picture name
function get_profile_pic($db, $login) {
	$qStr = "SELECT pname FROM pic WHERE login='$login'";
	//print($qStr);
	$qRes = $db->query($qStr);
	$pname = "";
	if ($qRes != FALSE) {
		//print("Good query");
		if ($qRes->rowCount() == 1) {
			//print("Row count is one");
			$row = $qRes->fetch();
			$pname = $row['pname'];
			//print("Successfully found pic name in db");
		}
		else {
			print("User not in db");
		}
	}
	else {
		print("Failed to query pic db");
	}
	return $pname;
}

?>
