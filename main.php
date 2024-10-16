
<?php



session_start();
if (isset($_SESSION['location'])) {
    $location = $_SESSION['location'];
  $department = $_SESSION['department'];
  $descr = $_SESSION['descr'];
}
else {
    header("Location: index.php");
    exit();
}
?>
<?php
include 'connection.php';





$logo1 = "";
    $nameo = "";
    $address = "";
    $logo2 = "";
    
// Fetch data from the about table
$sql = "SELECT * FROM about LIMIT 1";

$result = $db->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
    $logo1 = $row['logo1'];
    $nameo = $row['name'];
    $address = $row['address'];
    $logo2 = $row['logo2'];
} 

// Get current period
$current_period = date('A');


mysqli_close($db);
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/grow_up.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="assets/img/brand/favicon-bar.svg" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="script.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="lostfound.css">
    <script src="lostfound.js" defer></script>
    <title>RFID GPMS</title>
    <style>
        .preview-1 {
            width: 140px!important;
            height: 130px!important;
            position: absolute;
            border: 1px solid gray;
            top: 15%;
            cursor: pointer; /* Add cursor pointer to indicate clickability */
        }
    </style>
        <style type="text/css">

.column {
    flex: 1;
    text-align: center;
}

.column.wide {
    flex: 2; /* Makes this column twice as wide as the others */
}

.column:first-child img,
.column:last-child img {
    max-width: 100%;
    height: auto;
}

.text {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100%;
}

.text .row {
    line-height: 1.5;
    margin-bottom: 5px;
}

.detail {
    appearance: none;
	border: none;
	outline: none;
	border-bottom: .2em solid #084298;
	background: white;
	border-radius: .2em .2em 0 0;
	padding: .4em;
	color: #ced4da;
    margin:13px 0px;
    height:70px;
}

    </style>
</head>

<body onload="startTime()">
<audio id="myAudio" hidden>
    <source src="admin/audio/alert.mp3" type="audio/mpeg">
    Your browser does not support the audio element.
</audio> 
<div id="message"></div>
<nav class="navbar navbar-expand-lg navbar-light py-2" style="height: 1%; border-bottom: 1px solid #FBC257; margin-bottom: 1%; padding: 0px 50px 0px 50px; display: flex; justify-content: center; align-items: center;">
    <div style="text-align: left; margin-right: 10px;">
        <img src="<?php echo 'admin/uploads/'.$logo1; ?>" alt="Image 1" style="height: 100px;">
    </div>
    <div class="column wide" style="flex-grow: 2; text-align: center;">
        <div class="text">
            <h1><div class="row"><b><?php echo $nameo; ?></b></div></h1>
            <h5><i><span style="color:red;">(<?php 
            if($department == 'Main'){
                $descr = 'Gate';
            }
            
            
            echo $department.': '.$descr; ?>)</span></i></h5>
        </div>
    </div>
    <div style="text-align: right; margin-left: 10px;">
        <img src="<?php echo 'admin/uploads/'.$logo2; ?>" alt="Image 2" style="height: 100px;">
    </div>
</nav>







    
    <!-- Section -->
    <section class="hero" style="margin-top: 0%">
        <div class="container">
                <center>
                    <div id="clockdate" style="border: 1px solid #f5af5b;background-color: #f5af5b">
                        <div class="clockdate-wrapper" style="height:100px;">
                            <div id="clock" style="font-weight: bold; color: #fff;font-size: 50px"></div>
                            <div id="date" style="color: #fff"><span id="currentDate"></span></div>
                        </div>
                    </div>
                </center><br><Br>
            <div class="row" style="margin-top:-35px;">
                <div class="col-md-3">
                    <div class="card">
                    <form id="rfidForm" method="POST">
                      <div class="card-body" style="padding-top:0;height:310px;">
                         <p class="card-text">
                          <div id="mgs-add"></div>
                     
    <input type="text" id="rfidcard" name="rfid_number" class="form-control" placeholder="Scan RFID card" autofocus>
    
    <input id="refresh" type="submit" name="submit" value="Submit" hidden>
 


    
    <?php
$rfid_number = '';
$time_in_out = 'Tap Your Card';
$status='';
 
