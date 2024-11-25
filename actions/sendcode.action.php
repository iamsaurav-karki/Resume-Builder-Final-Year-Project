<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../assets/class/database.class.php';
require '../assets/class/function.class.php';


require '../assets/packages/phpmailer/src/Exception.php';
require '../assets/packages/phpmailer/src/PHPMailer.php';
require '../assets/packages/phpmailer/src/SMTP.php';

if($_POST){
$post = $_POST;


if($post['email_id']){

  $email_id=$db->real_escape_string($post['email_id']);


  $result = $db->query("SELECT id,full_name FROM users WHERE (email_id = '$email_id')");

  $result = $result->fetch_assoc();

 if($result){
  $otp = rand(100000,999999);
$mail = new PHPMailer(true);

try {
    //Server settings                     //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'karkisaurav2711@gmail.com';                     //SMTP username
    $mail->Password   = 'vbkffakjruiiofri';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('karkisaurav2711@gmail.com', 'Resume Builder');
    $mail->addAddress($email_id);     //Add a recipient

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Forgot Password ?';
    $mail->Body    = 'Your email verification code is: <b>'.$otp.'</b>';

    $mail->send();
    $fn->setSession('otp',$otp);
    $fn->setSession('email',$email_id);

  $fn->redirect('../verification.php');



} catch (Exception $e) {
    $fn->setError($mail->ErrorInfo);
  $fn->redirect('../forgot-password.php');
}

 }else {
   $fn->setError($email_id.'is not registered');
  $fn->redirect('../forgot-password.php');
 }





}else{
  $fn->setError('Enter your email!');

  $fn->redirect('../forgot-password.php');
}
}
else {

    $fn->redirect('../forgot-password.php');
}


?>