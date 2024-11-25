<?php
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

if($_POST){
$post = $_POST;


if($post['otp']){

$otp=$post['otp'];

if($fn->getSession('otp')==$otp){
  $fn->setAlert('Email Verified!');
  $fn->redirect('../change-password.php');

}else{
    $fn->setError('Invalid otp');
  $fn->redirect('../verification.php');
}




}else{
  $fn->setError('Enter 6 digit Verification code sent to your email');

  $fn->redirect('../verification.php');
}
}
else {

    $fn->redirect('../verification.php');
}


?>