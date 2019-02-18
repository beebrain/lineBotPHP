<?php // callback.php
 require("pub.php");
require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');


function sendQuickReply(){
 $payload = [
    {
      "type": "text",
      "text": "Hello Quick Reply!",
      "quickReply": {
        "items": [
          {
            "type": "action",
            "imageUrl": "https://cdn1.iconfinder.com/data/icons/mix-color-3/502/Untitled-1-512.png",
            "action": {
              "type": "message",
              "label": "Message",
              "text": "Hello World!"
            }
            }
        ]
      }
    }
   ]
   return $payload;
}

$access_token = '09hPKMB6Ww68KbPUGvXrGg25g42qFZsANdnOssQ26F4ldpCDINz8KsNNrD5cznqMTJ7Wu1KHxQ9E8THiccaC+mjKLdQYIoXEknO2fOmVkEIXpUILyU6JyQNSnwHnMFMC9pED0MGuOblkjM3P6t5odQdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
	// Get text sent
			if ($msg == ""){
			$text = $event['message']['text'];
			}else{
				$text = $msg;
			}
			// Get replyToken
			$replyToken = $event['replyToken'];

			// Build message to reply back
			$payload = [
				'type' => 'text',
				'text' => $text
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [sendQuickReply()],
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
			echo $result . "\r\n";
			
			
			// pub
		
		}
	}
}


echo "OK";
