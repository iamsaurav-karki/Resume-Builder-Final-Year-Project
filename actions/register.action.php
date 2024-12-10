<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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

    // Check password length
    if ($length >= 8) $strength++;
    if ($length >= 14) $strength++;

    // Check for uppercase letters
    if (preg_match('/[A-Z]/', $password)) $strength++;

    // Check for lowercase letters
    if (preg_match('/[a-z]/', $password)) $strength++;

    // Check for numbers
    if (preg_match('/[0-9]/', $password)) $strength++;

    // Check for special characters
    if (preg_match('/[^a-zA-Z0-9]/', $password)) $strength++;

    // Categorize password based on strength
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
        $fn->redirect('../register.php'); // Redirect back to registration page
        exit; // Stop further execution if CAPTCHA is invalid
    }
    unset($_SESSION['captcha']); // Destroy the session variable after validation

    if ($post['full_name'] && $post['email_id'] && $post['password']) {
        $full_name = $db->real_escape_string($post['full_name']);
        $email_id = $db->real_escape_string($post['email_id']);
        $password = $db->real_escape_string($post['password']);

        // Validate password strength
        $passwordStrength = checkPasswordStrength($password);
        if ($passwordStrength == 'Very Weak' || $passwordStrength == 'Weak') {
            $fn->setError('Password is too weak. Please use a stronger password.');
            $fn->redirect('../register.php');
            exit; // Stop further execution if password is weak
        }

        // In register.action.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


        // Hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);


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

            // Send a welcome email upon successful registration
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'karkisaurav2711@gmail.com'; // SMTP username
                $mail->Password = 'vbkffakjruiiofri'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                $mail->setFrom('karkisaurav2711@gmail.com', 'Resume Builder');
                $mail->addAddress($email_id);

                $mail->isHTML(true);
                $mail->Subject = 'Welcome to Resume Builder!';
                $mail->Body = "<p>Hello $full_name,</p>
                                <p>Thank you for registering with Resume Builder. Your account has been successfully created.</p>
                                <p>We are excited to have you on board!</p>
                                <p>Best Regards, <br> Resume Builder Team (Saurav,Kushal,Laxman)</p>";

                $mail->send();

                // Set success alert and redirect to login page
                $fn->setAlert('Registration successful! Please check your email for a confirmation.');
                $fn->redirect('../login.php');
            } catch (Exception $e) {
                // If email fails to send
                $fn->setError('Could not send confirmation email. Please try again.');
                $fn->redirect('../register.php');
            }

        } catch (Exception $error) {
            // Handle any other errors during registration
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