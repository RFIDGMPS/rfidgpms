<?php
include 'connection.php';

// Step 1: Drop the table if it exists
$dropTableSQL = "DROP TABLE IF EXISTS admin_sessions";
if ($db->query($dropTableSQL) === TRUE) {
    echo "Table `admin_sessions` dropped successfully.<br>";
} else {
    echo "Error dropping table: " . $db->error . "<br>";
}

// Step 2: Create the new table
$createTableSQL = "
    CREATE TABLE admin_sessions (
        id INT AUTO_INCREMENT PRIMARY KEY,          -- Auto-incrementing unique identifier
        location VARCHAR(255),                      -- Stores the location information
        ip_address VARCHAR(255),                    -- Stores the IP address
        device VARCHAR(255),                        -- Stores the device details
        date_logged DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP  -- Automatically sets the current timestamp
    )
";

if ($db->query($createTableSQL) === TRUE) {
    echo "Table `admin_sessions` created successfully.<br>";
} else {
    echo "Error creating table: " . $db->error . "<br>";
}

// Close the connection
$db->close();
?>