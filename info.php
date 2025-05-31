<?php
$from = "PROBIYNAH";
$messageId = "PROBIYNAH";

$username = "probiynah";
$password = "Probiyn@h2023";

$postUrl = "https://dmn65v.api.infobip.com/sms/1/text/advanced";
                        
// creation d'objet d'envoie d'sms
$destination = array("messageId" => $messageId,
"to" => $to);

$message = array("from" => $from,
"destinations" => array($destination),
"text" => $text);

$postData = array("messages" => array($message));
$postDataJson = json_encode($postData);
$ch = curl_init();
$header = array("Content-Type:application/json", "Accept:application/json");

curl_setopt($ch, CURLOPT_URL, $postUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// response of the POST request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$responseBody = json_decode($response);
curl_close($ch);
?>
