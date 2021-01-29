<?php
session_start();

function getTotalSales () {
    global $conn; 
    
    $selS = 'SELECT *, date_format(purchased, "%m/%d/%Y") AS purchased, 
    date_format(purchased, "%m/%Y") AS currentMonth, date_format(purchased, "%Y") AS thisYear
    FROM sales ORDER BY purchased'; 
    
    $resS = $conn->query($selS); 

    return $resS;
}


function getRevenue($whichMonth) { //revenue for selected year & mont
    global $conn; 

    $selR = 'SELECT SUM(amount) AS revenue, date_format(purchased, "%m/%Y") AS purchased FROM sales WHERE purchased LIKE "%'.$whichMonth.'%"';
    
    $resR = $conn->query($selR); 
    $rev = $resR->fetch_array();
    
    $revenueDisplay = '$'.number_format($rev['revenue'], 2);
    return $revenueDisplay;
}

function getAllProducts () {
    global $conn;
    $selP = 'SELECT * FROM products ORDER BY id'; 
    return $conn->query($selP);
}

function getSettings() {
	global $conn; 
	$selS = 'SELECT * FROM settings ORDER BY opt';
	return $conn->query($selS);
}

function showMessage ($msg) {
    return '<pre><font color="red"><strong>'.$msg.'</strong></font></pre>';
}


if($adir == '') { //admin main directory
    $dir = '../'; //root directory
    $adir = './';
}
else { //admin sub-directory
    $dir = $adir.'../'; 
}

if(!isset($_SESSION['admin']))//if not logged in, redirect back to login page
    header('Location: '.$adir); 

include($dir.'include/functions.php');
include($dir.'include/class.phpmailer.php');
include($dir.'include/class.smtp.php');
include($dir.'include/config.php');
include($dir.'include/spmSettings.php');


$helpImg = $dir.'images/admin/help.png';
$delImg = $dir.'images/admin/delete.png';
$tinyMCE = $dir.'admin/tinymce/jscripts/tiny_mce/tiny_mce.js'; 
$bootDir = $dir.'include/bootstrap/';
$srcDir = $dir.'include/';
$devSite = true; 

if($_POST['dl']) { //download files
    $url = $_POST['url']; 
    downloadLink($url); 
    exit; 
}

$prodCount = 0; //total # of products 
$prod = array(); 

$selP = 'SELECT id, itemName FROM products'; 
$resP = $conn->query($selP);

while($p = $resP->fetch_array()) {
    $prod[] = $p;
    $prodCount++; 
}

//show site stats
$totalProducts = $prodCount;

$selU = 'SELECT COUNT(*) AS totalUsers FROM users';
$resU = $conn->query($selU);
$stat = $resU->fetch_array(); 
$totalUsers = $stat['totalUsers']; 

$selS = 'SELECT COUNT(*) AS totalSales FROM sales'; 
$resS = $conn->query($selS);
$stat = $resS->fetch_array(); 
$totalSales = $stat['totalSales']; 

$selSP = 'SELECT COUNT(*) AS sitePages FROM memberpages';
$resSP = $conn->query($selSP);
$stat = $resSP->fetch_array(); 
$sitePages = $stat['sitePages'];

		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <title><?=$businessName ?> Admin Area</title>
    <link href="<?=$dir ?>include/css/admin.css" rel="stylesheet" />
    <script src="<?=$dir ?>include/js/boxover.js"></script>
    
    <!-- dataTable styles -->
    <style type="text/css" media="screen">
         @import "<?= $srcDir ?>media/css/demo_table.css";
         @import "<?= $srcDir ?>media/css/demo_table_jui.css";
         @import "<?= $srcDir ?>media/css/themes/base/jquery-ui.css";
         @import "<?= $srcDir ?>media/css/themes/smoothness/jquery-ui-1.7.2.custom.css";

         .dataTables_info { padding-top: 0; }
         .dataTables_paginate { padding-top: 0; }
         .css_right { float: right; }
         #example_wrapper .fg-toolbar { font-size: 0.8em }
         #theme_links span { float: left; padding: 2px 10px; }
     </style>
     <link href="<?= $bootDir ?>css/bootstrap-theme.css" rel="stylesheet" />
     <link href="<?= $bootDir ?>css/bootstrap.css" rel="stylesheet" />

     <!--jquery scripts-->
     <script src="<?= $srcDir ?>media/js/complete.js"></script>
     <script src="<?= $srcDir ?>media/js/jquery.min.js" type="text/javascript"></script>
     <script src="<?= $srcDir ?>media/js/jquery-ui.js" type="text/javascript"></script>
     <script src="<?= $srcDir ?>media/js/jquery.validate.js" type="text/javascript"></script>
     
     <script src="<?= $bootDir ?>js/bootstrap.min.js"></script><!--bootstrap scripts-->
     <script src="<?= $srcDir ?>media/js/jquery.dataTables.min.js" type="text/javascript"></script> <!--dataTable scripts-->
     <style>
        .dropdown-submenu {
            position: relative;
        }
        .dropdown-submenu>.dropdown-menu {
            top: 0;
            border-radius: 0 6px 6px 6px;
            left: 100%;
            margin-left: -1px;
            margin-top: -6px;
            moz-border-radius: 0 6px 6px 6px;
            webkit-border-radius: 0 6px 6px 6px;
        }
        .dropdown-submenu:hover>.dropdown-menu {
            display: block;
        }
        .dropdown-submenu>a:after {
            border-color: transparent;
            border-left-color: #cccccc;
            border-style: solid;
            border-width: 5px 0 5px 5px;
            content: " ";
            display: block;
            float: right;
            height: 0;
            margin-right: -10px;
            margin-top: 5px;
            width: 0;
        }
        .dropdown-submenu:hover>a:after {
            border-left-color: #ffffff;
        }
        .dropdown-submenu.pull-left {
            float: none;
        }
        .dropdown-submenu.pull-left>.dropdown-menu {
            border-radius: 6px 0 6px 6px;
            left: -100%;
            margin-left: 10px;
            moz-border-radius: 6px 0 6px 6px;
            webkit-border-radius: 6px 0 6px 6px;
        }
		
        .navbar .nav, .navbar .nav > li {
            float:none;
            display:inline-block;
            *display:inline; /* ie7 fix */
            *zoom:1; /* hasLayout ie7 trigger */
            vertical-align: top;
        }
        .navbar-inner {
            text-align:center;
        }       
        .dropdown-menu > li > a {
            text-align: left;
        }
    </style>
