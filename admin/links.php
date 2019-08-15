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
            'url' => $_POST['url'] 
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
        ),
    'cond' => 'where id="'.$_GET['id'].'"'
    );    
    
    dbUpdate($dbOptions);
}
else if($_POST['delete']) {

	$delL = 'DELETE FROM links WHERE id="'.$_GET['id'].'"';
	mysql_query($delL, $conn) or die(mysql_error());
		   
	$error = 'Successfully deleted link '.$_GET['id'];
}


$error = '<p><font color="red"><b>'.$error.'</b></font></p>';

$selL = 'SELECT * FROM links ORDER BY name';
$resL = mysql_query($selL, $conn) or die(mysql_error());

while($l = mysql_fetch_assoc($resL)) {
    $id = $l['id'];
    
    $linkList .= '<tr><td><a href="?id='.$id.'">'.$l['name'].'</a></td>
    <td><a href="'.$l['url'].'" target=_blank>'.shortenText($l['url'], 40).'</a></td></tr>';
    
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
	<th><a href="links.php">URL</a></th></tr>
<?=$linkList?>
</table>

<?
include('adminFooter.php');  ?>