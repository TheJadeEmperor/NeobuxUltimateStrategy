<?php
include('adminCode.php'); 

if($_POST['delete']) {
    if(sizeof($_POST['id']) > 0)
    foreach($_POST['id'] as $deleteThis) {	
        $del = 'delete from posts where id="'.$deleteThis.'"';
        $res = mysql_query($del, $conn); 	
    }
}

$sel = 'SELECT *, date_format(postedOn, "%m/%d/%Y %h:%i %p") as postedTime, p.id as id, u.id as uid 
from posts p left join users u on p.postedBy = u.id order by postedOn asc'; 
$res = mysql_query($sel, $conn) or die(mysql_error());

while($p = mysql_fetch_assoc($res)) {
    $pID = $p[id];

    $subject = stripslashes($p['subject']); 
	
    $theList .= '<tr valign="top" title="'.$subject.'">
        <td><a href="postNew.php?id='.$pID.'">'.$pID.'</a>
        </td><td><a href="postNew.php?id='.$pID.'">'.shortenText($subject, 30).'</a></td>
        <td>'.$p['postedTime'].'</td>
        <td><a href="'.$websiteURL.'?p='.$p['url'].'" target="_blank" >View</a></td>
        <td><input type=checkbox name="id[]" value="'.$pID.'"> </td>
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
        <td colspan="4"><input type=submit name=delete value="Delete Post" onclick="return confirm('** Deletions are irreversible. Are you sure you want to proceed? **');" />        
        </td>
    </tr>
</table>
</form>

<p>&nbsp;</p>

<?
include('adminFooter.php');  ?>