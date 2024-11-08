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
$loanno = $_POST['loanno'];
$emi = $_POST['emi'];
$emimonth = $_POST['emimonth'];

$created = date('Y-m-d H:i:s');

$sql = "INSERT INTO payroll_emi(empname,emimonth, loanno, created, emi)
 VALUES ('$empname', '$emimonth', '$loanno', '$created', '$emi')";

if ($conn->query($sql) === TRUE) {
    echo "EMI deducted successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
