<?php

header("Access-Control-Allow-Origin: *");

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// database connectiong
$conn= mysqli_connect($host, $username, $pass,$db);
mysqli_set_charset($conn, "utf8mb4");

$value=$_POST['value'];
$id=$_POST['id'];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if($value==0){ // +1 like
    $query= "update comments set likes=likes+1 where id=$id";
}
else if($value==1){ // -1 like
    $query= "update comments set likes=likes-1 where id=$id";
}
else if($value==2){ // +1 dislike
    $query= "update comments set dislikes=dislikes+1 where id=$id";
}
else if($value==3){ // -1 dislike
    $query= "update comments set dislikes=dislikes-1 where id=$id";
}
else if($value==4){ // +1 like -1 dislike
    $query= "update comments set likes=likes+1, dislikes=dislikes-1 
    where id=$id";
}
else if($value==5){ // +1 dislike -1 like
    $query= "update comments set dislikes=dislikes+1, likes=likes-1
    where id=$id";
}

$conn->query($query);

$conn->close();
