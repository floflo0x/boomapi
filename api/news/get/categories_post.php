<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$curl = curl_init();
$cId=$_POST['cId'];
$offset=$_POST['offset'];
$filter=$_POST['filter'];

if($filter=='n'){
    $filter="order by p.id desc";
}
else if($filter=='o'){
    $filter="order by p.id asc";
}

curl_setopt_array($curl, array(
  CURLOPT_URL => $queryNewsUrl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('q2' => "select count(*) as c from posts p join tags t on p.id = t.post_id join views v on p.id=v.post_id where t.category_id=$cId $filter"),
));
$response = curl_exec($curl);
$json=json_decode($response,true);
$total=$json[0]['c'];

curl_setopt_array($curl, array(
  CURLOPT_URL => $queryNewsUrl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('q2' => "select p.*,t.category_id,v.views from posts p join tags t on p.id = t.post_id join views v on p.id=v.post_id where t.category_id=$cId $filter limit 15 offset $offset"),
));

$response = curl_exec($curl);
$myObj= new stdClass();
$myObj->totalCount=$total;
$myObj->results=json_decode($response,true);


curl_close($curl);
echo json_encode($myObj);
