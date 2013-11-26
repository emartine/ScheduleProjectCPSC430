<?php
	session_start();
	error_reporting(~E_ALL);

	if ($_SESSION['username'] == null)
	{
		header('Location: index.php');
	}

	if ($_GET['id'] == NULL || $_SESSION['privilege'] != "ADMN")
	{
		header('Location: userindex.php');
	}

	include "db_connect.php";
	include "header.html";
?>

<html>

<head></head>

<body>

<center><h1 style = margin-top:0px;>Delete a User</h1></center>

<div>

<?php
	if ($_GET['id'] != NULL)
	{
		$id = $_GET['id'];

		if ($_POST['hiding'] == "submitted")
		{
			$delete = "DELETE FROM User WHERE ID = '$id';";
			$deleteQ = mysqli_query ($db, $delete);
			$row = mysqli_fetch_array($deleteQ);
			
			echo "<center><font size=\"3\"><h3>The User has been removed </h3></font></center>";
		}

		$search = "Select * FROM User WHERE ID = '$id';";
		$query = mysqli_query ($db, $search);
		$row = mysqli_fetch_array($query);
		
		if ($row != null && $_POST['hiding'] == null)
		{
			$name = $row['User'];
			$email = $row['UMWEmail'];
			$dept = $row['Dept'];

			echo "<center><h3><font size=\"3\">Are you sure you want to delete this User?</font></h3></center>";
			echo "<center><table id=\"hor-minimalist-b\">";
				echo "<tr><th>User</th><th>UMWEmail</th><th>Department</th></tr>";
				echo "<tr><td>$name</td><td>$email</td><td>$dept</td></tr>";
			echo "</table></center>";

			if ($dept != "ADMN")
			{
				echo "<form method=\"post\" action=\"removeUser.php?id=$id\">";
					echo "<input type=\"hidden\" name=\"hiding\" value=\"submitted\">";
					echo "<center><input type=\"submit\" value=\"Delete\"></center>";
				echo"</form>";
			}
			else
			{
				echo "<center><h3><font size=\"3\">ADMINS cannot be deleted</font></h3></center>";
			}
		}
	}
?>

</div>

</body>

</html>
