<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$bank_name = $_POST['bank_name'];
$ifsc = $_POST['ifsc'];
$default_bank = isset($_POST['default_bank']) ? $_POST['default_bank'] : 'No';

$sql = "INSERT INTO payroll_bank (bank_name, ifsc, default_bank) VALUES ('$bank_name', '$ifsc', '$default_bank')";

if ($conn->query($sql) === TRUE) {
    echo "Bank details added successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
