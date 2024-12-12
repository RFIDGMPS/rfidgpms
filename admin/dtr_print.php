<!DOCTYPE html>
<html>
<?php
session_start();

  
include 'auth.php'; // Include session validation
?>
<?php
//include 'header.php';
?>

<body style="text-align:center;" onload="window.print()">
<?php
// Include the database connection
$personnel = [];
$query = '';
$id = $_SESSION['id'];
$name = $_SESSION['name'];
$month = $_SESSION['month'];
include '../connection.php';

// // Validate the ID (ensure it’s numeric)
// if (!$id || !is_numeric($id)) {
//     die("Invalid personnel ID.");
// }

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

// Check if personnel data is available
// if (empty($personnel)) {
//     echo "No personnel found for the given ID.";
//     exit;
// }

// Get current date, month, and year
$currentMonth = date('m'); // Current month
$currentYear = date('Y'); // Current year
$month1 = date('m', strtotime($month)); 
// Initialize the array to store the data for each day
$daysData = [];

// SQL query to fetch all logs for the current month and personnel ID
$sql = "SELECT date_logged, time_in_am, time_out_am, time_in_pm, time_out_pm 
        FROM personell_logs 
        WHERE MONTH(date_logged) = ? AND YEAR(date_logged) = ? AND personnel_id = ?";

// Prepare statement
$stmt = $db->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $db->error);
}

// Bind parameters (current month, current year, and personnel ID)
$stmt->bind_param("iii", $month1, $currentYear, $id);

// Execute the statement
if (!$stmt->execute()) {
    die("Error executing query: " . $stmt->error);
}

// Get the result
$result = $stmt->get_result();

// Process the fetched records
while ($row = $result->fetch_assoc()) {
    // Extract the day from date_logged
    $day = (int)date('d', strtotime($row['date_logged']));

    // Assign default values for null fields
    if ($row['time_in_am'] != '?' && $row['time_in_am'] != null) {
        $row['time_in_am'] = '08:00 AM';
    }
    if ($row['time_out_am'] != '?' && $row['time_out_am'] != null) {
        $row['time_out_am'] = '12:00 PM';
    }
    if ($row['time_in_pm'] != '?' && $row['time_in_pm'] != null) {
        $row['time_in_pm'] = '01:00 PM';
    }
    if ($row['time_out_pm'] != '?' && $row['time_out_pm'] != null) {
        $row['time_out_pm'] = '05:00 PM';
    }

    // Store the record in the corresponding day
    $daysData[$day] = $row;
}

// Close the statement
$stmt->close();

// Close the database connection
$db->close();
?>

    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
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

        .header h5 {
            font-size: 10px;
            text-align: left;
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
            /* margin-bottom: 20px; */
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

        /* Adjust the table layout to two columns */
        @media print {
            /* Reduce the overall page size */
            body {
                margin: 0;
                padding: 0;
                font-size: 10px;
            }

            .container {
                width: 100%;
                max-width: 100%;
                margin: 0;
                padding: 10px;
                box-sizing: border-box;
                font-size: 10px;
            }

            /* Ensure table fits within page */
            table {
                width: 100%;
                page-break-inside: avoid;
            }

            th, td {
                font-size: 10px;
                padding: 4px;
            }

            .footer {
                margin-top: 15px;
                font-size: 12px;
            }

            /* Adjust the page size */
            @page {
                size: 8.5in 11in;
                margin: 0.25in;
            }

            /* Styling for two-column layout */
            .table-wrapper {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
            }

            .table-wrapper .table-column {
                flex: 1;
                min-width: 300px;
            }
        }
    </style>

    <div class="table-wrapper">
        <!-- First Column (Container Copy) -->
        <div class="table-column">
            <div class="container" id="container">
                <div class="header">
                    <h5>Civil Service Form No. 48</h5>
                    <h4>DAILY TIME RECORD</h4>
                    <?php if (!empty($name)): ?>
                        <h1><?php echo htmlspecialchars($name); ?></h1>
                    <?php else: ?>
                        <p>(Name)</p>
                    <?php endif; ?>
                </div>

                <table class="info-table">
                    <tr>
                        <th>For the month of</th>
                        <td>  <?php if (!empty($name)): ?>
                        <?php echo htmlspecialchars($month); ?>
                    <?php else: ?>
                        <p>(Month)</p>
                    <?php endif; ?></td>
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

                <!-- Add more content for the table here -->
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
            </div>
            <div class="footer">
                <p><strong>Prepared by:</strong> (Signature over printed name)</p>
                <p>Approved by:</p>
                <div class="in-charge">
                    <p>____________________</p>
                    <p><strong>In-Charge</strong></p>
                </div>
            </div>
        </div>

        <!-- Second Column -->
        <div class="table-column">
        <div class="container" id="container">
        <div class="header">
                    <h5>Civil Service Form No. 48</h5>
                    <h4>DAILY TIME RECORD</h4>
                    <?php if (!empty($name)): ?>
                        <h1><?php echo htmlspecialchars($name); ?></h1>
                    <?php else: ?>
                        <p>(Name)</p>
                    <?php endif; ?>
                </div>

                <table class="info-table">
                    <tr>
                        <th>For the month of</th>
                        <td>  <?php if (!empty($name)): ?>
                        <?php echo htmlspecialchars($month); ?>
                    <?php else: ?>
                        <p>(Month)</p>
                    <?php endif; ?></td>
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

                <!-- Add more content for the table here -->
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
            </div>
            <div class="footer">
                <p><strong>Prepared by:</strong> (Signature over printed name)</p>
                <p>Approved by:</p>
                <div class="in-charge">
                    <p>____________________</p>
                    <p><strong>In-Charge</strong></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
