<?php
session_start();
header('Content-Type: image/png');

// Generate a random CAPTCHA code
$captcha_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, 6);
$_SESSION['captcha_code'] = $captcha_code;

// Create an image (150x50 pixels)
$image = imagecreate(150, 50);

// Colors
$background_color = imagecolorallocate($image, 255, 255, 255);  // White background
$text_color = imagecolorallocate($image, 0, 0, 0);  // Black text color
$line_color = imagecolorallocate($image, 64, 64, 64);  // Line color for noise
$pixel_color = imagecolorallocate($image, 100, 100, 100);  // Pixel color for noise

// Add noise to the image (random pixels)
for ($i = 0; $i < 1000; $i++) {
    imagesetpixel($image, rand(0, 150), rand(0, 50), $pixel_color);
}

// Add noise (random lines)
for ($i = 0; $i < 5; $i++) {
    imageline($image, rand(0, 150), rand(0, 50), rand(0, 150), rand(0, 50), $line_color);
}

// Font file path - Make sure this points to a valid .ttf font file on your server
$font_path = __DIR__ . '/admin/fonts/glyphicons-halflings-regular.ttf';  // Change this to the actual path of your font file

// Check if the font exists
if (!file_exists($font_path)) {
    die('Font file not found!');
}

// Add the CAPTCHA code to the image
$font_size = 20; // Font size
$angle = 0;  // Angle of the text (0 means straight)
$x = rand(10, 40);  // X position of the text
$y = rand(30, 40);  // Y position of the text

// Use imagettftext to render the CAPTCHA text
imagettftext($image, $font_size, $angle, $x, $y, $text_color, $font_path, $captcha_code);

// Output the image as PNG
imagepng($image);

// Clean up
imagedestroy($image);
?>
