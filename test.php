<?php
include 'connection.php';

// SQL query to fetch all records
$sql = "SELECT * FROM personell_logs";
$result = $db->query($sql);

// Check if records exist
if ($result->num_rows > 0) {
    // Display data in a table
    echo "<table border='1' cellspacing='0' cellpadding='5'>";
    echo "<tr>
            <th>ID</th>
            <th>Personnel ID</th>
            <th>Time In (AM)</th>
            <th>Time Out (AM)</th>
            <th>Time In (PM)</th>
            <th>Time Out (PM)</th>
            <th>Date Logged</th>
            <th>Location</th>
          </tr>";

    // Fetch and display rows
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['personnel_id'] . "</td>
                <td>" . $row['time_in_am'] . "</td>
                <td>" . $row['time_out_am'] . "</td>
                <td>" . $row['time_in_pm'] . "</td>
                <td>" . $row['time_out_pm'] . "</td>
                <td>" . $row['date_logged'] . "</td>
                <td>" . $row['location'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

// Close the connection
$db->close();
?>
