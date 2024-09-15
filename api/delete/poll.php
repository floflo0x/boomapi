<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// database connectiong
$conn= mysqli_connect($host, $username, $pass,$db);
mysqli_set_charset($conn, "utf8mb4");
$id=$_POST['id'];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute an INSERT query
$sql = "delete from options where poll_id=?";
$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);
$stmt->execute();

$sql = "delete from poll where id=?";
$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

echo json_encode(array("isSuccess"=>true));

// Close the statement and connection
$stmt->close();

$conn->close();