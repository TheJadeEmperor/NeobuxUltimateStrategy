<?php
$path = $_SERVER['REQUEST_URI']; 
$path = str_replace('/', '', $path);

if(is_int($pos) || $path == '') {
    $dir = '';
}
else {
    $dir = '../';
} 

$imgDir = $dir.'images/splash/';
$websiteURL = 'https://ultimateneobuxstrategy.com/';
$subscrLandingURL = $websiteURL.'templates/subscribe.php?url='.$websiteURL;
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body id="popup">
    <center>
        <h2 class="subheadline"><span class="strong red">Attention:</span> Make $20 to $30 a day from Neobux?</h2>
        <h3>Sign up below to get your FREE Neobux Report!</h3>
    </center>

    <table>
        <tr valign="middle">
            <td>
                <iframe width="480" height="315" src="https://www.youtube.com/embed/sHTRZ82K89E?si=Vs_NVgrPOrXIUgaV" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
		   </td>
           <td align="center">
                <img src="<?=$imgDir?>redArrow.gif" class="redArrow">

                <form method="POST" onsubmit="NoExitPage=true;" id="TRWVLCPForm" name="TRWVLCPForm" action="https://www.trafficwave.net/cgi-bin/autoresp/inforeq.cgi">
                <table>
                    <tr>
                        <td align="center">
                            
                        <div id="errorPopup">Sign Up Below</div>
                        <input type="text" class="input" size="28" id="da_email" name="da_email" />

                        <input type="image" src="<?=$imgDir?>instantAccess.png" value="Submit">
               
                        </td>
                    </tr>
                </table>

                <input type="hidden" id="da_name" name="da_name" value="PTC User">
                <input type="hidden" name="trwvid" value="neobux">
                <input type="hidden" name="series" value="nusnewsletter">
                <input type="hidden" name="subscrLandingURL" value="<?=$subscrLandingURL ?>">
                <input type="hidden" name="confirmLandingURL" value="<?=$subscrLandingURL ?>">
                <input type="hidden" name="langPref" value="en"><input type="hidden" name="lcpID" value=""><input type="hidden" name="lcpDE" value="0">
                
                </form>
            </td>
        </tr>
    </table>
</body>
</html>