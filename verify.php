<?php
include 'connection.php';
session_start();
$ip_address = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$device_fingerprint = hash('sha256', $ip_address . $user_agent);

// Get token and code from URL
$token = $_GET['token'] ?? '';
$code = $_GET['code'] ?? '';

if (!$token || !$code) {
    $verification_message =  "Invalid verification link.";
    exit;
}

// Check if the token matches the one stored in the session
if ($token === $_SESSION['verification_token']) {
    // You can now validate the code as needed, e.g., check if the code matches the one sent via email
    if ($code === $_SESSION['verification_code']) {
        $verification_message = "Verification successful! You can now log in.";
        logSession($db, $ip_address, $device_fingerprint);
    } else {
        $verification_message = "Invalid verification code.";
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

?>

<!-- Check if there's a message to display -->
<?php if (!empty($verification_message)): ?>
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
<?php endif; ?>