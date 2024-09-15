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
$portraitImage = $data->portrait_image;
$video = $data->video;
$link = $data->link;
$id = $data->id;
$tt = $data->title_translate;
$dt = $data->des_translate;

$conn->query("update posts set title='$title',title_translate='$tt',des_translate='$dt', des='$des', image='$image',portrait_image='$portraitImage', video='$video',link='$link' where id = $id");

$conn->query("delete from tags where post_id=$id");

foreach($data->tags as $tagId){
    $conn->query("insert into tags (post_id,category_id) values ($id,$tagId)");
}

echo json_encode(array("isSuccess"=>true));

$conn->close();
