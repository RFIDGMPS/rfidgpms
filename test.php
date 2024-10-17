<?php
include 'connection.php';  // Ensure this file contains the DB connection logic
if ($db->query('TRUNCATE TABLE personell_logs') === TRUE) {
    echo "personell_logs table truncated successfully.<br>";
} else {
    echo "Error truncating personell_logs: " . $db->error . "<br>";
}

if ($db->query('TRUNCATE TABLE room_logs') === TRUE) {
    echo "room_logs table truncated successfully.<br>";
} else {
    echo "Error truncating room_logs: " . $db->error . "<br>";
}


$insert_query = "INSERT INTO personell_logs (personnel_id, time_in_am, time_out_am, date_logged, location) 
                 VALUES ('1', '09:37:22', '10:37:22','2024-10-17', 'Gate')";
        mysqli_query($db, $insert_query);

        $insert_query1 = "INSERT INTO room_logs (personnel_id, time_in, time_out, date_logged, location) 
                          VALUES ('1', '09:37:22', '10:37:22', '2024-10-17', 'Gate')";
        mysqli_query($db, $insert_query1);

$current_time = new DateTime();
$timein = $timeout = '';
    if ($current_time->format('A') === 'AM') {
        $timein = 'time_in_am';
        $timeout = 'time_out_am';
    } else {
        $timein = 'time_in_pm';
        $timeout = 'time_out_pm';
    }

// SQL query to select all records from room_logs
$sql = " SELECT 
    p.photo,
    p.department,
    p.role,
    CONCAT(p.first_name, ' ', p.last_name) AS full_name,
    rl.time_in,
    rl.time_out,
    rl.date_logged,
    rl.personnel_id,
    rl.location
FROM room_logs rl
JOIN personell p ON rl.personnel_id = p.id
WHERE rl.date_logged = CURRENT_DATE()
ORDER BY 
    GREATEST(rl.time_in, rl.time_out) DESC
;
";
$result = $db->query($sql);

// Check if there are results and display them
if ($result->num_rows > 0) {
    // Start the table
    echo "<table border='1'>
            <tr>
                <th>Log ID</th>
                <th>Personnel ID</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Date Logged</th>
                <th>Location</th>
            </tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['personnel_id']) . "</td>
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


// SQL query to fetch data from personell_logs
$sql1 = "SELECT * FROM personell_logs";
$result1 = $db->query($sql1);

// Check if any rows were returned
if ($result1->num_rows > 0) {
    // Start table and table headers
    echo "<table border='1'>";
    echo "<tr>
            <th>ID</th>
            <th>Personell ID</th>
            <th>Time In</th>
            <th>Time Out</th>
             <th>Time In</th>
            <th>Time Out</th>
            <th>Location</th>
          </tr>";
    
    // Loop through and display each row of data
    while($row = $result1->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["personnel_id"] . "</td>
                <td>" . $row["personell_id"] . "</td>
                <td>" . $row["time_in_am"] . "</td>
                <td>" . $row["time_out_am"] . "</td>
                <td>" . $row["time_in_pm"] . "</td>
                <td>" . $row["time_out_pm"] . "</td>
                <td>" . $row["location"] . "</td>
              </tr>";
    }

    // End the table
    echo "</table>";
} else {
    echo "No records found";
}

// Close connection
$db->close();
?>


