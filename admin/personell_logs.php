
<?php
include 'auth.php'; // Include session validation
?>
<?php


include 'header.php';

// Initialize database connection
include '../connection.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Convert posted dates to yyyy-mm-dd format
    $date1 = date('Y-m-d', strtotime($_POST['date1']));
    $date2 = date('Y-m-d', strtotime($_POST['date2']));

    // SQL query to fetch filtered data
    $sql = "SELECT p.first_name, p.last_name, p.department, p.role, p.photo, rl.location, rl.time_in, rl.time_out, rl.date_logged 
        FROM personell AS p
        JOIN room_logs AS rl ON p.id = rl.personnel_id
        WHERE rl.date_logged BETWEEN '$date1' AND '$date2'  ORDER BY rl.date_logged DESC";
    $result = mysqli_query($db, $sql);

    // Check if query was successful
    if ($result) {
        // Initialize array to store filtered data
        $filtered_data = [];

        // Fetch data row by row
        while ($row = mysqli_fetch_assoc($result)) {
            $filtered_data[] = $row; // Store row in array
        }

        // Store filtered data in session
        $_SESSION['filtered_data'] = $filtered_data;
    } else {
        echo "Error: " . mysqli_error($db);
    }
}
else {
// Fetch all records from the database if no filtering is applied
$sql = "SELECT p.first_name, p.last_name, p.department, p.role, p.photo, rl.location, rl.time_in, rl.time_out, rl.date_logged 
        FROM personell AS p
        JOIN room_logs AS rl ON p.id = rl.personnel_id ORDER BY rl.date_logged  DESC";
$result = mysqli_query($db, $sql);
if ($result) {
    // Initialize array to store filtered data
    $filtered_data = [];

    // Fetch data row by row
    while ($row = mysqli_fetch_assoc($result)) {
        $filtered_data[] = $row; // Store row in array
    }

    // Store filtered data in session
    $_SESSION['filtered_data'] = $filtered_data;
} else {
    echo "Error: " . mysqli_error($db);
}
}
// Close database connection
mysqli_close($db);
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'header.php'; ?>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <?php include 'sidebar.php'; ?>
        
        <div class="content">
        <?php
		include 'navbar.php';
		?>

            <div class="container-fluid pt-4 px-4">
                <div class="col-sm-12 col-xl-12">
                    <div class="bg-light rounded h-100 p-4">
                        <div class="row">
                            <div class="col-9">
                                <h6 class="mb-4">Generate Report</h6>
                            </div>
                        </div>
                        <br>
                        <form id="filterForm" method="POST">
                        <div class="row">


                        

        <div class="col-lg-3">
            <label>Date:</label>
            <input type="text" class="form-control" name="date1" placeholder="Start" id="date1" autocomplete="off" />
        </div>
        <div class="col-lg-3">
            <label>To</label>
            <input type="text" class="form-control" name="date2" placeholder="End" id="date2" autocomplete="off" />
        </div>
        <div class="col-lg-3 mt-4">
            <label></label>
            <button type="submit" class="btn btn-primary" id="btn_search"><i class="fa fa-search"></i> Filter</button>
            <button type="button" id="reset" class="btn btn-warning"><i class="fa fa-sync"></i> Reset</button>
        </div>


                            <div class="col-lg-3 mt-4" style="text-align:right;">
                                <label></label>
                                <button type="button" class="btn btn-success" id="btn_print"><i class="fa fa-print"> Print</i></button> 
            
                            </div></form>
                        </div>
                        <hr>
                        <div class="table-responsive">
                        <table class="table table-border" id="dataTable">
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
    include '../connection.php';

    // Check if date1 and date2 are set (for initial load they might not be set)
    if (isset($_POST['date1']) && isset($_POST['date2'])) {
        // Convert posted dates to yyyy-mm-dd format
        $date1 = date('Y-m-d', strtotime($_POST['date1']));
        $date2 = date('Y-m-d', strtotime($_POST['date2']));

        // SQL query to fetch filtered data
        $sql = "SELECT p.first_name, p.last_name, p.department, p.role, p.photo, rl.location, rl.time_in, rl.time_out, rl.date_logged 
        FROM personell AS p
        JOIN room_logs AS rl ON p.id = rl.personnel_id
        WHERE rl.date_logged BETWEEN '$date1' AND '$date2'  ORDER BY rl.date_logged DESC";
        $result = mysqli_query($db, $sql);

        // Check if query was successful
        if ($result) {
            // Start generating HTML output
            $output = '';

            // Fetch data row by row
            while ($row = mysqli_fetch_array($result)) {
                $output .= '<tr>';
                $output .= '<td><center><img src="uploads/' . $row['photo'] . '" width="50px" height="50px"></center></td>';
                $output .= '<td>' . $row['first_name'] . ' ' .  $row['last_name']. '</td>';
                $output .= '<td>' . $row['department'] . '</td>';
                $output .= '<td>' . $row['location'] . '</td>';
                $output .= '<td>' . $row['role'] . '</td>';
                $output .= '<td>' . date("h:i A", strtotime($row['time_in'])) . '</td>';

                if ($row['time_out'] === '?' || $row['time_out'] === '' || is_null($row['time_out'])) {
                    $output .= '<td>' . $row['time_out'] . '</td>'; // Display as is
                } else {
                    $output .= '<td>' . date("h:i A", strtotime($row['time_out'])) . '</td>';
                }
                
                
                
                $output .= '<td>' . $row['date_logged'] . '</td>';
                $output .= '</tr>';
            }

            // Output the generated HTML
            echo $output;
        } else {
            // Error handling if query fails
            echo '<tr><td colspan="9">No records found.</td></tr>';
        }

        // Close database connection
        mysqli_close($db);
    } else {
        // If date1 and date2 are not set, fetch all records
        $results = mysqli_query($db, "SELECT p.first_name, p.last_name, p.department, p.role, p.photo, rl.location, rl.time_in, rl.time_out, rl.date_logged 
        FROM personell AS p
        JOIN room_logs AS rl ON p.id = rl.personnel_id ORDER BY rl.date_logged DESC");

        // Loop through all records and generate HTML output
        while ($row = mysqli_fetch_array($results)) {
            echo '<tr>';
            echo '<td><center><img src="uploads/' . $row['photo'] . '" width="50px" height="50px"></center></td>';
            echo '<td>' . $row['first_name'] . ' ' .  $row['last_name'] .'</td>';
            echo '<td>' . $row['department'] . '</td>';
            echo '<td>' . $row['location'] . '</td>';
            echo '<td>' . $row['role'] . '</td>';
            echo '<td>' . date("h:i A", strtotime($row['time_in']))  . '</td>';
            if ($row['time_out'] === '?' || $row['time_out'] === '' || is_null($row['time_out'])) {
                echo'<td>' . $row['time_out'] . '</td>'; // Display as is
            } else {
                echo'<td>' . date("h:i A", strtotime($row['time_out'])) . '</td>';
            }
            
           
            echo '<td>' . $row['date_logged'] . '</td>';
            echo '</tr>';
        }

        // Close database connection
        mysqli_close($db);
    }
    ?>
</tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php include 'footer.php'; ?>
            
        </div>
    
        <script type="text/javascript">
    $(document).ready(function() {
        $('#date1').datepicker();
        $('#date2').datepicker();
        
        $('#btn_search').on('click', function() {
            if ($('#date1').val() == "" || $('#date2').val() == "") {
                alert("Please enter Date 'From' and 'To' before submit");
            } else {
                $date1 = $('#date1').val();
                $date2 = $('#date2').val();
                $('#load_data').empty();
                $loader = $('<tr ><td colspan = "6"><center>Searching....</center></td></tr>');
                $loader.appendTo('#load_data');
                setTimeout(function() {
                    $loader.remove();
                    $.ajax({
                        url: '../config/init/report_attendance.php',
                        type: 'POST',
                        data: {
                            date1: $date1,
                            date2: $date2
                        },
                        success: function(res) {
                            $('#load_data').html(res);
                        }
                    });
                }, 1000);
            }
        });

        $('#reset').on('click', function() {
            location.reload();
        });

        $('#btn_print').on('click', function() {
           
                // Load print.php content into a hidden iframe
                var iframe = $('<iframe>', {
                    id: 'printFrame',
                    style: 'visibility:hidden; display:none'
                }).appendTo('body');

                // Set iframe source to print.php
                iframe.attr('src', 'print.php');

                // Wait for iframe to load
                iframe.on('load', function() {
                    // Call print function of the iframe content
                    this.contentWindow.print();

                    // Remove the iframe after printing
                    setTimeout(function() {
                        iframe.remove();
                    }, 1000); // Adjust time as needed for printing to complete
                });
            
        });
    });
</script>


        <script>
            $(function() {
                $("#date1").datepicker();
            });
        </script>
        <script>
            $(function() {
                $("#date2").datepicker();
            });
        </script>


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


     
    </div>
</body>
</html>
