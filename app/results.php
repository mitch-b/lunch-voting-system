<?php
        // connect to the database
        include('mysql.php');
        $sql = "SELECT DISTINCT name FROM restaurant";
        $result = mysql_query($sql);
	$results = "";
	$i = 0;
	$arr = array(0 => array("name" => "", "num" => 0),
		 1 => array("name" => "", "num" => 0), 
		2 => array("name" => "", "num" => 0));
        while($row = mysql_fetch_assoc($result))
        {
                $sql2 = "SELECT * FROM restaurant WHERE name='" . 
		mysql_real_escape_string($row['name']) . "'";
                $result2 = mysql_query($sql2);
                $num = mysql_num_rows($result2);
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
			print nl2br("Winner is currently : $winner\n");
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
	$mesg = "
<html>
    <body style=\"font-family:Corbel,Tahoma,Arial;\">
    <div style=\"padding:15px;\">
        <center><strong>$type Lunch Results</strong></center>
        <p>We are going to lunch today at: <strong>$winner</strong>.</p><p>Poll Results</p><hr /><p>" . nl2br($results) . "</p>
    </div>
    </body>
</html>";
	$headers ="From:$type Lunch Notifier <lunch@mitchbarry.com>" . "\r\n";
	$headers .= "Content-type: text/html\r\n";
	$headers .= 'Cc: ';
    if ( $thismonth == $nextmonth )
	{
		$sql = "SELECT email, frequency FROM users WHERE frequency='W'";
		$headers .= get_emails($sql);
	}
    else
	{
		$sql = "SELECT email, frequency FROM users WHERE frequency='W' OR frequency='M'";
		$headers .= get_emails($sql);
	}
	$subject = "Lunch this week: $winner";
    mail("lunch@mitchbarry.com", $subject, $mesg, $headers);
	echo nl2br($mesg);

	function get_emails($sql)
	{
		$result = mysql_query($sql) or die(mysql_error());
		while($data = mysql_fetch_assoc($result))
		{
			if($emls != ''){
				$emls .= ", ";
			}
			$emls .= $data['email'];
		}
		echo "<br />sent to: $emls<br />";
		$emls .= "\r\n";
		return $emls;
	}
?>
