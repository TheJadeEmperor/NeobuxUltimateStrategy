<?php
$adir = '../';
include($adir.'adminCode.php');

if($_POST['delete']) {
    if($_GET['id']) {

        $opt = array(
            'tableName' => 'memberpages',
            'cond' => 'WHERE id="'.$_GET['id'].'"'
        );
        dbDeleteQuery ($opt);

        $opt = array(
            'tableName' => 'pageviews',
            'cond' => 'WHERE page="/?action='.$_POST['url'].'"'
        );
        dbDeleteQuery ($opt);

        $msg = 'Site page deleted';
        $_GET['id'] = ''; 
    }
}

if($_POST['add']) {
    if($_POST['url'] == '')
        $msg .= 'URL is blank';
        
    if($msg == '') {
        $dbOptions = array(
        'tableName' => 'memberpages',
        'dbFields' => array(
            'url' => $_POST['url'],
            'file' => $_POST['file'],
            'header' => $_POST['header'], 
            'footer' => $_POST['footer']
            )
        ); 
       
        dbInsert($dbOptions); //add new page
        
        $pvOptions = array(
        'tableName' => 'pageviews',
        'dbFields' => array(
            'page' => '/?action='.$_POST['url'],
            'uniqueViews' => 0, 
            'rawViews' => 0),
        );
        
        dbInsert($pvOptions); //add new pageview
        
        $msg = 'Added new member page';
    }
    
    $msg = '<font color="red"><b>'.$msg.'</b></font>';
}
else if($_POST['update']) {
    $dbOptions = array(
    'tableName' => 'memberpages',
    'dbFields' => array(
        'url' => $_POST['url'],
        'file' => $_POST['file'],
        'header' => $_POST['header'], 
        'footer' => $_POST['footer']
        ),
    'cond' => 'WHERE id="'.$_GET['id'].'"'
    );
    
    dbUpdate($dbOptions); //update page
    
    $pvOptions = array(
    'tableName' => 'pageviews',
    'dbFields' => array(
        'page' => '/?action='.$_POST['url'],
        ),
    'cond' => 'WHERE page="/?action='.$_POST['oldurl'].'"'
    );
    
    dbUpdate($pvOptions); //update pageview
    
    $msg = 'Updated member page';
    
    $msg = '<font color="red"><b>'.$msg.'</b></font>';
}

if($_GET['id']) {
    $disAdd = 'disabled';
}
else {
	$disEdit = 'disabled';
}

$opt = array(
    'tableName' => 'memberpages', 
    'cond' => 'ORDER BY url');
$resMP = dbSelectQuery($opt);	

while($mp = $resMP->fetch_array()) {
    $mp = stripAllSlashes($mp); //memberpages 
    
    if($_GET['id'] == $mp['id'])
        $m = $mp; 
    
    $mList .= '<tr>
    <td><a href="sitePages.php?id='.$mp['id'].'">'.$mp['url'].'</a></td>
    <td>'.$mp['file'].'</td>
    <td><a href="'.$dir.'?action='.$mp['url'].'" target="_BLANK">Link</a></td>
    </tr>';
}

$mList = '<table>'.$mList.'</table>';

$properties = 'type="text" class="activeField"';
?>

<form method="POST"> 
<div class="moduleBlue"><h1>Add New Page</h1>
<div class="moduleBody">
    <p><font color="red"><strong><?=$msg?></strong></font></p>
    <table>
    <tr>
        <td>URL</td>
        <td>
            <div title="header=[URL] body=[URL of the file: www.website.com/?action=URL
            <br >Letters and numbers only, no special characters] "><img src="<?=$helpImg?>" />
            <input <?=$properties?> name="url" value="<?=$m['url']?>" />
            <input type="hidden" name="oldurl" value="<?=$m['url']?>" />
            </div>
        </td>
    </tr>
    <tr>
        <td>File Name</td>
        <td>
            <div title="header=[File Name] body=[The location of the file, relative to the website root<br>Ex: folder/file.html] "><img src="<?=$helpImg?>" />
            <input <?=$properties?> name="file" value="<?=$m['file']?>" />
            </div>
            </td>
    </tr>
    <tr>
        <td>Header File</td>
        <td> 
            <div title="header=[Header File] body=[File to be included as the header, leave blank if you don't want to use a header] "><img src="<?=$helpImg?>" />
                <input <?=$properties?> name="header" value="<?=$m['header']?>" />
            </div>
        </td>
    </tr>
    <tr>
        <td>Footer File</td>
        <td>
            <div title="header=[Footer File] body=[File to be included as the footer, leave blank if you don't want to use a footer] "><img src="<?=$helpImg?>" />
            <input <?=$properties?> name="footer" value="<?=$m['footer']?>" />
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <input type="submit" class="btn success" name="add" value="Add New Page" <?=$disAdd?> />
            <input type="submit" class="btn info" name="update" value="Update Page" <?=$disEdit?> /> 
            <input type="submit" class="btn danger" name="delete" value="Delete Page" <?=$disEdit?> onclick="return confirm('Are you sure you want to delete this page?')"/>
        </td>
    </tr>
    </table>
</div>
</div>
</form>

<p>&nbsp;</p>

<div class="moduleBlue"><h1>All Site Pages</h1>
<div class="moduleBody">
    <?=$mList?>
</div>
</div>


<?
include($adir.'adminFooter.php');  ?>