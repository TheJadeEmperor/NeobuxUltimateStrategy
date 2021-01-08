<?php
$selC = 'SELECT count(*) AS count FROM posts WHERE status<>"I"';

$resC = $conn->query($selC);
$c = $resC->fetch_array();
 
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
$selP = 'SELECT *, date_format(postedOn, "%m/%d/%Y %h:%i %p") AS published, p.id AS id, u.id as uid FROM posts p LEFT JOIN users u ON p.postedBy = u.id WHERE (p.status<>"I" OR p.status is null) ORDER BY postedOn DESC LIMIT '.$firstPost.', 10';

$resP = $conn->query($selP);

while($p = $resP->fetch_array() ) {
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