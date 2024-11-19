<?php
include 'auth.php'; // Include session validation
include '../connection.php';

// Fetch existing data from the about table
$sql = "SELECT * FROM about LIMIT 1";
$result = $db->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>

<body>
    <div class="container-fluid position-relative bg-light p-0">
        <?php include 'sidebar.php'; ?>
        
        <div class="content">
        <?php include 'navbar.php'; ?>

            <div class="container-fluid pt-4 px-4">
                <div class="col-sm-12 col-xl-12">
                    <div class="card shadow-sm rounded-lg">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">About</h6>
                            <button id="editButton" class="btn btn-primary" onclick="toggleEdit()"><i class="bi bi-pencil"></i> Edit</button>
                        </div>
                        <div class="card-body">
                            <!-- Form for updating about information -->
                            <form role="form" method="post" action="update_about.php" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name:</label>
                                        <input type="text" id="name" class="form-control" name="name" value="<?php echo $row['name']; ?>" autocomplete="off" readonly />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Address:</label>
                                        <input type="text" id="address" class="form-control" name="address" value="<?php echo $row['address']; ?>" autocomplete="off" readonly />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="logo1" class="form-label">Logo 1:</label>
                                        <div class="file-uploader">
                                            <label class="upload-img-btn">
                                                <input type="file" id="logo1" name="logo1" class="upload-field" style="display:none;" accept="image/*" title="Upload Logo 1" disabled readonly />
                                                <input type="hidden" name="logo1" class="logo1">
                                                <img class="preview-1 edit-logo1" src="<?php echo 'uploads/'.$row['logo1']; ?>" class="img-fluid" style="height: 130px; width: 140px; border: 1px solid #ccc;" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="logo2" class="form-label">Logo 2:</label>
                                        <div class="file-uploader">
                                            <label class="upload-img-btn">
                                                <input type="file" id="logo2" name="logo2" class="upload-field" style="display:none;" accept="image/*" title="Upload Logo 2" disabled readonly />
                                                <input type="hidden" name="logo2" class="logo2">
                                                <img class="preview-2 edit-logo2" src="<?php echo 'uploads/'.$row['logo2']; ?>" class="img-fluid" style="height: 130px; width: 140px; border: 1px solid #ccc;" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success" id="saveButton" style="padding: 10px 20px;"> <i class="bi bi-save"></i> Save</button>
                                    <button type="button" class="btn btn-secondary" id="cancelButton" onclick="cancelEdit()">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'footer.php'; ?>
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Handle form submission to trigger SweetAlert
        <?php 
        if (isset($_GET['status']) && $_GET['status'] == 'success') {
            echo "
            Swal.fire({
                title: 'Saved!',
                text: 'Your changes have been saved successfully.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location = 'settings.php'; // Redirect to settings page after closing the alert
            });
            ";
        }
        ?>
    </script>

    <a href="#" class="btn btn-lg btn-warning btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
</body>
</html>
