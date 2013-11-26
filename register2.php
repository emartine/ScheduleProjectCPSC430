<?php
	session_start();

	if ($_SESSION['username'] == null)
	{
		header('Location: index.php');
	}
	include "header.html";
	include "db_connect.php";
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>You can't Register people </title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>

<div>

	<center><h2>Sorry, you do not have the ability to register new users, please contact the admins of this website</h2></center>		

</div>

</body>

</html>	
