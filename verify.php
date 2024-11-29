<?php

session_start();

// Get token and code from URL
$token = $_GET['token'] ?? '';
$code = $_GET['code'] ?? '';

if (!$token || !$code) {
    echo "Invalid verification link.";
    exit;
}

// Check if the token matches the one stored in the session
if ($token === $_SESSION['verification_token']) {
    // You can now validate the code as needed, e.g., check if the code matches the one sent via email
    if ($code === $_SESSION['verification_code']) {
        echo "Verification successful!";
        // Proceed with login or any other action
    } else {
        echo "Invalid verification code.";
    }
} else {
    echo "Invalid verification link.";
}
?>