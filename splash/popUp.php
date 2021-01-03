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
$subscribeLandingURL = $dir.'redirect.php?url=ysense';  
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
				<iframe width="480" height="315" src="https://www.youtube.com/embed/sHTRZ82K89E?rel=0;&mute=1&loop=1&playlist=sHTRZ82K89E" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		   </td>
           <td align="center">
                <img src="<?=$imgDir?>redArrow.gif" class="redArrow">

                <form method="post" action="<?=$subscribeLandingURL?>">
                <table>
                    <tr>
                        <td align="center">
                            
                        <div id="errorPopup">Sign Up Below</div>
                        <input type="text" class="input" size="28" id="emailPopup" name="email" value="Your Best Email" onclick="if(this.value=='Your Best Email') this.value=''; " />

                        <input type="image" src="<?=$imgDir?>instantAccess.png" value="Submit" onclick="return validateEmailPopup(document.getElementById('emailPopup').value); ">
               
                        </td>
                    </tr>
                </table>
                </form>

            
            </td>
        </tr>
    </table>
</body>
</html>