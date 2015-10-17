<?php
include('adminCode.php');

if($_POST)
{
    $dbOptions = array(
    'tableName' => 'sales', 
    'dbFields' => array(
        'productID' => $_POST[productID],
        'transID' => $_POST[transID], 
        'itemName' => $_POST[itemName],
        'itemNumber' => $_POST[itemNumber],
        'amount' => $_POST[amount],
        'payerEmail' => $_POST[payerEmail],
        'contactEmail' => $_POST[contactEmail],
        'purchased' => $_POST[purchased],
		'expires' => $_POST[expires],
        'firstName' => $_POST[firstName],
        'lastName' => $_POST[lastName],
        'paidTo' => $_POST[paidTo],
        'affiliate' => $_POST[affiliate],
        'status' => $_POST[status],
        'notes' => $_POST[notes],
        'optout' => $_POST[optout]
        ),
    'cond' => 'where id="'.$_GET[id].'"');
    

    if($_POST[update])
    {
        if(dbUpdate($dbOptions))
            $msg = 'Updated sales record';
    }
    else if($_POST[delete])
    {
        $del = 'delete from sales where id="'.$_GET[id].'"';
        $res = mysql_query($del, $conn) or print(mysql_error());
    }
}

if($_GET[id])
{
    $dbOpt = array(
        'tableName' => 'sales',
        'cond' => ' where id="'.$_GET[id].'"');
    
    $sale = dbSelect($dbOpt); 
    $s = $sale[0];
    
    $disAdd = 'disabled'; 
}
else {
	$disEdit = 'disabled'; 
}

$queryD = 'desc sales'; //describe this table
$resultD = mysql_query($queryD, $conn) or die(mysql_error());

$tableContent .= '<tr bgcolor="FFFFCC"><td colspan=3>Fields: '.mysql_num_rows($resultD).'</td>
    </tr>
    <tr><td>Field</td><td>Type</td><td>Value</td></tr>';

    while($field = mysql_fetch_row($resultD))
    {
        $tableContent .= '<tr><td>'.$field[0].'</td><td>'.$field[1].'</td><td><input type=text name="'.$field[0].'" value="'.$s[$field[0]].'"></td>';      
    } 

if($msg)
{	
	echo '<fieldset><font color=red><b>'.$msg.'</b></font></fieldset>';
}
?>
<form method=post>
<div class="moduleBlue"><h1>Add Sales Record</h1>
<div class="moduleBody">
    <table>
    <?=$tableContent?>
    <tr>
        <td colspan=3 align=center>
            <input type=submit value=" Add Sales Record " <?=$disAdd?> />
            <input type=submit name=update value=" Edit Sales Record " <?=$disEdit?> />
        </td>
    </tr>
    </table>
</div>
</div>

<p>&nbsp;</p>

<div class="moduleBlue"><h1>Delete Record</h1>
<div class="moduleBody">
<center>
    <input type=submit name="delete" value=" Delete Record " onclick="return confirm('Warning: You are about to delete this record permanently')"/>
</center>
</div>
</div>
</form>

<?
include('adminFooter.php');  ?>