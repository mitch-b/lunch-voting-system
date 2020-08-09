<?php

// define (HOSTNAME, 'localhost');
// define (USERNAME, 'lvs');
// define (PASSWORD, 'lvs');
// define (DATABASE_NAME, 'lunch_voting_system');

// $dbase = mysql_connect(HOSTNAME, USERNAME, PASSWORD) or die ('Unable to connect to MySQL.');

// mysql_select_db(DATABASE_NAME);

// updated to PDO... stupid.

$dbhost = 'lvs-data';
$dbname = 'lunch_voting_system';
$username = 'root';
$password = 'root';

$db = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $username, $password);

?>
