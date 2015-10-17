<?
$dir = '../';
include($dir.'include/functions.php');
include($dir.'include/mysql.php');
include($dir.'include/config.php');

if($_GET[e])
{
    $emailAddress = $_GET[e];
    
    //update customer
    $updC = 'update sales set optout="Y" where payerEmail="'.$emailAddress.'" or contactEmail="'.$emailAddress.'"';
    mysql_query($updC, $conn) or die(mysql_error());
    
    //update user
    $updU = 'update users set optout="Y" where paypal="'.$emailAddress.'" or email="'.$emailAddress.'"';
    mysql_query($updU, $conn) or die(mysql_error());
}    

$pageContent = '<p>You have opted out of our emails. You will not receive anymore emails
at '.$emailAddress.' </p>
    
<p>Sorry to see you go :-(   </p>';

echo $pageContent; 
?>