<?php
include 'inc/config.php';

$empname = $_GET['empname'];
$id = $_GET['id'];

$sql = "UPDATE remotework SET status = 1 WHERE empname = ? AND id = ? AND status = 0";
$stmt = $con->prepare($sql);

if ($stmt === false) {
    die("Error preparing the statement: " . $con->error);
}

// Bind both parameters empname and id
$stmt->bind_param("si", $empname, $id);

$success = $stmt->execute();

if ($success) {
    echo "Record updated successfully.";
} else {
    echo "Error updating record: " . $stmt->error;
}

$stmt->close();
$con->close();
?>
