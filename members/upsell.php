<?php

////
$my = fopen("testfile1.txt", "w");
fwrite($my, __LINE__.' ');
///
if(!$_SESSION['login']['id'])
    header('Location: index.php');
//
fwrite($my, __LINE__.' ');

function getProduct($productID) {
    global $conn; 
    
    $selP = 'SELECT * from PRODUCTS where id="'.$productID.'"';
   
    $resP = $conn->query($selP);
    $p = $resP->fetch_array();
    return $p; 
}

fwrite($my, __LINE__.' ');

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

//echo $val['upID]']. ' '.$val['upFile'];

 

fwrite($my, __LINE__.' ');

if($val['upID']) {

    $selUP = 'SELECT id from sales where payerEmail="'.$u['paypal'].'" and productID="'.$val['upsell']['productID'].'"';
    $resUP = $conn->query($selUP);

    fwrite($my, __LINE__.' '.$val['upFile'] );

    if(mysqli_num_rows($resUP) == 0) { //if user is not a customer         

//        include('content/'.$val['memUpsellFile']);
        include( $val['upFile'] );
        
        fwrite($my, __LINE__.' '.$val['upFile'] );
    }
    else { //if user is a customer, skip upsell 
        $_SESSION['login']['skipUpsell'] = true;
        echo $transition; 
    }

    fwrite($my, __LINE__);

}
else { //if upsell is disabled 

    fwrite($my, __LINE__);

    $_SESSION['login']['skipOTO'] = true;
    echo $transition; 
}
fwrite($my, __LINE__);

?>