<?php
session_start(); // Start the session

// Unset all session variables
session_unset();

// Invalidate the global token
file_put_contents('global_admin_token.txt', '');

// Destroy the current session
session_destroy();


// Redirect to the login page
header('Location: index');
exit();
?>
