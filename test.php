<?php
// Include database connection
include 'connection.php';

// SQL query to add the 'date_added' column
$query = "ALTER TABLE personell ADD COLUMN date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP";

// Execute the query
if ($db->query($query) === TRUE) {
    echo "Column 'date_added' added successfully.";
} else {
    echo "Error: " . $db->error;
}
?>
