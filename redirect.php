<?php
include($dir.'include/functions.php');
include($dir.'include/config.php');
include($dir.'include/spmSettings.php'); 
include($dir.'include/api_sendgrid.php'); 

$url = $_GET['url'];
$urlRedirect = $context['links'][$url];

if(empty($urlRedirect)) {
	$urlRedirect = 'http://neobuxultimatestrategy.com/basics';
}


echo $_POST['email']; 

if($_POST['email']) {
	//add email to sendgrid 
	$subscriberEmail = $_POST['email'];

	$sendgridMail = new \SendGrid\Mail\Mail(); 
	$sendgridClass = new \SendGrid(SENDGRID_API_KEY);
	$sendGridAPI = new sendGridAPI(SENDGRID_API_KEY);
	
	//add contact to list
	$info = array(
		'list_id' => $list_id,
		'contact' => array(
			'email' => $subscriberEmail, //contact's main email
			'join_date' => date('Y-m-d'), //today's date
			'origin' => $_POST['origin'] //page tracking 
			)
	);
	echo $subscriberEmail. ' '; 

	$sendGridAPI->contact_add($info);
}
else {
	echo "You don't belong here"; exit; 
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<meta http-equiv="refresh" content="5;url=<?=$urlRedirect?>">-->
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
			<p><b>** Now Redirecting You to "<?=$urlRedirect?>" **</b></p>
			
			<p>Please wait...</p>
	
			<img src="images/waiting.gif" alt="Waiting">
        </td>
    </tr>
</table>


<p>&nbsp;</p>

<p>Check your inbox to confirm receipt of our newsletters</p>
<!--
<p><img src="images/splash/confirm.jpg" alt="Confirm subscription" border="1"/></p>
-->
</center>
</body>
</html>