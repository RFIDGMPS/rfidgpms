
<!DOCTYPE html>
<html>
<?php
include 'auth.php'; // Include session validation
?>
<?php
    
include 'header.php';
?>

<body style="text-align:center;" onload="window.print()">
    <img src="uploads/header.png"/>
    <br><br>
    <h1>Campus Entrance Log Monitoring Report</h1>
    <br>
    <div class="table-responsive">
                                <table class="table table-border" id="">

                                    <thead>

                                        <tr>
                                        <th>Photo</th>
                                        <th>Full Name</th>
                                        <th>Department</th>
                                        <th>Location</th>
                                        <th>Role</th>
                                        <th>Time In</th>
                                        <th>Time Out</th>
                                        <th>Log Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="load_data">
                                    <?php
                     

                            // Check if filtered data is in session
                            if (isset($_SESSION['filtered_data'])) {
                                foreach ($_SESSION['filtered_data'] as $row) {
                                    echo '<tr>';
                                    echo '<td><center><img src="uploads/' . $row['photo'] . '" width="50px" height="50px"></center></td>';
                                    echo '<td>' . $row['first_name'] . ' ' .  $row['last_name'] .'</td>';
                                    echo '<td>' . $row['department'] . '</td>';
                                    echo '<td>' . $row['location'] . '</td>';
                                    echo '<td>' . $row['role'] . '</td>';
                                    echo '<td>' . $row['time_in'] . '</td>';
                                    echo '<td>' . $row['time_out'] . '</td>';
                                    echo '<td>' . $row['date_logged'] . '</td>';
                                    echo '</tr>';
                                }
                            } 

                            // Clear session data after printing
                            unset($_SESSION['filtered_data']);
                            ?>

                                    </tbody>
                                </table>
                            </div>
</body>
</html>






