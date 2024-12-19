<?php
include '../connection.php'; 
// Query to fetch departments
$sql = "SELECT department_id, department_name FROM department";
$result = $db->query($sql);

// Prepare response
$departments = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row;
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($departments);

// Close connection
$db->close();
?>
