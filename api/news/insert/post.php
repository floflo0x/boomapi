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

// Prepare and execute an INSERT query
$sql = "INSERT INTO posts (title,des,image,date) VALUES (?,?,?,?)";
$stmt = $conn->prepare($sql);
$title = $data->title;
$des = $data->des;
$image = $data->image;

$stmt->bind_param("ssss", $title, $des, $image,$currentDate);
$stmt->execute();

// Get the ID of the last inserted row
$last_id = $conn->insert_id;

echo json_encode(array("isSuccess"=>true,"post_id"=>$last_id));

// Close the statement and connection
$stmt->close();

$conn->query("insert into views (post_id,views,date) values ($last_id,0,'$currentDate')");
foreach($data->tags as $tagId){
    $conn->query("insert into tags (post_id,category_id) values ($last_id,$tagId)");
}
$conn->close();

