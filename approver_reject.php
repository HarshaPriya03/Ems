<?php
include_once 'dbConfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reject'])) {
    $appid = $_POST['appid'];
    $apremail = isset($_POST['apremail']) ? $_POST['apremail'] : '';
	$aprremark = $_POST['aprremark'];
    $aprtime = date('Y-m-d H:i:s');
    file_put_contents('post_data.log', print_r($_POST, true));

    $insert = $db->query("UPDATE leaves SET status='2', status1='1', aprremark = '$aprremark', aprtime='$aprtime' WHERE ID = '$appid' ");

    if ($insert) {
        echo 'ok';
    } else {
        echo 'err: ' . $db->error;
    }
} else {
    echo 'Invalid ID';
}

?>
