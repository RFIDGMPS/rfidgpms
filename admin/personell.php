
<!DOCTYPE html>

<?php
include 'auth.php'; // Include session validation
date_default_timezone_set('Asia/Manila');

?>
<html lang="en">
   <?php
include 'header.php';
   ?>
 <?php 
// Include the database connection
include '../connection.php'; 

?>

   <body>
      <div class="container-fluid position-relative bg-white d-flex p-0">
         <!-- Spinner Start
         <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
               <span class="sr-only">Loading...</span>
            </div>
         </div> -->
         <!-- Spinner End -->
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
                              <h6 class="mb-4">Manage Personnel</h6>
                           </div>
                           <div class="col-3">
                              <button type="button" class="btn btn-outline-warning m-2" data-bs-toggle="modal" data-bs-target="#employeeModal">Add Personnel</button>
                           </div>
                        </div>
                        <hr>
                        </hr>
                        <div class="table-responsive">
                           <table class="table table-border" id="myDataTable">
                              <thead>
                                 <tr>
                                    <th scope="col">Photo</th>
                                    <th scope="col">RFID Number</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                          <th style="display: none;">Date Added</th> <!-- Hidden header for the date_added column -->
      
                                 </tr>
                              </thead>
                              <tbody>
                                 
                                 <?php $results = mysqli_query($db, "SELECT * FROM personell WHERE deleted != 1 ORDER BY date_added DESC"); ?>
                                 <?php while ($row = mysqli_fetch_array($results)) { ?>
                                 <tr class="table-<?php echo $row['id'];?>">
								 <input class="id_number" type="hidden" value="<?php echo $row['id_no']; ?>" />
									<input class="role" type="hidden" value="<?php echo $row['role']; ?>" />
               
									<input class="last_name" type="hidden" value="<?php echo $row['last_name']; ?>" />
									<input class="first_name" type="hidden" value="<?php echo $row['first_name']; ?>" />
									<input class="middle_name" type="hidden" value="<?php echo $row['middle_name']; ?>" />
									<input class="date_of_birth" type="hidden" value="<?php echo $row['date_of_birth']; ?>" />
									<input class="place_of_birth" type="hidden" value="<?php echo $row['place_of_birth']; ?>" />
									<input class="sex" type="hidden" value="<?php echo $row['sex']; ?>" />
									<input class="civil_status" type="hidden" value="<?php echo $row['civil_status']; ?>" />
									<input class="contact_number" type="hidden" value="<?php echo $row['contact_number']; ?>" />
                           <input class="categ" type="hidden" value="<?php echo $row['category']; ?>" />
									<input class="email_address" type="hidden" value="<?php echo $row['email_address']; ?>" />
									<input class="status" type="hidden" value="<?php echo $row['status']; ?>" />
									<input class="department" type="hidden" value="<?php echo $row['department']; ?>" />
							
                                    <td>
                                       <center>
                                          <img class="photo" src="uploads/<?php echo $row['photo']; ?>" width="50px" height="50px">
                                       </center>
                                    </td>
                                    <td class="rfid"><?php echo $row['rfid_number']; ?></td>
                                    <td><?php echo $row['first_name'] .' '.$row['last_name']; ?></td>
                                    <td><?php echo $row['role']; ?></td>
                                    <td><?php echo $row['category']; ?></td>
                                    <td><?php echo $row['department']; ?></td>
                                    <td><?php if ($row['status'] == 'Active') {
											echo '<span class="badge bg-success">Active</span>';
									} 
									else {
										echo '<span class="badge bg-danger">Blocked</span>';
									}
									?></td>
                                    <td width="14%">
                                       <center>
                                          <button address="<?php echo $row['complete_address']; ?>" data-id="<?php echo $row['id'];?>" class="btn btn-outline-primary btn-sm btn-edit e_user_id" >
                                          <i class="bi bi-plus-edit"></i> Edit </button>
                                        <!-- Delete Button -->
<button user_name="<?php echo $row['first_name'] . ' ' . $row['last_name']; ?>" 
        data-id="<?php echo $row['id']; ?>" 
        class="btn btn-outline-danger btn-sm btn-del d_user_id" 
        data-bs-toggle="modal" 
        data-bs-target="#delemployee-modal">
    <i class="bi bi-plus-trash"></i> Delete
</button>


                                       </center>
                                    </td>
                                    <td style="display:none;" class="hidden-date"><?php echo $row['date_added']; ?></td> <!-- Hidden column -->
         
                                 </tr>
                                 <?php } ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>


