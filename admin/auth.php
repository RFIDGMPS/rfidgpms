<?php
session_start(); // Start the session


// Read the global token from the file
$globalToken = file_get_contents('global_admin_token.txt');

// Check if the session token matches the global token
if (!isset($_SESSION['username']) || !isset($_SESSION['admin_token']) || $_SESSION['admin_token'] !== $globalToken) {
    // Token mismatch; logout the session

    session_destroy();
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Session Terminated',
            text: 'Your account has been logged out because it was accessed from another device. Please protect your account.'
        }).then(() => {
            window.location.href = 'index'; // Redirect to the login page
        });
    </script>";
    exit();
}
?>
