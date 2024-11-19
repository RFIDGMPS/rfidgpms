<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <?php include 'sidebar.php'; ?>

        <div class="content">
            <?php include 'navbar.php'; ?>

            <div class="container-fluid pt-4 px-4">
                <div class="col-sm-12 col-xl-12">
                    <div class="bg-light rounded p-4 shadow-sm">
                        <div class="row">
                            <div class="col-9">
                                <h6 class="mb-4 text-primary">About</h6>
                            </div>
                            <div class="col-lg-3 mt-4 text-end">
                                <button id="editButton" class="btn btn-warning text-white" onclick="toggleEdit()">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>
                            </div>
                        </div>
                        <br>
                        <form role="form" method="post" action="edit1.php?edit=about" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>" autocomplete="off" readonly />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="address" class="form-label">Address:</label>
                                    <input type="text" class="form-control" name="address" id="address" value="<?php echo $address; ?>" autocomplete="off" readonly />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="logo1" class="form-label">Logo 1:</label>
                                    <div class="file-uploader text-center">
                                        <label class="upload-img-btn" for="logo1" style="cursor:pointer;">
                                            <input type="file" id="logo1" name="logo1" class="upload-field-1" style="display:none;" accept="image/*" title="Upload Logo 1.." disabled readonly />
                                            <img class="preview-1 edit-logo1" src="<?php echo 'uploads/'.$logo1; ?>" style="width: 140px; height: 130px; border: 2px solid #ddd; border-radius: 8px;" title="Upload Photo.." />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="logo2" class="form-label">Logo 2:</label>
                                    <div class="file-uploader text-center">
                                        <label class="upload-img-btn" for="logo2" style="cursor:pointer;">
                                            <input type="file" id="logo2" name="logo2" class="upload-field-2" style="display:none;" accept="image/*" title="Upload Logo 2.." disabled readonly />
                                            <img class="preview-2 edit-logo2" src="<?php echo 'uploads/'.$logo2; ?>" style="width: 140px; height: 130px; border: 2px solid #ddd; border-radius: 8px;" title="Upload Photo.." />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col text-end">
                                <button type="submit" class="btn btn-success px-4 py-2" id="btn_print" style="font-size: 1rem; font-weight: 600;"> 
                                    <i class="bi bi-save"></i> Save 
                                </button>
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
                var $logo1 = $('.edit-logo1').attr('src');
                var $logo2 = $('.edit-logo2').attr('src');

                $('.logo1').val($logo1);
                $('.logo2').val($logo2);
            });

            function toggleEdit() {
                const inputs = document.querySelectorAll('input[type="text"], input[type="file"]');
                inputs.forEach(input => {
                    if (input.hasAttribute('readonly')) {
                        input.removeAttribute('readonly');
                        input.removeAttribute('disabled');
                    } else {
                        input.setAttribute('readonly', 'readonly');
                        input.setAttribute('disabled', 'disabled');
                    }
                });
            }

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
        
        <a href="#" class="btn btn-lg btn-warning btn-lg-square back-to-top">
            <i class="bi bi-arrow-up"></i>
        </a>
    </div>

    <!-- Bootstrap JS and other libraries -->
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
