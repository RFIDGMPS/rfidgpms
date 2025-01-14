<?php
include 'connection.php';

// Loop to insert 96 random 10-digit numbers
for ($i = 0; $i < 96; $i++) {
    // Generate a random 10-digit number
    $rfid_number = str_pad(mt_rand(0, 9999999999), 10, '0', STR_PAD_LEFT);

    // SQL query to insert data
    $sql = "INSERT INTO visitor (rfid_number) VALUES ('$rfid_number')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Record $i inserted successfully with RFID: $rfid_number<br>";
    } else {
        echo "Error on record $i: " . $sql . "<br>" . $db->error . "<br>";
    }
}

// Close the connection
$db->close();
?>


