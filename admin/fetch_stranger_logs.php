<?php
// Database connection details
include '../connection.php';

// Fetch stranger logs from the database
$query = "SELECT rfid_number, attempts, log_date FROM stranger_logs ORDER BY last_log DESC LIMIT 10";
$result = $mysqli->query($query);

// Prepare the data for JSON output
$stranger_logs = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $stranger_logs[] = $row;
    }
}

// Close the connection
$mysqli->close();

// Return the logs as JSON
echo json_encode($stranger_logs);
?>
