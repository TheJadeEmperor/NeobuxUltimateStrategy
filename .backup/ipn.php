<?php
include('include/functions.php');
include('include/mysql.php');
include('include/config.php');
include('include/spmSettings.php'); 

$conn = database($dbHost, $dbUser, $dbPW, $dbName);
$headers = "From: ".$adminEmail."\n";
$headers .= "Content-type: text/html;";

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) {
$value = stripslashes($value);
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .="POST /cgi-bin/webscr HTTP/1.1\r\n";
$header .="Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$header .="Host: www.paypal.com\r\n";
$header .="Connection: close\r\n";

$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

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

if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) 
{
// check that txn_id has not been previously processed
// check that payment_amount/payment_currency are correct
// process payment

$selP = 'select * from products where itemName="'.$itemName.'"';
$resP = mysql_query($selP, $conn) or die(mysql_error());

$p = mysql_fetch_assoc($resP); 
$productID = $p[id];
$folder = $p[folder]; 
$itemPrice = $p[itemPrice];

if($folder == '/')
    $folder = '';

$downloadLink = $folder.'/?action=download&id='.$transID;

switch($paymentStatus)
{
	case 'Expired':
	case 'Failed':
	case 'Refunded':
	case 'Reversed':
	case 'Voided':
		$subject = $itemName.' Order Cancelled';

		$message = '<p>You have cancelled your order to '.$itemName.' </p>

		<p>The following information are your order details:
		<br><br>
		<p>	Payer ID: '.$_POST[payer_id].'<br> 
		Txn ID: '.$_POST['txn_id'].'<br>
		Paypal Email: '.$_POST['payer_email'].'<br>
		Item Name: '.$itemName.'<br>
		Item #: '.$itemNumber.'<br>
		Payment Status: '.$paymentStatus.'<br>
		Payment Amount: $'.$paymentAmount.'<br></p>';

		mail($adminEmail, $subject, $message, $headers);
        
        //update the database 
        $updS = 'update sales set status="R", expires="0" where transID="'.$transID.'"';
        $resS = mysql_query($updS, $conn) or print(mysql_error()); 
		break; 
	case 'Completed':
	case 'Pending':
	default: //confirmation email for customers
	{  
        //check if price matches and if amount is fake
        if($itemPrice != $paymentAmount && $paymentAmount == '0.01') {
            //redirect to fraud page 
            $downloadLink = $websiteURL.'/fraud.html';
        }
        else {
            //send download email to customer 
            sendDownloadEmail($p[id], $conn);
        }
            
    	if($itemNumber) 
        {
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
            $sel = 'select transID from sales where transID="'.$transID.'"';
            $res = mysql_query($sel, $conn) or die(mysql_error()); 
            
            if(mysql_num_rows($res) == 0) 
            {
                dbInsert($opt); //add sales record into database
            }
            
            if($custom) //affiliate's sale
            {
                $selU = 'select * from users where id="'.$custom.'"';
                $resU = mysql_query($selU, $conn) or print(mysql_error());
                $u = mysql_fetch_assoc($resU); 
                
                //total sales paid to affiliate
                if($receiverEmail == $u[paypal]) 
                    $salesPaid = 'salesPaid+1'; 
                else
                    $salesPaid = 'salesPaid';
                
                $updS = 'update affstats set sales=sales+1,
                salesPaid='.$salesPaid.'
                where userID="'.$custom.'" and productID="'.$productID.'"';
                
                mysql_query($updS, $conn) or print(mysql_error());
            }
        }   

		break;
		}
	}
}
else if (strcmp ($res, "INVALID") == 0)
{
	//notify admins of problem
	$headers = "From: ".$adminEmail."\n";
	$headers .= "Content-type: text/html;";
	$subject = 'Problem with Order: '.$itemName;

	$vars = array( 'txn_type', 'first_name', 'last_name', 'mc_currency',
	'residence_country', 'payer_email', 'payer_id', 'reattempt', 
	'address_name', 'address_city', 'receiver_email',
	'business', 'payment_status', 'amount3', 'mc_amount3', );
	
	$message = '<p>The following information was sent from paypal: <br>
	Date: '.date('m-d-Y', time()).'<br>
	Referrer: '.$_SERVER[HTTP_REFERER].'<br>';

	foreach($vars as $var)
	{
		$message .= $var.': '.$_POST[$var].'<br>';
	}

}
}
fclose ($fp);
}

?>
<meta http-equiv="refresh" content="3;url=<?=$downloadLink?>">
<center>
<img src='https://www.paypal.com/en_US/i/bnr/horizontal_solution_PPeCheck.gif' border=0><br>
<img border="0" src="images/transition.gif" width="186" height="42"><br><br>

<table width=420px cellpadding=5 style="border: 1px solid black; font-size: 12px;">
<tr>
    <td align="center">
    <h1>Processing Your Transaction...</h1>
    
    <h2>Redirecting you to download page...</h2>
    </td>
</tr>
</table>
</center>