
<?php
session_start();
include 'connection.php';
date_default_timezone_set('Asia/Manila');
// header("Content-Security-Policy: default-src 'self'; script-src 'self' 'sha256-<hash>'");
// header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
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
                //echo "Record ID " . $row['id'] . " updated successfully.<br>";
            } else {
                //echo "Error updating record ID " . $row['id'] . ": " . $db->error . "<br>";
            }
        }
    }
} else {
    //echo "No records found for yesterday in personell_logs.";
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
                //echo "Record updated successfully for ID: $id <br>";
            } else {
                //echo "Error updating record for ID: $id: " . $db->error . "<br>";
            }
        }
    }
} else {
    //echo "No records found with NULL or empty values for yesterday in room_logs.";
}


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
               // echo "Record updated successfully for ID: $id <br>";
            } 
        }
    }
}
?>



<?php





if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Secure token generation
}

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department = sanitizeInput($_POST['roomdpt']);
    $location = sanitizeInput($_POST['location']);
    $password = sanitizeInput($_POST['Ppassword']);
    $rfid_number = sanitizeInput($_POST['Prfid_number']);

    // Validate inputs (simple example, you can expand this)
    if (empty($department) || empty($location) || empty($password) || empty($rfid_number)) {
        echo "All fields are required.";
        exit;
    }

    // Assuming you have a login function that handles authentication
    // Use prepared statements for the database query
    $stmt = $db->prepare("SELECT * FROM users WHERE department = ? AND location = ? AND password = ? AND rfid_number = ?");
    $stmt->bind_param("ssss", $department, $location, password_hash($password, PASSWORD_DEFAULT), $rfid_number); // Use password_hash() for security
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Successful login
        $_SESSION['user'] = $department; // Save user data in session
        header("Location: main");
        exit;
    } else {
        echo "Invalid credentials.";
    }
}
?>
<?php 

// Strict-Transport-Security (HSTS)
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

// X-Frame-Options
header("X-Frame-Options: DENY");

// X-Content-Type-Options
header("X-Content-Type-Options: nosniff");

// Referrer-Policy
header("Referrer-Policy: no-referrer");

// Permissions-Policy
header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
?>
<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="utf-8">
      <title>RFIDGPMS</title>
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <meta content="" name="keywords">
      <meta content="" name="description">
      <link rel="icon" href="admin/uploads/logo.png" type="image/png">
      <!-- Favicon -->
      <!--     <link href="img/favicon.ico" rel="icon"> -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
      <link href="admin/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
      <link href="admin/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
      <link href="admin/css/bootstrap.min.css" rel="stylesheet">
      <link href="admin/css/style.css" rel="stylesheet">
      <link href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" rel="stylesheet" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
      <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
      <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
      <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
      <!--   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/elevatezoom/2.2.3/jquery.elevatezoom.js" integrity="sha512-EjW7LChk2bIML+/kvj1NDrPSKHqfQ+zxJGBUKcopijd85cGwAX8ojz+781Rc0e7huwyI3j5Bn6rkctL3Gy61qw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <style type="text/css">
         @media (max-width: 576px) and (max-width: 768px) {
         #lnamez {
         margin-top: 30%;
         display: block;
         /* remove extra space below image */
         }
         #up_img {
         position: relative;
         margin-top: 4%;
         display: block;
         /* remove extra space below image */
         }
         }
         @media (max-width: 992px) and (max-width: 1200px) {
         #lnamez {
         margin-top: 30%;
         display: block;
         /* remove extra space below image */
         }
         #up_img {
         position: relative;
         margin-top: 4%;
         display: block;
         /* remove extra space below image */
         }
         }
      </style>
      
   </head>
<?php
// Start the session
//session_start();

?>



<body>
   
