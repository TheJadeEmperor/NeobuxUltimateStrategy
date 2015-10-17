<?
include('adminCode.php');

if($_POST[add])
{
	//check for errors
	if($_POST[name] == '')
		$error .= 'Name cannot be blank';
	
	if($_POST[url] == '')
		$error .= '<br />URL cannot be blank';
	
	if($error == '')
	{
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
else if($_POST[upd])
{
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

$error = '<p><font color=red><b>'.$error.'</b></font></p>';

$selL = 'select * from links order by name';
$resL = mysql_query($selL, $conn) or die(mysql_error());

while($l = mysql_fetch_assoc($resL))
{
    $id = $l['id'];
    
    $linkList .= '<tr><td><a href="?id='.$id.'">'.$l['name'].'</a></td>
    <td><a href="'.$l['url'].'" target=_blank>'.shortenText($l['url'], 40).'</a></td></tr>';
    
    if($_GET[id] == $id)
    {
        $u = $l;
        $disAdd = 'disabled';
    }
}

?>
<div class=moduleBlue><h1>Add New Link</h1>
<div class="moduleBody">
<?=$error?>
<form method=post>
<table>
<tr>
	<td>Name</td><td><input type=text class=activeField name=name value="<?=$u['name']?>" size=30 /></td>
</tr>
<tr>
	<td>URL</td><td><textarea class=activeField name=url cols=60 rows=2><?=$u['url']?></textarea></td>
</tr>	
<tr>
	<td colspan=2 align=center>
		<input type=submit name=add value=" Add " <?=$disAdd?> />
		<input type=submit name=upd value=" Update " <?=$disUpd?> />
		<input type=reset name=clear value=" Clear " />
	</td>
</tr>
</table>
</form>
</div>
</div>

<br /><br />

<table class="moduleBlue">
    <tr><th>Name</th><th>URL</th></tr>
<?=$linkList?>
</table>

<?
include('adminFooter.php');  ?>