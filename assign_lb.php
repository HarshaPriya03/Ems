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
        $selectSql = "SELECT sl, cl, isl, icl FROM leavebalance WHERE empname = '$employeeName'";
        $result = $conn->query($selectSql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();


            // Ensure sl and cl values are not negative
            $slValue = max(0, $row['sl']) + 1;
            $clValue = max(0, $row['cl']) + 1;
            $islValue = $row['isl'] + 1;
            $iclValue = $row['icl'] + 1;
            $lastupdate = date('Y-m-d H:i:s');

            $updateSql = "UPDATE leavebalance SET sl = $slValue, cl = $clValue, isl = $islValue, icl = $iclValue, lastupdate = '$lastupdate' WHERE empname = '$employeeName'";

            if ($conn->query($updateSql) === TRUE) {
                continue; // Move to the next employee
            } else {
                $response = array('status' => 'error', 'message' => 'Error updating leave balance for employee: ' . $employeeName . ' - ' . $conn->error);
                echo json_encode($response);
                exit();
            }
        } else {
            $response = array('status' => 'error', 'message' => 'No leave balance found for the specified employee: ' . $employeeName);
            echo json_encode($response);
            exit();
        }
    }

    $response = array('status' => 'success', 'message' => 'Leave balances and attendance confirmed successfully!');
    echo json_encode($response);
} else {
    echo "Invalid request";
}

$conn->close();
?>
