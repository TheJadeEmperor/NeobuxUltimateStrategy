<?php 
$imgDir = 'images/splash/'; 
$redirLink = 'http://neobuxultimatestrategy.com/redirect.php?action='; 
$subscrLandingURL = $redirLink.'http://neobuxultimatestrategy.com/basics';
$confirmLandingURL = $redirLink.'http://neobuxultimatestrategy.com/video-course';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
.strong { font-weight:bold; }
.red { color:#c13100; }
.subheadline {
    background:url(<?=$imgDir?>highlight.png) repeat-y center top;
    font:italic 20px Arial, Helvetica, sans-serif;
    margin:0 0 20px;
    text-align:center;
    color: black;
}
</style>
</head>
<body>
<center> 
<h2 class="subheadline"><span class="strong red">Attention:</span> Make $20 to $30 a day from PTC's!</h2>
<h3>Sign up below to get your FREE Neobux Report! </h3>
</center>

<table>
<tr valign="top">
<td>
	 <div id="media">
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="480" height="380" id="csSWF">
        <param name="movie" value="nus/controller.swf" />
        <param name="quality" value="best" />
        <param name="bgcolor" value="#1a1a1a" />
        <param name="allowfullscreen" value="true" />
        <param name="scale" value="showall" />
        <param name="allowscriptaccess" value="always" />
        <param name="flashvars" value="autostart=false&thumb=images/nus.png&thumbscale=45&showendscreen=false&color=0x1A1A1A,0x1A1A1A" />
        <!--[if !IE]>-->
        <object type="application/x-shockwave-flash" data="splash/controller.swf" width="480" height="380">
            <param name="quality" value="best" />
            <param name="bgcolor" value="#1a1a1a" />
            <param name="allowfullscreen" value="true" />
            <param name="scale" value="showall" />
            <param name="allowscriptaccess" value="always" />
            <param name="flashvars" value="autostart=false&thumb=images/nus.png&thumbscale=200&showendscreen=false&color=0x1A1A1A,0x1A1A1A" />
        <!--<![endif]-->
        
            <div id="noUpdate">
                <p>The Camtasia Studio video content presented here requires a more recent version of the Adobe Flash Player. If you are you using a browser with JavaScript disabled please enable it now. Otherwise, please update your version of the free Flash Player by <a href="http://www.adobe.com/go/getflashplayer">downloading here</a>.</p>
            </div>
        <!--[if !IE]>-->
        </object>
        <!--<![endif]-->
    </object>
    </div>

</td><td align="center" style="">
	<img src="<?=$imgDir?>redArrow.gif">
	<form method="post" action="http://www.trafficwave.net/cgi-bin/autoresp/inforeq.cgi">
	
	<table>
	<tr valign="top">
		<td align=left> Name: <br>
		<input type="text" class="input" size="28" id="da_name" name="da_name" value="Your Full Name"
		onclick="if(this.value=='Your Full Name') this.value='';">
		</td>
	</tr><tr>
		<td align=left><br> Email: <br>
		<input type=text class="input" size="28" id="da_email" name="da_email" value="Your Email Address"
		onclick="if(this.value=='Your Email Address')	this.value='';">
		</td></tr>
	</table>

	<input type="image" src="<?=$imgDir?>instantAccess.png" value="Submit" id="submit" name="subscribe"> 
	<input type=hidden name="da_cust1" value="popUp">
    <input type=hidden name="da_cust2" value="<?=$_SERVER[HTTP_REFERER]?>">
    <input type=hidden name="trwvid" value="theemperor">
    <input type=hidden name="series" value="nusnewsletter">
	<input type=hidden name="subscrLandingURL" value="<?=$subscrLandingURL?>">
	<input type=hidden name="confirmLandingURL" value="<?=$confirmLandingURL?>">
	</form>
</td>
</tr>
</table>
</body></html>