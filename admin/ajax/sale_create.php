<?
$dir = '../../';
include($dir.'include/functions.php');
include($dir.'include/mysql.php');
include($dir.'include/config.php');

//sanitize arguments
foreach($_REQUEST as $request => $value) {
    $_REQUEST[$request] = mysql_real_escape_string($value);
}

$insertRecord = 'INSERT INTO sales (
    productID,
    transID,
    itemName,
    itemNumber,
    amount,
    payerEmail,
    contactEmail,
    purchased,
    expires,
    firstName,
    lastName,
    paidTo,
    status,
    notes,
    optout
    ) values (
    "'.$_REQUEST['productID'].'",
    "'.$_REQUEST['transID'].'",
    "'.$_REQUEST['itemName'].'",
    "'.$_REQUEST['itemNumber'].'",
    "'.$_REQUEST['amount'].'",
    "'.$_REQUEST['payerEmail'].'",
    "'.$_REQUEST['contactEmail'].'",
    "'.$_REQUEST['purchased'].'",
    "'.$_REQUEST['expires'].'",
    "'.$_REQUEST['firstName'].'",
    "'.$_REQUEST['lastName'].'",
    "'.$_REQUEST['paidTo'].'",
    "'.$_REQUEST['status'].'",
    "'.$_REQUEST['notes'].'",
    "'.$_REQUEST['optout'].'"
)';

if(mysql_query($insertRecord))
    echo 'Successfully inserted record #'.mysql_insert_id();
else
    echo 'Failed to insert record: '.mysql_error();
?>