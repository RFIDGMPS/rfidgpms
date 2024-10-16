<?php
include 'connection.php';  // Ensure this file contains the DB connection logic
// Your existing query
$sql = "TRUNCATE TABLE personell_logs;";

// Execute the query
if ($db->query($sql) === TRUE) {
    echo "Table 'personell_logs' truncated successfully.";
} else {
    echo "Error truncating table: " . $db->error;
}
?>
