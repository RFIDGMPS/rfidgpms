
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
         </div> -->
         <!-- Spinner End -->
         <!-- Sidebar Start -->
        <?php
		include 'sidebar.php';
		?>
         <!-- Sidebar End -->
         <!-- Content Start -->
         <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand  navbar-light sticky-top px-4 py-0" style="background-color: #fcaf42">
               <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                  <h2 class="text-warning mb-0"></h2>
               </a>
               <a href="#" class="sidebar-toggler flex-shrink-0">
               <i class="fa fa-bars"></i>
               </a>
               <div class="navbar-nav align-items-center ms-auto">
                  <!--      <div class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-envelope me-lg-2"></i><span class="d-none d-lg-inline-flex">Message</span></a><div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0"><hr class="dropdown-divider"><a href="#" class="dropdown-item"><div class="d-flex align-items-center"><img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;"><div class="ms-2"><h6 class="fw-normal mb-0">Jhon send you a message</h6><small>15 minutes ago</small></div></div></a><hr class="dropdown-divider"><a href="#" class="dropdown-item text-center">See all message</a></div></div> -->
                  <!--  <div class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-bell me-lg-2"></i><span class="d-none d-lg-inline-flex">Notification</span></a><div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0"><hr class="dropdown-divider"><a href="#" class="dropdown-item"><h6 class="fw-normal mb-0">Password changed</h6><small>15 minutes ago</small></a><hr class="dropdown-divider"><a href="#" class="dropdown-item text-center">See all notifications</a></div></div> -->
                  <div class="nav-item dropdown">
                     <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                     <img class="rounded-circle me-lg-2" src="img/2601828.png" alt="" style="width: 40px; height: 40px;">
                     <span class="d-none d-lg-inline-flex">admin@gmail.com</span>
                     </a>
                     <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                        <a href="logout" class="dropdown-item" style="border: 1px solid #b0a8a7">
                        <i class="bi bi-arrow-right-circle"></i> Log Out </a>
                     </div>
                  </div>
               </div>
            </nav>
            <!-- Navbar End -->
            <div class="container-fluid pt-4 px-4">
               <div class="col-sm-12 col-xl-12">
                  <div class="col-sm-12 col-xl-12">
                     <div class="bg-light rounded h-100 p-4">
                        <div class="row">
                           <div class="col-9">
                              <h6 class="mb-4">Manage Employee</h6>
                           </div>
                           <div class="col-3">
                              <button type="button" class="btn btn-outline-warning m-2" data-bs-toggle="modal" data-bs-target="#employeeModal">Add Employee</button>
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
                                    <th scope="col">Contact Number</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php include '../connection.php'; ?>
                                 <?php $results = mysqli_query($db, "SELECT * FROM users"); ?>
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
									<input class="email_address" type="hidden" value="<?php echo $row['email_address']; ?>" />
									<input class="status" type="hidden" value="<?php echo $row['status']; ?>" />
									<input class="department" type="hidden" value="<?php echo $row['department']; ?>" />
									<input class="address" type="hidden" value="<?php echo $row['complete_address']; ?>" />
                                    <td>
                                       <center>
                                          <img class="photo" src="uploads/<?php echo $row['photo']; ?>" width="50px" height="50px">
                                       </center>
                                    </td>
                                    <td class="rfid"><?php echo $row['rfid_number']; ?></td>
                                    <td><?php echo $row['first_name'] .' '.$row['last_name']; ?></td>
                                    <td><?php echo $row['role']; ?></td>
                                    <td><?php echo $row['contact_number']; ?></td>
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
                                          <button data-id="<?php echo $row['id'];?>" class="btn btn-outline-primary btn-sm btn-edit e_user_id" >
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
			 $('.d_user_id').click(function(){
				$('#delemployee-modal').modal('show');
            		    
						$('.user_name').html($(this).attr('user_name'));
               		$id = $(this).attr('data-id');
               		$('.remove_id').click(function(){
               			window.location = 'del.php?type=user&id=' + $id;
						 
               		});
               	});
               	$('.e_user_id').click(function(){
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
					$getaddress =  $('.table-'+$id+' .address').val();
					$('.edit-photo').attr('src',$getphoto);
					$('.edit-photo-input').attr('image',$getphoto);
					$('.edit-rfid').val($getrfid);
					$('.edit-id').val($getid);
					$('.edit-role-val').html($getrole);
					$('.edit-fname').val($getfname);
					$('.edit-lname').val($getlname);
					$('.edit-mname').val($getmname);
					$('.edit-dob').val($getdob);
					$('.edit-pob').val($getpob);
					$('.edit-sex').html($getsex);
					$('.edit-cnumber').val($getcnumber);
					$('.edit-status').val($getcivil);
					$('.edit-email').val($getemail);
					$('.edit-department').html($getdepartment);
					$('.edit-status1').html($getstatus);
					$('.edit-address').html($getaddress);
					$('.edit-form').attr('action','edit1.php?edit=user&id='+$id);
					
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
                                          <label name="upload-label" class="upload-img-btn">
                                          <input required type="file" id="photo" name="photo" class="upload-field-1" style="display:none;" accept="image/*" title="Upload Foto.."/>
                                          <img class="preview-1" src="../assets/img/pngtree-vector-add-user-icon-png-image_780447.jpg" style="width: 140px!important;height: 130px!important;position: absolute;border: 1px solid gray;top: 15%" title="Upload Photo.." />
                                          </label>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="lnamez">
                                       <div class="form-group">
                                          <label>ID Number:</label>
                                          <input required type="text" class="form-control" name="id_no" id="id_no" autocomplete="off">
                                          <span class="id-error"></span>
                                       </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>RFID NUMBER:</label>
                                          <input required type="text" class="form-control" name="rfid_number" id="rfid_number" minlength="10" maxlength="10" autocomplete="off">
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
                                             <option value="">&larr; Select Section &rarr;</option>
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
                                             <option value="">&larr; Select Status &rarr;</option>
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
                                          <select required class="form-control dept_ID" name="department" id="dept_id" autocomplete="off">
                                             <option value="">&larr; Select Department &rarr;</option>
                                             <option value="Humss">HUMSS AUSTEN</option>
                                             <option value="Accounting">Accounting Department</option>
                                             <option value="mis">MIS depertment</option>
                                          </select>
                                          <span class="dprt-error"></span>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>ROLE:</label>
                                          <select required class="form-control dept_ID" name="role" id="role" autocomplete="off">
                                             <option value="">&larr; Select Role &rarr;</option>
                                             <option value="Student">Student</option>
                                             <option value="Instructor">Instructor</option>
                                             <option value="Employee">Employee</option>
                                             <option value="Visitor">Visitor</option>
                                          </select>
                                          <span class="pob-error"></span>
                                       </div>
                                    </div>
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
                                          <input required type="text" class="form-control" name="complete_address" id="complete_address" autocomplete="off">
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
            <!--	<script type="text/javascript">
               $(document).delegate('#btn-emp', 'click', function(event) {
               	event.preventDefault();
               	// alert('click');
               	var photo = document.getElementById('photo').files[0];
               	var employee_no = $('#id_no').val();
               	var frid_number = $('#frid_number').val();
               	var last_name = $('#last_name').val();
               	var first_name = $('#first_name').val();
               	var middle_name = $('#middle_name').val();
               	var date_of_birth = $('#date_of_birth').val();
               	var place_of_birth = $('#place_of_birth').val();
               	var sex = $('#sex_id option:selected').val();
               	var civil_status = $('#stat_id option:selected').val();
               	var contact_number = $('#contact_number').val();
               	var email_address = $('#email_address').val();
               	var section = $('#sec_id option:selected').val();
               
               	var department = $('#dept_id option:selected').val();
               	var complete_address = $('#complete_address').val();
               
               	var status = $('#status').val();
               	var form_data = new FormData();
               	form_data.append('photo', $('#photo')[0].files[0]);
               	form_data.append("employee_no", employee_no);
               	form_data.append("frid_number", frid_number);
               	form_data.append("last_name", last_name);
               	form_data.append("first_name", first_name);
               	form_data.append("middle_name", middle_name);
               	form_data.append("date_of_birth", date_of_birth);
               	form_data.append("place_of_birth", place_of_birth);
               	form_data.append("sex", sex);
               	form_data.append("civil_status", civil_status);
               	form_data.append("contact_number", contact_number);
               	form_data.append("email_address", email_address);
               	form_data.append("designation", designation);
               	form_data.append("date_hire", date_hire);
               	form_data.append("department", department);
               	form_data.append("complete_address", complete_address);
               	form_data.append("username", username);
               	form_data.append("password", password);
               	form_data.append("status", status);
               
               	function isValidEMPNo() {
               		var pattern = /^[a-zA-Z 0-9 -\s]+$/;
               		var id_no = $("#id_no").val();
               		if (pattern.test(id_no) && id_no !== "") {
               			$("#id_no").removeClass("is-invalid").addClass("is-valid");
               			$(".id-error").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (id_no === "") {
               			$("#id_no").removeClass("is-valid").addClass("is-invalid");
               			$(".id-error").html('Required ID Number');
               			$(".id-error").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#id_no").removeClass("is-valid").addClass("is-invalid");
               			$(".id-error").html('Please input Character/No. only');
               			$(".id-error").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
               	function isValidRFIDNo() {
               		var pattern = /^[0-9 \s]+$/;
               		var frid_number = $("#frid_number").val();
               		if (pattern.test(frid_number) && frid_number !== "") {
               			$("#frid_number").removeClass("is-invalid").addClass("is-valid");
               			$(".rfidno-error").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (frid_number === "") {
               			$("#frid_number").removeClass("is-valid").addClass("is-invalid");
               			$(".rfidno-error").html('Required RFID Number');
               			$(".rfidno-error").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#frid_number").removeClass("is-valid").addClass("is-invalid");
               			$(".rfidno-error").html('Please input Number only');
               			$(".rfidno-error").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
               	function isValidLastName() {
               		var pattern = /^[a-zA-Z \s]+$/;
               		var last_name = $("#last_name").val();
               		if (pattern.test(last_name) && last_name !== "") {
               			$("#last_name").removeClass("is-invalid").addClass("is-valid");
               			$(".lname-error").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (last_name === "") {
               			$("#last_name").removeClass("is-valid").addClass("is-invalid");
               			$(".lname-error").html('Required Last Name');
               			$(".lname-error").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#last_name").removeClass("is-valid").addClass("is-invalid");
               			$(".lname-error").html('Please input Character only');
               			$(".lname-error").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
               	function isValidFirstName() {
               		var pattern = /^[a-zA-Z \s]+$/;
               		var first_name = $("#first_name").val();
               		if (pattern.test(first_name) && first_name !== "") {
               			$("#first_name").removeClass("is-invalid").addClass("is-valid");
               			$(".fname-error").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (first_name === "") {
               			$("#first_name").removeClass("is-valid").addClass("is-invalid");
               			$(".fname-error").html('Required First Name');
               			$(".fname-error").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#first_name").removeClass("is-valid").addClass("is-invalid");
               			$(".fname-error").html('Please input Character only');
               			$(".fname-error").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
               	function isValidMname() {
               		if ($("#middle_name").val() === "" && $("#middle_name").val()) {
               			$("#middle_name").removeClass("is-invalid").addClass("is-valid");
               			return false;
               		} else {
               			$("#middle_name").removeClass("is-invalid").addClass("is-valid");
               			return true;
               		}
               	};
               
               	function isValidDbirth() {
               		if ($("#date_of_birth").val() === "") {
               			$("#date_of_birth").addClass("is-invalid");
               			$(".dob-error").html('Required Date of Birth');
               			$(".dob-error").css({
               				"color": "red",
               				"font-size": "14px",
               			});
               			return false;
               		} else {
               			$("#date_of_birth").removeClass("is-invalid").addClass("is-valid");
               			$(".dob-error").css({
               				"display": "none"
               			});
               			return true;
               		}
               	};
               
               	function isValidPlaceofBirth() {
               		var pattern = /^[a-zA-Z \s]+$/;
               		var place_of_birth = $("#place_of_birth").val();
               		if (pattern.test(place_of_birth) && place_of_birth !== "") {
               			$("#place_of_birth").removeClass("is-invalid").addClass("is-valid");
               			$(".pob-error").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (place_of_birth === "") {
               			$("#place_of_birth").removeClass("is-valid").addClass("is-invalid");
               			$(".pob-error").html('Required Place of Birth');
               			$(".pob-error").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#place_of_birth").removeClass("is-valid").addClass("is-invalid");
               			$(".pob-error").html('Please input Character only');
               			$(".pob-error").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
               	function isValidCivilStat() {
               		if ($("#stat_id").val() === "") {
               			$("#stat_id").addClass("is-invalid");
               			$(".stat-error").html('Required Civil Status');
               			$(".stat-error").css({
               				"color": "red",
               				"font-size": "14px",
               			});
               			return false;
               		} else {
               			$("#stat_id").removeClass("is-invalid").addClass("is-valid");
               			$(".stat-error").css({
               				"display": "none"
               			});
               			return true;
               		}
               	};
               
               	function isValidCnumber() {
               		if ($("#contact_number").val() === "" && $("#contact_number").val()) {
               			$("#contact_number").removeClass("is-invalid").addClass("is-valid");
               			return false;
               		} else {
               			$("#contact_number").removeClass("is-invalid").addClass("is-valid");
               			return true;
               		}
               	};
               
               	function isValidEmailAddress() {
               		if ($("#email_address").val() === "" && $("#email_address").val()) {
               			$("#email_address").removeClass("is-invalid").addClass("is-valid");
               			return false;
               		} else {
               			$("#email_address").removeClass("is-invalid").addClass("is-valid");
               			return true;
               		}
               	};
               
               	function isValidSection() {
               		if ($("#sec_id").val() === "") {
               			$("#sec_id").addClass("is-invalid");
               			$(".sec-error").html('Required Section');
               			$(".sec-error").css({
               				"color": "red",
               				"font-size": "14px",
               			});
               			return false;
               		} else {
               			$("#sec_id").removeClass("is-invalid").addClass("is-valid");
               			$(".sec-error").css({
               				"display": "none"
               			});
               			return true;
               		}
               	};
               
               	function isValidDhire() {
               		if ($("#date_hire").val() === "") {
               			$("#date_hire").addClass("is-invalid");
               			$(".dh-error").html('Required Date Hire');
               			$(".dh-error").css({
               				"color": "red",
               				"font-size": "14px",
               			});
               			return false;
               		} else {
               			$("#date_hire").removeClass("is-invalid").addClass("is-valid");
               			$(".dh-error").css({
               				"display": "none"
               			});
               			return true;
               		}
               	};
               
               	function isValidDepartment() {
               		if ($("#dept_id").val() === "") {
               			$("#dept_id").addClass("is-invalid");
               			$(".dprt-error").html('Required Department');
               			$(".dprt-error").css({
               				"color": "red",
               				"font-size": "14px",
               			});
               			return false;
               		} else {
               			$("#dept_id").removeClass("is-invalid").addClass("is-valid");
               			$(".dprt-error").css({
               				"display": "none"
               			});
               			return true;
               		}
               	};
               
               	function isValidSex() {
               		if ($("#sex_id").val() === "") {
               			$("#sex_id").addClass("is-invalid");
               			$(".sex-error").html('Required Sex');
               			$(".sex-error").css({
               				"color": "red",
               				"font-size": "14px",
               			});
               			return false;
               		} else {
               			$("#sex_id").removeClass("is-invalid").addClass("is-valid");
               			$(".sex-error").css({
               				"display": "none"
               			});
               			return true;
               		}
               	};
               
               	function isValiCAddress() {
               		var pattern = /^[a-zA-Z0-9 !_@#$%^&-*].*$/;
               		var complete_address = $("#complete_address").val();
               		if (pattern.test(complete_address) && complete_address !== "") {
               			$("#complete_address").removeClass("is-invalid").addClass("is-valid");
               			$(".ca-error").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (complete_address === "") {
               			$("#complete_address").removeClass("is-valid").addClass("is-invalid");
               			$(".ca-error").html('Required Complete Address');
               			$(".ca-error").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#complete_address").removeClass("is-valid").addClass("is-invalid");
               			$(".ca-error").html('Please input Character/Number');
               			$(".ca-error").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
               	function isValidUname() {
               		var pattern = /^[a-zA-Z0-9 !_@#$%^&-*].*$/;
               		var username = $("#username").val();
               		if (pattern.test(username) && username !== "") {
               			$("#username").removeClass("is-invalid").addClass("is-valid");
               			$(".uname-error").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (username === "") {
               			$("#username").removeClass("is-valid").addClass("is-invalid");
               			$(".uname-error").html('Required Username');
               			$(".uname-error").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#username").removeClass("is-valid").addClass("is-invalid");
               			$(".uname-error").html('Please input Character');
               			$(".uname-error").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
               	function isValidPass() {
               		var pattern = /^[a-zA-Z0-9 !_@#$%^&-*].*$/;
               		var password = $("#password").val();
               		if (pattern.test(password) && password !== "") {
               			$("#password").removeClass("is-invalid").addClass("is-valid");
               			$(".pass-error").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (password === "") {
               			$("#password").removeClass("is-valid").addClass("is-invalid");
               			$(".pass-error").html('Required Password');
               			$(".pass-error").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#password").removeClass("is-valid").addClass("is-invalid");
               			$(".pass-error").html('Please input Secure Password');
               			$(".pass-error").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
               	function isValidStat() {
               		if ($("#status").val() === "" && $("#status").val()) {
               			$("#status").removeClass("is-invalid").addClass("is-valid");
               			return false;
               		} else {
               			$("#status").removeClass("is-invalid").addClass("is-valid");
               			return true;
               		}
               	};
               	isValidEMPNo();
               	isValidRFIDNo();
               	isValidLastName();
               	isValidFirstName();
               	isValidMname();
               	isValidDbirth();
               	isValidPlaceofBirth();
               	isValidSex();
               	isValidCivilStat();
               	isValidCnumber();
               	isValidEmailAddress();
               	isValidSection();
               	isValidDhire();
               	isValidDepartment();
               	isValiCAddress();
               	isValidUname();
               	isValidPass();
               	isValidStat();
               	if (isValidEMPNo() === true && isValidRFIDNo() === true && isValidLastName() === true && isValidFirstName() === true && isValidMname() === true && isValidDbirth() === true && isValidPlaceofBirth() === true && isValidSex() === true && isValidCivilStat() === true && isValidCnumber() === true && isValidEmailAddress() === true && isValidSection() === true && isValidDhire() === true && isValidDepartment() === true && isValiCAddress() === true && isValidUname() === true && isValidPass() === true && isValidStat() === true) {
               		$.ajax({
               			url: '../config/init/add_employee.php',
               			method: 'POST',
               			data: form_data,
               			contentType: false,
               			cache: false,
               			processData: false,
               			success: function(response) {
               				$("#mgs-emp").html(response);
               				$('#mgs-emp').animate({
               					scrollTop: 0
               				}, 'slow');
               			},
               			error: function(response) {
               				console.log("Failed");
               			}
               		});
               	}
               });
               </script>-->
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
               <select  class="form-control dept_ID" name="sex" id="sex_id" autocomplete="off">
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
               <select  class="form-control edit-status" name="civil_status" id="stat_id" autocomplete="off">
                  <option value="edit-status"></option>
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
               <select  class="form-control dept_ID" name="department" id="dept_id" autocomplete="off">
                  <option class="edit-department"></option>
                  <option value="Humss">HUMSS AUSTEN</option>
                  <option value="Accounting">Accounting Department</option>
                  <option value="mis">MIS depertment</option>
               </select>
               <span class="dprt-error"></span>
            </div>
         </div>
         <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="form-group">
               <label>ROLE:</label>
               <select class="form-control" name="role" id="role" autocomplete="off">
                  <option class="edit-role-val"></option>
                  <option value="Student">Student</option>
                  <option value="Instructor">Instructor</option>
                  <option value="Employee">Employee</option>
                  <option value="Visitor">Visitor</option>
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
               <input type="text" class="form-control edit-address" name="address" id="complete_address" autocomplete="off">
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

            <!--<script type="text/javascript">
               $(document).delegate('#btn-editemp', 'click', function(event) {
               	event.preventDefault();
               	// alert('click');
               	var photo = document.getElementById('edit_photos').files[0];
               	var employee_no = $('#edit_employeeno').val();
               	var frid_number = $('#edit_fridnumber').val();
               	var last_name = $('#edit_lastname').val();
               	var first_name = $('#edit_firstname').val();
               	var middle_name = $('#edit_middlename').val();
               	var date_of_birth = $('#edit_dateofbirth').val();
               	var place_of_birth = $('#edit_placeofbirth').val();
               	var sex = $('#edit_sex').val();
               	var civil_status = $('#edit_civilstatus').val();
               	var contact_number = $('#edit_contactnumber').val();
               	var email_address = $('#edit_emailaddress').val();
               	var designation = $('#edit_designation').val();
               	var date_hire = $('#edit_datehire').val();
               	var department = $('#edit_department option:selected').val();
               	var complete_address = $('#edit_completeaddress').val();
               	var username = $('#edit_username').val();
               	var password = $('#edit_password').val();
               	var status = $('#edit_status option:selected').val();
               	var employee_id = $('#edit_employeeid').val();
               	var form_data = new FormData();
               	form_data.append('photo', $('#edit_photos')[0].files[0]);
               	form_data.append("employee_no", employee_no);
               	form_data.append("frid_number", frid_number);
               	form_data.append("last_name", last_name);
               	form_data.append("first_name", first_name);
               	form_data.append("middle_name", middle_name);
               	form_data.append("date_of_birth", date_of_birth);
               	form_data.append("place_of_birth", place_of_birth);
               	form_data.append("sex", sex);
               	form_data.append("civil_status", civil_status);
               	form_data.append("contact_number", contact_number);
               	form_data.append("email_address", email_address);
               	form_data.append("designation", designation);
               	form_data.append("date_hire", date_hire);
               	form_data.append("department", department);
               	form_data.append("complete_address", complete_address);
               	form_data.append("username", username);
               	form_data.append("password", password);
               	form_data.append("status", status);
               	form_data.append("employee_id", employee_id);
               
               	function isValidEMPNo2() {
               		var pattern = /^[a-zA-Z 0-9 -\s]+$/;
               		var employee_no = $("#edit_employeeno").val();
               		if (pattern.test(employee_no) && employee_no !== "") {
               			$("#edit_employeeno").removeClass("is-invalid").addClass("is-valid");
               			$(".rfidno-error2").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (employee_no === "") {
               			$("#edit_employeeno").removeClass("is-valid").addClass("is-invalid");
               			$(".empno-error2").html('Required Employee Number');
               			$(".empno-error2").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#edit_employeeno").removeClass("is-valid").addClass("is-invalid");
               			$(".empno-error2").html('Please input Character/No. only');
               			$(".empno-error2").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
               	function isValidRFIDNo2() {
               		var pattern = /^[0-9 \s]+$/;
               		var frid_number = $("#edit_fridnumber").val();
               		if (pattern.test(frid_number) && frid_number !== "") {
               			$("#edit_fridnumber").removeClass("is-invalid").addClass("is-valid");
               			$(".rfidno-error2").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (frid_number === "") {
               			$("#edit_fridnumber").removeClass("is-valid").addClass("is-invalid");
               			$(".rfidno-error2").html('Required RFID Number');
               			$(".rfidno-error2").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#edit_fridnumber").removeClass("is-valid").addClass("is-invalid");
               			$(".rfidno-error2").html('Please input Number only');
               			$(".rfidno-error2").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
               	function isValidLastName2() {
               		var pattern = /^[a-zA-Z \s]+$/;
               		var last_name = $("#edit_lastname").val();
               		if (pattern.test(last_name) && last_name !== "") {
               			$("#edit_lastname").removeClass("is-invalid").addClass("is-valid");
               			$(".lname-error2").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (last_name === "") {
               			$("#edit_lastname").removeClass("is-valid").addClass("is-invalid");
               			$(".lname-error2").html('Required Last Name');
               			$(".lname-error2").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#edit_lastname").removeClass("is-valid").addClass("is-invalid");
               			$(".lname-error2").html('Please input Character only');
               			$(".lname-error2").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
               	function isValidFirstName2() {
               		var pattern = /^[a-zA-Z \s]+$/;
               		var first_name = $("#edit_firstname").val();
               		if (pattern.test(first_name) && first_name !== "") {
               			$("#edit_firstname").removeClass("is-invalid").addClass("is-valid");
               			$(".fname-error2").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (first_name === "") {
               			$("#edit_firstname").removeClass("is-valid").addClass("is-invalid");
               			$(".fname-error2").html('Required First Name');
               			$(".fname-error2").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#edit_firstname").removeClass("is-valid").addClass("is-invalid");
               			$(".fname-error2").html('Please input Character only');
               			$(".fname-error2").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
               	function isValidMname2() {
               		if ($("#edit_middlename").val() === "" && $("#edit_middlename").val()) {
               			$("#edit_middlename").removeClass("is-invalid").addClass("is-valid");
               			return false;
               		} else {
               			$("#edit_middlename").removeClass("is-invalid").addClass("is-valid");
               			return true;
               		}
               	};
               
               	function isValidDbirth2() {
               		if ($("#edit_dateofbirth").val() === "") {
               			$("#edit_dateofbirth").addClass("is-invalid");
               			$(".dob-error2").html('Required Date of Birth');
               			$(".dob-error2").css({
               				"color": "red",
               				"font-size": "14px",
               			});
               			return false;
               		} else {
               			$("#edit_dateofbirth").removeClass("is-invalid").addClass("is-valid");
               			$(".dob-error2").css({
               				"display": "none"
               			});
               			return true;
               		}
               	};
               
               	function isValidPlaceofBirth2() {
               		var pattern = /^[a-zA-Z \s]+$/;
               		var place_of_birth = $("#edit_placeofbirth").val();
               		if (pattern.test(place_of_birth) && place_of_birth !== "") {
               			$("#edit_placeofbirth").removeClass("is-invalid").addClass("is-valid");
               			$(".pob-error2").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (place_of_birth === "") {
               			$("#edit_placeofbirth").removeClass("is-valid").addClass("is-invalid");
               			$(".pob-error2").html('Required Place of Birth');
               			$(".pob-error2").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#edit_placeofbirth").removeClass("is-valid").addClass("is-invalid");
               			$(".pob-error2").html('Please input Character only');
               			$(".pob-error2").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
               	function isValidSex2() {
               		var pattern = /^[a-zA-Z \s]+$/;
               		var sex = $("#edit_sex").val();
               		if (pattern.test(sex) && sex !== "") {
               			$("#edit_sex").removeClass("is-invalid").addClass("is-valid");
               			$(".sex-error2").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (sex === "") {
               			$("#edit_sex").removeClass("is-valid").addClass("is-invalid");
               			$(".sex-error2").html('Required Sex');
               			$(".sex-error2").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#edit_sex").removeClass("is-valid").addClass("is-invalid");
               			$(".sex-error2").html('Please input Character only');
               			$(".sex-error2").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
            
               	function isValidCnumber2() {
               		if ($("#edit_contactnumber").val() === "" && $("#edit_contactnumber").val()) {
               			$("#edit_contactnumber").removeClass("is-invalid").addClass("is-valid");
               			return false;
               		} else {
               			$("#edit_contactnumber").removeClass("is-invalid").addClass("is-valid");
               			return true;
               		}
               	};
               
               	function isValidEmailAddress2() {
               		if ($("#edit_emailaddress").val() === "" && $("#edit_emailaddress").val()) {
               			$("#edit_emailaddress").removeClass("is-invalid").addClass("is-valid");
               			return false;
               		} else {
               			$("#edit_emailaddress").removeClass("is-invalid").addClass("is-valid");
               			return true;
               		}
               	};
               
               	function isValidDesignation2() {
               		var pattern = /^[a-zA-Z \s]+$/;
               		var designation = $("#edit_designation").val();
               		if (pattern.test(designation) && designation !== "") {
               			$("#edit_designation").removeClass("is-invalid").addClass("is-valid");
               			$(".design-error2").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (designation === "") {
               			$("#edit_designation").removeClass("is-valid").addClass("is-invalid");
               			$(".design-error2").html('Required Designation');
               			$(".design-error2").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#edit_designation").removeClass("is-valid").addClass("is-invalid");
               			$(".design-error2").html('Please input Character only');
               			$(".design-error2").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
               	function isValidDhire2() {
               		if ($("#edit_datehire").val() === "") {
               			$("#edit_datehire").addClass("is-invalid");
               			$(".dh-error2").html('Required Date Hire');
               			$(".dh-error2").css({
               				"color": "red",
               				"font-size": "14px",
               			});
               			return false;
               		} else {
               			$("#edit_datehire").removeClass("is-invalid").addClass("is-valid");
               			$(".dh-error2").css({
               				"display": "none"
               			});
               			return true;
               		}
               	};
               
               	function isValidDepartment2() {
               		if ($("#edit_department").val() === "") {
               			$("#edit_department").addClass("is-invalid");
               			$(".dprt-error2").html('Required Department');
               			$(".dprt-error2").css({
               				"color": "red",
               				"font-size": "14px",
               			});
               			return false;
               		} else {
               			$("#edit_department").removeClass("is-invalid").addClass("is-valid");
               			$(".dprt-error2").css({
               				"display": "none"
               			});
               			return true;
               		}
               	};
               
               	function isValiCAddress2() {
               		var pattern = /^[a-zA-Z0-9 !_@#$%^&-*].*$/;
               		var complete_address = $("#edit_completeaddress").val();
               		if (pattern.test(complete_address) && complete_address !== "") {
               			$("#edit_completeaddress").removeClass("is-invalid").addClass("is-valid");
               			$(".ca-error2").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (complete_address === "") {
               			$("#edit_completeaddress").removeClass("is-valid").addClass("is-invalid");
               			$(".ca-error2").html('Required Complete Address');
               			$(".ca-error2").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#edit_completeaddress").removeClass("is-valid").addClass("is-invalid");
               			$(".ca-error2").html('Please input Character/Number');
               			$(".ca-error2").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
               	function isValidUname2() {
               		var pattern = /^[a-zA-Z0-9 !_@#$%^&-*].*$/;
               		var username = $("#edit_username").val();
               		if (pattern.test(username) && username !== "") {
               			$("#edit_username").removeClass("is-invalid").addClass("is-valid");
               			$(".uname-error2").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (username === "") {
               			$("#edit_username").removeClass("is-valid").addClass("is-invalid");
               			$(".uname-error2").html('Required Username');
               			$(".uname-error2").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#edit_username").removeClass("is-valid").addClass("is-invalid");
               			$(".uname-error2").html('Please input Character');
               			$(".uname-error2").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
               	function isValidPass2() {
               		var pattern = /^[a-zA-Z0-9 !_@#$%^&-*].*$/;
               		var password = $("#edit_password").val();
               		if (pattern.test(password) && password !== "") {
               			$("#edit_password").removeClass("is-invalid").addClass("is-valid");
               			$(".pass-error2").css({
               				"color": "green",
               				"font-size": "14px",
               				"display": "none"
               			});
               			return true;
               		} else if (password === "") {
               			$("#edit_password").removeClass("is-valid").addClass("is-invalid");
               			$(".pass-error2").html('Required Password');
               			$(".pass-error2").css({
               				"color": "red",
               				"font-size": "14px"
               			});
               		} else {
               			$("#edit_password").removeClass("is-valid").addClass("is-invalid");
               			$(".pass-error2").html('Please input Secure Password');
               			$(".pass-error2").css({
               				"color": "red",
               				"font-size": "14px",
               				"display": "block"
               			});
               		}
               	};
               
               	function isValidStat2() {
               		if ($("#edit_status").val() === "" && $("#edit_status").val()) {
               			$("#edit_status").removeClass("is-invalid").addClass("is-valid");
               			return false;
               		} else {
               			$("#edit_status").removeClass("is-invalid").addClass("is-valid");
               			return true;
               		}
               	};
               	isValidEMPNo2();
               	isValidRFIDNo2();
               	isValidLastName2();
               	isValidFirstName2();
               	isValidMname2();
               	isValidDbirth2();
               	isValidPlaceofBirth2();
               	isValidSex2();
               	isValidCivilStat2();
               	isValidCnumber2();
               	isValidEmailAddress2();
               	isValidDesignation2();
               	isValidDhire2();
               	isValidDepartment2();
               	isValiCAddress2();
               	isValidUname2();
               	isValidPass2();
               	isValidStat2();
               	if (isValidEMPNo2() === true && isValidRFIDNo2() === true && isValidLastName2() === true && isValidFirstName2() === true && isValidMname2() === true && isValidDbirth2() === true && isValidPlaceofBirth2() === true && isValidSex2() === true && isValidCivilStat2() === true && isValidCnumber2() === true && isValidEmailAddress2() === true && isValidDesignation2() === true && isValidDhire2() === true && isValidDepartment2() === true && isValiCAddress2() === true && isValidUname2() === true && isValidPass2() === true && isValidStat2() === true) {
               		$.ajax({
               			url: '../config/init/edit_employee.php',
               			method: 'POST',
               			data: form_data,
               			contentType: false,
               			cache: false,
               			processData: false,
               			success: function(response) {
               				$("#mgs-editemp").html(response);
               				$('#mgs-editemp').animate({
               					scrollTop: 0
               				}, 'slow');
               			},
               			error: function(response) {
               				console.log("Failed");
               			}
               		});
               	}
               });
            </script>-->
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
								 <p class="user_name"></p>
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
         <!-- <script>
            $(document).ready(function() {
            	load_data();
            	var count = 1;
			
			<script>
            	 function load_data() {
            	 	$(document).on('click', '.btn-edit', function() {
            			$('#editemployeeModal').modal('show');
            			var employee_id = $(this).data("edit");
            	 		// console.log(department_id);
            			// getID(employee_id); //argument    
						$('.idhere').html($(this).attr('data-id'));
            		});
            	}
				</script>
            
            	function getID(employee_id) {
            		$.ajax({
            			type: 'POST',
            			url: '../config/init/row_employee.php',
            			data: {
            				employee_id: employee_id
            			},
            			dataType: 'json',
            			success: function(response) {
            				$('#edit_employeeid').val(response.employee_id);
            				if (response.photo == "../uploads/") {
            					$('#edit_photo').attr("src", "../uploads/default/depositphotos_531920820-stock-illustration-photo-available-vector-icon-default.jpg");
            				} else {
            					$('#edit_photo').attr("src", response.photo);
            				}
            				$('#edit_employeeno').val(response.employee_no);
            				$('#edit_fridnumber').val(response.frid_number);
            				$('#edit_lastname').val(response.last_name);
            				$('#edit_firstname').val(response.first_name);
            				$('#edit_middlename').val(response.middle_name);
            				$('#edit_dateofbirth').val(response.date_of_birth);
            				$('#edit_placeofbirth').val(response.place_of_birth);
            				$('#edit_sex').val(response.sex);
            				$('#edit_civilstatus').val(response.civil_status);
            				$('#edit_contactnumber').val(response.contact_number);
            				$('#edit_emailaddress').val(response.email_address);
            				$('#edit_designation').val(response.designation);
            				$('#edit_datehire').val(response.date_hire);
            				$('#edit_department').val(response.department);
            				$('#edit_completeaddress').val(response.complete_address);
            				$('#edit_username').val(response.username);
            				$('#edit_password').val(response.password);
            				$('#edit_status').val(response.status);
            			}
            		});
            	}
            });
         </script> -->
         <!-- <script>
            $(document).ready(function() {
            	load_data();
            	var count = 1;
			
			<script>
            	function load_data() {
            		$(document).on('click', '.btn-del', function() {
            			$('#delemployee-modal').modal('show');
            			var employee_id = $(this).data("del");
            			//get_delId(employee_id); //argument    
						$('.user_name').html($(this).attr('user_name'));
            		});
            	}
            	</script>
				
            	function get_delId(employee_id) {
            		$.ajax({
            			type: 'POST',
            			url: '../config/init/row_employee.php',
            			data: {
            				employee_id: employee_id
            			},
            			dataType: 'json',
            			success: function(response2) {
            				$('#delete_employeeid').val(response2.employee_id);
            				$('#delete_employeeno').val(response2.employee_no);
            			}
            		});
            	}
            });
         </script> -->
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