
<form method="POST" action="session.php">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>

    <label>Choose verification method:</label><br>
    <input type="radio" name="verification_method" value="link" required> Verification Link<br>
    <input type="radio" name="verification_method" value="otp" required> Numeric OTP<br>

    <img src="captcha.php" alt="CAPTCHA">
    <input type="text" name="captcha" placeholder="Enter CAPTCHA" required>
    <button type="submit">Login</button>
</form>

<?php
// include 'connection.php'; // Assuming connection.php initializes the $db variable with a database connection

// // SQL query to delete all rows from the admin_sessions table
// $query = "DELETE FROM admin_sessions"; 

// // Prepare the query using the $db object
// $stmt = $db->prepare($query);

// if ($stmt->execute()) {
//     echo "All records from admin_sessions have been deleted.";
// } else {
//     echo "Error deleting records: " . $stmt->error;
// }

// // Close the prepared statement
// $stmt->close();
?>




<?php

include 'connection.php';
session_start();

// Query to fetch admin session data
$query = "SELECT * FROM admin_sessions ORDER BY date_logged DESC"; // You can modify the order as needed
$result = $db->query($query);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>User ID</th>
                <th>Location</th>
                <th>IP Address</th>
                <th>Device</th>
                <th>Date Logged</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['user_id']) . "</td>
                <td>" . htmlspecialchars($row['location']) . "</td>
                <td>" . htmlspecialchars($row['ip_address']) . "</td>
                <td>" . htmlspecialchars($row['device']) . "</td>
                <td>" . htmlspecialchars($row['date_logged']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No session data available.";
}

$db->close();
?>
