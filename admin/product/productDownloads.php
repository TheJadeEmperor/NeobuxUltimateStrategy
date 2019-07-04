<?php
$adir = '../';
include($adir.'adminCode.php');

if($_GET['id'])  {
    $pID = $_GET['id'];
    
    if($_POST['add']) {
        $ins = 'INSERT INTO downloads (
        productID, 
        name,
        url
        ) values (
        "'.$pID.'",
        "'.$_POST['name'].'",
        "'.$_POST['url'].'")';
        
        mysql_query($ins, $conn) or die(mysql_error());
    }
    else if($_POST['update']) {
        $dbOptions = array(
        'tableName' => 'downloads',
        'dbFields' => array(
            'name' => $_POST['name'],
            'url' => $_POST['url']),
        'cond' => 'where id="'.$_POST['id'].'"'
        );
        
        dbUpdate($dbOptions);
    }
	else if($_POST['delete_x'] && $_POST['delete_y']) {
        $del = 'DELETE FROM downloads WHERE id="'.$_POST['downloadID'].'"';
        mysql_query($del, $conn) or die(mysql_error());
    }

	
	if($_GET['debug'] == 1) {
		echo $ins; echo $del;
		echo '<pre>'; print_r($_POST); echo '</pre>';
	}
	
    
    $properties = 'type="text" class="activeField"';
        
    $sel = 'SELECT *, d.id AS downloadID FROM downloads d LEFT JOIN products p ON p.id = d.productID WHERE productID="'.$pID.'" ORDER BY name ASC';
    $res = mysql_query($sel, $conn) or die(mysql_error());
    
    $c = 1;
    while($d = mysql_fetch_assoc($res)) {   
        $downloadsList .= '<form method="POST">
        <tr valign="top">
        <td>'.$c.'</td>
        <td>
            <input '.$properties.' name="name" value="'.$d['name'].'" size="25"/><br />
            <input type="submit" name="update" value="Update" />
        </td>
        <td>
            <input '.$properties.' name="url" value="'.$d['url'].'" size="60"/><br />
            <input type="submit" name="dl" value="Test Download">
        </td>
        <td>
            <input type="hidden" name="downloadID" value="'.$d['downloadID'].'" /> 
            <input type="image" name="delete" value="" src="'.$delImg.'" onclick="confirm(\'Are you sure?\');">
        </td>
        </tr>
        </form>';
        
        $itemName = $d['itemName'];
        $c++; 
    }
}
?>
<div class="moduleBlue"><h1>Downloads for <?=$itemName?></h1><div>
	<center>   
	<br />
	<p><a href="productNew.php?id=<?=$pID?>"><button class="btn btn-success">Edit Product</button></a></p>
	
	</center>
</div>
</div>

<p>&nbsp;</p>

<table class="moduleBlue" cellspacing="0" cellpadding="2">    
    <tr>
        <th>#</th><th>Name</th><th>URL</th><th></th>
    </tr>
    <tr>
        <?=$downloadsList?>
    </tr>
</table>

<p>&nbsp;</p>

<form method="POST">
<div class="moduleBlue"><h1>Add New Download</h1>
<div>
     <table>
         <tr>
             <td>Name of Download</td>
             <td><input <?=$properties?> name="name" value="" /></td>
         </tr>
         <tr>
             <td>URL of Download</td>
             <td><input <?=$properties?> name="url" value="" /></td>
         </tr>
         <tr>
             <td colspan="2" align="center"><input type="submit" name="add" value="Add Download" /></td>
         </tr>
     </table>   
</div>
</div>
</form>

<?
include($adir.'adminFooter.php'); ?>