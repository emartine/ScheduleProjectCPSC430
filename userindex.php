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
	<title>User Index </title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<h1 style = "margin-top:0px;"> User Index </h1>
</head>

	<body link='#FFFF33' vlink='#FFFF33'>
	
	<div id="contents">
	
		<?php
			include "db_connect.php";
			
			$query = "SELECT * FROM User ORDER BY User;";
			$result = mysqli_query($db, $query);
			
			if ($_SESSION['privilege'] == "ADMN")
			{
				echo "<center><table id=\"hor-minimalist-b\">\n<tr><th>Name</th><th>Email</th><th>Department</th><th>Delete</th><tr>\n\n";
			}
			else
			{	
				echo "<center><table id=\"hor-minimalist-b\">\n<tr><th>Name</th><th>Email</th><th>Department</th><tr>\n\n";
			}

			while($row = mysqli_fetch_array($result)) 
			{
				$user = $row['User'];
				$email = $row['UMWEmail'];
				$department = $row['Dept'];
				$id = $row['ID'];
				
				if ($_SESSION['privilege'] == "ADMN" && $department != "ADMN")
				{
					echo "<tr><td>$user</td><td>$email</td><td>$department</td><td><a href=\"removeUser.php?id=$id\">Remove</a></td></tr>\n";
				}
				else if ($_SESSION['privilege'] == "ADMN" && $department == "ADMN")
				{
					echo "<tr><td>$user</td><td>$email</td><td>$department</td><td>CANNOT</td></tr>\n";
				}
				else
				{
					echo "<tr><td>$user</td><td>$email</td><td>$department</td></tr>\n";
				}
			}
			
			echo "</table></center>\n"; 
		?>
	</div>
	
	</body>
</html>
