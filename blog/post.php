<?php
$url = $_GET['p']; 
$websiteURL = $val['websiteURL']; 

//get post details
$sel = 'SELECT *, date_format(postedOn, "%m/%d/%Y %h:%i %p") AS postedOn, p.id AS id
FROM posts p WHERE p.url="'.$url.'" LIMIT 1';
$res = mysql_query($sel, $conn) or die(mysql_error());

if(mysql_num_rows($res) > 0) {
    $p = mysql_fetch_assoc($res);

    $postID = $p[id]; 
    $p[post] = stripslashes($p[post]);
    $p[subject] = stripslashes($p[subject]);
    $postLink = $websiteURL.'/'.$url;

    if($p[subject]=='')
        $p[subject] = '[No Subject]';

    if($p[post]=='')
        $p[post] = '[No content]';

    $keywords = explode(', ', $p[tags]);
    $tagArray = array();
	
    foreach($keywords as $piece) {
            array_push($tagArray, '<b><a href="./?p='.$url.'" title="'.$piece.'">'.$piece.'</a></b>'); 
    }

    $tags = implode(', ', $tagArray); 

    //get comments
    $selC = 'select *, date_format(c.postedOn, "%m/%d/%Y %h:%i %p") as postedOn from comments c 
    left join users u on c.postedBy=u.id where replyID="'.$postID.'"';
    $resC = mysql_query($selC, $conn) or die(mysql_error());

    $num = mysql_num_rows($resC); 

    while($c = mysql_fetch_assoc($resC))
    {
        $c[post] = stripslashes($c[post]);
        $c[subject] = stripslashes($c[subject]);

        $contentComments .= '<div style="border: 1px solid gray; padding: 10px; background-color: #efefef;">'.$c[post].'
        <div style="text-align: right">By <a href="#">'.$c[username].'</a> on '.$c[postedOn].'</div></div><br>';
    }
}


if(mysql_num_rows($res) > 0) {
    
    $subject = $p['subject']; 
    
    $postLink = 'http://neobuxultimatestrategy.com/?p='.$url;
    
    echo '<header class="major">
		<h2>'.$p['subject'].'</h2>
	</header>
	
	<a href="'.$postLink.'" class="postTitle" title="'.$p['subject'].'">
    <h1>'.$p['subject'].'</h1></a> 

    <p>By <a href="#">Admin</a> on '.$p['postedOn'].'</p>

    <p>&nbsp;</p>'; 


    if($p['useHTMLFile'] == 'on') {
        include('blog/'.$url.'.html');
    }
    else {
        echo $p['post']; 
    }
    
    echo '<p>&nbsp; </p>
    <span class="st_twitter_vcount" displayText="Tweet"></span>
    <span class="st_email_vcount" displayText="Email"></span>
    <span class="st_facebook_vcount" displayText="Facebook"></span>
    <span class="st_sharethis_vcount" displayText="ShareThis"></span>
    <span class="st_fblike_vcount" st_title="'.$subject.'" st_url="'.$postLink.'" displayText="share"></span>

    <table width="100%" id="comments">
	<tr valign="top">
	<td align="left"><p>Tags: '.$tags.' </p></td>
	<td align="right" width="150px"><p>Comments ('.$num.') </p></td>
	</tr>
	</table> 
	<p>&nbsp;</p>'; 

    echo $_SESSION[msg]; 
}
else {
    echo 'No post by that title exists'; 
}

?>