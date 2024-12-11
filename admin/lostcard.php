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
        <!-- Sidebar Start -->
        <?php include 'sidebar.php'; ?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <?php include 'navbar.php'; ?>

            <div class="container-fluid pt-4 px-4">
                <div class="col-sm-12 col-xl-12">
                    <div class="col-sm-12 col-xl-12">
                        <div class="bg-light rounded h-100 p-4">
                            <div class="row">
                                <div class="col-9">
                                    <h6 class="mb-4">Block Lost Card</h6>
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
                                            <th scope="col">Date Requested</th>
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
                                                ORDER BY lostcard.id DESC";

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
                                            } elseif ($diff->h > 0) {
                                                return $diff->h == 1 ? '1 hour ago' : $diff->h . ' hours ago';
                                            } elseif ($diff->i > 0) {
                                                return $diff->i == 1 ? '1 minute ago' : $diff->i . ' minutes ago';
                                            } else {
                                                return 'Just now';
                                            }
                                        }

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $relativeTime = timeAgo($row['date_requested']);
                                                echo "<tr>
                                                        <td style='vertical-align:middle;'>";
                                                if ($row['status'] == 0) {
                                                    echo "<button onclick=\"blockUser(" . $row['id'] . ", " . $row['id'] . ")\" class='btn btn-outline-primary btn-sm'>
                                                                <i class='bi bi-plus-edit'></i> Block
                                                          </button>
                                                          <button onclick=\"deleteUser(" . $row['id'] . ")\" class='btn btn-outline-danger btn-sm'>
                                                                <i class='bi bi-plus-trash'></i> Delete
                                                          </button>";
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'footer.php'; ?>
        </div>

        <a href="#" class="btn btn-lg btn-warning btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        // Block User Function
        function blockUser(personnelId, lostcardId) {
            Swal.fire({
                title: 'Are you sure you want to block this user?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, block it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "update_status.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            Swal.fire('Blocked!', 'The user has been blocked.', 'success').then(() => {
                                window.location.href = 'lostcard';
                            });
                        } else {
                            Swal.fire('Error', 'There was an error blocking the user.', 'error');
                        }
                    };
                    xhr.send("action=block&personnel_id=" + personnelId + "&lostcard_id=" + lostcardId);
                }
            });
        }

        // Delete User Function
        function deleteUser(personnelId) {
            Swal.fire({
                title: 'Are you sure you want to delete this request?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "update_status.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            Swal.fire('Deleted!', 'The request has been deleted.', 'success').then(() => {
                                window.location.href = 'lostcard';
                            });
                        } else {
                            Swal.fire('Error', 'There was an error deleting the request.', 'error');
                        }
                    };
                    xhr.send("action=delete&personnel_id=" + personnelId);
                }
            });
        }
    </script>
</body>
</html>
