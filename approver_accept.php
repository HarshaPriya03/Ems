<?php
include_once 'dbConfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve'])) {
    $appid = $_POST['appid'];
    $apremail = isset($_POST['apremail']) ? $_POST['apremail'] : '';
    $aprtime = date('Y-m-d H:i:s');
    file_put_contents('post_data.log', print_r($_POST, true));

    $insert = $db->query("UPDATE leaves SET status1='1', status='1', aprtime='$aprtime' WHERE ID = '$appid'");

    if ($insert) {
        echo 'ok';
    } else {
        $error_message = 'Error executing query: ' . $db->error;
        error_log($error_message, 3, 'error.log');
        echo 'err';
    }
    
} else {
    echo 'Invalid ID';
}

?>
