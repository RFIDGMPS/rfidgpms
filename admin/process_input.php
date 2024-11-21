<?php
// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input value
    $searchInput = htmlspecialchars($_POST['searchInput']); // Sanitize the input
    echo "You entered: " . $searchInput;

    // Add your database query or other logic here
}
?>
