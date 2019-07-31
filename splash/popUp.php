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
        <tr valign="middle">
            <td>
				
				<iframe width="480" height="315" src="https://www.youtube.com/embed/sHTRZ82K89E" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

		   </td>
		   <td width="15px"></td>
           <td align="center">
                <img src="<?=$imgDir?>redArrow.gif">
                <form method="post" action="httpS://www.trafficwave.net/cgi-bin/autoresp/inforeq.cgi">

                <table>
                    <tr valign="top">
                        <td align="left"> Name: <br />
                        <input type="text" class="input" size="28" id="da_name" name="da_name" value="Your Full Name"
                        onclick="if(this.value=='Your Full Name') this.value='';">
                        </td>
                    </tr>
                    <tr>
                        <td align="left">Email: <br />
                        <input type=text class="input" size="28" id="da_email" name="da_email" value="Your Email Address"
                        onclick="if(this.value=='Your Email Address') this.value='';">
                        </td>
                    </tr>
                </table>

                <input type="image" src="<?=$imgDir?>instantAccess.png" value="Submit" id="submit" name="subscribe"> 
                <input type="hidden" name="da_cust1" value="PopUpPage">
                <input type="hidden" name="da_cust2" value="<?=$_SERVER['HTTP_REFERER']?>">
                <input type="hidden" name="trwvid" value="theemperor">
                <input type="hidden" name="series" value="nusnewsletter">
                <input type="hidden" name="subscrLandingURL" value="<?=$subscrLandingURL?>">
                <input type="hidden" name="confirmLandingURL" value="<?=$confirmLandingURL?>">
                </form>

            </td>
        </tr>
    </table>
</body>
</html>