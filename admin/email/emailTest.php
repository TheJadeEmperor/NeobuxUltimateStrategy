<?php
$adir = '../';
include($adir.'adminCode.php');

if($_POST['sendEmail']) {
    $productID = $_POST['productID'];

    $data = array(
        'productID' => $productID,
        'type' => $_POST['type'],
    );

    $message = sendDownloadEmail($data);
    echo $message; 
}

//get payer_email or set default to adminEmail
if($_POST['payer_email'])
    $payer_email = $_POST['payer_email'];
else
    $payer_email = $context['adminEmail'];

//get all products data
$opt = array(
    'tableName' => 'products',
    'cond' => 'ORDER BY id');
$resP = dbSelectQuery($opt);

while( $p = $resP->fetch_array() ) {

    $select = '';
    if($_POST['productID'] == $p['id'])
        $select = 'selected'; 

    $prodDropDown .= '<option value="'.$p['id'].'" '.$select.'>'.$p['itemName'].'</option>';
}

//a product is chosen from drop down menu
if($_POST['productID']) {

    $id = $_POST['productID']; 

    $opt = array(
        'tableName' => 'emails',
        'cond' => 'WHERE productID="'.$id.'"');
    $resE = dbSelectQuery($opt);

    while( $e = $resE->fetch_array() ) {

        $e['subject'] = stripslashes($e['subject']);

        $e['message'] = stripslashes($e['message']);

        $option = '';

        if($_POST['type'] == $e['type']) {

            $option = 'selected';
            $template = $e; 
        }

        $emailDropDown .= '<option value="'.$e['type'].'" '.$option.'>'.$e['subject'].'</option>';
    }
}
?>
<form method="POST">
    <div class="moduleBlue"><h1>Test Emails</h1>
    <div class="moduleBody">

    <table>
        <tr>
            <td>Use this product: </td><td>
                <select name="productID" onchange="submit();"><option></option><?=$prodDropDown?></select>
            </td>
        </tr>
        <tr>
            <td>Use this email: </td>
            <td><select name="type" onchange="submit();"><option></option><?=$emailDropDown?></select>
            </td>
        </tr>
        <tr>
            <td>Message: </td>
            <td><textarea cols="35" rows="5"><?=$template['message']?></textarea></td>
        </tr>
    </table>

    <table>
        <tr>
            <td>Send to this email: </td>
            <td><input type="text" name="payer_email" value="<?=$payer_email?>" size="30" /></td>
        </tr> 
        <tr>
            <td>$firstName</td>
            <td><input type="text" name="first_name" value="<?=$_POST['first_name']?>" /></td>
        </tr>
        <tr>
            <td>$lastName</td>
            <td><input type="text" name="last_name" value="<?=$_POST['last_name']?>"/> </td>
        </tr>
        <tr>
            <td>$transID</td>
            <td><input type="text" name="txn_id" value="<?=$_POST['txn_id']?>" /></td>
        </tr>
        <tr>
            <td>$paymentStatus</td>
            <td><input type="text" name="payment_status" value="<?=$_POST['payment_status']?>" /></td>
        </tr>
        <tr>
            <td colspan="2" align="center">

                <input type="hidden" name="id" value="<?=$_POST['productID']?>">
                <input type="submit" name="sendEmail" value="Test Email" class="btn btn-warning"> Click only once
            </td>
        </tr>
    </table>

    </div>
    </div>
</form>

<?php
include($adir.'adminFooter.php'); ?>