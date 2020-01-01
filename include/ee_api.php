<?php

function ee_api_call($class, $action, $params) {
	
	if(is_array($params)) {
		foreach($params as $key => $val) {
			$urlParams .= '&'.$key.'='.$val;
		}
	}
	
	$url = 'https://api.elasticemail.com/v2/'.$class.'/'.$action.'?apikey='.API_KEY.''.$urlParams;

	$curl = curl_init();

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
	//curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

	$result = curl_exec($curl);	
	$err = curl_error($curl);
	print_r($err);

	$result = json_decode ($result);

	return $result;
}


function ee_send_email($emailData) {
	
	$url = 'https://api.elasticemail.com/v2/email/send?apikey='.API_KEY;
	$curl = curl_init($url);

	curl_setopt($curl, CURLOPT_POST, 0);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

	curl_setopt($curl, CURLOPT_POSTFIELDS, $emailData);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);	
	$response = json_decode($response, true);
	$err = curl_error($curl);
	
	curl_close($curl);

	return $response;
} 


function delete_contact($params) {

	$result = ee_api_call('contact', 'delete', $params); 	
	return $result;
}


function add_contact($params) {
	
	$params = array(
		'email' => $params['email'],
		'publicAccountID' => PUBLIC_ACCOUNT_ID,
		'publiclistid' => $params['publiclistid'], 
		//false=single opt in, true = double opt in
		'sendActivation' => false 
	);
	$result = ee_api_call('contact', 'add', $params); 	
	return $result; 
}


function subscribe_contact($params) {
	
	$params = array(
		'email' => $params['email'],
		'publicAccountID' => PUBLIC_ACCOUNT_ID,
		'publiclistid' => $params['publiclistid'], 
		//false=single opt in, true = double opt in
		'sendActivation' => true 
	);
	$result = ee_api_call('contact', 'add', $params); 	
	return $result; 
}


function parse_variables_html($html) {
	
	$html = str_replace('**NAME**', 'PTC User', $html);
	
	$html = str_replace('**SIG_EMAIL**', 'contact@bestpayingsites.com', $html);

	return $html; 
}



?>