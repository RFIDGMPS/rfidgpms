<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include 'connection.php';
session_start();
$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$device_fingerprint = hash('sha256', $ip_address . $user_agent);
$email = $_SESSION['email'];
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'admin/PHPMailer/src/Exception.php';
include 'admin/PHPMailer/src/PHPMailer.php';
include 'admin/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Get token and code from URL
$token = $_GET['token'] ?? '';
$code = $_GET['code'] ?? '';
$mail = new PHPMailer(true);
if (!$token || !$code) {
    $verification_message =  "Invalid verification link.";
    exit;
}

// Check if the token matches the one stored in the session
if ($token === $_SESSION['verification_token']) {
    // You can now validate the code as needed, e.g., check if the code matches the one sent via email
    if ($code === $_SESSION['verification_code']) {
        $verification_message = "Verification successful! You can now log in.";
        sendLoginNotification($email, $ip_address, $user_agent);
        logSession($db, $ip_address, $device_fingerprint);
        
    } else {
        $verification_message = "Invalid verification code.". $_SESSION['verification_code'];
    }
} else {
    $verification_message =  "Invalid verification link.";
}

function logSession($db, $ip_address, $device_fingerprint) {
    $location = fetchLocation($ip_address);
    $query = "INSERT INTO admin_sessions (location, ip_address, device, date_logged) VALUES (?, ?, ?, NOW())";
    $stmt = $db->prepare($query);
    $stmt->bind_param('sss', $location, $ip_address, $device_fingerprint);
    $stmt->execute();
    $stmt->close();
}


function fetchLocation($ip_address) {
    $geoData = json_decode(file_get_contents("http://ip-api.com/json/$ip_address"), true);
    return $geoData['city'] . ', ' . $geoData['country'];
}


function sendLoginNotification($email, $ip_address, $user_agent) {
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
        $mail->Subject = 'New Device Login Detected';
        $mail->Body = "We detected a login from a new device. If this was not you, secure your account immediately.";

        // Send email
        if (!$mail->send()) {
            echo "Error sending email: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Mailer Error: " . $e->getMessage();
    }
}
?>

<!-- Check if there's a message to display -->
<?php if (!empty($verification_message)): ?>
    <body>
    <script>
        // Display SweetAlert based on the message
        Swal.fire({
            title: '<?php echo $verification_message; ?>',
            icon: '<?php echo ($code == $token) ? "success" : "error"; ?>',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed && '<?php echo ($code == $token) ? "success" : "error"; ?>' === "success") {
                window.location.href = "admin/index"; // Redirect to admin page on successful OTP
            }
        });
    </script>
    </body>
<?php endif; ?>