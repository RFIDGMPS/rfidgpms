<!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

<form method="POST" action="session.php">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <label>Choose verification method:</label><br>
    <input type="radio" name="verification_method" value="email" required> Email<br>
    <input type="radio" name="verification_method" value="contact" required> Contact Number<br>

    <img src="captcha.php" alt="CAPTCHA">
    <input type="text" name="captcha" placeholder="Enter CAPTCHA" required>
    <button type="submit">Login</button>
</form> -->

<?php 
include 'connection.php';
// Database connection


$new_email = 'kyebejeanungon@gmail.com'; // New email to update

// Prepare the update query
$query = "UPDATE user SET email = ? WHERE id = ?";

// Prepare the statement
$stmt = $db->prepare($query);

// Check if statement preparation was successful
if ($stmt) {
    // Bind parameters (s = string, i = integer)
    $stmt->bind_param('si', $new_email, 1);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Email updated successfully!";
    } else {
        echo "Error updating email: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing the statement: " . $db->error;
}?>