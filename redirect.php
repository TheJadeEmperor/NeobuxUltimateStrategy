<?php

switch($_GET['url']) {
	case 'clixsense':
		$url = 'http://www.clixsense.com/?3373459';
		break;
	case 'nus':
		$url = 'http://neobuxultimatestrategy.com/';
		break;
	case 'basics':
	default:
		$url = 'http://neobuxultimatestrategy.com/basics';
		break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="5;url=<?=$url?>">
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

<center>
<table width="450px" cellpadding="10" class="table">
    <tr valign="middle">
        <td align="center">
			<p>Thank you for subscribing to our newsletters</p>
			<p>Remember to check your inbox for a confirmation email</p>
			<p><b>** Now Redirecting You to "<?=$url?>" **</b></p>
			
			<p>Please wait...</p>
	
			<img src="images/waiting.gif" alt="Waiting">
        </td>
    </tr>
</table>


<p>&nbsp;</p>

<p>Only 1 more step left - check your inbox and confirm</p>

<p><img src="images/splash/confirm.jpg" alt="Confirm subscription" border="1"/></p>

</center>
</body>
</html>