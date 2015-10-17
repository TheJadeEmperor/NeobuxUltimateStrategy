<?php
include('adminCode.php');
$tableName = 'emails';

$id = $_GET[id];
$name = $_GET[name];

if($_POST[save])
{
	$dbFields = array(
		'name' => $_POST[name],
		'subject' => $_POST[subject],
		'message' => $_POST[message]);
	
	$set= array();
	foreach($dbFields as $fld => $val)
	{
		array_push($set, $fld.'="'.addslashes($val).'"');
	}
	
	$theSet = implode(',', $set);
	
	$upd = 'update '.$tableName.' set '.$theSet.' where productID="'.$id.'" and name="'.$name.'"';
	mysql_query($upd, $conn) or die(mysql_error()); 
}


$selE = 'select * from '.$tableName.' where productID="'.$id.'" and name="'.$name.'"';
$resE = mysql_query($selE, $conn) or die(mysql_error()); 

$rec = mysql_fetch_assoc($resE);

 


$properties = 'class="activeField" size=60'; 

$theForm = '<form method=post>
<table>
<tr><tr>
	<td>name</td><td><input '.$properties.' name=name value="'.$rec[name].'"></td>
</tr>
	<td>subject</td><td><input '.$properties.' name=subject value="'.$rec[subject].'"></td>
</tr> <tr>
	<td>body </td>
</tr><tr>
	<td colspan=2><textarea name=message rows=25 cols=70>'.stripslashes( $rec[message] ).'</textarea></td>
</tr><tr>
	<td align=center colspan=2><input type=submit name=save value=" Save Changes ">
	<a href="previewEmail.php?id='.$rec[id].'"><input type=button name=preview value=" Preview Email "></a></td>
</tr>
</table></form>';

?>
<div class="moduleBlue"><h1>Emails for Product <?=$id?></h1><div>
<p><a href="?id=<?=$id?>&name=download">Download Email</a> &nbsp; <a href="?id=<?=$id?>&name=welcome">Welcome Affiliate</a> Pending Email</p>
</div></div>

<table>
<tr valign=top>
	<td>
		<?=$theList?>
	</td><td>
		<?=$theForm?>
	</td>
</tr>
</table>