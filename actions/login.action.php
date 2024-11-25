<?php
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

if($_POST){
$post = $_POST;


if($post['email_id'] && $post['password']){

  $email_id=$db->real_escape_string($post['email_id']);
  $password=md5($db->real_escape_string($post['password']));


  $result = $db->query("SELECT id,full_name FROM users WHERE (email_id = '$email_id' && password = '$password')");

  $result = $result->fetch_assoc();

 if($result){
 $fn->setAuth($result);
 $fn->setAlert('Login success');
  $fn->redirect('../myresumes.php');


 }else {
   $fn->setError('Invalid credentials');
  $fn->redirect('../login.php');
 }





}else{
  $fn->setError('All field is mandatory!');

  $fn->redirect('../login.php');
}
}
else {

    $fn->redirect('../login.php');
}


?>