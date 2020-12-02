<?php

include_once("db_connect.php");
include("projectUtils.php");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- stud_serach.html
		Let's the user search buildings aand rooms with different filters-->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device=width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="dash.css">
		<title>HousingNet Student Home</title>
	</head>
	<body>
		<nav>
			<div class="logo">
				<img src="grapes.jpg" alt="grapes">
				<p>HousingNet</p>
			</div>
			<ul class="nav-links">
				<li><a href="stud_home.php">Home</a></li>
				<li><a href="stud_search.php">Search</a></li>
				<li><a href="stud_contact.php">Contact</a></li>
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
								print("<H2>Search results: </H2>");
								$searchType = $_GET['searchType'];
								//print("$searchType");
								$result = FALSE;
								if ($searchType == "room") {
									$result = search_room($db);
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
									print("<a class='upload-pic button' href='stud_search.php'> Search again </a>");
								}
								else {
									print("failed to run search_students");
								}
							}
							else {
							print("<h2> Search for: </h2>");
						print("<FORM action='stud_search.php' method='GET'>");
						print("<select name='searchType' id='searchType' onchange='this.form.submit()'>");
						if ($_GET == NULL || $_GET['searchType'] == "room") {
     							print("<option value='room'>room</option>");
  							print("<option value='building'>building</option>");
						}
						else if ($_GET['searchType'] == "building") {
  							print("<option value='building'>building</option>");
     							print("<option value='room'>room</option>");
						}
						else {
							print("Failure to create dropdown");
						}
						print("</select>");
						print("</FORM>");
							print("<input type='checkbox' onclick='toggle(this);' />Check all <br />");
							//print_r($_GET);
							if (isset($_GET['searchType']) == TRUE) {
								$searchType = $_GET['searchType'];
							}
							else {
								$searchType = "room";
							}
							//print("$searchType");
							print("<FORM class='lisu filter' name='signup' method='POST' action='stud_search.php?searchType=".$searchType."'>");
							echo search_options($db, $searchType);
							print("<p>");
							print("<INPUT type='submit' value='search'/>");
							print("<INPUT type='reset' value='clear'/>");
							print("</p>");
						print("</FORM>");
						}
						?>
						<!-- https://stackoverflow.com/questions/386281/how-to-implement-select-all-check-box-in-html -->
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
