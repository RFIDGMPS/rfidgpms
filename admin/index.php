
<?php
// Include PHPMailer classes (adjust the path to your project structure)
// require 'PHPMailer/src/Exception.php';
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';

// //echo $_SERVER['REMOTE_ADDR'];
// //echo $_SERVER['HTTP_USER_AGENT'];
// // Import PHPMailer classes into the global namespace
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// // Create a new PHPMailer instance
// $mail = new PHPMailer(true);

// // Set up PHPMailer (similar to the code I provided earlier)
// try {
//     $mail->isSMTP();
//     $mail->Host = 'smtp.gmail.com';
//     $mail->SMTPAuth = true;
//     $mail->Username = 'kyebejeanu@gmail.com';
//     $mail->Password = 'krwr vqdj vzmq fiby';
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
//     $mail->Port = 587;

//     // Sender and recipient settings
//     $mail->setFrom('kyebejeanu@gmail.com', 'RFID GPMS');
//     $mail->addAddress('$email', $admin);

//     // Email content
//     $mail->isHTML(true);
//     $mail->Subject = 'Test email';
//     $mail->Body    = 'This is a test email sent using PHPMailer!';
//     $mail->AltBody = 'This is a plain text body for non-HTML clients';

//     // Send email
//     $mail->send();
//     echo 'Email sent successfully!';
// } catch (Exception $e) {
//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// }
?>

<?php
session_start();
session_regenerate_id(true); // Prevent session fixation attacks
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'sha256-<hash>'");
// header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
// Generate CSRF token if not already set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Include database connection securely
include '../connection.php';
date_default_timezone_set('Asia/Manila');
?>

<?php


// Get the date for yesterday
$yesterday = date('Y-m-d', strtotime('-1 day'));

// Fetch records from personell_logs for yesterday
$sql = "SELECT id, time_in_am, time_in_pm, time_out_am, time_out_pm 
        FROM personell_logs 
        WHERE DATE(date_logged) = '$yesterday'";

$result = $db->query($sql);

// Check if there are any records
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Initialize an empty array to store the fields that need updating
        $updateFields = [];

        // Check each field if it is NULL or an empty string and prepare for update
        if (is_null($row['time_in_am']) || $row['time_in_am'] === '') {
            $updateFields[] = "time_in_am = '?'";
        }
        if (is_null($row['time_in_pm']) || $row['time_in_pm'] === '') {
            $updateFields[] = "time_in_pm = '?'";
        }
        if (is_null($row['time_out_am']) || $row['time_out_am'] === '') {
            $updateFields[] = "time_out_am = '?'";
        }
        if (is_null($row['time_out_pm']) || $row['time_out_pm'] === '') {
            $updateFields[] = "time_out_pm = '?'";
        }

        // If there are fields to update, run the update query
        if (!empty($updateFields)) {
            // Convert the array to a string for the SET clause
            $updateQuery = implode(", ", $updateFields);
            
            // Update query for the specific record
            $updateSql = "UPDATE personell_logs 
                          SET $updateQuery 
                          WHERE id = " . $row['id'];

            // Execute the update query
            if ($db->query($updateSql) === TRUE) {
                echo "Record ID " . $row['id'] . " updated successfully.<br>";
            } 
        }
    }
} 

// Fetch records from room_logs for yesterday
$sql = "SELECT * FROM room_logs WHERE DATE(date_logged) = '$yesterday' AND (time_in IS NULL OR time_out IS NULL OR time_in = '' OR time_out = '')";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // Loop through all rows with NULL or empty time fields
    while ($row = $result->fetch_assoc()) {
        $id = $row['id']; // Assuming you have an 'id' column in room_logs for identification
        
        $updateFields = [];
        // Check if time_in is NULL or an empty string and needs to be updated
        if (is_null($row['time_in']) || $row['time_in'] === '') {
            $updateFields[] = "time_in = '?'";
        }
        // Check if time_out is NULL or an empty string and needs to be updated
        if (is_null($row['time_out']) || $row['time_out'] === '') {
            $updateFields[] = "time_out = '?'";
        }
        
        // Only update if there's something to update
        if (!empty($updateFields)) {
            $updateQuery = "UPDATE room_logs SET " . implode(", ", $updateFields) . " WHERE id = $id";
            if ($db->query($updateQuery) === TRUE) {
                echo "Record updated successfully for ID: $id <br>";
            } 
        }
    }
}


