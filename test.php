<?php
include 'connection.php';  // Ensure this file contains the DB connection logic
// Fetch records from room_logs for yesterday
$yesterday = date('Y-m-d', strtotime('-1 day'));
$sql = "SELECT * FROM visitor_logs WHERE (time_in IS NULL OR time_out IS NULL OR time_in = '' OR time_out = '')";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // Loop through all rows with NULL or empty time fields
    while ($row = $result->fetch_assoc()) {
        $id = $row['id']; // Assuming you have an 'id' column in room_logs for identification
        
        $updateFields = [];
        // Check if time_in is NULL or an empty string and needs to be updated
        if (is_null($row['time_in']) || $row['time_in'] === '') {
            $updateFields[] = "time_in = '?'";
        }
        // Check if time_out is NULL or an empty string and needs to be updated
        if (is_null($row['time_out']) || $row['time_out'] === '') {
            $updateFields[] = "time_out = '?'";
        }
        
        // Only update if there's something to update
        if (!empty($updateFields)) {
            $updateQuery = "UPDATE visitor_logs SET " . implode(", ", $updateFields) . " WHERE id = $id";
            if ($db->query($updateQuery) === TRUE) {
                echo "Record updated successfully for ID: $id <br>";
            } 
        }
    }

   
}
else {
    echo "No records found";
}

// Close connection
$db->close();
?>


