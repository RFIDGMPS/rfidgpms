<?php
session_start(); // Start the session

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();


// Invalidate the global token
unset($_SESSION['global_token']);
unset($_SESSION['token_expiry']);


// Redirect to the login page
header('Location: index');
exit();
?>
