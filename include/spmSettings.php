<?php
global $context; 

$selS = 'SELECT * FROM settings ORDER BY opt';
$resS = $conn->query($selS);

while($s = $resS->fetch_array()) {
    $s['setting'] = stripslashes($s['setting']);
    $val[$s['opt']] = $s['setting'];     
}


$selL = 'SELECT * FROM links ORDER BY name';
$resL = $conn->query($selL);


while($l = $resL->fetch_array()) {
	$l['url'] = stripslashes($l['url']);
	$links[$l['name']] = $l['url'];
}

$context = array(
    'dir' => $dir, 
    'links' => $links,
    'conn' => $conn, 
    'websiteURL' => $val['websiteURL'], 
    'ipnURL' => $ipnURL,
    'adminEmail' => $val['adminEmail'],
    'supportEmail' => $val['fromEmail'],
    'val' => $val ); 

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