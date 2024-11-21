<?php
// Set the content type to JSON
header('Content-Type: application/json');

// Database connection settings
include '../connection.php';

// Check if a query parameter is set
if (isset($_GET['query'])) {
    $query = htmlspecialchars($_GET['query']); // Sanitize input
    $safe_query = $db->real_escape_string($query); // Escape special characters for security

    // SQL query to search for first or last name matching the input
    $sql = "SELECT id,first_name, last_name,category 
            FROM personell 
            WHERE first_name LIKE '%$safe_query%' OR last_name LIKE '%$safe_query%' AND category != 'Student'"; // Limit to 10 results

    // Execute the query
    $result = $db->query($sql);

    // If the query is successful, fetch the results
    if ($result) {
        $output = [];
        while ($row = $result->fetch_assoc()) {
            $output[] = $row; // Store the result in an array
        }
        echo json_encode($output); // Return the results as JSON
    } else {
        error_log('Query failed: ' . $db->error); // Log any query errors
        echo json_encode(['error' => 'Query failed']); // Return an error message in JSON format
    }
} else {
    echo json_encode(['error' => 'No query provided']); // Return an error if no query is provided
}

// Close the database connection
$db->close();
?>
