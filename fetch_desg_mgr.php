<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $con = mysqli_connect("localhost", "root", "", "ems");

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $id = intval($_POST['id']);

    $sql = "SELECT desg, empname FROM manager WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($desg, $empname);
    $stmt->fetch();
    $stmt->close();

    $con->close();

    header('Content-Type: application/json');
    echo json_encode(['desg' => $desg, 'empname' => $empname]);
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method']);
}
?>