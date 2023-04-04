<?php
$dir = '../';
include($dir.'include/functions.php');
include($dir.'include/config.php');
include($dir.'include/spmSettings.php'); 
include($dir.'include/api_sendgrid.php'); 

$urlRedirect = $_GET['url']; //url nickname in parameter  

if(empty($urlRedirect)) { //default url
	$urlRedirect = $websiteURL.'basics';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="5;url=<?=$urlRedirect?>">
<style>
body {
    font-family: verdana;
    font-size: 12px; 
}

.table {
	border: 1px solid black; font-size: 12px;
}
</style>
</head>
<body>

<p>&nbsp;</p><p>&nbsp;</p>
<center>
<table width="450px" cellpadding="10" class="table">
    <tr valign="middle">
        <td align="center">
			<p>Thank you for subscribing to our newsletters</p>
			<p>Remember to check your inbox for a confirmation email</p>
			<p><b>** Now Redirecting You to "<?=$urlRedirect?>" **</b></p>
			
			<p>Please wait...</p>
	
			<img src="<?=$dir?>images/waiting.gif" alt="Waiting">
        </td>
    </tr>
</table>

<p>&nbsp;</p>

<p>Check your inbox to confirm receipt of our newsletters</p>
</center>
</body>
</html>