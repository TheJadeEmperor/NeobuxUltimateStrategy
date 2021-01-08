<?php
$adir = '../';
include($adir.'adminCode.php');

if($_POST['delete']) {
    if(sizeof($_POST['id']) > 0)
    foreach($_POST['id'] as $deleteThis) {
        
        $opt = array(
            'tableName' => 'posts',
            'cond' => 'WHERE id="'.$deleteThis.'"'
        );
 
        dbDeleteQuery ($opt);  //'DELETE FROM posts WHERE id="'.$deleteThis.'"'  
    }
}


$sel = 'SELECT *, date_format(postedOn, "%m/%d/%Y %h:%i %p") AS postedTime, p.id AS id, u.id AS uid FROM posts p LEFT JOIN users u ON p.postedBy = u.id ORDER BY postedOn ASC'; 
$res = $conn->query($sel);

while($p = $res->fetch_array()) {
    $pID = $p['id'];

    $subject = stripslashes($p['subject']); 
	
    $theList .= '<tr valign="top" title="'.$subject.'">
        <td><a href="postNew.php?id='.$pID.'">'.$pID.'</a>
        </td><td><a href="postNew.php?id='.$pID.'">'.shortenText($subject, 50).'</a></td>
        <td>'.$p['postedTime'].'</td>
        <td><a href="'.$dir.'?p='.$p['url'].'" target="_BLANK" >View</a></td>
        <td><input type="checkbox" name="id[]" value="'.$pID.'"></td>
    </tr>';
}
?>
<form method="POST">
<table class="moduleBlue" cellpadding="2">
    <tr>
        <th>Post ID </th>
        <th>Subject</th>
        <th>Date & Time</th>
        <th>View</th>
        <th>Delete</th>
    </tr>
	<?=$theList?>
    <tr>
        <td></td>
        <td colspan="4" align="center"><input type="submit" name="delete" value="Delete Post" class="btn danger" onclick="return confirm('** Deletions are irreversible. Are you sure you want to proceed? **');" />        
        </td>
    </tr>
</table>
</form>

<p>&nbsp;</p>
<?
include($adir.'adminFooter.php');  ?>