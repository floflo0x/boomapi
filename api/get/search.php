<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$curl = curl_init();
$s=$_POST['s'];


curl_setopt_array($curl, array(
  CURLOPT_URL => $queryUrl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('q2' => "select * from posts where title like '%$s%' limit 15"),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
