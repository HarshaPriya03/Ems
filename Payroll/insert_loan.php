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
$loamt = $_POST['loamt'];
$loterm = $_POST['loterm'];
$emi = $_POST['emi'];
$notes = $_POST['notes'];
$stmonth = $_POST['stmonth'];
$lno = $_POST['lno'];
$disbursed = $_POST['disbursed'];
$created = date('Y-m-d H:i:s');

$mop = isset($_POST['mop']) ? $_POST['mop'] : NULL;
$tno = isset($_POST['tno']) ? $_POST['tno'] : NULL;
$pdate = isset($_POST['pdate']) ? $_POST['pdate'] : NULL;

$sql = "INSERT INTO payroll_loan(empname, loamt, mop, tno, loanno, created, pdate, loterm, emi, notes, stmonth,disbursed,status)
 VALUES ('$empname', '$loamt', '$mop', '$tno', '$lno', '$created', '$pdate', '$loterm', '$emi', '$notes', '$stmonth', '$disbursed','1')";

if ($conn->query($sql) === TRUE) {
    echo "New Loan A/C Opened Successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
