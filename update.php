<?php
include_once 'dbConfig.php';

$ID = isset($_GET['id']) ? $_GET['id'] : null;

if ($ID !== null) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $empdob = $_POST['empdob'] ?? '';
    $ms = $_POST['ms'] ?? '';
    $gen = $_POST['gen'] ?? '';
    $empid = $_POST['empid'] ?? '';
    $rm = $_POST['rm'] ?? '';
    $desg = $_POST['desg'] ?? '';
    $emptype = $_POST['emptype'] ?? '';
    $doj = $_POST['doj'] ?? '';
    $dept = $_POST['dept'] ?? '';
    $salary = $_POST['salary'] ?? '';
    $work_location = $_POST['work_location'] ?? '';
    $pan = $_POST['pan'] ?? '';
    $ban = $_POST['ban'] ?? '';
    $bn = $_POST['bn'] ?? '';
    $adn = $_POST['adn'] ?? '';
    $ifsc = $_POST['ifsc'] ?? '';

    $insert = $db->query("UPDATE `emp` SET empname='$name', empemail='$email', empph='$mobile', empdob='$empdob', empms='$ms', empgen='$gen', emp_no='$empid', rm='$rm', desg='$desg', empty='$emptype', empdoj='$doj', dept='$dept', salary='$salary',work_location='$work_location', pan='$pan', ban='$ban', bn='$bn', adn='$adn', ifsc='$ifsc' WHERE id='$ID'");

    echo $insert ? 'ok' : 'err';
} else {
    echo 'Invalid ID';
}
?>