// Check if form is submitted
if (isset($_POST['submit'])) {
    $rfid_number = $_POST['rfid_number'];
    date_default_timezone_set('Asia/Manila');
    $time = date('H:i:s');
    $date_logged = date('Y-m-d');
    $current_period = date('A'); // Get AM/PM period
    
    include 'connection.php';

    // Check if RFID number exists in personell table
    $query = "SELECT * FROM personell WHERE rfid_number = '$rfid_number'";
    $result = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['status'] == 'Block') {





           // echo "<script>alert('This Personnel is Blocked!'); window.location = 'index.php';</script>";
           $time_in_out='BLOCKED';
         
           $voice='Blocked Card!';
           echo "<script>const audio = document.getElementById('myAudio');
        audio.currentTime = 0; // Reset the audio to the start
        audio.play().catch(function(error) {
            console.log('Audio playback failed:', error);
        });
    </script>";
           
        } else {
     // Check if user is already logged today
     if($department == 'Main'){
$query1 = "SELECT * FROM personell_logs WHERE personnel_id = '{$user['id']}' AND date_logged = '$date_logged'";
$result1 = mysqli_query($db, $query1);
$user1 = mysqli_fetch_assoc($result1);

// Get current time period (AM/PM)
$current_period = date('A');

if ($user1) {
    // Update existing log entry
    if ($current_period === "AM") {
        $update_field = ($user1['time_out_am'] == '') ? 'time_out_am' : null;
    } else {
        $update_field = ($user1['time_out_pm'] == '') ? 'time_out_pm' : null;
    }
    
    if ($update_field) {
        $time_in_out = 'TIME OUT';
        $voice = 'Take care ' . $user['first_name'] . ' ' . $user['last_name'] . '!';

        // Update the respective time_out column
        $update_query = "UPDATE personell_logs SET $update_field = '$time' WHERE id = '{$user1['id']}'";
        mysqli_query($db, $update_query);
    } else {
        echo "<script>alert('Please wait for the appropriate time period.');</script>";
    }

} else {
    // Insert new log entry with the correct time_in field
    if ($current_period === "AM") {
        $time_field = 'time_in_am';
        $time_in_out = 'TIME IN';
        $voice = 'Good morning ' . $user['first_name'] . ' ' . $user['last_name'] . '!';
    } else {
        $time_field = 'time_in_pm';
        $time_in_out = 'TIME IN';
        $voice = 'Good afternoon ' . $user['first_name'] . ' ' . $user['last_name'] . '!';
    }

    // Insert into the respective time_in field
    $insert_query = "INSERT INTO personell_logs (personnel_id, $time_field, date_logged, location) 
                     VALUES ('{$user['id']}', '$time', '$date_logged', '$location')";
    mysqli_query($db, $insert_query);
}

        







            // if($department == 'Main'){
            // // Check if user is already logged today
            // $query1 = "SELECT * FROM personell_logs WHERE personnel_id = '{$user['id']}' AND date_logged = '$date_logged'";
            // $result1 = mysqli_query($db, $query1);
            // $user1 = mysqli_fetch_assoc($result1);

            // if ($user1) {
            //     // Update existing log entry
            //     if (($user1['time_out'] == '')) {
            //         //$update_field = $current_period === "AM" ? 'time_out_am' : 'time_out_pm';
            //         $time_in_out = 'TIME OUT';
                   
            //             $voice='Take care '.$user['first_name'].' ' . $user['last_name'].'!';
                        
                    
            //         $update_query = "UPDATE personell_logs SET time_out = '$time' WHERE id = '{$user1['id']}'";
            //         mysqli_query($db, $update_query);
            //     } else {
            //         echo "<script>alert('Please wait for the appropriate time period.');</script>";
            //     }
            // } else {
              
            //     // Insert new log entry
           
            //     $time_in_out = 'TIME IN';
            //     //$time_field = $current_period === "AM" ? 'time_in_am' : 'time_in_pm';
            //     if(date('A') =="AM"){
            //         $voice='Good morning '.$user['first_name'].' ' . $user['last_name'].'!';
                   
            //     } 
            //     if(date('A') =="PM"){
            //         $voice='Good afternoon '.$user['first_name'].' ' . $user['last_name'].'!';
                    
            //     } 
            //     $insert_query = "INSERT INTO personell_logs (personnel_id,time_in, date_logged, location) 
            //                      VALUES ('{$user['id']}','$time', '$date_logged', '$location')";
            //     mysqli_query($db, $insert_query);
                
            // }
        } else {
        // Check if user is already logged today
// Query to get the latest log for the user
$query1 = "SELECT * FROM personell_logs WHERE personnel_id = '{$user['id']}' AND date_logged = '$date_logged' ORDER BY id DESC LIMIT 1";
$result1 = mysqli_query($db, $query1);
$row = mysqli_fetch_assoc($result1);

if ($row) {
    // Check if user's department matches the department
    echo $user['department'];
    echo $department;
    if ($user['department'] == $department) {
        // Check if the last log has no 'time_out' and the location matches
        if (empty($row['time_out']) && $row['location'] == $location) {
            $time_in_out = 'TIME OUT';
          
                $voice='Have a great day '.$user['first_name'].' ' . $user['last_name'].'!';
                
        
            // Update the log with 'time_out'
            $update_query = "UPDATE personell_logs SET time_out = '$time' WHERE id = '{$row['id']}'";
            mysqli_query($db, $update_query);
        } else {
            // If the log is complete or location differs, insert a new log
            $time_in_out = 'TIME IN';
            if(date('A') =="AM"){
                $voice='Good morning '.$user['first_name'].' ' . $user['last_name'].'!';
               
            } 
            if(date('A') =="PM"){
                $voice='Good afternoon '.$user['first_name'].' ' . $user['last_name'].'!';
                
            } 
            $insert_query = "INSERT INTO personell_logs (personnel_id, location, time_in, date_logged) 
                             VALUES ('{$user['id']}', '$location', '$time', '$date_logged')";
            mysqli_query($db, $insert_query);
        }
    } else {
        // If department doesn't match
        $voice = 'You\'re not allowed to enter this room.';
        $time_in_out='UNAUTHORIZE';
        echo "<script>const audio = document.getElementById('myAudio');
        audio.currentTime = 0; // Reset the audio to the start
        audio.play().catch(function(error) {
            console.log('Audio playback failed:', error);
        });
    </script>";
    }
} else {
    // If no previous log exists, insert a new log
   $voice = 'You must log in to main gate first.';
   $time_in_out='UNAUTHORIZE';
}

    }
    }
    }
    else {
        // Check if RFID number exists in visitor table
       

        if($department != 'Main'){
            $voice = 'You\'re not allowed to enter this room.';
            $time_in_out='UNAUTHORIZE';
            echo "<script>const audio = document.getElementById('myAudio');
        audio.currentTime = 0; // Reset the audio to the start
        audio.play().catch(function(error) {
            console.log('Audio playback failed:', error);
        });
    </script>";
        }else{
            $query = "SELECT * FROM visitor WHERE rfid_number = '$rfid_number'";
            $result = mysqli_query($db, $query);
            $visitor = mysqli_fetch_assoc($result);

        if ($visitor) {
            $query1 = "SELECT * FROM visitor_logs WHERE rfid_number = '$rfid_number' AND date_logged = '$date_logged'";
            $result1 = mysqli_query($db, $query1);
            $visitor1 = mysqli_fetch_assoc($result1);
           
            if ($visitor1) {
                
                if ($visitor1['time_out'] == '') {
                    //$update_field = $current_period === "AM" ? 'time_out_am' : 'time_out_pm';
                    $time_in_out = 'TIME OUT';
                  
                        $voice='Thank you for visiting '.$visitor1['name'].'!';
                        
                    
                    $update_query = "UPDATE visitor_logs SET time_out = '$time' WHERE id = '{$visitor1['id']}'";
                    mysqli_query($db, $update_query);
                   
                    
                } else {
                    echo "<script>alert('Please wait for the appropriate time period.');</script>";
                }
            } else {
                echo '<script>$(document).ready(function() {
                    $("#visitorModal").modal("show");
                });</script>';
               
            }
        } else {
         $time_in_out='STRANGER';
            //$voice='Unknown Card!';
            echo "<script>const audio = document.getElementById('myAudio');
        audio.currentTime = 0; // Reset the audio to the start
        audio.play().catch(function(error) {
            console.log('Audio playback failed:', error);
        });</script>";
        $voice='Uknown Card!';
            $insert_query = "INSERT INTO personell_logs (role, rfid_number, time_in, date_logged, photo) 
                             VALUES ('Stranger', '$rfid_number', '$time', '$date_logged', 'stranger.jpg')";
            mysqli_query($db, $insert_query);
        }
    }
    }

    // Close database connection
    mysqli_close($db);
}
?>
<script>
  
  // Get the PHP-generated text
  const text = "<?php echo $voice; ?>";

  // Function to convert text to speech
  const textToSpeech = (text) => {
      const synth = window.speechSynthesis;

      if (!synth.speaking && text) {
          const utterance = new SpeechSynthesisUtterance(text);
          synth.speak(utterance);
      }
  };

  const stopSpeech = () => {
      const synth = window.speechSynthesis;
      if (synth.speaking) {
          synth.cancel(); // Stops any ongoing speech
      }
  };
  // Trigger text-to-speech if there's submitted text
  if (text) {
      textToSpeech(text);
  }

