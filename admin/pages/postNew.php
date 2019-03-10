<?php
$adir = '../';
include($adir.'adminCode.php');

if($_POST['save']) { //insert into db 

    $url = addslashes($_POST[url]);
    
    //error checking
    if($_POST['subject'] == '') {
        $msg .= '* Subject line is required <br />';
    }
    
    if($_POST['url'] == '') {
        $msg .= '* URL is required <br />';
    }
    
    if($msg) {
        $msg = '<font color="red"><b>Please fix the following errors: <br />'.$msg.'</b></font>';
    }
    else {
        $dbFields = array(
            'subject' => '"'.addslashes($_POST['subject']).'"', 
            'post' => '"'.addslashes($_POST['elm1']).'"',
            'postedBy' => '"'.$_SESSION['login']['id'].'"',
            'postedOn' => 'now()', 
            'tags' => '"'.addslashes($_POST['tags']).'"', 
            'url' => '"'.addslashes($_POST['url']).'"',
            'status' => '"'.$_POST['status'].'"',
            'useHTMLFile' => '"'.$_POST['useHTMLFile'].'"',
			'HTMLFileName' => '"'.$_POST['HTMLFileName'].'"'
        );
    
        $fields = $values = array();
    
        foreach($dbFields as $fld => $val)
        {
            array_push($fields, $fld);
            array_push($values, $val); 
        }
    
        $theFields = implode(',', $fields);
        $theValues = implode(',', $values); 
    
        //add post
        $ins = 'insert into posts ('.$theFields.') values ('.$theValues.') ';
        $res = mysql_query($ins, $conn) or die(mysql_error()); 
        $postID = mysql_insert_id();
        
        //add view     
        $dbOptions = array(
        'tableName' => 'pageviews',
        'dbFields' => array(
            'page' => '?p='.$url,
            'uniqueViews' => 0,
            'rawViews' => 0,
        ) 
        );
        
        dbInsert($dbOptions); 
    
        echo '<meta http-equiv="refresh" content="1;url=postNew.php?id='.$postID.'">';
    }
}
else if($_POST['update']) {
	$opt = array(
		'tableName' => 'posts',	
		'dbFields' => array(
			'subject' => $_POST['subject'], 
			'post' => $_POST['elm1'],
			'postedBy' => $_SESSION['login']['id'], 
			'postedOn' => $_POST['postedOn'], 
			'tags' => $_POST['tags'], 
			'url' => $_POST['url'],
			'status' => $_POST['status'],
			'useHTMLFile' => $_POST['useHTMLFile'],
			'HTMLFileName' => $_POST['HTMLFileName'],
		),
		'cond' => 'where id="'.$_GET[id].'"'
	);
	
	if(dbUpdate($opt))
		$msg = 'Post has been updated.'; 
}

if($_GET['id']) {
	$opt = array(
	'tableName' => 'posts',
	'cond' => 'where id="'.$_GET[id].'"'); 
	
	$allPosts = dbSelect($opt); 	
	$p = $allPosts[0]; 

	$disAdd = 'disabled'; 
}
else
	$disEdit = 'disabled';

//status: active or inactive
$statusChoice = array(
'A' => 'Active',
'I' => 'Inactive');

foreach($statusChoice as $sta => $dis) {
    $pick = '';
    if($p[status] == $sta)
        $pick = 'selected';
    $statusOpt .= '<option '.$pick.' value="'.$sta.'">'.$dis.'</option>';
}

//use html file?
if($p['useHTMLFile'] == 'on')
    $useHTMLChecked = 'checked';

$postURL = $dir.'?p='.$p['url'];
?>

<form method="post">
<div class="moduleBlue" style="width: 720px;"><h1>Add or Update Post</h1>
<div class="moduleBody">
    <?=$msg?>
<table>
	<tr>	
		<td width="150px"> subject: </td>
		<td><input class="activeField" name="subject" size="75" value="<?=$p['subject']?>"></td>
	</tr><tr>
		<td> url: </td>
		<td><input class="activeField" name="url" size="75" value="<?=$p['url']?>"><br />
		<a href="<?=$postURL?>" target="_BLANK"><?=$postURL?></a>
		</td>
	</tr><tr>
		<td> tags: </td>
		<td>
			<textarea rows="2" cols="60" name="tags"><?=$p['tags']?></textarea>
		</td>
	</tr>
	<tr>
		<td> postedBy: </td>
		<td>
			<input class="activeField" name="url" size="57" value="<?=$p['postedBy']?>">
		</td>
	</tr>
	<tr>
		<td> postedOn: </td>
		<td>
			<input class="activeField" name="postedOn" size="57" value="<?=$p['postedOn']?>">
		</td>
	</tr>
	<tr>
	
	
	    <td> status: </td>
	    <td> 
	        <select name="status">
	        <?=$statusOpt?>
            </select>
	    </td>
	</tr>
	<tr>
	    <td>UseHTMLFile? </td>
	    <td>
	        <input type="checkbox" class="activeField" name="useHTMLFile" <?=$useHTMLChecked?> />
	    </td>
	</tr>
	<tr>
		<td>HTMLFileName </td>
	    <td>
	        <input type="text" class="activeField" name="HTMLFileName" 
			value="<?=$p['HTMLFileName'] ?>" size="50" />
	    </td>
	</tr>
</table>

<br /><br />
<center>
    <input type="submit" <?=$disAdd?> name="save" value="New Post" />
    <input type="submit" <?=$disEdit?> name="update" value="Save" />
    <input type="reset" name="reset" value="Reset" />

</center><br />
</div></div>
</form>
<?
include('adminFooter.php');  ?>