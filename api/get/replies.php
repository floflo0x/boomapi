<?php

header("Access-Control-Allow-Origin: *");
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$curl = curl_init();
$commId=$_POST['commId'];
$offset=$_POST['offset'];

curl_setopt_array($curl, array(
  CURLOPT_URL => $queryUrl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('q2' => "select r.*,u.name,u.image from replies r join users u on r.user_id=u.id where r.comm_id=$commId limit 5 offset $offset"),
));

$response = curl_exec($curl);

curl_close($curl);

date_default_timezone_set('America/New_York');
$date = new DateTime();
// Get the current timestamp (seconds since Unix epoch)
$timestamp = $date->getTimestamp();

$myObj= new stdClass();
$myObj->usaTimestamp=$timestamp;
$myObj->results=json_decode($response,true);

echo json_encode($myObj);