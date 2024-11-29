<?php
include 'connection.php';

// Values to insert
$contact = '09560379350';
$email = 'kyebejeanu@gmail.com';

// SQL query to insert data
$sql = "INSERT INTO user (contact, email) VALUES (?, ?)";

// Prepare the statement
$stmt = $db->prepare($sql);

if ($stmt) {
    // Bind parameters (s = string)
    $stmt->bind_param('ss', $contact, $email);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Record inserted successfully.";
    } else {
        echo "Error inserting record: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing statement: " . $db->error;
}
?>