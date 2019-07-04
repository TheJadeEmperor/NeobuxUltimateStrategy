<?php
$adir = '../';
include($adir.'adminCode.php'); 

$sel = 'SELECT * FROM products ORDER BY id DESC';
$res = mysql_query($sel, $conn) or die(mysql_error());

while($p = mysql_fetch_assoc($res)) {
	
	$id = $p['id'];
	
	$theList .= '<tr valign="top">
	<td><a href="productNew.php?id='.$id.'">'.$id.'</a></td>
	<td><a href="productNew.php?id='.$id.'">'.shortenText($p['itemName'], 30).'</a><br />
	>> <a href="../../'.$p['folder'].'" target="_blank">Visit Sales Page</a></td>
	<td>'.$p['itemPrice'].'</td>
	<td>'.$p['itemNumber'].'</td>
	<td align="center"><a href="productEmailsList.php"><button class="btn btn-info">Edit</button></a></td>
	<td align="center"><a href="productDownloads.php?id='.$id.'"><button class="btn btn-warning">Downloads</button></a></td>
	</tr>';
}

?>
<table class="moduleBlue" cellspacing="0" cellpadding="2">
	<tr>
		<th>Product ID</th><th>Item Name</th><th>Item Price</th><th>Item #</th>
		<th>Emails</th><th>Downloads</th>
	</tr>
	
	<tbody><?=$theList?></tbody>
</table>

<p>&nbsp; </p>

<?
include($adir.'adminFooter.php'); ?>