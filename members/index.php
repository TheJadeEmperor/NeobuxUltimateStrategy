<?php
$dir = '../';
include($dir.'include/mysql.php'); 
include($dir.'include/config.php');
include($dir.'include/functions.php');
include($dir.'include/spmSettings.php');
session_start();


if(is_int(strpos(__FILE__, 'C:\\'))) {//localhost
    error_reporting(E_ALL ^ E_NOTICE);
}
else { //live website
    error_reporting(0);
}


if($_POST['dl']) {
    downloadLink($_POST['url']);
}


$templateHeader = $val['memHeader'];
$templateFooter = $val['memFooter'];
$membersContent = $val['memAreaContent'];


if($_POST['login']) {
    //verify username/password
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if(empty($username)) {
        $_SESSION['error'] = 'Please enter a valid username!';
    }

    if(empty($password)) {
        $_SESSION['error'] = 'Please enter a valid password!';
    }

    $selU = 'SELECT * FROM users where USERNAME="'.$username.'" || email="'.$username.'"';
    $resU = mysql_query($selU, $conn) or print(mysql_error());
    $u = mysql_fetch_assoc($resU);

    if(mysql_num_rows($resU) == 0) { //no user found 
        $_SESSION['error'] = 'The username '.$username.' does not exist!';
    }
    else { //user is found 
        if($u['password'] != $password) {
            $_SESSION['error'] = 'The password is invalid!';
        }
        else {
            if(empty($u['email']))
                $u[email] = 'N / A';
                
            if(empty($u['paypal']))
                $u[paypal] = 'N / A';
                    
            $_SESSION['login'] = $u;
            
            if($u['status'] == 'B') { //check if user is banned
                $_SESSION['error'] = 'Unable to login - You have been banned from our system <br />
                If you feel this is in error, please contact our support desk';    
            }
            else { //login successful            
            	unset($_SESSION['error']); //remove the error message
               	header('Location: ./?action=affcenter');                
            }
        }
    }
}

$msg = $_SESSION['error'];

//user info 
$u = $_SESSION['login'];

//skip the upsell this session
if($_POST['skipUpsell']) {
    $_SESSION['login']['skipUpsell'] = true;
}

if(isset($u['id'])) //logged in
{	
    switch($_GET['action']) {
        //==========================
        case 'download-bonus':
        case 'video1':
        case 'video2':
        case 'chapter1':
        case 'chapter2':
        case 'chapter3':
        case 'chapter4':
        case 'chapter5':
        case 'chapter6-7':
        case 'forums':
        case 'download-videos':
            $fileName = 'timedContent.php';
            $affmenu = true;
            break;
        //==========================
        default:
        case 'affcenter': //affiliate center 
            if($_SESSION['login']['skipUpsell']) {
                $fileName = 'affcenter.php';
                $affmenu = true;
            }
            else {
                $fileName = 'upsell.php';
                $templateHeader = $templateFooter = ''; //upsell has its own header and footer
            } 
            break;
        case 'details': //update profile details 
            $fileName = 'details.php';
            $affmenu = true;
            break;
        case 'tools':   //affiliate tools 
            $fileName = 'afftools.php';
            $affmenu = true;
            break;
        case 'sale':    //transaction details
            $fileName = 'salesDetail.php';
            $affmenu = true; 
            break;
        case 'logout':
            $fileName = 'logout.html';
            $affmenu = false;
            break;	 
    }
}
else { //not logged in
    
    if($_GET['action'] == '') {
        $fileName = 'login.html';
    }
    else if ($_GET['action'] == 'forgot') {
        $fileName = 'forgot.php';
    }
    else {
        $fileName = 'content/repairs.php'; 
    }
}

if(file_exists($templateHeader))
include($templateHeader);

include($fileName);

if(file_exists($templateFooter))
include($templateFooter);
?>