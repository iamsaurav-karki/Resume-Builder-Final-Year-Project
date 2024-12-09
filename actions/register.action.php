<?php
session_start();
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

if ($_POST) {
    $post = $_POST;

    if ($post['full_name'] && $post['email_id'] && $post['password']) {
        // Get user input
        $full_name = $db->real_escape_string($post['full_name']);
        $email_id = $db->real_escape_string($post['email_id']);
        $password = $db->real_escape_string($post['password']);

        // Validate password length (minimum 8 characters)
        if (strlen($password) < 8) {
            $fn->setError('Password must be at least 8 characters long');
            $fn->redirect('../register.php');
            exit; // Stop further execution if password is invalid
        }

        // Hash the password
        $password = md5($password);

        // Check if user already exists
        $result = $db->query("SELECT count(*) as user FROM users WHERE email_id = '$email_id'");

        $result = $result->fetch_assoc();
        if ($result['user']) {
            $fn->setError($email_id . ' is already registered');
            $fn->redirect('../register.php');
            die();
        }

        try {
            // Insert new user into the database
            $db->query("INSERT INTO users(full_name,email_id,password) VALUES('$full_name','$email_id','$password')");

            $fn->setAlert('Registration successful');
            $fn->redirect('../login.php');

        } catch (Exception $error) {
            $fn->setError($error->getMessage());
            $fn->redirect('../register.php');
        }

    } else {
        $fn->setError('All fields are mandatory!');
        $fn->redirect('../register.php');
    }
} else {
    $fn->redirect('../register.php');
}
