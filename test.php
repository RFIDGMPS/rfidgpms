<?php
include 'connection.php';  // Ensure this file contains the DB connection logic
// Your existing query
$sql = "ALTER TABLE room_logs ADD COLUMN personnel_id INT(11) DEFAULT NULL;";

// Execute the query
if ($db->query($sql) === TRUE) {
    echo "Column 'personnel_id' added to 'room_logs' successfully.";
} else {
    echo "Error adding column: " . $db->error;
}
?>
