<?php
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

function checkPasswordStrength($password) {
    $strength = 0;
    $length = strlen($password);

    // Check password length
    if ($length >= 8) $strength++;
    if ($length >= 14) $strength++;

    // Uppercase letters
    if (preg_match('/[A-Z]/', $password)) $strength++;

    // Lowercase letters
    if (preg_match('/[a-z]/', $password)) $strength++;

    // Digits
    if (preg_match('/[0-9]/', $password)) $strength++;

    // Special characters
    if (preg_match('/[^a-zA-Z0-9]/', $password)) $strength++;

    // Categorize password
    if ($strength < 3) return 'Very Weak';
    if ($strength < 4) return 'Weak';
    if ($strength < 5) return 'Medium';
    if ($strength < 6) return 'Strong';
    return 'Very Strong';
}

if ($_POST) {
    $post = $_POST;

    if ($post['password']) {
        // Validate the new password
        $password = $db->real_escape_string($post['password']);

        // Check password strength
        $passwordStrength = checkPasswordStrength($password);
        if ($passwordStrength == 'Very Weak' || $passwordStrength == 'Weak') {
            // Set the error message and redirect back to the change-password page
            $fn->setError('Password is too weak. Please use a stronger password.');
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