<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#myDataTable').DataTable({
        order: [[8, 'desc']] // Adjust the index (0) to the appropriate column
    });

    // Event delegation for the delete button
    $(document).on('click', '.d_user_id', function() {
        var userName = $(this).attr('user_name');
        var userId = $(this).attr('data-id');

        // Set user name and user ID in modal
        $('.user_name').val(userName);
        $('#delete_employeeid').val(userId);

        // Show the custom modal (display it manually if using a custom modal)
        $('#delemployee-modal').show(); 
    });

    // Handle "Yes" button click for deletion
    $('#btn-delemp').on('click', function () {
        var userId = $('#delete_employeeid').val();

        if (userId) {
            // AJAX request to delete the user
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "del.php?type=personell", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Show success message with SweetAlert
                    Swal.fire('Deleted!', 'The user has been deleted.', 'success').then(() => {
                        // Reload the page or update the UI
                        location.reload();
                    });
                } else {
                    // Show error message with SweetAlert
                    Swal.fire('Error!', 'There was a problem deleting the user.', 'error');
                }
            };
            xhr.send("id=" + userId);
        } else {
            Swal.fire('Error!', 'User ID not found!', 'error');
        }
    });

    // Event delegation for the edit button
    $(document).on('click', '.e_user_id', function() {
        var $id = $(this).attr('data-id');
        $('#editemployeeModal').modal('show'); // Bootstrap modal for editing

        // Retrieve data from the selected row
        var $getphoto = $('.table-' + $id + ' .photo').attr('src');
        var $getrfid = $('.table-' + $id + ' .rfid').html();
        var $getrole = $('.table-' + $id + ' .role').val();
        var $getcateg = $('.table-' + $id + ' .categ').val();
        var $getfname = $('.table-' + $id + ' .first_name').val();
        var $getlname = $('.table-' + $id + ' .last_name').val();
        var $getmname = $('.table-' + $id + ' .middle_name').val();
        var $getdob = $('.table-' + $id + ' .date_of_birth').val();
        var $getpob = $('.table-' + $id + ' .place_of_birth').val();
        var $getsex = $('.table-' + $id + ' .sex').val();
        var $getcivil = $('.table-' + $id + ' .civil_status').val();
        var $getcnumber = $('.table-' + $id + ' .contact_number').val();
        var $getemail = $('.table-' + $id + ' .email_address').val();
        var $getdepartment = $('.table-' + $id + ' .department').val();
        var $getstatus = $('.table-' + $id + ' .status').val();

        // Update the modal fields with data
        $('.edit-photo').attr('src', $getphoto);
        $('.edit-rfid').val($getrfid);
        $('.edit-id').val($id);
        $('.edit-role-val').html($getrole);
        $('.edit-categ-val').html($getcateg);
        $('.edit-fname').val($getfname);
        $('.edit-lname').val($getlname);
        $('.capturedImage').val($getphoto);
        $('.edit-mname').val($getmname);
        $('.edit-dob').val($getdob);
        $('.edit-pob').val($getpob);
        $('.edit-sex').html($getsex);
        $('.edit-cnumber').val($getcnumber);
        $('.edit-status').html($getcivil);
        $('.edit-email').val($getemail);
        $('.edit-department').html($getdepartment);
        $('.edit-status1').html($getstatus);

        // Update the form action dynamically
        //$('.edit-form').attr('action', 'edit1.php?edit=personell&id=' + $id);
    });
});
</script>

            <!-- Modal -->
            <form  id="personellForm" role="form" method="post" action="" enctype="multipart/form-data">
               <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">
                              <i class="bi bi-plus-circle"></i> New Personnel
                           </h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="col-lg-11 mb-2 mt-1" id="mgs-emp" style="margin-left: 4%"></div>
                        <div class="modal-body">
                           <div class="row justify-content-md-center">
                              <div id="msg-emp" style=""></div>
                              <div class="col-sm-12 col-md-12 col-lg-10">
                                 <div class="" style="border: 1PX solid #b3f0fc;padding: 1%;background-color: #f7cfa1;color: black;font-size: 1.2rem">PERSONAL INFORMATION</div>
                                 <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-12" id="up_img">
                                    <div class="file-uploader">
   <label for="photo" class="upload-img-btn" style="cursor: pointer;">
      <img class="preview-1" src="../assets/img/pngtree-vector-add-user-icon-png-image_780447.jpg"
           style="width: 140px!important; height: 130px!important; position: absolute; border: 1px solid gray; top: 25%;"
           title="Upload Photo.." />
   </label>
   <input type="file" id="photo" name="photo" class="upload-field-1" 
          style="opacity: 0; position: absolute; z-index: -1;" accept="image/*" required>