</script>


<div id="rfidDisplay"></div>
<br/>
                          <center style="margin-top:-7px;"><img id="pic" height="220px" class="w-100 entrant" alt="img"  src="assets/img/section//istockphoto-1184670010-612x612.jpg" id="img"></center>
                          <script type="text/javascript">
         $(document).ready(function() {
         
    	$getphoto =  $('.pic').attr('src');
					$('.entrant').attr('src',$getphoto);
                    $getname =  $('.entrant_name').html();
                    $('.display_name').html($getname);  
                    $getrole =  $('.role').html();
                    $('.d_role').html($getrole);  
         });
		 
		 </script>
                          
                        
                      </p>      
                      </div>
                              </form>
                            

                    </div>
                </div>
                <div class="col-md-9">
          
                <div class="alert alert-primary" role="alert" id="alert">
    <center><h3 id="in_out">Tap Your Card</h3></center>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="detail entrant_name" style="margin-top:0px;margin-bottom:0px;color:#ced4da;">
            <h1><center><b id="entrant_name">Name</b></center></h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="detail deprt" style="color:#ced4da;">
            <h1 id="department">Department</h1>
        </div>
        <div class="detail role" style="color:#ced4da;">
            <h1 id="role">Role</h1> 
        </div>
    </div>
    <div class="col-md-6">
        <div class="detail time_in" style="color:#ced4da;">
            <h1 id="time_in">Time in</h1>
        </div>
        <div class="detail time_out" style="color:#ced4da;">
            <h1 id="time_out">Time out</h1>
        </div>
    </div>
