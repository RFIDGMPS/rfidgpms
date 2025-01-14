<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include '../connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
//require 'vendor/autoload.php'; // PHP Mailer autoloader
session_start();
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$device_fingerprint = hash('sha256', $ip_address . $user_agent);
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$verification_message='';
$mail = new PHPMailer(true);

// Process login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Input values
    $email = $_POST['email'];
    //$password = $_POST['password'];
    $captcha = $_POST['captcha'];
    $verification_method = $_POST['verification_method']; // 'email' or 'contact'

    // Validate CAPTCHA
    if ($captcha !== $_SESSION['captcha_code']) {
        $verification_message =  "Invalid CAPTCHA!";
        
    }
else {
    // Check user credentials
    $query = "SELECT id, password, contact FROM user WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password, $contact);
        $stmt->fetch();

   
       
               
    
                // New device: send verification
                $verification_code = rand(100000, 999999);
                $_SESSION['verification_code'] = $verification_code;

                if ($verification_method === 'otp') {
                    sendOTPEmail($email, $verification_code);
                    echo "Verification code sent to your email.";
                    $_SESSION['verification_code']=$verification_code;
                    $_SESSION['email'] = $email;
                    if(isset($_GET['change_password'])){
                    header("Location: verifyotp?change_password");
                    }
                    else {
                        header("Location: verifyotp");
                    }
    exit();
                    
                } 
                elseif ($verification_method === 'link') {
                    sendLinkEmail($email, $verification_code);
                 
                    $_SESSION['verification_code']=$verification_code;
                    $_SESSION['email'] = $email;
                    $verification_message = 'Verification link sent to your email.';
                } 
                else {
                    $verification_message = "Invalid verification method.";
                }

               
            
            
    } else {
        $verification_message = "Invalid email.";
    }
    
    $stmt->close();
}

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
 
if(isset($_GET['change_password'])){
    function generate_secure_token() {
        return bin2hex(random_bytes(16)); // Generate a random, secure token
    }
    
    // Generate token and store it in the session
    $token = generate_secure_token();
    $_SESSION['password_reset_token'] = $token;
    $_SESSION['password_reset_token_expiry'] = time() + (15 * 60); // Token expires in 15 minutes
    
    // Secure link
    $verification_link = "https://rfidgpms.com/admin/change_password.php?token=" . urlencode($token);
    
}else {
    $verification_link = "https://rfidgpms.com/admin/verify.php?token=$token&code=$code";
}
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
        $mail->Body = "Click the following link to verify your identity: <a href='$verification_link'>Verify</a>";
    

        // Send email
        if (!$mail->send()) {
            echo "Error sending email: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Mailer Error: " . $e->getMessage();
    }
}

?>

<?php if (!empty($verification_message)): ?>
    <body>
    <script>
        // Display SweetAlert based on the message
        Swal.fire({
            title: '<?php echo $verification_message; ?>',
            icon: '<?php echo (strpos($verification_message, "sent") !== false || strpos($verification_message, "Verification code") !== false) ? "success" : "error"; ?>',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                <?php if (strpos($verification_message, "sent") !== false || strpos($verification_message, "Verification code") !== false): ?>
                    window.location.href = "index"; // Redirect to admin page on success
                    <?php elseif (isset($_GET['change_password'])): ?>
                        window.location.href = "forgot_password";
                    <?php else: ?>
                    window.location.href = "verification"; // Redirect to new_device.php on error
                <?php endif; ?>
            }
        });
    </script>
    </body>
<?php endif; ?>

