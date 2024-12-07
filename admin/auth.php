<?php
session_start(); // Start the session


// Read the global token from the file
$globalToken = file_get_contents('global_admin_token.txt');

// Check if the session token matches the global token
if (!isset($_SESSION['username']) || !isset($_SESSION['admin_token']) || $_SESSION['admin_token'] !== $globalToken) {
    // Token mismatch; logout the session
    session_destroy();
    header('Location: index');
    exit();
}
?>
