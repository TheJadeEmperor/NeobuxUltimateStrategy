<?php
//database info goes here
//////////////////////////////
$dbHost = '74.220.207.187';
$dbUser = 'codegeas_root';
$dbPW = 'KaibaCorp1!';
$dbName = 'codegeas_nus';
/////////////////////////////

$conn = $context[conn] = database($dbHost, $dbUser, $dbPW, $dbName);

$host = "mail.bestpayingsites.com"; // SMTP host
$username = "admin@bestpayingsites.com"; //SMTP username
$password = "KaibaCorp1!"; // SMTP password
$fromName = 'Ultimate Strategy';
$fromEmail = $username;
?>