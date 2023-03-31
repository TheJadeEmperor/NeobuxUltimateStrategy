<?php

////
$myfile = fopen("testfile.txt", "w");
fwrite($myfile, __LINE__);
///
if(!$_SESSION['login']['id'])
    header('Location: index.php');
//
fwrite($myfile, __LINE__);

function getProduct($productID) {
    global $conn; 
    
    $selP = 'SELECT * from PRODUCTS where id="'.$productID.'"';
   
    $resP = $conn->query($selP);
    $p = $resP->fetch_array();
    return $p; 
}

fwrite($myfile, __LINE__);

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

$val['upsellA'] = array(
    'productID' => 3, //PTC Mini site
    'upsellFile' => 'upsellPTCMiniSite.html'
); 

fwrite($myfile, __LINE__);

if($val['memAreaUpsell'] == 'on') {

    fwrite($myfile, __LINE__);

    $selUP = 'SELECT id from sales where payerEmail="'.$u['paypal'].'" and productID="'.$val['memUpsellProductID'].'"';
    $resUP = $conn->query($selUP);

    if(mysqli_num_rows($resUP) == 0) { //if user is not a customer         

        include('content/'.$val['memUpsellFile']);
    }
    else { //if user is a customer, skip upsell 
        $_SESSION['login']['skipUpsell'] = true;
        echo $transition; 
    }

    fwrite($myfile, __LINE__);

}
else { //if upsell is disabled 

    fwrite($myfile, __LINE__);

    $_SESSION['login']['skipOTO'] = true;
    echo $transition; 
}
fwrite($myfile, __LINE__);

?>