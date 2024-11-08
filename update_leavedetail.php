<?php
include_once 'dbConfig.php';

$ID = isset($_GET['id']) ? $_GET['id'] : null;

if ($ID !== null) {
    $from = $_POST['from'] ?? '';
    $to = $_POST['to'] ?? '';
    $reason = $_POST['reason'] ?? '';
    $hrremark = $_POST['hrremark'] ?? '';
    $hrtime = date('Y-m-d H:i:s');

    $insert = $db->query("UPDATE `leaves` SET `from`='$from', `to`='$to', reason='$reason', hrremark='$hrremark', hrtime='$hrtime' WHERE id='$ID'");

    echo $insert ? 'ok' : 'err';
} else {
    echo 'Invalid ID';
}
?>
