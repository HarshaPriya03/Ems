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
$mgrname = $_POST['mgrname'];
$desg = $_POST['desg'];
$from = $_POST['from'];
$to = $_POST['to'];
$reason= $_POST['reason'];

$sql = "INSERT INTO remotework(mgrname,empname,desg,`from`,`to`,reason,`status`,`status1`,apr) 
        VALUES ('$mgrname','$empname','$desg','$from','$to','$reason','0','0','0')";

if ($con->query($sql) === TRUE) {
    echo "Done!";
} else {
    echo "Error updating record: " . $con->error;
}

$con->close();
?>
