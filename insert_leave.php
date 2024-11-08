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

// Prepare and bind SQL statement
$stmt = $conn->prepare("INSERT INTO leaves (work_location,empname, leavetype, leavetype2, `from`, `to`, desg, status, status2, reason, empph, empemail) 
                        VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssissss", $work_location, $empname, $leavetype, $leavetype2, $from, $to, $desg, $status, $status2, $reason, $empph, $empemail);

// Assign POST data to variables
$work_location = $_POST['work_location'];
$empname = $_POST['empname'];
$leavetype = $_POST['leavetype'];
$leavetype2 = isset($_POST['leavetype2']) ? $_POST['leavetype2'] : 0;
$from = (isset($_POST['from']) && !empty($_POST['from'])) ? $_POST['from'] : (isset($_POST['from1']) ? $_POST['from1'] : null);
$to = (isset($_POST['to']) && !empty($_POST['to'])) ? $_POST['to'] : (isset($_POST['to2']) ? $_POST['to2'] : null);
$desg = $_POST['desg'];
$status = $_POST['status'];
$status2 = isset($_POST['status2']) ? $_POST['status2'] : 0;
$reason = $_POST['reason'];
$empph = $_POST['empph'];
$empemail = $_POST['empemail'];

// Execute the prepared statement
if ($stmt->execute()) {
    echo "Done!";
} else {
    echo "Error updating record: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
