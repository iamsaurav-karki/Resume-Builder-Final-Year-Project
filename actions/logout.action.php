
<?php
/*
session_start();
session_destroy();
$fn->setAlert('Login success');
header('Location:../login.php');
*/
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../assets/class/function.class.php';

$fn = new Functions();

// Destroy the session
session_destroy();

// Set a SweetAlert message for successful logout
session_start(); // Start a new session to set the alert
$fn->setAlert('You have successfully logged out.');

// Redirect to the login page
$fn->redirect('../login.php');
exit();

?>