<?php

header('Access-Control-Allow-Origin: *');

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$curl = curl_init();
$filter=$_POST['filter'];

date_default_timezone_set('America/New_York');

$date = new DateTime();
$currentDate= $date->format('Y-m-d');

if($filter=="w"){
    $date->sub(new DateInterval('P7D'));
}
else if($filter=="m"){
    $date->sub(new DateInterval('P1M'));
}
else if($filter=="y"){
    $date->sub(new DateInterval('P1Y'));
}
$date= $date->format('Y-m-d');

curl_setopt_array($curl, array(
  CURLOPT_URL => $queryNewsUrl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('q2' => "select p.*,v.views from views v join posts p on p.id = v.post_id where v.date BETWEEN '$date' AND '$currentDate' order by v.views desc limit 20"),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
