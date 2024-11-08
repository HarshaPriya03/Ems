<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$empname = $_POST['empname'];
$desg = $_POST['desg'];
$dept = $_POST['dept'];
$emp_no = $_POST['emp_no'];
$salarytype = $_POST['salarytype'];
$hra = $_POST['hra'];
$oa = $_POST['oa'];
$epf1 = $_POST['epf1'];
$esi1 = $_POST['esi1'];
$epf2 = $_POST['epf2'];
$esi2 = $_POST['esi2'];
$bp = $_POST['bp'];
$epf3 = $_POST['epf3'];
$netpay = $_POST['netpay'];
$tde = $_POST['tde'];
$tes = $_POST['tes'];
$ctc = $_POST['ctc'];
$created = date('Y-m-d H:i:s');

$sql = "INSERT INTO payroll_msalarystruc (empname, emp_no, desg,dept, salarytype, hra, oa, epf1, esi1, epf2, esi2, bp, epf3, created, netpay, tde, tes, ctc) 
        VALUES ('$empname', '$emp_no', '$desg','$dept', '$salarytype', '$hra', '$oa', '$epf1', '$esi1', '$epf2', '$esi2', '$bp', '$epf3', '$created', '$netpay', '$tde', '$tes', '$ctc')";

if ($conn->query($sql) === TRUE) {
    echo "Details added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
