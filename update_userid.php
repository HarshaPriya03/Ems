<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$selectedEmployee = $_POST['employee'];
$userId = $_POST['userId'];
$serviceTagId = $_POST['serviceTagId'];
$isMultiLocation = $_POST['isMultiLocation'];

if ($isMultiLocation == 'true') {
    $sql = "UPDATE emp SET UserId1 = '$userId', ServiceTagId1 = '$serviceTagId' WHERE empname = '$selectedEmployee'";
} else {
    $sql = "UPDATE emp SET UserId = '$userId', ServiceTagId = '$serviceTagId' WHERE empname = '$selectedEmployee'";
}

if ($conn->query($sql) === TRUE) {
    echo "Mapping UserID with Employee Done!";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
