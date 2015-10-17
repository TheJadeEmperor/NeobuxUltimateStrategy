<?
$dir = '../../';
include($dir.'include/functions.php');
include($dir.'include/mysql.php');
include($dir.'include/config.php');

//sanitize arguments
foreach($_REQUEST as $request => $value) {
    $_REQUEST[$request] = mysql_real_escape_string($value);
}

$updateRecord = 'UPDATE sales set 
    productID="'.$_REQUEST['productID'].'",
    transID="'.$_REQUEST['transID'].'",
    itemName="'.$_REQUEST['itemName'].'",
    itemNumber="'.$_REQUEST['itemNumber'].'",
    amount="'.$_REQUEST['amount'].'",
    payerEmail="'.$_REQUEST['payerEmail'].'",
    contactEmail="'.$_REQUEST['contactEmail'].'",
    purchased="'.$_REQUEST['purchased'].'",
    expires="'.$_REQUEST['expires'].'",
    firstName="'.$_REQUEST['firstName'].'",
    lastName="'.$_REQUEST['lastName'].'",
    paidTo="'.$_REQUEST['paidTo'].'",
    status="'.$_REQUEST['status'].'",
    notes="'.$_REQUEST['notes'].'",
    optout="'.$_REQUEST['optout'].'"
WHERE id="'.$_REQUEST['id'].'"';

if(mysql_query($updateRecord))
    echo 'Successfully updated record #'.mysql_insert_id();
else
    echo 'Failed to update record: '.mysql_error();
?>