<!DOCTYPE HTML>
<?php
session_start();
include_once("db_connect.php");
include("projectUtils.php");
?>
<html lang="en" dir="ltr">
	<head>
		<!-- stud_home.html
		Page where student goes after logging in
		Displays user's information from database-->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
				<div class="row p-3 dashboard">
					<div class="col-lg-4 pic">
						<?php
							$login = $_SESSION['login'];
							//print("$login");
							$pname = get_profile_pic($db, $login);
							//print("$pname");
							//if the user does not have a profile pic on record, give them the defalut
							if (empty($pname)) {
								$pname = "default_profile_pic.jpg";
							}
							print("<img class='profile' src='$pname' style='width:350px;height:350px;' alt='student-pic'>");
							//print("<img src='uploaded/Custer_George.jpg' style='width:200px;height:200px;' alt='student-pic'>");
						?>
					</div>
					<div class="col-lg-2"></div>
					<div class="col-lg-6 info">
							<?php
								$login = $_SESSION['login'];
								$qStr = "SELECT fname, mname, lname, year, status, bname, number FROM student JOIN room ON student.roomid=room.roomid WHERE login='$login'";
								$qRes = $db->query($qStr);
								if ($qRes != FALSE) {
									$row = $qRes->fetch();
									$fname = $row['fname'];
									$mname = $row['mname'];
									$lname = $row['lname'];
									$year = $row['year'];
									$bname = $row['bname'];
									$number = $row['number'];
									$status = $row['status'];
									print("<h2>$fname $mname $lname</h2>");
									print("<p>Year: $year</p>");
									print("<p>Building: $bname</p>");
									print("<p>Room: $number</p>");
									print("<p>Status: $status</p>");
								}
								else {
									print("Error retrieving your information");
								}
							?>
							<a class="report-error button" href="report_error.html">
								Report Error
							</a>
							<a class="upload-pic button" href="upload_pic.html">
								Upload Picture
							</a>
					</div>
				</div>
			</div>
		</div>

	</body>
</html>
