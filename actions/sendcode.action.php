<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/class/database.class.php';
require '../assets/class/function.class.php';
require '../assets/packages/phpmailer/src/Exception.php';
require '../assets/packages/phpmailer/src/PHPMailer.php';
require '../assets/packages/phpmailer/src/SMTP.php';

if ($_POST) {
    $post = $_POST;

    if (!empty($post['email_id'])) {
        $email_id = $db->real_escape_string($post['email_id']);

        // Check if email exists
        $stmt = $db->prepare("SELECT id, full_name FROM users WHERE email_id = ?");
        $stmt->bind_param("s", $email_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result) {
            $otp = random_int(100000, 999999);
            $otp_expiry = date('Y-m-d H:i:s', time() + 300); // 5 minutes expiry
            $hashed_otp = password_hash($otp, PASSWORD_DEFAULT);

            // Save OTP and expiry in the database
            $stmt = $db->prepare("UPDATE users SET otp = ?, otp_expiry = ? WHERE id = ?");
            $stmt->bind_param("ssi", $hashed_otp, $otp_expiry, $result['id']);
            $stmt->execute();

            // Send OTP via email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username   = 'karkisaurav2711@gmail.com';                     //SMTP username
                $mail->Password   = 'vbkffakjruiiofri';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                $mail->setFrom('karkisaurav2711@gmail.com', 'Resume Builder');
                $mail->addAddress($email_id);

                $mail->isHTML(true);
                $mail->Subject = 'Forgot Password?';
                $mail->Body = "Your OTP for password reset is: <b>$otp</b>. It will expire in 5 minutes.";

                $mail->send();

                // Save email in session
                $fn->setSession('email', $email_id);
                $fn->setAlert('OTP sent to your email!');
                $fn->redirect('../verification.php');
            } catch (Exception $e) {
                $fn->setError('Could not send OTP. Please try again.');
                $fn->redirect('../forgot-password.php');
            }
        } else {
            $fn->setError('Email not registered.');
            $fn->redirect('../forgot-password.php');
        }
    } else {
        $fn->setError('Enter your email!');
        $fn->redirect('../forgot-password.php');
    }
} else {
    $fn->redirect('../forgot-password.php');
}
