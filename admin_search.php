<?php

include_once("db_connect.php");
include("projectUtils.php");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- admin_search.php
		Page where admin goes after logging in (subject to change)
		Can search students with different filters, and then contact them-->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device=width, initial-scale=1.0">
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="dash.css">
		<title>HousingNet Admin Home</title>
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
			<div class="container">
				<div class="row">
					<div class="col-lg-3">
					</div>
					<div class="col-lg-6">
						<?php
							if($_POST != NULL) {
								print("<H2>Search results:</H2>");
								$searchType = $_GET['searchType'];
								//print("$searchType");
								$result = FALSE;
								if ($searchType == "room") {
									$result = search_room($db);
								}
								else if ($searchType == "student") {
									$result = search_student($db);
								}
								else if ($searchType == "building") {
									$result = search_building($db);
								}
								else {
									print("Invalid search type, could not return table");
								}
								//for testing
								if($result) {
									//print("successfully ran search_students");
								}
								else {
									print("failed to run search_students");
								}
								print("<a class='upload-pic button' href='admin_search.php'> Search again </a>");
							}
							else {
						print("<h2> Search for: </h2>");
						print("<FORM action='admin_search.php' method='GET'>");
						print("<select name='searchType' id='searchType' onchange='this.form.submit()'>");
						if ($_GET == NULL || $_GET['searchType'] == "student") {
      							print("<option value='student'>student</option>");
     							print("<option value='room'>room</option>");
  							print("<option value='building'>building</option>");
						}
						else if ($_GET['searchType'] == "room") {
     							print("<option value='room'>room</option>");
     							print("<option value='student'>student</option>");
  							print("<option value='building'>building</option>");
						}
						else if ($_GET['searchType'] == "building") {
  							print("<option value='building'>building</option>");
	  						print("<option value='student'>student</option>");
     							print("<option value='room'>room</option>");
						}
						else {
							print("Failure to create dropdown");
						}
							print("</select>");
						print("</FORM>");
							//print_r($_GET);
							if (isset($_GET['searchType']) == TRUE) {
								$searchType = $_GET['searchType'];
							}
							else {
								$searchType = "student";
							}
							//print("$searchType");
							print("<FORM class='lisu filter' name='signup' method='POST' action='admin_search.php?searchType=".$searchType."'>");
							if ($searchType == "student") {
								print("<LABEL for='fname' id='fname'>Search by last name: </LABEL>");
								print("<INPUT type='text' id='fname' name='fname' placeholder='Abraham'/> <br />");
								print("<LABEL for='lname' id='lname'>Search by last name: </LABEL>");
								print("<INPUT type='text' id='lname' name='lname' placeholder='Lincoln'/> <br />");
							}
							//https://stackoverflow.com/questions/386281/how-to-implement-select-all-check-box-in-html
							print("<input type='checkbox' onclick='toggle(this);' />Check all <br />");
							echo search_options($db, $searchType);
							print("<p>");
							print("<INPUT type='submit' value='search'/>");
							print("<INPUT type='reset' value='clear'/>");
							print("</p>");
						print("</FORM>");
					}
					?>
							<script>
								function toggle(source) {
    									var checkboxes = document.querySelectorAll('input[type="checkbox"]');
							        	for (var i = 0; i < checkboxes.length; i++) {
    										if (checkboxes[i] != source)
    								        	checkboxes[i].checked = source.checked;
   								 	}
								}
							</script>
					</div>
					<div class="col-lg-3">
					</div>
				</div>
			</div>
		</div>

	</body>
</html>
