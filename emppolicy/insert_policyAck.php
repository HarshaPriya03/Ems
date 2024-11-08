<?php
include 'inc/config.php';

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$empname = $_POST['empname'];
$policy_title = $_POST['policy_title'];
$policyno = $_POST['policyno'];
$dept = $_POST['dept'];
$folder_name= $_POST['folder_name'];
$version= $_POST['version'];
$ack_time = date('Y-m-d H:i:s');

$sql = "INSERT INTO policies_ack(empname,policy_title,policyno,dept,`version`, ack_status, ack_time ,folder_name) 
        VALUES ('$empname','$policy_title','$policyno', '$dept','$version',  '1',  '$ack_time' , '$folder_name')";

if ($con->query($sql) === TRUE) {
    echo "Done!";
} else {
    echo "Error updating record: " . $con->error;
}

$con->close();
?>
