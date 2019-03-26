<?php
global $context; 

$selS = 'select * from settings order by opt';
$resS = mysql_query($selS, $conn) or die(mysql_error());

while($s = mysql_fetch_assoc($resS)) {
    $s['setting'] = stripslashes($s['setting']);
    $val[$s['opt']] = $s['setting'];     
}

$selL = 'select * from links order by name';
$resL = mysql_query($selL, $conn) or die(mysql_error());

while($l = mysql_fetch_assoc($resL)) {
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

//affiliate registration
$affLink = $websiteURL.'/members/?action=register';

//members area
$affLogin = $websiteURL.'/members/';


//weekly backups
//backup options
$dayOfWeek = '0'; //day of week to backup 
$backupDir = '.backup';
$backupFile = date('Y-m-d', time()).'.sql';

if( date('w', time()) == $dayOfWeek ) {
    $dump = 'mysqldump -u'.$dbUser.' -p'.$dbPW.' '.$dbName.' > ./'.$backupDir.'/'.$backupFile;
    system($dump); 
} 

error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

//delete error logs
if(file_exists('error_log')) {   
    unlink('error_log');
}
?>