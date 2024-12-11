<?php
	require_once '../connection.php';

	switch ($_GET['type'])
{
    case 'personell':
       
		// $db->query("DELETE FROM `personell` WHERE `id` = '$_REQUEST[id]'") or die(mysqli_error($db));
		// echo'<script type="text/javascript">
		// 		alert("Successfully Deleted.");
		// 		window.location = "personell";
		// 	</script>	';

        $deleted=1;

// SQL query to update the personell record
$query = "UPDATE personell SET 
    deleted = '$deleted' WHERE id = '$_REQUEST[id]'";

$result = mysqli_query($db, $query);

// Prepare the response
if ($result) {
    echo'<script type="text/javascript">
			alert("Successfully Deleted.");
			window.location = "personell";
			</script>	';
} 

    break;
    case 'department':
	
// Get the department ID from the request
$department_id = $_REQUEST['id'];


// Prepare a DELETE query with a placeholder
$query = "DELETE FROM `department` WHERE `department_id` = ?";

// Initialize a prepared statement
$stmt = $db->prepare($query);

if ($stmt) {
    // Bind the department_id parameter (i = integer)
    $stmt->bind_param("i", $department_id);

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

// Close the database connection
$db->close();


        break;
		case 'visitor':
			if (isset($_REQUEST['id'])) {
                // Prepare the DELETE query
                $query = "DELETE FROM visitor WHERE id = ?";
                $stmt = $db->prepare($query);
            
                // Bind the `id` parameter
                $stmt->bind_param('i', $_REQUEST['id']);
            
                // Execute the query and check for success
                if ($stmt->execute()) {
                    echo 'success';
                } else {
                    echo 'Error in deleting record: ' . $stmt->error;
                }
            
                // Close the statement
                $stmt->close();
            }
            
			break;
			case 'role':
			
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];

    // Prepare the DELETE query
    $query = "DELETE FROM `role` WHERE `id` = ?";
    $stmt = $db->prepare($query);

    // Bind the id parameter
    $stmt->bind_param('i', $id);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'Error in deleting from Database: ' . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo 'Error: No ID provided.';
}


				break;
				case 'room':
					// Prepare the statement
$stmt = $db->prepare("DELETE FROM `rooms` WHERE `id` = ?");

// Bind the parameter
$stmt->bind_param("i", $_REQUEST['id']); // Assuming 'id' is an integer

// Execute the statement
if ($stmt->execute()) {
    echo 'success';
} else {
    die('Error: ' . $stmt->error);
}

// Close the statement
$stmt->close();

					break;
}
	?>
	
	