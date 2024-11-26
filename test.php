<?php

include 'connection.php';


// SQL query to fetch data
$query = "SELECT id, first_name, last_name, date_added FROM personell";
$result = $db->query($query);

// Display records
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . " - Name: " . $row['first_name'] . " " . $row['last_name'] . " - Date Added: " . $row['date_added'] . "<br>";
    }
} else {
    echo "No records found.";
}
?>

