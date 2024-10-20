

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
                                    <h6 class="mb-4">Manage Rooms</h6>
                                </div>
                                <div class="col-3">
                                    <button type="button" class="btn btn-outline-warning m-2" data-bs-toggle="modal" data-bs-target="#roomModal">Add Room</button>
                                </div>
                            </div>
                            <hr></hr>
                            <div class="table-responsive">
                                <table class="table table-border" id="myDataTable">
                                    <thead>
                                        <tr>
                                     
                                            <th scope="col" >Department</th>
                                            <th scope="col" >Authorized Role</th>
                                            <th scope="col">Room</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Password</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php include '../connection.php';  

                                            ?>





                                 <?php $results = mysqli_query($db, "SELECT * FROM rooms ORDER BY id"); ?>
                                 <?php while ($row = mysqli_fetch_array($results)) { ?>
                                    <tr  class="table-<?php echo $row['id'];?>">
                                  
                                    <td class="department"><?php echo $row['department']; ?></td>
                                    <td><?php echo $row['authorized_personnel']; ?></td>
                                            <td><?php echo $row['room']; ?></td>
                                            <td><?php echo $row['descr']; ?></td>
                                            <td><?php echo substr($row['password'], 0, 10) . '...'; ?></td>
                                            <td width="14%">
                                            <center>
                                          <button authrole="<?php echo $row['authorized_personnel'];?>" descr="<?php echo $row['descr'];?>" pass="<?php echo $row['password'];?>" room="<?php echo $row['room'];?>" department="<?php echo $row['department'];?>" data-id="<?php echo $row['id'];?>" class="btn btn-outline-primary btn-sm btn-edit e_room_id" >
                                          <i class="bi bi-plus-edit"></i> Edit </button>
                                          <button authrole="<?php echo $row['authorized_personnel'];?>" descr="<?php echo $row['descr'];?>" pass="<?php echo $row['password'];?>" room="<?php echo $row['room'];?>" department="<?php echo $row['department'];?>"  data-id="<?php echo $row['id']; ?>" class="btn btn-outline-danger btn-sm btn-del d_room_id">
                                          <i class="bi bi-plus-trash"></i> Delete </button>
                                          <input type="hidden" id="dpt" value="<?php echo $row['department'];?>"/>
                                          <input type="hidden" id="role" value="<?php echo $row['authorized_personnel'];?>"/>
                                          <input type="hidden" id="desc" value="<?php echo $row['descr'];?>"/>
                                          <input type="hidden" id="pass" value="<?php echo $row['password'];?>"/>
                                          <input type="hidden" id="name" value="<?php echo $row['room'];?>"/>
                                       </center> </td>
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
    $('#myDataTable').DataTable({
        order: [[0, 'desc']] // Adjust the index (0) to the appropriate column
    });
});
</script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
 $('.d_room_id').click(function(){
    $id = $(this).attr('data-id');
var id = $id;
    Swal.fire({
  title: "Are you sure?",
  text: "You won't be able to revert this!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Yes, delete it!"
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
                type: "GET",
                url: "del.php?type=room&id=" + id,
                data:{id:id},
                dataType: 'text',
                success: function(data){
                    if (data.trim() == 'success') {
                        Swal.fire({
      title: "Deleted!",
      text: "Room has been deleted.",
      icon: "success"

            }).then(() => {
                window.location.href = 'room.php'; // Redirect after 1.5 seconds
            });
                    } else {
                        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong! Please try again.'
        });
                    }
                }
});

   
  }
});

});



</script>
            <!-- Modal -->
            <div class="modal fade" id="roomModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-plus-circle"></i> New Room</h5>
                            <button type="button" onclick="resetForm()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="myForm">
                            <div class="modal-body">
                                <div class="col-lg-12 mt-1" id="mgs-dept"></div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Department: </b></label>
                                        <select  class="form-control" name="roomdpt" id="roomdpt" autocomplete="off">
              
				
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
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Authorized Role: </b></label>
                                        <select  class="form-control" name="roomrole" id="roomrole" autocomplete="off">
              
				
<?php
										  $sql = "SELECT * FROM role";
$result = $db->query($sql);

// Initialize an array to store department options
$role_options = [];

