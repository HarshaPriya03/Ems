<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedEmployees = $_POST['selectedEmployees'];
    $currentTime = date("Y-m-d H:i:s");
    foreach ($selectedEmployees as $employeeName) {
        $sql = "INSERT INTO absent (empname, AttendanceTime) VALUES ('$employeeName', '$currentTime')";
        $conn->query($sql);
    }
    
    echo "Marked absent successfully";
    $response = array("success" => true, "redirect" => "markabsent.php");
    echo json_encode($response);
} else {
    echo "Invalid request";
}
$conn->close();
?>
