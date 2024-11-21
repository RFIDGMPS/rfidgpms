<?php
// Database connection
include '../connection.php';


if (isset($_GET['query'])) {
    $query = htmlspecialchars($_GET['query']);
    $safe_query = $db->real_escape_string($query);

    $sql = "SELECT first_name, last_name 
            FROM personell 
            WHERE first_name LIKE '%$safe_query%' OR last_name LIKE '%$safe_query%' 
            LIMIT 10";

    $result = $db->query($sql);

    if ($result) {
        $output = [];
        while ($row = $result->fetch_assoc()) {
            $output[] = $row;
        }
        echo json_encode($output);
    } else {
        echo json_encode(['error' => 'Query failed']);
    }
} else {
    echo json_encode(['error' => 'No query provided']);
}

// Close the database connection
$db->close();
?>
