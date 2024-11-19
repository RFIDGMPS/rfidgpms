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
$id=$_SESSION['id'];
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
  <div class="table-responsive">

<style>
    /* General styles */
    body {
        font-family: Arial, sans-serif;
    }

    .container {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
        box-sizing: border-box;
        page-break-inside: avoid;
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
        text-align:left;
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

    /* Print-specific styles */
    @media print {
        /* Reduce the overall page size */
        body {
            margin: 0;
            padding: 0;
            font-size: 10px; /* Shrink font size for printing */
        }

        .container {
            width: 48%;
            max-width: 48%;
            margin: 0;
            padding: 10px;
            box-sizing: border-box;
            font-size: 10px; /* Adjust the font size */
            display: inline-block;
            vertical-align: top;
        }

        /* Make sure table fits within page */
        table {
            width: 100%;
            margin: 10px;
            page-break-inside: avoid;
        }

        th, td {
            font-size: 10px; /* Shrink font size for tables */
            padding: 4px; /* Reduce padding */
        }

        .footer {
            margin-top: 15px;
            font-size: 12px;
        }

        /* Hide elements that are not needed for printing */
        button, .no-print {
            display: none;
        }
     
        /* Adjust for long size paper (8.5in x 13in) */
        @page {
            size: 8.5in 13in;  /* Set the paper size to long bond paper */
            margin: 0.25in; /* Set minimal margins */
        }
    }

</style>

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
            // Validate if the day exists in the current month
            if (!checkdate($currentMonth, $day, $currentYear)) {
                continue;
            }
            ?>
            <tr>
                <td><?php echo $day; ?></td>
                <td><?php echo !empty($daysData[$day]['time_in_am']) ? convertTo12Hour($daysData[$day]['time_in_am']) : 'N/A'; ?></td>
                <td><?php echo !empty($daysData[$day]['time_out_am']) ? convertTo12Hour($daysData[$day]['time_out_am']) : 'N/A'; ?></td>
                <td><?php echo !empty($daysData[$day]['time_in_pm']) ? convertTo12Hour($daysData[$day]['time_in_pm']) : 'N/A'; ?></td>
                <td><?php echo !empty($daysData[$day]['time_out_pm']) ? convertTo12Hour($daysData[$day]['time_out_pm']) : 'N/A'; ?></td>
                <td></td>
                <td></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Duplicate the container div -->
<div class="container" id="container">
    <!-- Repeat the same structure for the second container, adjust content as necessary -->
</div>

</body>
</html>
