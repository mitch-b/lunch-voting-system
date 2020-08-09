<?php
	$mesg = "
<html>
    <body style=\"font-family:Corbel,Tahoma,Arial;\">
    <div style=\"padding:15px;\">
        <center><b>Lunch Reminder</b></center>
        <p>Please head to <a href='http://lvs.mitchbarry.com/lunch'>the lunch page</a> to vote for lunch.</p>
	<p>You have until 12:00PM Central to complete this action.</p>
	<p><em><strong>Reminder:</strong></em> Don't forget to complete your CATS for the week!</p>
    </div>
    </body>
</html>
";
	require_once('mysql.php');
	$days = 7;
	$thismonth = date("M", time());
    $nextmonth = date("M", time()+($days*24*60*60));
	$type = "Weekly";
	if ($thismonth != $nextmonth)
	{
	    $type = "Monthly";
	}
	$headers = "From:$type Lunch <lunch@mg.mitchbarry.com>" . "\r\n";
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
	$subject = "$type Lunch Reminder";
    mail("lunch@mg.mitchbarry.com", $subject, $mesg, $headers);
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
		$emls .= "\r\n";
		return $emls;
	}

?>
