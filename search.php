<?php 
	session_start();
	error_reporting(~E_ALL);
	include "header.html" ;
	include "db_connect.php";
?>

<head>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<title>Search</title>
</head>

       <center><h1 style = margin-top:0px;>Search for a Reservation</h1></center>

<body>

<!--<div id="contents">-->

<!-- The php code below should check if the user is properly logged in and if not will redirect them to the login page -->
<?php
	if ($_SESSION['username'] == null)
	{
		//header('Location: http://rosemary.umw.edu/~gparvez/textbook');
		header('Location: index.php');
	}
?>

<div>
	<form name="professorSearch" method="post" id="professor" action="search.php">
		<table style="margin:20px; margin-top:-20px;">
                        <input type = "hidden" name = "hiding" value = "submitted">
			<tr><td><h3>Instructor: </h3></td><td> <input type="text" name="prof" id="prof" maxlength="30"/></td></tr>
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
                               	<option value="CPSC">Computer Science</option>
				<option value="FSEM">Freshmen Seminar</option>
				<option value="MATH">Math</option>
				<option value="EDUC">Education</option>
				<option value="PHIL">Philosophy</option>
				<option value="OTHR">Other</option>
			</select></td>
		</table>

		<table>
        		<td>&nbsp;</td><td><input type="submit" value="Search" /></td>
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

	$query = $query." ORDER BY Time ASC, Name, Department, Days";

	$result = mysqli_query($db, $query);
	
	if ($_POST['hiding'] == "submitted")
	{
		echo "<hr>";
		echo "<center><table id=\"hor-minimalist-b\"><tr><th>Class</th><th>Instructor</th><th width=\"100\">Time</th><th>Room</th><th>Day(s)</th>
			<th>Dept</th></tr>";
	}
	
	while ($row = mysqli_fetch_array($result))
	{
		$Instructor = $row['Instructor'];
		$Time = $row['Time'];
		$Room = $row['Room'];
		$Dept = $row['Department'];
		$Name = $row['Name'];
		$Length = $row['Length'];
		$Day = $row['Days'];

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
				
		echo "<tr><td>$Name</td><td>$Instructor</td><td>$strTime</td><td>$Room</td><td>$Day</td><td>$Dept</td></tr>";
	}
	
	echo "</table></center>";
	/*else
	{
		echo "<p>Sorry, I did not find what you where searching for</p>\n";
	}*/
?>

</div>

</body>

</html>
