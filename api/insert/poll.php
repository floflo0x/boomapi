<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// database connectiong
$conn= mysqli_connect($host, $username, $pass,$db);
mysqli_set_charset($conn, "utf8mb4");

$data= json_decode(file_get_contents('php://input'));
date_default_timezone_set('America/New_York');

$date = new DateTime();
$currentDate= $date->format('Y-m-d');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute an INSERT query
$sql = "INSERT INTO poll (portrait_image,landscape_img,question,ques_translate,answer) VALUES (?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$pImg = $data->pImg;
$lImg = $data->lImg;
$question = $data->question;
$ques_tr = $data->ques_tr;
// $options = $data->options;
$answer = $data->answer;

$stmt->bind_param("sssss", $pImg, $lImg, $question, $ques_tr, $answer);
$stmt->execute();

// Get the ID of the last inserted row
$last_id = $conn->insert_id;

echo json_encode(array("isSuccess"=>true,"post_id"=>$last_id));

// Close the statement and connection
$stmt->close();

foreach($data->options as $opId){
	$conn->query("insert into options (poll_id,option_text,votes,date) values ($last_id,'$opId',0,'$currentDate')");
  	// echo $opId;
}

$conn->close();

