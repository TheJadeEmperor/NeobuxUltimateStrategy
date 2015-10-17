<?php
$adir = '../';
include($adir.'adminCode.php');

//update download email options
if($_POST[updateEmailOptions])
{ 
    $updEC = 'update settings set setting="'.$_POST['sendDownloadEmailCopy'].'" where opt="sendDownloadEmailCopy"';
    mysql_query($updEC, $conn) or die(mysql_error());
    
    $updEA = 'update settings set setting="'.$_POST['sendDownloadEmailAddress'].'" where opt="sendDownloadEmailAddress"';
    mysql_query($updEA, $conn) or die(mysql_error());
    
    $val['sendDownloadEmailCopy'] = $_POST['sendDownloadEmailCopy'];
    $val['sendDownloadEmailAddress'] = $_POST['sendDownloadEmailAddress'];
}

if($val['sendDownloadEmailCopy'] == 'on')
{
    $downloadEmailChecked = 'checked';
} 
else
{
    $downloadEmailDisabled = 'disabled'; 
}



$opt = array(
'tableName' => 'emails', 
'cond' => ' order by productID, type');

$emailList = dbSelect($opt); 

foreach($emailList as $e)
{
    //get product info
    $selP = 'select * from products where id="'.$e[productID].'"';
    $resP = mysql_query($selP, $conn) or die(mysql_error()); 
    $p = mysql_fetch_assoc($resP); 
    
    if($currentProduct == $p[itemName])
    {
        $theList .= '<tr>
        <td></td>
        <td><a href="productEmailsEdit.php?id='.$e[productID].'&type='.$e[type].'">'.$e[type].'</a></td>
        <td>'.$e[subject].' </td>
        </tr>';
    }
    else {
        $itemName = $currentProduct = $p[itemName]; 
        $theList .= '<tr><td></td></tr>
        <tr>
        <td><a href="productNew.php?id='.$e[productID].'">'.$itemName.'</a></td>
        <td><a href="productEmailsEdit.php?id='.$e[productID].'&type='.$e[type].'">'.$e[type].'</a></td>
        <td>'.$e[subject].' </td>
        </tr>';
    }
}
?>

<div class="moduleBlue"><h1>Download Emails</h1>
<form method=post>
    <table>
    <tr>
        <td>Send Myself A Copy of The Confirmation Email</td>
        <td><input type=checkbox name="sendDownloadEmailCopy" <?=$downloadEmailChecked?> /></td>
    </tr>
    <tr>
        <td>Send Email Copy to This Email Address<br /><input type=text name="sendDownloadEmailAddress" value="<?=$val['sendDownloadEmailAddress']?>" <?=$downloadEmailDisabled?> size="40" /></td>
    </tr>
    <tr>
        <td align="center"><input type="submit" name="updateEmailOptions" value="Update Email Options" /></td>
    </tr>
    </table>
</form>
</div>

<p>&nbsp;</p>

<table class="moduleBlue" cellspacing=0 cellpadding=5>
	<tr><th>Product</th><th>Type</th><th>Subject</th></tr>
	<?=$theList?>
</table>

<?
include($adir.'adminFooter.php');  ?>