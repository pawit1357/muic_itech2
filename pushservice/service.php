<?php

$app_id =0; //$_GET['app_id'];
$deviceToken = $_GET['token'];
$message = $_GET['msg'];

// echo $app_id .','.$deviceToken.','.$message;

if(!(!isset($app_id) || trim($app_id)==='') &&
		!(!isset($message) || trim($message)==='') &&
		!(!isset($deviceToken) || trim($deviceToken)===''))
{
	$cert = '';
	switch($app_id)
	{
		case 0:
			/* MUIC APP V.1 */
			// = 'aps-development.pem';
			$cert = 'ck.pem';
			break;
		case 1:
			$cert = 'ck-life.pem';
			break;
		case 2:
			$cert = 'ck-sph.pem';
			break;
		case 3:
			$cert = 'ck-house.pem';
			break;
		case 4:
			$cert = 'ck-lib.pem';
			break;
	}
	$passphrase = 'password';

	$ctx = stream_context_create();
	stream_context_set_option($ctx, 'ssl', 'local_cert', $cert);
	stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

	// Open a connection to the APNS server
	$fp = stream_socket_client(
			'ssl://gateway.sandbox.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

	if (!$fp)
		exit("Failed to connect: $err $errstr" . PHP_EOL);

	//echo 'Connected to APNS' . PHP_EOL;

	// Create the payload body
	$body['aps'] = array(
			'url' =>'http://www.muic.mahidol.ac.th/eng/',
			'alert' => $message,
			'sound' => 'default',
			'badge' => 1,
	);

	// Encode the payload as JSON
	$payload = json_encode($body);

	$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

	// Send it to the server
	$result = fwrite($fp, $msg, strlen($msg));
	if(result){
		//echo 'push notification have sending';
	}
	flush();
	fclose($fp);
}


////////////////////////////////////////////////////////////////////////////////
?>