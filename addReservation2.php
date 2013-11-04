<?php
session_start();
error_reporting(~E_ALL);
include "header.html"
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Book 2 </title>
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div id="contents">

<?php
include "db_connect.php";
$username = $_SESSION['username'];
//$profile  = $_SESSION['profile'];

$Instructor = $_POST['Instructor'];
$Time = $_POST['Time'];
$Length = $_POST['Length'];
$Room = $_POST['Room'];
$Department = $_POST['Department'];
$Days = $_POST['Days'];
$Name = $_POST['Name'];



if($Room != null && $Time != null)
{
	echo "<center><h1>Your book was added</h1></center>";
echo "<p>Thanks for adding a book, $username!</p>";
	echo "<h2>No: $Name</h2>";
	echo "<h2>Book Title: $Instructor</h2>";
	echo "<h2>Author: $Time</h2>";
	echo "<h2>ISBN: $Length</h2>";
	echo "<h2>Class: $Room</h2>";
	echo "<h2>Price: $Department</h2>";
	echo "<h2>Quality: $Days</h2>";

$insertInto = "INSERT INTO `schedule?group2`.`Reservations` (`ID`, `Instructor`, `Time`, `Length`, `Room`, `Department`, `Creator`, `Days`, `Name`) VALUES (NULL, '$Instructor', '$Time', '$Length', '$Room', '$Department', '$username', '$Days', '$Name')";
$insertIntoQuery = mysqli_query($db, $insertInto);
	include "reservationwasadded.php";	}

else
{
	echo "<center><h1>Your book was not added</h1></center>";
	echo "<p>You did not enter all the fields correctly.  Try again.</p>";
	include "tryagain.php";
}
?>

</div>
</body>
</html>
