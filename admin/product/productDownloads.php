<?php
$adir = '../';
include($adir.'adminCode.php');

if($_GET['id']) {
    $pID = $_GET['id'];
    
    if($_POST['add']) {

        $opt = array(
            'tableName' => 'downloads',
            'dbFields' => array(
                'productID' => $pID,
                'name' => $_POST['name'],
                'url' => $_POST['url'],
            )
        );

        dbInsert($opt); 
    }
    else if($_POST['update']) {
    	
		$dbOptions = array(
            'tableName' => 'downloads',
            'dbFields' => array(
                'name' => $_POST['name'],
                'url' => $_POST['url']),
            'cond' => 'where id="'.$_POST['downloadID'].'"'
        );
        
        dbUpdate($dbOptions); 
    }
	else if($_POST['delete_x'] && $_POST['delete_y']) { 
        
        $opt = array(
            'tableName' => 'downloads',
            'cond' => 'WHERE id="'.$_POST['downloadID'].'"' 
        ); 
        dbDeleteQuery ($opt); //'DELETE FROM downloads WHERE id="'.$_POST['downloadID'].'"'
    }

    
    $properties = 'type="text" class="activeField"';
        
    $sel = 'SELECT *, d.id AS downloadID FROM downloads d LEFT JOIN products p ON p.id = d.productID WHERE productID="'.$pID.'" ORDER BY name ASC';
    $res = $conn->query($sel);  
    
    $c = 1;
    while($d = $res->fetch_array()) {   
        $downloadsList .= '<form method="POST">
        <tr valign="top">
        <td>'.$c.'</td>
        <td>
            <input '.$properties.' name="name" value="'.$d['name'].'" size="25"/><br />
            <input type="submit" name="update" value="Update" class="btn info" />
        </td>
        <td>
            <input '.$properties.' name="url" value="'.$d['url'].'" size="60"/><br />
            <input type="submit" name="dl" value="Test Download" class="btn info">
        </td>
        <td>
            <input type="hidden" name="downloadID" value="'.$d['downloadID'].'" /> 
            <input type="image" name="delete" value="" src="'.$delImg.'" onclick="confirm(\'Are you sure you want to delete this record?\');">
        </td>
        </tr>
        </form>';
        
        $itemName = $d['itemName'];
        $c++; 
    }
}

if($_GET['debug'] == 1) {
    echo '<pre>'; 
    echo $sel.'<br />'; 
    print_r('Post:'.$_POST); echo '</pre>';
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
             <td colspan="2" align="center"><input type="submit" name="add" value="Add Download" class="btn success" /></td>
         </tr>
     </table>   
</div>
</div>
</form>

<?
include($adir.'adminFooter.php'); ?>