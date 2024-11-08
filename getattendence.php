<?php
session_start(); 
@include 'inc/config.php';

$prevMaxId = isset($_SESSION['prevMaxId']) ? $_SESSION['prevMaxId'] : 0;

$query = "SELECT MAX(ID) as currentMaxId FROM CamsBiometricAttendance";
$result = mysqli_query($con, $query);

$response = array('hasUpdates' => false, 'error' => null);

if (!$result) {
    $response['error'] = mysqli_error($con);
} else {
    $row = mysqli_fetch_assoc($result);

    $response['hasUpdates'] = ($row['currentMaxId'] > $prevMaxId);

    $_SESSION['prevMaxId'] = $row['currentMaxId'];
}

ob_clean();

header('Content-Type: application/json');

echo json_encode($response);

exit;
?>
