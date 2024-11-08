<?php
include 'inc/config.php';

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $policy_title = isset($_GET['policy_title']) ? $_GET['policy_title'] : '';
    $policyno = isset($_GET['policyno']) ? $_GET['policyno'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $apr_name = isset($_POST['apr_name']) ? $_POST['apr_name'] : '';

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $apr_time = date('Y-m-d H:i:s');
    $apr_email = $_SESSION['user_name'];

    $sql = "UPDATE policies_policy SET apr_name = ?, apr_email = ?, apr_time = ?, status = ? WHERE policy_title = ? AND policyno = ?";
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        die("Preparation failed: " . $con->error);
    }

    $stmt->bind_param('sssiss', $apr_name, $apr_email, $apr_time, $status, $policy_title, $policyno);

    if ($stmt->execute()) {
        echo "Policy Approved Successfully!";
    } else {
        echo "Error updating status: " . $con->error;
    }

    $stmt->close();
    $con->close();
} else {
    echo "Invalid request method.";
}
?>