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
$damt = $_POST['damt'];
$dtype = $_POST['dtype'];
$reason = $_POST['reason'];
$paymonth = $_POST['paymonth'];
$created = date('Y-m-d H:i:s');


$sql = "INSERT INTO payroll_misc(empname,damt,dtype,reason,paymonth, created)
 VALUES ('$empname','$damt', '$dtype',  '$reason',  '$paymonth', '$created')";

if ($conn->query($sql) === TRUE) {
    echo "Misc created successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
