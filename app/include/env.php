<?php

#
# simple include to pull environment variables from docker container
#

$mailhost = getenv('MAIL_HOST');
$mailuser = getenv('MAIL_USER');
$mailpass = getenv('MAIL_PASS');
$mailport = getenv('MAIL_PORT');
$mailfrom = getenv('MAIL_FROM');

$hostname = getenv('HOSTNAME');
$adminemail = getenv('ADMIN_EMAIL');

?>