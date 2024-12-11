
<?php

include 'connection.php';


// Prepare an SQL query using placeholders
$stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");

// Bind parameters to the placeholders
$stmt->bind_param("ss", $username, $password); // "ss" means both are strings

// Set values for the parameters
$username = $_POST['username'];  // Assuming you're getting this data from a form
$password = $_POST['password'];  // Assuming you're getting this data from a form

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if there are any matching records
if ($result->num_rows > 0) {
    echo "Login successful!";
} else {
    echo "Invalid credentials.";
}

// Close the statement and connection
$stmt->close();
$db->close();
?>
