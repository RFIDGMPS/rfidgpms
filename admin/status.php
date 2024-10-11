<?php
include '../connection.php';

// Get today's date
$today = date('Y-m-d');

// Query to get the total number of users
$total_users_sql = "SELECT COUNT(*) as total_users FROM personell";
$total_users_result = $db->query($total_users_sql);
$total_users = ($total_users_result->num_rows > 0) ? $total_users_result->fetch_assoc()['total_users'] : 0;

// Query to get the number of users who arrived today
$arrived_users_sql = "SELECT COUNT(DISTINCT rfid_number) as arrived_users FROM personell_logs WHERE date_logged = '$today' AND role != 'Stranger'";
$arrived_users_result = $db->query($arrived_users_sql);
$arrived_users = ($arrived_users_result->num_rows > 0) ? $arrived_users_result->fetch_assoc()['arrived_users'] : 0;

// Calculate not arrived users
$not_arrived_users = $total_users - $arrived_users;

// Calculate percentages
$arrived_percentage = ($total_users > 0) ? ($arrived_users / $total_users) * 100 : 0;
$not_arrived_percentage = 100 - $arrived_percentage;

// Prepare data for JSON response
$response = [
    'arrived' => $arrived_percentage,
    'not_arrived' => $not_arrived_percentage
];

echo json_encode($response);
?>
