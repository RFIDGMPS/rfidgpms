
<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include 'connection.php';


// SQL query to fetch specific columns
$sql = "SELECT id, first_name, deleted FROM personell";
$result = $db->query($sql);

// Check if records were found
if ($result->num_rows > 0) {
    // Display data in a table
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Deleted</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["first_name"] . "</td>
                <td>" . $row["deleted"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

// Close the connection
$db->close();
?>
