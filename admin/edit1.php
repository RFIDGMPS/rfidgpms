
<?php
  include('../connection.php');

		
					


switch ($_GET['edit'])
{
    case 'personell':
		
		$id = $_GET['id'];
				 $photo=$_POST['capturedImage'].' ';
	
				 $photo= trim($photo,"uploads/");
			
				 $id_no= $_POST['id_no'];
				 $rfid_number=$_POST['rfid_number'];
				 $last_name=$_POST['last_name'];
				 $first_name=$_POST['first_name'];
				$middle_name=$_POST['middle_name'];
					$date_of_birth=$_POST['date_of_birth'];
					$place_of_birth=$_POST['place_of_birth'];
					$sex=$_POST['sex'];
					$civil_status=$_POST['c_status'];
					$contact_number=$_POST['contact_number'];
			   $email_address=$_POST['email_address'];
					  $department=$_POST['e_department'];
					  
			   $role=$_POST['role'];
							$status=$_POST['status'];
							$complete_address=$_POST['complete_address'];
					
							if(isset($_FILES['photo']['name']) && $_FILES['photo']['name'] != null){
								$photo= $_FILES['photo']['name'];
							
								$target_dir = "uploads/";
								$target_file = $target_dir . basename($_FILES["photo"]["name"]);
								move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
								
							}
							
							
						 $query = "UPDATE personell SET 
						photo = '$photo',
						 id_no = '$id_no', 
						 rfid_number = '$rfid_number', 
						 last_name = '$last_name', 
						 first_name = '$first_name', 
						 middle_name = '$middle_name', 
						 date_of_birth = '$date_of_birth', 
						 place_of_birth = '$place_of_birth', 
						 sex = '$sex', 
						 civil_status = '$civil_status', 
						 contact_number = '$contact_number', 
						 email_address = '$email_address', 
						 department = '$department', 
						 role = '$role', 
						 status = '$status', 
						 complete_address = '$complete_address' 
					 WHERE id = '$id'";


							$result = mysqli_query($db, $query) or die(mysqli_error($db));

							if($status == 'Active'){
								$query1 = "UPDATE lostcard SET 
								 status = 0
								WHERE personnel_id = '$id'";
								$result = mysqli_query($db, $query1) or die(mysqli_error($db));
								}
							echo '<script type="text/javascript">
			alert("Update Successfull.");
			window.location = "personell.php";
		</script>';
    break;
    case 'department':
		$id = $_GET['id'];
		$department_name = $_POST['dptname'];
		$department_desc = $_POST['dptdesc'];
		
		// Prepare a SELECT query to check if the department name already exists, excluding the current department being updated
		$checkQuery = "SELECT COUNT(*) FROM department WHERE department_name = ? AND department_id != ?";
		
		// Initialize a prepared statement for the SELECT query
		$stmt = $db->prepare($checkQuery);
		
		if ($stmt) {
			// Bind the parameters (s = string, i = integer) for department name and department ID
			$stmt->bind_param("si", $department_name, $id);
			
			// Execute the statement
			$stmt->execute();
			
			// Bind the result to a variable
			$stmt->bind_result($count);
			$stmt->fetch();
		
			// Close the statement
			$stmt->close();
		
			if ($count > 0) {
				// Department with the same name already exists
				echo "Department name already exist.";
			} else {
				// If the department does not exist for other records, proceed with the update
		
				// Prepare an update query with placeholders
				$query = "UPDATE department SET department_name = ?, department_desc = ? WHERE department_id = ?";
		
				// Initialize a prepared statement for the UPDATE query
				$stmt = $db->prepare($query);
		
				if ($stmt) {
					// Bind parameters to the query (s = string, i = integer)
					$stmt->bind_param("ssi", $department_name, $department_desc, $id);
		
					// Execute the statement
					if ($stmt->execute()) {
						echo 'success';
					} else {
						// Handle execution error
						echo "Error: " . $stmt->error;
					}
		
					// Close the statement
					$stmt->close();
				} else {
					// Handle query preparation error
					echo "Error preparing UPDATE statement: " . $db->error;
				}
			}
		} else {
			// Handle query preparation error for the SELECT query
			echo "Error preparing SELECT statement: " . $db->error;
		}
		
		// Close the database connection
		$db->close();
		



						break;
						case 'visitor':
						
if (isset($_GET['id']) && isset($_POST['rfid_number'])) {
    $id = $_GET['id'];
    $rfid_number = $_POST['rfid_number'];
	
	if (strlen($rfid_number) !== 10 || !ctype_digit($rfid_number)) {
        echo 'RFID number must be exactly 10 digits.';
        return;
    }
    // Prepare a query to check if the RFID number already exists for a different ID
    $checkQuery = "SELECT * FROM visitor WHERE rfid_number = ? AND id != ?";
    $checkStmt = $db->prepare($checkQuery);
    $checkStmt->bind_param('si', $rfid_number, $id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    // Check if the RFID number already exists for a different record
    if ($checkResult->num_rows > 0) {
        echo 'RFID number already exist.';
    } else {
        // Prepare the update query
        $updateQuery = "UPDATE visitor SET rfid_number = ? WHERE id = ?";
        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->bind_param('si', $rfid_number, $id);

        // Execute the update query and check for success
        if ($updateStmt->execute()) {
            echo 'success';
        } else {
            echo 'Error in updating Database: ' . $updateStmt->error;
        }

        // Close the update statement
        $updateStmt->close();
    }

    // Close the check statement
    $checkStmt->close();
}


											break;
											case 'about':
												$name = $_POST['name'];
												$address = $_POST['address'];
												$logo1 = $_POST['logo1'];
												$logo2 = $_POST['logo2'];
												$logo1= trim($logo1,"uploads/");
												$logo2= trim($logo2,"uploads/");
												
							if(isset($_FILES['logo1']['name']) && $_FILES['logo1']['name'] != null){
								$logo1= $_FILES['logo1']['name'];
							
								$target_dir = "uploads/";
								$target_file = $target_dir . basename($_FILES["logo1"]["name"]);
								move_uploaded_file($_FILES["logo1"]["tmp_name"], $target_file);
								
							}

							if(isset($_FILES['logo2']['name']) && $_FILES['logo2']['name'] != null){
								$logo2= $_FILES['logo2']['name'];
							
								$target_dir = "uploads/";
								$target_file = $target_dir . basename($_FILES["logo2"]["name"]);
								move_uploaded_file($_FILES["logo2"]["tmp_name"], $target_file);
								
							}
						

												$query = "UPDATE about SET 
																name = '$name',
																address = '$address',
																logo1 = '$logo1',
																logo2 = '$logo2'
																WHERE id = 1";
																	$result = mysqli_query($db, $query) or die(mysqli_error($db));
																	echo '<script type="text/javascript">
																	alert("Saved.");
																	window.location = "settings.php";
																</script>';
																break;
																case 'role':
																	
																
																	if (isset($_GET['id']) && isset($_POST['role'])) {
																		$id = $_GET['id'];
																		$role = $_POST['role'];
																	
																		// Check if the role already exists
																		$check_query = "SELECT * FROM role WHERE role = ? AND id != ?";
																		$stmt_check = $db->prepare($check_query);
																		$stmt_check->bind_param('si', $role, $id);
																		$stmt_check->execute();
																		$result_check = $stmt_check->get_result();
																	
																		if ($result_check->num_rows > 0) {
																			// Role already exists
																			echo 'Role already exist.';
																		} else {
																			// Prepare the update query
																			$query = "UPDATE role SET role = ? WHERE id = ?";
																			$stmt = $db->prepare($query);
																	
																			// Bind parameters (role and id)
																			$stmt->bind_param('si', $role, $id);
																	
																			// Execute the query and check for success
																			if ($stmt->execute()) {
																				echo 'success';
																			} else {
																				echo 'Error in updating Database: ' . $stmt->error;
																			}
																	
																			// Close the statement
																			$stmt->close();
																		}
																	
																		// Close the check statement
																		$stmt_check->close();
																	}
																	
																	
																	

																					break;
																					case 'room':// Get the ID from the URL
																						$id = $_GET['id'];
																						
																						// Get the POST data
																						$room = $_POST['roomname'];
																						$department = $_POST['roomdpt'];
																						$descr = $_POST['roomdesc'];
																						$role = $_POST['roomrole'];
																						$password = password_hash($_POST['roompass'], PASSWORD_DEFAULT);
																						
																						// Check if the room and department already exist
																						$checkQuery = "SELECT COUNT(*) FROM rooms WHERE room = ? AND department = ? AND id != ?";
																						
																						// Initialize a prepared statement for the SELECT query
																						$stmt = $db->prepare($checkQuery);
																						
																						if ($stmt) {
																							// Bind parameters to the query (s = string, i = integer)
																							$stmt->bind_param("ssi", $room, $department, $id);
																						
																							// Execute the query
																							$stmt->execute();
																						
																							// Bind the result to a variable
																							$stmt->bind_result($count);
																							$stmt->fetch();
																						
																							// Close the statement
																							$stmt->close();
																						
																							if ($count > 0) {
																								// Room and department already exist
																								echo "Room already exist on the same department.";
																							} else {
																								// Proceed with the UPDATE query if no duplicates are found
																						
																								// Prepare the UPDATE query with placeholders
																								$query = "UPDATE rooms SET room = ?, department = ?, descr = ?, authorized_personnel = ?, password = ? WHERE id = ?";
																						
																								// Initialize a prepared statement for the UPDATE query
																								$stmt = $db->prepare($query);
																						
																								if ($stmt) {
																									// Bind parameters to the query (s = string, i = integer)
																									$stmt->bind_param("sssssi", $room, $department, $descr, $role, $password, $id);
																						
																									// Execute the statement
																									if ($stmt->execute()) {
																										echo 'success';
																									} else {
																										// Handle execution error
																										echo "Error: " . $stmt->error;
																									}
																						
																									// Close the statement
																									$stmt->close();
																								} else {
																									// Handle query preparation error
																									echo "Error preparing statement: " . $db->error;
																								}
																							}
																						} else {
																							// Handle query preparation error for the SELECT query
																							echo "Error preparing SELECT statement: " . $db->error;
																						}
																						
																						// Close the database connection
																						$db->close();
																						

break;
																					
																
}
?>	
	
