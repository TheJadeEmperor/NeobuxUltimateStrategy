<?php 
//include($dir.'include/config.php'); 
include($dir.'include/ee_api.php'); 

$landingURL = 'http://neobuxultimatestrategy.com/redirect.php?url=ysense';


if($_POST['subscribe']) {

	//NUS list 
	$nusListID = '903f800e-6dda-4294-8cb5-dcdd17390e09';

	//Allsubs list
	$allSubsID = '1e746915-727a-471e-851c-e378daf0e3f5';
	
	$subscriberEmail = $_POST['email']; 
	
	//subscribe here
	$params = array(
		'email' => $subscriberEmail,
		'publiclistid' => $nusListID, 
		'activationReturnUrl' => $landingURL, 
	);
	$result = subscribe_contact($params); 
	//print("<pre>".print_r($result,true)."</pre>");

	//no double optin 
	$params = array(
		'email' => $subscriberEmail,
		'publiclistid' => $allSubsID, 
	);
	$result = add_contact($params); 
	//print("<pre>".print_r($result,true)."</pre>");
	
	$success = $result->success; 
	
	if($success == 1) {
		//echo 'success';
		//redirect to landingURL
		echo '<meta http-equiv="refresh" content="0;url='.$landingURL.'">';
	}
	else { //error
		$error = $result->error;
		$messageID = $result->messageid;
		
		//echo $error.' '.$messageID;
		 
		if($messageID == 'contact_invalid_email') {
			$error = 'Please enter a valid email and try again';
		}
		echo $error; 
		?> 
		<br />
		<button onclick="history.go(-1);">Back</button>
		<?php 
	}
} 
else  if ($_GET['unsub'] == 1) {
	//FUTURE - UNSUBSCRIBE CONTACT
	$list = $_GET['list']; 
	$email = $_GET['email'];
	$consentdate = $_GET['consentdate'];
	echo $list.' '.$email.' '.$consentdate; 
	
	//check if consentdate matches the records 
	
	//delete contact from list 
	
}
else { //no reason to be on this page
	echo "You don't belong here"; 
	?> 
	<br />
	<button onclick="history.go(-1);">Back</button>
	<?php 
}


?>