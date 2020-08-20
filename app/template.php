<?php
session_start();
include("mysql.php");
// check if already voted ...
if (isset($_COOKIE['user'])) {
	echo "
		<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
		<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
		<link rel=\"stylesheet\" type=\"text/css\" href=\"./assets/mitchbarry.css\" />
		<title>Lunch Voting System | powered by mitchbarry.com</title>
		</head>
		<body>
		<div id=\"container\">";
	include('./include/left_column.php');
	echo "<div id='vote'><p>You have already voted. Thank you for your participation.</p>";
	echo "Current results: <hr />";
	// connect to database

	// 2020: needed slight refactor
	// $sql2 = "SELECT DISTINCT name FROM restaurant";
	// $result2 = mysql_query($sql2);
	// while($row = mysql_fetch_assoc($result2))
	$sql2 = "SELECT DISTINCT name FROM restaurant";
	$result2 = $db->query($sql2);
	while ($result2 && $row = $result2->fetch(PDO::FETCH_ASSOC)) {
		// 2020: needed slight refactor
		// $sql3 = "SELECT * FROM restaurant WHERE name='" . mysql_real_escape_string($row['name']) . "'";
		// $result3 = mysql_query($sql3);
		// $num = mysql_num_rows($result3);

		$sql3 = "SELECT * FROM restaurant WHERE name = " . $db->quote($row['name']);
		$result3 = $db->query($sql3);
		$num = $result3->rowCount();
		echo $row['name'] . " : " . $num . "<br />";
	}
	echo "<p /></div></body></html>";
} else // the user has not voted this week
{
	if (isset($_POST['choice'])) {
		// 2020: needed slight refactor
		//expire in 5 days
		// $expire = time()+432000;
		// setcookie("user", "voted", $expire);

		// connect to database
		$pass = md5("oursecret");

		// 2020: needed slight refactor
		// $result = mysql_query("SELECT id FROM restaurant WHERE pin = '$pass'");
		// if(mysql_num_rows($result)>0)

		$query = "SELECT `name` FROM restaurant WHERE pin = " . $db->quote($pass);
		$result = $db->query($query);
		if ($result && $result->rowCount() > 0) {
			echo "
				<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
				<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
				<head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
				<link rel=\"stylesheet\" type=\"text/css\" href=\"./assets/mitchbarry.css\" />
				<title>mitchbarry.com | Lunch Voting System</title>
				</head>
				<body>
				<div id=\"container\">";
			include('./include/left_column.php');
			echo "<div id='vote'><p>This weeks results have been overriden due to special circumstances. Your vote will not count.</p><p /><a href='manage.php' class='meta_right'>manage lunch system</a>
</div></body></html>";
		} else {
			$pin = md5($_POST['pin']);

			// 2020: needed slight refactor
			// $choice = mysql_real_escape_string($_POST['choice']);
			// $sql = "INSERT INTO restaurant (name,pin) VALUES ('$choice','$pin')";
			// $result = mysql_query($sql) or die("<p><em>Failed to place your vote.</em></p><p>Either you have an invalid PIN or you have already voted.</p>");

			$query = "INSERT INTO restaurant (name,pin) VALUES (?,?)";
			$stmt = $db->prepare($query);
			if ($stmt->execute([$_POST['choice'], $pin])) {
				//expire in 5 days
				$expire = time() + 432000;
				setcookie("user", "voted", $expire);
			} else {
				echo "<p><em>Failed to place your vote.</em></p><p>Either you have an invalid PIN or you have already voted.</p>";
			}
		}
		// select count of restaurants
		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
				<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
				<head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
				<link rel=\"stylesheet\" type=\"text/css\" href=\"./assets/mitchbarry.css\" />
				<title>mitchbarry.com | Lunch Voting System Results</title>
				</head>
				<body>
				<div id=\"container\">";
		include('./include/left_column.php');
		echo "<div id='vote'><h3>View Results</h3>";

		// 2020: needed slight refactor
		// $sql2 = "SELECT DISTINCT name FROM restaurant";
		// $result2 = mysql_query($sql2);
		// while($row = mysql_fetch_assoc($result2))

		$sql2 = "SELECT DISTINCT name FROM restaurant";
		$result2 = $db->query($sql2);
		while ($result2 && $row = $result2->fetch(PDO::FETCH_ASSOC)) {
			// 2020: needed slight refactor
			// $sql3 = "SELECT * FROM restaurant WHERE name='" . mysql_real_escape_string($row['name']) . "'";
			// $result3 = mysql_query($sql3);
			// $num = mysql_num_rows($result3);

			$sql3 = "SELECT * FROM restaurant WHERE name = " . $db->quote($row['name']);
			$result3 = $db->query($sql3);
			$num = $result3->rowCount();
			echo $row['name'] . " : " . $num . "<br />";
		}
		echo "<p /><a href='manage.php' class='meta_right'>manage lunch system</a></div></body></html>";
	} else {
?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<link rel="stylesheet" type="text/css" href="./assets/mitchbarry.css" />
			<title>mitchbarry.com | Lunch Voting System</title>
		</head>

		<body>
			<div id="container">
				<?php include('./include/left_column.php'); ?>
				<div id="vote">
					<h3>Place vote for lunch location:</h3>
					<div class="meta">Locations have been generated randomly for an exciting lunch every time!</div><br />
					<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
						<table class="lunchtable">
							<tr>
								<td rowspan="2">
									<input type="radio" name="choice" value="var1" />var1
									<br /><input type="radio" name="choice" value="var2" />var2
									<br /><input type="radio" name="choice" value="var3" />var3
								</td>
								<td align="right">&nbsp;&nbsp;&nbsp;&nbsp;Pin: <input name="pin" type="password" maxlength="32" />
								</td>
							</tr>
							<tr>
								<td align="right">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="Submit Lunch Vote" />
								</td>
							</tr>
						</table>
					</form>
					<a href="register.php">Register for a PIN</a>
					<?php
					$pass = md5("oursecret");

					// 2020: needed slight refactor
					// $result = mysql_query("SELECT name FROM restaurant WHERE pin = '$pass'");
					// if(mysql_num_rows($result)>0)

					$query = "SELECT `name` FROM restaurant WHERE pin = " . $db->quote($pass);
					$result = $db->query($query);
					if ($result && $result->rowCount() > 0) {
						// 2020: needed slight refactor
						// $row = mysql_fetch_assoc($result);
						$row = $result->fetch(PDO::FETCH_ASSOC);
						$restaurant = $row['name'];
						echo "<p><strong>Attention:</strong> We are overriding the system today in favor of: <i>" . $restaurant . "</i></p>";
					}
					?>
					<p>
						<a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml10-blue" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
					</p>
					<div id="votefooter">lunch system brought to you by Mitchell Barry, Darin Kleb &copy; 2010</div>
				</div><a href='manage.php' class='meta_right'>manage lunch system</a>
			</div>
		</body>

		</html>
<?php }
} ?>