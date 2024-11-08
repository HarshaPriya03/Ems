<?php
include_once 'dbConfig.php';

$ID = isset($_GET['id']) ? $_GET['id'] : null;

if ($ID !== null) {
    // Retrieve form data
    $sbn = isset($_POST['sbn']) && !empty($_POST['sbn']) ? $_POST['sbn'] : null;
    $sifsc = isset($_POST['sifsc']) && !empty($_POST['sifsc']) ? $_POST['sifsc'] : null;
    $sban = isset($_POST['sban']) && !empty($_POST['sban']) ? $_POST['sban'] : null;
    $uan = isset($_POST['uan']) && !empty($_POST['uan']) ? $_POST['uan'] : null;
    $epfn = isset($_POST['epfn']) && !empty($_POST['epfn']) ? $_POST['epfn'] : null;
    $esin = isset($_POST['esin']) && !empty($_POST['esin']) ? $_POST['esin'] : null;

    // Update database
    $insert = $db->query("UPDATE `emp` SET sbn='$sbn', sifsc='$sifsc', sban='$sban', uan='$uan', epfn='$epfn', esin='$esin' WHERE id='$ID'");

    echo $insert ? 'ok' : 'err';
} else {
    echo 'Invalid ID';
}
?>
