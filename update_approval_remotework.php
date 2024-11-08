<?php
include 'inc/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];
    
    
    $sql = "UPDATE remotework SET apr = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('ii', $status, $id);
    
    if ($stmt->execute()) {
        echo 'Success';
    } else {
        echo 'Error: ' . $stmt->error;
    }
    
    $stmt->close();
    $con->close();
}
?>
