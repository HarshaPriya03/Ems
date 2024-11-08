<?php
include 'inc/config.php';

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
    exit();
}

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$empname = $_POST['empname'];
$post_id = $_POST['post_id'];
$posted = date('Y-m-d H:i:s');

$sql = "INSERT INTO aKonnect_likes (empname, post_id, liked, status) VALUES ('$empname', '$post_id', '$posted', 1)";

if ($con->query($sql) === TRUE) {
    echo "Like  successfully!";
} else {
    echo "Error inserting like: " . $con->error;
}

$con->close();
?>
