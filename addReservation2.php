<?php
	session_start();
	error_reporting(~E_ALL);
	include "header.html"
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Add Reservation 2</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<h1 style="margin-top:0px;"> Add a Reservation </h1>
</head>

<body>

<div id="contents">

<?php
	include "db_connect.php";
	
	$username = $_SESSION['username'];
	//$profile  = $_SESSION['profile'];
	
	if ($username == null)
	{
		header('Location: index.php');
	}

	$Instructor = $_POST['Instructor'];
	$Time = $_POST['Time'];
	$Length = $_POST['Length'];
	$Room = $_POST['Room'];
	$Department = $_POST['Department'];
	$Days = $_POST['Days'];
	$Name = $_POST['Name'];

	if ((int)$Length < 15 || (int)$Length > 215)
	{
		echo "<center><h2 style=\"margin-top:0px;\">Your reservation was not added</h2></center>";
		echo "<p>Sorry, the Length of the class was either too short or too long.</p>";
		include "tryagain.php";
	}
	else if($Room != null && $Time != null && $Instructor != null && $Length != null)
	{
		echo "<center><h2 style=\"margin-top:0px;\">Your reservation was added</h2></center>";
		echo "<h2>Name: $Name</h2>";
		echo "<h2>Instructor: $Instructor</h2>";
		echo "<h2>Time: $Time</h2>";
		echo "<h2>Length: $Length</h2>";
		echo "<h2>Room: $Room</h2>";
		echo "<h2>Department: $Department</h2>";
		echo "<h2>Days: $Days</h2>";

		$insertInto = "INSERT INTO `schedule?group2`.`Reservations` (`ID`, `Instructor`, `Time`, `Length`, `Room`, `Department`, `Creator`, `Days`, `Name`) 					VALUES (NULL, '$Instructor', '$Time', '$Length', '$Room', '$Department', '$username', '$Days', '$Name')";
		
		$insertIntoQuery = mysqli_query($db, $insertInto);
		$id = mysqli_insert_id($db);
		
		include "reservationwasadded.php";
		// Look for conflicts below
		echo "<hr>";

		echo "<center><h3 style=\"margin-top:25px;\">Direct Conflicts:</h3></center>";

		$query = "SELECT * FROM Reservations WHERE Room = '$Room' AND (Days LIKE '%$Days%'";
		for ($y = 0; $y < strlen($Days); $y++)
		{
			$query = $query." OR Days LIKE '%$Days[$y]%'";
		}
		$query = $query.");";
		$resultQ = mysqli_query($db, $query);

		$classTimestr = (string)$Time;
		$tempDuration = 0;
		$digit = 0;
		$tempNum = 0;

		if ((strlen($classTimestr)) == 3)
		{
			$tempNum = ((int)$classTimestr[0]) * 100;

			$digit = (int)substr($classTimestr,1);
			$digit = $digit + $Length;

			while ($digit >= 60)
			{
				$tempDuration = $tempDuration + 100;
				$digit = $digit - 60;
			}
			$tempDuration = $tempDuration + $digit;
			$tempNum = $tempNum + $tempDuration;
		}
		else if ((strlen($classTimestr)) == 4)
		{
			$tempNum = ((int)substr($classTimestr,0,2)) * 100;

			$digit = (int)substr($classTimestr,2,2);
			$digit = $digit + $Length;

			while ($digit >= 60)
			{
				$tempDuration = $tempDuration + 100;
				$digit = $digit - 60;
			}
			$tempDuration = $tempDuration + $digit;
			$tempNum = $tempNum + $tempDuration;
		}

		$endTime = $tempNum;
		$count = 0;
		$array[20];
		$arrayName[20];
        $arrayClass[20];
        
		while ($row = mysqli_fetch_array($resultQ))
		{
			$idClass = $row['ID'];
			$timeClass = $row['Time'];
			$lengthClass = $row['Length'];
			$endTimeClass = 0;
			$className = $row['Name'];
			$creator = $row['Creator'];

			$classTimestr = (string)$timeClass;
			$tempDuration = 0;
			$digit = 0;
			$tempNum = 0;

			if ((strlen($classTimestr)) == 3)
			{
				$tempNum = ((int)$classTimestr[0]) * 100;

				$digit = (int)substr($classTimestr,1);
				$digit = $digit + $lengthClass;

				while ($digit >= 60)
				{
					$tempDuration = $tempDuration + 100;
					$digit = $digit - 60;
				}
				$tempDuration = $tempDuration + $digit;
				$tempNum = $tempNum + $tempDuration;
				$endTimeClass = $tempNum;
			}
			else if ((strlen($classTimestr)) == 4)
			{
				$tempNum = ((int)substr($classTimestr,0,2)) * 100;

				$digit = (int)substr($classTimestr,2,2);
				$digit = $digit + $lengthClass;

				while ($digit >= 60)
				{
					$tempDuration = $tempDuration + 100;
					$digit = $digit - 60;
				}
				$tempDuration = $tempDuration + $digit;
				$tempNum = $tempNum + $tempDuration;
				$endTimeClass = $tempNum;
			}

			//$endTimeClass = $tempNum;

			if ((($timeClass >= $Time && $timeClass < $endTime) || ($endTimeClass > $Time && $timeClass < $endTime)) && $id != $idClass)
			{
				$array[$count] = $idClass;
				$arrayName[$count] = $creator;
                $arrayClass[$count] = $className;
				$count++;
			}
			$endTimeClass = 0;
			$tempNum = 0;
		}

		if ($count == 0)
		{
			echo "<center><h3>There were no direct Conflicts</h3></center>";
		}
		else
		{	
			$query1 = "Select * from User Where User = '$username';";
			$result1 = mysqli_query($db, $query1);

			$row = mysqli_fetch_array($result1);

			$submitEmail = $row['UMWEmail'];

			echo "<center><h3>Send email to those with whom conflict occurs:</h3></center>";

			echo "<form action=\"email.php\" method=\"post\" name=\"sendEmail\">";
				echo "<input type=\"hidden\" name=\"length\" value=\"$count\">";
				echo "<input type=\"hidden\" name=\"name\" value=\"$username\">";
				echo "<input type=\"hidden\" name=\"email\" value=\"$submitEmail\">";
				for ($x = 0; $x < $count; $x++)
				{
					$prof = $arrayName[$x];
					$class = $array[$x];
					$box = "cb".(string)$x;
                    $conflictClassName = $arrayClass[$x];
					echo "<center><h3><input type=\"checkbox\" name=\"$box\" value=\"$class\"/>User: $prof Class: $conflictClassName </h3></center>";
				}
				echo "<center><input type=\"submit\" value=\"Send Emails\"/></center>";
			echo "</form>";
		}
	}
	else
	{
		echo "<center><h2 style=\"margin-top:0px;\">Your reservation was not added</h2></center>";
		echo "<p>You did not enter all the fields correctly.  Try again.</p>";
		include "tryagain.php";
	}
?>

</div>

</body>

</html>
