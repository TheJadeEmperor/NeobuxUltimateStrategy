<?
include('adminCode.php');

if($_POST['add']) {
	//check for errors
	if($_POST['name'] == '')
		$error .= 'Name cannot be blank';
	
	if($_POST['url'] == '')
		$error .= '<br />URL cannot be blank';
	
	if($error == '') {
	    $dbOptions = array(
        'tableName' => 'links',
        'dbFields' => array(
            'name' => $_POST['name'],
            'url' => $_POST['url'],
			'notes' => $_POST['notes'],
            )
        );
		
        dbInsert($dbOptions);
	}
    
    $disUpd = 'disabled';
}
else if($_POST['upd']) {
    $dbOptions = array(
    'tableName' => 'links',
    'dbFields' => array(
        'name' => $_POST['name'],
        'url' => $_POST['url'],
		'notes' => $_POST['notes'],
        ),
    'cond' => 'where id="'.$_GET['id'].'"'
    );    
    
    dbUpdate($dbOptions);
}
else if($_POST['delete']) {

	$opt = array(
		'tableName' => 'links',
		'cond' => 'WHERE id="'.$_GET['id'].'"');

	dbDeleteQuery ($opt);
		   
	$error = 'Successfully deleted link '.$_GET['id'];
}


$error = '<p><font color="red"><b>'.$error.'</b></font></p>';



$opt = array(
 	'tableName' => 'links',
	'cond' => 'ORDER BY name');

$res = dbSelectQuery($opt);	

while($l = $res->fetch_array()) {
    $id = $l['id'];
	$thisURL = $l['url'];
	$name = $l['name'];
	
	$redirectURL = $websiteURL.'/redirect.php?url='.$name;
    
    $linkList .= '<tr><td><a href="?id='.$id.'">'.$name.'</a></td>
    <td><a href="'.$thisURL.'" target="_BLANK">'.shortenText($thisURL, 40).'</a></td>
	<td><a href="'.$redirectURL.'" target="_BLANK">'.shortenText($redirectURL, 40).'</a></td>
	</tr>';
    
    if($_GET['id'] == $id) {
        $u = $l;
        $disAdd = 'disabled';
    }
}

if($_GET['id']) {
	$disAdd = 'disabled';
}
else {
	$disUpd = 'disabled';
}
?>
<div class="moduleBlue"><a href="links.php"><h1>Add/Update New Link</h1></a>
<div class="moduleBody">
	<?=$error?>
	<form method="POST">
	<table>
	<tr>
		<td>Name</td>
		<td><input type="text" class="activeField" name="name" value="<?=$u['name']?>" size="30" /></td>
	</tr>
	<tr>
		<td>URL</td>
		<td><textarea class="activeField" name="url" cols="60" rows="2"><?=$u['url']?></textarea></td>
	</tr>	
	<tr>
		<td>Notes</td>
		<td><textarea class="activeField" name="notes" cols="60" rows="3"><?=$u['notes']?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<input type="submit" name="add" value=" Add " <?=$disAdd?> class="btn btn-success" />
			<input type="submit" name="upd" value=" Update " <?=$disUpd?> class="btn btn-warning" />
			<input type="submit" name="delete" value=" Delete " <?=$disUpd?> class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this link?')" />
		</td>
	</tr>
	</table>
	</form>
</div>
</div>

<br /><br />

<table class="moduleBlue">
    <tr><th><a href="links.php">Name</a></th>
	<th><a href="links.php">URL</a></th>
	<th><a href="links.php">Redirect URL</a></th></tr>
	<?=$linkList?>
</table>

<?
include('adminFooter.php'); ?>