<?php
session_start();
require_once('../../mysql.php');
require_once('../../include/env.php');

$tbl_name = "account";
// username and password sent from form 
$username = $_POST['username'];
$password = $_POST['password'];
// To protect MySQL injection (more detail about MySQL injection)
$username = stripslashes($username);
$password = stripslashes($password);

$md5password = md5($password);

$query = "SELECT * FROM $tbl_name WHERE username=? and password=?";
$stmt = $db->prepare($query);
$stmt->execute([$username, $md5password]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($stmt->rowCount() == 1) {
	// Register $username, $password and redirect to file "index.php"
	$user_id = $data['user_id'];

	$access_sql = "SELECT * FROM groups WHERE user_id=" . $db->quote($user_id);
	$access_result = $db->query($access_sql);

	$access = "standard";
	while ($access_data = $access_result->fetch(PDO::FETCH_ASSOC)) {
		if ($access_data['group_name'] == "administrator")
			$access = "administrator";
	}
	$_SESSION['username'] = $username;
	$_SESSION['access'] = $access;
	$_SESSION['user_id'] = $user_id;

	// update time logged in to database
	$query = "UPDATE $tbl_name SET date=now(),ip=? WHERE username=?";
	$stmt = $db->prepare($query);
	$stmt->execute([$_SERVER['REMOTE_ADDR'], $username]);

	header("location: $hostname");
} else {
	echo "wrong username/password";
}
