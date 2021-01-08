<?php
global $context; 

//get data from settings table
$opt = array(
    'tableName' => 'settings',
    'cond' => 'ORDER BY opt');

$resS = dbSelectQuery($opt);

while($s = $resS->fetch_array()) {
    $s['setting'] = stripslashes($s['setting']);
    $val[$s['opt']] = $s['setting'];     
}


//get all links from db
$opt = array(
    'tableName' => 'links',
    'cond' => 'ORDER BY name');

$resL = dbSelectQuery($opt);

while($l = $resL->fetch_array()) {
	$l['url'] = stripslashes($l['url']);
	$links[$l['name']] = $l['url'];
}


$context = array( //global variables 
    'links' => $links,
    'conn' => $conn,
    'newslConn' => $newslConn,
    'dir' => $dir, 
    'links' => $links,
    'websiteURL' => $val['websiteURL'], 
    'adminEmail' => $val['adminEmail'],
    'supportEmail' => $val['fromEmail'],
    'ipnURL' => $ipnURL,
    'val' => $val 
); 

//admin email address 
$adminEmail = $val['adminEmail'];

//paypal account to receive payments 
$paypalEmail = $val['paypalEmail'];

//customer support email 
$supportEmail = $val['fromEmail'];

//the main URL of this domain 
$websiteURL = $val['websiteURL'];

$businessName = $val['businessName']; 

$ipnURL = $val['ipnURL'];

//members area
$affLogin = $websiteURL.'/members/';

//is paypal enabled? If not show backup payment option
///////////////////
$paypalOrderLink = $val['paypalOrderLink'];
$usePaypalOrderLink = $val['usePaypalOrderLink'];
/////////////////// 


//delete error logs
if(file_exists('error_log')) {   
    unlink('error_log');
}
?>