<?php
$transID = $_GET['id'];

//check for transaction in db
$selS = 'SELECT *, date_format(purchased, "%m/%d/%Y") AS salesDate,
date_format(expires, "%m/%d/%Y") AS expiresDate FROM sales WHERE transID = "'.$_GET['id'].'" AND productID="'.$productID.'"';
$resS = $conn->query($selS);

$sales = mysqli_num_rows($resS);

if($s = $resS->fetch_array()) {
    $firstName = $s['firstName'];
    $lastName = $s['lastName'];
    $salesDate = $s['salesDate'];  
    $expiresDate = $s['expiresDate'];
    $payerEmail = $s['payerEmail'];
 
    if(!isset($expiresDate))
        $expiresDate = $salesDate; 
}

if($oto == 'Y' && !$_POST['skipOTO']) { //one time offer 
    $fileName = 'oto.html';
}
else {
    if($sales > 0) { //valid sale
        //check for expiration date
        $today = time(); 
        $expiresDate = strtotime($expiresDate); 
        $expireSeconds = $expires * 60 * 60; 
		
        if($transID == 'vipuser') { //no expiration date for VIP user 
            $today = 0;
            $expiresDate = 0;
        }
        
        if(($today) <= ($expiresDate + $expireSeconds)) { 
            //check for existing account
            $selU = 'SELECT * FROM users WHERE email="'.$payerEmail.'" OR paypal="'.$payerEmail.'"';
            $resU = $conn->query($selU);
          
            if(mysqli_num_rows($resU) == 0) { //no account exists
           
                //generate random password
                $password = genString(8);
                
                //insert email & password into db
                $insI = 'insert into users (
                paypal,
                email,
                password,
                joinDate
                ) values (
                "'.$payerEmail.'",
                "'.$payerEmail.'",
                "'.$password.'",
                now() )';

                $resI = $conn->query($insI);
            }
            else  { //existing account 
           
                $u = $resU->fetch_array(); 
              
                $password = $u['password'];
            } 
            
            //multiple downloads
            $selD = 'SELECT * FROM downloads WHERE productID="'.$productID.'" ORDER BY name';
            $resD = $conn->query($selD);
           
            if(mysqli_num_rows($resD) > 0) {
                $downloadContent = '<table>';
                while($d = mysql_fetch_assoc($resD))  {
                    $downloadContent .= '<tr>
                    <td>'.$d['name'].'</td>
                    <td>
                    <form method="post"><input type="submit" name="dl" value="Download"/>
                    <input type="hidden" name="url" value="'.$d['url'].'" />
                    </form>
                    </td>';
                }    
                $downloadContent .= '</table>';
            }
            echo __LINE__.' ';
            $fileName = 'download.html';
        } 
        else {
            $fileName = 'expired.html';
        }
    }
    else  { //invalid sale
  
        $fileName = 'invalid.html';
    }
}       
include($fileName); 
?>