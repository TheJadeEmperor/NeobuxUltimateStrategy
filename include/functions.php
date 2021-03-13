<?php
/* ##############################################################
 * 
 * downloadLink($url)   
 *  create download link, given a url
 * 
 * postMetaTags($url)
 *  return array of seo title, keywords, and description, given 
 *  the url of blog post
 *
 * sendDownloadEmail($id)
 *  sends download email upon purchase, function is called in IPN
 * 
 * showPost($id)
 *  show the post contents, given the post's id
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
 * 
 * dbInsert($opt)
 * 	inserts a new record into the db
 * 
 * dbSelect($opt)
 * 
 * dbUpdate($opt)

###############################################################*/

// connect to database, returns resource 
function database($host, $user, $pw, $dbName) {

	if(!is_int(strpos(__FILE__, 'C:\\'))) { //connect to db remotely (local server)
		$host = 'localhost';
	}
	
	$conn = new mysqli($host, $user, $pw, $dbName);
	// Check connection
	if ($conn -> connect_errno) {
	  echo __LINE__." ". $conn -> connect_error;
	  exit();
	}

	return $conn;
}

//code for popup in splash/popUp.php and popup.css
function popUpWindow($dir) {
	global $popUp;

	//echo 'popUp: '. $popUp; echo $_SESSION['popUp']; 

	if ($popUp) { //popUp = 1: enabled 
		if ($_SESSION['popUp'] < 1) {  //pop up happens once per user session
			$_SESSION['popUp'] = 1; //track session

			return '
			var windowSize = $(window).width();
			if(windowSize >= 420) { //no popUp on mobile
				var seconds = 12; 
				var milliseconds = seconds * 1000; 
				setTimeout("javascript:TINY.box.show({url:\''.$dir.'splash/popUp.php\',width:780,height:490,openjs:\'initPopupLogin\',opacity:30});", milliseconds);
			} 
			'; //use JS tiny box to show pop up
		}
	}
}

//get ad pages content from codegeas_cc db
function getAdContent ($conn) { //call this function on ad pages
	$conn->select_db('codegeas_cc'); 
	
	/////////////////////////////////
    $selA = 'SELECT * FROM ad_pages_content WHERE id = 1';
	$resA = $conn->query($selA); 
    if($ad = $resA->fetch_array()) {
        $adContent = $ad['content'];
	}
	/////////////////////////////////

    //switch back to main db
	$conn->select_db('codegeas_nus');
	
	return $adContent;
}

function getAdminUser () { //for admin login page
	global $conn;
	$getLogin = 'SELECT * FROM settings WHERE opt="adminUser" || opt="adminPass"';
	$resLogin = $conn->query($getLogin); 
	
	return $resLogin;
}

function updateRawViews($pageView) { //update raw views
	global $conn;
	$upd = 'update pageviews set rawViews=rawViews+1 where page="'.$pageView.'"';
	$res = $conn->query($upd);
	return $res;
}

function updateUniqueViews($pageView) { //update unique views
	global $conn;
	$upd = 'update pageviews set uniqueViews=uniqueViews+1, rawViews=rawViews+1 where page="'.$pageView.'"';
	$res = $conn->query($upd);     
	return $res;
}

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
    $conn = $context['conn']; 

    $meta = array(
        'title' => 'NUS Blog',
        'tags' => 'NUS blog',
        'desc' => 'NUS blog'
    );
    
    $selP = 'SELECT * FROM posts WHERE url="'.$url.'" LIMIT 1';
	$resP = $conn->query($selP);
	$p = $resP->fetch_array();
    
    if(mysql_num_rows($res) > 0) {	
    	$meta = array(
            'title' => stripslashes($p['subject']), 
            'tags' => stripslashes($p['tags']), 
            'desc' => stripslashes($p['subject']), 
    	);
    }
   
    return $meta; 	
}
 

