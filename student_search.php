<?php

include_once("db_connect.php");
include("projectUtils.php");

print("Before");
print_r($_POST);
$hanson = $_POST["hanson"];
print($hanson);
$result = search_student($db);
//$result = TRUE;
//for testing
if($result == TRUE) {
	print("successfully ran search_students");
}
else {
	print("failed to run search_students");
}
 ?>
