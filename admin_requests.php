<?php
include_once("db_connect.php");
include("projectUtils.php");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- admin_requests.php
		page where the admin should be able to change any of the values in the database, and add/delete any of the relations/tables-->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device=width, initial-scale=1.0">
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="dash.css">
		<title>HousingNet Admin</title>
	</head>
	<body>
		  <nav>
                        <div class="logo">
                                <img src="grapes.jpg" alt="grapes">
                                <p>HousingNet</p>
                        </div>
                        <ul class="nav-links">
                                <li><a href="admin_search.php">Search</a></li>
                                <li><a href="admin_requests.php">Requests</a></li>
                                <li><a href="admin_modify.php">Modify</a></li>
                        </ul>
                </nav>

		<div class="fill">
		</div>
	</body>
</html>
