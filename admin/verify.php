<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include '../connection.php';
session_start();
$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$device_fingerprint = hash('sha256', $ip_address . $user_agent);
$email = $_SESSION['email'];
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'PHPMailer/src/Exception.php';
include 'PHPMailer/src/PHPMailer.php';
include 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Get token and code from URL
$token = $_GET['token'] ?? '';
$code = $_GET['code'] ?? '';
$mail = new PHPMailer(true);
$verification_status = ''; // To track success or failure

if (!$token || !$code) {
    $verification_message = "Invalid verification link.";
    $verification_status = 'error';
} else {
    // Check if the token matches the one stored in the session
    if ($token === $_SESSION['verification_token']) {
        // Validate the code
        if ($code == $_SESSION['verification_code']) {
            $verification_message = "Verification successful! <br/>You can now log in.";
            $verification_status = 'success';
            sendLoginNotification($email, $ip_address, $user_agent);
            logSession($db, $ip_address, $device_fingerprint);
        } else {
            $verification_message = "Invalid verification code.";
            $verification_status = 'error';
        }
    } else {
        $verification_message = "Invalid verification link.";
        $verification_status = 'error';
    }
}

// Function to log the session details
function logSession($db, $ip_address, $device_fingerprint) {
    $location = fetchLocation($ip_address);
    $query = "INSERT INTO admin_sessions (location, ip_address, device, date_logged) VALUES (?, ?, ?, NOW())";
    $stmt = $db->prepare($query);
    $stmt->bind_param('sss', $location, $ip_address, $device_fingerprint);
    $stmt->execute();
    $stmt->close();
}

// Function to fetch the user's location based on IP
function fetchLocation($ip_address) {
    $geoData = json_decode(file_get_contents("http://ip-api.com/json/$ip_address"), true);
    return $geoData['city'] . ', ' . $geoData['country'];
}

// Function to send login notification email
function sendLoginNotification($email, $ip_address, $user_agent) {
    global $mail;  // Reusing the already instantiated PHPMailer object

    function generate_secure_token() {
        return bin2hex(random_bytes(16)); // Generate a random, secure token
    }
    
    // Generate token and store it in the session
    $token = generate_secure_token();
    $_SESSION['password_reset_token'] = $token;
    $_SESSION['password_reset_token_expiry'] = time() + (15 * 60); // Token expires in 15 minutes
    
    // Secure link
    $secure_link = "https://rfidgpms.com/admin/change_password.php?token=" . urlencode($token);
    
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
        $mail->Body = "We detected a login from a new device. If this was not you, please <a href='$secure_link'>secure your account</a> immediately.";

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
        // Display SweetAlert based on the verification status
        Swal.fire({
            title: '<?php echo $verification_status === "success" ? "Success!" : "Error!"; ?>',
            html: '<?php echo $verification_message; ?>',
            icon: '<?php echo $verification_status; ?>',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect based on verification status
                window.location.href = "<?php echo $verification_status === 'success' ? 'index' : 'login.php'; ?>";
            }
        });
    </script>
    </body>
<?php endif; ?>
