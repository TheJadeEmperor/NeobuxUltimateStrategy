<?php
if(!$_SESSION['login']['id'])
    header('Location: index.php');

function getProduct($productID) {
    global $conn; 
    
    $selP = 'select * from products where id="'.$productID.'"';
   
    $resP = $conn->query($selP);
    $p = $resP->fetch_array();
    return $p; 
}

$skipButton = '
<center>
    <form method=post>
        <input type=submit name="skipUpsell" value="No Thanks, Take Me to the Members Area"
    class="btn success" />
    </form>
</center>'; 

$transition = '<meta http-equiv="refresh" content="1;url=./?action=affcenter">
<center>
    <h1>Logging you in</h1>
    <img src="../images/waiting.gif" /><p>&nbsp;</p><p>&nbsp;</p>
</center>';

$val['upsellA'] = array(
    'productID' => 3, //PTC Mini site
    'upsellFile' => 'upsellPTCMiniSite.html'
); 


if($val['memAreaUpsell'] == 'on') {

    $selUP = 'select id from sales where payerEmail="'.$u['paypal'].'" and productID="'.$val['memUpsellProductID'].'"';
    $resUP = $conn->query($selUP);

    if(mysqli_num_rows($resUP) == 0) { //if user is not a customer         

        include('content/'.$val['memUpsellFile']);
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