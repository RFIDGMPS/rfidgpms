<?php
include 'auth.php'; // Include session validation
?>

<!DOCTYPE html>



<html lang="en">

<?php
include 'header.php';
   ?>
<head> 
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        // Use the PHP generated data
        const weeklyData = <?php
            include '../connection.php';

            // Function to get count of logs for each day
            function getEntrantsCount($db, $tableName) {
                $data = array_fill(0, 7, 0); // Initialize array with 0 values for each day of the week
                for ($i = 0; $i < 7; $i++) {
                    $date = date('Y-m-d', strtotime("last Monday +$i days"));
                    $sql = "SELECT COUNT(*) as count FROM $tableName WHERE date_logged = '$date'";
                    $result = $db->query($sql);
                    if ($result && $row = $result->fetch_assoc()) {
                        $data[$i] = $row['count'];
                    }
                }
                return $data;
            }

            // Fetch data from personell_logs and visitor_logs
            $personellData = getEntrantsCount($db, 'personell_logs');
            $visitorData = getEntrantsCount($db, 'visitor_logs');

            // Sum the entrants from both tables for each day
            $totalData = [];
            for ($i = 0; $i < 7; $i++) {
                $totalData[$i] = $personellData[$i] + $visitorData[$i];
            }

            // Close connection
            $db->close();

            echo json_encode($totalData);
        ?>;
        
        const daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const dataArray = [['Day', 'Entrants']];
        for (let i = 0; i < weeklyData.length; i++) {
            dataArray.push([daysOfWeek[i], weeklyData[i]]);
        }
        const data = google.visualization.arrayToDataTable(dataArray);

        // Set Options
        const options = {
            title: 'Weekly Entrants',
            hAxis: {title: 'Day'},
            vAxis: {title: 'Number of Entrants'},
            legend: 'none'
        };

        // Draw
        const chart = new google.visualization.LineChart(document.getElementById('myChart1'));
        chart.draw(data, options);
    }
</script>



</head>
<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
       Spinner End -->
        <!-- Sidebar Start -->
        <?php
		include 'sidebar.php';
		?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
        <?php
		include 'navbar.php';
		?>

            <!-- Sale & Revenue Start -->
            <?php
include '../connection.php';
$today = date('Y-m-d');

function getCount($db, $query) {
    $result = $db->query($query);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["count"];
    }
    return 0;
}

