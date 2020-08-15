<?php

require_once('Mail.php');
require_once('env.php');

$params = array(
    'host' => $mailhost,
    'port' => $mailport,
    'auth' => true,
    'socket_options' => array('ssl' => array('verify_peer_name' => false, 'allow_self_signed' => true)),
    'username' => $mailuser,
    'password' => $mailpass
);

$smtp = Mail::factory('smtp', $params);

?>