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
$sql = "SELECT SUM(hra) as total_hra, SUM(oa) as total_oa, SUM(bp) as total_bp, SUM(netpay) as total_netpay FROM payroll_msalarystruc";
$result = $conn->query($sql);

$data = $result->fetch_assoc();

$hra = $data['total_hra'];
$oa = $data['total_oa'];
$bp = $data['total_bp'];
$netpay = $data['total_netpay'];

$conn->close();

echo "const dataHra = $hra;";
echo "const dataOa = $oa;";
echo "const dataBp = $bp;";
echo "const dataNetpay = $netpay;";
?>
