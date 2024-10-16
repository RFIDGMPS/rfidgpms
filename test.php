<?php
include 'connection.php';  // Ensure this file contains the DB connection logic
// Your existing query



// Determine if it's AM or PM
$current_time = new DateTime();
$time_in = $time_out = '';

if ($current_time->format('A') === 'AM') {
    $time_in = 'time_in_am';
    $time_out = 'time_out_am';
} else {
    $time_in = 'time_in_pm';
    $time_out = 'time_out_pm';
}

// Prepare the SQL query
$query = "SELECT 
            p.photo,
            p.department,
            p.role,
            CONCAT(p.first_name, ' ', p.last_name) AS full_name,
            pl.$time_in AS time_in,
            pl.$time_out AS time_out,
            pl.date_logged,
            pl.id
        FROM personell_logs pl
        JOIN personell p ON pl.personnel_id = p.id
        WHERE pl.date_logged = CURRENT_DATE()
        ORDER BY pl.id DESC
        LIMIT 1";

$results = mysqli_query($db, $query);

// Debugging: Display the query
if (!$results) {
    echo "Query Error: " . mysqli_error($db);
}

// Check if results are returned and display them
if ($results && mysqli_num_rows($results) > 0) {

       
    
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
