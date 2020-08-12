<?php
require_once("mysql.php");
require_once("include/smtp.settings.php");

$action = $_GET['action'];


if ($_GET['pass'] == "oursecret") {
	$id = $_GET['id'];

	// 2020: needed slight refactor
	// $result = mysql_query("SELECT name, email FROM users WHERE id = '$id'");
	// $row = mysql_fetch_assoc($result);

	$query = "SELECT name, email FROM users WHERE id = " . $db->quote($id);
	$result = $db->query($query);
	$row = $result->fetch(PDO::FETCH_ASSOC);

	$name = $row['name'];
	$email = $row['email'];
	if ($action == "approve") {
		$password = $_POST['confirmation'];
		$pass = md5($password);

		// 2020: needed slight refactor
		// mysql_query("UPDATE users SET status = 'APPROVED', password = '$pass'  WHERE id = '$id'");

		$query = "UPDATE users SET status=?, password=? WHERE id=?";
		$stmt = $db->prepare($query);
		$stmt->execute(['APPROVED', $pass, $id]);

		$subject = "PIN Approved";
		$from = "PIN Service Request <lunch@mg.mitchbarry.com>";
		$msg = "Your request for a PIN is approved. Set your pin at http://localhost:8080/setpin.php?id=" . $id . "&confirmation=" . $password;
		
		// 2020: needed slight refactor
		// mail($email, $subject, $msg, $from);

		$content = "text/html; charset=utf-8";
		$mime = "1.0";
		$headers = array(
			'From' => $from,
			'To' => $email,
			'Subject' => $subject,
			'MIME-Version' => $mime,
			'Content-type' => $content
		);
		$mail = $smtp->send($email, $headers, $msg);
		if (PEAR::isError($mail)) {
			echo ("<p>" . $mail->getMessage() . "</p>");
		} else {
			header("Location: approve.php?action=approved");
		}
	} else if ($action == "deny") {
		// 2020: needed slight refactor
		// mysql_query("DELETE FROM users WHERE id = '$id'");

		$query = "DELETE FROM users WHERE id=?";
		$stmt = $db->prepare($query);
		$stmt->execute([$id]);

		$subject = "PIN Denied";
		$from = "PIN Service Request <lunch@mg.mitchbarry.com>";
		$msg = "Your request for a PIN has been denied. Abuse of the system is not tolerated. If you feel this is a mistake, ";
		$msg .= "please contact Mitch and Darin.";

		// 2020: needed slight refactor
		// mail($email, $subject, $msg, $from);

		$content = "text/html; charset=utf-8";
		$mime = "1.0";
		$headers = array(
			'From' => $from,
			'To' => $email,
			'Subject' => $subject,
			'MIME-Version' => $mime,
			'Content-type' => $content
		);
		$mail = $smtp->send($email, $headers, $msg);
		if (PEAR::isError($mail)) {
			echo ("<p>" . $mail->getMessage() . "</p>");
		} else {
			header("Location: approve.php?action=denied");
		}
	}
} else if ($action != "approved" && $action != "denied")
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
		if (empty($action)) {
			echo "<form action=\"approve.php?action=approve&pass=oursecret&id=" . $id . "\" method=\"post\">";
			echo "<tr><td align=\"right\">Name:</td><td>" . $name . "</td></tr>";
			echo "<tr><td align=\"right\">Email:</td><td>" . $email . "</td></tr>";
			echo "<tr><td align=\"right\">Confirmation:</td><td><input name=\"confirmation\" type=\"text\"/></td></tr>";
			echo "<tr><td></td><td><input type=\"submit\" value=\"Confirm\"/></td></tr>";
			echo "</form>";
			echo "<form action=\"approve.php?action=deny&pass=oursecret&id=" . $id . "\" method=\"post\">";
			echo "<tr><td></td><td><input type=\"submit\" value=\"Deny\"/></td></tr>";
			echo "</form>";
		} else if ($action == "approved") {
			echo "<tr><td>User Approved</td></tr>";
		} else if ($action == "denied") {
			echo "<tr><td>User PIN Request Denied</td></tr>";
		}
		?>
	</table>
</body>

</html>