<?php
include('adminCode.php');

$dbFields = array(
	'fromEmail' => $_POST['fromEmail'], 
	'fromName' => $_POST['fromName'], 
	'smtpHost' => $_POST['smtpHost'], 
	'smtpPass' => $_POST['smtpPass'],
	'adminEmail' => $_POST['adminEmail'],
	'adminFrom' => $_POST['adminFrom'], 
	'paypalEmail' => $_POST['paypalEmail'],
	'paypalOrderLink' => $_POST['paypalOrderLink'], 
	'usePaypalOrderLink' => $_POST['usePaypalOrderLink'], 
	'websiteURL' => $_POST['websiteURL'], 
	'websiteName' => $_POST['websiteName'], 
	'businessName' => $_POST['businessName']
);

if($_POST['update']) {
    $updA = 'UPDATE settings SET setting="'.$_POST['adminUser'].'" WHERE opt="adminUser"';
    $conn->query($updA);
    
    $updB = 'UPDATE settings SET setting="'.$_POST['adminPass'].'" WHERE opt="adminPass"';
    $conn->query($updB);

    foreach($dbFields as $fld => $set) {
        $upd = 'UPDATE settings SET setting="'.$set.'" WHERE opt="'.$fld.'"';
        $conn->query($upd);
    }
}


$resS = getSettings();
while($s = $resS->fetch_array()) {
    $val[$s['opt']] = $s['setting'];
}


$properties = 'class="activeField" size="40"';

?>
<form method="POST">

<div class="left">
	<div class="moduleBlue"><h1>SMTP Email Settings (For mass emails)</h1>
	<div class="moduleBody">
    
    <table class="formField">
    <tr title="fromEmail">
        <td> From Email: </td>
        <td>
            <div title="header=[SMTP From Email] body=[Email account used to send mass emails from]">
				<img src="<?=$helpImg?>" />
				<input <?=$properties?> name="fromEmail" value="<?=$val['fromEmail']?>">
            </div>
        </td>
    </tr>
    <tr title="fromName">
        <td> From Name: </td>
        <td>
            <div title="header=[SMTP From Name] body=[Email name used to send mass emails from]">
                <img src="<?=$helpImg?>" />
                <input <?=$properties?> name="fromName" value="<?=$val['fromName']?>">
            </div>
    	</td>
    </tr>
    <tr title="smtpHost">
        <td> SMTP Host: </td>
        <td>
            <div title="header=[SMTP Host] body=[Hostname of your email server, please consult your email provider for this]">
                <img src="<?=$helpImg?>" />
                <input <?=$properties?> name="smtpHost" value="<?=$val['smtpHost']?>">
            </div>
    	</td>
    </tr>
    <tr title="smtpPass">
        <td> SMTP Password: </td>
        <td>
            <div title="header=[SMTP Password] body=[Password of your email server, please consult your email provider for this]">
                <img src="<?=$helpImg?>" />
                <input type="password" <?=$properties?> name="smtpPass" value="<?=$val['smtpPass']?>">
            </div>
    	</td>
    </tr>
    </table>
    </div>
    </div>
    <br /><br />
    
	<div class="moduleBlue"><h1>Email Addresses</h1>
	<div class="moduleBody">
	    <table class="formField">
	    <tr title="Support Email">
	        <td> Support Email: </td>
	        <td>
	        	<div title="header=[Support Email] body=[This is the contact email or the download email and welcome emails will be sent from this address ] ">
	            	<img src="<?=$helpImg?>" />
	            	<input <?=$properties?> name="adminEmail" value="<?=$val['adminEmail']?>" />
	        	</div>
	    	</td>
	    </tr>
	    <tr title="From Name">
	        <td> From Name:  </td>
	        <td>
	        	<div title="header=[From Name] body=[The name associated with the Support Email]">
	        		<img src="<?=$helpImg?>" />
	        		<input <?=$properties?> name="adminFrom" value="<?=$val['adminFrom']?>" />
	        	</div>
	        </td>
		</tr>
	    <tr>
	        <td> Paypal Email: </td>
	        <td>
	        	<div title="header=[Paypal Email Account] body=[Very important! This is where you will be receiving payments, make sure this is correct]">
	        		<img src="<?=$helpImg?>" />
	        		<input <?=$properties?> name="paypalEmail" value="<?=$val['paypalEmail']?>">
	    	</td>
	    </tr>
	    <tr>
	        <td> Paypal Order Link: </td>
	        <td>
	        	<div title="header=[Paypal Email Account] body=[Very important! This is where you will be receiving payments, make sure this is correct]">
	        		<img src="<?=$helpImg?>" />
	        		<input <?=$properties?> name="paypalOrderLink" value="<?=$val['paypalOrderLink']?>">
	    	</td>
	    </tr>
	    <tr>
	        <td> Use Paypal Order Link: </td>
	        <td>
				<?php
				$select[ $val['usePaypalOrderLink'] ] = 'selected';
				
				$allOptions = array(
					'1' => 'Yes', 
					'0' => 'No');
				
				foreach ($allOptions as $thisVal => $thisOpt) {
					$displayOptions .= '<option value="'.$thisVal.'" '.$select[$thisVal].'>'.$thisOpt.'</option>';
				}
				?>
							
	        	<div title="header=[Use Paypal Order Link?] body=[If this is turned off, you need to set the order links for all products]">
	        		<img src="<?=$helpImg?>" />
	        		
					<select name="usePaypalOrderLink">
						 <?=$displayOptions?>
					</select>
	    	</td>
	    </tr>
	    </table>
    </div>
    </div>
