<?php
header('Access-Control-Allow-Origin: *');

$curl = curl_init();

$code=$_GET['code'];

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://oneupload.to/api/file/direct_link?key=2871mnoaakdh9zv4rzcx&file_code=$code&q=n",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
