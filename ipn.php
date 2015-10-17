<?php
include('include/functions.php');
include('include/mysql.php');
include('include/config.php');
include('include/spmSettings.php'); 

$conn = database($dbHost, $dbUser, $dbPW, $dbName);
$headers = "From: ".$adminEmail."\n";
$headers .= "Content-type: text/html;";

//reading raw POST data from input stream. reading pot data from $_POST may cause serialization issues since POST data may contain arrays
$raw_post_data = file_get_contents('php://input'); 
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();

foreach ($raw_post_array as $keyval) {
    $keyval = explode ('=', $keyval);
    if (count($keyval) == 2)
        $myPost[$keyval[0]] = urldecode($keyval[1]);
}

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
     $get_magic_quotes_exits = true;
} 
foreach ($myPost as $key => $value) {        
     if($get_magic_quotes_exits == true && get_magic_quotes_gpc() == 1) { 
          $value = urlencode(stripslashes($value)); 
     }
     else {
          $value = urlencode($value);
     }
     $req .= "&$key=$value";
}
 
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, 'https://www.paypal.com/cgi-bin/webscr');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www.paypal.com'));
// In wamp like environment where the root authority certificate doesn't comes in the bundle, you need
// to download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path 
// of the certificate as shown below.
// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
$res = curl_exec($ch);
curl_close($ch);
 
// assign posted variables to local variables
$itemName = $_POST['item_name'];
$itemNumber = $_POST['item_number'];
$paymentStatus = $_POST['payment_status'];
$paymentCurrency = $_POST['mc_currency']; 
$transID = $_POST['txn_id'];
$receiverEmail = $_POST['receiver_email'];
$paymentAmount = $_POST['mc_gross'];
$payerEmail = $_POST['payer_email'];
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$custom = $_POST['custom']; 

$myFile = "log.txt";
$fh = fopen($myFile, 'a') or print("Can't open file $myFile");

if (strcmp ($res, "VERIFIED") == 0) {
    // check the payment_status is Completed
    // check that txn_id has not been previously processed
    // check that receiver_email is your Primary PayPal email
    // check that payment_amount/payment_currency are correct
    // process payment 
    
    $selP = 'SELECT * from products WHERE itemName="'.$itemName.'"';
    $resP = mysql_query($selP, $conn) or die(mysql_error());
    
    $p = mysql_fetch_assoc($resP); 
    $productID = $p['id'];
    $folder = $p['folder']; 
    $itemPrice = $p['itemPrice'];
    
    if($folder == '/')
        $folder = '';
    
    $downloadLink = $folder.'/?action=download&id='.$transID;
   
    $stringData = "downloadLink: $websiteURL"."$downloadLink\n"
            . "paymentStatus: $paymentStatus\n"
            . "payerEmail: $payerEmail\n";
    fwrite($fh, $stringData);
    
    
    switch($paymentStatus) {
        case 'Expired':
        case 'Failed':
        case 'Refunded':
        case 'Reversed':
        case 'Voided':
            $subject = $itemName.' Order Cancelled';
    
            $message = '<p>You have cancelled your order to '.$itemName.' </p>
    
            <p>The following are details of the order:
            <br><br>
            <p> Payer ID: '.$_POST[payer_id].'<br> 
            Txn ID: '.$transID.'<br>
            Paypal Email: '.$payerEmail.'<br>
            Item Name: '.$itemName.'<br>
            Item #: '.$itemNumber.'<br>
            Payment Status: '.$paymentStatus.'<br>
            Payment Amount: '.$paymentAmount.'<br></p>';
    
            mail($adminEmail, $subject, $message, $headers);
            mail($payerEmail, $subject, $message, $headers); 

            //update account status: C = Cancelled
            if($payerEmail) {
                $updA = 'UPDATE users SET status="C" where paypal="'.$payerEmail.'" OR email="'.$payerEmail.'"';
                $resA = mysql_query($updA) or die(mysql_error); 
            }
			
            break; 
            
        case 'Completed':
        case 'Pending':
        default: {  //confirmation email for customers
            
            $stringData = "itemNumber: $itemNumber\n";
            fwrite($fh, $stringData);
            
            //check if price matches and if amount is fake
            if(($itemPrice != $paymentAmount) && ($paymentAmount == '0.01')) {
                //redirect to fraud page 
                $downloadLink = $websiteURL.'fraud.html';
            }
            
            if($itemNumber) {
                //sales tracking
                $opt = array(
                    'tableName' => 'sales',
                    'dbFields' => array(
                        'productID' => $productID,
                        'transID' => $transID,
                        'itemName' => $itemName,
                        'itemNumber' => $itemNumber,
                        'amount' => $paymentAmount, 
                        'purchased' => 'now()',
                        'expires' => 'now()',
                        'firstName' => $firstName, 
                        'lastName' => $lastName, 
                        'payerEmail' => $payerEmail,
                        'paidTo' => $receiverEmail,
                        'affiliate' => $custom
                    )
                );
                
                //check for existing sale
                $sel = 'SELECT transID FROM sales WHERE transID="'.$transID.'"';
                $res = mysql_query($sel, $conn) or die(mysql_error()); 
                
                if(mysql_num_rows($res) == 0) {
                    
                    //add sales record into database
                    dbInsert($opt); 
                    
                    //send download email to customer 
                    sendDownloadEmail($p['id'], $conn);
                }
            }   
    
            break;
        }
    }
}
else { //bad transaction   
    //notify admins of problem
    $headers = "From: ".$adminEmail."\n";
    $headers .= "Content-type: text/html;";
    $subject = 'Problem with Order: '.$businessName;

    $vars = array( 'txn_type', 'first_name', 'last_name', 'mc_currency',
    'residence_country', 'payer_email', 'payer_id', 'reattempt', 
    'address_name', 'address_city', 'receiver_email',
    'business', 'payment_status', 'amount3', 'mc_amount3');

    $message = '<p>The following information was sent from paypal: <br>
    Date: '.date('m/d/Y', time()).'<br>
    Referrer: '.$_SERVER['HTTP_REFERER'].'<br>';

    foreach($vars as $var) {
        $message .= $var.': '.$_POST[$var].'<br>';
    }

    $message .= '<p>This is an automatically generated message. Please do not respond to this message.</p>';
    mail($adminEmail, $subject, $message, $headers);
    
    $stringData = "Problem with order\n";
    fwrite($fh, $stringData);
    
    $downloadLink = './?action=thankyou';
}

$stringData = "timestamp: ".date('m/d/Y h:i a', time())."\n\n";
fwrite($fh, $stringData);
fclose($fh);
?>
<meta http-equiv="refresh" content="3;url=<?=$downloadLink?>">
<center>
<img src='https://www.paypal.com/en_US/i/bnr/horizontal_solution_PPeCheck.gif' border="0"><br />
<img border="0" src="images/transition.gif" width="186" height="42"><br /><br />

<table width=420px cellpadding=5 style="border: 1px solid black; font-size: 12px;">
<tr>
    <td align="center">
    <h1>Processing Your Transaction...</h1>
    
    <h2>Redirecting you to download page...</h2>
    </td>
</tr>
</table>
</center>