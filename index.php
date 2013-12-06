<?php
	session_start();
?>

<?php
	error_reporting(~E_ALL);
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Log In</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body style="background-image:url('indexbg.jpg'); background-size:100%;">
<h1 style="margin-top:0px; font-size:48px; font-weight:normal;
text-shadow:
	-1px -1px 0 #999,
	1px -1px 0 #999,
	-1px 1px 0 #999,
	1px 1px 0 #999;
color:#FFF;
text-align:center;">UMW Course Scheduler</h1>

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
            header('Location: http://rosemary.umw.edu/~gparvez/textbook/editProfile.php');
        }
        else
        {
        	if ($name != null)
            {
            	echo "<p>Incorrect username or password</p>\n";
            }
            
            echo "<form method=\"post\" action=\"index.php\" style=\"text-align:left;\">";
            echo "<label for=\"username\"><h3 style=\"color:#FFF;
			text-shadow:
        		-1px -1px 0 #666,
        		1px -1px 0 #666,
        		-1px 1px 0 #666,
        		1px 1px 0 #666;
			font-family:Arial, Helvetica, Tahoma;
			font-weight:bold;

			\">Username:</h3></label><input type=\"text\" id=\"username\" name=\"username\"  style=\"background-color:#FFF;\"/><br />";
            echo "<label for=\"pw\"><h3 style=\"color:#FFF;
				text-shadow:
        		-1px -1px 0 #666,
        		1px -1px 0 #666,
		        -1px 1px 0 #666,
        		1px 1px 0 #666;
			font-family:Arial, Helvetica, Tahoma;
			font-weight:bold;

			\">Password:</h3></label><input type=\"password\" id=\"pw\" name=\"pw\" style=\"background-color:#FFF; \"/><br />";
            echo "
            	<table>
					<tr>
                    	<td>
                        	<input type=\"submit\" value=\"Login\" name=\"submit\" style=\"margin-left:0em; background-color:#FFF;\" >
                            </form>
                        </td>
                    </tr>
                </table>";
		}
	?>
</div>

</body>

</html>