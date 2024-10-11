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
        <?php
		include 'navbar.php';
		?>


            <div class="container-fluid pt-4 px-4">
                <div class="col-sm-12 col-xl-12">
                    <div class="col-sm-12 col-xl-12">
                        <div class="bg-light rounded h-100 p-4">
                            <div class="row">
                                <div class="col-9">
                                    <h6 class="mb-4">Entrance Logs</h6>
                                </div>
                            </div>
                            <hr></hr>
                            <div class="table-responsive">
                                <table class="table table-border" id="myDataTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Photo</th>
                                            <th scope="col">RFID Number</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Time In (AM)</th>
                                            <th scope="col">Time Out (AM)</th>
                                            <th scope="col">Time In (PM)</th>
                                            <th scope="col">Time Out (PM)</th>
                                            <th scope="col">Date Logged</th>
                                          

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php include '../connection.php'; ?>
                                 <?php $results = mysqli_query($db, "SELECT * FROM entrance"); ?>
                                 <?php while ($row = mysqli_fetch_array($results)) { ?>
                                        <tr>
                                            <td>
                                                <center><img src="uploads/<?php echo $row['photo']; ?>" width="50px" height="50px"></center>
                                            </td>
                                            <td><?php echo $row['rfid_number']; ?></td>
                                            <td><?php echo $row['role']; ?></td>
                                            <td><?php echo $row['full_name']; ?></td>

                                            <td><?php echo $row['time_in_am']; ?></td>
                                            <td>
                                            <?php echo $row['time_out_am']; ?></td>
                                            <td><?php echo $row['time_in_pm']; ?></td>
                                            <td>
                                            <?php echo $row['time_out_pm']; ?></td>
                                            <td><?php echo $row['date_logged']; ?></td>
                                           
                                        </tr>
                                        <?php } ?>
                                   
                                      
                                      
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