</div>



                                    </div>



                                    <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="form-group">
        <label>ROLE:</label>
        <select required class="form-control dept_ID" name="role" id="role" autocomplete="off" onchange="updateCategory()">
            <?php
                $sql = "SELECT * FROM role";
                $result = $db->query($sql);

                // Fetch and display role options
                while ($row = $result->fetch_assoc()) {
                    $role = $row['role'];
                    
                    // Set 'Student' as the default selected option
                    if ($role === 'Student') {
                        echo "<option value='$role' selected>$role</option>";
                    } else {
                        echo "<option value='$role'>$role</option>";
                    }
                }
            ?>
        </select>
        <span class="pob-error"></span>
    </div>
</div>

<div class="col-lg-5 col-md-6 col-sm-12" id="lnamez">
    <div class="form-group">
        <label>CATEGORY:</label>
        <select required class="form-control" name="category" id="category" autocomplete="off">
            <!-- Category options will be populated by JavaScript -->
        </select>
        <span class="id-error"></span>
    </div>
</div>

<script>
// Ensure the 'Student' role is preselected and categories updated accordingly
document.addEventListener('DOMContentLoaded', function () {
    updateCategory(); // Initialize category based on the default selected role
});

function updateCategory() {
    var role = document.getElementById('role').value;
    var categorySelect = document.getElementById('category');
    
    // Clear the existing options
    categorySelect.innerHTML = '';

    if (role === 'Student') {
        // If the role is 'Student', show 'Student' only in category
        var option = document.createElement('option');
        option.value = 'Student';
        option.text = 'Student';
        categorySelect.appendChild(option);
    } else {
        // If the role is not 'Student', show 'Regular' and 'Contractual'
        var option1 = document.createElement('option');
        option1.value = 'Regular';
        option1.text = 'Regular';
        categorySelect.appendChild(option1);

        var option2 = document.createElement('option');
        option2.value = 'Contractual';
        option2.text = 'Contractual';
        categorySelect.appendChild(option2);
    }
}
</script>
                                 </div>
                                 <div class="row mb-3 mt-1">
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <!-- empty -->
                                       </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mt-1">
                                       <div class="form-group">
                                          <label>LAST NAME:</label>
                                          <input required type="text" class="form-control" name="last_name" id="last_name" autocomplete="off">
                                          <span class="lname-error"></span>
                                       </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mt-1">
                                       <div class="form-group">
                                          <label>FIRST NAME:</label>
                                          <input required type="text" class="form-control" name="first_name" id="first_name" autocomplete="off">
                                          <span class="fname-error"></span>
                                       </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12 mt-1">
                                       <div class="form-group">
                                       <label>DATE OF BIRTH:</label>
                                          <input required type="date" class="form-control" name="date_of_birth" id="date_of_birth" autocomplete="off">
                                          <span class="dob-error"></span>
                                        </div>
                                    </div>
                                    <script>
        // Function to set the max date to 18 years ago
        function setMaxDate() {
            const today = new Date();
            const maxDate = new Date(today.setFullYear(today.getFullYear() - 18));
            const maxDateString = maxDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
            document.getElementById('date_of_birth').setAttribute('max', maxDateString);
        }

        // Call the function when the page loads
        window.onload = setMaxDate;
    </script>
                                 </div>
                                 <!-- <div class="row mb-2">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>DATE OF BIRTH:</label>
                                          <input required type="date" class="form-control" name="date_of_birth" id="date_of_birth" autocomplete="off">
                                          <span class="dob-error"></span>
                                       </div>
                                    </div>
                                    <script>
        // Function to set the max date to 18 years ago
        function setMaxDate() {
            const today = new Date();
            const maxDate = new Date(today.setFullYear(today.getFullYear() - 18));
            const maxDateString = maxDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
            document.getElementById('date_of_birth').setAttribute('max', maxDateString);
        }

        // Call the function when the page loads
        window.onload = setMaxDate;
    </script>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>PLACE OF BIRTH:</label>
                                          <input required type="text" class="form-control" name="place_of_birth" id="place_of_birth" autocomplete="off">
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>SEX:</label>
                                          <select required class="form-control dept_ID" name="sex" id="sex_id" autocomplete="off">
                                          
                                             <option value="Male">Male</option>
                                             <option value="Female">Female</option>
                                          </select>
                                          <span class="sex-error"></span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>CIVIL STATUS:</label>
                                          <select required class="form-control dept_ID" name="stat" id="stat_id" autocomplete="off">
                                            
                                             <option value="Single">Single</option>
                                             <option value="Married">Married</option>
                                             <option value="Widowed">Widowed</option>
                                          </select>
                                          <span class="stat-error"></span>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>CONTACT NUMBER:</label>
                                          <input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Optional" minlength="11" maxlength="11" autocomplete="off">
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>EMAIL ADDRESS:</label>
                                          <input type="email" class="form-control" name="email_address" id="email_address" placeholder="Optional" autocomplete="off">
                                       </div>
                                    </div>
                                 </div> -->
                                 <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>DEPARTMENT:</label>
                                          <select required class="form-control" name="department" id="department" autocomplete="off">
										
