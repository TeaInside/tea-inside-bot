<?php 
$ch = curl_init("https://webhook.teainside.ga/webhook/telegram.php");
curl_setopt_array($ch,[
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_SSL_VERIFYPEER => false,
	CURLOPT_SSL_VERIFYHOST => false,
	CURLOPT_POSTFIELDS => file_get_contents("php://input")
]);
curl_exec($ch);
require __DIR__."/../connector/telegram/webhook.php";