 <?php
  

function send_LINE($msg){
 $access_token = 'ALPkDPxL0IeyXrTkJmwwYyfRSGsRp4HCK2BHdwNtSUl21oCdgrX2o3zkeGU0yv9eTJ7Wu1KHxQ9E8THiccaC+mjKLdQYIoXEknO2fOmVkEJxt5nNqXHnJcbJcgePqyVhSWs5ZL9muLlulOa7xAg1IQdB04t89/1O/w1cDnyilFU='; 

  $messages = [
        'type' => 'text',
        'text' => "BEEEEE"
        //'text' => $text
      ];

      // Make a POST Request to Messaging API to reply to sender
      $url = 'https://api.line.me/v2/bot/message/push';
      $data = [

        'to' => 'Uabf6ae83f9b44fec0a7ff7c1ab0eca4f',
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

      echo $result . "\r\n"; 
}

?>
