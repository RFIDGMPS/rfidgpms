
<!DOCTYPE html>
<?php
include 'auth.php'; // Include session validation


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
                                 </tr>
                              </thead>
                              <tbody>
                                 
                                 <?php $results = mysqli_query($db, "SELECT * FROM personell"); ?>
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
                           <input class="category" type="hidden" value="<?php echo $row['category']; ?>" />
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
									elseif($row['status'] == 'Inactive'){
										echo '<span class="badge bg-warning">Inactive</span>';
									}
									else {
										echo '<span class="badge bg-danger">Blocked</span>';
									}
									?></td>
                                    <td width="14%">
                                       <center>
                                          <button address="<?php echo $row['complete_address']; ?>" data-id="<?php echo $row['id'];?>" class="btn btn-outline-primary btn-sm btn-edit e_user_id" >
                                          <i class="bi bi-plus-edit"></i> Edit </button>
                                          <button user_name="<?php echo $row['first_name'] .' '. $row['last_name']; ?>" data-id="<?php echo $row['id']; ?>" class="btn btn-outline-danger btn-sm btn-del d_user_id">
                                          <i class="bi bi-plus-trash"></i> Delete </button>
                                       </center>
                                    </td>
                                 </tr>
                                 <?php } ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
			<script type="text/javascript">
         $(document).ready(function() {
         	$("#myDataTable").DataTable();

    
			 $('#myDataTable tbody').on('click', '.d_user_id', function() {
			// $('.d_user_id').click(function(){
				$('#delemployee-modal').modal('show');
            		    
						$('.user_name').html($(this).attr('user_name'));
               		$id = $(this).attr('data-id');
                     $username =  $(this).attr('user_name');
       
                       $('.d-personell').val($username);
               		$('.remove_id').click(function(){
               			window.location = 'del.php?type=personell&id=' + $id;
						 
               		});
               	});
				        // Event delegation for edit button
            $('#myDataTable tbody').on('click', '.e_user_id', function() {

               	//$('.e_user_id').click(function(){
               		$id = $(this).attr('data-id');
               		// $('#editModal').load('edit.php?id=' + $id);
					$('#editemployeeModal').modal('show');
					$getphoto =  $('.table-'+$id+' .photo').attr('src');
			
					$getid =  $('.table-'+$id+' .id_number').val();
					$getrfid =  $('.table-'+$id+' .rfid').html();
					$getrole =  $('.table-'+$id+' .role').val();
					$getfname =  $('.table-'+$id+' .first_name').val();
					$getlname =  $('.table-'+$id+' .last_name').val();
					$getmname =  $('.table-'+$id+' .middle_name').val();
					$getdob =  $('.table-'+$id+' .date_of_birth').val();
					$getpob =  $('.table-'+$id+' .place_of_birth').val();
					$getsex =  $('.table-'+$id+' .sex').val();
					$getcivil =  $('.table-'+$id+' .civil_status').val();
            
					$getcnumber =  $('.table-'+$id+' .contact_number').val();
					$getemail =  $('.table-'+$id+' .email_address').val();
					$getdepartment =  $('.table-'+$id+' .department').val();
					$getstatus =  $('.table-'+$id+' .status').val();
				
               $address =  $(this).attr('address');
      
       $('.e-address').val($address);

					$('.edit-photo').attr('src',$getphoto);
               
					$('.edit-photo-input').attr('image',$getphoto);
					$('.edit-rfid').val($getrfid);
					$('.edit-id').val($getid);
					$('.edit-role-val').html($getrole);
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
				
					$('.edit-form').attr('action','edit1.php?edit=personell&id='+$id);
					
               	});
         });
		 
		 </script>
            <!-- Modal -->
            <form role="form" method="post" action="transac.php?action=add" enctype="multipart/form-data">
               <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">
                              <i class="bi bi-plus-circle"></i> New User
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
           style="width: 140px!important;height: 130px!important;position: absolute;border: 1px solid gray;top: 15%;"
           title="Upload Photo.." />
   </label>
   <input type="file" id="photo" name="photo" accept="image/*"
          style="opacity: 0; position: absolute; z-index: -1;" required>
</div>

                                    </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  const fileInput = document.getElementById('photo');

// Listen for file selection
fileInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    const validFormats = ['image/jpeg', 'image/png'];
    const maxSize = 2 * 1024 * 1024; // 2MB

    // Check if a file was selected
    if (!file) {
        Swal.fire({
            icon: 'warning',
            title: 'No File Selected',
            text: 'Please select an image file.',
        });
        return;
    }

    // Check file type and size
    if (!validFormats.includes(file.type)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Format',
            text: 'Only JPG and PNG formats are allowed.',
        });
        fileInput.value = ''; // Reset the input
        return;
    }

    if (file.size > maxSize) {
        Swal.fire({
            icon: 'error',
            title: 'File Too Large',
            text: 'Maximum file size is 2MB.',
        });
        fileInput.value = ''; // Reset the input
        return;
    }

    Swal.fire({
        icon: 'success',
        title: 'File Selected',
        text: 'Your file is valid!',
    });
});

