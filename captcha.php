<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: image/png');

// Generate random CAPTCHA code
$captcha_code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 6);
$_SESSION['captcha'] = $captcha_code;

// Create CAPTCHA image
$image = imagecreate(120, 40);
if (!$image) {
    die('Failed to create image');
}

$bg_color = imagecolorallocate($image, 255, 255, 255); // white background
$text_color = imagecolorallocate($image, 0, 0, 0); // black text
$font_size = 20;

// Add text to image
imagestring($image, 5, 10, 10, $captcha_code, $text_color);

// Output the image
imagepng($image);
imagedestroy($image);
?>
