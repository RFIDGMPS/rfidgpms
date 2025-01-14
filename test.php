<?php
include 'connection.php';
// Array of possible roles to choose from
$roles = ['Admin', 'Manager', 'Security', 'Staff', 'Technician', 'Visitor', 'Supervisor', 'Operator', 'Coordinator', 'Clerk', 'Engineer', 'Director', 'Executive', 'Support', 'Leader', 'Assistant', 'Analyst', 'Receptionist', 'Consultant', 'Developer', 'Designer', 'Driver', 'Accountant', 'HR', 'Trainer', 'Instructor', 'Customer Service', 'Sales', 'Marketing', 'Team Lead', 'Project Manager', 'Quality Assurance', 'Team Member', 'Inventory Manager', 'Logistics', 'Dispatcher', 'Warehouse Supervisor', 'Researcher', 'Developer Lead', 'Maintenance', 'IT Specialist', 'Supervisor Lead', 'Security Officer', 'Trainer Lead', 'Purchasing Officer', 'Service Manager', 'Operations Manager', 'Facilities', 'Administrator', 'Client Relations', 'Data Analyst'];

// Loop to insert 95 random roles
for ($i = 0; $i < 95; $i++) {
    // Randomly select a role
    $role = $roles[array_rand($roles)];

    // SQL query to insert data
    $sql = "INSERT INTO role (role) VALUES ('$role')";

    // Execute the query
    if ($db->query($sql) === TRUE) {
        echo "Record $i inserted successfully<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $db->error . "<br>";
    }
}

// Close the connection
$db->close();
?>
