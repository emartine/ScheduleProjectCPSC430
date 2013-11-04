<?php
	session_start();
	include "header.html"
?>
<?php
	error_reporting(~E_ALL);
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Book Index </title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>

	<body>
	
	<div id="contents">
	
		<?php
			include "db_connect.php";
			
			$query = "SELECT * FROM Reservations SORT BY Time;";
			$result = mysqli_query($db, $query);
			
			echo "<table width=\"100%\" border=\"1\" cellpadding=\"2\">";
			echo "<tr style=\"background-color:#DDD; text-align:center;\"";
			echo "<td><h4>Time</h4></td>";
			echo "<td><h4>B36</h4></td>";
			echo "<td><h4>B52</h4></td>";
			echo "<td><h4>B6</h4></td>";
			echo "<td><h4>B7</h4></td>";
          		echo "<td><h4>B39</h4></td>";
          		echo "<td><h4>106A</h4></td>";
          		echo "<td><h4>119</h4></td>";
          		echo "<td><h4>138</h4></td>";
          		echo "<td><h4>140</h4></h4></td>";
          		echo "<td><h4>204</h4></td>";
          		echo "<td><h4>210</h4></td>";
          		echo "<td><h4>243</h4></td></tr>";

			int time = 800;

			while (time < 1700)
			{
				echo "<tr><td>time</td>";
				
				while($row = mysqli_fetch_array($result)) 
				{	
					if ($time == time && $room == 'B36')
					{
						$instructor = $row['Instructor'];
                                        	$time = $row['Time'];
                                        	$length = $row['Length'];
                                        	$room = $row['Room'];
                                        	$dept = $row['Department'];
						
					}
					echo "<tr><td>time</td>";

				if ($room = 'B36')
				{
					echo "
				}
				
				echo "<tr><td>$title</td><td>$author</td><td>$subject</td><td><a href = 'redirectProfile.php?user=$user'> $user </a></td></tr>\n";			
			}
			echo "</table>"; 
		?>
	</div>
	

 <table width="100%" border="1" cellpadding="2">
	  <tr style="background-color:#DDD; text-align:center;">
	  <td><h4>Time</h4></td>
	  <td><h4>B36</h4></td>
	  <td><h4>B52</h4></td>
	  <td><h4>B6</h4></td>
	  <td><h4>B7</h4></td>
	  <td><h4>B39</h4></td>
	  <td><h4>106A</h4></td>
	  <td><h4>119</h4></td>
	  <td><h4>138</h4></td>
	  <td><h4>140</h4></h4></td>
	  <td><h4>204</h4></td>
	  <td><h4>210</h4></td>
	  <td><h4>243</h4></td>
	  </tr></table>
	</body>
</html>
