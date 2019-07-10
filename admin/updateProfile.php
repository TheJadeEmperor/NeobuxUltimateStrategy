<?php
include('adminCode.php');

//delete user
if($_POST['deleteUser']) {
    $del = 'DELETE FROM users WHERE id="'.$_POST['deleteID'].'"';
    mysql_query($del, $conn) or die(mysql_error());
    
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
    
	$set = array();

	foreach($dbFields as $fld => $val) {
		array_push($set, $fld.'="'.addslashes($val).'"');
	}
	
	$theSet = implode(',', $set);
	
	$upd = 'UPDATE users SET '.$theSet.' WHERE id="'.$_POST['id'].'"';
	mysql_query($upd, $conn) or die(mysql_error());
}

if($_GET['id']) { //if user ID is passed to the page
	$selU = 'SELECT * FROM users WHERE id="'.$_GET['id'].'"';
}
else if($_GET['e']) { //if email is passed to the page
    $selU = 'SELECT * FROM users WHERE email="'.$_GET['e'].'" || paypal="'.$_GET['e'].'"';
}

//get user info
$resU = mysql_query($selU, $conn) or die(mysql_error());

if($u = mysql_fetch_assoc($resU)) {  
    $userID = $u['id'];
    $optoutPick[$u['optout']] = 'selected'; //optout?
    $statusPick[$u['status']] = 'selected'; //status
}

//check if this user is a customer
$selS = 'SELECT *, date_format(purchased, "%m/%d/%Y") AS bought FROM sales WHERE payerEmail="'.$u['paypal'].'" and payerEmail <> ""';
$resS = mysql_query($selS, $conn) or die(mysql_error());

if(mysql_num_rows($resS) > 0) {
    while($s = mysql_fetch_assoc($resS)) {
        $sContent .= '<p>Bought the '.$s['itemName'].' on 
        <a href="custManage.php?id='.$s['id'].'" title="'.$s['id'].'">'.$s['bought'].'</a></p>';
    }
}
else {
    $sContent = '<p>Not a customer</p>';	
}

//generate affiliate links 
$selP = 'SELECT * FROM products WHERE itemPrice > 0 ORDER BY id';
$resP = mysql_query($selP, $conn) or die(mysql_error());

while($p = mysql_fetch_assoc($resP)) {
    $folder = $p['folder'];
    
    if($folder == '')
        $affContent .= '<p>'.$websiteURL.'/?r='.$u['username'].'</p>';
    else
        $affContent .= '<p>'.$websiteURL.'/'.$p['folder'].'/?r='.$u['username'].'</p>';    
}


if(!empty($msg)) {
	$msg = '<fieldset><font color="red"><b>'.$msg.'</b></font></fieldset>';
}
	
echo $msg; 
?>
<div class="moduleBlue"><h1>Update User</h1>
<div class="moduleBody">


<form method="POST">
<table>
	<tr title="User's unique registration ID - given upon registration - it cannot be changed">
		<td>User ID</td>
		<td><?=$userID?> <input type="hidden" name="id" value="<?=$userID?>" /></td>
	</tr>
	<tr title="username">
		<td>Username </td>
		<td><input class="activeField" name="username" value="<?=$u['username']?>"></td>
	</tr>
	<tr>
		<td>Password </td>
		<td><input class="activeField" name="password" value="<?=$u['password']?>"></td>
	</tr>
	<tr>
		<td>First Name </td>
		<td><input class="activeField" name="fname" value="<?=$u['fname']?>"></td>
	</tr>
	<tr>
		<td>Last Name</td>
		<td><input class="activeField" name="lname" value="<?=$u['lname']?>"></td>
	</tr>
	<tr>
		<td>Email - Contact</td>
		<td><input class="activeField" name="email" value="<?=$u['email']?>" size="30"></td>
	</tr>
	<tr>
		<td>Email - Paypal</td>
		<td><input class="activeField" name="paypal" value="<?=$u['paypal']?>" size="30"></td>
	</tr>
	<tr>
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
		<td colspan="2" align="center"><input type="submit" class="activeField" name="update" value="Update Profile"></td>
	</tr>
</table>
</form>
</div>
</div>

<p>&nbsp;</p>

<div class="moduleBlue">
	<h1>Is Customer?</h1>
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
			<input type="submit" name="deleteUser" <?=$disDel?> onclick="confirm ('Are you sure?')"/>
			<input type="hidden" name="deleteID" value="<?=$userID?>" />
			</form>
		</div>
		
		</center>
	</div>
</div>
</div>

<p>&nbsp;</p>

<?
include('adminFooter.php');  ?>