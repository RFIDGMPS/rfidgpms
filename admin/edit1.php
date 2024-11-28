
<?php
  include('../connection.php');

		
					


switch ($_GET['edit'])
{
    case 'personell':
		
// Ensure proper request method is used
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method");
}

// Sanitize and validate the input data
function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

$id = sanitizeInput($_POST['id']);
$rfid_number = sanitizeInput($_POST['rfid_number']);
$last_name = sanitizeInput($_POST['last_name']);
$first_name = sanitizeInput($_POST['first_name']);
$date_of_birth = sanitizeInput($_POST['date_of_birth']);
$status = sanitizeInput($_POST['status']);
$role = isset($_POST['role']) ? sanitizeInput($_POST['role']) : null;
$category = isset($_POST['category']) ? sanitizeInput($_POST['category']) : null;
$department = isset($_POST['e_department']) ? sanitizeInput($_POST['e_department']) : null;

// Validate inputs (example validation, you can expand it)
if (!is_numeric($id)) {
    die("Invalid ID format.");
}

$status_value = ($status == 'Active') ? 0 : 1;

// Retrieve current values for `role` and `category` if not provided
$query = "SELECT role, category FROM personell WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($current_role, $current_category);
$stmt->fetch();

$role = $role ?: $current_role;
$category = $category ?: $current_category;

// File upload logic with validation
$photo = null;
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $photo_name = basename($_FILES["photo"]["name"]);
    $target_dir = "uploads/";
    $target_file = $target_dir . $photo_name;
    
    // Validate the file type (e.g., only images are allowed)
    $allowed_file_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($_FILES['photo']['type'], $allowed_file_types)) {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $photo = $photo_name;
        } else {
            die('Error uploading the file.');
        }
    } else {
        die('Invalid file type. Only images are allowed.');
    }
} else {
    // Retrieve current photo if no new photo is uploaded
    $query = "SELECT photo FROM personell WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($photo);
    $stmt->fetch();
}

// SQL query to update the personell record using prepared statements
$query = "UPDATE personell SET 
    photo = ?,
    rfid_number = ?,
    category = ?,
    last_name = ?,
    first_name = ?,
    date_of_birth = ?,
    department = ?,
    role = ?,
    status = ?
WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("sssssssssi", $photo, $rfid_number, $category, $last_name, $first_name, $date_of_birth, $department, $role, $status, $id);

$result = $stmt->execute();

// Update the lostcard table
$query1 = "UPDATE lostcard SET status = ? WHERE personnel_id = ?";
$stmt1 = $db->prepare($query1);
$stmt1->bind_param("ii", $status_value, $id);
$result1 = $stmt1->execute();

// Prepare the response
if ($result && $result1) {
    $response = [
        'title' => 'Success!',
        'text' => 'The record has been updated successfully.',
        'icon' => 'success'
    ];
} else {
    $response = [
        'title' => 'Error!',
        'text' => 'Failed to update the record. Please try again.',
        'icon' => 'error'
    ];
}

// Return the JSON response
echo json_encode($response);

// Close the statements
$stmt->close();
$stmt1->close();

// Close the database connection
$db->close();
    break;
    case 'department':
		
// Ensure proper request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method");
}

// Sanitize and validate input data
function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

$id = isset($_GET['id']) ? sanitizeInput($_GET['id']) : null;
$department_name = isset($_POST['dptname']) ? sanitizeInput($_POST['dptname']) : null;
$department_desc = isset($_POST['dptdesc']) ? sanitizeInput($_POST['dptdesc']) : null;

// Validate inputs (example validation, you can expand it)
if (!$id || !is_numeric($id)) {
    die("Invalid department ID.");
}

if (empty($department_name) || empty($department_desc)) {
    die("Department name and description are required.");
}

// Prepare a SELECT query to check if the department name already exists, excluding the current department
$checkQuery = "SELECT COUNT(*) FROM department WHERE department_name = ? AND department_id != ?";

$stmt = $db->prepare($checkQuery);

if ($stmt) {
    $stmt->bind_param("si", $department_name, $id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // Department with the same name already exists
        echo "Department name already exists.";
    } else {
        // If the department does not exist, proceed with the update
        $query = "UPDATE department SET department_name = ?, department_desc = ? WHERE department_id = ?";

        $stmt = $db->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ssi", $department_name, $department_desc, $id);

            if ($stmt->execute()) {
                echo 'success';
            } else {
                // Handle execution error
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            // Handle query preparation error for the UPDATE query
            echo "Error preparing UPDATE statement: " . $db->error;
        }
    }
} else {
    // Handle query preparation error for the SELECT query
    echo "Error preparing SELECT statement: " . $db->error;
}

