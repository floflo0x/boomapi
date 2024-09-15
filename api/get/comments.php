<?php

header("Access-Control-Allow-Origin: *");
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$curl = curl_init();
$postId=$_POST['postId'];
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
  CURLOPT_POSTFIELDS => array('q2' => "select c.*,u.name,u.image from comments c join users u on c.user_id=u.id where c.post_id=$postId limit 5 offset $offset"),
));

$response = curl_exec($curl);
$json= json_decode($response,true);


//echo "select count(*) as c from replies where comm_id=$commId limit 1";
$x=0;
foreach($json as $comment){
  $commId=$comment['id'];
  
  curl_setopt_array($curl, array(
  CURLOPT_URL => $queryUrl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('q2' => "select count(*) as c from replies where comm_id=$commId limit 1"),
));

$response = curl_exec($curl);
  //echo $response;
  $comment['replies']=json_decode($response,true)[0]['c'];
  $json[$x]=$comment;
  $x++;
}

curl_close($curl);

date_default_timezone_set('America/New_York');
$date = new DateTime();
// Get the current timestamp (seconds since Unix epoch)
$timestamp = $date->getTimestamp();

$myObj= new stdClass();
$myObj->usaTimestamp=$timestamp;
$myObj->results=$json;

echo json_encode($myObj);