<div class="container-fluid position-relative bg-white d-flex p-0">
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <form role="form" id="logform" method="POST"> 
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <div id="myalert3" style="display:none;">
                                <div class="alert alert-danger">
                                    <span id="alerttext"></span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <a href="index" class="">
                                    <h3 class="text-warning">GPMS</h3>
                                </a>
                                <h3>Location</h3>
                            </div>
                            <div>
                                <select class="form-control mb-4" name="roomdpt" id="roomdpt" autocomplete="off" onchange="fetchRooms()">
                                    <option value="Main" selected>Main</option>
                                    <?php
                                    $sql = "SELECT * FROM department";
                                    $result = $db->query($sql);
                                    while ($row = $result->fetch_assoc()) {
                                        $department_name = $row['department_name'];
                                        if ($department_name !== 'Main') {
                                            echo "<option value='$department_name'>$department_name</option>";
                                        }
                                    }
                                    ?>
                                </select>

                                <select class="form-control mb-4" name="location" id="location" autocomplete="off">
                                    <option value="Gate" selected>Gate</option>
                                </select>

                                <script>
                                    function fetchRooms() {
                                        var selectedDepartment = document.getElementById('roomdpt').value;
                                        if (selectedDepartment === "Main") {
                                            document.getElementById('location').innerHTML = "<option value='Gate' selected>Gate</option>";
                                        } else if (selectedDepartment) {
                                            var xhr = new XMLHttpRequest();
                                            xhr.onreadystatechange = function () {
                                                if (xhr.readyState === 4 && xhr.status === 200) {
                                                    document.getElementById('location').innerHTML = xhr.responseText;
                                                }
                                            };
                                            xhr.open('GET', 'get_rooms.php?department=' + encodeURIComponent(selectedDepartment), true);
                                            xhr.send();
                                        } else {
                                            document.getElementById('location').innerHTML = "<option value=''>Select Room</option>";
                                        }
                                    }
                                </script>
                            </div>

                            <div class="form-floating mb-4">
                                <input id="remember" type="password" class="form-control" name="Ppassword" placeholder="Password" autocomplete="off">
                                <label for="floatingPassword">Password</label>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check">
                                    <input type="checkbox" id="showPassword" onclick="togglePasswordVisibility()" class="form-check-input">
                                    <label class="form-check-label" for="showPassword">Show Password</label>
                                </div>
                            </div>
                            <input style="border-color:#084298; margin-bottom:30px;" type="text" name="Prfid_number" class="form-control" placeholder="Tap RFID card" autofocus>
                            <button hidden type="submit" class="btn btn-primary">Submit</button>
                            <a class="terms-link" href="../terms">Terms and Conditions</a>
                           
<style>
.terms-link {
    padding-left: 55%;
   
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
                        </form>
                      
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            $(document).ready(function () {
                                $('#logform').on('submit', function (event) {
                                    event.preventDefault();

                                    // Gather form data
                                    var formData = $(this).serialize();

                                    // Send form data via AJAX
                                    $.ajax({
                                        url: 'login',
                                        type: 'POST',
                                        data: formData,
                                        success: function (response) {
                                            if (response.trim() === 'success') {
                                                window.location.href = "main";
                                            } else {
                                                $('#alerttext').html(response);
                                                document.getElementById("myalert3").style.display = "block";
                                                setTimeout(function () {
                                                    $("#myalert3").fadeOut("slow");
                                                }, 3000);
                                            }
                                        },
                                        error: function () {
                                            $('#alerttext').html("Error in form submission.");
                                            document.getElementById("myalert3").style.display = "block";
                                        }
                                    });
                                });
                            });

                            function togglePasswordVisibility() {
                                var passwordField = document.getElementById("remember");
                                if (passwordField.type === "password") {
                                    passwordField.type = "text";
                                } else {
                                    passwordField.type = "password";
                                }
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
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
     <script type="text/javascript" src="assets/custom/js/admin_login.js"> </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="admin/lib/chart/chart.min.js"></script>
    <script src="admin/lib/easing/easing.min.js"></script>
    <script src="admin/lib/waypoints/waypoints.min.js"></script>
    <script src="admin/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="admin/lib/tempusdominus/js/moment.min.js"></script>
    <script src="admin/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="admin/js/main.js"></script>
</body>

</html>