<?php
include 'connection.php';

// Array of personnel IDs to choose from
$personnel_ids = [37, 1172, 6, 5, 4, 3];

// Array of possible verification photos (placeholder images for demo purposes)
$verification_photos = ['photo1.jpg', 'photo2.jpg', 'photo3.jpg', 'photo4.jpg', 'photo5.jpg'];

// Loop to insert 50 records
for ($i = 0; $i < 50; $i++) {
    // Randomly select a personnel ID
    $personnel_id = $personnel_ids[array_rand($personnel_ids)];

    // Generate a random date_requested (between 1 to 30 days ago)
    $date_requested = date('Y-m-d', strtotime("-" . rand(1, 30) . " days"));

    // Randomly select a status (0 or 1)
    $status = rand(0, 1);

    // Randomly select a verification photo
    $verification_photo = $verification_photos[array_rand($verification_photos)];

    // SQL query to insert data
    $sql = "INSERT INTO lostcard (personnel_id, date_requested, status, verification_photo) 
            VALUES ('$personnel_id', '$date_requested', '$status', '$verification_photo')";

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
