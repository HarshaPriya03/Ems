<?php
include 'inc/config.php';

// Assuming version and policy_title are passed through POST
$version = $_POST['version'];
$policy_title = $_POST['policy_title'];

$dept = $_POST['dept'];
$work_location = $_POST['work_location'];
$empty = $_POST['empty'];

// Convert arrays to comma-separated values
$concatenatedDept = implode(', ', $dept);
$concatenatedWork_location = implode(', ', $work_location);
$concatenatedEmpty = implode(', ', $empty);

// Prepare and execute the SQL update statement
$sql = "UPDATE policies_policy SET dept = ?, work_location = ?, empty = ? WHERE version = ? AND policy_title = ?";
$stmt = $con->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($con->error));
}

$stmt->bind_param('sssss', $concatenatedDept, $concatenatedWork_location, $concatenatedEmpty, $version, $policy_title);

if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $stmt->error;
}

$stmt->close();
$con->close();
?>
