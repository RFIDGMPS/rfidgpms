<?php
include 'connection.php';


// Personnel IDs to choose from
$personnel_ids = [37, 1172, 6, 5, 4, 3];

// Locations (rooms)
$locations = ['Gate', 'Lab1', 'ComLab1', 'Lab2', 'RoomA', 'RoomB', 'RoomC'];

// Insert 60 random records
for ($i = 0; $i < 60; $i++) {
    // Randomly pick personnel_id
    $personnel_id = $personnel_ids[array_rand($personnel_ids)];

    // Randomly pick location
    $location = $locations[array_rand($locations)];

    // Generate random times
    $time_in_am = date("H:i:s", strtotime("08:00:00") + rand(0, 3600)); // Between 8:00 AM and 9:00 AM
    $time_out_am = date("H:i:s", strtotime($time_in_am) + rand(3600, 7200)); // 1-2 hours later

    $time_in_pm = date("H:i:s", strtotime("13:00:00") + rand(0, 3600)); // Between 1:00 PM and 2:00 PM
    $time_out_pm = date("H:i:s", strtotime($time_in_pm) + rand(3600, 7200)); // 1-2 hours later

    // Generate random date within the past month
    $date_logged = date("Y-m-d", strtotime("-" . rand(0, 30) . " days"));

    // SQL query to insert data
    $sql = "INSERT INTO personell_logs (personell_id, time_in_am, time_out_am, time_in_pm, time_out_pm, date_logged, location)
            VALUES ('$personnel_id', '$time_in_am', '$time_out_am', '$time_in_pm', '$time_out_pm', '$date_logged', '$location')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Record $i inserted successfully.<br>";
    } else {
        echo "Error on record $i: " . $sql . "<br>" . $conn->error . "<br>";
    }
}

// Close the connection
$db->close();
?>