function sendDownloadEmail($data) {
    global $context; 
	
	$id = $data['productID'];
	$type = $data['type'];
	$conn = $context['conn'];
    
    $selP = 'SELECT * FROM products WHERE id="'.$id.'"';
	$resP = $conn->query($selP);
	$p = $resP->fetch_array(); 
    
    $itemName = $p['itemName'];
    $itemNumber = $p['itemNumber'];
    $itemPrice = $p['itemPrice']; 
    $expires = $p['expires']; 
    $folder = $p['folder'];
    
    if($folder == '') {
        $downloadLink = $context['websiteURL'].'/?action=download&id='.$_POST['txn_id'];
    }
    else {
        $downloadLink = $context['websiteURL'].'/'.$folder.'/?action=download&id='.$_POST['txn_id'];
    }
        
    $selE = 'SELECT * FROM emails WHERE type="'.$type.'" AND productID="'.$id.'"';
	$resE = $conn->query($selE);
	$e = $resE->fetch_array();
 
    $var = array(
    '$itemName', 
    '$itemNumber', 
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
    $expires, 
    $downloadLink,
    $_POST['mc_gross'], 
    $_POST['first_name'], 
    $_POST['last_name'],
    $_POST['payer_email'], 
    $_POST['txn_id'],
    $_POST['payment_status'], 
    $_POST['receiver_email'] );
    
    $message = stripslashes($e['message']); 
    $subject = stripslashes($e['subject']); 
    $message = str_replace($var, $val, $message); //replace vars in message
    $subject = str_replace($var, $val, $subject); //replace vars in subject line

    $headers = "From: ".$context['adminEmail']."\n";
    $headers .= "Content-type: text/html;";     
    
    mail($_POST['payer_email'], $subject, $message, $headers);
    
	//// log for debugging
    $myFile = "sendDownloadEmail.txt";
    $fh = fopen($myFile, 'a') or die("can't open file");
    $stringData = "sendDownloadEmailAddress: ".$context['val']['sendDownloadEmailAddress']."\n"
            . "headers: .$headers"; 
    
    fwrite($fh, $stringData);
    fclose($fh);
    //// log for debugging

	if($_GET['debug'] == 1)
		echo $selP.' '.$selE.' '.$message; 

    if($context['val']['sendDownloadEmailCopy'] == 'on') //send copy of emails to self
        return mail($context['val']['sendDownloadEmailAddress'], $subject, $message, $headers); 
}


function showPost($url) {
	global $conn; 
	
	//general settings
	$websiteURL = 'http://neobuxultimatestrategy.com';
	
	//get post details
	$selP = 'select *, date_format(postedOn, "%m/%d/%Y %h:%i %p") as postedOn, p.id as id, u.id as uid 
	from posts p left join users u on p.postedBy = u.id 
	where p.url="'.$url.'" limit 1';
	
	$resP = $conn->query($selP);
	$p = $resP->fetch_array();

	
	$id = $p['id']; 
	$p['post'] = stripslashes($p['post']);
	$p['subject'] = stripslashes($p['subject']);
	$postLink = $websiteURL.'/'.$url;
	
	if($p['subject']=='')
		$p['subject'] = '[No Subject]';
	
	if($p['post']=='')
		$p['post'] = '[No content]';
		
	echo '<a href="'.$postLink.'" class="postTitle" title="'.$p['subject'].'">
	<h2>'.$p['subject'].'</h2></a>
	<p>By <a href="?action=viewProfile&id='.$p['uid'].'">'.$p['username'].'</a> on '.$p['postedOn'].'</p>
	
	<div style="float: left;"><a href="http://twitter.com/share" class="twitter-share-button" data-url="'.$postLink.'" data-count="horizontal" data-via="gematsucom">Tweet</a>
	<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div> 

	<div style="float: left; margin: 0; width: 76px; overflow: hidden;"><iframe src="http://www.facebook.com/plugins/like.php?href='.$postLink.'&amp;layout=button_count&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px; width: 150px;" allowTransparency="true"></iframe></div>

	<p>&nbsp;</p>'; 
	
	echo $p['post'].'<hr /> <p>&nbsp;</p>'; 

	return $postContent; 
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
	$new = $text;
	$new = substr($new, 0, $limit);
	
	if(strlen($text) > $limit)
		$new = $new.'...';
	return $new;
}//function

