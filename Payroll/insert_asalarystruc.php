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
$emp_no = $_POST['emp_no'];
$salarytype = $_POST['salarytype'];
$ahra = $_POST['ahra'];
$aoa = $_POST['aoa'];
$aepf1 = $_POST['aepf1'];
$aesi1 = $_POST['aesi1'];
$aepf2 = $_POST['aepf2'];
$aesi2 = $_POST['aesi2'];
$abp = $_POST['abp'];
$aepf3 = $_POST['aepf3'];
$anetpay = $_POST['anetpay'];
$atde = $_POST['atde'];
$ates = $_POST['ates'];
$actc = $_POST['actc'];
$acreated = date('Y-m-d H:i:s');

$sql = "INSERT INTO payroll_asalarystruc (empname, emp_no, desg, salarytype, ahra, aoa, aepf1, aesi1, aepf2, aesi2, abp, aepf3, acreated, anetpay, atde, ates, actc) 
        VALUES ('$empname', '$emp_no', '$desg', '$salarytype', '$ahra', '$aoa', '$aepf1', '$aesi1', '$aepf2', '$aesi2', '$abp', '$aepf3', '$acreated',  '$anetpay', '$atde', '$ates', '$actc')";

if ($conn->query($sql) === TRUE) {
    echo "Details added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
