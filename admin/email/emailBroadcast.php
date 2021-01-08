<?php
$adir = '../';
include($adir.'adminCode.php');

function isLegalName($string) { //check for illegal characters in a field

	$illegal = array('#', '$', '?', '&', '!', ' ', '"');
	
	foreach($illegal as $check) {
		if(is_int(strpos($string, $check))) {
			return false;
		}
	}
	
	return true;
}

/////////////////////////////
$tableName = 'newsletter';
/////////////////////////////

$dbFields = array(
	'category' => $_POST['category'],
	'subject' => $_POST['subject'], 
	'message' => addslashes($_POST['message']) 
);

if($_POST['add']) {
	if($_POST['category'] == '' || $_POST['subject'] == '') {
		$msg = 'Fields cannot be blank.';
	}
	else {
		if(!isLegalName($_POST['category'])) {
			$msg = 'Illegal characters in category field.';
		}
		else {

			$dbOptions = array(
				'tableName' => $tableName,
				'dbFields' => $dbFields
			);
				
			dbInsert($dbOptions);
			
		}
	}
}
else if($_POST['edit']) {
	if(!isLegalName($_POST['category'])) {
		$msg = 'Illegal characters in category field.';
	}
	else {

		$queryOptions = array( //update settings table
            'tableName' => $tableName, 
			'dbFields' => $dbFields,
			'cond' => ' WHERE category="'.$_GET['cat'].'"'
		);

        dbUpdate($queryOptions); 
	}
}


$opt = array(
	'tableName' => $tableName,
	'cond' => 'ORDER BY category');

$res = dbSelectQuery($opt);	

while($array = $res->fetch_array()) {
	if($_GET['cat'] == $array['category']) {
		$theList .= '<a href="?cat='.$array['category'].'"><strong>'.$array['category'].'</strong></a><br />';
		$bc = $array;
	}
	else
		$theList .= '<a href="?cat='.$array['category'].'">'.$array['category'].'</a><br />';
}


if($_GET['cat']) { //editing a broadcast

	if($_POST['del']) {	
			
		$opt = array(
			'tableName' => $tableName,
			'cond' => 'WHERE category="'.$_GET['cat'].'"'
		);
	
		dbDeleteQuery ($opt);
	}

	$disAdd = 'disabled';
}
else {
	$disEdit = 'disabled';
}

$addEditButtons = '
<table> 
<tr>
	<td>Category</td><td><input type="text" name="category" value="'.$bc['category'].'" class="input">'.$addEditButtons.'</td>
</tr><tr>
	<td>Subject</td><td><input type="text" name="subject" value="'.$bc['subject'].'" class="input" size="50"></td>
</tr><tr>
	<td colspan="2">Broadcast Message (html code) <br /><textarea cols="70" rows="30" name="message">'.stripslashes($bc['message']).'</textarea></td>
</tr><tr>
	<td colspan="2" align="center">
	<input type="submit" name="add" value=" Add Broadcast " class="btn success" '.$disAdd.'>
    <input type="submit" name="edit" value=" Save Broadcast " class="btn info" '.$disEdit.'>
	<a href="'.$_SERVER['PHP_SELF'].'"><input type="button" class="btn btn-warning" value=" Clear "></a>
	<input type="submit" name="del" value=" Delete " class="btn danger" '.$disEdit.'>
	
	</td>
</tr>
</table>';


if($msg)
	$msg = showMessage($msg);

//current URL and parameters
$action = $_SERVER['REQUEST_URI'];     
?>
<table>
<tr valign="top">
    <td>
        <div class="moduleBlue"><h1>Emails List</h1>
        <div class="moduleBody"><?=$theList?>
        </div>    
        </div>    
    </td>
    <td>
        <div class="moduleBlue"><h1>Edit Broadcast Emails</h1>
        <div class="moduleBody">
            <?=$msg?>
            <form method="POST" action="<?=$action?>"> 
            <?=$addEditButtons?>
            </form>
        </div></div>
    </td>
</tr>
</table>

<?
include($adir.'adminFooter.php'); ?>