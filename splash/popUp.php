<?php 
$imgDir = 'images/splash/'; 
$redirLink = 'http://neobuxultimatestrategy.com/redirect.php?action='; 
$subscrLandingURL = $redirLink.'basics';
$confirmLandingURL = $redirLink.'basics';
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
    <center> 
        <h2 class="subheadline"><span class="strong red">Attention:</span> Make $20 to $30 a day from Neobux?</h2>
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
                    <param name="flashvars" value="autostart=false&thumb=images/sales/nus2.png&thumbscale=45&showendscreen=false&color=0x1A1A1A,0x1A1A1A" />
                        <!--[if !IE]>-->
                        <object type="application/x-shockwave-flash" data="splash/controller.swf" width="480" height="380">
                        <param name="quality" value="best" />
                        <param name="bgcolor" value="#1a1a1a" />
                        <param name="allowfullscreen" value="true" />
                        <param name="scale" value="showall" />
                        <param name="allowscriptaccess" value="always" />
                        <param name="flashvars" value="autostart=false&thumb=images/sales/nus2.png&thumbscale=200&showendscreen=false&color=0x1A1A1A,0x1A1A1A" />
                        <!--<![endif]-->

                        <div id="noUpdate">
                            <p>The Camtasia Studio video content presented here requires a more recent version of the Adobe Flash Player. If you are you using a browser with JavaScript disabled please enable it now. Otherwise, please update your version of the free Flash Player by <a href="http://www.adobe.com/go/getflashplayer">downloading here</a>.</p>
                        </div>
                        
                        </object><!--[if !IE]>-->
                    </object><!--<![endif]-->
                </div>
            </td>
            <td align="center">
                <img src="<?=$imgDir?>redArrow.gif">
                <form method="post" action="http://www.trafficwave.net/cgi-bin/autoresp/inforeq.cgi">

                <table>
                    <tr valign="top">
                        <td align=left> Name: <br />
                        <input type="text" class="input" size="28" id="da_name" name="da_name" value="Your Full Name"
                        onclick="if(this.value=='Your Full Name') this.value='';">
                        </td>
                    </tr>
                    <tr>
                        <td align=left><br /> Email: <br />
                        <input type=text class="input" size="28" id="da_email" name="da_email" value="Your Email Address"
                        onclick="if(this.value=='Your Email Address') this.value='';">
                        </td>
                    </tr>
                </table>

                <input type="image" src="<?=$imgDir?>instantAccess.png" value="Submit" id="submit" name="subscribe"> 
                <input type=hidden name="da_cust1" value="PopUpPage">
                <input type=hidden name="da_cust2" value="<?=$_SERVER['HTTP_REFERER']?>">
                <input type=hidden name="trwvid" value="theemperor">
                <input type=hidden name="series" value="nusnewsletter">
                <input type=hidden name="subscrLandingURL" value="<?=$subscrLandingURL?>">
                <input type=hidden name="confirmLandingURL" value="<?=$confirmLandingURL?>">
                </form>

                <p class="note"><img src="images/lock.png"> We hate spam and will never sell your<br /> email to others</p>
            </td>
        </tr>
    </table>
</body>
</html>