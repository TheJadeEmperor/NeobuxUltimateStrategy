<?php
$adir = '../';
include($adir.'adminCode.php');

$_SESSION['sendTo'] = array();

$selS = 'SELECT U.id, username, fname, lname, email, paypal, S.id as salesID FROM users U LEFT JOIN sales S ON U.paypal = S.payerEmail GROUP BY U.ID'; 
$resS = $conn->query($selS); 

while($u = $resS->fetch_array()) {
	
	array_push($_SESSION['sendTo'], $c['payerEmail']);

	$id = $u['id'];
	$paypal = $u['paypal'];
	$email = $u['email'];
	if($email == $paypal) 
		$paypal = 'Same';
	else
		$paypal = "";

	if($u['salesID'])
		$isCustomer = 'Yes'; 
	else 
		$isCustomer = "";
	
	$custTable .= '<tr>
	<td>'.$id.'</td>
	<td>'.$u['username'].'</td>
	<td>'.$u['fname'].' '.$u['lname'].'</td>
	<td>'.$email.'</td> 
	<td>'.$paypal.'</td>
	<td>'.$isCustomer.'</td>
	<td><a href="updateProfile.php?id='.$id.'" target="_BLANK">View</a></td>
	</tr>';
}

?>
<script> 
$(document).ready( function () {
    $('#cust').dataTable({  
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "iDisplayLength": 100
    });

}); //document.ready
</script>

<table cellpadding="0" cellspacing="0" border="0" class="display" id="cust">
    <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Email Address</th>
			<th>Paypal Address</th>
			<th>Is Customer?</th>
            <th>View</th>
        </tr>
    </thead>
    <tfoot>
    </tfoot>
    <tbody>
         <?=$custTable?>
    </tbody>
</table>
<br />
<div class="panel panel-info">
    <div class="panel-heading">
        <p align="center"><a href="email/emailSend.php"><input type="button" class="btn btn-warning" value="Email All"></a></p>
    </div>
</div>

<?
include($dir.'adminFooter.php');  ?>