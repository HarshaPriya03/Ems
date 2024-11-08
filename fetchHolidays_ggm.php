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

$sql = "SELECT * FROM holiday_ggm";
$result = $conn->query($sql);

$holidays = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $holidays[] = array(
            "date" => $row['date'],
            "name" => $row['value']
        );
    }
}

header('Content-Type: application/json');
echo json_encode($holidays);

$conn->close();
?>
