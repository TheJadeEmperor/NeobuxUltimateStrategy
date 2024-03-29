<?php
$adir = '../';
include($adir.'adminCode.php');

$tableName = 'sales';
$saleID = $_GET['id'];

//extend the expiration date
if($_POST['extendExpires']) {
    $expireSeconds = $_POST['expiresHours'] * 60 * 60; //# of hours converted to seconds
    $newExpDate = time() + $expireSeconds; //new expiration date in seconds
    $newExpDate = date('Y-m-d h:m:i', $newExpDate); //new expiration date in sql format

    $dbOptions = array(
        'tableName' => $tableName,
        'dbFields' => array(
            'expires' => $newExpDate
            ),
        'cond' => 'WHERE id="'.$saleID.'"'
        );    
        
    dbUpdate($dbOptions);
}


//get info from this sale 
$selS = 'SELECT *, date_format(purchased, "%m/%d/%Y") AS bought, date_format(expires, "%m/%d/%Y") AS expiresDate FROM sales WHERE id="'.$saleID .'"';
$resS = $conn->query($selS); // or die(mysql_error());

if($s = $resS->fetch_array()) {
    $s['notes'] = stripslashes($s['notes']);
    $amount = '$'.number_format($s['amount'], 2);

    $opt = array(
        'tableName' => 'products',
        'cond' => 'where id="'.$s['productID'].'"'
    );
    
    $resP = dbSelectQuery($opt);
    
    $p = $resP->fetch_array(); //product array
}

$salesDate = $s['bought'];
$expiresDisplay = $s['expiresDate'];

//check for expiration date
$today = time(); 
$expiresDate = strtotime($s['expiresDate']);
$expireSeconds = $p['expires'] * 60 * 60; 

if(($today) <= ($expiresDate + $expireSeconds)) {
    $downloadLinkStatus = 'Active';
    $disExtend = 'disabled'; 
}
else  {
    $downloadLinkStatus = 'Expired';
}


//get the download link
$folder = $p['folder'];
if($folder == '')
    $downloadLink = $dir.'?action=download&id='.$s['transID'];
else
    $downloadLink = $dir.$folder.'/?action=download&id='.$s['transID'];

if($_POST['makeAccount']) {
    $dbOptions = array(
    'tableName' => 'users',
    'dbFields' => array(
        'paypal' => $s['payerEmail'],
        'email' => $s['contactEmail'],
        'fname' => $s['firstName'],
        'lname' => $s['lastName'],
        'joinDate' => $s['purchased'],
        'username' => genString(8),
        'password' => genString(8),
        )
    ); 
    
    $res = dbInsert($dbOptions);
    if($res) {
        $newID = $conn->insert_id; 
        $msg = 'Added user account: <a href="updateProfile.php?id='.$newID.'">click here to view account</a>';
    }
}

if($_POST['updateNotes']) {
    $dbOptions = array(
    'tableName' => 'sales', 
    'dbFields' => array(
        'notes' => $_POST['notes']),
    'cond' => 'where id="'.$_GET['id'].'"');
        
    if(dbUpdate($dbOptions))
        $msg = 'Updated notes for this sale';
    else
        $msg = 'Failed to update this sale';
}

//check for users account
$opt = array(
    'tableName' => 'users',
    'cond' => ' WHERE paypal="'.$s['payerEmail'].'" || email="'.$s['payerEmail'].'"'
);

$resU = dbSelectQuery($opt);

$u = $resU->fetch_array();
$numAccounts = $resU->num_rows;

if($numAccounts == 0 || empty($s['payerEmail'])) {
    $membersAccount = 'No';
}
else {
    $disAdd = 'disabled';
	$membersAccount = '<a href="updateProfile.php?id='.$u['id'].'">Yes</a>';
}


if($msg)
	echo showMessage($msg);
?>
<table>
<tr valign="top">
    <td>
        <form method="POST">

        <div class="moduleBlue"><h1>View Sale</h1>
        <div class="moduleBody">
            <table>
            <tr>
                <td>Transaction ID</td>
                <td><div title="header=[Paypal Transaction ID] body=[The unique transaction ID sent from Paypal upon purchase <br /> This is ID used in the download link]">
                    <a href="<?=$downloadLink?>" target="_blank"><?=$s['transID']?></a> <img src="<?=$helpImg?>" /> </div>
                </td>
            </tr>
            <tr>
                <td>Full Name</td>
                <td><?=$s['firstName'].' '.$s['lastName']?></td>
            </tr>
            <tr>
                <td>Product</td>
                <td><?=$p['itemName']?></td>
            </tr>
            <tr>
                <td>Amount</td>
                <td><?=$amount?></td>
            </tr>
            <tr>
                <td>Payer Email</td>
                <td><?=$s['payerEmail']?></td>
            </tr>
            <tr>
                <td>Members account?</td><td><?=$membersAccount?></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" name="makeAccount" value=" Make Members Account " class="btn success"
                    onclick="confirm('Make members account?');" <?=$disAdd?> /></td>
            </tr>
            <tr>
                <td>Purchased </td>
                <td><div title="header=[Purchase Date] body=[When the sale was made]">
                    <?=$salesDate?> <img src="<?=$helpImg?>" /> </div></td>
            </tr>
            <tr>
                <td>Download Link Expires</td>
                <td><div title="header=[Download Link Expires] body=[When the download link expires <br /> The # of hours can be set in the product options]">
                    <?=$expiresDisplay?>  (<?=$p['expires']?> Hours) <img src="<?=$helpImg?>" /> </div></td>
            </tr>
            <tr>
                <td>Download Link Status</td>
                <td><a href="<?=$downloadLink?>" target="_blank"><?=$downloadLinkStatus?></a></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                	<input type="hidden" name="expiresHours" value="<?=$p['expires']?>">
                    <input type="submit" name="extendExpires" value=" Extend Expiration Date " class="btn danger" onclick="confirm('Extend the expiration date?');" <?=$disExtend?> />
                </td>
            </tr>
            </table>
        </div>
        </div>
        </form>

        <p>&nbsp;</p>
        <div class="moduleBlue"><h1>Update Notes</h1>
        <div class="moduleBody">
            <form method="post">
                <textarea name="notes" rows="5" cols="50"><?=$s['notes']?></textarea><br />
                <center><input type="submit" name="updateNotes" value="Update Notes" class="btn info" /></center>
            </form>    
        </div>
        </div>
    </td>
    <td width="10px"></td>
    <td>
    	<div class="moduleBlue"><h1>More Options</h1>
        <div class="moduleBody">
            <center><a href="custManage.php?id=<?=$saleID?>"><input type="button" value="Edit Sales Details" class="btn danger" onclick="alert('Warning: You are about to make changes to the database\nClick OK if you know what this means')"/></a>
        	</center>
        </div>
        </div>
    	
    	
    	
    </td>
</tr>
</table>

<p>&nbsp; </p>
<p>&nbsp; </p>
<?php
include('adminFooter.php');  ?> 