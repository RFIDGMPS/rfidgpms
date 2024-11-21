
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
    <h1>Visitor Entrance Log Monitoring Report</h1>
    <br>
    <div class="table-responsive">
                                <table class="table table-border" id="">

                                    <thead>

                                        <tr>
                                        <th>Photo</th>
                                        <th>Full Name</th>
                                   
                                        <th>Address</th>
                                     
                                   
                                        <th>Time In</th>
                                        <th>Time Out</th>
                                        <th>Log Date</th>
                                        <th>Purpose</th>
                                        </tr>
                                    </thead>
                                    <tbody id="load_data">
                                    <?php
                     

                            // Check if filtered data is in session
                            if (isset($_SESSION['filtered_data'])) {
                                foreach ($_SESSION['filtered_data'] as $row) {
                                    echo '<tr>';
                                    echo '<td><center><img src="uploads/' . $row['photo'] . '" width="50px" height="50px"></center></td>';
                                    echo '<td>' . $row['name'] . '</td>';
                               
                                    echo '<td>' . $row['address'] . '</td>';
                                  
                            
                                    echo '<td>' . $row['time_in'] . '</td>';
                                    echo '<td>' . $row['time_out'] . '</td>';
                                    echo '<td>' . $row['date_logged'] . '</td>';
                                    echo '<td>' . $row['purpose'] . '</td>';
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






