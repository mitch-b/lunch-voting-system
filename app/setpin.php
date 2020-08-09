<?php
// this page allows the user to set their own PIN for the lunch voting system
// needs to $_GET user's 'id' and the 'confirmation' code that was sent by administrators
require_once("mysql.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Set PIN</title>
</head>

<body>
	<table align="center" width="400px">
		<?php
		if (empty($_POST['action'])) {
			$id = stripslashes($_GET['id']);
			$code = md5($_GET['confirmation']);

			// 2020: needed slight refactor
			// $sql = "SELECT * FROM users WHERE password = '" . $code . "'";
			// $result = mysql_query($sql);
			// if (mysql_num_rows($result) > 0) {
			// 	  $row = mysql_fetch_assoc($result);

			$query = "SELECT * FROM users WHERE password = " . $db->quote($code);
			$result = $db->query($query);
			if ($result->rowCount() > 0) {
				$row = $result->fetch(PDO::FETCH_ASSOC);
				$name = $row['name'];
				$email = $row['email'];
				echo "<form action=\"setpin.php\" method=\"post\">";
				echo "<tr><td align=\"right\">Name:</td><td>" . $name . "</td></tr>";
				echo "<tr><td align=\"right\">Email:</td><td>" . $email . "</td></tr>";
				echo "<tr><td align=\"right\">Enter desired PIN:</td><td><input name=\"pin\" type=\"password\"/></td></tr>";
				echo "<tr><td align=\"right\">Repeat desired PIN:</td><td><input name=\"repeatpin\" type=\"password\"/></td></tr>";
				echo "<tr><td></td><td><input type=\"submit\" value=\"Confirm\"/></td></tr>";
				echo "<input type=\"hidden\" name=\"id\" value=\"$id\" />";
				echo "<input type=\"hidden\" name=\"action\" value=\"set\" />";
				echo "</form>";
				// 2020: needed slight refactor
				// } else if (mysql_num_rows($result) <= 0) {
			} else {
				echo "<p>Woah, woah, woah, this account definitlely does not exist in the database. Quit playing around!</p>";
			}
		}
		if ($_POST['action'] == "set") {
			if ($_POST['pin'] == $_POST['repeatpin']) {
				$pin = md5($_POST['pin']);
				$id = $_POST['id'];

				// 2020: needed slight refactor
				// $sql = "SELECT * FROM users WHERE id='$id' AND status='PIN_SET'";
				// $result = mysql_query($sql);
				// if (mysql_num_rows($result) > 0) {

				$query = "SELECT * FROM users WHERE id=" . $db->quote($id) . " AND status='PIN_SET'";
				$result = $db->query($query);
				if ($result->rowCount() > 0) {
					echo "Your PIN has already been set.";
				} else {

					// 2020: needed slight refactor
					// $result2 = mysql_query("INSERT INTO pins VALUES ('$pin')") or die("Failed to insert a unique PIN. Please try again.");
					// mysql_query("UPDATE users SET status = 'PIN_SET' WHERE id = '$id'");

					$query = "INSERT INTO pins VALUES (?)";
					$stmt = $db->prepare($query);
					if (!$stmt->execute([$pin])) {
						echo "Failed to insert a unique PIN. Please try again.";
					}
					$query = "UPDATE users SET status = ? WHERE id = ?";
					$stmt = $db->prepare($query);
					$stmt->execute(['PIN_SET', $id]);
					echo "Thank you for registering your PIN. Do not forget it, as it is not retrievable.";
				}
			} else {
				echo "PIN fields need to be equal.";
			}
		} ?>
	</table>
</body>

</html>