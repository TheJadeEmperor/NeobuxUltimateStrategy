<?php
$fileName = 'affcenter.php';
$fileDir = 'content/';
$action = $_GET['action'];

$numDays = 0;

switch($action) {
    case 'download-bonus':
        $fileName = 'content/bonus.php';
        break;
    case 'video1':
        $fileName = 'content/video1.php';
        break;
    case 'video2':
        $numDays = 1;
        $fileName = 'content/video2.php';
        break;
    case 'chapter1':
        $numDays = 0;
        $fileName = 'content/chapter1.php';
        break;
    case 'chapter2':
        $numDays = 0;
        $fileName = 'content/chapter2.php';
        break;
    case 'chapter3':
        $numDays = 0;
        $fileName = 'content/chapter3.php';
        break;
    case 'chapter4':
        $numDays = 1;
        $fileName = 'content/chapter4.php';
        break;
    case 'chapter5':
        $numDays = 1;	
        $fileName = 'content/chapter5.php';
        break;
    case 'chapter6-7':
        $numDays = 2;		
        $fileName = 'content/chapter6-7.php';
        break;
    case 'forums':
        $fileName = $fileDir.'forums.php';
        break; 
    case 'download-videos':
        $fileName = $fileDir.'download-videos.php';
        break;
}

//product specific content
if($action == 'forums' || $action == 'download-videos') {
    //PTC Mini-sites
    $productID = 3;

    $selS = 'SELECT *, date_format(purchased, "%m/%d/%y") AS purchased FROM sales WHERE (payerEmail="'.$_SESSION['login']['paypal'].'") and productID="'.$productID.'";'; 
    $resS = $conn->query($selS);
    
    if(mysqli_num_rows($resS) == 0) { // not a customer 
        $fileName = $fileDir.'locked.php';
    }
}

//date of purchase in unix format
$joinDate = strtotime($u['joinDate']);

$today = time(); //today in unix format

$numDaysInSeconds = $numDays * 24 * 60 * 60;


if(($today) >= ($joinDate + $numDaysInSeconds)) { //X days have passed
    include($fileName);
}
else { //X days not passed yet, show coming soon page
    include('content/comingSoon.php');		
}
?>