// Fetch records from room_logs for yesterday
$sql = "SELECT * FROM visitor_logs WHERE DATE(date_logged) = '$yesterday' AND (time_in IS NULL OR time_out IS NULL OR time_in = '' OR time_out = '')";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // Loop through all rows with NULL or empty time fields
    while ($row = $result->fetch_assoc()) {
        $id = $row['id']; // Assuming you have an 'id' column in room_logs for identification
        
        $updateFields = [];
        // Check if time_in is NULL or an empty string and needs to be updated
        if (is_null($row['time_in']) || $row['time_in'] === '') {
            $updateFields[] = "time_in = '?'";
        }
        // Check if time_out is NULL or an empty string and needs to be updated
        if (is_null($row['time_out']) || $row['time_out'] === '') {
            $updateFields[] = "time_out = '?'";
        }
        
        // Only update if there's something to update
        if (!empty($updateFields)) {
            $updateQuery = "UPDATE visitor_logs SET " . implode(", ", $updateFields) . " WHERE id = $id";
            if ($db->query($updateQuery) === TRUE) {
                echo "Record updated successfully for ID: $id <br>";
            } 
        }
    }
}
?>

<?php
// Initialize variables for login attempts
$maxAttempts = 3; // Limit to 3 failed login attempts
$lockoutTime = 300; // Lockout time in seconds (5 minutes)
$errorMessage = '';

// Check if the session has 'login_attempts' and 'lockout' set
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lockout'] = time();
}

// Handle form submission
if (isset($_POST['login'])) {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $errorMessage = "Invalid request.";
    } else {
        // Check if the user is locked out
        if ($_SESSION['login_attempts'] >= $maxAttempts && (time() - $_SESSION['lockout']) < $lockoutTime) {
            $remainingTime = $lockoutTime - (time() - $_SESSION['lockout']);
            $errorMessage = "Too many failed login attempts. Please wait " . ceil($remainingTime / 60) . " minutes.";
        } else {
            // Reset attempts if the lockout period is over
            if ($_SESSION['login_attempts'] >= $maxAttempts && (time() - $_SESSION['lockout']) >= $lockoutTime) {
                $_SESSION['login_attempts'] = 0;
            }

            // Sanitize and validate inputs
            $username1 = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $password1 = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

            // Use prepared statements to prevent SQL injection
            $stmt = $db->prepare("SELECT * FROM user WHERE username = ? LIMIT 1");
            $stmt->bind_param("s", $username1);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password1, $row['password'])) {
                    // Successful login
                    $ip_address = $_SERVER['REMOTE_ADDR'];
                    $user_agent = $_SERVER['HTTP_USER_AGENT'];
                    $device_fingerprint = hash('sha256', $ip_address . $user_agent);



                    $check_device_query = "SELECT * FROM admin_sessions WHERE ip_address = ? AND device = ?";
                    $check_stmt = $db->prepare($check_device_query);
                    $check_stmt->bind_param('ss', $ip_address, $device_fingerprint);
                    $check_stmt->execute();
                    $device_result = $check_stmt->get_result();
        
                    if ($device_result->num_rows > 0) {
                  
                        $_SESSION['login_attempts'] = 0;
                    
                        $_SESSION['username'] = $username1;
    
                        header("Location: dashboard");
                        exit();
                    } else {
                        header("Location: verification");
                        exit();
                    }



                    
                } else {
                    // Invalid password
                    $_SESSION['login_attempts']++;
                    $errorMessage = "Invalid username or password.";
                }
            } else {
                // Invalid username
                $_SESSION['login_attempts']++;
                $errorMessage = "Invalid username or password.";
            }

            // Lockout after max attempts
            if ($_SESSION['login_attempts'] >= $maxAttempts) {
                $_SESSION['lockout'] = time();
                $errorMessage = "Too many failed login attempts. Please wait 5 minutes before trying again.";
            }

            $stmt->close();
        }
    }
}

// Pass the error message to JavaScript
echo "<script>var errorMessage = '" . addslashes($errorMessage) . "';</script>";
$remainingLockoutTime = max(0, $lockoutTime - (time() - $_SESSION['lockout']));
echo "<script>var lockout = { attempts: " . $_SESSION['login_attempts'] . ", remaining: " . $remainingLockoutTime . " };</script>";
?>






<!-- HTML and JavaScript portion -->
<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>

<body>  <div class="container-fluid position-relative bg-white d-flex p-0">
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                    <form id="logform" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                        <div id="myalert3" style="display:none;">
                            <div class="alert alert-danger">
                                <span id="alerttext"></span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="text-warning">ADMIN</h3>
                            <h3>Sign In</h3>
                        </div>

                        <div class="form-floating mb-3">
                            <input id="uname" type="text" class="form-control" name="username" placeholder="Username" autocomplete="off" required>
                            <label for="username">Username</label>
                        </div>

                        <div class="form-floating mb-4">
                            <input id="password" type="password" class="form-control" name="password" placeholder="Password" autocomplete="off" required>
                            <label for="password">Password</label>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input type="checkbox" id="remember" class="form-check-input" onclick="togglePasswordVisibility()">
                                <label class="form-check-label" for="remember">Show Password</label>
                            </div>
                        </div>

                        <button id="but" type="submit" name="login" class="btn btn-warning py-3 w-100 mb-4">Sign In</button>

                        <!-- Countdown Timer -->
                        <div id="lockout-message" class="text-danger" style="display: none;">
                            Too many attempts. Try again in <span id="countdown"></span> seconds.
                        </div>
                       
                    </form>
                    <a class="terms-link" href="forgot_password">Forgot Password</a>
