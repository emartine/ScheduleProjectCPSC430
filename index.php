<?php
	session_start();
?>

<?php
        error_reporting(~E_ALL);
?>

<div class="bgheader">
	<p>UMW Course Scheduler</p>
</div>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Log In</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<h1 style=\"margin-top:0px;\">Log In</h1>

<body>

<div id="contents">
	<?php
  		include "db_connect.php";
   
  		if ($_POST['username'] != null)
  		{
                	$name = $_POST['username'];
  		}
  		else
  		{
                	$name = null;
  		}
  		
		if ($_POST['pw'] != null)
  		{
                	$pw = $_POST['pw'];
  		}
  		else
  		{
                	$pw = null;
  		}
        
   		$query = "Select * from User WHERE User = '$name' AND pass = SHA('$pw')";
   		$result = mysqli_query($db, $query);
   
   		if ($row = mysqli_fetch_array($result))
   		{
			$privilege = $row['Dept'];
                   	//echo "<p>Thanks for logging in, $name</p>\n";
                   	//echo "<p><a href=\"editProfile.php\">Continue</a></p>";
                	$_SESSION['username']=$name;
                	$_SESSION['profile']= $name;
			$_SESSION['privilege'] = $privilege;
			header('Location: editProfile.php');
   		}
  		else
    		{
                	if ($name != null)
                	{
                        	echo "<p>Incorrect username or password</p>\n";
                	}
                   	echo "<form method=\"post\" action=\"index.php\">";
			echo "<label for=\"username\"><h3>Username:</h3></label><input type=\"text\" id=\"username\" name=\"username\" /><br />";
        		echo "<label for=\"pw\"><h3>Password:</h3></label><input type=\"password\" id=\"pw\" name=\"pw\" /><br />";
                	echo "
                        	<table>
                                	<tr>
                                        	<td>
                                                	<input type=\"submit\" value=\"Login\" name=\"submit\">
                                                	</form>
                                        	</td>
                                	</tr>
                        	</table>";
    		}
	?>
</div>

</body>

</html>
