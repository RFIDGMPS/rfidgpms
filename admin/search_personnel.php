<?php
// Database connection
include '../connection.php';

if (isset($_GET['query'])) {
    $query = htmlspecialchars($_GET['query']);
    $safe_query = $db->real_escape_string($query);

    // SQL query to search for matches in first_name or last_name
    $sql = "SELECT first_name, last_name 
            FROM personell 
            WHERE first_name LIKE '%$safe_query%' OR last_name LIKE '%$safe_query%' 
            LIMIT 10";

    $result = $db->query($sql);

    $output = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $output[] = $row;
        }
    }

    echo json_encode($output);
} else {
    echo json_encode([]);
}

// Close the database connection
$db->close();
?>
