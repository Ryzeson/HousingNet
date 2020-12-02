
<?php
	ini_set("dsiplay_errors");
	print("Before connecting");
	include_once("db_connect.php");
	include("projectUtils.php");
	print("Before method call");
	$buildings = load_building_dd($db);
	print("After method call");
?>

<!doctype html>
<html lang="en">
<head>
	 <!-- signup.php
	 	form that collects user's info when they sign up-->
    <meta charset="utf-8">
    <meta name"viewport" content="width = device-width, initial-scale=1">
    <title>HousingNet</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>


<div class="container">
	<div class="row">
		<div class="col-lg-3">
		</div>
		<div class="col-lg-6">
			<h2>HousingNet</h2>
			<h3>Signup</h3>
			<FORM class="lisu" name="signup" method="POST" action="signup_f.php">
				<p>First name:</p><input type="text" name="fname" placeholder="Jackson" required /> <br/>
				<p>Middle name:</p><input type="text" name="mname" placeholder="Joe" required /> <br/>
				<p>Last name:</p><input type="text" name="lname" placeholder="Smith" required /> <br/>
				<p>Username:</p><input type="text" name="username" placeholder="JackSmith" required /> <br/>
				<p>Password:</p><input type="password" name="password" placeholder="gburg123" required /> <br/>
				<!--<p>Confirm Password:</p><input type="text" name="login" placeholder="JackSmith" required /> <br/>-->
				<p>Login:</p><input type="text" name="login" placeholder="smitja01" required /> <br/>
				<p>SSN:</p><input type="text" name="ssn" placeholder="33344422" required /> <br/>
				<p>Year:</p><input type="text" name="year" placeholder="2023" required /> <br/>
				<p>Building:</p><input list="buildings" type="text" name="Building" placeholder="Hanson" required /> <br/>
					<datalist id="buildings">
						<option value="Apple Hall">
						<option value="Baughman Hall">
						<option value="Civil War House">
				    <option value="Hanson">
						<option value="Ice House">
				    <option value="Paxton">
						<option value="RISE House">
				    <option value="Smyser">
				  </datalist>

				<p>Room:</p><input type="text" name="Room" placeholder="101" required /> <br/>
				<!-- checkbox -->
				<p>Status:</p><input type="text" name="Status" placeholder="RA" required /> <br/>
				<!--How to get housing info? Do they put it in? If so, does an admin check?-->
				<p>
				<INPUT type="submit" value="signup"/>
				</p>
			</FORM>
			<p>BuildingSQL:
				<select name="BuildingSQL" >
				<option value="">Select building</option>
				<?php echo load_building_dd($db); ?>
			</select></p>
		</div>
		<div class="col-lg-3">
		</div>
	</div>
</div>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>