</div>

<p>&nbsp;</p>

<div class="right">

	<div class="moduleBlue"><h1>Admin Account</h1>
    <div class="moduleBody">
        <table>
	    <tr>
	        <td>Username: </td>
	        <td>
				<div title="header=[Admin Username] body=[This is what you use to log into the admin area]">
					<img src="<?=$helpImg?>" />
					<input <?=$properties?> name="adminUser" value="<?=$val['adminUser']?>" size=30>
				</div>
        	</td>
	    </tr>
		<tr>
	        <td>Password: </td>
	        <td>
				<div title="header=[Admin Password] body=[This is what you use to log into the admin area]">
					<img src="<?=$helpImg?>" />
					<input type="password" <?=$properties?> name="adminPass" value="<?=$val['adminPass']?>" size=30>
				</div>
			</td>
	    </tr>
        </table>
    </div>
    </div>
	    
    <br /><br />
		
    <div class="moduleBlue"><h1>Website Settings</h1>
	<div class="moduleBody">
	    <table>
	    <tr>
	        <td> Website URL: </td>
	        <td>
	        	<div title="header=[Website URL] body=[URL of this website <br />
	                ex: www.domain.com <br> Only put the top level domain] ">
	                <img src="<?=$helpImg?>" />
	        		<input <?=$properties?> name="websiteURL" value="<?=$val['websiteURL']?>">
        		</div>
    		</td>
	    </tr>
	    <tr>
	        <td> Website Name: </td>
	        <td>
	        	<div title="header=[Name of website] body=[What is the name of your website?]">
	                <img src="<?=$helpImg?>" />
	        		<input <?=$properties?> name="websiteName" value="<?=$val['websiteName']?>">
        		</div>
        	</td>
	    </tr>
	    <tr>
	        <td> Business Name: </td>
	        <td>
	        	<div title="header=[Name of your business] body=[This name will be used in several pages of the website, including the affiliate registration page and members area pages]" >
	        		<img src="<?=$helpImg?>" />
	        		<input <?=$properties?> name="businessName" value="<?=$val['businessName']?>">
	        	</div>
        	</td>
	    </tr>
	    </table>
    </div>
	</div>
</div>

<div class="clear"></div>
		
<br />
<center>	
	<input type="submit" name="update" value=" Save Settings " class="btn btn success" />
</center>
</form>

<p>&nbsp;</p>
<p>&nbsp;</p>

<?php
include('adminFooter.php');  ?>