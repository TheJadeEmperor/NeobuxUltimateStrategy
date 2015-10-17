<?php
include('adminCode.php');

function getSales($whichMonth) 
{
    global $conn; 
    $selR = 'select sum(amount) as revenue, date_format(purchased, "%m/%Y") as purchased from sales where purchased like "%'.$whichMonth.'%"';
    
    $resR = mysql_query($selR, $conn) or die(mysql_error()); 
    $r = mysql_fetch_assoc($resR);
    
    $revenue = '$'.number_format($r[revenue], 2);
    return $revenue;
}

if($_POST[viewMonth])
{
    $pickYearMonth = $_POST[pickYear].'-'.$_POST[pickMonth];
    
    $salesPickMonth = getSales($pickYearMonth);
}


$thisMonth = date('m/Y', time());
$lastMonth = date("m/Y",strtotime("-1 month"));
$thisYear = date("Y", time()); 

//echo $thisYear; 

$selS = 'select *, date_format(purchased, "%m/%d/%Y") as purchased, 
date_format(purchased, "%m/%Y") as currentMonth, date_format(purchased, "%Y") as thisYear
from sales order by purchased';
$resS = mysql_query($selS, $conn) or die(mysql_error());

while($s = mysql_fetch_assoc($resS))
{
    //total sales 
    $grandTotal += $s[amount];
    
    if($thisMonth == $s[currentMonth])
        $salesThisMonth += $s[amount];
    else if($lastMonth == $s[currentMonth])
        $salesLastMonth += $s[amount]; 
    
    //sales this year
    if($thisYear == $s[thisYear])
        $salesThisYear += $s[amount]; 
    
    //breakdown by product 
    $product[$s[productID]][total] += $s[amount]; 
    $product[$s[productID]][itemName] = $s[itemName]; 
}

$salesThisMonth = '$'.number_format($salesThisMonth, 2);
$salesLastMonth = '$'.number_format($salesLastMonth, 2);
$salesThisYear = '$'.number_format($salesThisYear, 2);
$grandTotal = '$'.number_format($grandTotal, 2);
 
//month drop down menu
for($mo = 1; $mo <= 12; $mo++)
{
    if($mo < 10)
        $mo = '0'.$mo;
    
    $pick = '';
    if($_POST[pickMonth] == $mo)
        $pick = 'selected';
    
    $monthOpt .= '<option '.$pick.'>'.$mo.'</option>';
}

//break down by year
$monthArray = array(
'01' => 'Jan',
'02' => 'Feb',
'03' => 'Mar',
'04' => 'Apr',
'05' => 'May',
'06' => 'Jun',
'07' => 'Jul',
'08' => 'Aug',
'09' => 'Sep',
'10' => 'Oct',
'11' => 'Nov',
'12' => 'Dec');

?>
<table>
<tr valign="top">
    <td>
        
        <div class="moduleBlue"><h1>Sales History</h1>
        <div>
        <table>
        <tr valign="top">
            <td>Sales This Month</td>
            <td><div title="header=[This month's revenue] body=[All sales made by you and
                your affiliates this month so far] ">
            <img src="<?=$helpImg?>" /> <?=$salesThisMonth?></div>
            </td>
        </tr>
        <tr>
            <td>Sales Last Month</td>
            <td><?=$salesLastMonth?></td>
        </tr>
        <tr>
            <td>Sales This Year</td>    
            <td><?=$salesThisYear?></td>
        </tr>
        <tr>
            <td>Total Sales Since Inception </td>
            <td><div title="header=[Total Sales] body=[This is a grand total of all sales since the
                inception of this website - this includes all affiliate sales and sales from inactive
                products] ">
            <img src="<?=$helpImg?>" /> <?=$grandTotal?></div></td> 
        </tr>
        </table>
        </div></div>
        
        <p>&nbsp;</p>
        
        <div class="moduleBlue"><h1>This Year's Sales (<?=$thisYear?>)</h1>
        <div class="moduleBody">
        <?
        foreach($monthArray as $mo => $month)
        {
            echo $month.' '.$thisYear.': '.getSales($thisYear.'-'.$mo).'<br />';
        }
        
        ?>
        
        </div></div>
    </td>
    <td width="10px"></td>
    <td>
        <div class="moduleBlue"><h1>Sales by Month</h1>
        <div class="moduleBody">
            <br />
            <form method=post> 
                Year: <input type=text class="activeField" size=6 name=pickYear value="<?=$_POST[pickYear]?>"/>
                Month: <select name=pickMonth><?=$monthOpt?></select>
                <input type=submit name=viewMonth class="btn success" value=" View " />
            </form> 
            <p>Total: <b><?=$salesPickMonth?></b></p>
        </div>
        </div>
        
        <p>&nbsp;</p><br />
        
        <div class="moduleBlue"><h1>Breakdown by Product</h1>
        <div class="moduleBody">
            <table>
            <?
            foreach($product as $id => $amt)
            {
                $productTotal = '$'.number_format($amt[total], 2);
                $productName = shortenText($amt[itemName], 30);
                $productName = '<a href="product/productNew.php?id='.$id.'">'.$productName.'</a>';
                
                echo '<tr>
                <td>'.$productName.'</td> 
                <td>'.$productTotal.'</td></tr>';
            }
            ?>
            </table>
        </div>
        </div>
        
    </td>
</tr>
</table>
<?
include('adminFooter.php');  ?>