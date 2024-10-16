<?php
include 'connection.php';  // Ensure this file contains the DB connection logic


// SQL query to select all records from room_logs
$sql = " SELECT 
    p.photo,
    p.department,
    p.role,
    CONCAT(p.first_name, ' ', p.last_name) AS full_name,
    pl.time_in,
    pl.time_out,
    pl.date_logged,
    pl.id
FROM personell_logs pl
JOIN personell p ON pl.personnel_id = p.id
WHERE pl.date_logged = CURRENT_DATE()

UNION ALL

SELECT 
    vl.photo,
    vl.department,
    'Visitor' AS role,
    vl.name AS full_name,
    vl.time_in,
    vl.time_out,
    vl.date_logged,
    vl.id
FROM visitor_logs vl
WHERE vl.date_logged = CURRENT_DATE()

ORDER BY GREATEST(time_in, time_out) DESC
LIMIT 1;
";
$result = $db->query($sql);

// Check if there are results and display them
if ($result->num_rows > 0) {
    // Start the table
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Personnel ID</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Date Logged</th>
                <th>Location</th>
            </tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['full_name']) . "</td>
                <td>" . htmlspecialchars($row['time_in']) . "</td>
                   <td>" . htmlspecialchars($row['time_out']) . "</td>
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


