<?php
$transID = $_GET['id'];

//check for transaction in db
$selS = 'select *, date_format(purchased, "%m/%d/%Y") as salesDate,
date_format(expires, "%m/%d/%Y") as expiresDate from sales where transID = "'.$_GET[id].'"
and productID="'.$productID.'"';
$resS = mysql_query($selS, $conn) or die(mysql_error()); 

$sales = mysql_num_rows($resS);

if($s = mysql_fetch_assoc($resS)) {
    $firstName = $s[firstName];
    $lastName = $s[lastName];
    $salesDate = $s[salesDate];  
    $expiresDate = $s[expiresDate];
    $payerEmail = $s[payerEmail];
    
    if(!isset($expiresDate))
        $expiresDate = $salesDate; 
}

if($oto == 'Y' && !$_POST[skipOTO]) //one time offer 
{
    $fileName = 'oto.html';
}
else
{
    if($sales > 0) //valid sale
    {
        //check for expiration date
        $today = time(); 
        $expiresDate = strtotime($expiresDate); 
        $expireSeconds = $expires * 60 * 60; 
		
        if($transID == 'vipuser') //no expiration date for VIP user
        {
            $today = 0;
            $expiresDate = 0;
        }
		
        if(($today) <= ($expiresDate + $expireSeconds))
        {
            //check for existing account
            $selU = 'select * from users where email="'.$payerEmail.'" or paypal="'.$payerEmail.'"';
            $resU = mysql_query($selU, $conn) or die(mysql_error());
            
            if(mysql_num_rows($resU) == 0) //no account exists
            {
                //generate random password
                $password = genString(8);
                
                //insert email & password into db
                $ins = 'insert into users (
                paypal,
                email,
                password,
                joinDate
                ) values (
                "'.$payerEmail.'",
                "'.$payerEmail.'",
                "'.$password.'",
                now() )';
            
                mysql_query($ins, $conn) or die(mysql_error());
            }
            else //existing account 
            {
                $u = mysql_fetch_assoc($resU); 
                
                $password = $u[password];
            } 
            
            //multiple downloads
            $selD = 'select * from downloads where productID="'.$productID.'" order by name';
            $resD = mysql_query($selD) or die(mysql_error());
            
            if(mysql_num_rows($resD) > 0)
            {
                $downloadContent = '<table>';
                while($d = mysql_fetch_assoc($resD))
                {
                    $downloadContent .= '<tr>
                    <td>'.$d[name].'</td>
                    <td><form method=post><input type=submit name=dl value="Download"/>
                        <input type=hidden name=url value="'.$d[url].'" /></form>
                    </td>';
                }    
                $downloadContent .= '</table>';
            }
            
            $fileName = 'download.html';
        } 
        else 
		{
            $fileName = 'expired.html';
        }
    }
    else //invalid sale
    {
        $fileName = 'invalid.html';
    }
}       
include($fileName); 
?>