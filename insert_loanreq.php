<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$empname = $_POST['empname'];
$work_location = $_POST['work_location'];
$loamt = $_POST['loamt'];
$notes = $_POST['notes'];
$created = date('Y-m-d H:i:s');


$sql = "INSERT INTO payroll_loan_req(empname,work_location, loamt, created, notes,status)
 VALUES ('$empname', '$work_location','$loamt', '$created','$notes','0')";

if ($conn->query($sql) === TRUE) {
    echo "Employee Requested Successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
