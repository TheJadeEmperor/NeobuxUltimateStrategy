<?php
date_default_timezone_set('America/New_York'); 

$imgDir = 'images/splash/';

$timer = '
    <script language="JavaScript">
    TargetDate =  "'.date('m/d/Y', time()+86400).' 12:00 AM";
    BackColor = "none";
    ForeColor = "black";
    CountActive = true;
    CountStepper = -1;
    LeadingZero = true;
    DisplayFormat = "%%H%% Hours, %%M%% Minutes, %%S%% Seconds";
    FinishMessage = "Special Discount Has Ended...";
    </script>
    <script language="JavaScript" src="https://scripts.hashemian.com/js/countdown.js"></script>';

$preHeadline = '<h2 class="subheadline"><span class="strong red">Warning: </span>
    This offer will expire in '.$timer.'... </h2>';

$subscrLandingURL = $websiteURL.'templates/subscribe.php?url='.$websiteURL;
$confirmLandingURL = $websiteURL.'templates/subscribe.php?url='.$websiteURL;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Free Neobux Report | Neobux Strategy Guide | Make Money From Neobux in <?=date('Y', time());?> </title>
<meta name="description" content="Make $20 to $30 a day with our free neobux ebook - get the neobux ultimate strategy today!" />
<link href="<?=$dir?>include/css/splash.css" rel="stylesheet" type="text/css" media="screen" />
 
<script type="text/javascript" src="include/js/swfobject.js"></script>
<script type="text/javascript" src="include/js/jquery.js"></script>
<script>

var NoExitPage = false; 

function ExitPage() { 
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


function validateEmail(email) { /* validation for email field */
    console.log('validateEmail ' + email);
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{3,4})+$/.test(email)) {
        return true;
    } else {
        document.getElementById('error').innerHTML = 'You have entered an invalid email address!';
        
        return false;
    }
}
</script>
</head>
<body onbeforeunload="return ExitPage();">
<div id="wrapper">
<div id="contentWrap">
<div id="contentTop"></div>
<div id="content">

<?=$preHeadline?>

<div class="line"></div>
<br />

<img src="images/splash/freeReportHeadline.jpg" />

<div class="line"></div><br />

 

<div id="form">
    <h3 class="red">Does Neobux still work in <?=date('Y', time());?>?</h3>
    <h4 id="error">Find out with this free Neobux report!</h4>

    <form method="POST" onsubmit="NoExitPage=true;" id="TRWVLCPForm" name="TRWVLCPForm" action="https://www.trafficwave.net/cgi-bin/autoresp/inforeq.cgi">
 
    <div class="infoWrap">
        <input type="text" id="da_email" name="da_email" placeholder="name@email.com"  class="textField">
    </div>
    
    <div class="buttonWrap">
        <button type="submit" value="Submit" id="submit" name="subscribe" class="link" onclick="return validateEmail(document.getElementById('email').value);"></button>
    </div>

    <input type="hidden" id="da_name" name="da_name" value="PTC User">
    <input type="hidden" name="trwvid" value="neobux">
    <input type="hidden" name="series" value="nusnewsletter">
    <input type="hidden" name="subscrLandingURL" value="<?=$subscrLandingURL?>">
    <input type="hidden" name="confirmLandingURL" value="<?=$confirmLandingURL?>">
    <input type="hidden" name="langPref" value="en"><input type="hidden" name="lcpID" value=""><input type="hidden" name="lcpDE" value="0">
    
    </form>
</div><!-- form -->


<p class="note"><img src="images/splash/lock.png" />
We hate spam and will never sell your email address to others. All opt-ins are completely optional.</p>

</div><!-- content -->
<div id="contentBtm"></div>
</div><!-- Content Wrap -->
</div><!-- wrapper -->

<div id="wrapper">
<div id="contentWrap">
<div id="contentTop"></div>
<div id="content">

	<p>&nbsp;</p>
	<center>
		<iframe width="480" height="315" src="https://www.youtube.com/embed/L_YO4c3AzFw?rel=0;&mute=1&loop=1&playlist=sHTRZ82K89E" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>				
	</center>
	<p>&nbsp;</p>

<h1>Don't Close the Window!</h1>
<h3 class="red">See what some people are saying <br />about the PTC Newsletters</h3>

<table>
    <tr valign="top">
        <td width="160px"></td>
        <td align="left">

            <p><a href="#form"><img src="images/testimony/facebook1.jpg" alt="PTC Newsletter" title="PTC Newsletter" /></a></p>
                
            <p><a href="#form"><img src="images/testimony/facebook2.jpg" alt="PTC Newsletter" title="PTC Newsletter" /></a></p>

            <p><a href="#form"><img src="images/testimony/facebook3.jpg" alt="PTC Newsletter" title="PTC Newsletter" /></a></p>
        </td>
    </tr>
</table>

<h4>Your fellow Neobux users have already stated they got a lot of value out of it. <br />
    Scroll up and sign up to the newsletter and get your free ebook now!</h4>
	
</div>
<div id="contentBtm"></div>
</div>
</div>

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

</body>
</html>