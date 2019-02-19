 <?php
 function pubMqtt($topic,$msg){
       $APPID= "GateControl/"; //enter your appid
     $KEY = "ye7IuXPkeoiw7ik"; //enter your key
    $SECRET = "bZn1dQSMy8goobrSd6F6cr9Qk"; //enter your secret
    $Topic = $topic; 
    put("https://api.netpie.io/microgear/".$APPID.$Topic."?retain&auth=".$KEY.":".$SECRET,$msg);
 
  }
 function getMqttfromlineMsg($Topic,$lineMsg){
 
    $pos = strpos($lineMsg, ":");
	$topic = $Topic;
    $msg = $lineMsg;
	  
    if($pos){
      $splitMsg = explode(":", $lineMsg);
      $topic = $splitMsg[0];
      $msg = $splitMsg[1];
    }
	
	if ($msg = "open"){
		$msg = "1";
	}else{
		$msg = "0";
	}
	 pubMqtt($topic,$msg);
  }
 
  function put($url,$tmsg)
{
      
    $ch = curl_init($url);
 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
     
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $tmsg);
 
    //curl_setopt($ch, CURLOPT_USERPWD, "mJ7K4MfteC7p0dW:pp4gzMhCvJIqlxc66hKEvk46m");
     
    $response = curl_exec($ch);
    
      curl_close($ch);
      echo $response . "\r\n";
    return $response;
}
// $Topic = "NodeMCU1";
 //$lineMsg = "CHECK";
 //getMqttfromlineMsg($Topic,$lineMsg);
?>
