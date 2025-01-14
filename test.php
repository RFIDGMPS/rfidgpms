<?php
include 'connection.php';

// Array of personnel IDs to choose from
$personnel_ids = [37, 1172, 6, 5, 4, 3];

// Array of possible room names
$rooms = ['Lab1', 'ComLab1', 'ClassroomA', 'Room102', 'Lab2', 'ComLab2', 'MeetingRoom1', 'Hall1', 'Room201'];

// Loop to insert 30 records
for ($i = 0; $i < 30; $i++) {
    // Randomly select a personnel ID
    $personnel_id = $personnel_ids[array_rand($personnel_ids)];

    // Randomly select a time_in and time_out (just as examples, you can modify this logic)
    $time_in = date('Y-m-d H:i:s', strtotime("-" . rand(1, 10) . " hours"));
    $time_out = date('Y-m-d H:i:s', strtotime($time_in . " +" . rand(1, 5) . " hours"));

    // Randomly select a room
    $location = $rooms[array_rand($rooms)];

    // Get the current date for date_logged
    $date_logged = date('Y-m-d');

    // SQL query to insert data
    $sql = "INSERT INTO room_logs (personnel_id, time_in, time_out, date_logged, location) 
            VALUES ('$personnel_id', '$time_in', '$time_out', '$date_logged', '$location')";

    // Execute the query
    if ($db->query($sql) === TRUE) {
        echo "Record $i inserted successfully<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $db->error . "<br>";
    }
}

// Close the connection
$db->close();
?>
