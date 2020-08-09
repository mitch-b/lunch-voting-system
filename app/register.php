<?php
require_once("mysql.php");

$action = $_GET['action'];

if ($action == "add") {
	// 2020: needed slight refactor
	// $name = mysql_real_escape_string($_POST['name']);
	// $email = mysql_real_escape_string($_POST['email']);
	// $freq = mysql_real_escape_string($_POST['frequency']);
	// $result = mysql_query("SELECT name FROM users WHERE name = '$name'");
	// if (mysql_num_rows($result) > 0)

	$name = $_POST['name'];
	$email = $_POST['email'];
	$freq = $_POST['frequency'];

	$query = "SELECT name FROM users WHERE name = " . $db->quote($name);
	$result = $db->query($query);
	if ($result->rowCount() > 0)
		header("Location: register.php?action=error&reason=exists");
	else {

		// 2020: needed slight refactor
		// mysql_query("INSERT INTO users (name,email,frequency,status) VALUES ('$name','$email','$freq','PEND_APR')") or die(mysql_error());

		$query = "INSERT INTO users (name,email,frequency,status) VALUES (?, ?, ?, ?)";
		$stmt = $db->prepare($query);
		try {
			$stmt->execute([$name, $email, $freq, 'PEND_APR']);
		} catch (Exception $e) {
			echo 'Exception -> ';
			var_dump($e->getMessage());
		}

		// 2020: needed slight refactor
		// $result = mysql_query("SELECT id FROM users WHERE name = '$name'");
		// $row = mysql_fetch_assoc($result);

		$query = "SELECT id FROM users WHERE name = " . $db->quote($name);
		$result = $db->query($query);
		$row = $result->fetch(PDO::FETCH_ASSOC);

		$to = "mitch.barry+lvs@gmail.com";
		$from = "from: Pin Verification Service <lunch@mg.mitchbarry.com>";
		$subject = "PIN Registration Approval Needed for " . $name;
		$msg = "A PIN request has been placed by " . $name . ".\n\nPlease go to http://localhost:8080/approve.php?id=" . $row['id'] . "&pass=oursecret to approve/deny request.";
		mail($to, $subject, $msg, $from);
		header("Location: register.php?action=pending");
	}
} else if ($action == "verify") {
	$pass = md5($_GET['confirmation']);

	// 2020: needed slight refactor
	// $result = mysql_query("SELECT name FROM users WHERE password = '$pass'");
	// if (mysql_num_rows($result) > 0) {
	//     $row = mysql_fetch_assoc($result);

	$query = "SELECT name FROM users WHERE password = " . $db->quote($pass);
	$result = $db->query($query);
	if ($result->rowCount() > 0) {
		$row = $result->fetch(PDO::FETCH_ASSOC);
		$name = $row['name'];

		// 2020: needed slight refactor
		// mysql_query("UPDATE users SET status = 'ACTIVE' WHERE name = '$name'");

		$query = "UPDATE users SET status = ? WHERE name = ?";
		$stmt = $db->prepare($query);
		try {
			$stmt->execute(['ACTIVE', $name]);
			header("Location: register.php?action=active");
		} catch (Exception $e) {
			echo 'Exception -> ';
			var_dump($e->getMessage());
		}
	} else
		header("Location: register.php?action=error&reason=confirmation");
}

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
			echo "<form action=\"register.php?action=add\" method=\"post\">";
			echo "<tr><td></td><td><b>Register a PIN</b></td></tr>";
			echo "<tr><td align=\"right\">Name:</td><td><input name=\"name\" maxlength=\"25\" type=\"text\"/></td></tr>";
			echo "<tr><td align=\"right\">Email:</td><td><input name=\"email\" type=\"text\"/></td></tr>";
			echo "<tr><td align=\"right\">Frequency:</td><td><select name=\"frequency\"><option value=\"W\">Weekly</option><option value=\"M\">Monthly</option></select></td></tr>";
			echo "<tr><td></td><td><input type=\"submit\" value=\"Request PIN\"/></td></tr>";
			echo "</form>";
		} else if ($action == "pending") {
			echo "<tr><td>Your request has been sent to Mitch and Darin for approval.</td></tr>";
		} else if ($action == "error") {
			$reason = $_GET['reason'];
			if ($reason == "exists")
				echo "<tr><td>This name already exists. If you think this is a mistake, please notify Mitch and Darin.</td></tr>";
			else if ($reason == "confirmation")
				echo "<tr><td>Error with confirmation number. Contact Darin or Mitch for assistance.</td></tr>";
		} else if ($action == "active") {
			echo "<tr><td>Your PIN is now active and ready for use in voting.</td></tr>";
		}
		?>
	</table>
</body>

</html>