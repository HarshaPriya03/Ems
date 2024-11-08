<?php

// Establish a connection to the database
$mysqli = new mysqli("localhost", "Anika12", "Anika12", "ems");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Fetch the last stored employee ID from the database
$result = $mysqli->query("SELECT emp_no FROM emp ORDER BY emp_no DESC LIMIT 1");

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastEmployeeID = $row['emp_no'];
} else {
    // If no records are found, initialize with a default value
    $lastEmployeeID = 'ASPL0000'; // You may adjust this default value as needed
}

// Close the database connection
$mysqli->close();

// Return the last employee ID to the JavaScript
echo $lastEmployeeID;

?>
