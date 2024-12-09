<?php
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

if($_POST){
$post = $_POST;
 echo "<pre>";
 print_r($post);

 
if($post['id'] && $post['slug'] && $post['full_name'] && $post['email_id'] && $post['objective'] && $post['mobile_no'] && $post['dob'] && $post['religion'] && $post['nationality'] && $post['marital_status'] && $post['hobbies'] && $post['languages'] && $post['address']){


  $columns='';
  $values='';

  $post2 = $post;
  unset($post2['id']);
  unset($post2['slug']);


  foreach($post2 as $index=>$value){
    $value= $db->real_escape_string($value);
    $columns.=$index."='$value',";


  }
  // Add the current date and time in the correct format for updated_at
  $updated_at = date("Y-m-d H:i:s"); // Format: YYYY-MM-DD HH:MM:SS
  $columns .= "updated_at='$updated_at'";  // Append updated_at to the columns string



  try{

    $query = "UPDATE resumes SET ";
    $query.="$columns ";
    $query.="WHERE id={$post['id']} AND slug='{$post['slug']}'";

    // echo $query;
    // die();
    
  $db->query($query);

  $fn->setAlert('Resume Updated!');

   $fn->redirect('../myresumes.php?resume='.$post['slug']);

   die();



  }catch(Exception $error){
      $fn->setError($error->getMessage());
       $fn->redirect('../updateresume.php?resume='.$post['slug']);



  }



}else{
  $fn->setError('please fill the form!');

        $fn->redirect('../updateresume.php?resume='.$post['slug']);


}
}
else {

          $fn->redirect('../updateresume.php?resume='.$post['slug']);

}


?>