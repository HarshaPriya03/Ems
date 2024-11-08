<?php
$con = mysqli_connect("localhost", "root", "", "ems");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $designations = $_POST['desgs'];

    $currentDesgQuery = "SELECT desg FROM manager WHERE id='$id'";
    $currentDesgResult = $con->query($currentDesgQuery);
    $currentDesgs = $currentDesgResult->fetch_assoc()['desg'];
    
    $currentDesgsArray = explode(', ', $currentDesgs);

    $updatedDesgsArray = array_diff($currentDesgsArray, $designations);

    $updatedDesgs = implode(', ', $updatedDesgsArray);

    $updateQuery = "UPDATE manager SET desg='$updatedDesgs' WHERE id='$id'";
    if ($con->query($updateQuery) === TRUE) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $con->error]);
    }
}
?>
