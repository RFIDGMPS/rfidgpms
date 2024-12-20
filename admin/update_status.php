<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $personnel_id = isset($_POST['personnel_id']) ? intval($_POST['personnel_id']) : 0;

    if ($action === 'block') {
        $lostcard_id = isset($_POST['lostcard_id']) ? intval($_POST['lostcard_id']) : 0;

        // Update the 'lostcard' table status to 1
        $updateLostCard = "UPDATE lostcard SET status = 1 WHERE personnel_id = $personnel_id";
        mysqli_query($db, $updateLostCard);

        // Update the 'personell' table status to 'Block'
        $updatePersonell = "UPDATE personell SET status = 'Block' WHERE id = $personnel_id";
        mysqli_query($db, $updatePersonell);

        if (mysqli_affected_rows($db) > 0) {
            echo "success";
        } else {
            echo "error";
        }
    } elseif ($action === 'delete') {
        // Delete the user from the 'lostcard' table
        $deleteLostCard = "DELETE FROM lostcard WHERE personnel_id = $personnel_id";
        mysqli_query($db, $deleteLostCard);

        if (mysqli_affected_rows($db) > 0) {
            echo "success";
        } else {
            echo "error";
        }
    }
}

$db->close();
?>
