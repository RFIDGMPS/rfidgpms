<?php
include 'connection.php';

// Array of random names
$names = ["John Doe", "Jane Smith", "Alice Johnson", "Bob Brown", "Eve Davis", "Charlie Wilson", "Grace Taylor", "Oscar Martinez", "Ivy Clark", "Leo Rodriguez"];

// Array of departments
$departments = ["HR", "IT", "Finance", "Operations", "Sales"];

// Loop to insert 40 records
for ($i = 0; $i < 40; $i++) {
    // Fetch a random RFID number from the visitor table
    $result = $db->query("SELECT rfid_number FROM visitor ORDER BY RAND() LIMIT 1");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $rfid_number = $row['rfid_number'];
    } else {
        die("No RFID numbers found in the visitor table.");
    }

    // Generate random data for the other fields
    $name = $names[array_rand($names)];
    $department = $departments[array_rand($departments)];
    $photo = "photo_" . rand(1, 100) . ".jpg";
    $date_logged = date("Y-m-d", strtotime("-" . rand(0, 30) . " days"));
    $contact_number = rand(1000000000, 9999999999); // Optional
    $address = "Street " . rand(1, 100) . ", City " . rand(1, 10);
    $purpose = "Visit purpose " . rand(1, 5);
    $time_in = date("H:i:s", rand(28800, 64800)); // Random time between 8:00 AM and 6:00 PM
    $time_out = date("H:i:s", rand(64801, 86399)); // Random time after time_in
    $role = "Visitor";
    $location = "Gate";

    // Insert data into visitor_logs table
    $sql = "INSERT INTO visitor_logs (rfid_number, department, photo, date_logged, contact_number, address, purpose, time_in, time_out, role, location, name) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ssssssssssss", $rfid_number, $department, $photo, $date_logged, $contact_number, $address, $purpose, $time_in, $time_out, $role, $location, $name);

    if ($stmt->execute()) {
        echo "Record $i inserted successfully with RFID: $rfid_number<br>";
    } else {
        echo "Error inserting record $i: " . $stmt->error . "<br>";
    }
}

// Close connection
$db->close();
?>
