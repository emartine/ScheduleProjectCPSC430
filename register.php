<?php 
	session_start(); 
?>
<?php
	error_reporting(~E_ALL);
	include "header.html";
	include "db_connect.php";

	if ($_SESSION['username'] == null)
	{
		//header('Location: http://rosemary.umw.edu/~gparvez/textbook');
		header('Location: index.php');
	}

	if ($_SESSION['privilege'] != "ADMN")
	{
		//header('Location: http://rosemary.umw.edu/~gparvez/textbook/register2.php');
		header('Location: register2.php');
	}
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Registration</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<center><h1 style = margin-top:0px;>Register a New User</h1></center>

<body>

<div>
	<form method = "post" action = "register.php">
		<table style="margin:20px; margin-top:-20px;">
			<input type = "hidden" name = "hiding" value = "submitted">
			<tr><td><h3>User Name</h3></td><td><input type="text" id="username" name="username" maxlength="30" /></td></tr>
			<tr><td><h3>Password</h3></td><td><input type="text" id="password" name="password" maxlength="20" /></td></tr>
			<tr><td><h3>UMW Email</h3></td><td><input type="text" id="email" name="email" maxlength="30" /></td></tr>
			<tr><td><h3>Department</h3></td><td>
				<select id="dept" name="dept"/>
					<option value="CPSC">Computer Science</option>
					<option value="FSEM">Freshmen Seminar</option>
					<option value="MATH">Math</option>
					<option value="EDUC">Education</option>
					<option value="PHIL">Philosophy</option>
					<option value="OTHR">Other</option>
					<option value="ADMN">Admin</option>
				</select>
			</td></tr>	
		</table>
		<table>
			<td>&nbsp;</td><td><input type="submit" value="Register" /></td>
		</table>					
	</form>		
	
	<?php
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$dept = $_POST['dept'];

		if ($username == null || $password == null || $email == null || $dept == null)
		{
			if ($_POST['hiding'] == "submitted")
			{
				echo "<h3><font size=\"3\">You left a field above empty</font></h3>";
			}
		}
		else
		{	
			$search = "SELECT * FROM User WHERE User = '$username';";
			$searchquery = mysqli_query($db, $search);
			$row = mysqli_fetch_array($searchquery);

			if ($row == null)
			{
				$insertInto = "INSERT INTO `schedule?group2`.`User` (`ID`, `User`, `Pass`, `UMWEmail`, `Dept`) VALUES (NULL, '$username', SHA('$password'),
				'$email', '$dept');";
				$insertIntoQuery = mysqli_query($db, $insertInto);
				echo "<h3><font size=\"3\">That user has now been registered</font></h3>";
			}
			else
			{
				echo "<h3><font size=\"3\">Sorry, that username is already taken</font></h3>";
			}
		}
	?>	
</div>

</body>

</html>	
