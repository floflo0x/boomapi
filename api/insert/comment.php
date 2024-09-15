<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// database connectiong
$conn= mysqli_connect($host, $username, $pass,$db);
mysqli_set_charset($conn, "utf8mb4");

$data= json_decode(file_get_contents('php://input'));
date_default_timezone_set('America/New_York');

$date = new DateTime();
$currentDate= $date->format('Y-m-d H:i:s');
// Get the current timestamp (seconds since Unix epoch)
$timestamp = $date->getTimestamp();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute an INSERT query
$sql = "INSERT INTO comments (user_id,post_id,text,likes,dislikes,date) VALUES (?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$userId = $data->userId;
$postId = $data->postId;
$text = $data->text;
$likes = 0;
$dislikes = 0;

$stmt->bind_param("sssiis", $userId,$postId, $text, $likes, $dislikes,$timestamp);
$stmt->execute();

// Get the ID of the last inserted row
$last_id = $conn->insert_id;
$result=$conn->query("select c.*,u.name,u.image from comments c join users u on c.user_id=u.id where c.id=$last_id");
while ($row = $result->fetch_assoc()){
  $row['replies']=0;
  $array[]=$row;
}
date_default_timezone_set('America/New_York');
$date = new DateTime();
// Get the current timestamp (seconds since Unix epoch)
$timestamp = $date->getTimestamp();
echo json_encode(array("isSuccess"=>true,"usaTimestamp"=>$timestamp,"result"=>$array));


// Close the statement and connection
$stmt->close();
$conn->close();
