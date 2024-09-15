<?php

header("Access-Control-Allow-Origin: *");

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

$array = [];

// sql query
$q1= $_POST['q1']; //queries other than select
$q2= $_POST['q2']; //select query

// database connectiong
$conn= mysqli_connect($host, $username, $pass,$db);
mysqli_set_charset($conn, "utf8mb4");

if($conn){

    if($q1!=null){
        
        // applying query
      $result= mysqli_query($conn, $q1);
    }
   if($q2!=null){
      $r= mysqli_query($conn,$q2);
      while ($row = mysqli_fetch_assoc($r)){
          $array[]=$row;
      }
     echo (json_encode($array));
   }
  
}else{
 echo (mysqli_connect_error());
}

?>