<?php
										  $sql = "SELECT * FROM department";
$result = $db->query($sql);

// Initialize an array to store department options
$department_options = [];

// Fetch and store department options
while ($row = $result->fetch_assoc()) {
    $department_id = $row['department_id'];
    $department_name = $row['department_name'];
    $department_options[] = "<option value='$department_name'>$department_name</option>";
}?>
                          <?php
    // Output department options
    foreach ($department_options as $option) {
        echo $option;
    }
    ?>            

                                          </select>
                                          <span class="dprt-error"></span>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>RFID NUMBER:</label>
                                          <input required type="text" class="form-control" name="rfid_number" id="rfid_number" minlength="10" maxlength="10" autocomplete="off">
                                          <span class="rfidno-error"></span>
                                       </div>
                                    </div>



<script>
   $(document).ready(function() {
      $('#rfid_number').on('blur', function() {
         const rfidNumber = $(this).val();
         
         if (rfidNumber.length === 10) {
            $.ajax({
               url: 'check_rfid.php', // Backend PHP file
               method: 'POST',
               data: { rfid_number: rfidNumber },
               success: function(response) {
                  const res = JSON.parse(response);
                  if (res.exists) {
                     Swal.fire({
                        icon: 'warning',
                        title: 'Duplicate RFID',
                        text: 'This RFID number already exists in the system.',
                     }).then(() => {
                        // Clear the input field explicitly after the user clicks "OK"
                        document.getElementById('rfid_number').value = '';
                     });
                  } 
               },
               error: function() {
                  Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: 'Unable to check RFID. Please try again later.',
                  });
               }
            });
         }
      });
   });