$entrants_today = getCount($db, "
    SELECT COUNT(*) AS count FROM (
        SELECT id FROM room_logs WHERE date_logged = '$today' AND location='Gate'
        UNION ALL
        SELECT id FROM visitor_logs WHERE date_logged = '$today'
    ) AS combined_logs
");
$visitor = getCount($db, "SELECT COUNT(*) AS count FROM visitor_logs WHERE date_logged = '$today'");
$blocked = getCount($db, "SELECT COUNT(*) AS count FROM personell WHERE status = 'Block'");
$strangers = getCount($db, "SELECT COUNT(*) AS count FROM stranger_logs WHERE last_log = '$today'");
?>

            <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4"
                        onmouseover="showEntrantsLogs()" onmouseout="hideEntrantsLogs()">
                            <i class="fa fa-users fa-3x text-warning"></i>
                            <div class="ms-3">
                                <p class="mb-2">Entrants</p>
                                <h6 class="mb-0"><?php echo $entrants_today; ?></h6>
                            </div>
                        </div>
                        <div id="entrantsLogs" class="stranger-logs" style="display:none; position: absolute;background: white; border: 1px solid #ccc; padding: 10px;border-radius: 5px; z-index: 100;box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-height: 300px;">
       
       <ul class="list-unstyled">
           <?php
           // Fetch the current date
           $currentDate = date('Y-m-d');

           // Fetch stranger logs from the database limited to the current date
           $sql = "
           SELECT 
               p.photo,
               CONCAT(p.first_name, ' ', p.last_name) AS full_name
           FROM personell p
           JOIN personell_logs pl ON pl.personnel_id = p.id
           WHERE pl.date_logged = CURRENT_DATE()
           
           UNION ALL
           
           SELECT 
               vl.photo,
               vl.name AS full_name
           FROM visitor_logs vl
           WHERE vl.date_logged = CURRENT_DATE()
           
           LIMIT 10;
           ";
           
           $result = $db->query($sql);
           if ($result->num_rows > 0) {
               while ($row = $result->fetch_assoc()) {
                   echo '<li class="mb-2 d-flex align-items-center">';
                   echo '<span><img style="border-radius:50%;" src="uploads/' . htmlspecialchars($row["photo"]) . '" width="20px" height="20px"/></span>';
                   echo '<span class="text-muted ms-3"><b>' . htmlspecialchars($row["full_name"]) . '</b></span>';
                   echo '</li>';
               }
           } else {
               echo '<li><p class="text-center">No logs found</p></li>';
           }
           ?>
       </ul>
   </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4"
                        onmouseover="showVisitorLogs()" onmouseout="hideVisitorLogs()">
                        <i class="fa fa-user-plus fa-3x text-warning"></i>
                           
                            <div class="ms-3">
                                <p class="mb-2">Visitors</p>
                                <h6 class="mb-0"><?php echo $visitor; ?></h6>
                            </div>
                        </div>

                        <div id="visitorLogs" class="stranger-logs" style="display:none; position: absolute;background: white; border: 1px solid #ccc; padding: 10px;border-radius: 5px; z-index: 100;box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-height: 300px;">
       
       <ul class="list-unstyled">
           <?php
           // Fetch the current date
           $currentDate = date('Y-m-d');

           // Fetch stranger logs from the database limited to the current date
           $sql = "SELECT photo,name  FROM visitor_logs WHERE DATE(date_logged) = '$currentDate'";
           $result = $db->query($sql);
           if ($result->num_rows > 0) {
               while ($row = $result->fetch_assoc()) {
                   echo '<li class="mb-2 d-flex align-items-center">';
                   echo '<span><img style="border-radius:50%;" src="uploads/' . htmlspecialchars($row["photo"]) . '" width="20px" height="20px"/></span>';
                   echo '<span class="text-muted ms-3"><b>' . htmlspecialchars($row["name"]) . '</b></span>';
                   echo '</li>';
               }
           } else {
               echo '<li><p class="text-center">No logs found</p></li>';
           }
           ?>
       </ul>
   </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4"
                        onmouseover="showBlockLogs()" onmouseout="hideBlockLogs()">
                            <i class="fa fa-ban fa-3x text-warning"></i>
                            <div class="ms-3">
                                <p class="mb-2">Blocked</p>
                                <h6 class="mb-0"><?php echo $blocked; ?></h6>
                            </div>
                        </div>
                        <div id="blockLogs" class="stranger-logs" style="display:none; position: absolute;background: white; border: 1px solid #ccc; padding: 10px;border-radius: 5px; z-index: 100;box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-height: 300px;">
       
        <ul class="list-unstyled">
            <?php
            // Fetch the current date
            $currentDate = date('Y-m-d');

            // Fetch stranger logs from the database limited to the current date
            $sql = "SELECT photo,CONCAT(first_name, ' ', last_name) AS full_name  FROM personell WHERE status='Block'";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<li class="mb-2 d-flex align-items-center">';
                    echo '<span><img style="border-radius:50%;" src="uploads/' . htmlspecialchars($row["photo"]) . '" width="20px" height="20px"/></span>';
                    echo '<span class="text-muted ms-3"><b>' . htmlspecialchars($row["full_name"]) . '</b></span>';
                    echo '</li>';
                }
            } else {
                echo '<li><p class="text-center">No logs found</p></li>';
            }
            ?>
        </ul>
    </div>
                    </div>
                    <!-- Stranger Logs Display -->
                    <div class="col-sm-6 col-xl-3 position-relative">
    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4" 
         onmouseover="showStrangerLogs()" onmouseout="hideStrangerLogs()">
        <i class="fa fa-user-secret fa-3x text-warning"></i>
        <div class="ms-3">
            <p class="mb-2">Strangers</p>
            <h6 class="mb-0"><?php echo $strangers; ?></h6>
        </div>
    </div>
    
    <div id="strangerLogs" class="stranger-logs" style="display: none; position: absolute; top: 100%; left: 0; background: white; border: 1px solid #ccc; border-radius: 5px; padding: 10px; z-index: 100; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-height: 300px;">
       
        <ul class="list-unstyled">
            <?php
            // Fetch the current date
            $currentDate = date('Y-m-d');

            // Fetch stranger logs from the database limited to the current date
            $sql = "SELECT rfid_number, attempts 
            FROM stranger_logs 
            WHERE DATE(last_log) = '$currentDate' 
            LIMIT 10";
    
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<li class="mb-2 d-flex justify-content-between align-items-center">';
             // Right-aligned RFID number
             echo '<span class="ms-auto"><b>' . htmlspecialchars($row["rfid_number"]) . ' : </b></span>'; // ms-auto pushes this to the right
            
                    // Left-aligned attempts
                    echo '<span class="text-muted"> ' . htmlspecialchars($row["attempts"]) . ' attempt/s</span>';
            
                   
                    echo '</li>';
                }
            } else {
                echo '<li><p class="text-center">No logs found</p></li>';
            }
            
            ?>
        </ul>
    </div>
