<?php
session_start();
include_once("db_connect.php");

// assume that user's file will be saved in
// uploaded/ (in current folder)
// this folder must be created and have a+rwx permission

// call the function, saveImage, for actual uploading.

$msg1 = saveImage($_FILES['myFile1'], $db);

//echo "<P>$msg1</P>\n";



header("Location:stud_home.php");

function saveImage($fileData, $db) {

    // 0. for debugging
    printf("<PRE>\n");
    print_r($fileData);
    printf("</PRE>\n");

    $msg = "";

    // 1. important variables from $fileData
    $userfn = $fileData['name'];
    $size   = $fileData['size'];
    $tmpfn  = $fileData['tmp_name'];
    $type   = $fileData['type'];

    printf("<P>Step 1 done</P>");


    // 2. check file size for (0, 5MB]

    if ($size == 0) {
        $msg = "File is empty";
        return $msg;
    }
    else if ($size > 5200000) {
        $msg = "File is too large, max of 5MB limit";
        return $msg;
    }

    printf("<P>Step 2 done</P>");


    // 3. get uploaded file data info from temp folder
    $imgInfo = getimagesize($tmpfn);

    printf("<P>Step 3 done</P>");

    // 4. check mime type (is it an image?)
    if ($imgInfo == FALSE) {
        $msg = "File is not an image";
        return $msg;
    }

    printf("<P>Step 4 done</P>");


    // 5. check for allowed types (jpg/gif/png)

    printf("<P>Step 5 done</P>\n");

    // 6. copy uploaded file from temp folder to correct folder
    $folder = "./uploaded/";
    //$folder = "./cs360/project/uploaded/";
    $fn = $folder . $userfn;

    print "<P>Saving uploaded file as " . $fn . "</P>\n";

    print("Temp file name ". $tmpfn);
    print(" File name ". $fn);
    $result = move_uploaded_file($tmpfn, $fn);

    printf("<P>Step 6 done</P>");

    // 7. check if copying was successful
    if ($result != FALSE) {
	print("Successfully uploaded picture");
        $msg = "<P>Successfully uploaded $userfn</P>\n";

        // change owner info on the uploaded file
        // chown ______ files/folders
        // "chown skim $fn" ==> may not work
        //$cmd = "chown skim $fn";
        $cmd = "chmod a+rw '$fn'";
        //echo "<P>$cmd<\P>\n";
        system($cmd);

        $msg .= "<P>See your uploaded image: <IMG src='" . $fn . "' /></P>\n";
	$login = $_SESSION['login'];
	print($login);
	$qStr = "SELECT login FROM pic WHERE login='$login';";
	//print($qStr);
	$qRes = $db->query($qStr);
	if ($qRes != FALSE) {
		//if user exists in picture db, then update pic string
		if ($qRes->rowCount() == 1) {
			$qUpd = "UPDATE pic SET pname='$fn' WHERE login='$login'";
			print($qUpd);
			$qUpdRes = $db->query($qUpd);
			if ($qAddRes != FALSE) {
				$msg = "Succesfully updated pic info in the pic table";
			}
			else {
				$msg = "Failed to update pic info in the pic table";
			}
		}
		//otherwise add user and string to db
		else {
			$qAdd = "INSERT INTO pic VALUES('$login', '$fn')";
			print($qAdd);
			$qAddRes = $db->query($qAdd);
			if ($qAddRess != FALSE) {
				$msg = "Successfully added new pic to pic table";
			}
			else {
				$msg = "Failed to add new pic to pic table";
			}
		}
	}
	else {
		$msg = "Was unable to perform initial query on pic table";
	}
    }
    else {
        $msg = "<P>Error uploading $userfn</P>\n";
    }

    // 8. return success or failure message
    return $msg;
}

?>

