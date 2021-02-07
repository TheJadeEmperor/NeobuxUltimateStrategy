<?php
$transID = $_GET['id']; 

//check for transaction in db
$selS = 'SELECT *, date_format(purchased, "%m/%d/%Y") AS salesDate,
date_format(expires, "%m/%d/%Y") AS expiresDate FROM sales WHERE transID = "'.$_GET['id'].'"
AND productID="'.$productID.'"';
$resS = $conn->query($selS);

$sales = $resS->num_rows;

if($s = $resS->fetch_array()) {
    $firstName = $s['firstName'];
    $lastName = $s['lastName'];
    $salesDate = $s['salesDate'];  
    $expiresDate = $s['expiresDate'];
    $payerEmail = $s['payerEmail'];
    
    if(!isset($expiresDate)) //no expiration date set
        $expiresDate = $salesDate; 
}

if($otoPage && !$_POST['skipOTO']) { //upsell 
    $fileName = $otoPage;
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
             
            if($resU->num_rows == 0) { //no user account exists
           
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
                    <td>'.$d['name'].'</td>
                    <td><form method="POST"><input type="submit" name="dl" value="Download" />
                        <input type="hidden" name="url" value="'.$d['url'].'" /></form>
                    </td>';
                }    
                $downloadContent .= '</table>';
            }
            
            //$fileName = 'download.html';
            $fileName = $downloadPage;
        }  
        else { //past expiration date
            $fileName = 'expired.html';
        } 
    } //if($sales > 0)
    else { //invalid sale
        $fileName = 'invalid.html';
    }
}  
//echo $fileName;

include($fileName); 
?>