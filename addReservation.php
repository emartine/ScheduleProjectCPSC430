<?php
session_start();
error_reporting(~E_ALL);
include "header.html"
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Add Reservation</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

<center><h1 style="margin-top:0px;">Add</h1></center>

<?php
include "db_connect.php";
?>

<form method = "post" action = "addReservation2.php">
<table style="margin:20px; margin-top:-20px;">
	<tr><td><h3>Instructor</h3></td><td><input type="text" id="Instructor" maxlength = "30" name="Instructor" /></td></tr>
		<tr><td><h3>Class Title</h3></td><td><input type="text" id="Name" maxlength="30" name="Name" /></td></tr>
			<tr><td><h3>Time</h3></td><td><input type="number" id="Time" maxlength = "4" min="800" max="2200" name="Time" /></td></tr>
	<tr><td><h3>Length</h3></td><td><input type="number" id="Length" name="Length" min="15" max="210" step="5"/></td></tr> 
	<tr><td><h3>Room</h3></td><td>
	<select name ="Room" id = "Room">
		<option value="B36">B36</option>
		<option value="B52">B52</option>
		<option value="B6">B6</option>
		<option value="B7">B7</option>
		<option value="B39">B39</option>
		<option value="106A">106A</option>
		<option value="119">119</option>
		<option value="138">138</option>

		<option value="140">140</option>
		<option value="204">204</option>
		<option value="210">210</option>
		<option value="243">243</option>
	</select></td>
	
	<tr><td><h3>Department</h3></td><td><select name ="Department" maxlength = "10" id="Department" />
<option value="CPSC">Computer Science</option>
<option value="FSEM">Freshman Seminar</option>
<option value="MATH">Math</option>
<option value="EDUC">Education</option>
<option value="PHIL">Philosophy</option>

</select>
</td></tr> 
	<tr><td><h3>Days</h3></td><td>
	<select name ="Days" id = "Days">
                <option value="MWF">MWF</option>
                <option value="TR">TR</option>
	</select>

	</td></tr>
</table>

<table>
	<td>&nbsp;</td><td><input type="submit" value="Submit Reservation" /></td>
</table>
</form>
<div class="options" style="margin-top:-350px;"><h3>Disclaimer</h3><p>By clicking "Submit Reservation", the user is certifying that they have the appropriate permissions to make changes to the schedule corresponding to this UMW Course Scheduling Instance (Trinkle-F13).</div>
</body>
</html>
