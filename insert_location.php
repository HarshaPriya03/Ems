<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$building= $_POST['building'];
$sname1= $_POST['sname1'];
$sname2= $_POST['sname2'];
$area= $_POST['area'];
$city= $_POST['city'];
$state= $_POST['state'];
$pin= $_POST['pin'];
$abbr= $_POST['abbr'];
$email= $_POST['email'];
$phone= $_POST['phone'];

$sql = "INSERT INTO workLocation (building, sname1, sname2,area,city, state,pin,abbr,email,phone) 
        VALUES ('$building', '$sname1','$sname2', '$area', '$city','$state', '$pin', '$abbr','$email','$phone')";

if ($conn->query($sql) === TRUE) {
    echo "Done !";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
