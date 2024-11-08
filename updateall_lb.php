<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$empName = $conn->real_escape_string($_POST['empName']); 

$selectSql = "SELECT sl, cl, isl, icl FROM leavebalance WHERE empname = '$empName'";
$result = $conn->query($selectSql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $slValue = $row['sl'] + 1;
    $clValue = $row['cl'] + 1;
    $islValue = $row['isl'] + 1;
    $iclValue = $row['icl'] + 1;
    $lastupdate = date('Y-m-d H:i:s');
    $updateSql = "UPDATE leavebalance SET sl = $slValue, cl = $clValue , isl = $islValue, icl = $iclValue , lastupdate = '$lastupdate' WHERE empname = '$empName'";

    if ($conn->query($updateSql) === TRUE) {
        $response = array('status' => 'success', 'message' => 'Leave balance updated successfully!');
        echo json_encode($response);
    } else {
        $response = array('status' => 'error', 'message' => 'Error updating leave balance: ' . $conn->error);
        echo json_encode($response);
    }
} else {
    $response = array('status' => 'error', 'message' => 'No leave balance found for the specified employee.');
    echo json_encode($response);
}
$conn->close();
?>
