<?php
	require_once("mysql.php");

	$action = $_GET['action'];


	if($_GET['pass'] == "oursecret")
	{
		$id = $_GET['id'];
		$result = mysql_query("SELECT name, email FROM users WHERE id = '$id'");
		$row = mysql_fetch_assoc($result);
		$name = $row['name'];
		$email = $row['email'];
		if($action == "approve")
		{
			$password = $_POST['confirmation'];
			$pass = md5($password);
			mysql_query("UPDATE users SET status = 'APPROVED', password = '$pass'  WHERE id = '$id'");
			$subject = "PIN Approved";
			$from = "from: PIN Service Request <lunch@mitchbarry.com>";
			$msg = "Your request for a PIN is approved. Set your pin at http://www.mitchbarry.com/lunch/setpin.php?id=" . $id . "&confirmation=" . $password;
			mail($email,$subject,$msg,$from);
			header("Location: approve.php?action=approved");
		}
		else if($action == "deny")
		{
			mysql_query("DELETE FROM users WHERE id = '$id'");
			$subject = "PIN Denied";
			$from = "from: PIN Service Request <lunch@mitchbarry.com";
			$msg = "Your request for a PIN has been denied. Abuse of the system is not tolerated. If you feel this is a mistake, ";
			$msg .= "please contact Mitch and Darin.";
			mail($email,$subject,$msg,$from);
			header("Location: approve.php?action=denied");
		}
	}
	else if($action != "approved" && $action != "denied")
		header("Location: index.php");


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Register PIN</title>
	</head>
	<body>
		<table align="center" width="400px">
		<?php
			if(empty($action))
			{
				echo "<form action=\"approve.php?action=approve&pass=oursecret&id=" . $id . "\" method=\"post\">";
				echo "<tr><td align=\"right\">Name:</td><td>" . $name . "</td></tr>";
				echo "<tr><td align=\"right\">Email:</td><td>" . $email . "</td></tr>";
				echo "<tr><td align=\"right\">Confirmation:</td><td><input name=\"confirmation\" type=\"text\"/></td></tr>";
				echo "<tr><td></td><td><input type=\"submit\" value=\"Confirm\"/></td></tr>";
				echo "</form>";
				echo "<form action=\"approve.php?action=deny&pass=oursecret&id=" . $id . "\" method=\"post\">";
				echo "<tr><td></td><td><input type=\"submit\" value=\"Deny\"/></td></tr>";
				echo "</form>";
			}
			else if($action == "approved")
			{
				echo "<tr><td>User Approved</td></tr>";
			}
			else if($action == "denied")
			{
				echo "<tr><td>User PIN Request Denied</td></tr>";
			}
		?>
		</table>
	</body>
</html>


