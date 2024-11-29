<?php
include 'connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
//require 'vendor/autoload.php'; // PHP Mailer autoloader
session_start();
require 'admin/PHPMailer/src/Exception.php';
require 'admin/PHPMailer/src/PHPMailer.php';
require 'admin/PHPMailer/src/SMTP.php';
$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$device_fingerprint = hash('sha256', $ip_address . $user_agent);
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

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
           
            $check_device_query = "SELECT * FROM admin_sessions WHERE ip_address = ? AND device = ?";
            $check_stmt = $db->prepare($check_device_query);
            $check_stmt->bind_param('ss', $ip_address, $device_fingerprint);
            $check_stmt->execute();
            $device_result = $check_stmt->get_result();

            if ($device_result->num_rows > 0) {
                echo 'IP:'.$ip_address;
                echo 'Device:'.$device_fingerprint;
                header("Location: admin/dashboard");
                exit();
            } else {
                echo 'IP:'.$ip_address;
                echo 'Device:'.$device_fingerprint;
    //             exit();
    //             // New device: send verification
    //             $verification_code = rand(100000, 999999);
    //             $_SESSION['verification_code'] = $verification_code;

    //             if ($verification_method === 'otp') {
    //                 sendOTPEmail($email, $verification_code);
    //                 echo "Verification code sent to your email.";
    //                 $_SESSION['verification_code']=$verification_code;
    //                 $_SESSION['email'] = $email;
    //                 header("Location: verifyotp");
    // exit();
                    
    //             } 
    //             elseif ($verification_method === 'link') {
    //                 sendLinkEmail($email, $verification_code);
    //                 echo "Verification link sent to your email.";
                    
    //             } 
    //             else {
    //                 echo "Invalid verification method.";
    //             }

               
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




function sendOTPEmail($email, $code) {
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
        $mail->Subject = 'Verification Required';
        $mail->Body = "Your verification code is <strong>$code</strong>";

        // Send email
        if (!$mail->send()) {
            echo "Error sending email: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Mailer Error: " . $e->getMessage();
    }


    
}

function sendLinkEmail($email, $code) {
    global $mail;  // Reusing the already instantiated PHPMailer object
 // Generate a random token (this can be used to identify the link)
 $token = bin2hex(random_bytes(16)); // 16 bytes = 32 characters
 $_SESSION['verification_token'] = $token; // Store the token in the session for validation later

 // Create the verification link
 $verification_link = "https://rfidgpms.com/verify.php?token=$token&code=$code";

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
        $mail->Subject = 'Verification Required';
        $mail->Body = "Click the following link to verify your login: <a href='$verification_link'>Verify Login</a>";
    

        // Send email
        if (!$mail->send()) {
            echo "Error sending email: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Mailer Error: " . $e->getMessage();
    }
}

?>
