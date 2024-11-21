<?php
 include 'connection.php';

if (isset($_POST['query'])) {
    $search = $db->real_escape_string($_POST['query']);
    $sql = "SELECT first_name, last_name FROM personell WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' LIMIT 10";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p>" . $row['first_name'] . " " . $row['last_name'] . "</p>";
        }
    } else {
        echo "<p>No matches found</p>";
    }
}

$db->close();
?>
