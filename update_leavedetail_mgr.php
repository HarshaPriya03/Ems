<?php
include_once 'dbConfig.php';

$ID = isset($_GET['id']) ? $_GET['id'] : null;

if ($ID !== null) {
    $mgrremark = $_POST['mgrremark'] ?? '';
    $mgrtime = date('Y-m-d H:i:s');

    $insert = $db->query("UPDATE `leaves` SET mgrremark='$mgrremark', mgrtime='$mgrtime' WHERE id='$ID'");

    echo $insert ? 'ok' : 'err';
} else {
    echo 'Invalid ID';
}
?>
