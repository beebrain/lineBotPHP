<?php // callback.php
 require("pub.php");
require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');
	require("phpmatt.php");
	
	
$Topic = "gate" ;

function mqttpub($Topic="gate",$msg){
	

$server = "mqtt.example.com";     // change if necessary
$port = 37089;                     // change if necessary
$username = "bee";                   // set your username
$password = "great1234";                   // set your password
$client_id = "mqttLine_connect"; // make sure this is unique for connecting to sever - you could use uniqid()

$mqtt = new bluerhinos\phpMQTT($server, $port, "ClientID".rand());

if ($mqtt->connect(true,NULL,$username,$password)) {
  $mqtt->publish("/gate/",$message, 0);
  $mqtt->close();
}else{
  echo "Fail or time out";
}
}

$access_token = '09hPKMB6Ww68KbPUGvXrGg25g42qFZsANdnOssQ26F4ldpCDINz8KsNNrD5cznqMTJ7Wu1KHxQ9E8THiccaC+mjKLdQYIoXEknO2fOmVkEIXpUILyU6JyQNSnwHnMFMC9pED0MGuOblkjM3P6t5odQdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			mqttpub("/gate/",$text);
			echo $result . "\r\n";
			
		}
	}
}

echo "OK Bee";