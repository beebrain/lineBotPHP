<?php // callback.php
require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');

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
			//mqttpub("/gate/",$text);
			echo $result . "\r\n";
			
		}
	}
}
echo "OK";
?>
<!--
<script src="jquery-1.11.3.min.js"></script>
<script src="mqttws31.js"></script>

<script>
var config = {
	mqtt_server: "m16.cloudmqtt.com",
	mqtt_websockets_port: 37089,
	mqtt_user: "bee",
	mqtt_password: "great1234"
};

$(document).ready(function(e) {
	// Create a client instance
	client = new Paho.MQTT.Client(config.mqtt_server, config.mqtt_websockets_port, "web_" + parseInt(Math.random() * 100, 10)); 
	//Example client = new Paho.MQTT.Client("m11.cloudmqtt.com", 32903, "web_" + parseInt(Math.random() * 100, 10));
	
	// connect the client
	client.connect({
		useSSL: true,
		userName: config.mqtt_user,
		password: config.mqtt_password,
		onSuccess: function() {
			// Once a connection has been made, make a subscription and send a message.
			// console.log("onConnect");
			$("#status").text("Connected").removeClass().addClass("connected");
			client.subscribe("/gate/");
			mqttSend("/gate/", "OPEN");
		},
		onFailure: function(e) {
			console.log(e);
		}
	});
	
	
	
	
});

function close(){
client.disconnect();
}
var mqttSend = function(topic, msg) {
	var message = new Paho.MQTT.Message(msg);
	message.destinationName = topic;
	client.send(message); 
}
</script> -->