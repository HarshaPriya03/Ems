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

// Fetch data
$sql = "SELECT SUM(lopamt) as total_lopamt, SUM(misc) as total_misc, SUM(tds) as total_tds, SUM(totaldeduct) as total_totaldeduct FROM payroll_ss";
$result = $conn->query($sql);

$data = $result->fetch_assoc();

$lopamt = $data['total_lopamt'];
$misc = $data['total_misc'];
$tds = $data['total_tds'];
$totaldeduct = $data['total_totaldeduct'];

$conn->close();

// Output data as JavaScript variables
echo "const dataLopamt = $lopamt;";
echo "const dataMisc = $misc;";
echo "const dataTds = $tds;";
echo "const dataTotaldeduct = $totaldeduct;";
?>
