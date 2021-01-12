<?php
$adir = '../';
include($adir.'adminCode.php');
$tableName = 'users';

//delete user and redirect to userList
if($_POST['deleteUser']) {

    $opt = array(
        'tableName' => 'users',
        'cond' => 'WHERE id="'.$_POST['deleteID'].'"'
    ); 
    dbDeleteQuery ($opt); //DELETE fROM users WHERE id="'.$_POST['deleteID'].'"

    $msg = 'Deleted user from database ... redirecting to users list';
	
	echo '<meta http-equiv="refresh" content="3;URL=userSearch.php">';
}

//update db 
if($_POST['update']) {
    $dbFields = array(
        'fname' => $_POST['fname'],
        'lname' => $_POST['lname'],
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'email' => $_POST['email'],
        'paypal' => $_POST['paypal'],
        'optout' => $_POST['optout'],
        'status' => $_POST['status']
    );

    $opt = array(
        'tableName' => $tableName, 
        'dbFields' => $dbFields,
        'cond' => ' WHERE id="'.$_GET['id'].'"'
    );

    dbUpdate($opt);
    
	$set = array();
/*
	foreach($dbFields as $fld => $val) {
		array_push($set, $fld.'="'.addslashes($val).'"');
	}
	
	$theSet = implode(',', $set);
	
	$upd = 'update users set '.$theSet.' where id="'.$_POST[id].'"';
    mysql_query($upd, $conn) or die(mysql_error());
    */
}

if($_GET['id']) { //if user ID is passed to the page 
	$cond = 'WHERE id="'.$_GET['id'].'"';
}
else if($_GET['e']) { //if email is passed to the page
    $cond = 'WHERE email="'.$_GET['e'].'" || paypal="'.$_GET['e'].'"';
}


$opt = array(
	'tableName' => $tableName,
    'cond' => $cond
);
$resU = dbSelectQuery($opt);

if($u = $resU->fetch_array()) {  
    $userID = $u['id'];
    $optoutPick[$u['optout']] = 'selected'; //optout?
    $statusPick[$u['status']] = 'selected'; //status
}

//check if this user is a customer
$selS = 'SELECT *, date_format(purchased, "%m/%d/%Y") AS bought FROM sales WHERE 
payerEmail="'.$u['paypal'].'" AND payerEmail <> ""';
$resS = $conn->query($selS);

if(mysqli_num_rows($resS) > 0) {
    while($s = $resS->fetch_array()) {
        $sContent .= '<p>Bought the '.$s['itemName'].' on 
        <a href="custView.php?id='.$s['id'].'" title="'.$s['id'].'">'.$s['bought'].'</a></p>';
    }
}
else {
    $sContent = '<p>Not a customer</p>';	
}


if(!empty($msg)) {
	$msg = '<fieldset><font color="red"><b>'.$msg.'</b></font></fieldset>';
}
	
echo $msg; 
?>
<div class="moduleBlue"><h1>Update Affiliate</h1>
<div class="moduleBody">
<form method="POST">
<table>
<tr title="User's unique registration ID - given upon registration - it cannot be changed">
	<td>User ID</td>
    <td><?=$userID?><input type="hidden" name="id" value="<?=$userID?>" /></td>
</tr><tr title="username">
	<td>Username </td><td><input class="activeField" name="username" value="<?=$u['username']?>" /> </td>
</tr><tr>
	<td>Password </td><td><input class="activeField" name="password" value="<?=$u['password']?>" /></td>
</tr><tr>
	<td>First Name </td><td><input class="activeField" name="fname" value="<?=$u['fname']?>" /></td>
</tr><tr>
	<td>Last Name</td><td><input class="activeField" name="lname" value="<?=$u['lname']?>" /></td>
</tr><tr>
	<td>Email - Contact</td><td><input class="activeField" name="email" value="<?=$u['email']?>" size="30" /></td>
</tr><tr>
	<td>Email - Paypal</td><td><input class="activeField" name="paypal" value="<?=$u['paypal']?>" size="30" /></td>
</tr><tr>
    <td>Optout? </td>
    <td><select name="optout">
        <option <?=$optoutPick['']?> value="">N</option>
        <option <?=$optoutPick['Y']?> value="Y">Y</option>
    </select></td>
</tr>
<tr>
    <td>Status </td>
    <td><select name="status">
        <option <?=$statusPick['']?> value="">Active</option>
        <option <?=$statusPick['B']?> value="B">Banned</option>
		<option <?=$statusPick['C']?> value="C">Cancelled</option>
    </select>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" class="btn success" name="update" value="Update Profile" /></td>
</tr>
</table>
</form>
</div></div>

<p>&nbsp;</p>

<div class="moduleBlue"><h1>Is Customer?</h1>
<div class="moduleBody">
    <?=$sContent?>
</div>
</div>

<p>&nbsp;</p>
<p>&nbsp;</p>

<div class="moduleBlue"><h1>Delete User</h1>
<div class="moduleBody">
    <div title="header=[Delete User] body=[Delete a user from the users table, will not affect sales records]">
	<center>
	
	<form method="post">
        <img src="<?=$helpImg?>" />     
        <input type="submit" name="deleteUser" <?=$disDel?> onclick="confirm ('Are you sure?')" class="btn danger" /></div>
        <input type="hidden" name="deleteID" value="<?=$userID?>" />
    </form>

	</center>
	</div>
</div>
</div>

<p>&nbsp;</p>

<?
include('adminFooter.php');  ?>