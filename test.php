<?php
include 'connection.php';

// List of random room names
$rooms = ['Gate', 'Lab1', 'ComLab1', 'Library', 'Auditorium', 'AdminOffice'];

// Generate and insert 60 records
for ($i = 0; $i < 60; $i++) {
    // Generate random data
    $personnel_id = rand(1, 100); // Assuming personnel IDs range from 1 to 100
    $date_logged = date('Y-m-d', strtotime("-" . rand(0, 30) . " days")); // Random date within the last 30 days
    $time_in_am = date('H:i:s', strtotime(rand(7, 8) . ":" . rand(0, 59))); // Random time between 7:00 and 8:59
    $time_out_am = date('H:i:s', strtotime(rand(11, 12) . ":" . rand(0, 59))); // Random time between 11:00 and 12:59
    $time_in_pm = date('H:i:s', strtotime(rand(13, 14) . ":" . rand(0, 59))); // Random time between 13:00 and 14:59
    $time_out_pm = date('H:i:s', strtotime(rand(16, 17) . ":" . rand(0, 59))); // Random time between 16:00 and 17:59
    $location = $rooms[array_rand($rooms)]; // Random room from the list

    // SQL query to insert data
    $sql = "INSERT INTO personell_logs (personnel_id, time_in_am, time_out_am, time_in_pm, time_out_pm, date_logged, location)
            VALUES ('$personnel_id', '$time_in_am', '$time_out_am', '$time_in_pm', '$time_out_pm', '$date_logged', '$location')";

    // Execute the query
    if ($db->query($sql) === TRUE) {
        echo "Record $i inserted successfully with Personnel ID: $personnel_id, Location: $location<br>";
    } else {
        echo "Error on record $i: " . $sql . "<br>" . $db->error . "<br>";
    }
}

// Close the connection
$db->close();
?>
