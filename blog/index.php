<?php
$selC = 'select count(*) as count from posts where status<>"I"';
$resC = mysql_query($selC, $conn) or die(mysql_error()); 

$c = mysql_fetch_assoc($resC); 

$totalPosts = $c['count'];
$perPage = 10; 

$numPages = ceil($totalPosts / $perPage);  

$lastPost = $_GET['page'] * $perPage; 
$firstPost = $lastPost - ($perPage);

if($firstPost < 0)
    $firstPost = 0;

$categories = 1; 
echo '<h1>Latest Posts from '.$businessName.'</h1>
<p>Total in archives: '.$totalPosts.' posts in '.$categories.' category(s)</p>';

//show the latest 10 active posts
$sel = 'select *, date_format(postedOn, "%m/%d/%Y %h:%i %p") as published, p.id as id, u.id as uid 
from posts p left join users u on p.postedBy = u.id where (p.status<>"I" or p.status is null) 
order by postedOn desc limit '.$firstPost.', 10';

$res = mysql_query($sel, $conn) or die(mysql_error());

while($p = mysql_fetch_assoc($res)) {
    $id = $p['id']; 
    $subject = stripslashes($p['subject']); 
    $published = $p['published']; 
	
    $postContent .= '<table>
	<tr valign="top">
            <td>
		<a href="./?p='.$p['url'].'"><h3>'.$subject.'</h3></a><p>By <a href="./">Admin</a>
		<br>Published on '.$published.'</p>
            </td>
	</tr>
	</table><br />
        <div class="separator"></div><br />';  
}

echo $postContent; 
?>
<center>
    <div class="pagination">
    <table>
        <tr>
            <td>
                <ul>
                    <li><a href>Page >> </a></li>
<?
for($n = 1; $n <= $numPages; $n++) {
    echo '<li><a href="./?action=posts&page='.$n.'">'.$n.'</a></li>';
}
?>
            </ul>
        </td>
    </tr>
    </table>
    </div>
</center>

<p>&nbsp;</p>