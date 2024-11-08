<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$empname = $_POST['empname'];
$empemail= $_POST['empemail'];
$dtype = $_POST['dtype'];
$downer = $_POST['downer'];
$dname = $_POST['dname'];
$mname = $_POST['mname'];
$srno = $_POST['srno'];
$mac = $_POST['mac'];
$reason = $_POST['reason'];
$status = $_POST['status'];

$sql = "INSERT INTO inet_access(empname,empemail,dtype,downer,dname, mname, srno, mac , reason, status)
 VALUES ('$empname' ,'$empemail' , '$dtype',  '$downer' ,'$dname' , '$mname' , '$srno' , '$mac' ,'$reason' , '$status')";

if ($conn->query($sql) === TRUE) {
    echo "Request Sent Successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
