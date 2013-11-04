<?php session_start(); ?> 
<div class="bgheader">
<p>UMW Course Scheduler</p>
</div>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Home Page </title>
  <link rel="stylesheet" type="text/css" href="style.css" />

</head>
<body>

<!-- CONTENT -->
	<h3 style="margin-left:30px;margin-top:-20px;"><strong>Trinkle Hall</strong>: Please log in or register.</h3>
	<form method = "post" action = "Login.php">
	<table>
	<tr><td>&nbsp;</td><td><input type="submit" value="Login" /></td>
		
	</form>
	<form method = "post" action = "createAccount.php">
	<td>&nbsp;</td><td><input type="submit" value="Register" /></td>
	</form>

	<!-- END CONTENT -->
				
</body>
</html>
