<?php
include 'connection.php';
// SQL query to fetch data
$sql = "SELECT date_logged, time_in_am, time_out_am, time_in_pm, time_out_pm 
        FROM personell_logs 
        WHERE MONTH(date_logged) = ? AND personnel_id = ?";

// Prepare statement
$stmt = $db->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $db->error);
}

// Bind parameters
$stmt->bind_param("ii", $monthNumber, $id);

// Execute the statement
if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}

// Get the result
$result = $stmt->get_result();

// Check if rows are available
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Date Logged</th>
                <th>Time In (AM)</th>
                <th>Time Out (AM)</th>
                <th>Time In (PM)</th>
                <th>Time Out (PM)</th>
            </tr>";

    // Fetch and display each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['date_logged']) . "</td>
                <td>" . htmlspecialchars($row['time_in_am']) . "</td>
                <td>" . htmlspecialchars($row['time_out_am']) . "</td>
                <td>" . htmlspecialchars($row['time_in_pm']) . "</td>
                <td>" . htmlspecialchars($row['time_out_pm']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found for the given month and personnel ID.";
}

// Close the statement
$stmt->close();
?>
