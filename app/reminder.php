<?php
	$mesg = "
<html>
    <body style=\"font-family:Corbel,Tahoma,Arial;\">
    <div style=\"padding:15px;\">
        <center><b>Lunch Reminder</b></center>
        <p>Please head to <a href='http://localhost:8080'>the lunch page</a> to vote for lunch.</p>
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
	// 2020: needed slight refactor
	// $headers = "From:$type Lunch <lunch@mg.mitchbarry.com>" . "\r\n";
	// $headers .= 'Cc: ';

	$cc_recipients = '';
    if ( $thismonth == $nextmonth )
	{		
		$sql = "SELECT email, frequency FROM users WHERE frequency='W'";
		// $headers .= get_emails($sql);
		$bcc_recipients = get_emails($sql);
	}
    else
	{
		$sql = "SELECT email, frequency FROM users WHERE frequency='W' OR frequency='M'";
		// $headers .= get_emails($sql);
		$bcc_recipients = get_emails($sql);
	}
	$subject = "$type Lunch Reminder";

	// 2020: needed slight refactor
	// mail("lunch@mg.mitchbarry.com", $subject, $mesg, $headers);

	require_once("include/smtp.settings.php");
	$content = "text/html; charset=utf-8";
	$mime = "1.0";
	$to = "lunch@mg.mitchbarry.com";
	$from = "$type Lunch <lunch@mg.mitchbarry.com>";
	$headers = array(
		'From' => $from,
		'To' => $to,
		'Subject' => $subject,
		'MIME-Version' => $mime,
		'Content-type' => $content
	);
	$mail = $smtp->send($to.",".$bcc_recipients, $headers, $mesg);
	if (PEAR::isError($mail)) {
		echo ("<p>" . $mail->getMessage() . "</p>");
	} else {
		echo ("<p>Reminder email sent!</p>");
	}

	echo nl2br($mesg);
	
	function get_emails($sql)
	{
		// 2020: needed slight refactor
		// $result = mysql_query($sql) or die(mysql_error());
		// while($data = mysql_fetch_assoc($result))
		
		global $db;
		$emls = '';

		$result = $db->query($sql);
		while($data = $result->fetch(PDO::FETCH_ASSOC))
		{
			if($emls != ''){
				$emls .= ", ";
			}
			$emls .= $data['email'];
		}
		// 2020: needed slight refactor
		// $emls .= "\r\n";
		return $emls;
	}