</script>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>STATUS:</label>
                                          <input type="text" class="form-control" name="status" id="status" value="Active" autocomplete="off" readonly="">
                                       </div>
                                    </div>
                                 </div>
                                 <!-- <div class="row">
                                    <div class="col-lg-12 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>COMPLETE ADDRESS:</label>
                                          <input required type="text" class="form-control"  name="complete_address" id="complete_address" autocomplete="off">
                                          <span class="ca-error"></span>
                                       </div>
                                    </div>
                                 </div> -->
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                           <button type="submit" id="btn-emp" class="btn btn-outline-warning">Save</button>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
            
    <script>$(document).ready(function() {
    
    // Handle form submission
    $('#personellForm').submit(function(e) {
      e.preventDefault();  // Prevent default form submission


        var formData = new FormData(this);  // Get form data

       

        $.ajax({
            url: 'transac.php?action=add',  // PHP script that handles the update
            type: 'POST',
            data: formData,
            contentType: false,  // Needed for file uploads
            processData: false,  // Needed for file uploads
            success: function(response) {
                var result = JSON.parse(response);  // Parse the JSON response

                // Show SweetAlert based on the response
                Swal.fire({
                        title: result.title,
                        text: result.text,
                        icon: result.icon
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Reload the page after the alert is confirmed
                            location.reload();
                        }
                    });
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while processing the request.',
                    icon: 'error'
                });
            }
        });
    });
});
</script>
            <script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('employeeModal');
        const form = document.getElementById('personellForm');
        const fileInput = document.getElementById('photo');
        const previewImage = document.querySelector('.preview-1');

        // Listen for the modal's hide event
        modal.addEventListener('hide.bs.modal', function () {
         document.getElementById('role').value = 'Student';
  updateCategory(); 
            form.reset(); // Reset the form
            previewImage.src = "../assets/img/pngtree-vector-add-user-icon-png-image_780447.jpg"; // Reset image preview
        });

        // Update the preview image when a file is selected
        fileInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result; // Set the preview to the selected image
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
            <!-- Modal -->

               <div class="modal fade" id="editemployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">
                              <i class="bi bi-pencil"></i> Edit Personnel
                           </h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="col-lg-11 mb-2 mt-1" id="mgs-emp" style="margin-left: 4%"></div>
                        <div id="editModal">

    <form id="editPersonellForm" class="edit-form" role="form" method="post" action="" enctype="multipart/form-data">
    <div class="modal-body" id="editModal">
<div class="row justify-content-md-center">
   <div id="msg-emp" style=""></div>
   <div class="col-sm-12 col-md-12 col-lg-10">
      <div class="" style="border: 1PX solid #b3f0fc;padding: 1%;background-color: #f7cfa1;color: black;font-size: 1.2rem">PERSONAL INFORMATION</div>
      <div class="row">
         <div class="col-lg-3 col-md-6 col-sm-12" id="up_img">
            <div class="file-uploader">
               <label name="upload-label" class="upload-img-btn">
               <input type="file" id="photo" name="photo" class="upload-field-1" style="display:none;" accept="image/*" title="Upload Foto.."/>
               <input type="hidden" id="capturedImage" name="capturedImage" class="capturedImage">
               <img class="preview-1 edit-photo" src="" style="width: 140px!important;height: 130px!important;position: absolute;border: 1px solid gray;top: 25%" title="Upload Photo.." />
               </label>
            </div>
         </div>
         <div class="col-lg-4 col-md-6 col-sm-12">
    <div class="form-group">
        <label>ROLE:</label>
        <select class="form-control dept_ID" name="role" id="erole" autocomplete="off" 
                data-current-role="<?php echo htmlspecialchars($currentRole); ?>">
            <option class="edit-role-val" value=""><?php echo htmlspecialchars($currentRole); ?></option>
            <?php
            // Fetch role options from the database
            $sql = "SELECT * FROM role";
            $result = $db->query($sql);
            while ($row = $result->fetch_assoc()) {
                $role = $row['role'];
                echo "<option value='$role'>$role</option>";
            }
            ?>
        </select>
        <span class="pob-error"></span>
    </div>
</div>

<div class="col-lg-5 col-md-6 col-sm-12" id="lnamez">
    <div class="form-group">
        <label>CATEGORY:</label>
        <select class="form-control" name="category" id="ecategory" autocomplete="off"
                data-current-category="<?php echo htmlspecialchars($currentCategory); ?>">
            <option class="edit-categ-val" value=""><?php echo htmlspecialchars($currentCategory); ?></option>
        </select>
        <span class="id-error"></span>
    </div>
</div>