<style>
.terms-link {
    padding-left: 70%;
    font-size: 12px;
    color: gray;
    text-decoration: none; /* Removes the default underline */
    cursor: pointer;      /* Ensures pointer cursor */
}

.terms-link:hover {
    text-decoration: underline; /* Adds underline on hover */
    color: black;              /* Optional: Changes color on hover */
}

</style>
</div>
                
            </div>

        </div>
     
    </div>
</div>

<script>
    // Toggle password visibility
    function togglePasswordVisibility() {
        var passwordField = document.getElementById("password");
        passwordField.type = passwordField.type === "password" ? "text" : "password";
    }

    // Display error messages if any
    if (typeof errorMessage !== 'undefined' && errorMessage !== '') {
        document.getElementById('myalert3').style.display = 'block';
        document.getElementById('alerttext').innerText = errorMessage;
        fadeOutAlert();
    }

    // Fade out alert after 3 seconds
    function fadeOutAlert() {
        setTimeout(function() {
            document.getElementById('myalert3').style.display = 'none';
        }, 3000);
    }

    // Handle lockout and countdown
    if (lockout.attempts >= <?php echo $maxAttempts; ?> && lockout.remaining > 0) {
        document.getElementById('uname').disabled = true;
        document.getElementById('password').disabled = true;
        document.getElementById('but').disabled = true;

        // Show lockout message and countdown timer
        document.getElementById('lockout-message').style.display = 'block';
        var countdownElement = document.getElementById('countdown');
        var remainingTime = lockout.remaining;

        var interval = setInterval(function() {
            remainingTime--;
            countdownElement.textContent = remainingTime;

            // Re-enable form after countdown
            if (remainingTime <= 0) {
                clearInterval(interval);
                document.getElementById('uname').disabled = false;
                document.getElementById('password').disabled = false;
                document.getElementById('but').disabled = false;
                document.getElementById('lockout-message').style.display = 'none';
            }
        }, 1000);
    }
</script>

       <script type="text/javascript">
    // Disable right-click
    document.addEventListener('contextmenu', (e) => e.preventDefault());

    function ctrlShiftKey(e, keyCode) {
      return e.ctrlKey && e.shiftKey && e.keyCode === keyCode.charCodeAt(0);
    }

    document.onkeydown = (e) => {
      // Disable F12, Ctrl + Shift + I, Ctrl + Shift + J, Ctrl + U
      if (
        event.keyCode === 123 ||
        ctrlShiftKey(e, 'I') ||
        ctrlShiftKey(e, 'J') ||
        ctrlShiftKey(e, 'C') ||
        (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0))
      )
        return false;
    };
  </script>
  <script>
      $('body').keydown(function(e) {
        if(e.which==123){
            e.preventDefault();
        }
        if(e.ctrlKey && e.shiftKey && e.which == 73){
            e.preventDefault();
        }
        if(e.ctrlKey && e.shiftKey && e.which == 75){
            e.preventDefault();
        }
        if(e.ctrlKey && e.shiftKey && e.which == 67){
            e.preventDefault();
        }
        if(e.ctrlKey && e.shiftKey && e.which == 74){
            e.preventDefault();
        }
    });
!function() {
        function detectDevTool(allow) {
            if(isNaN(+allow)) allow = 100;
            var start = +new Date();
            debugger;
            var end = +new Date();
            if(isNaN(start) || isNaN(end) || end - start > allow) {
                console.log('DEVTOOLS detected '+allow);
            }
        }
        if(window.attachEvent) {
            if (document.readyState === "complete" || document.readyState === "interactive") {
                detectDevTool();
              window.attachEvent('onresize', detectDevTool);
              window.attachEvent('onmousemove', detectDevTool);
              window.attachEvent('onfocus', detectDevTool);
              window.attachEvent('onblur', detectDevTool);
            } else {
                setTimeout(argument.callee, 0);
            }
        } else {
            window.addEventListener('load', detectDevTool);
            window.addEventListener('resize', detectDevTool);
            window.addEventListener('mousemove', detectDevTool);
            window.addEventListener('focus', detectDevTool);
            window.addEventListener('blur', detectDevTool);
        }
    }();
  </script>
     <script type="text/javascript" src="../assets/custom/js/admin_login.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>