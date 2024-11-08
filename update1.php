<?php
include_once 'dbConfig.php';
$ID=$_GET['id'];
    $insert = $db->query("update `onb` set status='1' where id='$ID' ");
 
    echo $insert?'ok':'err';
    
?>
