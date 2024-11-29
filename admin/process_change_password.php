<?php
session_start();
include '../connection.php'; // Assumes this file contains the $db connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user's input
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Assumes the user ID is stored in the session
    $user_id = 1; 

    // Validate new passwords match
    if ($new_password !== $confirm_password) {
        echo "<script>
                alert('New passwords do not match!');
                window.location.href = 'change_password';
              </script>";
        exit;
    }

    // Fetch the current password from the database
    $query = "SELECT password FROM user WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verify the current password
        if (!password_verify($current_password, $hashed_password)) {
            echo "<script>
                    alert('Current password is incorrect!');
                    window.location.href = 'change_password';
                  </script>";
            exit;
        }

        // Update to the new password
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_query = "UPDATE user SET password = ? WHERE id = ?";
        $update_stmt = $db->prepare($update_query);
        $update_stmt->bind_param('si', $new_hashed_password, $user_id);

        if ($update_stmt->execute()) {
            echo "<script>
                    alert('Password updated successfully!');
                    window.location.href = 'index';
                  </script>";
        } else {
            echo "<script>
                    alert('Error updating password. Please try again.');
                    window.location.href = 'change_password';
                  </script>";
        }
    } else {
        echo "<script>
                alert('User not found!');
                window.location.href = 'change_password';
              </script>";
    }

    $stmt->close();
    $db->close();
} else {
    // If not a POST request, redirect to the form
    header('Location: change_password');
    exit;
}
?>
