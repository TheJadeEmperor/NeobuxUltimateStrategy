<?php
include('adminCode.php');

set_time_limit(120);

//get emails from customer search 
$eCount = 1;
if(isset($_SESSION[sendTo]))
{
    $sendToList = $_SESSION[sendTo];
	foreach($_SESSION[sendTo] as $st)
	{
		if($eCount == sizeof($_SESSION[sendTo])) //last email
		{
	    	$allEmails .= $st;	
        }
		else
        {
			$allEmails .= $st.'
'; 
        }
		$eCount ++; 
	}
}
else {
	$allEmails = $_POST[to];
}



if($_POST['sendEmail'] && $_POST['message'] != '')
{
    //format the message properly
    $_POST[message] = stripslashes($_POST[message]);
    $_POST[message] = str_replace("\"", '&quot;', $_POST[message]);
    $_POST[message] = str_replace('\'', '&#39;', $_POST[message]);
    
    echo '<fieldset>'.$_POST[message].'</fieldset> <br />
    <fieldset>';
    
    //handle file attachment
	$key = 0;
	$tmp_name = $_FILES["userfile"]["tmp_name"][$key];
	$name = $_FILES["userfile"]["name"][$key];
	$sendfile = "$name";
	move_uploaded_file($tmp_name, $sendfile);
	
	$to = $_POST['to'];
	$addresses = array(); 
	$addresses = explode("\n", $to); 
    
	
	$emailName = $_POST['who'];
	$emailSubject = stripslashes($_POST['subject']);
	$emailBody = $_POST['message'];
    $emailBody = str_replace("\n", "<br>", $emailBody);
	$EmailAltBody = str_replace("\n", "<br>", $emailBody);
	$emailFrom = $_POST['from'];

	$attachments = array();
	
	foreach ($addresses as $Email_to)
	{
        //add un-subscribe link
        $unsubText = '<p>********************** </p><p>Unsubscribe from further announcements: <br />
        <a href="'.$websiteURL.'/members/optout.php?e='.$Email_to.'" target=_blank>'.$websiteURL.'/members/optout.php?e='.$Email_to.'</a></p>';
    
        $emailBody .= $unsubText;
        $EmailAltBody .= $unsubText;

        //check for optout - customer
        $selO = 'select optout from sales where payerEmail="'.$Email_to.'" and optout="Y"';
        $resO = mysql_query($selO, $conn) or die(mysql_error());
        
        if(mysql_num_rows($resO) == 0)
        {
            //check for optout - user
            $queryO = 'select optout from users where (email="'.$Email_to.'" || paypal="'.$Email_to.'") and
            optout="Y"';
            $resultO = mysql_query($queryO) or die(mysql_error());
            
            if(mysql_num_rows($resultO) == 0)
                $isOptOut = false; 
            else {
                $isOptOut = true; 
            }
        }
        else
            $isOptOut = true;
       

		$mail = new PHPMailer();
	
		$mail->IsSMTP();         // send via SMTP
		$mail->Host     = $host; // SMTP servers
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = $username;  // SMTP username
		$mail->Password = $password; // SMTP password
		
		$mail->From     = $emailFrom;
		$mail->FromName = $emailName;
		$mail->AddAddress($Email_to);  
		
		$mail->AddAttachment($sendfile);
		$mail->WordWrap = 50;                              // set word wrap
		$mail->IsHTML(true);                               // send as HTML
		
		$mail->Subject  =  $emailSubject;
		$mail->Body     =  $emailBody;
		$mail->AltBody  =  $emailAltBody;
		
        if($isOptOut)
        {
            echo 'Message was <b>not</b> sent - user opted out of emails';    
        }
        else {
            if(!$mail->Send())
               echo "Message was <b>not</b> sent - ".$mail->ErrorInfo;
            else
               echo "Message to $Email_to has been sent<br>";
        }
	}
    echo '</fieldset> <p>&nbsp;</p>';
}


$opt = array(
'tableName' => 'newsletter', 
'cond' => ' order by category' );

$allNewsletters = dbSelect($opt); 

foreach($allNewsletters as $n) {
    $pick = ''; 
    if($_POST[newsletter] == $n[category])  //this template
    {   
        $pick = 'selected';
        $news = $n;
    }
    $newsOpt .= '<option value="'.$n[category].'" '.$pick.'>'.$n[category].'</option>';
}

$properties = 'class="activeField"';
?>

<table><tr><td>
<div class="moduleBlue"><h1>Send Mass Mail </h1><div>
<form method=post enctype="multipart/form-data">
<table class="formField">
<tr>
	<td>From Email Address </td>
	<td width="10px">
	    <div title="header=[Website URL] body=[The email address to send from - default is the SMTP email address if you set it] "><img src="<?=$helpImg?>" /></div>
    </td>
    <td><input <?=$properties?> name=fromEmail size=30 maxlength=50 value="<?=$fromEmail?>" /> ex: email@domain.com</td>
</tr>
<tr>
	<td>From Name </td>
	<td>
        <div title="header=[Website URL] body=[Name displayed for From Email Address, optional field] "><img src="<?=$helpImg?>" /></div>
    </td>
	<td><input <?=$properties?> name=who size=30 maxlength=30 value="<?=$fromName?>"> ex: Administrator</td>
</tr>
<tr>
	<td>Email Template</td>
	<td>
        <div title="header=[Email Template] body=[Choose a pre-written email to be sent, will auto-populate subject and message when selected <br />You can add and edit these templates] "><img src="<?=$helpImg?>" /></div>
    </td>
    <td><select <?=$properties?>  name=newsletter onchange="submit();">
        <option></option><?=$newsOpt?></select> <a href="newsletter.php">Edit Templates</a></td>
</tr>
<tr>
	<td>Subject</td>
	<td>
        <div title="header=[Email Subject Line] body=[Subject line of the email, will auto-populate when you select a template] "><img src="<?=$helpImg?>" /></div>
    </td>
    <td><input <?=$properties?> name=subject size=60 maxlength=60 value="<?=$news[subject]?>"></td>
</tr>
<tr valign="top">
	<td>Send To Email(s)</td>
	<td>
        <div title="header=[Recipients Email] body=[List of recipients' emails, separate each one on a new line, do NOT put commas] "><img src="<?=$helpImg?>" /></div>
    </td>
    <td><textarea <?=$properties?> name="to" cols=47 rows=9><?=$allEmails?></textarea></td>
	<td>ex: <br>1@1.com<br>2@2.com<br>3@3.com </td>
</tr>
<tr valign="top">
	<td>Message </td>
	<td>
        <div title="header=[Message Body] body=[The message to be sent, basic HTML is allowed] "><img src="<?=$helpImg?>" /></div>
    </td>
    <td><textarea name="message" cols=70 rows=15><?=$news[message]?></textarea></td>
</tr>
<tr valign="top">
	<td>Attach a file</td>
	<td>
        <div title="header=[File attachment] body=[You can attach a file to this email for the recipient to download, the limit is 4 MB] "><img src="<?=$helpImg?>" /></div>
    </td>
    <td><input type=file name="userfile[]" class="bginput" size="30" /> &nbsp;
	   <br />Max file size: 4 MB
    </td>
</tr>
<tr>
	<td colspan="3" align="center">	
	    <input type=submit name=sendEmail value="Send mail" class="btn success"/></td>
</tr>
</table>
 
<input type=hidden name=from value="<?=$fromEmail?>">
</form>
</div>
</div>
</td></tr></table> 