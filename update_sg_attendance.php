<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $ID = $_POST["ID"];
    $AttendanceType = $_POST["AttendanceType"];
    $AttendanceTime = $_POST["AttendanceTime"];
    $InputType = $_POST["InputType"];

    // Include database configuration
    include_once 'inc/config.php';

    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Prepare update query
    $sql = "UPDATE CamsBiometricAttendance SET 
            AttendanceType = '$AttendanceType', 
            AttendanceTime = '$AttendanceTime', 
            InputType = '$InputType' 
            WHERE ID = '$ID'";

    // Execute the update query
    if ($con->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $con->error;
    }

    // Close connection
    $con->close();
}
?>
