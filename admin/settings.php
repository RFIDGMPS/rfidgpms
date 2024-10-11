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
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <?php include 'sidebar.php'; ?>
        
        <div class="content">
        <?php
		include 'navbar.php';
		?>

            <div class="container-fluid pt-4 px-4">
                <div class="col-sm-12 col-xl-12">
                    <div class="bg-light rounded p-4">
                        <div class="row">
                            <div class="col-9">
                                <h6 class="mb-4">About</h6>
                            </div>
                            
                            <div class="col-lg-3 mt-4" style="text-align:right;">
                              
                            <button id="editButton" class="btn btn-primary" onclick="toggleEdit()"><i class="bi bi-pencil"></i> Edit</button>
            
                            
                            </div>
                        </div>
                        <br>
                        <form role="form" method="post" action="edit1.php?edit=about" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" autocomplete="off" readonly />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Address:</label>
                                    <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" autocomplete="off" readonly />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                <label>Logo 1:</label><br/>
                                <div class="file-uploader">
               <label name="upload-label" class="upload-img-btn">
               <input type="file" id="photo" name="logo1" class="upload-field-1" style="display:none;" accept="image/*" title="Upload Foto.." disabled readonly/>
               <input type="hidden" id="logo1" name="logo1" class="logo1">
               <img class="preview-1 edit-logo1" src="<?php echo 'uploads/'.$logo1; ?>" style="width: 140px!important;height: 130px!important;border: 1px solid gray;top: 20%;" title="Upload Photo.." />
               </label>
            </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Logo 2:</label><br/>
                                    <div class="file-uploader">
               <label name="upload-label" class="upload-img-btn">
               <input type="file" id="photo" name="logo2" class="upload-field-2" style="display:none;" accept="image/*" title="Upload Foto.." disabled readonly/>
               <input type="hidden" id="logo2" name="logo2" class="logo2">
               <img class="preview-2 edit-logo2" src="<?php echo 'uploads/'.$logo2; ?>" style="width: 140px!important;height: 130px!important;border: 1px solid gray;top: 15%;" title="Upload Photo.." />
               </label>
            </div>
                                </div>
                            </div>
                            <div class="col" style="text-align:right; ">
                               
                                <button type="submit" class="btn btn-success" id="btn_print" style="padding:20px;"> <i class="bi bi-save"></i> Save</button> 
            
                            
                            </div>
                        </form>
                    </div>
                    <hr>
                </div>
            </div>
            <?php include 'footer.php'; ?>
        </div>
        <script type="text/javascript">
         $(document).ready(function() {
            $logo1 =  $('.edit-logo1').attr('src');
            $logo2 =  $('.edit-logo2').attr('src');
           
$('.logo1').val($logo1);
$('.logo2').val($logo2);
         });
		 
		 </script>

<script>
        function toggleEdit() {
            const inputs = document.querySelectorAll('input[type="text"], input[type="file"]');
            const saveButton = document.getElementById('saveButton');
            inputs.forEach(input => {
                if (input.hasAttribute('readonly')) {
                    input.removeAttribute('readonly');
                    input.removeAttribute('disabled');
                } else {
                    input.setAttribute('readonly', 'readonly');
                    input.setAttribute('disabled', 'disabled');
                }
            });
            saveButton.disabled = !saveButton.disabled;
        }
    </script>


        <script type="text/javascript">
            function readURL(input) {
            	if (input.files && input.files[0]) {
            		var reader = new FileReader();
            		reader.onload = function(e) {
            			var num = $(input).attr('class').split('-')[2];
            			$('.file-uploader .preview-' + num).attr('src', e.target.result);
            		}
            		reader.readAsDataURL(input.files[0]);
            	}
            }
            $("[class^=upload-field-]").change(function() {
            	readURL(this);
            });
         </script>
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
</body>
</html>