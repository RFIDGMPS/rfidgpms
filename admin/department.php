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
                                    <h6 class="mb-4">Manage Department</h6>
                                </div>
                                <div class="col-3">
                                    <button type="button" class="btn btn-outline-warning m-2" data-bs-toggle="modal" data-bs-target="#departmentModal">Add Department</button>
                                </div>
                            </div>
                            <hr></hr>
                            <div class="table-responsive">
                                <table class="table table-border" id="myDataTable">
                                    <thead>
                                        <tr>
                                            <th scope="col" >Department Name</th>
                                            <th scope="col">Department Description</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php include '../connection.php'; ?>
                                 <?php $results = mysqli_query($db, "SELECT * FROM department"); ?>
                                 <?php while ($row = mysqli_fetch_array($results)) { ?>
                                    <tr  class="table-<?php echo $row['department_id'];?>">
                                  
                                            <td><?php echo $row['department_name']; ?></td>
                                            <td><?php echo $row['department_desc']; ?></td>
                                            <td width="14%">
                                            <center>
                                          <button department_name="<?php echo $row['department_name'];?>" department_desc="<?php echo $row['department_desc'];?>" data-id="<?php echo $row['department_id'];?>" class="btn btn-outline-primary btn-sm btn-edit e_department_id" >
                                          <i class="bi bi-plus-edit"></i> Edit </button>
                                   
                                          <input hidden type="text" id="hiddenName" value="<?php echo $row['department_name'];?>"/>
                                          <input hidden type="text" id="hiddenDesc" value="<?php echo $row['department_desc'];?>"/>
                                          <button id="deldpt" department_name="<?php echo $row['department_name'];?>" department_desc="<?php echo $row['department_desc'];?>"  data-id="<?php echo $row['department_id']; ?>" class="btn btn-outline-danger btn-sm btn-del d_department_id">
                                          <i class="bi bi-plus-trash"></i> Delete </button>
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
 $('.d_department_id').click(function(){
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
                url: "del.php?type=department&id=" + $id,
                data:{id:id},
                dataType: 'text',
                success: function(data){
                    if (data.trim() == 'success') {
                        Swal.fire({
      title: "Deleted!",
      text: "Department has been deleted.",
      icon: "success"

            }).then(() => {
                window.location.href = 'department'; // Redirect after 1.5 seconds
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
            <div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-plus-circle"></i> New Department</h5>
                            <button type="button" onclick="resetForm()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="myForm">
                            <div class="modal-body">
                                <div class="col-lg-12 mt-1" id="mgs-dept"></div>
                                <div class="col-lg-12 mb-1">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Department Name:</b></label>
                                        <input name="department_name" type="text" id="department_name" class="form-control" autocomplete="off">
                                        <span class="deptname-error" id="deptname-error" style="color:red;font-size:10px;"></span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Department Description: </b></label>
                                        <textarea name="department_desc" type="text" id="department_description" class="form-control" autocomplete="off"></textarea>
                                        <span class="deptname-desc" id="deptname-desc" style="color:red;font-size:10px;"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="resetForm()" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-outline-warning" id="btn-department">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
          


          <script>
            function resetForm() {
                 document.getElementById('deptname-error').innerHTML = '';
        document.getElementById('deptname-desc').innerHTML = '';
    document.getElementById('myForm').reset();  // Reset all input fields
}
          $('#btn-department').click(function(){
          
            var inputField = document.getElementById('department_name');
var inputField1 = document.getElementById('department_description');

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
if (!showError(inputField, 'deptname-error', 'This field is required.') ||
    !showError(inputField1, 'deptname-desc', 'This field is required.')) {
    // Prevent submission or continue handling as necessary
    return;
} else {
    // Clear error messages if validation passes
    document.getElementById('deptname-error').innerHTML = '';
    document.getElementById('deptname-desc').innerHTML = '';

        var dptname =  document.getElementById('department_name').value;
          var dptdesc =  document.getElementById('department_description').value;
          
              $.ajax({
                          type: "POST",
                          url: "transac.php?action=add_department",
                          data:{dptname:dptname, dptdesc:dptdesc},
                          dataType: 'text',
                          success: function(data){
                              if (data.trim() == 'success') {
                                  Swal.fire({
                          icon: 'success',
                          title: 'Sucessfully Added.',
                          showConfirmButton: false,
                          timer: 1500
                      }).then(() => {
                          window.location.href = 'department'; // Redirect after 1.5 seconds
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
	// 		 $('.d_department_id').click(function(){
    //             $('#deldepartment-modal').modal('show');
						
    //            		$id = $(this).attr('data-id');
    //                    $dptname =  $(this).attr('department_name');
       
    //    $('.d-dpt').val($dptname);
    //            		// $('.remove_id').click(function(){
    //            		// 	window.location = 'del.php?type=department&id=' + $id;
						 
    //            		// });
    //            	});
               	$('.e_department_id').click(function(){
               		$id = $(this).attr('data-id');
                       $('#editdepartment-modal').modal('show');
               		// $('#editModal').load('edit.php?id=' + $id);
                       document.getElementById('edeptname-error').innerHTML = '';
                       document.getElementById('edeptname-desc').innerHTML = '';

                       $dptname =  $(this).attr('department_name');
                       $dptdesc =  $(this).attr('department_desc');
       


					$('.edit-name').val($dptname);
					$('.edit-desc').val($dptdesc);
					//$('.edit-form').attr('action','edit1.php?id='+$id+'&edit=department');
					
               	});
         });
		 
		 </script>

            
            <div class="modal fade" id="editdepartment-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Department</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- <form method="POST"  class="edit-form" role="form" action=""> -->
                            <div class="modal-body">
                                <div class="col-lg-12 mt-1" id="mgs-editdept"></div>
                                <div class="col-lg-12 mb-1">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Department Name:</b></label>
                                        <input name="department_name" type="text" id="edit_departmentname" class="form-control edit-name" autocomplete="off">
                                        <span class="deptname-error" id="edeptname-error" style="color:red;font-size:10px;"></span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="inputTime"><b>Department Description: </b></label>
                                        <textarea name="department_desc" type="text" id="edit_departmentdescription" class="form-control edit-desc" autocomplete="off"></textarea>
                                        <span class="deptname-error" id="edeptname-desc" style="color:red;font-size:10px;"></span>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="" id="edit_departmentid">
                                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary" id="btn-editdepartment">Update</button>
                            </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        
          
<script>
$('#btn-editdepartment').click(function(){
    var inputField = document.getElementById('edit_departmentname');
var inputField1 = document.getElementById('edit_departmentdescription');

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
var isNameValid = showError(inputField, 'edeptname-error', 'This field is required.');
var isDescValid = showError(inputField1, 'edeptname-desc', 'This field is required.');

// If both fields are valid, clear error messages
if (isNameValid && isDescValid) {
    document.getElementById('edeptname-error').innerHTML = '';
    document.getElementById('edeptname-desc').innerHTML = '';


        $('.e_department_id').click(function(){
               		$id = $(this).attr('data-id');
                      
					
               	});

var dptname =  document.getElementById('edit_departmentname').value;
var dptdesc =  document.getElementById('edit_departmentdescription').value;

    $.ajax({
                type: "POST",
                url: "edit1.php?id="+$id+"&edit=department",
                data:{dptname:dptname, dptdesc:dptdesc},
                dataType: 'text',
                success: function(data){
                    if (data.trim() == 'success') {
                        Swal.fire({
                icon: 'success',
                title: 'Sucessfully Updated.',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = 'department'; // Redirect after 1.5 seconds
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
            <!-- <script>
$('#btn-deldepartment').click(function(){
    $('.d_department_id').click(function(){
                
               		$id = $(this).attr('data-id');
                  
               	});
var id=$id;

    $.ajax({
                type: "GET",
                url: "del.php?type=department&id=" + $id,
                data:{id:id},
                dataType: 'text',
                success: function(data){
                    if (data.trim() == 'success') {
                        Swal.fire({
                icon: 'success',
                title: 'Sucessfully Deleted.',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = 'department.php'; // Redirect after 1.5 seconds
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

});




</script> -->

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