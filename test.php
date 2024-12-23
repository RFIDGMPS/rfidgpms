
<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include 'connection.php';

$sql = "
INSERT INTO rooms (department, room, `desc`, authorized_personnel, password) VALUES
('BSIT', 'ComLab3', 'Computer Laboratory 3', 'Instructor', 'bsitcomlab3'),
('BSIT', 'ComLab4', 'Computer Laboratory 4', 'Instructor', 'bsitcomlab4'),
('BSIT', 'NetLab3', 'Networking Laboratory 3', 'Instructor', 'bsitnetlab3'),
('BSIT', 'ResearchLab', 'Research Laboratory', 'Instructor', 'bsitresearchlab'),
('BSIT', 'AI_Lab', 'Artificial Intelligence Lab', 'Instructor', 'bsitailab'),
('BSCS', 'CSLab3', 'Computer Science Laboratory 3', 'Instructor', 'bscscomlab3'),
('BSCS', 'SoftEngLab', 'Software Engineering Lab', 'Instructor', 'bscssoftenglab'),
('BSCS', 'GraphicsLab', 'Graphics and Visualization Lab', 'Instructor', 'bscsgraphicslab'),
('BSCS', 'TheoryRoom', 'Theory of Computation Room', 'Instructor', 'bscstheoryroom'),
('BSCS', 'DatabaseLab', 'Database Systems Laboratory', 'Instructor', 'bscsdatabaselab'),
('BSBA', 'EcoLab', 'Economics Laboratory', 'Instructor', 'bsbaecolab'),
('BSBA', 'EntreRoom', 'Entrepreneurship Room', 'Instructor', 'bsbaentreroom'),
('BSBA', 'HRRoom', 'Human Resources Room', 'Instructor', 'bsbahrroom'),
('BSBA', 'SalesLab', 'Sales and Marketing Laboratory', 'Instructor', 'bsbasaleslab'),
('BSBA', 'ConfRoom', 'Conference Room', 'Instructor', 'bsbaconfroom'),
('BSHRM', 'DiningLab2', 'Advanced Dining Laboratory', 'Instructor', 'bshrmdininglab2'),
('BSHRM', 'BakingLab', 'Baking Laboratory', 'Instructor', 'bshrmbakinglab'),
('BSHRM', 'HospitalityRoom', 'Hospitality Room', 'Instructor', 'bshrmhospitality'),
('BSHRM', 'LaundryLab', 'Laundry Training Laboratory', 'Instructor', 'bshrmlaundrylab'),
('BSHRM', 'EventRoom', 'Event Management Room', 'Instructor', 'bshrmeventroom'),
('BSN', 'PediatricsLab', 'Pediatrics Laboratory', 'Instructor', 'bsnpediatricslab'),
('BSN', 'ERLab', 'Emergency Room Simulation', 'Instructor', 'bsnerlab'),
('BSN', 'OBLab', 'Obstetrics Laboratory', 'Instructor', 'bsnoblab'),
('BSN', 'ICURoom', 'Intensive Care Unit Simulation', 'Instructor', 'bsnicuroom'),
('BSN', 'PharmaLab', 'Pharmaceutical Laboratory', 'Instructor', 'bsnpharmalab'),
('BSME', 'FluidLab', 'Fluid Mechanics Laboratory', 'Instructor', 'bsmefluidlab'),
('BSME', 'CADLab', 'CAD Design Laboratory', 'Instructor', 'bsmecadlab'),
('BSME', 'MaterialsLab', 'Materials Science Laboratory', 'Instructor', 'bsmematerialslab'),
('BSME', 'WeldingLab', 'Welding Laboratory', 'Instructor', 'bsmeweldinglab'),
('BSME', 'ThermalLab', 'Thermal Engineering Laboratory', 'Instructor', 'bsmethermallab'),
('BSEE', 'ControlsLab', 'Controls Engineering Laboratory', 'Instructor', 'bseecontrolslab'),
('BSEE', 'RenewableLab', 'Renewable Energy Laboratory', 'Instructor', 'bseerenewablelab'),
('BSEE', 'RoboticsLab', 'Robotics Laboratory', 'Instructor', 'bseeroboticslab'),
('BSEE', 'SignalLab', 'Signal Processing Lab', 'Instructor', 'bseesignallab'),
('BSEE', 'CircuitDesignLab', 'Advanced Circuit Design Laboratory', 'Instructor', 'bseecircuitdesignlab'),
('BSCE', 'TransportLab', 'Transportation Engineering Laboratory', 'Instructor', 'bsctransportlab'),
('BSCE', 'HydraulicsLab', 'Hydraulics Engineering Lab', 'Instructor', 'bscehydraulicslab'),
('BSCE', 'ConcreteLab', 'Concrete Testing Laboratory', 'Instructor', 'bsceconcretelab'),
('BSCE', 'EnviroLab', 'Environmental Engineering Lab', 'Instructor', 'bsceenvirolab'),
('BSCE', 'SurveyRoom', 'Surveying Room', 'Instructor', 'bscesurveyroom'),
('BSARCH', 'UrbanLab', 'Urban Design Lab', 'Instructor', 'bsarchurbanlab'),
('BSARCH', 'GreenLab', 'Green Architecture Lab', 'Instructor', 'bsarchgreenlab'),
('BSARCH', 'HistoryRoom', 'Architectural History Room', 'Instructor', 'bsarchhistory'),
('BSARCH', 'LightLab', 'Lighting Design Laboratory', 'Instructor', 'bsarchlightlab'),
('BSARCH', 'InteriorRoom', 'Interior Design Room', 'Instructor', 'bsarchinterior'),
('BEED', 'TechRoom', 'Technology in Education Room', 'Instructor', 'beedtechroom'),
('BEED', 'ScienceLab', 'Science Teaching Lab', 'Instructor', 'beedsciencelab'),
('BEED', 'ArtsRoom', 'Art in Education Room', 'Instructor', 'beedartsroom'),
('BEED', 'LangLab', 'Language Teaching Lab', 'Instructor', 'beedlanglab'),
('BEED', 'MathRoom', 'Mathematics Teaching Room', 'Instructor', 'beedmathroom');
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
