<?php
	session_start();
	include "header.html"
?>
<?php
//	error_reporting(~E_ALL);
	$day = $_POST['day'];
                    
	//Sets up MWF as default day if $day = null
        if ($day == null)
        {
      		$day = "MWF";
        }
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Calendar</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>

	<body>
<?php
	echo "<h1 style=\"margin-top:0px;\">Calendar</h1>";
	echo "<h3 style=\"color:#999; margin-top:-25px; margin-left:50px;\">Viewing: <strong>$day</strong></h1>";
?>	
	<div class="options" style="margin-top:-60px;">
		<h3 style="text-align:right;color:#999; margin-top:0px; margin-bottom:5px;">Select Range</h3>

        	<table align="right">
			<tr>
				<form method = 'post' action = "calendar.php">
				<input type = "hidden" name = "day" value = "MWF">
				<td>&nbsp;</td> <td><input type = 'submit' value = 'MWF'/></td>
				</form>
				<td>
				<form method = 'post' action = "calendar.php">
                                <input type = "hidden" name = "day" value = "TR">                  
				<td>&nbsp;</td> <td><input type = 'submit' value = 'TR'/></td>
                                </form>
				</td> 
				<td>
                                <form method = 'post' action = "calendar.php">
                                <input type = "hidden" name = "day" value = "M"> 
				<td>&nbsp;</td> <td><input type = 'submit' value = 'M'/></td>
                                </form>
                                </td>
				<td>
				<form method = 'post' action = "calendar.php">
                                <input type = "hidden" name = "day" value = "T">                                
				<td>&nbsp;</td> <td><input type = 'submit' value = 'T'/></td>
                                </form>
                                </td>
                                <td>
                                <form method = 'post' action = "calendar.php">
                                <input type = "hidden" name = "day" value = "W">
				<td>&nbsp;</td> <td><input type = 'submit' value = 'W'/></td>
                                </form>
                                </td>
	                        <td>
                                <form method = 'post' action = "calendar.php">
                                <input type = "hidden" name = "day" value = "R">
                                <td>&nbsp;</td> <td><input type = 'submit' value = 'R'/></td>
                                </form>
                                </td>
                                <td>
                                <form method = 'post' action = "calendar.php">
                                <input type = "hidden" name = "day" value = "F">
                                <td>&nbsp;</td> <td><input type = 'submit' value = 'F'/></td>
                                </form>
                                </td>
			</tr>
		</table>
	</div>
	<br/>	
		<?php
			include "db_connect.php";
		
			// Array of rooms in Trinkle
			$roomList = array("B36","B52","B6","B7","B39","106A","119","138","140","204","210","243");

			//Start the table and table style
			echo "<table width=\"95%\" align=\"center\" class=\"schedule\" border=\"0\">";
                        echo "<tr>";
		
			//Set up Time column <currently only fits the MWF class format>
			echo "<td><h3>Time</h3>";
			if ((strpos($day, 'M') !== FALSE) || (strpos($day, 'W') !== FALSE) || (strpos($day, 'F') !== FALSE))
			{
				$time = 8;
                        	while ($time < 23)
                        	{
                                	echo "<div class=\"course\">";
                                	if ($time > 12)
                                	{
                                        	$time = $time - 12;
                                  	      	echo "<br />";
                             	        	echo "<br />";
                                	        echo "$time:00pm<br />";
                                        	echo "<br />";
                                        	$time = $time + 12;
                                	}
                                	else if ($time == 12)
                                	{
                                        	echo "<br />";
                                        	echo "<br />";
                                        	echo "$time:00pm<br />";
                                        	echo "<br />";
                                	}
                                	else
                                	{
                                        	echo "<br />";
                                        	echo "<br />";
                                        	echo "$time:00am<br />";
                                       	 	echo "<br />";
                                	}
                                	echo "</div><br />";
                                	$time = $time + 1;
                        	}
			}
			else
			{
				$time = 8;
				$timeLoop = 1;
				while ($time < 23)
				{
					echo "<div class=\"course\">";
					if ($time > 12)
					{
						$time = $time - 12;
						echo "<br />";
                                                echo "<br />";
						if (($timeLoop % 2) == 1)
						{
                                                	echo "$time:00pm<br />";
						}
						else 
						{
							echo "$time:30pm<br />";	
						}
                                                echo "<br />";
                                                $time = $time + 12; 
					}
					else if ($time == 12)
					{
						echo "<br />";
                                                echo "<br />";
                                                echo "$time:30pm<br />";
                                                echo "<br />";
					}
					else
					{
                                                echo "<br />";
                                                echo "<br />";
                                                if (($timeLoop % 2) == 1)
                                                {
                                                        echo "$time:00am<br />";
                                                }
                                                else
                                                {
                                                        echo "$time:30am<br />";
                                                }
                                                echo "<br />";
					}
					echo "</div><br />";
					$time = $time + 1;
					$timeLoop = $timeLoop + 1;
				}
			}
                        echo "</td>";
			
			//loop through array and create the calendar view
			for ($x = 0; $x < count($roomList); $x++)
			{
				//the query is changed every loop to the next room in the array above
				$query = "SELECT * FROM Reservations WHERE Room = '$roomList[$x]' AND Days LIKE '%$day%' ORDER BY Time;";
                        	$result = mysqli_query($db, $query);
				
				echo "<td><h3>$roomList[$x]</h3>";
                        	$clock = 800;
                        	while ($row = mysqli_fetch_array($result))
                        	{
                                	$time = $row['Time'];

                                	while ($time != $clock)
                                	{
                                        	echo "<div class=\"course\">";
         	                               	echo "<br />";
                	                        echo "<br />";
                        	                echo "<br />";
                                	        echo "<br />";
                                	        echo "</div><br />";

                                        	$clock = $clock + 100;
                          	      	}

                                	$instructor = $row['Instructor'];
                                	$length = $row['Length'];
                                	$dept = $row['Department'];
					$name = $row['Name'];
                                	echo "<div class=\"course\">$name<br />";
					echo "$instructor<br />";
 //                               	echo "Time: $time <br />";
                                	echo "$length Min<br />";
                                	echo "$dept <br />";
                                	echo "</div><br />";

                                	$clock = $clock + 100;
                        	}
                        	while ($clock != 2300)
                        	{
                                        echo "<div class=\"course\">";
                                        echo "<br />";
                                        echo "<br />";
                                        echo "<br />";
                                        echo "<br />";
                                        echo "</div><br />";
                                	$clock = $clock + 100;
                        	}
                        	echo "</td>";
			}
			
			//end table row
			echo "</tr>";
			//end table
                        echo "</table>";
		?>
		

	</body>
</html>
