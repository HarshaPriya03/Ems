<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$insert_sql = "INSERT INTO payroll_emi (empname, emimonth, loanno, created, emi, category, reason) VALUES (?, ?, ?, ?, ?, ?, ?)";
$insert_query = $conn->prepare($insert_sql);
$insert_query->bind_param('sssssss', $empname, $emimonth, $loanno, $created, $emi, $category, $reason);

$empname = $_POST['empname'];
$loanno = $_POST['loanno'];
$emi = $_POST['emi'];
$emimonth = $_POST['emimonth'];
$category = $_POST['category'];
$reason = $_POST['reason'];
$created = date('Y-m-d H:i:s');

if ($insert_query->execute()) {
    $update_sql = "UPDATE payroll_loan SET status = 0, closed = ? WHERE empname = ? AND loanno = ?";
    $update_query = $conn->prepare($update_sql);
    $update_query->bind_param('sss', $created, $empname, $loanno);

    if ($update_query->execute()) {
        echo "Loan closed successfully!";
    } else {
        echo "Error updating payroll_loan status: " . $conn->error;
    }
} else {
    echo "Error inserting data into payroll_emi: " . $insert_query->error;
}

$conn->close();
