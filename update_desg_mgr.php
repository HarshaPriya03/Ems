<?php
 $con=mysqli_connect("localhost","root","","ems");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $newDesgs = isset($_POST['desgs']) ? $_POST['desgs'] : [];

    $newDesgsStr = implode(', ', $newDesgs);

    $sql = "SELECT desg FROM manager WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($existingDesgs);
    $stmt->fetch();
    $stmt->close();

    if ($existingDesgs) {
        $existingDesgsArray = explode(', ', $existingDesgs);

        $allDesgsArray = array_unique(array_merge($existingDesgsArray, $newDesgs));

        $allDesgsStr = implode(', ', $allDesgsArray);
    } else {
        $allDesgsStr = $newDesgsStr;
    }

    $sql = "UPDATE manager SET desg = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('si', $allDesgsStr, $id);
    if ($stmt->execute()) {
        echo 'Update successful';
    } else {
        echo 'Error updating record: ' . $stmt->error;
    }
    $stmt->close();
    $con->close();
} else {
    http_response_code(405);
    echo 'Invalid request method';
}
?>
