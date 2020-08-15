<?php
	session_start();
  session_destroy();
  require_once '../include/env.php';
	header("Location: $hostname");
?>