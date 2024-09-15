<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $queryNewsUrl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('q2' => "select p.*,t.category_id,v.views from posts p join tags t on p.id = t.post_id join views v on p.id=v.post_id where t.category_id=2 order by p.id desc limit 4"),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;