// Close the database connection outside the logic blocks
$db->close();
		



						break;
						case 'visitor':
					
// Check if the 'id' and 'rfid_number' are set
if (isset($_GET['id']) && isset($_POST['rfid_number'])) {
    // Sanitize and validate inputs
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    $rfid_number = filter_var($_POST['rfid_number'], FILTER_SANITIZE_STRING);

    // Validate the RFID number (exactly 10 digits and numeric)
    if (strlen($rfid_number) !== 10 || !ctype_digit($rfid_number)) {
        echo 'RFID number must be exactly 10 digits.';
        return;
    }

    // Check if the ID is valid
    if (!$id) {
        echo 'Invalid ID.';
        return;
    }

    // Prepare a query to check if the RFID number already exists for a different ID
    $checkQuery = "SELECT * FROM visitor WHERE rfid_number = ? AND id != ?";
    if ($checkStmt = $db->prepare($checkQuery)) {
        // Bind the parameters (s = string, i = integer)
        $checkStmt->bind_param('si', $rfid_number, $id);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        // Check if the RFID number already exists for another visitor record
        if ($checkResult->num_rows > 0) {
            echo 'RFID number already exists for another visitor.';
        } else {
            // Prepare the update query
            $updateQuery = "UPDATE visitor SET rfid_number = ? WHERE id = ?";
            if ($updateStmt = $db->prepare($updateQuery)) {
                // Bind parameters for the update query
                $updateStmt->bind_param('si', $rfid_number, $id);

                // Execute the update query and check for success
                if ($updateStmt->execute()) {
                    echo 'RFID number updated successfully.';
                } else {
                    echo 'Error updating RFID number in database. Please try again.';
                }

                // Close the update statement
                $updateStmt->close();
            } else {
                echo 'Error preparing update query.';
            }
        }

        // Close the check statement
        $checkStmt->close();
    } else {
        echo 'Error preparing check query.';
    }
} else {
    echo 'Missing required parameters.';
}

// Close the database connection
$db->close();


											break;
											case 'about':
											
// Check if the form was submitted using POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $logo1 = $_POST['logo1'] ?? '';
    $logo2 = $_POST['logo2'] ?? '';
    
    // Trim logos (sanitize paths)
    $logo1 = trim($logo1, "uploads/");
    $logo2 = trim($logo2, "uploads/");
    
    // Initialize variables for the new logo file names
    $new_logo1 = $logo1;
    $new_logo2 = $logo2;

    // Handle logo1 file upload
    if (isset($_FILES['logo1']) && $_FILES['logo1']['error'] === UPLOAD_ERR_OK) {
        // Validate file type (e.g., only allow image files)
        $fileType = mime_content_type($_FILES['logo1']['tmp_name']);
        if (strpos($fileType, 'image') === false) {
            echo json_encode(["status" => "error", "message" => "Logo1 must be an image file."]);
            exit;
        }

        // Generate a unique file name and move the uploaded file
        $new_logo1 = uniqid('logo1_', true) . '.' . pathinfo($_FILES['logo1']['name'], PATHINFO_EXTENSION);
        $target_dir = "uploads/";
        $target_file = $target_dir . $new_logo1;

        if (move_uploaded_file($_FILES['logo1']['tmp_name'], $target_file)) {
            // Successfully uploaded
        } else {
            echo json_encode(["status" => "error", "message" => "Error uploading Logo1."]);
            exit;
        }
    }

    // Handle logo2 file upload
    if (isset($_FILES['logo2']) && $_FILES['logo2']['error'] === UPLOAD_ERR_OK) {
        // Validate file type (e.g., only allow image files)
        $fileType = mime_content_type($_FILES['logo2']['tmp_name']);
        if (strpos($fileType, 'image') === false) {
            echo json_encode(["status" => "error", "message" => "Logo2 must be an image file."]);
            exit;
        }

        // Generate a unique file name and move the uploaded file
        $new_logo2 = uniqid('logo2_', true) . '.' . pathinfo($_FILES['logo2']['name'], PATHINFO_EXTENSION);
        $target_dir = "uploads/";
        $target_file = $target_dir . $new_logo2;

        if (move_uploaded_file($_FILES['logo2']['tmp_name'], $target_file)) {
            // Successfully uploaded
        } else {
            echo json_encode(["status" => "error", "message" => "Error uploading Logo2."]);
            exit;
        }
    }

    // Use prepared statements to prevent SQL injection
    $query = "UPDATE about SET 
              name = ?, 
              address = ?, 
              logo1 = ?, 
              logo2 = ? 
              WHERE id = 1";

    if ($stmt = $db->prepare($query)) {
        // Bind the parameters (s = string)
        $stmt->bind_param("ssss", $name, $address, $new_logo1, $new_logo2);

        // Execute the query and check for success
        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error updating database."]);
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Error preparing query."]);
    }
}

