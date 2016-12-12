<?php
function popUpWindow($dir) {
    return '
    var seconds = 15; 
    var milliseconds = seconds * 1000; 
setTimeout("javascript:TINY.box.show({url:\''.$dir.'splash/popUp.php\',width:780,height:480,openjs:\'initPopupLogin\',opacity:30});", milliseconds);'; 
}

//blog options
$popUp = 1;
$imgDir = 'images/blog/';   
$useHTMLFile = true; 
$referralLink = 'http://www.clixsense.com/?3373459&blog'; 
$redirLink = 'http://neobuxultimatestrategy.com/redirect.php?action='; 
$subscrLandingURL = $redirLink.'clixsense';
$confirmLandingURL = $redirLink.'clixsense'; 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?=$meta['title']?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="<?=$meta['tags']?>">
    <meta name="description" content="<?=$meta['desc']?>">
    <link rel="stylesheet" href="include/css/blog.css" type="text/css" />
    <link rel="stylesheet" href="include/css/popup.css" type="text/css" />
    <script type="text/javascript" src="include/js/jquery.js"></script>
    <script type="text/javascript" src="include/js/popup.js"></script>
    <script type="text/javascript">
    function linkTo(url) {
        window.open(url);
    }
    <?
    if($popUp) {
        if($_SESSION['popUp'] < 1)
            echo popUpWindow($dir); 
        $_SESSION['popUp'] = 1;
    }
    ?>
    </script>
    <script type="text/javascript">var switchTo5x=true;</script>
    <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
    <script type="text/javascript">stLight.options({publisher:'67a0d44d-0b79-44c1-bb19-7f31f475d6fe'});</script>
</head>
<body>

    <div class="sidebar"><br />
    <center>
        <span class="st_twitter_vcount" displayText="Tweet"></span>
        <span class="st_email_vcount" displayText="Email"></span>
        <span class="st_facebook_vcount" displayText="Facebook"></span>
        <span class="st_fblike_vcount" st_title="<?=$subject?>" st_url="<?=$postLink?>" displayText="share"></span>
    </center>
    </div>

    <div id="wrapper">
        <img src="images/sales/nusLogo3.png" />
        <div id="header">	
            <div id="nav">
            <ul class="buttons">
                <li id="button5"><a href="./?action=posts" title="NUS Posts">Posts</a></li>
                <li id="button1"><a href="./?p=neobux-referral-guide" title="Neobux Guide">Guide</a></li>
                <li id="button2"><a href="./?p=neobux-tips-make-money-neobux" title="Neobux Tips">Basic Tips</a></li>
                <li id="button4"><a href="./?p=neobux-direct-referrals" title="Neobux Direct Referrals">Referrals</a></li>
                <li id="button1"><a href="./?p=recycling-strategy" title="Neobux Recycling Strategy">Recycling</a></li>
                <li id="button3"><a href="./?p=best-paying-ptc-sites" title="PTC Sites">PTC Sites</a></li>	
            </ul>
            </div><!-- menu -->
        </div><!-- header -->
	
    <div id="container">
    <center>
    
        <div id="bannerBig">
            <a href="<?=$referralLink?>" title="Clixsense Scam"><img src="http://csstatic.com/banners/clixsense_gpt728x90a.png" alt="Clixsense Scam" width="728px" /></a>
        </div>

        <div id="bannerSmall">
            <a href="<?=$referralLink?>" title="Clixsense Scam"><img src="http://csstatic.com/banners/clixsense_gpt468x60a.png" alt="Clixsense Scam" /></a>
        </div>

        <br /><br />

        <table width="960px" border="0">
        <tr valign="top">
            <td align="left" width="680px">
                <div id="mainContent">