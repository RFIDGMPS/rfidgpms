<?php

include 'connection.php';


$sql = "SELECT id, first_name, last_name FROM personell";
$result = $db->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Start the HTML table
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
            </tr>";

    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["first_name"] . "</td>
                <td>" . $row["last_name"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close the connection
$db->close();
?>
