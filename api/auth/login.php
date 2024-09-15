<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';


$email=$_POST['email'];
$password=$_POST['password'];


// database connectiong
$conn= mysqli_connect($host, $username, $pass,$db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// sql query
$q= "select * from users where email=?";
$stmt = $conn->prepare($q);
$stmt->bind_param("s", $email);
$stmt->execute();

$myObj = new stdClass();

if($conn){
        
        // applying query
    $result= $stmt->get_result();
    if($result!=null){
        
        // selecting data 
       $row= mysqli_fetch_assoc($result);
       
       if(password_verify($password,$row['password'])){
           $myObj->isSuccess = true;
       }
       else{
           $myObj->isSuccess = false;
       }
   
    }else{
         $myObj->isSuccess = false;
    }
}
else{
    $myObj->isSuccess = false;
}
echo json_encode($myObj);

$stmt->close();
$conn->close();
?>