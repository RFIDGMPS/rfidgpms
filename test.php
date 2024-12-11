
<?php

// include 'connection.php';


// SQL query to fetch data from personell_logs table
$sql = "SELECT id, first_name, rfid_number FROM personell_logs";

// Execute the query
$result = $db->query($sql);

// Check if records exist
if ($result->num_rows > 0) {
    // Start HTML table
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>RFID Number</th>
            </tr>";

    // Loop through the results and display each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['first_name']) . "</td>
                <td>" . htmlspecialchars($row['rfid_number']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found in the personell_logs table.";
}

// Close the connection
$db->close();
?>
