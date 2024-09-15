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

$title = $data->title;
$des = $data->des;
$image = $data->image;
$id = $data->id;

$conn->query("update posts set title='$title', des='$des', image='$image' where id = $id");

$conn->query("delete from tags where post_id=$id");

foreach($data->tags as $tagId){
    $conn->query("insert into tags (post_id,category_id) values ($id,$tagId)");
}

echo json_encode(array("isSuccess"=>true));

$conn->close();
