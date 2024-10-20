<?php
include 'connection.php';  // Ensure this file contains the DB connection logic
// if ($db->query('TRUNCATE TABLE personell_logs') === TRUE) {
//     echo "personell_logs table truncated successfully.<br>";
// } else {
//     echo "Error truncating personell_logs: " . $db->error . "<br>";
// }

// if ($db->query('TRUNCATE TABLE room_logs') === TRUE) {
//     echo "room_logs table truncated successfully.<br>";
// } else {
//     echo "Error truncating room_logs: " . $db->error . "<br>";
// }
$sql = "SELECT id, rfid_number, last_log, attempts FROM stranger_logs";
$result = mysqli_query($db, $sql);

// Check if there are any records
if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>RFID Number</th>
                <th>Last Log</th>
                <th>Attempts</th>
            </tr>";

    // Loop through the results and display each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['rfid_number'] . "</td>
                <td>" . $row['last_log'] . "</td>
                <td>" . $row['attempts'] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No records found.";
}
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
JOIN personell p ON rl.personnel_id = p.id WHERE rl.date_logged = CURR_DATE()
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
    echo "</table>"; 
} else {
    echo "No records found.";
}


// SQL query to fetch data from personell_logs
$sql1 = "SELECT * FROM personell_logs WHERE date_logged = CURR_DATE()";
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
                <td>" . $row["date_logged"] . "</td>
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