<script>
    document.addEventListener('DOMContentLoaded', function () {
    const roleDropdown = document.getElementById('erole');
    const categoryDropdown = document.getElementById('ecategory');
    const form = document.getElementById('editPersonellForm');
    const modal = document.getElementById('editemployeeModal');

    // Placeholder values (replace with dynamically loaded values)
    const currentRole = roleDropdown.dataset.currentRole || ''; // Set via `data-*` attribute
    const currentCategory = categoryDropdown.dataset.currentCategory || ''; // Set via `data-*` attribute

    // Set the current values as default
    roleDropdown.querySelector('.edit-role-val').textContent = currentRole;
    roleDropdown.querySelector('.edit-role-val').value = currentRole;

    categoryDropdown.querySelector('.edit-categ-val').textContent = currentCategory;
    categoryDropdown.querySelector('.edit-categ-val').value = currentCategory;

    // Handle form reset on modal hide
    modal.addEventListener('hide.bs.modal', function () {
        form.reset();

        // Restore current values
        roleDropdown.querySelector('.edit-role-val').textContent = currentRole;
        roleDropdown.querySelector('.edit-role-val').value = currentRole;

        categoryDropdown.querySelector('.edit-categ-val').textContent = currentCategory;
        categoryDropdown.querySelector('.edit-categ-val').value = currentCategory;
    });

    // Update categories dynamically when role changes
    roleDropdown.addEventListener('change', function () {
        updateCategory1(this.value);
    });
});

function updateCategory1(role) {
    const categoryDropdown = document.getElementById('ecategory');

    // Clear existing options
    categoryDropdown.innerHTML = '';

    if (role === 'Student') {
        const studentOption = new Option('Student', 'Student');
        categoryDropdown.add(studentOption);
    } else {
        const regularOption = new Option('Regular', 'Regular');
        const contractualOption = new Option('Contractual', 'Contractual');
        categoryDropdown.add(regularOption);
        categoryDropdown.add(contractualOption);
    }
}

</script>

   </div>
      <div class="row mb-3 mt-1">
         <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="form-group">
               <!-- empty -->
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-12 mt-1">
            <div class="form-group">
               <label>LAST NAME:</label>
               <input  type="text" class="form-control edit-lname" name="last_name" id="last_name" autocomplete="off">
               <span class="lname-error"></span>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-12 mt-1">
            <div class="form-group">
               <label>FIRST NAME:</label>
               <input  type="text" class="form-control edit-fname" name="first_name" id="first_name" autocomplete="off">
               <span class="fname-error"></span>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-12 mt-1">
            <div class="form-group">
            <label>DATE OF BIRTH:</label>
               <input  type="date" class="form-control edit-dob" name="date_of_birth" id="date_of_birth" autocomplete="off">
               <span class="dob-error"></span>
             </div>
         </div>
      </div>
      
      <!-- <div class="row mb-2">
         <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="form-group">
               <label>DATE OF BIRTH:</label>
               <input  type="date" class="form-control edit-dob" name="date_of_birth" id="date_of_birth" autocomplete="off">
               <span class="dob-error"></span>
            </div>
         </div>
         <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="form-group">
               <label>PLACE OF BIRTH:</label>
               <input  type="text" class="form-control edit-pob" name="place_of_birth" id="place_of_birth" autocomplete="off">
            </div>
         </div>
         <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="form-group">
               <label>SEX:</label>
               <select  class="form-control" name="sex" id="sex_id" autocomplete="off">
                  <option class="edit-sex"></option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
               </select>
               <span class="sex-error"></span>
            </div>
         </div>
      </div> -->
      <!-- <div class="row">
         <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="form-group">
            <label>CIVIL STATUS:</label>
               <select class="form-control" name="c_status" id="c_status" autocomplete="off">
                  <option class="edit-status"></option>
                  <option value="Single">Single</option>
                  <option value="Married">Married</option>
                  <option value="Widowed">Widowed</option>
               </select>
               <span class="stat-error"></span>
            </div>
         </div>
         <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="form-group">
               <label>CONTACT NUMBER:</label>
               <input type="text" class="form-control edit-cnumber" name="contact_number" id="contact_number" placeholder="Optional" minlength="11" maxlength="11" autocomplete="off">
            </div>
         </div>
         <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="form-group">
               <label>EMAIL ADDRESS:</label>
               <input class="form-control edit-email"  type="email" name="email_address" id="email_address" placeholder="Optional" autocomplete="off">
            </div>
         </div>
      </div> -->
      <div class="row">
         <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="form-group">
               <label>DEPARTMENT:</label>
               <select  class="form-control" name="e_department" id="e_department" autocomplete="off">
                  <option class="edit-department"></option>
				
