<?php

require_once('Mail.php');

$host = getenv('MAIL_HOST');
$username = getenv('MAIL_USER');
$password = getenv('MAIL_PASS');
$port = getenv('MAIL_PORT');

$params = array(
    'host' => $host,
    'port' => $port,
    'auth' => true,
    'socket_options' => array('ssl' => array('verify_peer_name' => false, 'allow_self_signed' => true)),
    'username' => $username,
    'password' => $password
);

$smtp = Mail::factory('smtp', $params);

?>