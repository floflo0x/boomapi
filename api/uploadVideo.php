<?php
header("Access-Control-Allow-Origin: *"); // Allow all origins, or specify a single origin like 'https://example.com'
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

$uploadDirectory = 'uploads/';

// Check if the upload directory exists, if not, create it
if (!is_dir($uploadDirectory)) {
    mkdir($uploadDirectory, 0755, true);
}

// Check if a file was uploaded
if (isset($_FILES['video'])) {
    $file = $_FILES['video'];
    
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die('File upload error: ' . $file['error']);
    }

    // Get the file extension and check if it's a video
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $allowedExtensions = ['mp4', 'avi', 'mov', 'mkv']; // Add more as needed
    if (!in_array($fileExtension, $allowedExtensions)) {
        $myObj->isSuccess=false;
        $myObj->errorMsg="Invalid file type. Only video files are allowed.";
    }

    // Generate a unique file name to prevent overwriting
    
    $uniqueFileName = generateRandomString(8) . $file['name'];
    $destination = $uploadDirectory . $uniqueFileName;

    // Move the file to the upload directory
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        $myObj->isSuccess=true;
        $myObj->video=$uniqueFileName;
    } else {
        $myObj->isSuccess=false;
        $myObj->errorMsg='Failed to move the uploaded file';
    }
} else {
    $myObj->isSuccess=false;
    $myObj->errorMsg='No file was uploaded';
}

echo json_encode($myObj);
?>
