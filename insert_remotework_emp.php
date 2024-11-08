<?php
include 'inc/config.php';

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
    exit();
}

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$empname = $_POST['empname'];
$id = $_POST['id'];
$start = $_POST['start'];
$end = $_POST['end'];
$total = $_POST['total'];
$mgrname = $_POST['mgrname'];
$report = $_POST['report'];

$targetDir = "work_pics/";
$fileNames = [];
$uploadStatus = true;

if (!empty(array_filter($_FILES['work_pics']['name']))) {
    foreach ($_FILES['work_pics']['name'] as $key => $val) {
        $fileName = basename($_FILES['work_pics']['name'][$key]);
        $targetFilePath = $targetDir . $fileName;

        $check = getimagesize($_FILES['work_pics']['tmp_name'][$key]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['work_pics']['tmp_name'][$key], $targetFilePath)) {
                $fileNames[] = $fileName;
            } else {
                $uploadStatus = false;
                echo "Sorry, there was an error uploading file: " . $fileName;
                break;
            }
        } else {
            $uploadStatus = false;
            echo "File is not an image: " . $fileName;
            break;
        }
    }
}

if ($uploadStatus) {
    $fileNamesString = implode(",", $fileNames);

    $sql = "INSERT INTO remotework_emp(empname, link_id, `start`, `end`, total, `status`, mgrname, report, work_pics) 
            VALUES ('$empname', '$id', '$start', '$end', '$total', '0', '$mgrname', '$report', '$fileNamesString')";

    if ($con->query($sql) === TRUE) {
        echo "Done!";
    } else {
        echo "Error updating record: " . $con->error;
    }
}

$con->close();
?>
