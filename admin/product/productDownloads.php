<?php
$adir = '../';
include($adir.'adminCode.php');

if($_GET['id']) 
{
    $pID = $_GET['id'];
    
    if($_POST['add']) 
    {
        $ins = 'insert into downloads (
        productID, 
        name,
        url
        ) values (
        "'.$pID.'",
        "'.$_POST['name'].'",
        "'.$_POST['url'].'")';
        
        mysql_query($ins, $conn) or die(mysql_error());
    }
    else if($_POST['update'])
    {
        $dbOptions = array(
        'tableName' => 'downloads',
        'dbFields' => array(
            'name' => $_POST['name'],
            'url' => $_POST['url']),
        'cond' => 'where id="'.$_POST['id'].'"'
        );
        
        dbUpdate($dbOptions);
    }
    
    if($_POST['del']) 
    {
        $del = 'delete from downloads where id="'.$_POST['id'].'"';
        mysql_query($del, $conn) or die(mysql_error());
    }
    
    $properties = 'type="text" class="activeField"';
        
    $sel = 'select *, d.id as downloadID from downloads d left join products p on p.id = d.productID
    where productID="'.$pID.'" order by name asc';
    $res = mysql_query($sel, $conn) or die(mysql_error());
    
    $c = 1;
    while($d = mysql_fetch_assoc($res)) 
    {   
        $downloadsList .= '<form method=post>
        <tr valign=top>
        <td>'.$c.'</td>
        <td>
            <input '.$properties.' name="name" value="'.$d[name].'" size="25"/><br>
            <input type="submit" name="update" value="Update" />
        </td>
        <td>
            <input '.$properties.' name="url" value="'.$d[url].'" size="60"/><br>
            <input type="submit" name="dl" value="Test Download">
        </td>
        <td>
            <input type=hidden name="id" value="'.$d[downloadID].'" /> 
            <input type=image name="del" value="del" src="'.$delImg.'" onclick="confirm(\'Are you sure?\');">
        </td>
        </tr>
        </form>';
        
        $itemName = $d['itemName'];
        $c++; 
    }
}
?>
<div class="moduleBlue"><h1>Downloads for <?=$itemName?></h1><div>
    <a href="productNew.php?id=<?=$pID?>">Edit Product</a>
</div>
</div>

<p>&nbsp;</p>

<table class="moduleBlue" cellspacing=0 cellpadding=2>    
    <tr>
        <th>#</th><th>Name</th><th>URL</th><th></th>
    </tr>
    <tr>
        <?=$downloadsList?>
    </tr>
</table>

<p>&nbsp;</p>

<form method=post>
<div class="moduleBlue"><h1>Add New Product</h1>
<div>
     <table>
         <tr>
             <td>Name of Download</td>
             <td><input <?=$properties?> name=name value=""></td>
         </tr>
         <tr>
             <td>URL of Download</td>
             <td><input <?=$properties?> name=url value=""></td>
         </tr>
         <tr>
             <td><input type=submit name=add value="Add Download"/></td>
         </tr>
     </table>   
</div>
</div>
</form>