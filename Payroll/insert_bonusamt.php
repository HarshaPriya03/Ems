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
    $bonus = $_POST['bonus'];
    $bonusAmount = $_POST['bonusAmount'];
    $payoutDate = $_POST['payoutDate'];
    $created = date("Y-m-d H:i:s");
    foreach ($selectedEmployees as $employeeName) {
        $sql = "INSERT INTO payroll_bonusamt (empname, amt, bonus, paymonth, created) 
        VALUES ('$employeeName', '$bonusAmount', '$bonus', '$payoutDate', '$created')";
        $conn->query($sql);
    }

    echo "Bonus allocated successfully";
    // Assuming you want to return JSON response
    $response = array("success" => true, "redirect" => "confirmAttendance.php");
    echo json_encode($response);
} else {
    echo "Invalid request";
}
$conn->close();
?>
