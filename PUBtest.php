<?php // callback.php
 require("pub.php");
require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');
	require("phpmqtt.php");
	
	
$Topic = "gate" ;

function mqttpub($Topic="gate",$msg){
	

$server = "m16.cloudmqtt.com";     // change if necessary
$port = 37089;                     // change if necessary
$username = "bee";                   // set your username
$password = "great1234";                   // set your password
$client_id = uniqid(); // make sure this is unique for connecting to sever - you could use uniqid()

$mqtt = new bluerhinos\phpMQTT($server, $port, "ClientID".rand());

if ($mqtt->connect(true,NULL,$username,$password)) {
  $mqtt->publish("/gate/",$message, 0);
  $mqtt->close();
  echo "send";
}else{
  echo "Fail or time out";
}
}
mqttpub("/gate/","CLOSE");
echo "OK Bee";