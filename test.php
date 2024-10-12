<?php
include 'connection.php';  // Ensure this file contains the DB connection logic

// Query to fetch data from personell_logs and personell where personnel_id matches
$sql = "SELECT 
            pl.id AS log_id,
            pl.personnel_id,
            pl.time_in_am,
            pl.time_out_am,
            pl.time_in_pm,
            pl.time_out_pm,
            pl.time_in,
            pl.time_out,
            pl.location,
            pl.date_logged,
            p.id AS personell_id,
            p.id_no,
            p.rfid_number,
            p.last_name,
            p.first_name,
            p.middle_name,
            p.role,
            p.department,
            p.status
        FROM 
            personell_logs pl
        JOIN 
            personell p
        ON 
            pl.personnel_id = p.id
        ORDER BY 
            pl.date_logged DESC";

// Prepare and execute the query
$result = $db->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr>
            <th>Log ID</th>
            <th>Personnel ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Department</th>
            <th>Role</th>
            <th>Date Logged</th>
            <th>Time In (AM)</th>
            <th>Time Out (AM)</th>
            <th>Time In (PM)</th>
            <th>Time Out (PM)</th>
            <th>Location</th>
          </tr>";

    // Loop through the result set and display the records
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['log_id'] . "</td>
                <td>" . $row['personnel_id'] . "</td>
                <td>" . $row['last_name'] . "</td>
                <td>" . $row['first_name'] . "</td>
                <td>" . $row['department'] . "</td>
                <td>" . $row['role'] . "</td>
                <td>" . $row['date_logged'] . "</td>
                <td>" . $row['time_in_am'] . "</td>
                <td>" . $row['time_out_am'] . "</td>
                <td>" . $row['time_in_pm'] . "</td>
                <td>" . $row['time_out_pm'] . "</td>
                <td>" . $row['location'] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No records found.";
}

// Close the database connection
$db->close();
?>
