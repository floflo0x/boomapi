<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$curl = curl_init();
$offset=$_POST['offset'];
$filter=$_POST['filter'];

if($filter=='n'){
    $filter="order by id desc";
}
else if($filter=='o'){
    $filter="order by id asc";
}

curl_setopt_array($curl, array(
  CURLOPT_URL => $queryUrl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('q2' => "select count(*) as c from users"),
));
$response = curl_exec($curl);
$json=json_decode($response,true);
$total=$json[0]['c'];

curl_setopt_array($curl, array(
  CURLOPT_URL => $queryUrl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('q2' => "select * from users $filter limit 10 offset $offset"),
));

$response = curl_exec($curl);
$myObj= new stdClass();
$myObj->totalCount=$total;
$myObj->results=json_decode($response,true);


curl_close($curl);
echo json_encode($myObj);

?>