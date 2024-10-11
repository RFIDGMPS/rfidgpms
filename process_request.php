<?php
// Check if form has been submitted

    // Include the database connection
    include 'connection.php';

    // Get the ID from the hidden input
    $id = $_POST['id'];

    // Handle the uploaded photo
    $data_uri = $_POST['capturedImage'];

    if($id == null){
        echo 'Please choose personnel';
        exit;
    }



    // Validate the data URI format
    if (preg_match('/^data:image\/(?<type>.+);base64,(?<data>.+)$/', $data_uri, $matches)) {
        $encodedData = $matches['data'];
        $decodedData = base64_decode($encodedData);
    } else {
        echo 'Please capture verification photo'; // Change to echo for error response
        exit;
    }

    // Create a unique name for the image
    $imageName = uniqid() . '.jpeg';
    $filePath = 'admin/uploads/' . $imageName;

    // Get the current date and time
    $date_requested = date('Y-m-d H:i:s');

    // Check if the uploads directory exists and is writable
    if (!is_dir('admin/uploads')) {
        mkdir('admin/uploads', 0777, true); // Create the directory if it doesn't exist
    }

    // Attempt to save the image and insert into the database
    if (file_put_contents($filePath, $decodedData) !== false) {
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $db->prepare("INSERT INTO lostcard (personnel_id, date_requested, verification_photo, status) VALUES (?, ?, ?, ?)");
        $status = 0; // Set the status
        $stmt->bind_param('issi', $id, $date_requested, $imageName, $status);
        
        // Execute the query and check for success
        if ($stmt->execute()) {
            echo "success"; // Return success response
        } else {
            echo 'Error in updating Database: ' . $stmt->error; // Change to echo for error response
        }
        
        // Close the statement
        $stmt->close();
    } else {
        echo 'Error saving the image.'; // Change to echo for error response
    }

    

?>
