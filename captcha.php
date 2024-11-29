<?php
session_start();
header('Content-Type: image/png');

// Generate a random CAPTCHA code
$captcha_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, 6);
$_SESSION['captcha_code'] = $captcha_code;

// Create an image
$image = imagecreate(150, 50);

// Colors
$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
$line_color = imagecolorallocate($image, 64, 64, 64);
$pixel_color = imagecolorallocate($image, 100, 100, 100);

// Add noise
for ($i = 0; $i < 1000; $i++) {
    imagesetpixel($image, rand(0, 150), rand(0, 50), $pixel_color);
}

// Add text
imagettftext($image, 20, 0, 20, 35, $text_color, __DIR__ . 'admin/fonts/glyphicons-halflings-regular.ttf', $captcha_code);

// Output image
imagepng($image);
imagedestroy($image);
?>
