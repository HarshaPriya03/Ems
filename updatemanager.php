<?php
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['toggleStatus'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $newStatus = ($status == 1) ? 0 : 1;

    $sql = "UPDATE manager SET status = $newStatus WHERE id = '$id'";
    $updateQuery = mysqli_query($conn, $sql);

    if ($updateQuery) {
        $response = array('status' => 'success', 'message' => 'Status updated successfully!');
        echo json_encode($response);
        exit(); 
    } else {
        $response = array('status' => 'error', 'message' => 'Error updating status: ' . mysqli_error($conn));
        echo json_encode($response);
        exit();
    }
}

$conn->close();
?>
