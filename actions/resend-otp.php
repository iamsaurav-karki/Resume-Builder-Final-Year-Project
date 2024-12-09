<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/class/database.class.php';
require '../assets/class/function.class.php';
require '../assets/packages/phpmailer/src/Exception.php';
require '../assets/packages/phpmailer/src/PHPMailer.php';
require '../assets/packages/phpmailer/src/SMTP.php';

$email = $fn->getSession('email');
if (empty($email)) {
    $fn->setError('Session expired. Please request OTP again.');
    $fn->redirect('../forgot-password.php');
}

// Generate a new OTP
$newOtp = mt_rand(100000, 999999);  // 6-digit OTP
$otpExpiry = date("Y-m-d H:i:s", strtotime('+5 minutes'));  // OTP expiry time (5 minutes from now)

// Hash the OTP before storing it in the database
$hashedOtp = password_hash($newOtp, PASSWORD_DEFAULT);

// Update the OTP and expiry in the database
$stmt = $db->prepare("UPDATE users SET otp = ?, otp_expiry = ? WHERE email_id = ?");
$stmt->bind_param("sss", $hashedOtp, $otpExpiry, $email);
if ($stmt->execute()) {
    // Send the new OTP to the user's email using PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'karkisaurav2711@gmail.com';  // SMTP username
        $mail->Password = 'vbkffakjruiiofri';            // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('karkisaurav2711@gmail.com', 'Resume Builder');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your New OTP for Resume Builder';
        $mail->Body = "Your new OTP is: <b>$newOtp</b>. It will expire in 5 minutes.";

        $mail->send();

        $fn->setAlert('A new OTP has been sent to your email!');
    } catch (Exception $e) {
        $fn->setError('Failed to send OTP. Please try again. Mailer Error: ' . $mail->ErrorInfo);
    }
} else {
    $fn->setError('Failed to update OTP. Please try again.');
}

$fn->redirect('../verification.php');
?>
