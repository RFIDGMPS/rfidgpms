<?php
include 'connection.php';  // Ensure this file contains the DB connection logic


// SQL query to select all records from room_logs
$sql = "SELECT id, personnel_id, time_in, date_logged, location FROM room_logs";
$result = $db->query($sql);

// Check if there are results and display them
if ($result->num_rows > 0) {
    // Start the table
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Personnel ID</th>
                <th>Time In</th>
                <th>Date Logged</th>
                <th>Location</th>
            </tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['personnel_id']) . "</td>
                <td>" . htmlspecialchars($row['time_in']) . "</td>
                <td>" . htmlspecialchars($row['date_logged']) . "</td>
                <td>" . htmlspecialchars($row['location']) . "</td>
              </tr>";
    }
    echo "</table>"; // End the table
} else {
    echo "No records found.";
}

// Close connection
$db->close();
?>

?>
