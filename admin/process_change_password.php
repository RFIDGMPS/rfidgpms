<?php
session_start();
include '../connection.php'; // Assumes this file contains the $db connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = 1; // Adjust based on your session logic

    if ($new_password !== $confirm_password) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'New passwords do not match!'
                }).then(() => {
                    window.location.href = 'change_password';
                });
              </script>";
        exit;
    }

    $query = "SELECT password FROM user WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (!password_verify($current_password, $hashed_password)) {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Incorrect Password',
                        text: 'The current password you entered is incorrect.'
                    }).then(() => {
                        window.location.href = 'change_password';
                    });
                  </script>";
            exit;
        }

        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_query = "UPDATE user SET password = ? WHERE id = ?";
        $update_stmt = $db->prepare($update_query);
        $update_stmt->bind_param('si', $new_hashed_password, $user_id);

        if ($update_stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Password updated successfully!'
                    }).then(() => {
                        window.location.href = 'index';
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred. Please try again.'
                    }).then(() => {
                        window.location.href = 'change_password';
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'User Not Found',
                    text: 'Unable to find user details. Please try again.'
                }).then(() => {
                    window.location.href = 'change_password';
                });
              </script>";
    }

    $stmt->close();
    $db->close();
} else {
    header('Location: change_password');
    exit;
}
?>
