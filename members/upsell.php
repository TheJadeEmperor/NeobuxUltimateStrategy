<?php

if(!$_SESSION['login']['id'])
    header('Location: index.php');

$skipButton = '
<center>
    <form method="POST">
        <input type="submit" name="skipUpsell" value="No Thanks, Take Me to the Members Area" class="btn success" />
    </form>
</center>'; 

$transition = '<meta http-equiv="refresh" content="1;url=./?action=affcenter">
<center>
    <h1>Logging you in</h1>
    <img src="../images/waiting.gif" /><p>&nbsp;</p><p>&nbsp;</p>
</center>';
 

$val['upID'] = 3;
$val['upFile'] = 'content/upsellPTCMiniSite.html';



if($val['upID']) {

    $selUP = 'SELECT id from sales where payerEmail="'.$u['paypal'].'" and productID="'.$val['upsell']['productID'].'"';
    $resUP = $conn->query($selUP);

    if(mysqli_num_rows($resUP) == 0) { //if user is not a customer         

        include( $val['upFile'] );
        
    }
    else { //if user is a customer, skip upsell 
        $_SESSION['login']['skipUpsell'] = true;
        echo $transition; 
    }

}
else { //if upsell is disabled 

    $_SESSION['login']['skipOTO'] = true;
    echo $transition; 
}
?>