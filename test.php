<?php
include 'connection.php';

// SQL query to add columns
$sql = "ALTER TABLE user 
        ADD contact VARCHAR(15) NOT NULL AFTER id, 
        ADD email VARCHAR(255) NOT NULL AFTER contact";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Columns 'contact' and 'email' added successfully.";
} else {
    echo "Error updating table: " . $conn->error;
}

// Close the connection
$db->close();
?>