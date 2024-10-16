<?php
include 'connection.php';  // Ensure this file contains the DB connection logic

$sql = "TRUNCATE TABLE room_logs;";

// Execute the query
if ($db->query($sql) === TRUE) {
    echo "Table 'room_logs' truncated successfully.";
} else {
    echo "Error truncating table: " . $db->error;
}
?>


