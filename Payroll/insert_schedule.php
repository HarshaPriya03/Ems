<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$startMonth = $_POST['startMonth'];
$selectedDay = $_POST['selectedDay'];

$startDateTime = DateTime::createFromFormat('F Y', $startMonth);

for ($i = 0; $i < 12; $i++) {
    $payrollDate = clone $startDateTime;
    $payrollDate->modify("+$i months");
    
    $payrollMonth = $payrollDate->format('F Y');

    
    $sql = "INSERT INTO payroll_schedule (sdate, smonth, status) VALUES ('$selectedDay', '$payrollMonth',0)";
    
    if ($conn->query($sql) === TRUE) {
        echo "Payroll schedule inserted for $payrollMonth<br>";
    } else {
        echo "Error inserting payroll schedule: " . $conn->error . "<br>";
    }
}

$conn->close();
?>
