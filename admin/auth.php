<?php
session_start();

// Read the global token from the file
$globalToken = file_get_contents('global_admin_token.txt');

// Check if the session token matches the global token
if (!isset($_SESSION['username']) || !isset($_SESSION['admin_token']) || $_SESSION['admin_token'] !== $globalToken) {
    // Destroy the session
    session_destroy();
    
    // Stop further execution and trigger SweetAlert
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Session Terminated</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Session Terminated',
                text: 'Your account has been logged out because it was accessed from another device. Please protect your account.'
            }).then(() => {
                window.location.href = 'index'; // Redirect to the login page
            });
        </script>
    </body>
    </html>
    <?php
    exit();
}
?>
