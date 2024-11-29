<?php
session_start();

// Include necessary files
include 'connection.php';
include 'admin/PHPMailer/src/Exception.php';
include 'admin/PHPMailer/src/PHPMailer.php';
include 'admin/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = $_POST['otp'];
    $verification_code = $_SESSION['verification_code']; // Retrieve the OTP from the session

    // Check if OTP matches the code sent
    if ($otp == $verification_code) {
        echo "<h3>Verification successful!</h3>";
        // Proceed with the next step, like redirecting to a dashboard
    } else {
        echo "<h3 style='color:red;'>Invalid OTP. Please try again.</h3>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
    <?php include 'admin/header.php';?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #ffc107;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #dda80a;
        }
        .form-group .back-link {
            display: block;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Verify OTP</h2>

    <form action="verifyotp.php" method="POST">
        <div class="form-group">
            <label for="otp">Enter the OTP sent to your email:</label>
            <input type="text" id="otp" name="otp" required>
        </div>

        <div class="form-group">
            <button type="submit">Verify OTP</button>
        </div>

        <div class="form-group">
            <a href="login.php" class="back-link">Back to Login</a>
        </div>
    </form>
</div>

</body>
</html>