</div>      

             
             
        <?php 
        include 'connection.php'; 

        // Combine and fetch data from both tables for the current date, ordering by the latest update
        $results = mysqli_query($db, "
        SELECT 
        p.photo,
        p.department,
        p.role,
        CONCAT(p.first_name, ' ', p.last_name) AS full_name,
        CASE
            WHEN CURRENT_TIME() < '12:00:00' THEN pl.time_in_am
            ELSE pl.time_in_pm
        END AS time_in,
        CASE
            WHEN CURRENT_TIME() < '12:00:00' THEN pl.time_out_am
            ELSE pl.time_out_pm
        END AS time_out,
        pl.date_logged,
        pl.id -- Assuming id is the primary key and auto-increments
    FROM personell_logs pl
    JOIN personell p ON pl.personnel_id = p.id
    WHERE pl.date_logged = CURRENT_DATE()
    
    UNION
    
    SELECT 
        vl.photo,
        vl.department,
        'Visitor' AS role,
        vl.name AS full_name,
        vl.time_in,
        vl.time_out,
        vl.date_logged,
        vl.id -- Assuming id is the primary key in visitor_logs
    FROM visitor_logs vl
    WHERE vl.date_logged = CURRENT_DATE()
    
    ORDER BY 
        id DESC -- Sorting by the most recent id
    LIMIT 1;
    

    ");
    

                           
        // Fetch and display the results
        while ($row = mysqli_fetch_array($results)) {

 if(isset($_POST['submit'])){
    
    $alert='alert-primary';
if($time_in_out=='TIME IN'){
$alert='alert-success';
}
else {
    $alert='alert-danger'; 
}

  
if($time_in_out == 'BLOCKED' || $time_in_out == 'STRANGER' || $time_in_out == 'UNAUTHORIZE'){      
    
    $row['photo']=$row['full_name']=$row['department']=$row['role']=$row['time_in']=$row['time_out'] = '';
}
?>
   
           <script>
             // Store original values
        const originalTexts = {
            in_out: document.getElementById('in_out').innerHTML,
            entrant_name: document.getElementById('entrant_name').innerHTML,
            department: document.getElementById('department').innerHTML,
            role: document.getElementById('role').innerHTML,
            time_in: document.getElementById('time_in').innerHTML,
            time_out: document.getElementById('time_out').innerHTML
        };


        document.getElementById('in_out').innerHTML = '<?php echo $time_in_out;?>';
        document.getElementById('entrant_name').innerHTML = '<?php echo $row['full_name']; ?>';
        document.getElementById('department').innerHTML = '<?php echo $row['department']; ?>';
        document.getElementById('role').innerHTML = '<?php echo $row['role']; ?>';
        document.getElementById('time_in').innerHTML = '<?php echo $row['time_in']; ?>';
        document.getElementById('time_out').innerHTML = '<?php echo $row['time_out']; ?>';
        document.getElementById('entrant_name').style.color = 'black';
        document.getElementById('department').style.color = 'black';
            document.getElementById('role').style.color = 'black';
            document.getElementById('time_in').style.color = 'black';
            document.getElementById('time_out').style.color = 'black';
            document.getElementById('alert').classList.remove('alert-primary');
            document.getElementById('alert').classList.add('<?php echo $alert;?>');
            document.getElementById('pic').src = 'admin/uploads/<?php echo $row['photo']; ?>';
        // Revert text back to original after 3 seconds
        setTimeout(function() {
            document.getElementById('in_out').innerHTML = originalTexts.in_out;
            document.getElementById('entrant_name').innerHTML = originalTexts.entrant_name;
            document.getElementById('department').innerHTML = originalTexts.department;
            document.getElementById('role').innerHTML = originalTexts.role;
            document.getElementById('time_in').innerHTML = originalTexts.time_in;
            document.getElementById('time_out').innerHTML = originalTexts.time_out;
            document.getElementById('entrant_name').style.color = '#ced4da';
            document.getElementById('department').style.color = '#ced4da';
            document.getElementById('role').style.color = '#ced4da';
            document.getElementById('time_in').style.color = '#ced4da';
            document.getElementById('time_out').style.color = '#ced4da';
            document.getElementById('alert').classList.remove('<?php echo $alert;?>');
            document.getElementById('alert').classList.add('alert-primary');
            document.getElementById('pic').src = "assets/img/section/istockphoto-1184670010-612x612.jpg";
        }, 5000); // 3000 milliseconds = 3 seconds
    </script>
<?php 

 }
    }
        
    
        ?>
       
                 
              </div>
            </div>
        </div>

         
    </section>



 <!-- Modal -->
 <form id="myForm" role="form" method="post" enctype="multipart/form-data">
               <div class="modal fade" id="visitorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">
                              <i class="bi bi-plus-circle"></i> Visitor E-Logbook
                           </h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="col-lg-11 mb-2 mt-1" id="mgs-emp" style="margin-left: 4%"></div>
                        <div class="modal-body">
                           <div class="row justify-content-md-center">
                              <div id="msg-emp"></div>
                              <div class="col-sm-12 col-md-12 col-lg-10">
                                 <div class="" style="border: 1PX solid #b3f0fc;padding: 1%;background-color: #f7cfa1;color: black;font-size: 1.2rem">PERSONAL INFORMATION</div>
                                 <?php 
        include 'connection.php'; 

        // Combine and fetch data from both tables for the current date, ordering by the latest update
        $results = mysqli_query($db, "SELECT * FROM visitor WHERE rfid_number = '$rfid_number'"); 
     
        // Fetch and display the results
        while ($row = mysqli_fetch_array($results)) { ?>
                                 <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-12" id="up_img">
                                    <div class="file-uploader">
                                         
                                          <img id="captured" class="preview-1" src="assets/img/pngtree-vector-add-user-icon-png-image_780447.jpg" style="width: 140px!important;height: 130px!important;position: absolute;border: 1px solid gray;top: 15%" title="Upload Photo.." />
                                          
                                       </div>

                                       <input type="hidden" id="capturedImage" name="capturedImage">
                                    </div>
        
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="lnamez">
                                       <div class="form-group">
                                          <label>VISITOR CODE:</label>
                                          <input readonly value="<?php echo $row['v_code']; ?>" required type="text" class="form-control" name="v_code" id="v_code" autocomplete="off">
                                          <span class="id-error"></span>
                                       </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>RFID NUMBER:</label>
                                          <input readonly value="<?php echo $row['rfid_number']; ?>" required type="text" class="form-control" name="rfid_number" id="rfid_number" minlength="10" maxlength="10" autocomplete="off">
                                          <span class="rfidno-error"></span>
                                       </div>
                                    </div>
                                 </div>
                                 <?php }?>
                                 <div class="row mb-3">
                                    <div class="col-lg-3 col-md-6 col-sm-12" id="up_img">
                                      
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="lnamez">
                                    <div class="form-group">
                                          <label>NAME:</label>
                                          <input required type="text" class="form-control" name="fullName" id="fullName" autocomplete="off">
                                       </div>
                                    </div>
                                    <div class="col-lg-5 col-md-6 col-sm-12">
                                    <div class="form-group">
                                          <label>SEX:</label>
                                          <select readonly required class="form-control dept_ID" name="sex" id="sex_id" autocomplete="off">
                                             <option value="">&larr; Select Section &rarr;</option>
                                             <option value="Male">Male</option>
                                             <option value="Female">Female</option>
                                          </select>
                                          <span class="sex-error"></span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row mb-2">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group">
                                          <label>CIVIL STATUS:</label>
                                          <select readonly required class="form-control dept_ID" name="stat" id="stat_id" autocomplete="off">
                                             <option value="">&larr; Select Status &rarr;</option>
                                             <option value="Single">Single</option>
                                             <option value="Married">Married</option>
                                             <option value="Widowed">Widowed</option>
                                          </select>
                                          <span class="stat-error"></span>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group">
                                          <label>DEPARTMENT:</label>
                                          <select readonly required class="form-control dept_ID" name="department" id="dept_id" autocomplete="off">
										  <option value="">&larr; Select Department &rarr;</option>
<?php
										  $sql = "SELECT * FROM department";
$result = $db->query($sql);

// Initialize an array to store department options
$department_options = [];

// Fetch and store department options
while ($row = $result->fetch_assoc()) {
    $department_id = $row['department_id'];
    $department_name = $row['department_name'];
    $department_options[] = "<option value='$department_name'>$department_name</option>";
}?>
                          <?php
    // Output department options
    foreach ($department_options as $option) {
        echo $option;
    }
    ?>            

                                          </select>
                                          <span class="dprt-error"></span>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group">
                                          <label>CONTACT NUMBER:</label>
                                          <input required type="text" class="form-control" name="contact_number" id="contact_number" minlength="11" maxlength="11" autocomplete="off">
                                       </div>
                                    </div>
                                 </div>
                                
                                 <div class="row">
                                    <div class="col-lg-12 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>ADDRESS:</label>
                                          <input required type="text" class="form-control" name="address" id="complete_address" autocomplete="off">
                                          <span class="ca-error"></span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-lg-12 col-md-6 col-sm-12">
                                       <div class="form-group">
                                          <label>PURPOSE OF VISIT:</label>
                                          <textarea style="height:100px;" required type="text" class="form-control" name="purpose" id="purpose" autocomplete="off"></textarea>
                                          <span class="ca-error"></span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                           <!--<button name="vsave" type="submit" id="btn-emp" class="btn btn-outline-warning">Save</button>-->
                           <input name="vsave" type="submit" id="btn-emp" class="btn btn-outline-warning" value="Save">
                        </div>
                     </div>
                  </div>
               </div>
               <?php
          
            if (isset($_POST['capturedImage'])) {
                        











                        $v_code = $_POST['v_code'];
                        $rfid_number = $_POST['rfid_number'];
                        date_default_timezone_set('Asia/Manila'); // Set your timezone
                        $time = date('H:i:s'); // Current time
                        $name = $_POST['fullName'];
                        $department = $_POST['department'];
                        $sex = $_POST['sex'];
                        $civil_status = $_POST['stat'];
                        $contact_number = $_POST['contact_number'];
                        $address = $_POST['address'];
                        $purpose = $_POST['purpose'];
                       
                       
                        $date_logged = date('Y-m-d'); // Current date as date_logged
                       
                        // Determine appropriate time field to update
                       
                        $update_field = null;
            
        
                                $data_uri = $_POST['capturedImage'];
                                $encodedData = str_replace(' ', '+', $data_uri);
                                list($type, $encodedData) = explode(';', $encodedData);
                                list(, $encodedData) = explode(',', $encodedData);
                                $decodedData = base64_decode($encodedData);
                        
                                $imageName = $_POST['fullName'] . '.jpeg';
                                $filePath = 'admin/uploads/' . $imageName;
                        
                                $current_period=date('A');
        
         //$time_field = $current_period === "AM" ? 'time_in_am' : 'time_in_pm';
        
        
        
        
                                if (file_put_contents($filePath, $decodedData)) {
                                    // Insert query for entrance table
                                    $insert_query = "INSERT INTO visitor_logs (photo, v_code, name, rfid_number,  time_in, date_logged, department, sex,civil_status,contact_number,address,purpose,role) 
                                    VALUES ('$imageName','$v_code', '$name', '$rfid_number', '$time', '$date_logged', '$department', '$sex','$civil_status','$contact_number','$address','$purpose','Visitor')";
                    
                           
                        
                       
                                    // Execute query
                                    if (mysqli_query($db, $insert_query)) {
                                        
 if(isset($_POST['vsave'])){
    $time_in_out='TIME IN';
                        
$voice='Welcome '.$name.'!';
    $alert='alert-primary';
if($time_in_out=='TIME IN'){
$alert='alert-success';
}
else {
    $alert='alert-danger'; 
}



  
?>
  
           <script>
             // Store original values
        let originalTexts1 = {
            in_out: document.getElementById('in_out').innerHTML,
            entrant_name: document.getElementById('entrant_name').innerHTML,
            department: document.getElementById('department').innerHTML,
            role: document.getElementById('role').innerHTML,
            time_in: document.getElementById('time_in').innerHTML,
            time_out: document.getElementById('time_out').innerHTML
        };

        // Change text to 'Hello World'
        document.getElementById('in_out').innerHTML = '<?php echo $time_in_out;?>';
        document.getElementById('entrant_name').innerHTML = '<?php echo $name; ?>';
        document.getElementById('department').innerHTML = '<?php echo $department; ?>';
        document.getElementById('role').innerHTML = 'Visitor';
        document.getElementById('time_in').innerHTML = '<?php echo $time; ?>';
        document.getElementById('time_out').innerHTML = '';
        document.getElementById('entrant_name').style.color = 'black';
        document.getElementById('department').style.color = 'black';
            document.getElementById('role').style.color = 'black';
            document.getElementById('time_in').style.color = 'black';
            document.getElementById('time_out').style.color = 'black';
            document.getElementById('alert').classList.remove('alert-primary');
            document.getElementById('alert').classList.add('<?php echo $alert;?>');
            document.getElementById('pic').src = 'admin/uploads/<?php echo $imageName; ?>';
        // Revert text back to original after 3 seconds
        setTimeout(function() {
            document.getElementById('in_out').innerHTML = originalTexts1.in_out;
            document.getElementById('entrant_name').innerHTML = originalTexts1.entrant_name;
            document.getElementById('department').innerHTML = originalTexts1.department;
            document.getElementById('role').innerHTML = originalTexts1.role;
            document.getElementById('time_in').innerHTML = originalTexts1.time_in;
            document.getElementById('time_out').innerHTML = originalTexts1.time_out;
            document.getElementById('entrant_name').style.color = '#ced4da';
            document.getElementById('department').style.color = '#ced4da';
            document.getElementById('role').style.color = '#ced4da';
            document.getElementById('time_in').style.color = '#ced4da';
            document.getElementById('time_out').style.color = '#ced4da';
            document.getElementById('alert').classList.remove('<?php echo $alert;?>');
            document.getElementById('alert').classList.add('alert-primary');
            document.getElementById('pic').src = "assets/img/section/istockphoto-1184670010-612x612.jpg";
        }, 5000); // 3000 milliseconds = 3 seconds
    </script>
<?php 

    
    }
    
                                    } else {
                                        echo "Error updating record: " . mysqli_error($db);
                                    }
                                } else {
                                    echo 'Error saving image.';
                                }
                            }
                        
        
?>    

 <script>
  
  // Get the PHP-generated text
  const text1 = "<?php echo $voice; ?>";

  // Function to convert text to speech
  const textToSpeech1 = (text1) => {
      const synth1 = window.speechSynthesis;

      if (!synth1.speaking && text1) {
          const utterance1 = new SpeechSynthesisUtterance(text1);
          synth1.speak(utterance1);
      }
  };

  // Trigger text-to-speech if there's submitted text
  if (text1) {
      textToSpeech1(text1);
  }

</script>
            </form>
        
            <div class="modal fade" id="cameraModal" tabindex="-1" role="dialog" aria-labelledby="cameraModalLabel" aria-hidden="true">
                                                   <div class="modal-dialog" role="document">
                                                      <div class="modal-content">
                                                         <div class="modal-header">
                                                            <h5 class="modal-title" id="cameraModalLabel">Capture Photo</h5>
                                                            
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                  
                                                               </button>
                                                         </div>
                                                          <div class="modal-body" id="my_camera">
                  .
                                                               </div>
                                                            <div class="modal-footer">
                                                           
                                                                 <button onclick="saveSnap()" type="button" class="btn btn-primary" id="captureButton">Capture</button>
                                                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                  </div>
                                                                        </div>
                                                    </div>
                                    </div>

                                    <div id="results" style="visibility:hidden;position:absolute;"></div>
                                     
                                     <script>
            $(document).ready(function() {
            $('.preview-1').click(function() {
                // Show the modal
                $('#cameraModal').modal('show');

            });

           
        });

       
    </script>
                                    <script type="text/javascript" src="admin/assets/webcam.min.js"></script>
<script>

$(document).ready(function() {
            // Initialize Webcam.js
            Webcam.set({
width:460,
height:400,
image_format: 'jpeg',
jpeg_quality: 90
});
Webcam.attach('#my_camera');
            });
       

   

function saveSnap(){

Webcam.snap(function(data_uri){

   $('.preview-1').attr('src', data_uri); // Update preview image src
   document.getElementById('capturedImage').value = data_uri;
   
   $('#cameraModal').modal('hide');
   
});

}


</script>


  <!-- end Section -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
     
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
       <script type="text/javascript">
            function readURL(input) {
            	if (input.files && input.files[0]) {
            		var reader = new FileReader();
            		reader.onload = function(e) {
            			var num = $(input).attr('class').split('-')[2];
            			$('.file-uploader .preview-' + num).attr('src', e.target.result);
            		}
            		reader.readAsDataURL(input.files[0]);
            	}
            }
            $("[class^=upload-field-]").change(function() {
            	readURL(this);
            });
         </script>

<button class="mute" onclick="stopSpeech()" style="background:#FBC257;">
    <span class="material-symbols-rounded"><i class="fa fa-volume-up" aria-hidden="true"></i></span>
    <span class="material-symbols-outlined"><i class="fa fa-volume-mute" aria-hidden="true"></i></span>
</button>
         <?php
         if($department == 'Main') { ?>
        <button class="chatbot-toggler" style="background:#FBC257;">
    <span class="material-symbols-rounded"><i class="fa fa-id-badge" aria-hidden="true"></i></span>
    <span class="material-symbols-outlined"><i class="fa fa-times" aria-hidden="true"></i></span>
</button>
<style>
        .card {
            display: flex;
            align-items: center; /* Aligns items vertically center */
            padding: 10px;
            margin: 10px 0; /* Space between cards */
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff; /* Card background color */
            position: relative; /* For absolute positioning of the button */
            text-align:center;
        }
      
        .close-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            cursor: pointer;
            font-size: 18px;
            color: black;
            border-radius: 50%; /* Makes the image circular */
            border: none;
            padding: 5px 8px;
        }
    </style>
<div class="chatbot">
    <header style="background:#FBC257;">
      <h2>Lost Card</h2>
      <span class="close-btn material-symbols-outlined"><i class="fa fa-times" aria-hidden="true"></i></span>
    </header>
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-12">
                <div class="rounded p-4" id="adjust">
                
                    <input type="hidden" name="id" id="hiddenId"> <!-- Hidden input for ID -->
                        <div class="">
                            <center><span id="myalert2"></span></center>
                        </div>
                        <div id="myalert" style="display:none;">
                            <div class="">
                                <center><span id="alerttext"></span></center>
                            </div>
                        </div>
                        <div id="myalert3" style="display:none;">
                            <div class="">
                                <div class="alert alert-success" id="alerttext3"></div>
                            </div>
                        </div>
                        
                        <!-- Search Box -->
                        <div id="search" class="form-floating mb-4">
                            <input type="text" class="form-control" id="searchBox" name="pname" placeholder="Search Name" autocomplete="off" onkeyup="searchPersonell(this.value)">
                            <label for="floatingPassword">Search Name</label>
                        </div>
                        <!-- Card to display selected personnel -->
                        <div class="card" id="detailsModal" style="display:none;background-color:#e9ecef;">
    <span class="close-btn" onclick="closeModal()">×</span>
    
    <table style="margin-left: 30px; padding: 0px; margin-bottom: 0px; border: none;" class='table table-border' id='myTable'>
        <tr style="vertical-align:middle;">
            <!-- First column: Photo -->
            <td style="border-bottom-width:0px;"><img id="modalPhoto" src="" width='50' height='50'></td>
            <!-- Second column: Name and Department (stacked) -->
            <td style="text-align:left;border-bottom-width:0px;">
                <div id="modalTitle" style="font-weight: bold;"></div> <!-- Bold Name -->
                <div id="modalDepartment" style="opacity: 0.6;"></div> <!-- Department with less opacity -->
               
            </td>
        </tr>
    </table>
</div>
<div id="cam" style="display:none;position:fixed;" class="file-uploader">
                                         
                                         <img id="captured" class="preview-1" src="assets/img/pngtree-vector-add-user-icon-png-image_780447.jpg" style="width: 140px!important;height: 130px!important;position: absolute;border: 1px solid gray;top: 15%; left:200px;" title="Upload Photo.." />
                                         <center><b>Capture Verification: </b></center>
                                      </div>

                                      <input hidden id="capturedImage" name="capturedImage">
                                     
                                    </div>


                        
                        <!-- Live Search Results -->
                        <div id="searchResults"></div>
        
                        
                        <button name="send" id="submitButton" class="alert alert-primary py-3 w-100 mb-4"><b>Send</b></button>

                </div>
            </div>
        </div>
    </div>
    <div class="chat-input" hidden>
      <textarea placeholder="Enter a message..." spellcheck="false" hidden></textarea>
      <span id="send-btn" class="material-symbols-rounded" hidden>send</span>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$('#submitButton').click(function(){
var id =  document.getElementById('hiddenId').value;
var capturedImage =  document.getElementById('capturedImage').value;

    $.ajax({
                type: "POST",
                url: "process_request.php",
                data:{id:id, capturedImage:capturedImage},
                dataType: 'text',
                success: function(data){
                    if (data.trim() == 'success') {
                        Swal.fire({
                icon: 'success',
                title: 'Your request has been sent',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = 'main.php'; // Redirect after 1.5 seconds
            });
                    } else {
                        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: data
        });
                    }
                }
});

});




