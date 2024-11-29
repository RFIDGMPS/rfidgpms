<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            padding: 40px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        input[type="email"],
        input[type="text"],
        input[type="password"],
        button {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #2575fc;
            outline: none;
        }

        .radio-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .captcha-section {
            text-align: center;
            margin: 15px 0;
        }

        .captcha-section img {
            width: 100%;
            max-width: 150px;
            margin-bottom: 10px;
        }

        button {
            background-color: #2575fc;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #6a11cb;
        }

        .back-link {
            text-align: center;
            margin-top: 15px;
        }

        .back-link a {
            color: #2575fc;
            text-decoration: none;
            font-weight: 500;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <form method="POST" action="session.php">
        <input type="email" name="email" placeholder="Enter your email" required>

        <label>Choose verification method:</label>
        <div class="radio-group">
            <label><input type="radio" name="verification_method" value="link" required> Verification Link</label>
            <label><input type="radio" name="verification_method" value="otp" required> Numeric OTP</label>
        </div>

        <div class="captcha-section">
            <img src="captcha.php" alt="CAPTCHA">
            <input type="text" name="captcha" placeholder="Enter CAPTCHA" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <div class="back-link">
        <a href="index.php">Back to Home</a>
    </div>
</div>

</body>
</html>



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
