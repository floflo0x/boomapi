<?php

header("Access-Control-Allow-Origin: *");

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// database connectiong
$conn= mysqli_connect($host, $username, $pass,$db);
mysqli_set_charset($conn, "utf8mb4");

$startDate=$_POST['startDate'];
$endDate=$_POST['endDate'];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "select ROUND(AVG(views), 2) as avg,date from views where date between ? and ? group by date";
$stmt = $conn->prepare($sql);

$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$result= $stmt->get_result();


while ($row = $result->fetch_assoc()){
          $array[]=$row;
      }
     echo (json_encode($array));

// Close the statement and connection
$stmt->close();
$conn->close();
