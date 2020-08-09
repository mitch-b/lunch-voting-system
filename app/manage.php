<?php
    session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="./assets/mitchbarry.css" />
<title>Lunch Voting System Administration | powered by mitchbarry.com</title>
</head>
<body>
<div id="container">
	<?php include("./left_column.php"); ?>
    <div id='vote'>
    	<?php
	    $auth = 0;
	    if(isset($_SESSION['user_id'])){
			$user_id = $_SESSION['user_id'];
			// connect to database
			require_once('mysql.php');
			$sql = "SELECT * FROM groups WHERE user_id='$user_id' AND group_name='lvs_admin'";
			$result = mysql_query($sql);
			$data = mysql_fetch_assoc($result);
			if(mysql_num_rows($result)==1)
			{
				$auth = 1;
			}
	    }
	?>
	<?php if($auth) { ?>
	<p>Welcome, <?php echo $_SESSION['username']; ?></p>
	<?php
	require_once('mysql.php');
        $sql2 = "SELECT DISTINCT name FROM restaurant";
        $result2 = mysql_query($sql2);
	$results = "";
	$i = 0;
	$arr = array(0 => array("name" => "", "num" => 0),
		 1 => array("name" => "", "num" => 0), 
		2 => array("name" => "", "num" => 0));
        while($row = mysql_fetch_assoc($result2))
        {
                $sql3 = "SELECT * FROM restaurant WHERE name='" . 
		mysql_real_escape_string($row['name']) . "'";
                $result3 = mysql_query($sql3);
                $num = mysql_num_rows($result3);
		$arr[$i]["name"] = $row['name'];
		$arr[$i]["num"] = $num;
                $results .= $row['name'] . " : " . $num . "\n";
		$i++;
        }
	$max = 0;
	for($i = 0; $i < 3; $i++)
	{
		if($arr[$i]["num"] > $max && $arr[$i]["name"] != "")
		{
			$max = $arr[$i]["num"];
			$winner = $arr[$i]["name"];
		}
	}
	$days = 7;
	$thismonth = date("M", time());
        $nextmonth = date("M", time()+($days*24*60*60));
	$type = "Weekly";
	if ($thismonth != $nextmonth)
	{
	    $type = "Monthly";
	}
	echo "This week's lunch type is : $type<br /><br />";
	echo "So far, the current winner is : $winner<br /><hr />";
	echo "$results";
	?>







	<?php } else { ?>
	<p>Sorry, you must log in to the mitchbarry.com domain and have <em>lvs_admin</em> access attached to your account.  
	<?php
	if(isset($_SESSION[username])){
	echo "<br /><br />Your current access list is : ";
	$access = "SELECT * FROM groups WHERE user_id='$user_id'";
	$acc_result = mysql_query($access);
	while($acc_data = mysql_fetch_assoc($acc_result))
	{
	    echo "<br /><em>" . $acc_data['group_name'] . "</em>";
	}}
	?>
        </p>
	<?php } ?>
    </div>
</div>
</body>
</html>
