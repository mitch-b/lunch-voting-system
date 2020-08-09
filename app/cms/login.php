<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="../assets/mitchbarry.css" />
	<title>mitchbarry.com | Administrator Login</title>
</head>

<body>
	<div id="container"><?php include('../include/left_column.php'); ?>
		<div id='vote'>

			<?php include('forms/login_form.php'); ?>
			<script language="javascript" type="text/javascript">
				function set_focus() {
					login.username.focus();
				}
				set_focus();
			</script>
		</div>
	</div>
</body>

</html>