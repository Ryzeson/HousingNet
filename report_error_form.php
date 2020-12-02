<!DOCTYPE HTML>
<?php
  session_start();
  include_once("db_connect.php");
?>
<html lang="en" dir="ltr">
  <head>
    <!--
	report_error_form.html
	When the student submits the error report, they're directed here.
      -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="dash.css">
    <title>HousingNet Student Home - Report Error</title>
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
    <div class="fill pl-2 pt-1">
      <!-- PHP Section -->
      <?php
       $login = $_SESSION["login"];
       //$login = "";

       if (empty($login)) {
         print "<h3>Unable to retrieve username</h3><br/>\n";
         print "<p>We're not sure what happened. Contact an administrator for assistance.</p><br/>\n";
       }
       else {
         $qstr = "SELECT fname, mname, lname, year, status, bname, number FROM student JOIN room ON student.roomid=room.roomid WHERE login='$login'";
         $qres = $db->query($qstr);

         if ($qres != FALSE) {
           $row = $qres->fetch();

           if (empty($row['fname'])) {
             print "<h3>Unable to process request.</h3><br/>\n";
             print "<p>Please contact an admin for assistance.</p><br/>\n";
           }
           else {
             $name = $row['fname'] . " " . $row['lname'];

             $to = "eppsna01@gettysburg.edu";
             $from = $login . "@gettysburg.edu";

             $subject = "HousingNet Error Report";
             $content = "User " . $name . " sent an error report.\n\n" . "Message: " . $_POST["content"];

             $header = "From: " . $from;

             $mres = mail($to, $subject, $content, $header);

             if ($mres == FALSE) {
               print "<h3>Unable to process request.</h3><br/>\n";
               print "<p>Please contact the reslife office or an administrator.</p>\n";
             }
             else {
               print "<h3>Comment sent successfully.</h3><br/>\n";
               print "<p>An admin will process your request shortly.</p>\n";
             }
           }
         }
       }
       ?>
      <!-- End PHP -->
      <!--<p>(Note: debug version, emailing is disabled)</p>-->
      <a href="stud_home.php">Return to Home</a>
    </div>
  </body>
</html>
