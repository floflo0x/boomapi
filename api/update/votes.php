<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$curl = curl_init();
$pollId=$_POST['pollId'];
$oId=$_POST['oId'];

curl_setopt_array($curl, array(
  CURLOPT_URL => $queryUrl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('q1' => "UPDATE options set votes=votes+1 where poll_id='$pollId' AND id ='$oId'"),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;