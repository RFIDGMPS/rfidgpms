<?php

session_start();

// Get token and code from URL
$token = $_GET['token'] ?? '';
$code = $_GET['code'] ?? '';

if (!$token || !$code) {
    $verification_message =  "Invalid verification link.";
    exit;
}

// Check if the token matches the one stored in the session
if ($token === $_SESSION['verification_token']) {
    // You can now validate the code as needed, e.g., check if the code matches the one sent via email
    if ($code === $_SESSION['verification_code']) {
        $verification_message = "Verification successful!";
        // Proceed with login or any other action
    } else {
        $verification_message = "Invalid verification code.";
    }
} else {
    $verification_message =  "Invalid verification link.";
}
?>

<!-- Check if there's a message to display -->
<?php if (!empty($verification_message)): ?>
    <script>
        // Display SweetAlert based on the message
        Swal.fire({
            title: '<?php echo $verification_message; ?>',
            icon: '<?php echo ($code == $token) ? "success" : "error"; ?>',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed && '<?php echo ($code == $token) ? "success" : "error"; ?>' === "success") {
                window.location.href = "admin/index"; // Redirect to admin page on successful OTP
            }
        });
    </script>
<?php endif; ?>