</div>

<style>
    .stranger-logs {
        max-height: 200px; /* Maximum height for the log display */
        overflow: hidden; /* Disable scrolling */
    }
    .stranger-logs .bg-light {
        background-color: #f8f9fa; /* Light background color */
    }
</style>

<script>
function showStrangerLogs() {
    document.getElementById('strangerLogs').style.display = 'block';
}

function hideStrangerLogs() {
    document.getElementById('strangerLogs').style.display = 'none';
}
function showBlockLogs() {
    document.getElementById('blockLogs').style.display = 'block';
}

function hideBlockLogs() {
    document.getElementById('blockLogs').style.display = 'none';
}
function showVisitorLogs() {
    document.getElementById('visitorLogs').style.display = 'block';
}

function hideVisitorLogs() {
    document.getElementById('visitorLogs').style.display = 'none';
}
function showEntrantsLogs() {
    document.getElementById('entrantsLogs').style.display = 'block';
}

function hideEntrantsLogs() {
    document.getElementById('entrantsLogs').style.display = 'none';
}
</script>




                </div>
                <br>
                <div style="margin:0;padding:0;">
    <div class="row">
   
<div style="padding:20px; margin:10px;width:47%;" class="bg-light rounded">
    <div id="myChart" style="width:100%; height:300px;"></div>

    <script>
    google.charts.load('current', {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart2);

    function drawChart2() {
        // Fetch data from the PHP script
        fetch('status.php')
            .then(response => response.json())
            .then(data => {
                // Create DataTable
                const chartData = google.visualization.arrayToDataTable([
                    ['Status', 'Percentage'],
                    ['Arrived', data.arrived],
                    ['Not Arrived', data.not_arrived]
                ]);

                // Set Options
                const options = {
                    title: 'Entrants Status',
                    pieSliceText: 'percentage', // Show percentage on slices
                    slices: {
                        0: { offset: 0.1 }, // Slightly offset the 'Arrived' slice
                    }
                };

                // Draw Chart
                const chart = new google.visualization.PieChart(document.getElementById('myChart'));
                chart.draw(chartData, options);
            })
            .catch(error => console.error('Error fetching data:', error));
    }
    </script>
</div>


<div style="padding:20px; margin:10px;width:47%;" class="bg-light rounded">




<?php


// Fetch department data with counts
$sql = "
    SELECT 
        d.department_name, 
        COUNT(DISTINCT p.id) AS personnel_count, 
        COUNT(DISTINCT r.id) AS room_count
    FROM 
        department d
    LEFT JOIN 
        personell p ON d.department_name = p.department AND p.deleted != 1
    LEFT JOIN 
        rooms r ON d.department_name = r.department
    GROUP BY 
        d.department_id, d.department_name
";


$result = $db->query($sql);
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'department' => $row['department_name'],
            'personnel' => (int)$row['personnel_count'],
            'rooms' => (int)$row['room_count']
        ];
    }
}

