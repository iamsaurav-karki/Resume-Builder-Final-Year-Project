<?php
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }
session_start();
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

if ($_POST) {
    $post = $_POST;

    if (!empty($post['full_name']) && !empty($post['email_id'])) {
        $full_name = $db->real_escape_string($post['full_name']);
        $email_id = $db->real_escape_string($post['email_id']);
        $authid = $fn->Auth()['id'];

        // Check if email already exists for another user
        $result = $db->query("SELECT count(*) as user FROM users WHERE email_id = '$email_id' AND id != $authid");
        $result = $result->fetch_assoc();

        if ($result['user']) {
            $fn->setError($email_id . ' is already registered');
            $fn->redirect('../profile.php');
            exit();
        }

        // Check if password is provided for update
        if (!empty($post['password'])) {
            $password = password_hash($post['password'], PASSWORD_DEFAULT);

            // Update full_name, email, and password
            $db->query("UPDATE users SET full_name = '$full_name', email_id = '$email_id', password = '$password' WHERE id = $authid");
        } else {
            // Update only full_name and email (password remains unchanged)
            $db->query("UPDATE users SET full_name = '$full_name', email_id = '$email_id' WHERE id = $authid");
        }

        $fn->setAlert('Profile updated!');
        $fn->redirect('../myresumes.php');
    } else {
        $fn->setError('Please fill out all required fields!');
        $fn->redirect('../profile.php');
    }
} else {
    $fn->redirect('../profile.php');
}
?>
