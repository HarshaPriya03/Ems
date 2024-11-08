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
    $submissionTime = $_POST['submissionTime'];
    $confirm = $_POST['confirm'];
    foreach ($selectedEmployees as $employeeName) {
        // Insert confirmation record into CA table
        $insertSql = "INSERT INTO CA (empname, status, submissionTime, confirmed) VALUES ('$employeeName', 1, '$submissionTime', '$confirm')";
        if ($conn->query($insertSql) === FALSE) {
            $response = array('status' => 'error', 'message' => 'Error inserting confirmation record: ' . $conn->error);
            echo json_encode($response);
            exit();
        }
    }

    // All operations succeeded
    $response = array('status' => 'success', 'message' => 'Attendance confirmed successfully!');
    echo json_encode($response);
} else {
    echo "Invalid request";
}

$conn->close();
?>
