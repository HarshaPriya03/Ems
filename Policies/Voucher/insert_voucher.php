<?php
include 'inc/config.php';

if ($con->connect_error) {
    die(json_encode(array('status' => 'error', 'message' => "Connection failed: " . $con->connect_error)));
}

$ticket = '';
if (!empty($_FILES["ticket"]["type"])) {
    $fileName = $_POST['empname'] . '_' . $_FILES['ticket']['name'];
    $valid_extensions = array("pdf", "jpeg", "jpg", "png");
    $temporary = explode(".", $_FILES["ticket"]["name"]);
    $file_extension = end($temporary);

    if ((($_FILES["ticket"]["type"] == "application/pdf") ||
            ($_FILES["ticket"]["type"] == "image/jpeg") ||
            ($_FILES["ticket"]["type"] == "image/jpg") ||
            ($_FILES["ticket"]["type"] == "image/png")) &&
        in_array($file_extension, $valid_extensions)
    ) {
        $sourcePath = $_FILES['ticket']['tmp_name'];
        $targetPath = "ticket/" . $fileName;

        if (move_uploaded_file($sourcePath, $targetPath)) {
            $ticket = $fileName;
        }
    }
}

$empname = $_POST['empname'];
$from_city = $_POST['from_city'];
$to_city = $_POST['to_city'];
$boarding_date = $_POST['boarding_date'];
$departure_date = $_POST['departure_date'];
$duration = $_POST['duration'];
$mode = $_POST['mode'];
$cost = $_POST['cost'];
$policies_policy = $_POST['policies_policy'];
$transno = $_POST['transno'];
$voucherno = $_POST['voucherno'];
$created = date('Y-m-d H:i:s');

$sql = "INSERT INTO travel_voucher (empname, from_city, to_city, boarding_date, departure_date, duration, mode, cost, ticket, policies_policy, transno, voucherno, created, `status`) 
        VALUES ('$empname', '$from_city', '$to_city', '$boarding_date', '$departure_date', '$duration', '$mode', '$cost', '$ticket', '$policies_policy', '$transno', '$voucherno', '$created', '0')";

if ($con->query($sql) === TRUE) {
    echo json_encode(array('status' => 'success', 'message' => "Done!"));
} else {
    echo json_encode(array('status' => 'error', 'message' => "Error updating record: " . $con->error));
}

$con->close();
?>
