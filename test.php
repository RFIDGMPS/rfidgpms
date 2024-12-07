
<?php

include 'connection.php';

$current_id = 1;  // The current user ID to update
$new_id = 20240331;      // The new user ID you want to assign

// Prepared statement to update the user ID
$query = "UPDATE user SET id = ? WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('ii', $new_id, $current_id);  // 'i' for integer
$stmt->execute();

// Check if the update was successful
if ($stmt->affected_rows > 0) {
    echo "User ID updated successfully.";
} else {
    echo "No changes made or user not found.";
}

// Close the statement
$stmt->close();
?>