$db->close();
?>

<div id="myChart2" style="width:100%; height:300px;"></div>

<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    // Set Data dynamically from PHP
    const data = google.visualization.arrayToDataTable([
        ['Department', 'Personnel', 'Rooms'],
        <?php
        foreach ($data as $row) {
            echo "['" . $row['department'] . "', " . $row['personnel'] . ", " . $row['rooms'] . "],";
        }
        ?>
    ]);


    const options = {
        title: 'Departments: Personnel and Rooms',
        chartArea: {width: '50%'},
        hAxis: {
          title: 'Count'
        },
        vAxis: {
          title: 'Departments'
        }
      };
    // Draw Chart
    const chart = new google.visualization.BarChart(document.getElementById('myChart2'));
    chart.draw(data, options);
}
</script>












</div>
        
        
</div>
                                 </div>
                                 <div class="row">
                                 <div style="padding:20px; margin:10px; width:100%;" class="bg-light rounded">
    <div id="myChart1" style="width:100%; height:300px;"></div>
    </div>
</div>






                <div class="bg-light rounded h-100 p-4 mt-4" >
                    <br>
                    <h2><i class="bi bi-clock"></i> Entrance for today</h2>
                    <hr></hr>
                    <div class="table-responsive">
                    <table class="table table-border" id="myDataTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Photo</th>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Department</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Time In</th>
                                            <th scope="col">Time Out</th>
                                        
                                          

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php include '../connection.php'; ?>
                                 <?php  $results = mysqli_query($db, "

                                  SELECT 
    p.photo,
    p.department,
    p.rfid_number,
    p.role,
    CONCAT(p.first_name, ' ', p.last_name) AS full_name,
    rl.time_in,
    rl.time_out,
    rl.location,
    rl.date_logged
    
FROM room_logs rl
JOIN personell p ON rl.personnel_id = p.id
WHERE rl.date_logged = CURRENT_DATE()

UNION

SELECT 
    vl.photo,
    vl.department,
    vl.rfid_number,
    'Visitor' AS role,
    vl.name AS full_name,
    vl.time_in,
    vl.time_out,
    vl.location,
    vl.date_logged
FROM visitor_logs vl
WHERE vl.date_logged = CURRENT_DATE()

ORDER BY 
    CASE 
        WHEN time_out IS NOT NULL THEN time_out 
        ELSE time_in 
    END DESC
        ");  ?>
                                 <?php 
                                 
                               
                                
                                 
                                 while ($row = mysqli_fetch_array($results)) { 
                                    if($row['time_in'] != null){
                                        $timein=date('h:i A', strtotime($row['time_in']));
                                    }else {
                                        $timein=$row['time_in'];
                                    }

                                    if($row['time_out'] != null){
                                       
                                        $timeout=date('h:i A', strtotime($row['time_out']));
                                    }else {
                                   
                                        $timeout=$row['time_out'];
                                    }
                                    ?>
                                        <tr>
                                            <td>
                                                <center><img src="uploads/<?php echo $row['photo']; ?>" width="50px" height="50px"></center>
                                            </td>
                                            <td><?php echo $row['full_name']; ?></td>
                                            <td><?php echo $row['department']; ?></td>
                                            <td><?php echo $row['role']; ?></td>
                                            <td><?php echo $row['location']; ?></td>
                                            <td><?php echo $timein; ?></td>
                                            <td><?php echo $timeout; ?></td>



                                          
                                           
                                        </tr>
                                        <?php } ?>
                                   
                                      
                                      
                                    </tbody>
                                </table>
                    </div>
                </div>
            </div>


            <?php
include 'footer.php';
			?>
        </div>
        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-warning btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>