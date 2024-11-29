<?php
include 'connection.php';
//require 'vendor/autoload.php'; // PHP Mailer autoloader
session_start();
require 'admin/PHPMailer/src/Exception.php';
require 'admin/PHPMailer/src/PHPMailer.php';
require 'admin/PHPMailer/src/SMTP.php';

//echo $_SERVER['REMOTE_ADDR'];
//echo $_SERVER['HTTP_USER_AGENT'];
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
// Database connection


// Process login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Input values
    $email = $_POST['email'];
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];
    $verification_method = $_POST['verification_method']; // 'email' or 'contact'

    // Validate CAPTCHA
    if ($captcha !== $_SESSION['captcha_code']) {
        echo "Invalid CAPTCHA!";
        exit;
    }

    // Check user credentials
    $query = "SELECT id, password, contact FROM user WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password, $contact);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Detect new device
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $device_fingerprint = hash('sha256', $ip_address . $user_agent);

            $check_device_query = "SELECT * FROM admin_sessions WHERE ip_address = ? AND device = ?";
            $check_stmt = $db->prepare($check_device_query);
            $check_stmt->bind_param('ss', $ip_address, $device_fingerprint);
            $check_stmt->execute();
            $device_result = $check_stmt->get_result();

            if ($device_result->num_rows > 0) {
                // Known device: log session and notify
                logSession($db, $user_id, $ip_address, $device_fingerprint);
                sendLoginNotification($email, $ip_address, $user_agent);
                echo "Login successful!";
            } else {
                // New device: send verification
                $verification_code = rand(100000, 999999);
                $_SESSION['verification_code'] = $verification_code;

                if ($verification_method === 'email') {
                    sendVerificationEmail($email, $verification_code);
                    echo "Verification code sent to your email.";
                } elseif ($verification_method === 'contact') {
                    sendOTP($contact, $verification_code);
                    echo "OTP sent to your contact number.";
                } else {
                    echo "Invalid verification method.";
                }

                logSession($db, $user_id, $ip_address, $device_fingerprint);
            }
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }

    $stmt->close();
}

$db->close();

function logSession($db, $user_id, $ip_address, $device_fingerprint) {
    $location = fetchLocation($ip_address);
    $query = "INSERT INTO admin_sessions (user_id, location, ip_address, device, date_logged) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $db->prepare($query);
    $stmt->bind_param('isss', $user_id, $location, $ip_address, $device_fingerprint);
    $stmt->execute();
    $stmt->close();
}

function fetchLocation($ip_address) {
    $geoData = json_decode(file_get_contents("http://ip-api.com/json/$ip_address"), true);
    return $geoData['city'] . ', ' . $geoData['country'];
}

function sendVerificationEmail($email, $code) {
    //$mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com'; // Replace with your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'kyebejeanu@gmail.com';
    $mail->Password = 'krwr vqdj vzmq fiby';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Sender and recipient settings
    $mail->setFrom('kyebejeanu@gmail.com', 'RFID GPMS');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Verification Required';
    $mail->Body = "Your verification code is <strong>$code</strong>";

    if (!$mail->send()) {
        echo "Error sending email: " . $mail->ErrorInfo;
    }
}

function sendOTP($contact, $code) {
    // Replace this block with your SMS gateway API integration
    echo "Simulated sending OTP $code to contact $contact.";
}

function sendLoginNotification($email, $ip_address, $user_agent) {
    //$mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com'; // Replace with your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'kyebejeanu@gmail.com';
        $mail->Password = 'krwr vqdj vzmq fiby';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
    
        // Sender and recipient settings
        $mail->setFrom('kyebejeanu@gmail.com', 'RFID GPMS');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'New Device Login Detected';
    $mail->Body = "We detected a login from a new device. If this was not you, secure your account immediately.";

    $mail->send();
}
?>
