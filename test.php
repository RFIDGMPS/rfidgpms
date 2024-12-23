
<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include 'connection.php';

// SQL query to insert departments
$sql = "
INSERT INTO department (department_name, department_desc) VALUES
('BSCS', 'Bachelor of Science in Computer Science'),
('BSHRM', 'Bachelor of Science in Hotel and Restaurant Management'),
('BSA', 'Bachelor of Science in Accountancy'),
('BEED', 'Bachelor of Elementary Education'),
('BSED', 'Bachelor of Secondary Education'),
('BSN', 'Bachelor of Science in Nursing'),
('BSP', 'Bachelor of Science in Psychology'),
('BSBIO', 'Bachelor of Science in Biology'),
('BSCHE', 'Bachelor of Science in Chemistry'),
('BSEE', 'Bachelor of Science in Electrical Engineering'),
('BSCE', 'Bachelor of Science in Civil Engineering'),
('BSME', 'Bachelor of Science in Mechanical Engineering'),
('BSARCH', 'Bachelor of Science in Architecture'),
('BSPHYS', 'Bachelor of Science in Physics'),
('BSMATH', 'Bachelor of Science in Mathematics'),
('ABENG', 'Bachelor of Arts in English'),
('ABCOMM', 'Bachelor of Arts in Communication'),
('ABPOLSCI', 'Bachelor of Arts in Political Science'),
('ABPSY', 'Bachelor of Arts in Psychology'),
('BSAGRI', 'Bachelor of Science in Agriculture'),
('BSAENG', 'Bachelor of Science in Agricultural Engineering'),
('BSFORE', 'Bachelor of Science in Forestry'),
('BSFT', 'Bachelor of Science in Food Technology'),
('BSMAR', 'Bachelor of Science in Marine Biology'),
('BSED-ENG', 'Bachelor of Secondary Education Major in English'),
('BSED-MATH', 'Bachelor of Secondary Education Major in Mathematics'),
('BSED-SCI', 'Bachelor of Secondary Education Major in Science'),
('BSED-SS', 'Bachelor of Secondary Education Major in Social Studies'),
('BSCOE', 'Bachelor of Science in Computer Engineering'),
('BSIT-ECE', 'Bachelor of Science in Electronics and Communication Engineering'),
('BSM', 'Bachelor of Science in Management'),
('BSTM', 'Bachelor of Science in Tourism Management'),
('BSED-PE', 'Bachelor of Secondary Education Major in Physical Education'),
('BSED-FIL', 'Bachelor of Secondary Education Major in Filipino'),
('BSEN', 'Bachelor of Science in Environmental Science'),
('BS-STAT', 'Bachelor of Science in Statistics'),
('BSIS', 'Bachelor of Science in Information Systems'),
('BS-TCM', 'Bachelor of Science in Technical Communications'),
('BSED-MAPEH', 'Bachelor of Secondary Education Major in Music, Arts, PE and Health'),
('BS-PH', 'Bachelor of Science in Public Health'),
('ABFIL', 'Bachelor of Arts in Filipino'),
('BSMMA', 'Bachelor of Science in Multimedia Arts'),
('AB-LIT', 'Bachelor of Arts in Literature'),
('AB-PHI', 'Bachelor of Arts in Philosophy'),
('ABHIST', 'Bachelor of Arts in History'),
('ABTHEO', 'Bachelor of Arts in Theology'),
('ABJS', 'Bachelor of Arts in Journalism'),
('BSBA-HR', 'Bachelor of Science in Business Administration Major in Human Resource'),
('BSBA-FM', 'Bachelor of Science in Business Administration Major in Financial Management'),
('BSBA-MM', 'Bachelor of Science in Business Administration Major in Marketing Management'),
('BSECE', 'Bachelor of Science in Electronics and Communications Engineering'),
('BSIE', 'Bachelor of Science in Industrial Engineering'),
('BSF', 'Bachelor of Science in Fisheries'),
('BSNUT', 'Bachelor of Science in Nutrition'),
('BSOT', 'Bachelor of Science in Occupational Therapy'),
('BSMLT', 'Bachelor of Science in Medical Laboratory Technology'),
('BSPT', 'Bachelor of Science in Physical Therapy'),
('BSRAD', 'Bachelor of Science in Radiologic Technology'),
('BSDS', 'Bachelor of Science in Dental Surgery'),
('BSPH', 'Bachelor of Science in Pharmacy'),
('BSMID', 'Bachelor of Science in Midwifery'),
('BSMARE', 'Bachelor of Science in Maritime Engineering'),
('ABREL', 'Bachelor of Arts in Religious Studies'),
('BSHRIM', 'Bachelor of Science in Hospitality and Restaurant and Institution Management'),
('BSCP', 'Bachelor of Science in Criminology and Police Administration'),
('BSMATH-AP', 'Bachelor of Science in Mathematics Major in Applied Mathematics'),
('BSF-CF', 'Bachelor of Science in Forestry Major in Conservation Forestry'),
('BS-LIT', 'Bachelor of Science in Literature'),
('BSRES', 'Bachelor of Science in Renewable Energy Systems'),
('BSOS', 'Bachelor of Science in Ocean Studies'),
('BSAE', 'Bachelor of Science in Aeronautical Engineering'),
('BSFASHION', 'Bachelor of Science in Fashion and Design'),
('BSFNB', 'Bachelor of Science in Food and Nutrition Biotechnology'),
('BSCD', 'Bachelor of Science in Community Development'),
('BS-JD', 'Bachelor of Science in Justice Development'),
('BSAI', 'Bachelor of Science in Artificial Intelligence'),
('BSCEG', 'Bachelor of Science in Civil Engineering and Geoinformatics'),
('BSCSAI', 'Bachelor of Science in Computer Science with Artificial Intelligence'),
('BSIB', 'Bachelor of Science in International Business'),
('BSFMM', 'Bachelor of Science in Fisheries and Marine Management'),
('BSED-ARTS', 'Bachelor of Secondary Education Major in Arts'),
('BSWD', 'Bachelor of Science in Web Development'),
('BSGAME', 'Bachelor of Science in Game Development'),
('BSSE', 'Bachelor of Science in Software Engineering'),
('BSAI-ROBOTICS', 'Bachelor of Science in Artificial Intelligence and Robotics'),
('BSCS-NET', 'Bachelor of Science in Computer Science Major in Networking'),
('BSCS-SEC', 'Bachelor of Science in Computer Science Major in Cybersecurity'),
('BSCYBERLAW', 'Bachelor of Science in Cyber Law'),
('BSDS-ENT', 'Bachelor of Science in Data Science and Entrepreneurship');
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
