<?php
/* ##############################################################
 * 
 * affstats($userID)
 *  show affiliate stats such as clicks and sales 
 * 
 * downloadLink($url)   
 *  create download link, given a url
 * 
 * postMetaTags($url)
 *  return array of seo title, keywords, and description, given 
 *  the url of blog post
 * 
 * sendWelcomeEmail($id)
 *  sends email upon affiliate registration
 * 
 * sendDownloadEmail($id)
 *  sends download email upon purchase, function is called in IPN
 * 
 * showPost($id)
 *  show the post contents, given the post's id
 * 
 * showMenu($menu)
 *  display the admin menu
 * 
 * embedYoutubeVideo($src, $width, $height)
 *  displays embedded youtube video
 * 
 * shortenText($text, $limit)
 *  shortens a string $text, truncating it to $limit characters
 * 
 * randomChar()
 *  returns random alpha-numeric character
 * 
 * genString($number)
 *  generate a random string of $number digits

###############################################################*/

function downloadLink($url) {
	header("Content-Type: application/octet-stream");
	header("Content-Transfer-Encoding: binary");
	header("Content-Description: File Transfer");

	$fparts = explode("/", $url );
	$filename = $fparts[count($fparts)-1];
	header("Content-Disposition: attachment; filename=$filename");
	@readfile($url);

    exit;
}

function postMetaTags($url) {
    global $context; 
    $conn = $context[conn]; 

     $meta = array(
        'title' => 'NUS Blog',
        'tags' => 'NUS blog',
        'desc' => 'NUS blog'
    );
    
    
    $sel = 'select * from posts where url="'.$url.'" limit 1'; 
    $res = mysql_query($sel, $conn) or die(mysql_error()); 
    $p = mysql_fetch_assoc($res); 
    
    if(mysql_num_rows($res) > 0) {	
    	$meta = array(
            'title' => stripslashes($p['subject']), 
            'tags' => stripslashes($p['tags']), 
            'desc' => stripslashes($p['subject']), 
    	);
    }
   
    return $meta; 	
}

function sendWelcomeEmail($id, $conn) {
	global $context;
	
	$selP = 'select * from products where id="'.$id.'"';
	$resP = mysql_query($selP, $conn) or die(mysql_error());
	
	$p = mysql_fetch_assoc($resP);
	$itemName = $p[itemName];
	$itemNumber = $p[itemNumber];
	$salesPercent = $p[salesPercent];
	
	$selE = 'select * from emails where type="welcome"';
	$resE = mysql_query($selE, $conn) or die(mysql_error());
	
	$e = mysql_fetch_assoc($resE);
	
	$var = array(
	'$itemName', 
	'$itemNumber', 
	'$salesPercent', 
	'$firstName', 
	'$lastName', 
	'$nickname', 
	'$password', 
	'$paypal', 
	'$email');
	
	$val = array(
	$itemName, 
	$itemNumber, 
	$salesPercent, 
	$_POST[fname], 
	$_POST[lname], 
	$_POST[username], 
	$_POST[password], 
	$_POST[paypal], 
	$_POST[email] );
	
	$message = str_replace($var, $val, $e[message]);
	$subject = str_replace($var, $val, $e[subject]);

	$headers = "From: ".$context['adminEmail']."\n";
	$headers .= "Content-type: text/html;";		
	
	mail($adminEmail, $subject, $email, $headers);
	return mail($_POST[email], $subject, $message, $headers);
}


function sendDownloadEmail($id, $conn) {
    global $context; 
    
    $selP = 'select * from products where id="'.$id.'"';
    $resP = mysql_query($selP, $conn) or die(mysql_error()); 
    
    $p = mysql_fetch_assoc($resP);
    $itemName = $p[itemName];
    $itemNumber = $p[itemNumber];
    $itemPrice = $p[itemPrice]; 
    $salesPercent = $p[salesPercent];
    $expires = $p[expires]; 
    $folder = $p[folder];
    
    if($folder == '') {
        $downloadLink = $context[websiteURL].'/?action=download&id='.$_POST[txn_id];
    }
    else {
        $downloadLink = $context[websiteURL].'/'.$folder.'/?action=download&id='.$_POST[txn_id];
    }
        
    $selE = 'select * from emails where type="download" and productID="'.$id.'"';
    $resE = mysql_query($selE, $conn) or die(mysql_error());
    
    $e = mysql_fetch_assoc($resE); 
    
    $var = array(
    '$itemName', 
    '$itemNumber', 
    '$salesPercent',
    '$expires', 
    '$downloadLink',
    '$itemPrice', 
    '$firstName', 
    '$lastName',
    '$payerEmail',
    '$transID',
    '$paymentStatus',
    '$receiverEmail' );
    
    $val = array(
    $itemName, 
    $itemNumber, 
    $salesPercent, 
    $expires, 
    $downloadLink,
    $_POST['mc_gross'], 
    $_POST['first_name'], 
    $_POST['last_name'],
    $_POST['payer_email'], 
    $_POST['txn_id'],
    $_POST['payment_status'], 
    $_POST['receiver_email'] );
    
    $message = stripslashes($e[message]);
    $subject = stripslashes($e[subject]);
    $message = str_replace($var, $val, $message);
    $subject = str_replace($var, $val, $subject);   

    $headers = "From: ".$context[adminEmail]."\n";
    $headers .= "Content-type: text/html;";     
    
    mail($_POST['payer_email'], $subject, $message, $headers);
    
    $myFile = "sendDownloadEmail.txt";
    $fh = fopen($myFile, 'a') or die("can't open file");
    $stringData = "sendDownloadEmailAddress: ".$context['val']['sendDownloadEmailAddress']."\n"
            . "headers: .$headers";
    
    fwrite($fh, $stringData);
    fclose($fh);
    
    if($context['val']['sendDownloadEmailCopy'] == 'on')
        return mail($context['val']['sendDownloadEmailAddress'], $subject, $message, $headers); 
}


