<?php
$dir = '../';
require_once $dir.'vendor/autoload.php';
require_once $dir.'include/functions.php';
require_once $dir.'include/config.php';
require_once $dir.'include/spmSettings.php';


function checkDupeRows ($payerEmail, $productID) {
  global $conn; global $myfile;

  $query = "SELECT payerEmail, productID Password FROM sales WHERE
  payerEmail = '$payerEmail' AND productID='$productID'";
    
  fwrite($myfile, "\n".$query."\n");

  // Execute the query and store the result set
  $result = mysqli_query($conn, $query);
    
  //return number of rows in the table.
  $numRows = mysqli_num_rows($result);

  mysqli_free_result($result);// close the result.
  return $numRows;
}


if(!is_int(strpos(__FILE__, 'C:\\'))) { //localhost
  $stripeSecretKey = $stripeTestKey;
} //live
  $stripeSecretKey = $stripeLiveKey;


\Stripe\Stripe::setApiKey($stripeSecretKey);

$payload = @file_get_contents('php://input');
$event = null;

global $myfile;
$myfile = fopen("newfile.txt", "a");


try {
  $event = \Stripe\Event::constructFrom(
    json_decode($payload, true)
  );
} catch(\UnexpectedValueException $e) {

  $txt = '⚠️  Webhook error while parsing basic request.';
  fwrite($myfile, $txt);

  http_response_code(400);
  exit();
}
if ($endpoint_secret) {
  // Only verify the event if there is an endpoint secret defined
  // Otherwise use the basic decoded event
  $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
  try {
    $event = \Stripe\Webhook::constructEvent(
      $payload, $sig_header, $endpoint_secret
    );
  } catch(\Stripe\Exception\SignatureVerificationException $e) {
    // Invalid signature

    $txt = '⚠️  Webhook error while validating signature.';
    fwrite($myfile, $txt);
    http_response_code(400);
    exit();
  }
}

fwrite($myfile, '$event->type: '.$event->type); 
$paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
$payload = $paymentIntent;

//use payload
$transID = $paymentIntent->payment_intent;
$status = $paymentIntent->status;
$payment_link = $paymentIntent->payment_link;
$amount = $paymentIntent->amount_total/100; 
$payerEmail = $paymentIntent->customer_details->email;
$contactEmail = $paymentIntent->customer_email;

//get customer fname and lname
$name = $paymentIntent->customer_details->name;
$words = explode(" ", $name);
$firstName = $words[0];
$lastName = $words[1];

//product metadata from payment links dashboard
$productData = $payload->metadata;
$productID = $productData->productID;
$itemName = $productData->itemName;
$itemNumber = $productData->itemNumber;

$numRows = checkDupeRows ($payerEmail, $productID);

$opt = array(
  'tableName' => 'sales',
  'dbFields' => array(
      'productID' => $productID,
      'transID' => $transID,
      'itemName' => $itemName,
      'itemNumber' => $itemNumber,
      'amount' => $amount, 
      'purchased' => date('Y-m-d H:i:s', time()),
      'expires' => date('Y-m-d H:i:s', time()+259200), //expires 72 hours from purchased time
      'firstName' => $firstName, 
      'lastName' => $lastName, 
      'payerEmail' => $payerEmail,
      'contactEmail' => $contactEmail
  )
);


// Handle the event
switch ($event->type) { 
  case 'charge.succeeded':
  case 'payment_intent.completed':
    break;

    case 'checkout.session.completed':

      $txt = '
      payment_intent: '.$payment_intent.'
      amount: '.$amount.'
      firstName: '.$firstName.'  lastName: '.$lastName.'
      payerEmail: '.$payerEmail.'
      status: '.$status. '
      payment_link: '.$payment_link.'
      productID:. '.$productID.'
      itemName: '.$itemName.'
      itemNumber: '.$itemNumber.' 
      numRows: '.$numRows."\n";
      fwrite($myfile, $txt); 

      //check for existing record using transID
      if($numRows == 0) {
        dbInsert($opt); //add sales record into database
      
        $result = sendDownloadEmail($opt['dbFields']);
        //fwrite($myfile, ' after '.$result); 
      }
      break;
  default:
    // Unexpected event type
    //error_log('Received unknown event type');
    fwrite($myfile, "\n".'Received unknown event type'."\n"); 
}

http_response_code(200);