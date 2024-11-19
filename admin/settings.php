<?php
include 'auth.php'; // Include session validation
?>
<?php
include '../connection.php';
$logo1 = "";
$name = "";
$address = "";
$logo2 = "";

// Fetch data from the about table
$sql = "SELECT * FROM about LIMIT 1";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
    $logo1 = $row['logo1'];
    $name = $row['name'];
    $address = $row['address'];
    $logo2 = $row['logo2'];
} 
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>

<body>
    <div class="container-fluid position-relative bg-light p-0">
        <?php include 'sidebar.php'; ?>
        
        <div class="content">
        <?php
		include 'navbar.php';
		?>

            <div class="container-fluid pt-4 px-4">
                <div class="col-sm-12 col-xl-12">
                    <div class="card shadow-sm rounded-lg">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">About</h6>
                            <button id="editButton" class="btn btn-primary" onclick="toggleEdit()"><i class="bi bi-pencil"></i> Edit</button>
                        </div>
                        <div class="card-body">
                            <form role="form" method="post" action="edit1.php?edit=about" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name:</label>
                                        <input type="text" id="name" class="form-control" name="name" value="<?php echo $name; ?>" autocomplete="off" readonly />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Address:</label>
                                        <input type="text" id="address" class="form-control" name="address" value="<?php echo $address; ?>" autocomplete="off" readonly />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="logo1" class="form-label">Logo 1:</label>
                                        <div class="file-uploader">
                                            <label class="upload-img-btn">
                                                <input type="file" id="logo1" name="logo1" class="upload-field" style="display:none;" accept="image/*" title="Upload Logo 1" disabled readonly />
                                                <input type="hidden" name="logo1" class="logo1">
                                                <img class="preview-1 edit-logo1" src="<?php echo 'uploads/'.$logo1; ?>" class="img-fluid" style="height: 130px; width: 140px; border: 1px solid #ccc;" />
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="logo2" class="form-label">Logo 2:</label>
                                        <div class="file-uploader">
                                            <label class="upload-img-btn">
                                                <input type="file" id="logo2" name="logo2" class="upload-field" style="display:none;" accept="image/*" title="Upload Logo 2" disabled readonly />
                                                <input type="hidden" name="logo2" class="logo2">
                                                <img class="preview-2 edit-logo2" src="<?php echo 'uploads/'.$logo2; ?>" class="img-fluid" style="height: 130px; width: 140px; border: 1px solid #ccc;" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success" id="saveButton" style="padding: 10px 20px; display:none;"> <i class="bi bi-save"></i> Save</button> 
                                    <button type="button" class="btn btn-secondary" id="cancelButton" onclick="cancelEdit()" style="padding: 10px 20px; display:none;">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'footer.php'; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Ensure jQuery is included -->

    <script>
        $(document).ready(function() {
            $logo1 =  $('.edit-logo1').attr('src');
            $logo2 =  $('.edit-logo2').attr('src');
            $('.logo1').val($logo1);
            $('.logo2').val($logo2);
        });

        function toggleEdit() {
            const inputs = document.querySelectorAll('input[type="text"], input[type="file"]');
            const saveButton = document.getElementById('saveButton');
            const cancelButton = document.getElementById('cancelButton');
            inputs.forEach(input => {
                if (input.hasAttribute('readonly')) {
                    input.removeAttribute('readonly');
                    input.removeAttribute('disabled');
                } else {
                    input.setAttribute('readonly', 'readonly');
                    input.setAttribute('disabled', 'disabled');
                }
            });
            saveButton.style.display = saveButton.style.display === 'none' ? 'inline-block' : 'none';
            cancelButton.style.display = cancelButton.style.display === 'none' ? 'inline-block' : 'none';
        }

        function cancelEdit() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will lose your changes.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, cancel',
                cancelButtonText: 'No, stay'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Reset form or redirect
                    window.location.href = 'settings.php'; // Redirect to settings or reset the form
                }
            });
        }

        // Function to read image URL for preview
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // Get the preview class number from the input class
                    var num = $(input).attr('id').split('logo')[1]; // Get 1 or 2 from id
                    $('.preview-' + num).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Bind change event to upload fields for file upload
        $("input[type='file']").change(function() {
            readURL(this);
        });
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
