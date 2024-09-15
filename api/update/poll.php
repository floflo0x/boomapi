<?php
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

$pImg = $data->pImg;
$lImg = $data->lImg;
$question = $data->question;
$ques_tr = $data->ques_tr;
// $options = $data->options;
$answer = $data->answer;
$id = $data->id;

$conn->query("update poll set portrait_image='$pImg', landscape_img='$lImg', question='$question', ques_translate='$ques_tr', answer=$answer where id = $id");

$conn->query("delete from options where poll_id=$id");

foreach($data->options as $opId){
	$conn->query("insert into options (poll_id,option_text,votes,date) values ($id,'$opId',0,'$currentDate')");
}

echo json_encode(array("isSuccess"=>true));

$conn->close();
