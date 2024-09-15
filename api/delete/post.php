<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// database connectiong
$conn= mysqli_connect($host, $username, $pass,$db);
mysqli_set_charset($conn, "utf8mb4");
$id=$_POST['id'];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute an INSERT query
$sql = "delete from posts where id=?";
$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $id);
$stmt->execute();

$sql = "delete from tags where post_id=?";
$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $id);
$stmt->execute();

echo json_encode(array("isSuccess"=>true));

// Close the statement and connection
$stmt->close();

$conn->close();

