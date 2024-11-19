
<?php

include 'auth.php'; // Include session validation
$personnel = [];
$query = '';
$id=0;
include '../connection.php';
?>
<?php


include 'header.php';

// Initialize database connection


// Initialize variables

// Check if there's a search query
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['query'])) {
    $query = trim($_POST['query']);  // Get the search query and remove leading/trailing spaces

    // SQL query to fetch first_name, last_name, and category, excluding 'Student'
    $sql = "SELECT id,first_name, last_name, category 
            FROM personell 
            WHERE (first_name LIKE ? OR last_name LIKE ?) AND category != 'Student'";

    // Prepare the SQL statement
    $stmt = $db->prepare($sql);

    // Use wildcard to match partial strings
    $searchTerm = "%" . $query . "%";  

    // Bind parameters for both first_name and last_name (searching both fields)
    $stmt->bind_param("ss", $searchTerm, $searchTerm);  // 'ss' because both are strings

    // Execute the query and get the result
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the results into an array
    while ($row = $result->fetch_assoc()) {
        $personnel[] = $row;
    }

    // Close the statement and the database connection
    $stmt->close();
    $db->close();
}


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
 <style>
        .personnel-list {
            list-style-type: none;
            padding: 0;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .personnel-list li {
            padding: 8px;
            cursor: pointer;
        }
        .personnel-list li:hover {
            background-color: #f0f0f0;
        }
    </style>
            <div class="container-fluid pt-4 px-4">
                <div class="col-sm-12 col-xl-12">
                    <div class="bg-light rounded h-100 p-4">
                        <div class="row">
                            <div class="col-9">
                                <h6 class="mb-4">Generate DTR</h6>
                            </div>
                        </div>
                        <br>
                        <form id="filterForm" method="POST">
                        <div class="row">

                        <form method="POST" action="">
                        <div class="col-lg-3">
            <label>Search Personnel:</label>
           
                <input required type="text" class="form-control" name="query" autocomplete="off"/>
               
            
        </div>
        <div class="col-lg-3">
            <label>Month:</label>
           
            <select class="form-control" id="months" name="months">
            <option value="" disabled selected><?php echo date('F'); ?></option>
    <option value="1">January</option>
    <option value="2">February</option>
    <option value="3">March</option>
    <option value="4">April</option>
    <option value="5">May</option>
    <option value="6">June</option>
    <option value="7">July</option>
    <option value="8">August</option>
    <option value="9">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
</select>
               
            
        </div>
        <div class="col-lg-3 mt-4">
            <label></label>
            <button type="submit" class="btn btn-primary" id="btn_search"><i class="fa fa-search"></i> Search</button>
          
        </div>
        <div class="col-lg-3 mt-4" style="text-align:right;">
                                <label></label>
                                <button onclick="printDiv('container')" type="button" class="btn btn-success" id="btn_print"><i class="fa fa-print"> Print</i></button> 
                               
                            </div></form>
         <!-- Display Results -->
         <?php if (isset($query) && $query !== ''): ?>
    <?php if (!empty($personnel)): ?>
        <ul class="personnel-list">
            <?php foreach ($personnel as $person): ?>
                <li>
                    <a href="?id=<?= htmlspecialchars($person['id']); ?>">
                        <?= htmlspecialchars($person['first_name']) . ' ' . htmlspecialchars($person['last_name']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

    <?php endif; ?>
<?php endif; ?>



                          </form>
                        </div>
                        <hr>
                        <div class="table-responsive">

    <style>
       
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 20px;
            text-decoration: underline;
        }
        .header h3 {
            margin: 5px 0;
        }
        .info-table {
            width: 100%;
            margin-bottom: 10px;
        }
        .info-table th, .info-table td {
            border: none;
            padding: 5px;
        }
        .info-table th {
            text-align: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        .footer {
            margin-top: 20px;
        }
        .footer p {
            font-size: 14px;
            text-align: justify;
        }
        .footer .in-charge {
            text-align: right;
            margin-top: 30px;
        }
    </style>
<?php
// Include the database connection


// Get the 'id' parameter from the URL
$id = isset($_GET['id']) ? $_GET['id'] : null;
$_SESSION['id'] =$id;


// Query to fetch first_name and last_name for the given personnel ID
$personnel = [];
$sql = "SELECT first_name, last_name 
        FROM personell 
        WHERE id = ?";

// Prepare and execute the query
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the personnel data
if ($row = $result->fetch_assoc()) {
    $personnel = $row; // Store first_name and last_name
}

// Close the statement
$stmt->close();

// Get current date, month, and year
$currentDate = date('Y-m-d');
$currentMonth = date('m');
$currentYear = date('Y');

// Initialize the array to store the data for each day
$daysData = [];

// Loop through all days of the current month (1-31)
for ($day = 1; $day <= 31; $day++) {
    // Validate day number to avoid invalid days for current month
    if (!checkdate($currentMonth, $day, $currentYear)) {
        continue; // Skip invalid days (e.g., 31st in a month with 30 days or February 30th)
    }

    // Format the current day as 'YYYY-MM-DD' for comparison
    $formattedDate = sprintf('%s-%02d-%02d', $currentYear, $currentMonth, $day);

    // SQL query to fetch time data for the current day
    $sql = "SELECT time_in_am, time_out_am, time_in_pm, time_out_pm 
    FROM personell_logs 
    WHERE date_logged = ? AND personnel_id = ?"; // Use prepared statement to avoid SQL injection

// Prepare and execute the query
$stmt = $db->prepare($sql);
$stmt->bind_param("si", $formattedDate, $id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the data if available
$timeData = $result->fetch_assoc(); // Get the fetched data

// Check for null values and assign '?' if they are null


// Set default values if fields are '?' (which means they were originally null)
if ($timeData['time_in_am'] != '?' && $timeData['time_in_am'] != null) {
$timeData['time_in_am'] = '08:00 AM';
}
if ($timeData['time_out_am'] != '?' && $timeData['time_out_am'] != null) {
$timeData['time_out_am'] = '12:00 PM';
}
if ($timeData['time_in_pm'] != '?' && $timeData['time_in_pm'] != null) {
$timeData['time_in_pm'] = '01:00 PM';
}
if ($timeData['time_out_pm'] != '?' && $timeData['time_out_pm'] != null) {
$timeData['time_out_pm'] = '05:00 PM';
}

// Close the statement
$stmt->close();

// Store or use the data for the day
$daysData[$day] = $timeData;

}

// Close the database connection
$db->close();
?>

<div class="container" id="container">
    <div class="header">
        <h5>Civil Service Form No. 48</h5>
        <h4>DAILY TIME RECORD</h4>
        <?php if (!empty($personnel)): ?>
            <h1><?php echo htmlspecialchars($personnel['first_name'] . ' ' . $personnel['last_name']); ?></h1>
        <?php else: ?>
            <p>(Name)</p>
        <?php endif; ?>
    </div>

    <?php
    // Get the current month and year
    $currentMonthName = date('F'); // Full month name (e.g., January, February)
    $currentYear = date('Y');  // Full year (e.g., 2024)
    ?>
<?php
// Function to convert 24-hour time to 12-hour AM/PM time
function convertTo12Hour($time) {
    // Use strtotime to parse the time and convert it to a Unix timestamp
    $timestamp = strtotime($time);
    
    // If strtotime successfully parses the time, format it into 12-hour AM/PM format
    if ($timestamp !== false) {
        return date("g:i A", $timestamp); // Return the time in 12-hour AM/PM format (e.g., 2:30 PM)
    }
    // If the time cannot be parsed, return the original time string
    return $time;
}
?>

    <table class="info-table">
        <tr>
            <th>For the month of</th>
            <td><?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected month from the dropdown
    $selectedMonth = $_POST['months'];

    // Print the selected month
    echo $selectedMonth;
} ?></td>
            <td><?php echo $currentYear; ?></td>
            <td></td>
        </tr>
        <tr>
            <th>Official hours of arrival and departure:</th>
            <td>Regular Days: _______________</td>
            <td>Saturdays: _______________</td>
            <td></td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th rowspan="2">Days</th>
                <th colspan="2">A.M.</th>
                <th colspan="2">P.M.</th>
                <th colspan="2">Undertime</th>
            </tr>
            <tr>
                <th>Arrival</th>
                <th>Departure</th>
                <th>Arrival</th>
                <th>Departure</th>
                <th>Hours</th>
                <th>Minutes</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Loop through all the days of the month (1 to 31)
        for ($day = 1; $day <= 31; $day++) {
            // Check if time data exists for this day
            $timeData = isset($daysData[$day]) ? $daysData[$day] : null;
        
            // Set default values for time_in_am if it's empty or a placeholder
            // if ($timeData && (empty($timeData['time_in_am']) || $timeData['time_in_am'] === '?')) {
            //     $timeData['time_in_am'] = '08:00 AM';
            // }
        
            // Display the row for each day
            echo "<tr>";
            echo "<td>" . $day . "</td>";
            echo "<td>" . (isset($timeData['time_in_am']) ? htmlspecialchars($timeData['time_in_am']) : '') . "</td>";
            echo "<td>" . (isset($timeData['time_out_am']) ? htmlspecialchars($timeData['time_out_am']) : '') . "</td>";
            // Convert PM time to 12-hour AM/PM format before displaying
            echo "<td>" . (isset($timeData['time_in_pm']) ? htmlspecialchars($timeData['time_in_pm']) : '') . "</td>";
            echo "<td>" . (isset($timeData['time_out_pm']) ? htmlspecialchars($timeData['time_out_pm']) : '') . "</td>";
            echo "<td></td>"; // Placeholder for undertime
            echo "<td></td>"; // Placeholder for undertime
            echo "</tr>";
        }
        
        ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <td colspan="6"></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>
            I CERTIFY on my honor that the above is a true and correct report of the hours of work performed, record of which was made daily at the time of arrival and departure from the office.
        </p>
        <div class="in-charge">
            <p>__________________________</p>
            <p>In-Charge</p>
        </div>
    </div>
</div><!-- JavaScript to handle printing -->





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
                iframe.attr('src', 'dtr_print.php');

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
