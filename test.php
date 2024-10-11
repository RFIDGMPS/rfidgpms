<?php
include 'connection.php';

// Check connection
$dbname = "u510162695_gatepassdb";

// Step 2: Function to check if a column exists in the table
function columnExists($db, $table, $column) {
    $result = $db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
                            WHERE TABLE_NAME = '$table' AND COLUMN_NAME = '$column' AND TABLE_SCHEMA = '$dbname'");
    return $result->num_rows > 0;
}

// Step 3: Add columns if they do not exist
$columns = ['time_in_am', 'time_out_am', 'time_in_pm', 'time_out_pm'];
foreach ($columns as $column) {
    if (!columnExists($db, 'personell_logs', $column)) {
        $sql = "ALTER TABLE personell_logs ADD COLUMN $column VARCHAR(255) NOT NULL";
        if ($db->query($sql) === TRUE) {
            echo "Column '$column' added successfully!<br>";
        } else {
            echo "Error adding column '$column': " . $db->error . "<br>";
        }
    } else {
        echo "Column '$column' already exists.<br>";
    }
}

// Close connection
$db->close();

?>