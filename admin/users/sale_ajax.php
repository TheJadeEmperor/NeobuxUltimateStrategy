<?
$dir = '../../';
include($dir.'include/functions.php');
include($dir.'include/config.php');

//sanitize arguments
foreach($_REQUEST as $request => $value) {
    $_REQUEST[$request] = mysqli_real_escape_string($conn, $value);
}

switch ($_GET['action']) {
    case 'create':
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
            ) VALUES (
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
        
        if($conn->query($insertRecord))
            echo 'Successfully inserted record #'.$conn->insert_id;
        else
            echo $insertRecord.' '.$conn->error;
                
        break;

    case 'update':

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
    
        if($conn->query($updateRecord))
            echo 'Successfully updated record #'.$_REQUEST['id'];
        else
            echo $updateRecord.' '.$conn->error;        
        
        break;
    case 'read':
    default: 
        $opt = array(
            'tableName' => 'sales',
            'cond' => 'WHERE id="'.$_REQUEST['id'].'"'
        );
        
        $resS = dbSelectQuery($opt);
        $resArray = $resS->fetch_array();
        
        echo json_encode($resArray);

}

?>