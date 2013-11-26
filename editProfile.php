<?php
	session_start();
	include "header.html"
?>
<?php
	error_reporting(~E_ALL);

	if ($_SESSION['username'] == null)
	{
		//header('Location: http://rosemary.umw.edu/~gparvez/textbook');
		header('Location: index.php');
	}
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Profile Page </title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
	<body link='#FFFF33' vlink='#FFFF33'>
	<div id="contents">
			
		<?php
			include "db_connect.php";
		
			$username = $_SESSION['username'];
			$profile  = $_SESSION['profile'];

			//SQL for Email
			$queryMail = "SELECT UMWEmail FROM User WHERE User = '$profile'";
			$resultMail = mysqli_query($db, $queryMail);
			
			//Sets the variables beforehand for profile
			
			if ($username == $profile)
			{
				//Password Controller
				if ($_POST['oldpassword'] != null || $_POST['newpassword'] != null || $_POST['newpassword1'] != null )
				{
					$oldPassword = $_POST['oldpassword'];
					$newPassword = $_POST['newpassword'];
					$newPassword1 = $_POST['newpassword1'];
					if ($newPassword != $newPassword1)
					{
						$errorString = "The New Passwords you have entered do not match one another";
					}
					else
					{
						$queryComparePass = "SELECT * FROM User WHERE User = '$profile' AND Pass = SHA('$oldPassword')";
						$resultCompare = mysqli_query($db, $queryComparePass);
						if ($row1 = mysqli_fetch_array($resultCompare))
						{
							$querySetPass = "UPDATE User SET Pass = SHA('$newPassword') WHERE User = '$profile'";
							if (mysqli_query($db, $querySetPass))
							{
								$errorString = "You have changed your password";	
							}
						}
						else
						{
							$errorString = "The Current Password you have entered does not match your Current Password";
						}
					}
				}
				else { $errorString = "NULL"; }
				//Email Controller
				if ($_POST['email'] == null)
				{
					if ($row = mysqli_fetch_array($resultMail))
					{
						$email = $row['UMWEmail'];
					}
					else
					{
						$email = "N/A";
					}
				}
				else
				{
					$setEmail = $_POST['email'];
					$querySetMail = "UPDATE User SET UMWEmail = '$setEmail' WHERE User = '$profile'";
					if (mysqli_query($db, $querySetMail))
					{
						$resultGetMail = mysqli_query($db, $queryMail);
						if ($row = mysqli_fetch_array($resultGetMail))
						{
							$email = $row['UMWEmail'];
						}
					}
				}
			}
			else
			{
				// Set Email
				if ($row = mysqli_fetch_array($resultMail))
				{
					$email = $row['UMWEmail'];
				}
				else
				{
					$email = "N/A";
				}
			}
			//This displays the profile according to who is viewing it
			if ($username == $profile)
			{
				echo "<center><h1 style=\"margin-top:-60px; margin-left:0px;\">Edit Profile</h1></center>";
				echo "<center><h3 style=\"color:#999; margin-top:-25px; margin-left:40px; \">User: <strong>$profile</strong></h3></center>";
				//Change Password Form
				echo "<form method=\"post\" action=\"editProfile.php\">";
				echo "<h3>Change Password</h3>";
				echo "<label for=\"oldpassword\">Current Password</label><input type=\"password\" name=\"oldpassword\" /><br/>";
				echo "<label for=\"newpassword\">New Password</label><input type=\"password\" name=\"newpassword\" /><br/>";
				echo "<label for=\"newpassword1\">Re-enter New Password</label><input type=\"password\" name=\"newpassword1\" />";
				echo "<input type=\"submit\" value=\"Change Password\" ><br/>";
				if ($errorString != "NULL")
				{
					echo "<h3><font size=\"3\">$errorString</font></h3>";
				}

				//Change Email Form
				echo "<form method=\"email\" action=\"editProfile.php\">";
				echo "<h3>Change Email</h3>";
				echo "<label for=\"email\"><h2>Current Email: $email</h2>Edit Email :</label><input type=\"text\" maxlength=\"30\" id=\"email\"
					 name=\"email\" />";
				echo "<input type=\"submit\"value=\"Change Email\" /><br/>";
			}

			echo "<hr>";
			$privilege = $_SESSION['privilege'];
				
			echo "<center><h3 style=\"color:#999; margin-top: 25px; margin-left:40px; \">Department: <strong>$privilege</strong></h3></center>";

			$query = "Select * from Reservations Where Creator = '$username' OR Department = '$privilege'"; 

			if ($_SESSION['privilege'] == "ADMN")
			{
				$query = "Select * from Reservations";
			}

			$query = $query." Order by Time ASC;";

			$queryAct = mysqli_query($db, $query);

			echo "<center><table id=\"hor-minimalist-b\">";

			echo "<tr><th width=\"160\">Class</th><th>Instructor</th><th>Time</th><th>Room</th><th>Day(s)</th><th>Dept</th><th>Delete</th></tr>";
			while($row = mysqli_fetch_array($queryAct))
			{
				$name = $row['Name'];
				$teacher = $row['Instructor'];
				$room = $row['Room'];
				$dept = $row['Department'];
				$day = $row['Days'];
				$Time = $row['Time'];
				$id = $row['ID'];

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
				echo "<tr><td>$name</td><td>$teacher</td><td>$strTime</td><td>$room</td><td>$day</td><td>$dept</td>
					<td><a href=\"remove.php?id=$id\">Remove</a></td></tr>";
			}
			echo "</table></center>";

			if ($privilege == "ADMN")
			{
				echo "<hr>";
				echo "<center><h3 style=\"color:#999; margin-top: 25px; margin-left:40px; \">REMOVE ALL CLASSES</h3></center>";
				echo "<center><a href=\"removeAllRes.php\"><font color=\"#000000\">GO TO REMOVE ALL PAGE</font></a></center>";
			}
		?>
			
	</div>
	
	</body>
</html>
	
