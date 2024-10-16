<?php
include 'connection.php';  // Ensure this file contains the DB connection logic
// Your existing query

date_default_timezone_set('Asia/Manila');

// Now check the current time
echo date('A'); // Displays the full date and time with AM/PM
$query = "
  SELECT 
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

ORDER BY 
    id DESC
LIMIT 1;


";

$results = mysqli_query($db, $query);

// Debugging: Display the query
if (!$results) {
    echo "Query Error: " . mysqli_error($db);
}

// Check if results are returned and display them
if ($results && mysqli_num_rows($results) > 0) {
    if(date('A') == 'AM') {
        $row['time_in'] = $row['time_in_am'];
        echo $row['time_in'];
        $row['time_out'] = $row['time_out_am'];
        echo $row['time_out'];
    }
    else {
        $row['time_in'] = $row['time_in_pm'];
        echo $row['time_in'];
        $row['time_out'] = $row['time_out_pm'];
        echo $row['time_out'];
    }
    while ($row = mysqli_fetch_assoc($results)) {
     
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px;'>";
        echo "<img src='admin/uploads/{$row['photo']}' alt='Photo' style='width: 100px; height: auto;'/>";
        echo "<p><strong>Name:</strong> {$row['full_name']}</p>";
        echo "<p><strong>Department:</strong> {$row['department']}</p>";
        echo "<p><strong>Role:</strong> {$row['role']}</p>";
        echo "<p><strong>Time In:</strong> {$row['time_in']}</p>";
        echo "<p><strong>Time Out:</strong> {$row['time_out']}</p>";
        echo "<p><strong>Date Logged:</strong> {$row['date_logged']}</p>";
        echo "</div>";
    }
} else {
    echo "<p>No records found for today.</p>";
}

// Don't forget to close the database connection if necessary
?>
