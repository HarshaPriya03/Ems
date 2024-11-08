<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$empname = $_POST['empname'];
$empemail = $_POST['empemail'];
$sl = $_POST['sl'];
$cl = $_POST['cl'];
$co = $_POST['co'];
$iupdate = date('Y-m-d H:i:s');
$lastupdate = date('Y-m-d H:i:s');

$sql = "INSERT INTO leavebalance (empname, empemail,cl,sl,co,icl,isl,ico,iupdate,lastupdate) VALUES ('$empname', '$empemail', '$cl', '$sl', '$co','$cl', '$sl', '$co', '$iupdate', '$lastupdate')";
if ($conn->query($sql) === TRUE) {
    echo "Leave balance added!";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
