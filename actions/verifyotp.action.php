<?php
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

if ($_POST) {
    $otp = $_POST['otp'] ?? '';

    if (empty($otp)) {
        $fn->setError('Enter the OTP.');
        $fn->redirect('../verification.php');
    }

    $email = $fn->getSession('email');
    if (empty($email)) {
        $fn->setError('Session expired. Please request OTP again.');
        $fn->redirect('../forgot-password.php');
    }

    // Fetch OTP and expiry
    $stmt = $db->prepare("SELECT otp, otp_expiry FROM users WHERE email_id = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        if (time() > strtotime($result['otp_expiry'])) {
            $fn->setError('OTP has expired.');
            $fn->redirect('../forgot-password.php');
        }

        if (password_verify($otp, $result['otp'])) {
            $fn->setAlert('OTP verified! Proceed to reset your password.');
            $fn->redirect('../change-password.php');
        } else {
            $fn->setError('Invalid OTP. Please try again.');
            $fn->redirect('../verification.php');
        }
    } else {
        $fn->setError('Invalid request.');
        $fn->redirect('../forgot-password.php');
    }
}
?>
