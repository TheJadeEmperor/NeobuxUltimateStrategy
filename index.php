<?php
/*
+---------------------------------------------------------------------
| v2.0
| Copyright 2012-2021 Sales Page Machine. 
| Benjamin Louie
|
| The sale, duplication or transfer of the script to any 
| person other than the original purchaser is a violation
| of the purchase agreement and is strictly prohibited.
|
| Any alteration of the script source code or accompanying 
| materials will void any responsibility of Sales Page Machine
| regarding the proper functioning of the script.
|
| By using this script you agree to the terms and conditions 
| of use of the script.  
+---------------------------------------------------------------------
*/

function curPageURL() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } 
    else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

date_default_timezone_set('America/New_York'); 
session_start(); 
/* get the path of the product from url
 * if url is www.domain.com/prod
 * the path is "prod" */
$curPageURL = curPageURL();  

/*
if(is_int(strpos(__FILE__, 'C:\\'))) { //localhost
    $path = $_SERVER['REQUEST_URI']; 
    $path = str_replace('/', '', $path);
   // echo $path;

    list($path, $crap) = explode('?', $path);    

    echo $path.' '; 
    //echo $path.' ';

}
else { //live website

    list($crap, $path) = explode('//', $curPageURL);    
    list($crap, $path) = explode('/', $path); 
    $path = str_replace('index.php', '', $path); //get the current path
    
    if(is_int(strrpos($path, '?')))
        $path = '';
}
*/

$path = $_SERVER['REQUEST_URI']; 
$path = str_replace('/', '', $path); 
// echo $path;

list($path, $crap) = explode('?', $path); //get path before the ?

//get relative path to the root
$pos = strpos($path, '?'); //?action=page or ?p=post pages

if(is_int($pos) || $path == '') {
    $dir = '';
}
else {
    $dir = '../';
} 

include($dir.'include/functions.php');
include($dir.'include/config.php');
include($dir.'include/spmSettings.php'); 

//$selP = 'SELECT * FROM products WHERE folder="'.$path.'"';
//$resP = $conn->query($selP);
$opt = array(
	'tableName' => 'products',
	'cond' => 'WHERE folder="'.$path.'"');
$resP = dbSelectQuery($opt);

if( $p = $resP->fetch_array() ) {    
    //product vars
	$productID = $p['id'];
    $itemName = $p['itemName'];
    $itemPrice = $p['itemPrice'];
    $itemNumber = $p['itemNumber'];
    $keywords = $p['keywords'];
    $description = $p['description']; 
	$productOrderLink = $p['productOrderLink']; 
 	$productOrderText = $p['productOrderText'];
	
    //download vars
    $expires = $p['expires'];
    $oto = $p['oto']; 
    $otoName = $p['otoName'];
	$otoPrice = $p['otoPrice'];
    $otoNumber = $p['otoNumber'];
    $download = $p['download']; 
    $upsellID = $p['upsellID'];

    //affiliate vars
    $affProgram = $p['affProgram'];
    $salesPercent = $p['salesPercent']; 

    //template vars 
    $templateHeader = $p['header']; 
    $templateFooter = $p['footer']; 
    $salespage = $p['salespage']; 
    $downloadPage = $p['downloadPage'];
    
    //paypal vars 
	$ipnURL = $val['websiteURL'].'/ipn.php';
    $cancelURL = $val['websiteURL'];
   
    if($oto == 'Y') { //one time offer
    
        //$selO = 'SELECT * FROM products WHERE id="'.$upsellID.'"';
        //$resO = $conn->query($selO);   

        $opt = array(
            'tableName' => 'products',
            'cond' => 'WHERE id="'.$upsellID.'"');
        $resO = dbSelectQuery($opt);
        
		$o = $resO->fetch_array($resO);

        if($p['otoName'])
            $otoName = $p['otoName'];
        else
            $otoName = $o['itemName'];
        
        if($p['otoPrice']) 
            $otoPrice = $p['otoPrice'];
        else
            $otoPrice = $o['itemPrice'];
        
        if($p['otoNumber'])
            $otoNumber = $p['otoNumber'];
        else
            $otoNumber = $o['itemNumber']; 
    }
}

if($_POST['dl']) {
    $item =  $_POST['url'];
    
    header("Content-Type: application/octet-stream");
    header("Content-Transfer-Encoding: binary");
    header("Content-Description: File Transfer");

    $fparts = explode("/", $item );
    $filename = $fparts[count($fparts)-1];
    header("Content-Disposition: attachment; filename=$filename");
    @readfile($item);

    exit;
}

$paidToEmail = $paypalEmail;
$action = $_GET['action'];

switch($action) {
    case 'order':
        if($itemPrice == 0) //free gift product
           $fileName = 'download.html';
        else
           $fileName = $dir.'templates/order.html'; 
        break;
    case 'oto':
        $fileName = $dir.'templates/otoOrder.html';
        break;
    case 'download':
        $fileName = $dir.'templates/download.php';
        break; 
    case 'fraud':
        $fileName = $dir.'templates/fraud.html';
        break; 
    case 'posts':
        $templateHeader = $val['blogHeader'];
        $templateFooter = $val['blogFooter'];  
        $fileName = 'blog/index.php';
        $meta = postMetaTags($_GET['p']);    

        break;
	default:
		$keywords = $p['keywords'];
		$description = $p['description']; 

        $fileName = $salespage; //default action: show sales page  
        $pageView = '/'.$path;
        //blog post
        if($_GET['p']) {
            $templateHeader = $val['blogHeader'];
            $templateFooter = $val['blogFooter'];   
            $fileName = 'blog/post.php';
            $meta = postMetaTags($_GET['p']);     
            $pageView = '/?p='.$_GET['p'];
        }    
    
        //custom site pages 
        $selM = 'SELECT * FROM memberpages ORDER BY url';
        $resM = $conn->query($selM); 
        while($m = $resM->fetch_array()) {
            if($action == $m['url']) {
                $templateHeader = $m['header'];
                $templateFooter = $m['footer'];
                $fileName = $m['file'];
                $pageView = '/?action='.$m['url'];
            }
        }       
}

if(0) { //debug
    echo 'dir: '.$dir.'<br>
	path: '.$path.'<br>
    productID: '.$productID.'<br>
    paidToEmail: '.$paidToEmail.'<br>
	templateHeader: '.$templateHeader.'<br>
	templateFooter: '.$templateFooter.'<br>
    fileName: '.$fileName.'<br>
    downloadPage: '.$downloadPage;
}

if(file_exists($templateHeader))
include($templateHeader);

include($fileName); 

if(file_exists($templateFooter))
include($templateFooter);   

//track pageviews
if($pageView) {
    if(isset($_COOKIE['lastView'])) { //raw views
        $res = updateRawViews($pageView);
    }
    else { //unique views
        $res = updateUniqueViews($pageView);  
    } 
    setcookie('lastView', date('m/d/Y', time()));
}

?>