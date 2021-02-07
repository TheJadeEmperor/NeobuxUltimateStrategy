<?php 
date_default_timezone_set('America/New_York'); 
$imgDir = 'images/splash/';
$landingURL = $dir.'templates/redirect.php?url=nus';

if($_GET['e']) { //email address passed in url
    $emailField = '<input type=text id="da_email" name="da_email" value="'.$_GET['e'].'" class="textField">';
}
else {
    $emailField = '<input type=text id="da_email" name="da_email" value="name@email.com" onclick="if(this.value==\'name@email.com\') this.value=\'\';" class="textField">';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Free Neobux Report | Free Clixsense Report | Clixsense Referrals</title>
<meta name="description" content="Make $20 to $30 a day with our free neobux ebook - get the neobux ultimate strategy today!" />
<link href="<?=$dir?>include/css/splash.css" rel="stylesheet" type="text/css" media="screen" />
<style>@charset "utf-8";
body {
    font:normal 16px Arial, Helvetica, sans-serif;
    color: #555; 
}

h1,h2,h3,h4 {
    color: #151515;
    text-align:center; 
}

h1 {
    letter-spacing: 0em; font-size:36px; font-weight:bold; line-height:36px; 
    font: bold 40px/42px Tahoma;
    margin:0 0 25px;
    text-align:center;
}

h2 {
    letter-spacing:-.04em; 
    font-size:30px; font-weight:bold; line-height:30px;
    font:bold 1.4em Tahoma; 
    font-weight: bold; 
    line-height:24px; 
    color: #767676; 
}

h3 { 
    letter-spacing:-.03em; 
    font-size:24px; 
    font-weight:bold; 
    line-height:24px; 
}

h4 { 
    letter-spacing:-.03em; 
    font-size:18px; 
    font-weight:bold; 
    line-height:18px; 
    margin-bottom:0px;
}

p, li, ol {
    color:#767676;
    font-family: Georgia; 
    font-size: 18px; 
}
    
.center { text-align:center; margin:0 auto; }
.strong { font-weight:bold; }
.red { color:#c13100; }
.left { float:left; }
.right { float:right; }
a { color:inherit; margin:0; -moz-user-select:text; }
a:hover { text-decoration:none; }
.line { background:url(<?=$imgDir?>line.gif) no-repeat; height:1px; margin:0 auto; width:780px; }

#wrapper {
    margin:0 auto;
    width:892px;
}

#contentWrap {
    margin:5px 0 0;
    width:892px;
}
#contentTop {
    background:url(<?=$imgDir?>contentTop.png) no-repeat;
    height:36px;
    width:892px
}
#content {
    background:url(<?=$imgDir?>contentBG.png) repeat-y; 
    padding: 30px 50px;
}
#contentBtm {
    background:url(<?=$imgDir?>contentBtm.png) no-repeat;
    height:36px;
}

#content .subheadline {
    background:url(<?=$imgDir?>highlight.png) repeat-y center top;
    font:italic 20px Arial, Helvetica, sans-serif;
    margin:0 0 20px;
    text-align:center;
    color: black;
}
#form {
    background:url(<?=$imgDir?>form.jpg) no-repeat;
    height:225px;
    margin:0 auto 13px;
    padding:20px 55px 0;
    width:414px;
}

#content #form h3 {
    font:normal bold 24px Arial, Helvetica, sans-serif;
    margin:0 0 5px;
} 
.infoWrap {
    height:25px;
    margin:7px auto;
    width:308px;
}
.infoWrap .textField {
    background-color:#fff;
    border:solid 1px transparent;
    color:#c13100;
    font:normal 20px Arial, Helvetica, sans-serif;
    height: 20px;
    margin: 10px 0px; 
    padding: 6px 0;
    text-align:center;
    width:308px;
}
.buttonWrap {
    clear:both;
    height:68px;
    margin:27px auto 0;
    width:327px;
}
.buttonWrap button {
    height:68px;
    overflow:visible;
    width:327px;
}
button.link, button.link {
    background:url(<?=$imgDir?>btnSubmit.png) no-repeat left top;
    border:none;
    cursor:pointer;
    display:block;
    margin:0;
    padding:0;
    text-indent:-9999px;
    -moz-user-select:text;
}
button.link:hover {
    background:url(<?=$imgDir?>btnSubmit.png) no-repeat left bottom;
}

.input {
    border: 1px solid #000000;
    background: #FFFFFF;
    margin-bottom: 5px;
    height: 20px;
}

.input:hover {
    border: 1px solid #000;
    background: #FFFF99;
}
.note {
    color:#767676;
    font:normal 11px Arial, Helvetica, sans-serif;
    margin:15px auto 0;
    text-align:center;
}
#eXTReMe { 
    display: none; } 
