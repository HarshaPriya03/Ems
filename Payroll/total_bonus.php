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
$sql = "SELECT salarymonth, SUM(bonus) as total_bonus FROM payroll_ss GROUP BY salarymonth ORDER BY salarymonth";
$result = $conn->query($sql);

$monthss = [];
$bonuss = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $monthss[] = $row['salarymonth'];
        $bonuss[] = $row['total_bonus'];
    }
} else {
    echo "0 results";
}
$conn->close();

// Output data as JavaScript arrays
echo "const monthss = " . json_encode($monthss) . ";";
echo "const bonuss = " . json_encode($bonuss) . ";";
?>
