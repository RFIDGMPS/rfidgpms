<?php
include 'connection.php';  // Ensure this file contains the DB connection logic
if ($department == 'Main') {
    $results = mysqli_query($db, "
        SELECT 
            p.photo,
            p.department,
            p.role,
            CONCAT(p.first_name, ' ', p.last_name) AS full_name,
            CASE
                WHEN CURRENT_TIME() < '12:00:00' THEN pl.time_in_am
                ELSE pl.time_in_pm
            END AS time_in,
            CASE
                WHEN CURRENT_TIME() < '12:00:00' THEN pl.time_out_am
                ELSE pl.time_out_pm
            END AS time_out,
            pl.date_logged,
            pl.id -- Assuming id is the primary key and auto-increments
        FROM personell_logs pl
        JOIN personell p ON pl.personnel_id = p.id
        WHERE pl.date_logged = CURRENT_DATE()
        
        UNION
        
        SELECT 
            vl.photo,
            vl.department,
            'Visitor' AS role,
            vl.name AS full_name,
            vl.time_in,
            vl.time_out,
            vl.date_logged,
            vl.id -- Assuming id is the primary key in visitor_logs
        FROM visitor_logs vl
        WHERE vl.date_logged = CURRENT_DATE()
        
        ORDER BY 
            id DESC -- Sorting by the most recent id
        LIMIT 1;
    ");
} else {
    $results = mysqli_query($db, "
        SELECT 
            p.photo,
            p.department,
            p.role,
            CONCAT(p.first_name, ' ', p.last_name) AS full_name,
            pl.time_in,
            pl.time_out,
            pl.date_logged,
            pl.id -- Assuming id is the primary key and auto-increments
        FROM personell_logs pl
        JOIN personell p ON pl.personnel_id = p.id
        WHERE pl.date_logged = CURRENT_DATE()
        
        UNION
        
        SELECT 
            vl.photo,
            vl.department,
            'Visitor' AS role,
            vl.name AS full_name,
            vl.time_in,
            vl.time_out,
            vl.date_logged,
            vl.id -- Assuming id is the primary key in visitor_logs
        FROM visitor_logs vl
        WHERE vl.date_logged = CURRENT_DATE()
        
        ORDER BY 
            id DESC -- Sorting by the most recent id
        LIMIT 1;
    ");
}

// Check if results are returned and display them
if ($results && mysqli_num_rows($results) > 0) {
    while ($row = mysqli_fetch_assoc($results)) {
        echo "<div>";
        echo "<img src='admin/uploads/{$row['photo']}' alt='Photo' />";
        echo "<p>Name: {$row['full_name']}</p>";
        echo "<p>Department: {$row['department']}</p>";
        echo "<p>Role: {$row['role']}</p>";
        echo "<p>Time In: {$row['time_in']}</p>";
        echo "<p>Time Out: {$row['time_out']}</p>";
        echo "<p>Date Logged: {$row['date_logged']}</p>";
        echo "</div>";
    }
} else {
    echo "<p>No records found for today.</p>";
}

?>
