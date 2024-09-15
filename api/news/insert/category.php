<?php
header('Access-Control-Allow-Origin: *');

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// database connectiong
$conn= mysqli_connect($host, $username, $pass,$db);
mysqli_set_charset($conn, "utf8mb4");

$name=$_POST['name'];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->query("insert into category (name) values ('$name')");

echo json_encode(array("isSuccess"=>true));

$conn->close();

