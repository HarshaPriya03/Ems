<?php
include 'inc/config.php';

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$folder_name = $_POST['folder_name'];
$dept = $_POST['dept'];
$desc = $_POST['desc'];
$work_location = $_POST['work_location'];
$empty = $_POST['empty'];
$time = date('Y-m-d H:i:s');

$concatenatedDept = implode(', ', $dept);
$concatenatedWork_location = implode(', ', $work_location);
$concatenatedEmpty = implode(', ', $empty);


$sql = "INSERT INTO policies_folder (folder_name, dept, `desc`, `status`, work_location, `empty`, email, `time`, folder_status ) 
        VALUES ('$folder_name', '$concatenatedDept', '$desc', '1', '$concatenatedWork_location', '$concatenatedEmpty', '1', '$time' ,'1')";

if ($con->query($sql) === TRUE) {
    echo "Done!";
} else {
    echo "Error updating record: " . $con->error;
}

$con->close();
?>
