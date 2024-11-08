<?php
// update_employee.php

// Replace these database connection details with your actual credentials
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

// Retrieve data from the AJAX request
$UserId= $_POST['userId'];
$AttendanceTime= $_POST['time'];
$AttendanceType= $_POST['checkIn'];
$InputType= $_POST['Type'];
$option= $_POST['option'];
$addoption= $_POST['addoption'];
$ServiceTagId= $_POST['ServiceTagId'];
$posted = date('Y-m-d H:i:s');

$sql = "INSERT INTO CamsBiometricAttendance_GGM (UserID, AttendanceTime, AttendanceType, InputType,option,addoption,posted,ServiceTagId) 
        VALUES ('$UserId', '$AttendanceTime', '$AttendanceType', '$InputType', '$option', '$addoption', '$posted','$ServiceTagId')";

if ($conn->query($sql) === TRUE) {
    echo "Done !";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
