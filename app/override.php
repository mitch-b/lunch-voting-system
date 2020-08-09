<?php
	if($_GET['pass']!="oursecret")
		header("Location: index.php");
 	
	require_once("mysql.php");	
	if($_GET['action']=="override")
	{
		$restaurant = $_POST['place'];
		$pass = md5("oursecret");
		mysql_query("DELETE FROM restaurant WHERE '1'='1'");
		mysql_query("INSERT INTO restaurant (name,pin) VALUES ('$restaurant','$pass')") or die(mysql_error());
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xlm:lang="en" lang="en">
	<head>
		<title>Override</title>
	</head>
	<body>
		<table align="center" width="600px" rules="none">
			<form action="override.php?action=override&pass=oursecret" method="post">
			<?php
				if($_GET['action']=="override")
					echo "<tr><td>OVERRIDE COMPLETE</td></tr>";
			?>
			<tr><td>Override the Votes</td></tr>
			<tr><td>Restaurant: <input name="place" type="text" maxlength="75"/></td><tr>
			<tr><td><input type="submit" value="Override"/></td></tr>
			</form>
		</table>
	</body>
</html>
