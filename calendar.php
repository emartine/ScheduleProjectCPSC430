<?php
	session_start();
	include "header.html"
?>
<?php
//	error_reporting(~E_ALL);
	
	if ($_SESSION['username'] == null)
	{
		//header('Location: http://rosemary.umw.edu/~gparvez/textbook');
		header('Location: index.php');
	}

	$day = $_POST['day'];
                    
	//Sets up MWF as default day if $day = null
        if ($day == null)
        {
      		$day = "MWF";
        }
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Calendar</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>

<?php
	echo "<h1 style=\"margin-top:0px;\">Calendar</h1>";
	echo "<h3 style=\"color:#999; margin-top:-25px; margin-left:50px;\">Viewing: <strong>$day</strong></h3>";
?>	
	<!-- Handles the MTWRF selection stuff -->
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
				
			//Array that keeps track when to put an empty cell in, sames length as roomList, so if an extra room is added enter an extra ZERO!!
			$cell = array(0,0,0,0,0,0,0,0,0,0,0,0);
			
			// variables to be used in code that figures out what to write
			$time = 8;
			$timeLoop = 1;
			$clock = 800;
			$count = count($roomList);
			//variables to be used in code that figure out how the table should look like
			$height = 1900;
			$width = 100/($count+1);
			$timeH = 100;
			$color = "#FFFFFF";
			$fontC = "#FFFFFF";

			//Start the table and table style
			echo "<table width=\"95%\" align=\"center\" class=\"schedule\" border=\"0\" height=\"$height\">";
				//show which set of day/s has been selected 
				echo "<tr><th><h3>$day</h3></th>";
				//print out rooms from room array
				for ($x = 0; $x < $count; $x++)
				{
					echo "<th width=\"$width%\" height=\"50\"><h3>$roomList[$x]</h3></th>";
				}
				echo "</tr>";
				//Loop through the rest of calendar starting from 8 to 9:30 and filling in classes as it goes	
				while ($time < 22)
				{
					if ($time > 12)
					{
						$time = $time - 12;
						if (($timeLoop % 2) == 1)
						{
							echo "<tr><th height=\"$timeH\" width=\"$width%\"><h3>$time:00pm</h3></th>";
						}
						else
						{
							echo "<tr><th height=\"$timeH\" width=\"$width%\"><h3>$time:30pm</h3></th>";
						}
						$time = $time + 12;
					}
					else if ($time == 12)
					{
						if (($timeLoop % 2) == 1)
						{
							echo "<tr><th height=\"$timeH\" width=\"$width%\"><h3>$time:00pm</h3></th>";
						}
						else
						{
							echo "<tr><th height=\"$timeH\" width=\"$width%\"><h3>$time:30pm</h3></th>";
						}
					}
					else
					{
						if (($timeLoop % 2) == 1)
						{
							echo "<tr><th height=\"$timeH\" width=\"$width%\"><h3>$time:00am</h3></th>";
						}
						else
						{
							echo "<tr><th height=\"$timeH\" width=\"$width%\"><h3>$time:30am</h3></th>";
						}
					}

					for ($x = 0; $x < $count; $x++)
					{
						//correctly gathers all classes based on day ie MWF contain all classes on M,W,F and any combination of the three
						$query = "SELECT * FROM Reservations WHERE Room = '$roomList[$x]' AND (Days LIKE '%$day%'";
						for ($y = 0; $y < strlen($day); $y++)
						{
							$query = $query." OR Days LIKE '%$day[$y]%'";
						}
						$query = $query.") AND Time = '$clock';";
						$result = mysqli_query($db, $query);
						$row = mysqli_fetch_array($result);
						
						//does the query have any results? and have it already been done thorugh conflicts (cell[x])?
						if ($row != null && $cell[$x] == 0)
						{
							$done = 0;
							// Time for the next query when looped if conflicts are found
							$startTime = $clock;
							// How far in time to look for conflicts
							$duration = 0;
							$result = mysqli_query($db, $query);

							while ($done == 0)
							{
								while ($row = mysqli_fetch_array($result))
								{
									$length = $row['Length'];
									$dept = $row['Department'];

									$classTime = $row['Time'];
									$classTimestr = (string)$classTime;

									$tempDuration = 0;
									$digit = 0;
									$tempNum = 0;

									if ((strlen($classTimestr)) == 3)
									{
										$tempNum = ((int)$classTimestr[0]) * 100;

										$digit = (int)substr($classTimestr,1);
										$digit = $digit + $length;

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
										$digit = $digit + $length;

										while ($digit >= 60)
										{
											$tempDuration = $tempDuration + 100;
											$digit = $digit - 60;
										}
										$tempDuration = $tempDuration + $digit;
										$tempNum = $tempNum + $tempDuration;
									}
									if ($tempNum > $duration)
									{
										$duration = $tempNum;
									}
								}
								// Run a query to see if classes conflict
								$query = "SELECT * FROM Reservations WHERE Room = '$roomList[$x]' AND (Days LIKE '%$day%'";
								for ($y = 0; $y < strlen($day); $y++)
								{
									$query = $query." OR Days LIKE '%$day[$y]%'";
								}
								$query = $query.") AND Time < '$duration' AND Time > '$startTime' ORDER BY Time ASC;";
								$result = mysqli_query($db, $query);
								$row = mysqli_fetch_array($result);

								// if no classes conflict go on, else loop all over again
								if ($row == null)
								{
									$done = 1;
								}
								else
								{
									$startTime = $row['Time'];
									$result = mysqli_query($db, $query);
								}
							}
							//The query below contains all classes that are in conflict
							$query = "SELECT * FROM Reservations WHERE Room = '$roomList[$x]' AND (Days LIKE '%$day%'";
							for ($y = 0; $y < strlen($day); $y++)
							{
								$query = $query." OR Days LIKE '%$day[$y]%'";
							} 
							$query = $query.") AND Time < '$duration' AND Time >= '$clock' ORDER BY Time ASC;";
							$result = mysqli_query($db, $query);
							// Get the length of the conflicts
							$duration = $duration - $clock;
							$tempDuration = 0;

							if ($duration >= 60 && $duration <= 99)
							{
								$duration = 60;
							}

							while ($duration >= 100)
							{
								$tempDuration = $tempDuration + 60;
								$duration = $duration - 100;
							}

							if ($duration >= 60 && $duration <= 99)
							{
								$duration = $tempDuration + 30;
							}
							else
							{
								$duration = $tempDuration + $duration;
							}

							//How many results are there?
							$rowCount = mysqli_num_rows($result); 
							
							//For combination days ie. MWF,TR,etc, check to see if classes are in conflicting days or different days
							$xx = 0;
							$yy = 0;
							$conflict = 0;
							$result = mysqli_query($db, $query);
							while($row = mysqli_fetch_array($result))
							{
								$dayCompare = $row['Days'];
								$dayLength = strlen($dayCompare);
								$result1 = mysqli_query($db, $query);
								while ($rowZ = mysqli_fetch_array($result1))
								{
									if ($xx < $yy)
									{
										$tempDay = $rowZ['Days'];
										$roomN = $rowZ['Room'];
										for ($yyy = 0; $yyy < $dayLength; $yyy++)
										{
											if (strpos($tempDay,$dayCompare[$yyy]) !== false)
											{
												$conflict = 1;
											} 
										}
									}
									$yy = $yy + 1;
								}
								$xx = $xx + 1;
								$yy = 0;
							}

							// Add background color to table, if there are conflicts it will be black else it depends on dept
							if ($rowCount > 1 && $conflict == 1)
							{
								$color = "#000000";
								$fontC = "#FFFFFF";
							}
							else if ($rowCount > 1 && $conflict == 0)
							{
								$color = "#FFFF00";
								$fontC = "#000000";
							}
							else if ($dept == "CPSC")
							{
								$color = "#009900";
								$fontC = "#FFFFFF";
							}		
							else if ($dept == "MATH")
							{
								$color = "#FF0000";
								$fontC = "#FFFFFF";
							}
							else if ($dept == "PHIL")
							{
								$color = "#FF00FF";
								$fontC = "#FFFFFF";
							}
							else if ($dept == "EDUC")
							{
								$color = "#0099FF";
								$fontC = "#FFFFFF";
							}
							else if ($dept == "FSEM")
							{
								$color = "#9966FF";
								$fontC = "#FFFFFF";
							}
							else
							{
								$color = "#808080";
								$fontC = "#FFFFFF";
							}

							for ($span = 1; $span < 30; $span++)
							{
								if ($duration <= (30 * $span))
								{
									$rowSpan = $span;
									//break out the loop
									$span = 31;
								}
							}

							$num = $rowCount;
							echo "<th rowspan=\"$rowSpan\" width=\"$width%\" bgcolor=\"$color\"><font size=\"2\" color=\"$fontC\">";
							$result = mysqli_query($db, $query);
							while ($row = mysqli_fetch_array($result))
							{
								$name = $row['Name'];
								$department = $row['Department'];
								$creator = $row['Creator'];
								$id = $row['ID'];

								echo "$name<br />";
								if ($_SESSION['privilege'] == "ADMN" || $_SESSION['privilege'] == $department || $_SESSION['username'] == $creator)
								{
									echo "<a href=\"remove.php?id=$id\">Delete</a>";
								}
								$num = $num - 1;
								if ($num != 0)
								{
									echo "<hr>";
								}
							}
							echo "</font color></th>";
							$cell[$x] = $rowSpan - 1;
						}
						//Was empty so lets put in some empty cells...or not
						else
						{
							//Correctly put the empty cells if needed, based on cell array
							if ($cell[$x] == 0)
							{
								echo "<td width=\"$width%\"></td>";
							}
							else if ($cell[$x] >= 1)
							{
								$cell[$x] = $cell[$x] - 1;
							}
						}
					}

					echo "</tr>";
					// Set for the next time and variables as necessary		
					if (($timeLoop % 2) == 1)
					{
						$clock = $clock + 30;
					}
					else
					{
						$clock = $clock + 70;
						$time = $time + 1;
					}
						
					$timeLoop = $timeLoop + 1;
				}
			echo "</table>";
		?>
	</body>
</html>
