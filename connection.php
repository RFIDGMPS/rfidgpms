 <?php
 date_default_timezone_set('Asia/Manila');
 $db = mysqli_connect('127.0.0.1', 'u510162695_gatepassdb', '1Gatepassdb') or
        die ('Unable to connect. Check your connection parameters.');
        mysqli_select_db($db, 'u510162695_gatepassdb' ) or die(mysqli_error($db));
?>