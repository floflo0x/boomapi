<?php
// Enable error reporting for debugging purposes (can be turned off in production)
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *"); 
$myObj=new stdClass();
$errorMsg='';

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['fileToUpload'])) {
        $targetDirectory = "uploads/"; // Specify the directory where you want to store the uploaded files
      	$imageName=generateRandomString(4).$_FILES['fileToUpload']['name'];
        $targetFile = $targetDirectory . basename($imageName);
      	$imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
        $uploadOk = 1;
      	
      // Check file size
	//if ($_FILES["fileToUpload"]["size"] > 500000) {
     // $errorMsg= "Sorry, your file is too large.";
      //$uploadOk = 0;
    //}

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp"
	&& $imageFileType != "gif" ) {
      $errorMsg= "Sorry, only JPG, JPEG, PNG,WEBP & GIF files are allowed.";
      $uploadOk = 0;
	}
    if ($uploadOk == 0) {
          $myObj->isSuccess=false;
        } else {
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
              	$myObj->isSuccess=true;
                //echo 'File uploaded successfully.';
            } else {
              	$myObj->isSuccess=false;
                $errorMsg= 'Sorry, there was an error uploading your file. Please try again';
            }
        }
    } else {
      	$myObj->isSuccess=false;
        $errorMsg= 'No file uploaded.';
    }
} else {
    $myObj->isSuccess=false;
    $errorMsg= 'Invalid request method.';
}
$myObj->errorMsg=$errorMsg;
$myObj->image=$imageName;

echo json_encode($myObj);
?>