<?php
										  $sql = "SELECT * FROM department";
$result = $db->query($sql);

// Initialize an array to store department options
$department_options = [];

// Fetch and store department options
while ($row = $result->fetch_assoc()) {
    $department_id = $row['department_id'];
    $department_name = $row['department_name'];
    $department_options[] = "<option value='$department_name'>$department_name</option>";
}?>
                          <?php
    // Output department options
    foreach ($department_options as $option) {
        echo $option;
       
    }
    ?>            
               </select>
               <span class="dprt-error"></span>
            </div>
         </div>
         <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>RFID NUMBER:</label>
                                          <input required type="text" class="form-control edit-rfid" name="rfid_number" id="rfid_number1" minlength="10" maxlength="10" autocomplete="off">
                                          <span class="rfidno-error"></span>
                                       </div>
                                    </div>
                                    <script>
   $(document).ready(function() {
      // Store the previous value of the input
      let previousRFID = '';

      // Save the value before the input loses focus
      $('#rfid_number1').on('focus', function() {
         previousRFID = $(this).val();
      });

      // Check for duplicate RFID on blur
      $('#rfid_number1').on('blur', function() {
         const rfidNumber = $(this).val();

         if (rfidNumber.length === 10) {
            $.ajax({
               url: 'check_rfid.php', // Backend PHP file
               method: 'POST',
               data: { rfid_number: rfidNumber },
               success: function(response) {
                  const res = JSON.parse(response);
                  if (res.exists) {
                     // Show SweetAlert
                     Swal.fire({
                        icon: 'warning',
                        title: 'Duplicate RFID',
                        text: 'This RFID number already exists in the system.',
                        confirmButtonText: 'OK'
                     }).then(() => {
                        // Revert to the previous value
                        $('#rfid_number1').val(previousRFID);
                     });
                  }
               },
               error: function() {
                  Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: 'Unable to check RFID. Please try again later.',
                  });
               }
            });
         }
      });
   });
</script>




         <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="form-group">
               <label>STATUS:</label>
			   <select class="form-control" name="status" id="status" autocomplete="off">
                  <option class="edit-status1"></option>
                  <option value="Active">Active</option>
                  <option value="Block">Block</option>
               </select>
            </div>
         </div>
      </div>
      <!-- <div class="row">
         <div class="col-lg-12 col-md-6 col-sm-12">
            <div class="form-group">
               <label>COMPLETE ADDRESS:</label>
			   <input  type="text" class="form-control  e-address" name="complete_address" id="complete_address" autocomplete="off">
               <span class="ca-error"></span>
            </div>
         </div>
      </div> -->
   </div>
