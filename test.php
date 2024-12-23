
<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include 'connection.php';

$sql = "
INSERT INTO rooms (department, room, `desc`, authorized_personnel, password) VALUES
('BSIT', 'ComLab1', 'Computer Laboratory 1', 'Instructor', 'bsitcomlab1'),
('BSIT', 'ComLab2', 'Computer Laboratory 2', 'Instructor', 'bsitcomlab2'),
('BSIT', 'NetLab1', 'Networking Laboratory 1', 'Instructor', 'bsitnetlab1'),
('BSIT', 'NetLab2', 'Networking Laboratory 2', 'Instructor', 'bsitnetlab2'),
('BSIT', 'LectureHall', 'Lecture Hall', 'Instructor', 'bsitlecturehall'),
('BSCS', 'CSLab1', 'Computer Science Laboratory 1', 'Instructor', 'bscscomlab1'),
('BSCS', 'CSLab2', 'Computer Science Laboratory 2', 'Instructor', 'bscscomlab2'),
('BSCS', 'AlgoRoom', 'Algorithms Room', 'Instructor', 'bscsalgo'),
('BSCS', 'LogicLab', 'Logic Laboratory', 'Instructor', 'bscslogiclab'),
('BSCS', 'DataLab', 'Data Structures Laboratory', 'Instructor', 'bscsdatalab'),
('BSBA', 'AccountLab', 'Accounting Laboratory', 'Instructor', 'bsbaaccountlab'),
('BSBA', 'FinanceRoom', 'Finance Room', 'Instructor', 'bsbafinance'),
('BSBA', 'ManagementRoom', 'Management Room', 'Instructor', 'bsbamanagement'),
('BSBA', 'MarketingLab', 'Marketing Laboratory', 'Instructor', 'bsbamarketinglab'),
('BSBA', 'BusinessHall', 'Business Hall', 'Instructor', 'bsbabusinesshall'),
('BSHRM', 'KitchenLab1', 'Kitchen Laboratory 1', 'Instructor', 'bshrmlab1'),
('BSHRM', 'KitchenLab2', 'Kitchen Laboratory 2', 'Instructor', 'bshrmlab2'),
('BSHRM', 'FrontOffice', 'Front Office Training Room', 'Instructor', 'bshrmfrontoffice'),
('BSHRM', 'HotelRoom', 'Hotel Room Training Facility', 'Instructor', 'bshrmhotelroom'),
('BSHRM', 'DiningLab', 'Dining Laboratory', 'Instructor', 'bshrmdininglab'),
('BSN', 'NursingLab1', 'Nursing Laboratory 1', 'Instructor', 'bsnnursinglab1'),
('BSN', 'NursingLab2', 'Nursing Laboratory 2', 'Instructor', 'bsnnursinglab2'),
('BSN', 'AnatomyLab', 'Anatomy Laboratory', 'Instructor', 'bsnanatomylab'),
('BSN', 'SimulationRoom', 'Simulation Room', 'Instructor', 'bsnsimulation'),
('BSN', 'HealthHall', 'Health Hall', 'Instructor', 'bsnhealthhall'),
('BSME', 'MechLab1', 'Mechanical Laboratory 1', 'Instructor', 'bsmechlab1'),
('BSME', 'MechLab2', 'Mechanical Laboratory 2', 'Instructor', 'bsmechlab2'),
('BSME', 'ThermoRoom', 'Thermodynamics Room', 'Instructor', 'bsmethermoroom'),
('BSME', 'AutoLab', 'Automotive Laboratory', 'Instructor', 'bsmeautolab'),
('BSME', 'EngHall', 'Engineering Hall', 'Instructor', 'bsmeenghall'),
('BSEE', 'ElecLab1', 'Electrical Laboratory 1', 'Instructor', 'bseeeleclab1'),
('BSEE', 'ElecLab2', 'Electrical Laboratory 2', 'Instructor', 'bseeeleclab2'),
('BSEE', 'CircuitRoom', 'Circuit Design Room', 'Instructor', 'bseecircuit'),
('BSEE', 'PowerLab', 'Power Systems Laboratory', 'Instructor', 'bseepowerlab'),
('BSEE', 'EnergyHall', 'Energy Hall', 'Instructor', 'bseeenergyhall'),
('BSCE', 'CivilLab1', 'Civil Engineering Laboratory 1', 'Instructor', 'bscecivlab1'),
('BSCE', 'CivilLab2', 'Civil Engineering Laboratory 2', 'Instructor', 'bscecivlab2'),
('BSCE', 'StructuralLab', 'Structural Design Laboratory', 'Instructor', 'bscestructlab'),
('BSCE', 'SoilLab', 'Soil Testing Laboratory', 'Instructor', 'bscesoillab'),
('BSCE', 'GeoRoom', 'Geotechnical Room', 'Instructor', 'bscegeoroom'),
('BSARCH', 'DesignStudio1', 'Design Studio 1', 'Instructor', 'bsarchdesign1'),
('BSARCH', 'DesignStudio2', 'Design Studio 2', 'Instructor', 'bsarchdesign2'),
('BSARCH', 'RenderLab', 'Rendering Laboratory', 'Instructor', 'bsarchrender'),
('BSARCH', 'ModelRoom', 'Model Making Room', 'Instructor', 'bsarchmodel'),
('BSARCH', 'ArchHall', 'Architecture Hall', 'Instructor', 'bsarchhall'),
('BEED', 'TeachLab1', 'Teaching Laboratory 1', 'Instructor', 'beedteachlab1'),
('BEED', 'TeachLab2', 'Teaching Laboratory 2', 'Instructor', 'beedteachlab2'),
('BEED', 'EarlyEdRoom', 'Early Education Room', 'Instructor', 'beedearlyed'),
('BEED', 'LitLab', 'Literacy Laboratory', 'Instructor', 'beedlitlab'),
('BEED', 'EdHall', 'Education Hall', 'Instructor', 'beededhall');
";

// Execute the query
if ($db->query($sql) === TRUE) {
    echo "Departments inserted successfully.";
} else {
    echo "Error: " . $db->error;
}

// Close the connection
$db->close();
?>
