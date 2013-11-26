<?php
	session_start();
	error_reporting(~E_ALL);

	if ($_SESSION['username'] == null)
	{
		header('Location: index.php');
	}

	if ($_SESSION['privilege'] != "ADMN")
	{
		header('Location: editProfile.php');
	}

	include "db_connect.php";
	include "header.html";
?>

<html>

<head></head>

<body>

<center><h1 style = margin-top:0px;>Delete All Reservation</h1></center>

<div>

<?php
		if ($_POST['hiding'] == "submitted")
		{
			$delete = "DELETE FROM Reservations;";
			$deleteQ = mysqli_query ($db, $delete);
			$row = mysqli_fetch_array($deleteQ);
			
			echo "<center><font size=\"3\"><h3>ALL RESERVATIONS HAVE BEEN REMOVED</h3></font></center>";
			$_POST['hiding'] = null;
		}
		else
		{
			echo "<center><font size=\"3\"><h3>ARE YOU SURE YOU WANT TO REMOVE ALL RESERVATIONS</h3></font></center>";

			echo "<form method=\"post\" action=\"removeAllRes.php\">";
				echo "<input type=\"hidden\" name=\"hiding\" value=\"submitted\">";
				echo "<center><input type=\"submit\" value=\"Delete All Reservations\"></center>";
			echo"</form>";
		}
?>

</div>

</body>

</html>
