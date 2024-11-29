<!DOCTYPE html>
<html lang="en">
    <?php include 'header.php';?>
<!-- <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Inline CSS for a beautiful layout */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            color: #333;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            text-align: center;
        }

        h2 {
            color: #4e54c8;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
        }

        input:focus {
            border-color: #4e54c8;
            box-shadow: 0 0 4px rgba(78, 84, 200, 0.5);
        }

        button {
            background: #4e54c8;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background: #3e41a8;
        }

        .form-group .error {
            color: #e74c3c;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .form-group .success {
            color: #2ecc71;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .link {
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .link a {
            color: #4e54c8;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head> -->
<body>
    <div class="container">
        <h2>Change Password</h2>
        <form action="process_change_password.php" method="POST">
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" placeholder="Enter current password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" placeholder="Enter new password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
            </div>
            <button type="submit">Update Password</button>
        </form>
        <div class="link">
            <a href="dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
