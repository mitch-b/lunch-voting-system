<?php
include('../../include/security.inc.php');
require_once('../../mysql.php');
$username = stripslashes($_POST['username']);
$password = stripslashes($_POST['password']);
$confirm = stripslashes($_POST['confirm']);
$system = $_POST['system'];
$permission = $_POST['roleMenu'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="../../assets/mitchbarry.css" />
	<title>Lunch Voting System Administration | powered by mitchbarry.com</title>
</head>

<body>
	<div id="container">
		<?php include("../../include/left_column.php"); ?>
		<div id="center_column">
			<?php
			if ($username != "" && $password != "" && $confirm != "" && $password == $confirm) {
				if ($password == $confirm) {
					$password = md5($password);
					$query = "INSERT INTO users (username,password) VALUES (?,?)";
					$stmt = $db->prepare($query);
					try {
						$stmt->execute([$username, $password]);
						echo "User <strong>$username</strong> created successfully.";
					} catch (Exception $e) {
						echo 'Failed to insert user.<br />Query: $sql<br /><br />Exception -> ';
						var_dump($e->getMessage());
					}

					$query = "SELECT user_id FROM users WHERE username=" . $db->quote($username);
					$result = $db->query($query);
					if ($result->rowCount() > 0) {
						$data = $result->fetch(PDO::FETCH_ASSOC);
						$id = $data['user_id'];
						$query = "INSERT INTO groups VALUES (?,?)";
						$stmt = $db->prepare($query);
						$stmt->execute([$id, $username]);
						$stmt->execute([$id, $permission]);

						/* Add user access for systems here */
						if (isset($_POST['system'])) {
							foreach ($system as $sys => $s) {
								echo "<br /><span class='meta_right'>Adding to group: <strong>$s</strong></span>";
								$stmt->execute([$id, $s]);
							}
						}
					} else {
						echo "Failed to pull user_id.";
					}
				} else {
					echo "Error: Passwords do not match.";
				}
			} else {
				echo "Error: Please fill in all required fields and try again.";
			}
			?>
			<p /><a href='javascript:history.back()'>return</a>
		</div>
		<div id="right_column"></div>
	</div>
</body>

</html>