<?php
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

if ($_POST) {
    $post = $_POST;

    // CAPTCHA validation
    if (!isset($_POST['captcha']) || $_POST['captcha'] !== $_SESSION['captcha']) {
        $fn->setError('Invalid CAPTCHA. Please try again.');
        $fn->redirect('../register.php'); // Redirect back to registration page
        exit; // Stop further execution if CAPTCHA is invalid
    }
    unset($_SESSION['captcha']); // Destroy the session variable after validation

    if ($post['email_id'] && $post['password']) {
        $email_id = $db->real_escape_string($post['email_id']);
        $password = $db->real_escape_string($post['password']);

        // Fetch the user's hashed password from the database
        $result = $db->query("SELECT id, full_name, password FROM users WHERE email_id = '$email_id'");

        $result = $result->fetch_assoc();

        if ($result) {
            // Verify the entered password with the hashed password stored in the database
            if (password_verify($password, $result['password'])) {
                $fn->setAuth($result);
                $fn->setAlert('Login success');
                $fn->redirect('../myresumes.php');
            } else {
                $fn->setError('Invalid credentials');
                $fn->redirect('../login.php');
            }
        } else {
            $fn->setError('Invalid credentials');
            $fn->redirect('../login.php');
        }
    } else {
        $fn->setError('All fields are mandatory!');
        $fn->redirect('../login.php');
    }
} else {
    $fn->redirect('../login.php');
}
