<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include('smtp/PHPMailerAutoload.php');

$receiver=$_POST['receiver'];
$subject=$_POST['subject'];
$msg=$_POST['msg'];

echo smtp_mailer($receiver,$subject,$msg);
function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(); 
 //	$mail->SMTPDebug=3;
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'ssl'; 
	$mail->Host = "mail.hiphopboombox.com";
	$mail->Port = "465"; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "noreply@hiphopboombox.com";
	$mail->Password = "RGE}UB{v(&k~";
	$mail->SetFrom("noreply@hiphopboombox.com");
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo $mail->ErrorInfo;
	}else{
		echo 'Sent';
	}
}
?>