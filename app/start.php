<?php
	// connect to database
	require_once 'mysql.php';
	echo "truncating table..........";
	$sql = "TRUNCATE TABLE restaurant";

	// 2020: needed slight refactor
	// $result = mysql_query($sql) or die("failed<br /><br />" . mysql_error());
	
	$stmt = $db->prepare($sql);
	try {
		$stmt->execute();
	} catch (Exception $e) {
		echo 'Exception -> ';
		var_dump($e->getMessage());
	}
	
	echo nl2br("done\n");
	echo "updating list.............";
    $run = "./restaurant.pl";
	exec($run);
	echo nl2br("done\n\n");
	echo "<a href='https://lvs.mitchbarry.com/'>vote for lunch</a>";
?>
