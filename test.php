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
// $current_time = new DateTime();
// $timein = $timeout = '';
//     if ($current_time->format('A') === 'AM') {
//         $timein = 'time_in_am';
//         $timeout = 'time_out_am';
//     } else {
//         $timein = 'time_in_pm';
//         $timeout = 'time_out_pm';
//     }

// // SQL query to select all records from room_logs
// $sql = " SELECT 
//     p.photo,
//     p.department,
//     p.role,
//     CONCAT(p.first_name, ' ', p.last_name) AS full_name,
//     rl.time_in,
//     rl.time_out,
//     rl.date_logged,
//     rl.id,
//     rl.location
// FROM room_logs rl
// JOIN personell p ON rl.personnel_id = p.id
// WHERE rl.date_logged = CURRENT_DATE()
// ORDER BY 
//     GREATEST(rl.time_in, rl.time_out) DESC
// ;
// ";
// $result = $db->query($sql);

// // Check if there are results and display them
// if ($result->num_rows > 0) {
//     // Start the table
//     echo "<table border='1'>
//             <tr>
//                 <th>ID</th>
//                 <th>Personnel ID</th>
//                 <th>Time In</th>
//                 <th>Time Out</th>
//                 <th>Date Logged</th>
//                 <th>Location</th>
//             </tr>";

//     // Output data of each row
//     while ($row = $result->fetch_assoc()) {
//         echo "<tr>
//                 <td>" . htmlspecialchars($row['id']) . "</td>
//                 <td>" . htmlspecialchars($row['full_name']) . "</td>
//                 <td>" . htmlspecialchars($row['time_in']) . "</td>
//                    <td>" . htmlspecialchars($row['time_out']) . "</td>
//                 <td>" . htmlspecialchars($row['date_logged']) . "</td>
//                 <td>" . htmlspecialchars($row['location']) . "</td>
//               </tr>";
//     }
//     echo "</table>"; // End the table
// } else {
//     echo "No records found.";
// }

// // Close connection
// $db->close();
?>


