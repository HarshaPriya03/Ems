<?php
 $con=mysqli_connect("localhost","root","","ems");

$sql = "SELECT desg FROM dept";
$result = $con->query($sql);

$desgs = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $desgs[] = $row['desg'];
    }
}

header('Content-Type: application/json');
echo json_encode($desgs);
?>
