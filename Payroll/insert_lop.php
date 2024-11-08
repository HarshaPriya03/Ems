<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ems";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input data
$empname = array_map(array($conn, 'real_escape_string'), $_POST['empname']);
$lopmonth = array_map(array($conn, 'real_escape_string'), $_POST['lopmonth']);
$worked = array_map(array($conn, 'real_escape_string'), $_POST['worked']);
$leavebal = array_map(array($conn, 'real_escape_string'), $_POST['leavebal']);
$lop = array_map(array($conn, 'real_escape_string'), $_POST['lop']);
$lopadj = array_map(array($conn, 'real_escape_string'), $_POST['lopadj']);
$flop = array_map(array($conn, 'real_escape_string'), $_POST['flop']);
$comment = array_map(array($conn, 'real_escape_string'), $_POST['comment']);

$created = date('Y-m-d H:i:s');

// Prepare SQL statement and insert data for each row
for ($i = 0; $i < count($empname); $i++) {
    $sql = "INSERT INTO payroll_lop (empname, lopmonth,leavebal, lop, worked, lopadj, flop, comment, created) 
            VALUES ('{$empname[$i]}', '{$lopmonth[$i]}', '{$leavebal[$i]}', '{$lop[$i]}', '{$worked[$i]}', '{$lopadj[$i]}', '{$flop[$i]}', '{$comment[$i]}', '$created')";

    // Execute SQL statement
    if ($conn->query($sql) !== TRUE) {
        // Provide feedback for AJAX request
        $response = array("success" => false, "message" => "Error: " . $sql . "<br>" . $conn->error);
        echo json_encode($response);
        exit; // Exit script if an error occurs
    }
}

// Provide feedback for AJAX request if all rows inserted successfully
$response = array("success" => true, "message" => "LOP created successfully!");
echo json_encode($response);

// Close connection
$conn->close();
?>
