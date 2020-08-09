<?php
	// connect to database
	require_once 'mysql.php';
	echo "truncating table..........";
	$sql = "TRUNCATE TABLE restaurant";
	$result = mysql_query($sql) or die("failed<br /><br />" . mysql_error());
	echo nl2br("done\n");
	echo "updating list.............";
    $run = "./restaurant.pl";
	exec($run);
	echo nl2br("done\n\n");
	echo "<a href='https://lvs.mitchbarry.com/'>vote for lunch</a>";
?>