function showPost($url) {
	global $conn; 
	
	//general settings
	$websiteURL = 'http://neobuxultimatestrategy.com';
	
	//get post details
	$sel = 'select *, date_format(postedOn, "%m/%d/%Y %h:%i %p") as postedOn, p.id as id, u.id as uid 
	from posts p left join users u on p.postedBy = u.id 
	where p.url="'.$url.'" limit 1';
	$res = mysql_query($sel, $conn) or die(mysql_error());
	
	if(mysql_num_rows($res))
	{
		$p = mysql_fetch_assoc($res);
	
		$id = $p[id]; 
		$p[post] = stripslashes($p[post]);
		$p[subject] = stripslashes($p[subject]);
		$postLink = $websiteURL.'/'.$url;
		
		if($p[subject]=='')
			$p[subject] = '[No Subject]';
		
		if($p[post]=='')
			$p[post] = '[No content]';
			
		echo '<a href="'.$postLink.'" class="postTitle" title="'.$p[subject].'">
		<h2>'.$p[subject].'</h2></a>
		<p>By <a href="?action=viewProfile&id='.$p[uid].'">'.$p[username].'</a> on '.$p[postedOn].'</p>
		
		<div style="float: left;"><a href="http://twitter.com/share" class="twitter-share-button" data-url="'.$postLink.'" data-count="horizontal" data-via="gematsucom">Tweet</a>
		<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div> 
	
		<div style="float: left; margin: 0; width: 76px; overflow: hidden;"><iframe src="http://www.facebook.com/plugins/like.php?href='.$postLink.'&amp;layout=button_count&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px; width: 150px;" allowTransparency="true"></iframe></div>
	
		<p>&nbsp;</p>'; 
		
		echo $p[post].'<hr><p>&nbsp;</p>'; 
	}
	else
	{
		$postContent = 'No post by that title exists'; 
	}
	
		
	return $postContent; 
}

function showMenu($menu) {
	$extraMenu = '<div class="adminMenu" title="'.$menu[bar][title].'">
	<a href="'.$menu[bar][link].'"><h2>'.$menu[bar][title].'</h2></a><ul id="menu">';
	
	foreach($menu[item] as $name => $value)
	{
		$extraMenu .= '<li><a href="'.$value[link].'" title="'.$value[title].'" '.$value[extra].'>'.$name.'</a>';

		if(sizeof($value[sub_menu]) > 0)
		{
			$extraMenu .= '<ul>';
			foreach($value[sub_menu] as $sub => $val)
			{
				$extraMenu .= '<li><a href="'.$val[link].'" title="'.$val[title].'" '.$val[extra].'>
				:: '.$sub.' ::</a></li>';
			}
			$extraMenu .= '</ul>';
		}
		$extraMenu .= '</li>';
	}
	return $extraMenu.'</ul></div>';
}

/*
 * $options = array(
 * 	src => "source of video"
 * 	width => "width of video"
 * 	height => "height of video"
 * 	options => "video options"
 * )
 */

function embedYoutubeVideo($options) {
	return '<iframe width="'.$options['width'].'" height="'.$options['height'].'" src="'.$options['src'].'?'.$options['options'].'" frameborder="0" allowfullscreen></iframe>';
}

function shortenText($text, $limit) {
	//$limit = number of characters you want to display
	$new = $text.' ';
	$new = substr($new, 0, $limit);
	
	if(strlen($text) > $limit)
		$new = $new.'...';
	return $new;
}//function

//format mysql fields
function formatFields($row) {
    foreach($row as $fld => $val)
    {
        $val = stripslashes($val);
        $row[$fld] = trim($val); 
    }
    return $row; 
}

function randomChar() {
	$letters = array(1 => "a", "b", "c", "d", "e", "f", "g", "h" ,"i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z","A", "B", "C", "D", "E", "F", "G", "H" ,"I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z","0","1","2","3","4","5","6","7","8","9");
	$index = Key($letters);
	$element = Current($letters);
	$index = rand(1,62);
	$random_letter = $letters[$index];
	return $random_letter;
}

//create random hash
function genString($number) {
	for ($i = 0; $i < $number; $i++)
	{
	    $hash = $hash.(randomChar());
	}
	return $hash;
}

?>