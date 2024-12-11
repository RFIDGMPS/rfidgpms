
<?php

include 'connection.php';


// SQL query to select specific columns from the lostcard table
$sql = "SELECT personnel_id, verification_photo, status FROM lostcard";

// Execute the query and get the result
$result = $db->query($sql);

// Check if there are rows in the result
if ($result->num_rows > 0) {
    // Output data of each row
    echo "<table border='1'>
            <tr>
                <th>Personnel ID</th>
                <th>Verification Photo</th>
                <th>Status</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["personnel_id"] . "</td>
                <td><img src='" . $row["verification_photo"] . "' alt='Verification Photo' width='100'></td>
                <td>" . $row["status"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

// Close the connection
$db->close();
?>
