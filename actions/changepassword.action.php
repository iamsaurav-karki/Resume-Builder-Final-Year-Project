<?php
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

if ($_POST) {
    $post = $_POST;

    if ($post['password']) {
        // Validate the new password (e.g., minimum length)
        $password = $db->real_escape_string($post['password']);
        
        if (strlen($password) < 8) {
            // Set the error message and redirect back to the change-password page
            $fn->setError('Password must be at least 8 characters long');
            $fn->redirect('../change-password.php');
            exit; // Ensure the script halts after redirection
        }

        // If password is valid, hash it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Get the email from the session
        $email = $fn->getSession('email');

        // Update the password in the database
        $query = "UPDATE users SET password='$hashed_password' WHERE email_id='$email'";
        if ($db->query($query)) {
            // Inform the user and redirect to the login page
            $fn->setAlert('Password changed successfully!');
            $fn->redirect('../login.php');
        } else {
            // If the query failed, set an error
            $fn->setError('Something went wrong while updating your password.');
            $fn->redirect('../change-password.php');
        }
    } else {
        // If password is not set, show an error
        $fn->setError('Please enter your new password');
        $fn->redirect('../change-password.php');
    }
} else {
    $fn->redirect('../change-password.php');
}
