<?php 
session_start();
//error_reporting(~E_ALL);
include "header.html" ;
include "db_connect.php";
?>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<title>Search</title>
</head>

<body>
<div id="contents">

	<center><h1>Search for a Reservation</h1></center>

	<form name="professorSearch" method="post" id="professor" action="search.php">
		<table>
                        <input type = "hidden" name = "hiding" value = "submitted">
			<tr><td><h3>Instructor: </h3></td><td> <input type="text" name="prof" id="prof"/></td></tr>
			<tr><td><h3>Time: </h3></td><td><select name = "time" id="time">
				<option selected value = null> None</option>
				<?php
					$hour = 8;
		
					while ($hour < 22)
					{
                                        	if ($hour > 12)
                                        	{
                                                	$disTime = $hour - 12;
							$hour = $hour * 100;
							$hour1 = $hour + 30; 
                                        	        echo "<option value=$hour>$disTime:00pm</option>";
							echo "<option value=$hour1>$disTime:30pm</option>";
                                               		$hour = $hour / 100;
                                        	}
                                        	else if ($hour == 12)
                                        	{
							$disTime = $hour;
							$hour = $hour * 100;
							$hour1 = $hour + 30;
                                                        echo "<option value=$hour>$disTime:00pm</option>";
                                                        echo "<option value=$hour1>$disTime:30pm</option>";
							$hour = $hour / 100;
                                        	}
                                        	else
                                        	{
							$disTime = $hour;
							$hour = $hour * 100;
							$hour1 = $hour + 30;
                                                        echo "<option value=$hour>$disTime:00am</option>";
                                                        echo "<option value=$hour1>$disTime:30am</option>";
							$hour = $hour / 100;
                                        	}
                                        	$hour = $hour + 1;
                                	}
				?>
			</select></td>
			<tr><td><h3>Room: </h3></td><td><select name = "room" id="room">
                                <option selected value = null> None</option>
				<?php
					$listOfRoom = array("B36","B52","B6","B7","B39","106A","119","138","140","204","210","243");

					for ($x = 0; $x < count($listOfRoom); $x++)
					{
						echo "<option value=\"$listOfRoom[$x]\">$listOfRoom[$x]</option>";
					}
				?>
			</select></td>
			<tr><td><h3>Department: </h3></td><td><select name = "dept" id="dept">
                                <option selected value = null> None</option>				
				<?php
					$listOfDept = array("PHIL","MATH","EDUC","CPSC","FSEM");

	                                for ($x = 0; $x < count($listOfDept); $x++)
                                        {
                                                echo "<option value=\"$listOfDept[$x]\">$listOfDept[$x]</option>";
                                        }
				?>
			</select></td>
			<tr><td><input type ="submit" value=Search /></td></tr>
		</table>
	</form>
</div>
<div>
<?php
	$dept = $_POST['dept'];
	$room = $_POST['room'];
	$time = $_POST['time'];
	$prof = $_POST['prof'];

	$query = "Select * FROM Reservations";
	
	if ($prof != null)
	{
		$query = $query." WHERE Instructor = '$prof'";
	}
        if ($time != 'null')
        {
		if ($prof != null)
		{
			$query = $query." AND";
		}
		else
		{
			$query = $query." WHERE";
		}
                $query = $query." Time = '$time'";
        }
        if ($dept != 'null')
        {
                if ($time != 'null' || $prof != null)
                {
                        $query = $query." AND";
                }
                else
                {
                        $query = $query." WHERE";
                }
                $query = $query." Department = '$dept'";
        }
        if ($room != 'null')
        {
		if ($prof != null || $time != 'null' || $dept != 'null')
                {
                        $query = $query." AND";
                }
                else
                {
                        $query = $query." WHERE";
                }
                $query = $query." Room = '$room'";
        }

	$result = mysqli_query($db, $query);
	if ($_POST['hiding'] == "submitted")
	{
		echo "<table><tr><td>Instructor</td><td>Time</td><td>Room</td><td>Department</td></tr>";
	}	
	while ($row = mysqli_fetch_array($result))
	{
		$Instructor = $row['Instructor'];
		$Time = $row['Time'];
		$Room = $row['Room'];
		$Dept = $row['Department'];
				
		echo "<tr><td>$Instructor</td><td>$Time</td><td>$Room</td><td>$Dept</td></tr>";
	}
	echo "</table>";
	/*else
	{
		echo "<p>Sorry, I did not find what you where searching for</p>\n";
	}*/
?>

</div>
</body>
</html>
