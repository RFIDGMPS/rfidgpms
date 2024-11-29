<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Identity</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="email"],
        input[type="text"] {
            padding: 12px;
            margin: 10px 0;
            font-size: 16px;
            border: 2px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s;
        }

        input[type="email"]:focus,
        input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
        }

        label {
            font-size: 16px;
            color: #555;
            margin-bottom: 5px;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin: 10px 0;
        }

        .radio-group input {
            margin-top: 5px;
        }

        .captcha-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 15px 0;
        }

        .captcha-container img {
            max-width: 100%;
            margin-bottom: 10px;
        }

        button {
            padding: 12px;
            background-color: #ffc107;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #dda80a;
        }

        .back-link {
            text-align: center;
            margin-top: 15px;
        }

        .back-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

<div class="container">
    <h2>Unrecognized device has been detected. <br/>Please confirm your identity</h2>
    <form method="POST" action="session.php">
        <input type="email" name="email" placeholder="Email" required>

        <label>Choose verification method:</label>
        <div class="radio-group">
            <label><input type="radio" name="verification_method" value="link" required> Verification Link</label>
            <label><input type="radio" name="verification_method" value="otp" required> Numeric OTP</label>
        </div>

        <div class="captcha-container">
            <img src="captcha.php" alt="CAPTCHA">
            <input type="text" name="captcha" placeholder="Enter CAPTCHA" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <div class="back-link">
        <a href="index">Back to Home</a>
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

include '../connection.php';
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
