<?php
  session_start();
  require_once 'env.php';
	
	if(isset($_SESSION['username']))
		$logged_in = true;
	else
	{
		header("location: $hostname/cms/login.php");
	}

?>
