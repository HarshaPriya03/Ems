<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$amt = $_POST['amt'];
$bonus = $_POST['bonus'];
$notes = $_POST['notes'];
$created = date('Y-m-d H:i:s');


$sql = "INSERT INTO payroll_bonus(amt,bonus,notes, created)
 VALUES ('$amt', '$bonus',  '$notes', '$created')";

if ($conn->query($sql) === TRUE) {
    echo "Bonus created successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