// Fetch and store department options
while ($row = $result->fetch_assoc()) {

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
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-1">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Room:</b></label>
                                        <input name="roomname" type="text" id="roomname" class="form-control" autocomplete="off">
                                        <span class="roomname-error" id="roomname-error" style="color:red;font-size:10px;"></span>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-1">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Description:</b></label>
                                        <input  name="roomdesc" type="text" id="roomdesc" class="form-control" autocomplete="off">
                                        <span class="roomdesc-error" id="roomdesc-error" style="color:red;font-size:10px;"></span>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-1">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Password:</b></label>
                                        <input name="roompass" type="password" id="roompass" class="form-control" autocomplete="off">
                                        <span class="roompass-error" id="roompass-error" style="color:red;font-size:10px;"></span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input type="checkbox" id="remember" onclick="myFunction()"  class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Show Password</label>
                            </div>
                        </div>
                                <script>
        function myFunction() {
            var x = document.getElementById("roompass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="resetForm()" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-outline-warning" id="btn-room">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
  
            <script>
                 function resetForm() {
                    document.getElementById('roomname-error').innerHTML = '';
        document.getElementById('roomdesc-error').innerHTML = '';
        document.getElementById('roompass-error').innerHTML = '';

        document.getElementById('eroomname-error').innerHTML = '';
        document.getElementById('eroomdesc-error').innerHTML = '';
        document.getElementById('eroompass-error').innerHTML = '';
    document.getElementById('myForm').reset();  // Reset all input fields
}

          $('#btn-room').click(function(){
         

            var inputField = document.getElementById('roomname');
var inputField1 = document.getElementById('roomdesc');
var inputField2 = document.getElementById('roompass');

// Function to handle error display
function showError(input, errorId, message) {
    if (input.value === '') {
        document.getElementById(errorId).innerHTML = message;
        input.focus();
        return false;
    } else {
        document.getElementById(errorId).innerHTML = '';
        return true;
    }
}

// Check inputs
if (!showError(inputField, 'roomname-error', 'This field is required.') ||
    !showError(inputField1, 'roomdesc-error', 'This field is required.') ||
    !showError(inputField2, 'roompass-error', 'This field is required.')) {
    // Prevent submission if any input is invalid
    return;
} else {
    // Clear all error messages if validation passes
    document.getElementById('roomname-error').innerHTML = '';
    document.getElementById('roomdesc-error').innerHTML = '';
    document.getElementById('roompass-error').innerHTML = '';

        var roomdpt =  document.getElementById('roomdpt').value;
          var roomrole =  document.getElementById('roomrole').value;
          var roomname =  document.getElementById('roomname').value;
          var roomdesc =  document.getElementById('roomdesc').value;
          var roompass =  document.getElementById('roompass').value;
          

              $.ajax({
                          type: "POST",
                          url: "transac.php?action=add_room",
                          data:{roomdpt:roomdpt, roomname:roomname, roomdesc:roomdesc, roompass:roompass,roomrole:roomrole},
                          dataType: 'text',
                          success: function(data){
                              if (data.trim() == 'success') {
                                  Swal.fire({
                          icon: 'success',
                          title: 'Sucessfully Added.',
                          showConfirmButton: false,
                          timer: 1500
                      }).then(() => {
                          window.location.href = 'room.php'; // Redirect after 1.5 seconds
                      });
                              } else {
                                  Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: data
                  });
                              }
                          }
          });
    }
          
          
          });
          
          
          
          
          </script>


            <script type="text/javascript">
         $(document).ready(function() {
         	$("#myDataTable").DataTable();
	// 		 $('.d_room_id').click(function(){
    //             $('#deldepartment-modal').modal('show');
						
    //            		$id = $(this).attr('data-id');
    //                    $dptname =  $(this).attr('room');
       
    //    $('.d-dpt').val($dptname);
    //            		$('.remove_id').click(function(){
    //            			window.location = 'del.php?type=room&id=' + $id;
						 
    //            		});
    //            	});
               	$('.e_room_id').click(function(){
               		$id = $(this).attr('data-id');
                       $('#editdepartment-modal').modal('show');
               		// $('#editModal').load('edit.php?id=' + $id);
                      
                       $dptname =  $(this).attr('room');
                       $dptdesc =  $(this).attr('department');
                       $role =  $(this).attr('authrole');
                       $desc =  $(this).attr('descr');

					$('.edit-name').val($dptname);
					$('.edit-desc').val($desc);
                    $('.edit-role').html($role);
                    $('.edit-department').html($dptdesc);
					// $('.edit-form').attr('action','edit1.php?id='+$id+'&edit=room');
                 
					
               	});
         });
		 
		 </script>


            <div class="modal fade" id="editdepartment-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Room</h5>
                            <button onclick="resetForm()" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- <form method="POST"  class="edit-form" role="form" action=""> -->
                            <div class="modal-body">
                                <div class="col-lg-12 mt-1" id="mgs-editdept"></div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Department: </b></label>
                                        <select  class="form-control" name="eroomdpt" id="eroomdpt" autocomplete="off">
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
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Authorized Role: </b></label>
                                        <select  class="form-control" name="eroomrole" id="eroomrole" autocomplete="off">
                                        <option class="edit-role"></option>
				
<?php
										  $sql = "SELECT * FROM role";
$result = $db->query($sql);

// Initialize an array to store department options
$role_options = [];

// Fetch and store department options
while ($row = $result->fetch_assoc()) {

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
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-1">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Room:</b></label>
                                        <input name="eroomname" type="text" id="eroomname" class="form-control edit-name" autocomplete="off">
                                        <span class="eroomname-error" id="eroomname-error" style="color:red;font-size:10px;"></span>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-1">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Description:</b></label>
                                        <input name="eroomdesc" type="text" id="eroomdesc" class="form-control edit-desc" autocomplete="off">
                                        <span class="eroomdesc-error" id="eroomdesc-error" style="color:red;font-size:10px;"></span>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-1">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Password:</b></label>
                                        <input name="eroompass" type="password" id="eroompass" class="form-control edit-pass" autocomplete="off">
                                        <span class="eroompass-error" id="eroompass-error" style="color:red;font-size:10px;"></span>
                                    </div>
                                </div>

                        
                            <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="form-check">
                                <input type="checkbox" id="remember" onclick="myFunction1()"  class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Show Password</label>
                            </div>
                            </div>
                                <script>
        function myFunction1() {
            var x = document.getElementById("eroompass");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>    </div>
                            <div class="modal-footer">
                                <input type="hidden" name="" id="edit_departmentid">
                                <button onclick="resetForm()"  type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary" id="btn-editdepartment">Update</button>
                            </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
            
          
          <script>
          $('#btn-editdepartment').click(function(){

            var inputField = document.getElementById('eroomname');
var inputField1 = document.getElementById('eroomdesc');
var inputField2 = document.getElementById('eroompass');

// Function to handle error display
function showError(input, errorId, message) {
    if (input.value === '') {
        document.getElementById(errorId).innerHTML = message;
        input.focus();
        return false;
    } else {
        document.getElementById(errorId).innerHTML = '';
        return true;
    }
}

// Check inputs
if (!showError(inputField, 'eroomname-error', 'This field is required.') ||
    !showError(inputField1, 'eroomdesc-error', 'This field is required.') ||
    !showError(inputField2, 'eroompass-error', 'This field is required.')) {
    // Prevent submission if any input is invalid
    return;
} else {
   
    // Clear all error messages if validation passes
    document.getElementById('eroomname-error').innerHTML = '';
    document.getElementById('eroomdesc-error').innerHTML = '';
    document.getElementById('eroompass-error').innerHTML = '';



            $('.e_room_id').click(function(){
               		$id = $(this).attr('data-id');


               	});

                
var id=$id;


var roomdpt =  document.getElementById('eroomdpt').value;

          
          var roomrole =  document.getElementById('eroomrole').value;
        
         
          var roomname =  document.getElementById('eroomname').value;
    
          
          var roomdesc =  document.getElementById('eroomdesc').value;
    
        
          var roompass =  document.getElementById('eroompass').value;
    

       

              $.ajax({
                          type: "POST",
                          url: "edit1.php?id="+id+"&edit=room",
                          data:{id:id,roomdpt:roomdpt, roomname:roomname, roomdesc:roomdesc, roompass:roompass,roomrole:roomrole},
                          dataType: 'text',
                          success: function(data){
                              if (data.trim() == 'success') {
                                  Swal.fire({
                          icon: 'success',
                          title: 'Sucessfully Updated.',
                          showConfirmButton: false,
                          timer: 1500
                      }).then(() => {
                          window.location.href = 'room.php'; // Redirect after 1.5 seconds
                      });
                              } else {
                                  Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: data
                  });
                              }
                          }
          });
        }
          });
          
      
          
          
          </script>

            <div class="modal fade" id="deldepartment-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-trash"></i> Delete Department</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST">
                            <div class="modal-body">
                                <div class="col-lg-12 mt-1" id="mgs-deldept"></div>
                                <div class="col-lg-12 mb-1">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Department Name:</b></label>
                                        <input  type="text" id="delete_departmentname" class="form-control d-dpt" autocomplete="off" readonly="">
                                        <span class="deptname-error"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="" id="delete_departmentid">
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">No</button>
                                <button type="button" class="btn btn-outline-primary remove_id" id="btn-deldepartment">Yes</button>
                            </div>
                        </form>
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