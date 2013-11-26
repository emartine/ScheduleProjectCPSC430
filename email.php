<?php
	session_start();
	error_reporting(~E_ALL);

	include "db_connect.php";
	include "header.html";
    
    if ($_SESSION['username'] == null)
    {
        header('Location: index.php');
    }
    if ($_POST['length'] == null || $_POST['name'] == null || $_POST['email'] == null)
    {
        header('Location: addReservation.php');
    }
?>

<html>

<head></head>

<body>

<center><h1 style = margin-top:0px;>Email</h1></center>

<div>

<?php
	$length = $_POST['length'];
	$name = $_POST['name'];
	$email = $_POST['email'];

	$message ="";
	
	for ($x = 0; $x < $length; $x++)
	{
		$box = 'cb'.(string)$x;
		if ($_POST[$box] != null)
		{
			$id = $_POST[$box];
			$query = "Select * from Reservations where ID = '$id';";
			$result = mysqli_query($db, $query);
			$row = mysqli_fetch_array($result);

			if ($row != null)
			{
				$class = $row['Name'];
				$time = $row['Time'];
				$prof = $row['Creator'];

				$query1 = "Select * from User where User = '$prof';";
				$result = mysqli_query($db, $query1);
				$row = mysqli_fetch_array($result);

				$address = $row['UMWEmail'];
                
                $from = "From: UMW Trinkle Scheduler";

				$message = "$prof, There was a conflict which arose when $name added a class that overlapped with your class: $class at $time(military time). You can respond to $name at $email.";
				mail ($address, "Conflict", $message, $from);
			}
		}
	}
    echo "<center><h3>Email(s) Sent</h3></center>";
?>

</div>

</body>

</html>
