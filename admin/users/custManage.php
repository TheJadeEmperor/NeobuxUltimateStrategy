<?php
$adir = '../';
include($adir.'adminCode.php');
$tableName = 'sales';

if($_POST) {
    $dbOptions = array(
		'tableName' => $tableName, 
		'dbFields' => array(
			'productID' => $_POST['productID'],
			'transID' => $_POST['transID'], 
			'itemName' => $_POST['itemName'],
			'itemNumber' => $_POST['itemNumber'],
			'amount' => $_POST['amount'],
			'payerEmail' => $_POST['payerEmail'],
			'contactEmail' => $_POST['contactEmail'],
			'purchased' => $_POST['purchased'],
			'expires' => $_POST['expires'],
			'firstName' => $_POST['firstName'],
			'lastName' => $_POST['lastName'],
			'paidTo' => $_POST['paidTo'],
			'affiliate' => $_POST['affiliate'],
			'status' => $_POST['status'],
			'notes' => $_POST['notes'],
			'optout' => $_POST['optout']
			),
		'cond' => 'where id="'.$_GET['id'].'"'
	);
    
    if($_POST['update']) {
    	$res = dbUpdate($dbOptions);
		$msg = 'Updated sales record';
    }
    else if($_POST['delete']) {

		$opt = array(
			'tableName' => $tableName,
			'cond' => 'WHERE id="'.$_GET['id'].'"'
		); 

		dbDeleteQuery($opt);

		$msg = 'Deleted database record ... redirecting to users list';
		echo '<meta http-equiv="refresh" content="3;URL=userSearch.php">';
    }
}

if($_GET['id']) {
    $dbOpt = array(
        'tableName' => 'sales',
        'cond' => ' where id="'.$_GET['id'].'"'
	);
    
    $sale = dbSelect($dbOpt); 
    $s = $sale[0];
    
    $disAdd = 'disabled'; 
}
else {
	$disEdit = 'disabled'; 
}

$queryD = 'DESC sales'; //describe this table
$resultD = $conn->query($queryD);

$tableContent .= '<tr bgcolor="FFFFCC"><td colspan="3">Fields: '.$resultD->num_rows.'</td>
	</tr>
	<tr>
		<td>Field</td><td>Type</td><td>Value</td>
	</tr>';

    while($field = $resultD->fetch_array()) {
		$tableContent .= '<tr>
		<td>'.$field[0].'</td>
		<td>'.$field[1].'</td>
		<td><input type="text" name="'.$field[0].'" value="'.$s[$field[0]].'"></td>';      
    } 

if($msg) {	
	$msg = showMessage($msg );
}
?>
<form method="POST">
	<div class="moduleBlue"><h1>Edit Sales Record</h1>
	<div class="moduleBody">
		<?=$msg?>
		<table>
		<?=$tableContent?>
		<tr>
			<td colspan="3" align="center">
				<input type="submit" class="btn btn-success" value=" Add Sales Record " <?=$disAdd?> />
				<input type="submit" class="btn btn-success" name="update" value=" Edit Sales Record " <?=$disEdit?> />
			</td>
		</tr>
		</table>
	</div>
	</div>

	<p>&nbsp;</p>

	<div class="moduleBlue"><h1>Delete Record</h1>
	<div class="moduleBody">

		<center>
			<input type="submit" class="btn btn-danger" name="delete" value=" Delete Record " onclick="return confirm('Warning: You are about to delete this record permanently')" />
		</center>
			
		</div>
	</div>
</form>

<?
include('adminFooter.php');  ?>