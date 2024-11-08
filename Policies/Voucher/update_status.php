<?php
include 'inc/config.php';

session_start();

if (!isset($_SESSION['user_name'])) {
    header('location:loginpage.php');
    exit;
}

$user_name = $_SESSION['user_name'];
$sql = "SELECT `name` FROM user_form WHERE email = '$user_name'";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$name = $row['name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voucherno = isset($_GET['voucherno']) ? $_GET['voucherno'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    if (empty($voucherno) || empty($status)) {
        echo "Voucher number or status is missing.";
        exit;
    }

    $apr_time = date('Y-m-d H:i:s');

    $sql = "UPDATE travel_voucher SET apr_name = ?, apr_time = ?, status = ? WHERE voucherno = ?";
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        die("Preparation failed: " . $con->error);
    }

    $stmt->bind_param('ssis', $name, $apr_time, $status, $voucherno);

    if ($stmt->execute()) {
        echo "Voucher Status updated successfully!";
    } else {
        echo "Error updating status: " . $stmt->error;
    }

    $stmt->close();
    $con->close();
} else {
    echo "Invalid request method.";
}
?>
