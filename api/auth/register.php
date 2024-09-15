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

$email = $data->email;
$password = $data->password;
$ip = $data->ip_address;
$name = $data->name;
$image = $data->image;
$rem='';
$sql = "select count(*) as c from users where email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result= $stmt->get_result();
$row= mysqli_fetch_assoc($result);



if($row['c']>=1){
    echo json_encode(array("isSuccess"=>false));
}
else{
    // Prepare and execute an INSERT query
$sql = "INSERT INTO users (email,password,ip_address,name,image,created_at,rem_token) VALUES (?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);


$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$stmt->bind_param("sssssss", $email,$hashedPassword, $ip,$name, $image,$currentDate,$rem);
$stmt->execute();

// Get the ID of the last inserted row
$last_id = $conn->insert_id;

echo json_encode(array("isSuccess"=>true,"user_id"=>$last_id));
}


// Close the statement and connection
$stmt->close();
$conn->close();