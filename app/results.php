<?php
// connect to the database
include('mysql.php');
// pull $smtp and mail config
require_once("include/smtp.settings.php");

// 2020: needed slight refactor
// $sql = "SELECT DISTINCT name FROM restaurant";
// $result = mysql_query($sql);

$sql = "SELECT DISTINCT name FROM restaurant";
$result = $db->query($sql);

$results = "";
$i = 0;
$arr = array(
	0 => array("name" => "", "num" => 0),
	1 => array("name" => "", "num" => 0),
	2 => array("name" => "", "num" => 0)
);
// 2020: needed slight refactor
// while ($row = mysql_fetch_assoc($result)) {
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	// 2020: needed slight refactor
	// $sql2 = "SELECT * FROM restaurant WHERE name='" .
	// 	  mysql_real_escape_string($row['name']) . "'";
	// $result2 = mysql_query($sql2);
	// $num = mysql_num_rows($result2);

	$sql2 = "SELECT * FROM restaurant WHERE name=" . $db->quote($row['name']);
	$result3 = $db->query($sql2);
	$num = $result2->rowCount();

	$arr[$i]["name"] = $row['name'];
	$arr[$i]["num"] = $num;
	$results .= $row['name'] . " : " . $num . "\n";
	$i++;
}
$max = 0;
for ($i = 0; $i < 3; $i++) {
	if ($arr[$i]["num"] > $max && $arr[$i]["name"] != "") {
		$max = $arr[$i]["num"];
		$winner = $arr[$i]["name"];
		print nl2br("Winner is currently : $winner\n");
	}
}
$days = 7;
$thismonth = date("M", time());
$nextmonth = date("M", time() + ($days * 24 * 60 * 60));
$type = "Weekly";
if ($thismonth != $nextmonth) {
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
// 2020: needed slight refactor
// $headers = "From:$type Lunch Notifier <lunch@mg.mitchbarry.com>" . "\r\n";
// $headers .= "Content-type: text/html\r\n";
// $headers .= 'Cc: ';
$bcc_recipients = '';
if ($thismonth == $nextmonth) {
	$sql = "SELECT email, frequency FROM users WHERE frequency='W'";
	// $headers .= get_emails($sql);
	$bcc_recipients = get_emails($sql);
} else {
	$sql = "SELECT email, frequency FROM users WHERE frequency='W' OR frequency='M'";
	// $headers .= get_emails($sql);
	$bcc_recipients = get_emails($sql);
}
$subject = "Lunch this week: $winner";

// 2020: needed slight refactor
// mail("lunch@mg.mitchbarry.com", $subject, $mesg, $headers);

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
$mail = $smtp->send($to . "," . $bcc_recipients, $headers, $mesg);
if (PEAR::isError($mail)) {
	echo ("<p>" . $mail->getMessage() . "</p>");
}

echo nl2br($mesg);

function get_emails($sql)
{
	// 2020: needed slight refactor
	// $result = mysql_query($sql) or die(mysql_error());
	// while ($data = mysql_fetch_assoc($result)) {

	global $db;
	$emls = '';

	$result = $db->query($sql);
	while ($data = $result->fetch(PDO::FETCH_ASSOC)) {
		if ($emls != '') {
			$emls .= ", ";
		}
		$emls .= $data['email'];
	}
	echo "<br />sent to: $emls<br />";
	$emls .= "\r\n";
	return $emls;
}
