<?php
session_start(); // Start the session

if (!isset($_GET['token'])) {
    die("Invalid request. No token provided.");
}

$token = $_GET['token'];

// Check if the token matches and is not expired
if (isset($_SESSION['password_reset_token']) &&
    $token === $_SESSION['password_reset_token'] &&
    time() <= $_SESSION['password_reset_token_expiry']) {

        // Optionally, clear the token to prevent reuse
    unset($_SESSION['password_reset_token']);
    unset($_SESSION['password_reset_token_expiry']);
} else {
    // Token is invalid or expired
    die("Invalid or expired token.");
}

$_SESSION['A_id'] = 20240331;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #ffc107;
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
            background: #ffc107;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background: #dda80a;
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
        <h2>Change Password</h2>
        <form id="changePasswordForm">
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
       
    <div class="back-link">
        <a href="index">Back to Home</a>
    </div>
    </div>

    <script>
       document.getElementById('changePasswordForm').addEventListener('submit', async function (e) {
    e.preventDefault(); // Prevent form from submitting normally

    // Get the new and confirm password values
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    // Password strength validation regex: At least 8 characters, upper/lowercase, number, and special character
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    // Check if new password meets the strength criteria
    if (!passwordRegex.test(newPassword)) {
        Swal.fire({
            icon: 'error',
            title: 'Weak Password',
            text: 'Your password must be at least 8 characters long, include both upper and lower case letters, at least one number, and one special character.',
        });
        return; // Stop form submission
    }

    // Check if new password and confirm password match
    if (newPassword !== confirmPassword) {
        Swal.fire({
            icon: 'error',
            title: 'Password Mismatch',
            text: 'The new password and confirm password do not match.',
        });
        return; // Stop form submission
    }

    const formData = new FormData(this);

    try {
        const response = await fetch('process_change_password.php', {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();

        if (result.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: result.message,
            }).then(() => {
                window.location.href = 'index'; // Redirect on success
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: result.message,
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Unexpected Error',
            text: 'Something went wrong. Please try again.',
        });
    }
});

    </script>
</body>
</html>
