<?php
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();
// }
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';
require '../assets/packages/phpmailer/src/Exception.php';
require '../assets/packages/phpmailer/src/PHPMailer.php';
require '../assets/packages/phpmailer/src/SMTP.php';

// Function to check password strength
function checkPasswordStrength($password) {
    $strength = 0;
    $length = strlen($password);

    if ($length >= 8) $strength++;
    if ($length >= 14) $strength++;
    if (preg_match('/[A-Z]/', $password)) $strength++;
    if (preg_match('/[a-z]/', $password)) $strength++;
    if (preg_match('/[0-9]/', $password)) $strength++;
    if (preg_match('/[^a-zA-Z0-9]/', $password)) $strength++;

    if ($strength < 3) return 'Very Weak';
    if ($strength < 4) return 'Weak';
    if ($strength < 5) return 'Medium';
    if ($strength < 6) return 'Strong';
    return 'Very Strong';
}

if ($_POST) {
    $post = $_POST;

    // CAPTCHA validation
    if (!isset($_POST['captcha']) || $_POST['captcha'] !== $_SESSION['captcha']) {
        $fn->setError('Invalid CAPTCHA. Please try again.');
        $fn->redirect('../register.php');
        exit;
    }
    unset($_SESSION['captcha']);

    if (!empty($post['full_name']) && !empty($post['email_id']) && !empty($post['password'])) {
        $full_name = $db->real_escape_string($post['full_name']);
        $email_id = $db->real_escape_string($post['email_id']);
        $password = $post['password'];

        // Validate password strength
        $passwordStrength = checkPasswordStrength($password);
        if ($passwordStrength === 'Very Weak' || $passwordStrength === 'Weak') {
            $fn->setError('Password is too weak. Please use a stronger password.');
            $fn->redirect('../register.php');
            exit;
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if user already exists
        $stmt = $db->prepare("SELECT COUNT(*) as user FROM users WHERE email_id = ?");
        $stmt->bind_param("s", $email_id);
        $stmt->execute();
        $stmt->bind_result($user_count);
        $stmt->fetch();
        $stmt->close();

        if ($user_count > 0) {
            $fn->setError($email_id . ' is already registered');
            $fn->redirect('../register.php');
            exit;
        }

        try {
            // Insert new user into the database
            $stmt = $db->prepare("INSERT INTO users (full_name, email_id, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $full_name, $email_id, $hashed_password);
            $stmt->execute();
            $stmt->close();

            // Send a welcome email
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'karkisaurav2711@gmail.com';
            $mail->Password = 'vbkffakjruiiofri';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('karkisaurav2711@gmail.com', 'Resume Builder');
            $mail->addAddress($email_id);
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to Resume Builder!';
            $mail->Body = "<p>Hello $full_name,</p>
                           <p>Thank you for registering with Resume Builder. Your account has been successfully created.</p>
                           <p>We are excited to have you on board!</p>
                           <p>Best Regards,<br>Resume Builder Team (Saurav, Kushal, Laxman)</p>";
            $mail->send();

            // Set success message and redirect
            $fn->setAlert('Registration successful! Please check your email for a confirmation.');
            $fn->redirect('../login.php');
            exit; // Ensure script execution stops after redirection

        } catch (Exception $e) {
            $fn->setError('Registration failed: ' . $e->getMessage());
            $fn->redirect('../register.php');
            exit; // Ensure script execution stops after redirection
        }
    } else {
        $fn->setError('All fields are mandatory!');
        $fn->redirect('../register.php');
        exit; // Ensure script execution stops after redirection
    }
} else {
    $fn->redirect('../register.php');
    exit; // Ensure script execution stops after redirection
}
