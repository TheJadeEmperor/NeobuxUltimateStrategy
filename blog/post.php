<?php
$url = $_GET['p']; 
$websiteURL = $val['websiteURL']; 

//get post details
$sel = 'SELECT *, date_format(postedOn, "%m/%d/%Y %h:%i %p") AS postedOn, p.id AS id
FROM posts p WHERE p.url="'.$url.'" LIMIT 1';
$res = mysql_query($sel, $conn) or die(mysql_error());

if(mysql_num_rows($res) > 0) {
    $p = mysql_fetch_assoc($res);

    $postID = $p['id']; 
    $p['post'] = stripslashes($p['post']);
    $p['subject'] = stripslashes($p['subject']);
    $postLink = $websiteURL.'/'.$url;

    if($p['subject']=='')
        $p['subject'] = '[No Subject]';

    if($p['post']=='')
        $p['post'] = '[No content]';

    $keywords = explode(', ', $p[tags]);
    $tagArray = array();
	
    foreach($keywords as $piece) {
		array_push($tagArray, '<li><b><a class="button special" href="./?p='.$url.'" title="'.$piece.'">'.$piece.'</a></b></li>'); 
    }

    $tags = implode(' ', $tagArray); 

	$num = 0;
}


if(mysql_num_rows($res) > 0) {
    
    $subject = $p['subject']; 
    
    $postLink = 'https://neobuxultimatestrategy.com/?p='.$url;
    
    echo '<header class="major">
		<a href="'.$postLink.'" class="postTitle" title="'.$p['subject'].'"><h2>'.$p['subject'].'</h2></a>
	<p>By <a href="./">Admin</a> on '.$p['postedOn'].'</p>

	<span class="st_twitter_vcount" displayText="Tweet"></span>
    <span class="st_email_vcount" displayText="Email"></span>
    <span class="st_facebook_vcount" displayText="Facebook"></span>
    <span class="st_sharethis_vcount" displayText="ShareThis"></span>
    <span class="st_fblike_vcount" st_title="'.$subject.'" st_url="'.$postLink.'" displayText="share"></span>
	</header>
	
    <p>&nbsp;</p>'; 


    if($p['useHTMLFile'] == 'on') {
		
		if(!empty($p['HTMLFileName'])){
			echo 'true';
			include('blog/'.$p['HTMLFileName']);
		}
		else
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
	<td align="left"> 
		<p><ul class="actions">'.$tags.'</ul></p>
	</td>
	</tr>
	</table> 
	<p>&nbsp;</p>'; 

    echo $_SESSION['msg']; 
}
else {
    echo '<h1>No post by that title exists</h1>
	<h3>You may have followed a broken link or outdated link</h3>
	<p>&nbsp;</p>';

	include('blog/index.php');	
}

?>