<?php
session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}

if (isset($_POST['empname']) && isset($_POST['loanno'])) {
    $empname = $_POST['empname'];
    $loanno = $_POST['loanno'];

    $con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE payroll_loan SET status = 0 WHERE empname = ? AND loanno = ?";
    $query = $con->prepare($sql);
    $query->bind_param('ss', $empname, $loanno);
    if ($query->execute()) {
        echo 'Success';
    } else {
        echo 'Error';
    }
} else {
    echo 'Invalid request';
}
?>