//format mysql fields
function formatFields($row) {
    foreach($row as $fld => $val) {
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
	for ($i = 0; $i < $number; $i++) {
	    $hash = $hash.(randomChar());
	}
	return $hash;
}


function stripAllSlashes($array) {
    foreach($array as $fld => $val) {
        $newArray[$fld] = stripslashes($val);
    }
    return $newArray;
}

/*
$opt = array(
 	'tableName' => $tableName,
 	'dbFields' => array(
 		'fld' => $val)
	 );
*/
function dbInsert($opt) {
	global $conn; 
	
	$fields = $values = array();
	foreach($opt['dbFields'] as $fld => $val) {
		array_push($fields, $fld);
		
		if($val == 'now()') //mysql timestamp
			array_push($values, $val); 
		else
			array_push($values, '"'.addslashes($val).'"');
	}
	
	$theFields = implode(',', $fields);
	$theValues = implode(',', $values);
	
	$ins = 'INSERT INTO '.$opt['tableName'].' ('.$theFields.') VALUES ('.$theValues.')';
	$res = $conn->query($ins);

	if($_GET['debug'] == 1) {
		echo '<pre>'.$ins.'<br />insert_id:'.$conn->insert_id.'</pre>';
	}
	
	return $res;
}

/*
 * $opt = array(
 * 	'tableName' => $tableName,
 * 	'cond' => $cond)
 * */
function dbSelect($opt) {
	global $conn; 
	
	$sel = 'SELECT * FROM '.$opt['tableName']; 
	
	if($opt['cond'])
		$sel .= ' '.$opt['cond']; 
	
	$res = $conn->query($sel);

	while($rows = $res->fetch_array()) {
		foreach($rows as $fld => $val) {	//remove slashes 
			$rows[$fld] = stripslashes($val);  
		}
		$mysql[] = $rows;		
	}

	if($_GET['debug'] == 1) {
		echo '<pre>'.$sel.'</pre>';
	}
	
	return $mysql;
}


/*
$opt = array(
	'tableName' => $tableName,
	'cond' => $cond
);
 */
function dbSelectQuery($opt) {
	global $conn; 
	
	$sel = 'SELECT * FROM '.$opt['tableName']; 
	
	if($opt['cond'])
		$sel .= ' '.$opt['cond']; 

	$res = $conn->query($sel);

	if($_GET['debug'] == 1) {
		echo '<pre>'.$sel.'</pre>';
	}

	return $res;
}

/*
$opt = array(
	'tableName' => $tableName,
	'cond' => $cond)
 */
function dbDeleteQuery ($opt) {
	global $conn; 
	$delQ = 'DELETE FROM '.$opt['tableName']; 

	if($opt['cond']) 
		$delQ .= ' '.$opt['cond'];
	else 
		$delQ .= ' LIMIT 1'; //do not delete everything

	$delR = $conn->query($delQ);

	if($_GET['debug'] == 1) {
		echo '<pre>'.$delQ.'</pre>';
	}
	return $delR;
}

/*
$opt = array(
 	'tableName' => $tableName, 
 	'dbFields' => array(
 		'fld' => $val),
 	'cond' => $cond
);
*/
function dbUpdate($opt) {
	global $context; 
	global $conn;
	
	if(!isset($opt['cond']))
		$opt[cond] = 'limit 1'; //prevent updating of all entries 
	
	$set = array(); 
	foreach($opt['dbFields'] as $fld => $val) {
		array_push($set, $fld.'="'.addslashes($val).'"'); 
	}
	
	$theSet = implode(',', $set); 
	
	$upd = 'UPDATE '.$opt['tableName'].' SET '.$theSet.' '.$opt['cond']; 
	$res = $conn->query($upd);
	
	if($_GET['debug'] == 1) {
		echo '<pre>'.$upd.'</pre>';
	}
	return $res;  
}

?>