</script>



<script>
    function removeCard(button) {
        // Get the card element to remove
        const card = button.parentNode;
        // Remove the card from the DOM
        card.style.display = 'none'; // Hide the card instead of removing it
        

    }
</script>

<!-- Add JavaScript for Search Functionality -->
<script>
    function searchPersonell(query) {
        if (query.length === 0) {
            document.getElementById("searchResults").innerHTML = "";
            return;
        }
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("searchResults").innerHTML = xhr.responseText;
            }
        };
        xhr.open("GET", "search_personnel.php?q=" + query, true);
        xhr.send();
    }
</script>



<script>
function showDetails(id, fullName, department, photo) {
    document.getElementById('modalTitle').innerText = fullName;
    document.getElementById('modalDepartment').innerText = department;
    document.getElementById('modalPhoto').src = 'admin/uploads/' + photo;

    // Set the hidden input field value
    document.getElementById('hiddenId').value = id;

    // Show the modal
    document.getElementById('detailsModal').style.display = 'flex';
    document.getElementById('search').style.display = 'none';
    document.getElementById('searchResults').style.display = 'none';
    document.getElementById('cam').style.display = 'block';
    document.getElementById('adjust').style.height = '300px';
}

function closeModal() {
    document.getElementById('detailsModal').style.display = 'none';
    document.getElementById('search').style.display = 'block';
    document.getElementById('searchResults').style.display = 'block';
    document.getElementById('searchResults').style.paddingTop = '50px';
    document.getElementById('cam').style.display = 'none';
    document.getElementById('adjust').style.height = '0px';
    document.getElementById('hiddenId').value = '';
}
</script>




<?php }?>

</body>

</html>