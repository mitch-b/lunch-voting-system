<?php
	echo "wiping 'index.php'..........";
	
	$new = '<?php session_start(); ?>' . "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"./assets/mitchbarry.css\" />
<title>Lunch Voting System | powered by mitchbarry.com</title>
</head>
<body>
<div id=\"container\">" . '<?php include("./left_column.php"); ?>' . "<div id='vote'><p>Polling period has expired. Wait until 7AM CST Friday.</p></div><a href='manage.php' class='meta_right'>manage lunch system</a></div></body></html>";
	exec("cp index.php lastweek.php");
	$index = "index.php";
	$filehandler = fopen($index,'w');
	fwrite($filehandler,$new);
	fclose($filehandler);
	echo nl2br("done\n");
?>
