<!DOCTYPE html>
<html>
<?php
include 'auth.php'; // Include session validation
?>
<?php
include 'header.php';
?>

<body style="text-align:center;" onload="window.print()">
<?php
// Include the database connection
$personnel = [];
$query = '';
$id = $_SESSION['id'];
include '../connection.php';

// Validate the ID (ensure it’s numeric)
if (!$id || !is_numeric($id)) {
    die("Invalid personnel ID.");
}

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
if (empty($personnel)) {
    echo "No personnel found for the given ID.";
    exit;
}

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
                size: 8.5in 13in;
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
                    <?php if (!empty($personnel)): ?>
                        <h1><?php echo htmlspecialchars($personnel['first_name'] . ' ' . $personnel['last_name']); ?></h1>
                    <?php else: ?>
                        <p>No personnel found.</p>
                    <?php endif; ?>
                </div>

                <table class="info-table">
                    <tr>
                        <th>For the month of</th>
                        <td><?php echo $currentMonthName; ?></td>
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
                            <th>Date</th>
                            <th>AM In</th>
                            <th>AM Out</th>
                            <th>PM In</th>
                            <th>PM Out</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($daysData as $day => $data): ?>
                            <tr>
                                <td><?php echo sprintf('%02d', $day); ?></td>
                                <td><?php echo $data['time_in_am']; ?></td>
                                <td><?php echo $data['time_out_am']; ?></td>
                                <td><?php echo $data['time_in_pm']; ?></td>
                                <td><?php echo $data['time_out_pm']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
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
            
        </div>
    </div>
</body>
</html>
