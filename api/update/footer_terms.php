<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

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

$t = $data->t;
$name = $data->name;
$description = $data->description;
$id = $data->id;

$conn->query("update $t set name='$name', description='$description' where id = $id");

echo json_encode(array("isSuccess"=>true));

$conn->close();
