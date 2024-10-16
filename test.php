<?php
include 'connection.php';  // Ensure this file contains the DB connection logic
// Your existing query


// SQL to create the room_logs table
$sql = "CREATE TABLE room_logs (
    id INT(11) NOT NULL AUTO_INCREMENT,
    date_logged VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    time_in VARCHAR(255) NOT NULL,
    time_out VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

// Execute the query
if ($db->query($sql) === TRUE) {
    echo "Table 'room_logs' created successfully.";
} else {
    echo "Error creating table: " . $db->error;
}

?>