</div></div>
<div class="modal-footer">
                           <input type="hidden" id="edit_employeeid" name="">
                           <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                           <input value="Update" name="update" type="submit" id="btn-editemp" class="btn btn-outline-warning"/>
                        </div>

    </form>

    <script>$(document).ready(function() {
    var userId = '';  // Variable to store the selected user ID

    // Handle the click event to get the user ID
    $(document).on('click', '.e_user_id', function() {
        userId = $(this).data('id');  // Get the ID of the clicked element
       
    });

    // Handle form submission
    $('#editPersonellForm').submit(function(e) {
        e.preventDefault();  // Prevent default form submission

        if (userId === '') {
            Swal.fire({
                title: 'Error!',
                text: 'No user selected. Please select a user first.',
                icon: 'error'
            });
            return;  // Stop the form submission if no user is selected
        }

        var formData = new FormData(this);  // Get form data

        // Append the selected user ID to the form data
        formData.append('id', userId);

        $.ajax({
            url: 'edit1.php?edit=personell&id=' + userId,  // PHP script that handles the update
            type: 'POST',
            data: formData,
            contentType: false,  // Needed for file uploads
            processData: false,  // Needed for file uploads
            success: function(response) {
                var result = JSON.parse(response);  // Parse the JSON response

                // Show SweetAlert based on the response
                Swal.fire({
                        title: result.title,
                        text: result.text,
                        icon: result.icon
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Reload the page after the alert is confirmed
                            location.reload();
                        }
                    });
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while processing the request.',
                    icon: 'error'
                });
            }
        });
    });
});
</script>
						</div>
                     </div>
                  </div>
               </div>

               <div class="modal fade" id="delemployee-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">
               <i class="bi bi-trash"></i> Delete Personnel
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form method="POST" id="delete-form">
            <div class="modal-body">
               <div class="col-lg-12 mt-1" id="mgs-delemp"></div>
               <div class="col-lg-12 mb-1">
                  <div class="form-group">
                     <label for="inputTime"><b>Name:</b></label>
                     <input type="text" id="delete_departmentname" class="form-control d-personell user_name" autocomplete="off" readonly="">
                     <span class="deptname-error"></span>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <input type="hidden" name="user_id" id="delete_employeeid">
               <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">No</button>
               <button type="button" class="btn btn-outline-primary remove_id" id="btn-delemp">Yes</button>
            </div>
         </form>
      </div>
   </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('editemployeeModal');
        const form = document.getElementById('editPersonellForm');
        const fileInput = document.getElementById('photo');
        const previewImage = document.querySelector('.preview-1');

        // Listen for the modal's hide event
        modal.addEventListener('hide.bs.modal', function () {
            form.reset(); // Reset the form
            previewImage.src = "../assets/img/pngtree-vector-add-user-icon-png-image_780447.jpg"; // Reset image preview
        });

        // Update the preview image when a file is selected
        fileInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result; // Set the preview to the selected image
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>


            <!-- <script type="text/javascript">
               document.addEventListener('DOMContentLoaded', () => {
               	let btn = document.querySelector('#btn-delemp');
               	btn.addEventListener('click', (e) => {
               		e.preventDefault();
               		const employee_id = document.querySelector('input[id=delete_employeeid]').value;
               		console.log(employee_id);
               		var data = new FormData(this.form);
               		data.append('employee_id', employee_id);
               		$.ajax({
               			url: '../config/init/delete_employee.php',
               			type: "POST",
               			data: data,
               			processData: false,
               			contentType: false,
               			async: false,
               			cache: false,
               			success: function(response) {
               				$("#mgs-delemp").html(response);
               				$('#mgs-delemp').animate({
               					scrollTop: 0
               				}, 'slow');
               			},
               			error: function(response) {
               				console.log("Failed");
               			}
               		});
               		// }
               	});
               });
            </script> -->
			
            <?php
include 'footer.php';
			?>
       
         <script type="text/javascript">
           function readURL(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const validFormats = ['image/jpeg', 'image/png'];
        const maxSize = 2 * 1024 * 1024; // 2MB

        // Validate file format
        if (!validFormats.includes(file.type)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Format',
                text: 'Only JPG and PNG formats are allowed.',
            });
            input.value = ''; // Reset the input
            return;
        }

        // Validate file size
        if (file.size > maxSize) {
            Swal.fire({
                icon: 'error',
                title: 'File Too Large',
                text: 'Maximum file size is 2MB.',
            });
            input.value = ''; // Reset the input
            return;
        }

        // Preview the image
        var reader = new FileReader();
        reader.onload = function (e) {
            var num = $(input).attr('class').split('-')[2];
            $('.file-uploader .preview-' + num).attr('src', e.target.result);
        };
        reader.readAsDataURL(file);
    }
}

// Attach change event to all inputs with a class starting with 'upload-field-'
$("[class^=upload-field-]").change(function () {
    readURL(this);
});

         </script>
         <a href="#" class="btn btn-lg btn-warning btn-lg-square back-to-top">
         <i class="bi bi-arrow-up"></i>
         </a>
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