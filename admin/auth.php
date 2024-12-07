<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in

    header("Location: index");
    exit();
}

// Validate the token
if (!isset($_SESSION['admin_token']) || $_SESSION['admin_token'] !== $_SESSION['global_token']) {
    // If tokens don't match, destroy the session and redirect
    session_destroy();
    header('Location: index');
    exit();
}
?>
