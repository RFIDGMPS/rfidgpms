<!DOCTYPE html>


<?php
include 'auth.php'; // Include session validation
?>

<html lang="en">

<?php
include 'header.php';
   ?>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start 
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        Spinner End -->
        <!-- Sidebar Start -->
        <?php
		include 'sidebar.php';
		?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <?php
		include 'navbar.php';
		?>


            <div class="container-fluid pt-4 px-4">
                <div class="col-sm-12 col-xl-12">

                    <div class="col-sm-12 col-xl-12">
                        <div class="bg-light rounded h-100 p-4">
                            <div class="row">
                                <div class="col-9">
                                    <h6 class="mb-4">Card Deactivation Request</h6>
                                </div>

                            </div>
                            <hr></hr>
                            <div class="table-responsive">
                                <table class="table table-border" id="myDataTable">
                                    <thead>
                                        <tr>
                                        <th scope="col">Action</th>
                                     
                                            <th scope="col">Photo</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">RFID Number</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        

                                        <?php
include 'connection.php';

// SQL query to join the 'personell' and 'lostcard' tables
$sql = "SELECT personell.id, 
       CONCAT(personell.first_name, ' ', personell.last_name) AS full_name, 
       personell.department, 
       personell.photo, 
       personell.rfid_number, 
       lostcard.date_requested, 
       lostcard.verification_photo, 
       lostcard.status
FROM personell
JOIN lostcard ON personell.id = lostcard.personnel_id
ORDER BY lostcard.id DESC;
";

$result = $db->query($sql);

// Function to calculate relative time
function timeAgo($datetime) {
    $now = new DateTime();
    $past = new DateTime($datetime);
    $diff = $now->diff($past);

    if ($diff->y > 0) {
        return $diff->y == 1 ? '1 year ago' : $diff->y . ' years ago';
    } elseif ($diff->m > 0) {
        return $diff->m == 1 ? '1 month ago' : $diff->m . ' months ago';
    } elseif ($diff->d > 1) {
        return $diff->d == 1 ? 'Yesterday' : $diff->d . ' days ago';
    } elseif ($diff->d == 1) {
        return 'Yesterday';
    } elseif ($diff->h > 0) {
        return $diff->h == 1 ? '1 hour ago' : $diff->h . ' hours ago';
    } elseif ($diff->i > 0) {
        return $diff->i == 1 ? '1 minute ago' : $diff->i . ' minutes ago';
    } else {
        return 'Just now';
    }
}

// Check if any rows are returned
if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        $relativeTime = timeAgo($row['date_requested']);
        echo "<tr>
                <td style='vertical-align:middle;'>
                ";
    
        if ($row['status'] == 0) {
            // Block button
            echo "<form method='POST'>
                    <input type='hidden' name='action' value='block'>
                    <input type='hidden' name='personnel_id' value='" . $row['id'] . "'>
                    <input type='hidden' name='lostcard_id' value='" . $row['personnel_id'] . "'>
                    <button onclick='blockUser(".$row['personnel_id'].", ".$row['id'].")' type='button' class='btn btn-outline-primary btn-sm btn-edit'>
                        <i class='bi bi-plus-edit'></i> Block
                    </button>
                     <input type='hidden' name='action' value='delete'>
                    <input type='hidden' name='personnel_id' value='" . $row['id'] . "'>
                    <button onclick='deleteUser(".$row['personnel_id'].")' type='button' class='btn btn-outline-danger btn-sm btn-del'>
                        <i class='bi bi-plus-trash'></i> Delete
                    </button>
                  </form>";
    
          
        } else {
            echo "<span class='badge bg-danger'>Blocked</span>";
        }
    
        echo "</td>
              <td><img src='uploads/" . $row['photo'] . "' width='50' height='50'> 
                  <img src='uploads/" . $row['verification_photo'] . "' width='50' height='50'></td>
              <td>" . $row['full_name'] . "</td>
              <td>" . $row['rfid_number'] . "</td>
              <td>" . $relativeTime . "</td>
          </tr>";
    }
    
    
   
} else {
    echo "No lost card records found.";
}

$db->close();
?>

<script>
// Block User Function
function blockUser(personnelId, lostcardId) {
    if (confirm("Are you sure you want to block this user?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            if (xhr.status === 200) {
                // Update the UI after successful update
                alert('User has been blocked.');
                location.reload(); // Reload page to reflect changes
            } else {
                console.error('Error updating status');
            }
        };

        xhr.send("action=block&personnel_id=" + personnelId + "&lostcard_id=" + lostcardId);
    }
}

// Delete User Function
function deleteUser(personnelId) {
    if (confirm("Are you sure you want to delete this user?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            if (xhr.status === 200) {
                // Update the UI after successful deletion
                alert('User has been deleted.');
                location.reload(); // Reload page to reflect changes
            } else {
                console.error('Error deleting user');
            }
        };

        xhr.send("action=delete&personnel_id=" + personnelId);
    }
}
</script>

                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
include 'footer.php';
			?>
        </div>

        <a href="#" class="btn btn-lg btn-warning btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>

</body>

</html>