</style>
<script type="text/javascript" src="include/js/swfobject.js"></script>
<script type="text/javascript" src="include/js/jquery.js"></script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-6094683-5']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<script>
    <!-- 
    var NoExitPage = false; 

    function ExitPage() 
    { 
        if(NoExitPage == false) { 
        NoExitPage=true; 
        location.href='<?=$landingURL?>'; 

        return"***********************************************\n\n"+ 
        " WAIT! Sign up to get your FREE Neobux Report! \n\n"+ 
        " Learn how to get 40+ Direct Referrals Overnight! \n\n"+ 
        " Click the [Cancel] button to Download Your FREE GIFT!\n\n"+ 
        "***********************************************"; 
        }
    } 
    // --> 
    
    //disable right click
    document.ondragstart = test;
    document.onselectstart = test;
    document.oncontextmenu = test;
    function test() {
        return false;
    }
</script>
</head>
<body onbeforeunload="return ExitPage();">
        
<div id="wrapper">
<div id="contentWrap">
<div id="contentTop"></div>
<div id="content">
    <center>
    <h1>These Are My Clixsense Referrals</h1>
    
    <a href="#form"><img src="images/refs/clixRefs.jpg" title="Look at all these Clixsense Referrals"/></a>
    <br />
    <img src="images/splash/redArrow.gif" />
    <h1>70 Referrals in 2 Days??</h1>
    
    <a href="#form"><img src="images/refs/clixsenseB.jpg" title="70 Referrals in 2 Days??" /></a>
    <p>Want to know the secret? </p>
    </center>
    
</div>
<div id="contentBtm"></div>
</div>
</div>
    
<center><img src="images/splash/redArrow.gif" /></center>
    
<div id="wrapper">
<div id="contentWrap">
<div id="contentTop"></div>
<div id="content">

<h2 class="subheadline"><span class="strong red">Warning: </span>This offer will expire on <?=date('F dS', time())?> at midnight...</h2>
<div class="line"></div>
<br />

<h1><span class="red">ATTENTION:</span> Get 70 Referrals <br />
        For Your PTC Website in 2 <br /> 
        Days Using Our System! <br />
        Free PTC Report Reveals All!</h1>

<div class="line"></div><br />

<div id="form">
    <h3>Get Your Free PTC Report </h3>
    <h4 class="red">Your referrals are waiting for you! </h4>
    
    <form method="post" onsubmit="NoExitPage=true;" action="https://www.trafficwave.net/cgi-bin/autoresp/inforeq.cgi">

    <div class="infoWrap">
        <?=$emailField?>
    </div>
    
    <div class="buttonWrap">
        <button type="submit" value="Submit" id="submit" name="subscribe" class="link button" />
    </div>
    
    <input type=hidden class="input" id="da_name" name="da_name" value="PTC User">
    <input type=hidden name="da_cust1" value="<?=$page?>" />
    <input type=hidden name="da_cust2" value="<?=$_SERVER['HTTP_REFERER']?>" />
    <input type=hidden name="da_cust3" value="<?=$_GET['campaign']?>" />
    <input type=hidden name="trwvid" value="theemperor">
    <input type=hidden name="series" value="nusnewsletter">
    <input type=hidden name="subscrLandingURL" value="<?=$landingURL?>">
    <input type=hidden name="confirmLandingURL" value="<?=$landingURL?>">
    </form>
</div><!-- form -->

<p class="note"><img src="images/splash/lock.png" />
We hate spam and will never sell your email address to others. All opt-ins are completely optional.</p>

</div><!-- content -->
<div id="contentBtm"></div>
</div><!-- Content Wrap -->
</div><!-- wrapper -->

<div id="eXTReMe"><a href="http://extremetracking.com/open?login=richptc">
<img src="https://t1.extreme-dm.com/i.gif" style="border: 0;"
height="38" width="41" id="EXim" alt="eXTReMe Tracker" /></a>
<script type="text/javascript"><!--
EXref="";top.document.referrer?EXref=top.document.referrer:EXref=document.referrer;//-->
</script><script type="text/javascript"><!--
var EXlogin='richptc' // Login
var EXvsrv='s10' // VServer
EXs=screen;EXw=EXs.width;navigator.appName!="Netscape"?
EXb=EXs.colorDepth:EXb=EXs.pixelDepth;EXsrc="src";
navigator.javaEnabled()==1?EXjv="y":EXjv="n";
EXd=document;EXw?"":EXw="na";EXb?"":EXb="na";
EXref?EXref=EXref:EXref=EXd.referrer;
EXd.write("<img "+EXsrc+"=https://e1.extreme-dm.com",
"/"+EXvsrv+".g?login="+EXlogin+"&amp;",
"jv="+EXjv+"&amp;j=y&amp;srw="+EXw+"&amp;srb="+EXb+"&amp;",
"l="+escape(EXref)+" height=1 width=1>");//-->
</script><noscript><div id="neXTReMe"><img height="1" width="1" alt=""
src="http://e1.extreme-dm.com/s10.g?login=richptc&amp;j=n&amp;jv=n" />
</div></noscript></div>

</body></html>