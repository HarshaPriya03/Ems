<?php
include 'inc/config.php';

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$email = $_SESSION['user_name'];
$policy_title = $_POST['policy_title'];
$policy_category = $_POST['policy_category'];
$policyno = $_POST['policyno'];
$policy_content = $_POST['policy_content'];
$dept = $_POST['dept'];
$desc = $_POST['desc'];
$work_location = $_POST['work_location'];
$empty = $_POST['empty'];
$folder_name= $_POST['folder_name'];
$version= $_POST['version'];
$time = date('Y-m-d H:i:s');

$concatenatedEmpty = implode(', ', $empty);
$concatenatedDept = implode(', ', $dept);
$concatenatedWork_location = implode(', ', $work_location);

$sql = "INSERT INTO policies_policy (policy_title,policy_category,policyno, policy_content,dept,`version`,  `desc`, `status`, work_location, `empty`, email, `time` ,folder_name) 
        VALUES ('$policy_title','$policy_category','$policyno', '$policy_content', '$concatenatedDept','$version', '$desc', '0', '$concatenatedWork_location', '$concatenatedEmpty', '$email', '$time' , '$folder_name')";

if ($con->query($sql) === TRUE) {
    echo "Done!";
} else {
    echo "Error updating record: " . $con->error;
}

$con->close();
?>