</head>
<body> 
    <center>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav" id="main-menu">
                    <li><a class="navbar-brand" href="">Sales Page Machine</a></li>
                    <li class="dropdown" id="localhost">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Main <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=$adir?>main.php">Main Options</a></li>
                            <li><a href="<?=$adir?>salesMonthly.php">Monthly Sales</a></li> 
                            <li><a href="<?=$adir?>logout.php">Logout</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Site Content <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=$adir?>pages/memberArea.php">Members Area</a></li>
                            <li><a href="<?=$adir?>pages/sitePages.php">Site Pages</a></li>
                            <li><a href="<?=$adir?>pages/pageviews.php">Pageviews</a></li>
							<li><a href="<?=$adir?>links.php">Links</a></li>
							
							<li class="divider"></li>
							
                            <li><a href="<?=$adir?>pages/postNew.php">New Post</a></li>
                            <li><a href="<?=$adir?>pages/postList.php">All Posts</a></li>
							<li><a href="<?=$adir?>pages/blogOptions.php">Blog Options</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Products <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                            <li><a href="<?=$adir?>product/productAll.php">All Products</a></li>
                            <li><a href="<?=$adir?>product/productNew.php">New Product</a></li>
                            <li><a href="<?=$adir?>product/productEmailsList.php">Product Emails</a></li>
							
							<li class="divider"></li>
							
							<?php
							foreach($prod as $p) {
															
								echo '<li class="dropdown-submenu">
								<a tabindex="-1" href="'.$adir.'product/productNew.php?id='.$p['id'].'">'.$p['itemName'].'</a>
									<ul class="dropdown-menu">
										<li>
										<a href="'.$adir.'product/productDownloads.php?id='.$p['id'].'">Purchase Downloads</a></li>
										<li><a href="'.$adir.'product/productEmailsEdit.php?id='.$p['id'].'&type=download"</a>Download Email</li><li><a href="'.$adir.'product/productEmailsEdit.php?id='.$p['id'].'&type=fraud">Fraud Email</a></li>
									</ul>
								</li>';
							}
							?>
							
                        </ul>
                    </li>                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users & Emails<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=$adir?>users/userSearch.php">Search Users</a></li>
                            <li><a href="<?=$adir?>users/custSearch.php">Search Customers</a></li>
                            <li><a href="<?=$adir?>email/emailTest.php">Test Emails</a></li>
                            <li><a href="<?=$adir?>email/emailBroadcast.php">Email Broadcasts</a></li>
                            <li><a href="<?=$adir?>email/emailSend.php">Send Mass Emails</a></li>
                        </ul>
                    </li>
                    
                    <? 
                    if($devSite) {
                    ?>
                    <li class="dropdown">    
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">SEO<b class="caret"></b></a>
                        <ul class="dropdown-menu">
							<li><a href="<?=$adir?>dev/sitemap.php" target="_blank">Generate Sitemap</a></li>
                            <li><a href="<?=$adir?>dev/sitemap.xml" target="_blank">View Sitemap</a></li>

                            <li class="divider"></li>
                            
                            <li><a href="https://www.google.com/webmasters/tools/" target="_blank">Webmaster Tools</a></li>
                            <li><a href="https://www.google.com/analytics/web/" target="_blank">Google Analytics</a></li>
                        </ul>
                    </li>
                    <? } ?>
                   
                </ul>
            </div>
        </div>
    </nav>
<table>
<tr valign="top">
    <td align="left">
        <div class="adminBox"><a href="<?=$adir?>main.php"><h2>Site Stats</h2></a>
        <div>
            <table>
            <tr>
                <td><a href="<?=$adir?>userList.php">Total Users</a>: </td>
                <td><?=$totalUsers?></td>
            </tr>
            <tr>
                <td><a href="<?=$adir?>salesMonthly.php">Total Sales</a>: </td>
                <td><?=$totalSales?></td>
            </tr>
            <tr>
                <td><a href="<?=$adir?>product/productAll.php">Total Products</a>: </td>
                <td><?=$totalProducts?></td>
            </tr>
            <tr>
                <td><a href="<?=$adir?>pages/sitePages.php">Site Pages</a>: </td>
                <td><?=$sitePages?></td>
            </tr>
            </table>

        </div>    
        </div>
    </td>
    <td align="left" width="15px"></td>
    <td align="left">