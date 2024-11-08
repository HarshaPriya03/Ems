<?php
include 'inc/config.php'; 

$id = $_GET['id'];
$sql = "SELECT * FROM payroll_loan_req WHERE id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data);
?>