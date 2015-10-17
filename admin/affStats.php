<?php
include('adminCode.php'); 

function affstats($userID)
{
    $selU = 'select * from affstats where userID="'.$userID.'"';
    $resU = mysql_query($selU) or die(mysql_error());
    
    while($s = mysql_fetch_assoc($resU))
    {
        $stats[$s[userID]][$s[productID]] = $s; 
    }

    $selP = 'select * from products where affcenter="Y" order by itemName'; 
    $resP = mysql_query($selP) or die(mysql_error()); 
    
    while($p = mysql_fetch_assoc($resP))
    {
        $productID = $p[id];
        $affstats .= '<tr><td>'.$p[itemName].'</td>
        <td>'.$stats[$userID][$productID][uniqueClicks].'</td>
        <td>'.$stats[$userID][$productID][rawClicks].'</td>
        <td>'.$stats[$userID][$productID][salesPaid].'</td>
        <td>'.$stats[$userID][$productID][sales].'</td></tr>'; 
    }
    
    $affstats = '<table cellpadding=5 cellspacing=0 border=1>
    <tr>
        <th>Product</th>
        <th>Unique Clicks </td>
        <th>Raw Clicks </td>
        <th>Sales Paid </td>
        <th>Sales Total </td>
    </tr>
    '.$affstats.'</table>' ;
    
    return $affstats; 
}

if($_GET[id])
{
    $userID = $_GET[id]; 
}

if($_POST[update])
{
    $upd = 'update affstats set uniqueClicks="'.$_POST[uniqueClicks].'",
    rawClicks="'.$_POST[rawClicks].'",
    salesPaid="'.$_POST[salesPaid].'",
    sales="'.$_POST[sales].'" 
    where userID="'.$userID.'" and productID="'.$_POST[productID].'"';
    
    $res = mysql_query($upd, $conn) or die(mysql_error()); 
}

//get aff details
$selA = 'select * from users where id="'.$userID.'"';
$resA = mysql_query($selA, $conn) or die(mysql_error()); 

$a = mysql_fetch_assoc($resA);


//get stats
$selU = 'select * from affstats where userID="'.$userID.'"';
$resU = mysql_query($selU) or die(mysql_error());

while($s = mysql_fetch_assoc($resU))
{
    $stats[$s[userID]][$s[productID]] = $s; 
}

$selP = 'select * from products where affcenter="Y" order by itemName'; 
$resP = mysql_query($selP) or die(mysql_error()); 

while($p = mysql_fetch_assoc($resP))
{
    $productID = $p[id];
    
    $content .= '<tr>
    <td>'.$p[itemName].'</td>
    <td><form method=post><input type=text size=3 name=uniqueClicks value="'.$stats[$userID][$productID][uniqueClicks].'" /></td>
    <td><input type=text size=3 name=rawClicks value="'.$stats[$userID][$productID][rawClicks].'" /></td>
    <td><input type=text size=3 name=salesPaid value="'.$stats[$userID][$productID][salesPaid].'" /></td>
    <td><input type=text size=3 name=sales value="'.$stats[$userID][$productID][sales].'" /></td>
    <td> <input type=submit name=update value="Update" />
        <input type=hidden name=productID value="'.$productID.'" ></form> </td>
    </tr>';
}
?>

<div class="moduleBlue"><h1>Affiliate Details</h1>
<div class="moduleBody">
<table>
    <tr>
        <td> Username </td><td><?=$a[username]?></td>
    </tr>
    <tr>
        <td>Paypal </td><td> <?=$a[paypal]?> </td>
    </tr>
    <tr>
        <td>Email</td><td><?=$a[email]?> </td>
    </tr>
</table> 
</div>
</div>

<p>&nbsp;</p>
<? echo affstats($userID) ?>
<p>&nbsp;</p>
<table cellpadding=5 cellspacing=0 border=1>
    <tr>
        <th>Product</th>
        <th>Unique Clicks </th>
        <th>Raw Clicks </th>
        <th>Sales Paid </th>
        <th>Sales Total </th>
        <th></th>
    </tr>
    <?=$content?>
</table> 

<?
include('adminFooter.php');  ?>