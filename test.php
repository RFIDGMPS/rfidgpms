<?php
include 'connection.php';
// SQL query to create the admin_sessions table
$sql = "CREATE TABLE IF NOT EXISTS admin_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    location VARCHAR(255) NOT NULL,
    device VARCHAR(255) NOT NULL,
    date_logged DATETIME NOT NULL
)";

// Execute the query
if ($db->query($sql) === TRUE) {
    echo "Table 'admin_sessions' created successfully.";
} else {
    echo "Error creating table: " . $db->error;
}
?>