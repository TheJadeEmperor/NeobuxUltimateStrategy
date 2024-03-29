<?php
$url = $_GET['p']; 
$websiteURL = $val['websiteURL']; 

//get post details
$selP = 'SELECT *, date_format(postedOn, "%m/%d/%Y %h:%i %p") AS postedOn, p.id AS id
FROM posts p WHERE p.url="'.$url.'" LIMIT 1';
$resP = $conn->query($selP);
 
if(mysqli_num_rows($resP) > 0) {
    while($p = $resP->fetch_array()) {

        $postID = $p['id']; 
        $p['post'] = stripslashes($p['post']);
        $p['subject'] = stripslashes($p['subject']);
        $postLink = $websiteURL.'/'.$url;

        if($p['subject']=='')
            $p['subject'] = '[No Subject]';

        if($p['post']=='')
            $p['post'] = '[No content]';

        $keywords = explode(', ', $p['tags']);
        $tagArray = array();
        
        foreach($keywords as $piece) {
            array_push($tagArray, '<li><b><a class="button special" href="./?p='.$url.'" title="'.$piece.'">'.$piece.'</a></b></li>'); 
        }

        $tags = implode(' ', $tagArray); 

        $subject = $p['subject']; 
        
        $postLink = $websiteURL.'?p='.$url;
        
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
            
            //use file name in settings
            if(!empty($p['HTMLFileName'])) {
                include('blog/'.$p['HTMLFileName']);
            }
            else { //use URL as file name
                include('blog/'.$url.'.html');
            }
        }
        else {
            echo $p['post']; 
        }
    
        echo '
        <p>Benjamin Louie <br />
        Neobux Ultimate Strategy<br />
        <a href="'.$websiteURL.'">'.$websiteURL.'</a></p>';
        
        echo '
        <p>&nbsp;</p>
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
}
else {
    echo '<h1>No post by that title exists</h1>
	<h3>You may have followed a broken link or outdated link</h3>
	<p>&nbsp;</p>';

	include('blog/index.php');	
}

?>