</script>
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
        <label>Category:</label>
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
                                          <label>MIDDLE NAME:</label>
                                          <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Optional..." autocomplete="off">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row mb-2">
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
                                 </div>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                                 <div class="row">
                                    <div class="col-lg-12 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>COMPLETE ADDRESS:</label>
                                          <input required type="text" class="form-control"  name="complete_address" id="complete_address" autocomplete="off">
                                          <span class="ca-error"></span>
                                       </div>
                                    </div>
                                 </div>
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
          
            <!-- Modal -->

               <div class="modal fade" id="editemployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">
                              <i class="bi bi-pencil"></i> Edit User
                           </h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="col-lg-11 mb-2 mt-1" id="mgs-emp" style="margin-left: 4%"></div>
                        <div id="editModal">

    <form class="edit-form" role="form" method="post" action="" enctype="multipart/form-data">
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
               <img class="preview-1 edit-photo" src="" style="width: 140px!important;height: 130px!important;position: absolute;border: 1px solid gray;top: 15%" title="Upload Photo.." />
               </label>
            </div>
         </div>
         <div class="col-lg-4 col-md-6 col-sm-12" id="lnamez">
            <div class="form-group">
               <label>ID Number:</label>
               <input  type="text" value="" class="form-control edit-id" name="id_no" id="id_no" autocomplete="off">
               <span class="id-error"></span>
            </div>
         </div>
         <div class="col-lg-5 col-md-6 col-sm-12">
            <div class="form-group">
               <label>RFID NUMBER:</label>
               <input  type="text" value="" class="form-control edit-rfid" name="rfid_number" id="frid_number" minlength="10" maxlength="10" autocomplete="off">
               <span class="rfidno-error"></span>
            </div>
         </div>
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
               <label>MIDDLE NAME:</label>
               <input type="text" class="form-control edit-mname" name="middle_name" id="middle_name" placeholder="Optional..." autocomplete="off">
            </div>
         </div>
      </div>
      <div class="row mb-2">
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
      </div>
      <div class="row">
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
      </div>
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
               <label>ROLE:</label>
               <select class="form-control" name="role" id="role" autocomplete="off">
                  <option class="edit-role-val"></option>
                  <?php
										  $sql = "SELECT * FROM role";
$result = $db->query($sql);

// Initialize an array to store department options
$role_options = [];

// Fetch and store department options
while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $role = $row['role'];
    $role_options[] = "<option value='$role'>$role</option>";
}?>
                          <?php
    // Output department options
    foreach ($role_options as $option) {
        echo $option;
    }
    ?>    
                    
               </select>
               <span class="pob-error"></span>
            </div>
         </div>
         <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="form-group">
               <label>STATUS:</label>
			   <select class="form-control" name="status" id="status" autocomplete="off">
                  <option class="edit-status1"></option>
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                  <option value="Block">Block</option>
               </select>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-12 col-md-6 col-sm-12">
            <div class="form-group">
               <label>COMPLETE ADDRESS:</label>
			   <input  type="text" class="form-control  e-address" name="complete_address" id="complete_address" autocomplete="off">
               <span class="ca-error"></span>
            </div>
         </div>
      </div>
   </div>
</div></div>
<div class="modal-footer">
                           <input type="hidden" id="edit_employeeid" name="">
                           <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                           <input value="Update" name="update" type="submit" id="btn-editemp" class="btn btn-outline-warning"/>
                        </div>

    </form>

						</div>
                     </div>
                  </div>
               </div>

            <div class="modal fade" id="delemployee-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title">
                           <i class="bi bi-trash"></i> Delete User
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <form method="POST">
                        <div class="modal-body">
                           <div class="col-lg-12 mt-1" id="mgs-delemp"></div>
                           <div class="col-lg-12 mb-1">
                              <div class="form-group">
                                 <label for="inputTime">
                                 <b>Name:</b>
                                 </label>
                                 <input  type="text" id="delete_departmentname" class="form-control d-personell" autocomplete="off" readonly="">
                                 <span class="deptname-error"></span>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <input type="hidden" name="" id="delete_employeeid">
                           <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">No</button>
                           <button type="button" class="btn btn-outline-primary remove_id" id="btn-delemp">Yes</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <script type="text/javascript">
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
            </script>
			
            <?php
include 'footer.php';
			?>
       
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