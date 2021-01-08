<?php
$transID = $_GET['id']; 

//check for transaction in db
$selS = 'select *, date_format(purchased, "%m/%d/%Y") as salesDate,
date_format(expires, "%m/%d/%Y") as expiresDate from sales where transID = "'.$_GET['id'].'"
and productID="'.$productID.'"';
$conn->query($selS);

$sales = $resS->num_rows;

if($s = $resS->fetch_array()) {
    $firstName = $s['firstName'];
    $lastName = $s['lastName'];
    $salesDate = $s['salesDate'];  
    $expiresDate = $s['expiresDate'];
    $payerEmail = $s['payerEmail'];
    
    if(!isset($expiresDate))
        $expiresDate = $salesDate; 
}

if($oto == 'Y' && !$_POST['skipOTO']) { //upsell 
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
            $opt = array(
                'tableName' => 'users',
                'cond' => 'WHERE email="'.$payerEmail.'" OR paypal="'.$payerEmail.'"'
            );           
            $resU = dbSelectQuery($opt);
             
            if($resU->num_rows == 0) { //no account exists
           
                //generate random password
                $password = genString(8);
                
                //insert email & password into db
                $opt = array(
                    'tableName' => 'users',
                    'dbFields' => array(
                        'paypal' => $payerEmail,
                        'email' => $payerEmail,
                        'password' => $password,
                        'joinDate' => 'now()'
                    )
                );
               
                dbInsert($opt);
            }
            else { //existing account 
                //$u = mysql_fetch_assoc($resU); 
                $u = $resU->fetch_assoc();
                $password = $u['password'];
            } 
            
            $opt = array(
                'tableName' => 'downloads',
                'cond' => 'WHERE productID="'.$productID.'" ORDER BY name'
            ); 
            
            $resD = dbSelectQuery($opt);
            
            if($resD->num_rows > 0) {
                $downloadContent = '<table>';
                while($d = $resD->fetch_assoc()) {
                    $downloadContent .= '<tr>
                    <td>'.$d[name].'</td>
                    <td><form method="POST"><input type="submit" name="dl" value="Download" />
                        <input type="hidden" name="url" value="'.$d[url].'" /></form>
                    </td>';
                }    
                $downloadContent .= '</table>';
            }
            
            $fileName = 'download.html';
        } 
        else {
            $fileName = 'expired.html';
        }
    }
    else { //invalid sale
        $fileName = 'invalid.html';
    }
}  
//echo __LINE__.' ';

//echo $fileName;
include($fileName); 
?>