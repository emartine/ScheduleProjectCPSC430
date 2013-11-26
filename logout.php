<?php session_start(); ?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Log Out </title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
	<?php
		session_destroy();
		header('Location: index.php');
	?>
</body>

</html>
