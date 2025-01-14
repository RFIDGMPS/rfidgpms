<?php
include 'connection.php';


// SQL query to delete data
$date_to_delete = '2024-10-18'; // Date to match
$sql = "DELETE FROM visitor_logs WHERE date_logged = ?";

// Prepare and bind statement to prevent SQL injection
$stmt = $db->prepare($sql);
$stmt->bind_param("s", $date_to_delete);

// Execute the statement
if ($stmt->execute()) {
    echo "Records deleted successfully where date_logged = $date_to_delete";
} else {
    echo "Error deleting records: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$db->close();
?>
