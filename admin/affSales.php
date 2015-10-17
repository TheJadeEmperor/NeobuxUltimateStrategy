<?php
include('adminCode.php');

if($_GET['id']) //affiliate's user id
{
    $userID = $_GET['id'];
}

$selS = 'select *, date_format(purchased,"%m/%d/%y %h:%i %p") as 
purchasedDate from sales where affiliate="'.$userID.'" order by purchased';
$resS = mysql_query($selS, $conn) or die(mysql_error()); 

while($s = mysql_fetch_assoc($resS))
{
    $displayEmail = shortenText($s[payerEmail], 25);
    $itemName = shortenText($s[itemName], 30);
    $amount = $s[amount];
    $salesTotal += $amount;
    
    $selU = 'select id, username, email from users where paypal="'.$s[payerEmail].'" limit 1';
    $resU = mysql_query($selU, $conn) or die(mysql_error());
    
    $u = mysql_fetch_assoc($resU);
    $username = $u[username]; 
    $contactEmail = $u[email];
    $userID = $u[id];
    
    if(!isset($username))
        $username = 'N/A';
    if(!isset($contactEmail))
        $contactEmail = 'N/A';
    
    $salesContent .= '<tr>
    <td><a href="custView.php?id='.$s[id].'">'.$s[transID].'</a></td>
    <td>'.$s[purchasedDate].'</td>
    <td><a href="product/productNew.php?id='.$s[productID].'">'.$itemName.'</a></td>
    <td>
    <div title="header=['.$s[firstName].' '.$s[lastName].'] body=[Contact Email: '.$contactEmail.'
    <br />Username: '.$username.'] "><a href="updateProfile.php?id='.$userID.'">'.$displayEmail.'</a></div>
    </td>
    <td>'.$s[paidTo].'</td>
    <td>'.$amount.'</td>
    </tr>';
}  
?>
<div class="moduleBlue"><h1>Sales</h1>
<div>
<table>
    <tr>
        <th>Transaction ID</th>
        <th>Purchased</th>
        <th>Product Name</th>
        <th>Customer Email</th>
        <th>Paid To</th>
        <th>Amount</th>
    </tr>
    <?=$salesContent?>
    <tr>
        <td colspan=5 align=right>Total:</td>
        <td><?=$salesTotal?></td>
    </tr>
</table>
</div>
</div>

<?
include('adminFooter.php');  ?>