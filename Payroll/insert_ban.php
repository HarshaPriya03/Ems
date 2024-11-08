<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sban = $_POST['sban'];
$sbn = $_POST['sbn'];
$sifsc = $_POST['sifsc'];
$empname = $_POST['empname'];
$uan = $_POST['uan'];
$epfn = $_POST['epfn'];
$esin = $_POST['esin'];
$created = date('Y-m-d H:i:s');

$sql = "INSERT INTO payroll_ban(sbn, sifsc, empname, sban, created, status, status1, uan,epfn,esin)
 VALUES ('$sbn', '$sifsc', '$empname', '$sban' , '$created', '1', '0','$uan','$epfn','$esin')";

if ($conn->query($sql) === TRUE) {
    echo "Bank details added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