// Close the database connection
$db->close();
																break;
																case 'role':
																	
																
																	if (isset($_GET['id']) && isset($_POST['role'])) {
																		// Get the parameters from the GET and POST request
																		$id = $_GET['id'];
																		$role = $_POST['role'];
																	
																		// Validate the 'role' field to ensure it's not empty
																		if (empty($role)) {
																			echo 'Role cannot be empty.';
																			exit;
																		}
																	
																		// Check if the role already exists (excluding the current one being updated)
																		$check_query = "SELECT COUNT(*) FROM role WHERE role = ? AND id != ?";
																		if ($stmt_check = $db->prepare($check_query)) {
																			// Bind parameters for 'role' and 'id'
																			$stmt_check->bind_param('si', $role, $id);
																	
																			// Execute the check query
																			$stmt_check->execute();
																			$stmt_check->bind_result($count);
																			$stmt_check->fetch();
																	
																			// If the role already exists
																			if ($count > 0) {
																				echo 'Role already exists.';
																			} else {
																				// Prepare the update query
																				$query = "UPDATE role SET role = ? WHERE id = ?";
																				if ($stmt = $db->prepare($query)) {
																					// Bind parameters for 'role' and 'id'
																					$stmt->bind_param('si', $role, $id);
																	
																					// Execute the update query and check for success
																					if ($stmt->execute()) {
																						echo 'Success';
																					} else {
																						echo 'Error in updating database: ' . $stmt->error;
																					}
																	
																					// Close the update statement
																					$stmt->close();
																				} else {
																					echo 'Error preparing update query: ' . $db->error;
																				}
																			}
																	
																			// Close the check statement
																			$stmt_check->close();
																		} else {
																			echo 'Error preparing check query: ' . $db->error;
																		}
																	}
																	
																	

																					break;
																					case 'room':// Get the ID from the URL
																						if (isset($_GET['id']) && isset($_POST['roomname']) && isset($_POST['roomdpt']) && isset($_POST['roomdesc']) && isset($_POST['roomrole']) && isset($_POST['roompass'])) {
																							// Get the POST data
																							$id = $_GET['id'];
																							$room = $_POST['roomname'];
																							$department = $_POST['roomdpt'];
																							$descr = $_POST['roomdesc'];
																							$role = $_POST['roomrole'];
																							$password = password_hash($_POST['roompass'], PASSWORD_DEFAULT); // Hash password
																						
																							// Check if the room and department already exist
																							$checkQuery = "SELECT COUNT(*) FROM rooms WHERE room = ? AND department = ? AND id != ?";
																						
																							// Initialize a prepared statement for the SELECT query
																							if ($stmt = $db->prepare($checkQuery)) {
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
																									echo "Room already exists in the same department.";
																								} else {
																									// Proceed with the UPDATE query if no duplicates are found
																									$updateQuery = "UPDATE rooms SET room = ?, department = ?, descr = ?, authorized_personnel = ?, password = ? WHERE id = ?";
																						
																									// Initialize a prepared statement for the UPDATE query
																									if ($stmt = $db->prepare($updateQuery)) {
																										// Bind parameters to the query (s = string, i = integer)
																										$stmt->bind_param("sssssi", $room, $department, $descr, $role, $password, $id);
																						
																										// Execute the update query
																										if ($stmt->execute()) {
																											echo 'success';
																										} else {
																											// Handle execution error
																											echo "Error executing update query: " . $stmt->error;
																										}
																						
																										// Close the statement
																										$stmt->close();
																									} else {
																										// Handle query preparation error for the UPDATE query
																										echo "Error preparing update statement: " . $db->error;
																									}
																								}
																							} else {
																								// Handle query preparation error for the SELECT query
																								echo "Error preparing SELECT statement: " . $db->error;
																							}
																						
																							// Close the database connection (optional, as it's good practice)
																							$db->close();
																						} else {
																							echo 'Required data missing.';
																						}			

break;
																					
																
}
?>	
	
