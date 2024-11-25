<?php
session_start();
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

if($_POST){
$post = $_POST;


if($post['full_name'] && $post['email_id'] && $post['password']){

  $full_name=$db->real_escape_string($post['full_name']);
  $email_id=$db->real_escape_string($post['email_id']);
  $password=md5($db->real_escape_string($post['password']));


  $result = $db->query("SELECT count(*) as user FROM users WHERE (email_id = '$email_id' && password = '$password')");

  $result = $result->fetch_assoc();
 if($result['user']){
  $fn->setError($email_id.'is already registered');
  $fn->redirect('../register.php');

  die();
 }



  try{
  $db->query("INSERT INTO users(full_name,email_id,password) VALUES('$full_name','$email_id','$password')");

  $fn->setAlert('Registration successful');

  $fn->redirect('../login.php');


  }catch(Exception $error){
      $fn->setError($error->getMessage());
  $fn->redirect('../register.php');


  }



}else{
  $fn->setError('All field is mandatory!');

  $fn->redirect('../register.php');
}
}
else {

    $fn->redirect('../register.php');
}


?>