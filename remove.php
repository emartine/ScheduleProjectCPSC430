<?php
	session_start();
	error_reporting(~E_ALL);

	if ($_SESSION['username'] == null)
	{
		header('Location: index.php');
	}

	if ($_GET['id'] == NULL)
	{
		header('Location: editProfile.php');
	}

	include "db_connect.php";
	include "header.html";
?>

<html>

<head></head>

<body>

<center><h1 style = margin-top:0px;>Delete a Reservation</h1></center>

<div>

<?php
	if ($_GET['id'] != NULL)
	{
		$id = $_GET['id'];

		if ($_POST['hiding'] == "submitted")
		{
			$delete = "DELETE FROM Reservations WHERE ID = '$id';";
			$deleteQ = mysqli_query ($db, $delete);
			$row = mysqli_fetch_array($deleteQ);
			
			echo "<center><font size=\"3\"><h3>The reservation has been removed </h3></font></center>";
			$_POST['hiding'] = null;
		}

		$search = "Select * FROM Reservations WHERE ID = '$id';";
		$query = mysqli_query ($db, $search);
		$row = mysqli_fetch_array($query);
		
		if ($row != null && $_POST['hiding'] == null)
		{
			$name = $row['Name'];
			$teacher = $row['Instructor'];
			$room = $row['Room'];
			$dept = $row['Department'];
			$day = $row['Days'];
			$Time = $row['Time'];
			$creator = $row['Creator'];

			$strTime = (string)$Time;
			if (strlen($strTime) == 3)
			{
				$first = substr($strTime,0,1).":";
				$second = substr($strTime,1,2)." AM";
				$strTime = $first.$second;
			}
			else
			{
				$first = substr($strTime,0,2);
				$firstNum = (int)$first;
				if ($firstNum > 12)
				{
					$firstNum = $firstNum - 12;
					$first = (string)$firstNum;
				}
				$first = $first.":";
				$second = substr($strTime,2,2);
				$strTime = $first.$second;
				if ($Time >= 1200)
				{
					$strTime = $strTime." PM";
				}
				else
				{
					$strTime = $strTime." AM";
				}
			}
			echo "<center><h3><font size=\"3\">Are you sure you want to delete this Reservation?</font></h3></center>";
			echo "<center><table id=\"hor-minimalist-b\">";
				echo "<tr><th>Class</th><th>Instructor</th><th>Time</th><th>Room</th><th>Day(s)</th><th>Dept</th></tr>";
				echo "<tr><td>$name</td><td>$teacher</td><td>$strTime</td><td>$room</td><td>$day</td><td>$dept</td></tr>";
			echo "</table></center>";

			if ($_SESSION['privilege'] == "ADMN" || $_SESSION['privilege'] == $dept || $_SESSION['username'] == $creator)
			{
				echo "<form method=\"post\" action=\"remove.php?id=$id\">";
					echo "<input type=\"hidden\" name=\"hiding\" value=\"submitted\">";
					echo "<center><input type=\"submit\" value=\"Delete\"></center>";
				echo"</form>";
			}
			else
			{
				echo "<center><h3><font size=\"3\">You can't delete this Reservation</font></h3></center>";
			}
		}
	}
?>

</div>

</body>

</html>
