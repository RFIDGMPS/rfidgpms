
<?php

include 'connection.php';

// Assuming you already have a database connection stored in $db
$user_id = 20240331;  // The user ID to update

// New value for the column (e.g., password, email, etc.)
$new_value = 'new_password_value';  // Replace this with the new value you want to set

// Prepared statement to update the user table
$query = "UPDATE user SET password = ? WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('si', $new_value, $user_id);  // 's' for string, 'i' for integer
$stmt->execute();

// Check if the update was successful
if ($stmt->affected_rows > 0) {
    echo "User updated successfully.";
} else {
    echo "No changes made or user not found.";
}

// Close the statement
$stmt->close();
?>

