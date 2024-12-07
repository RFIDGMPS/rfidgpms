<?php
session_start();
include '../connection.php'; // Assumes this file contains the $db connection
$email = $_SESSION['email'];
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include necessary files

include 'PHPMailer/src/Exception.php';
include 'PHPMailer/src/PHPMailer.php';
include 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$mail = new PHPMailer(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $user_id = $_SESSION['A_id']; // Adjust based on your session logic

    if ($new_password !== $confirm_password) {
        echo json_encode(['status' => 'error', 'message' => 'New passwords do not match!']);
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
            echo json_encode(['status' => 'error', 'message' => 'The current password you entered is incorrect.']);
            exit;
        }

        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_query = "UPDATE user SET password = ? WHERE id = ?";
        $update_stmt = $db->prepare($update_query);
        $update_stmt->bind_param('si', $new_hashed_password, $user_id);

        if ($update_stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Password updated successfully!']);
            sendLoginNotification($email);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'An error occurred. Please try again.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found.']);
    }

    $stmt->close();
    $db->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}



function sendLoginNotification($email) {
    global $mail;  // Reusing the already instantiated PHPMailer object

  
    try {
        // SMTP Settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'kyebejeanu@gmail.com';
        $mail->Password = 'krwr vqdj vzmq fiby'; // Use App Password if 2FA is enabled
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender and recipient settings
        $mail->setFrom('kyebejeanu@gmail.com', 'RFID GPMS');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Password Changed';
        $mail->Body = "Password has been changed recently.";

        // Send email
        if (!$mail->send()) {
            echo "Error sending email: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Mailer Error: " . $e->getMessage();
    }
}
?>
