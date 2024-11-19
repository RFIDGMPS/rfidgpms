<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['photo'])) {
        $file = $_FILES['photo'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB in bytes
        $allowedTypes = ['image/jpeg', 'image/png'];

        // Check if there was an upload error
        if ($file['error'] !== UPLOAD_ERR_OK) {
            die(json_encode(['success' => false, 'message' => 'File upload error.']));
        }

        // Check file type
        if (!in_array($file['type'], $allowedTypes)) {
            die(json_encode(['success' => false, 'message' => 'Invalid file format. Only JPG and PNG are allowed.']));
        }

        // Check file size
        if ($file['size'] > $maxFileSize) {
            die(json_encode(['success' => false, 'message' => 'File is too large. Maximum size is 2MB.']));
        }

        // Generate a secure file name and move the file to the upload directory
        $uploadDir = 'uploads/';
        $fileName = uniqid('img_', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

        if (!move_uploaded_file($file['tmp_name'], $uploadDir . $fileName)) {
            die(json_encode(['success' => false, 'message' => 'Failed to save file.']));
        }

        // Success
        echo json_encode(['success' => true, 'message' => 'File uploaded successfully!', 'file' => $fileName]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No file uploaded.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
