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
$photo = '';

if (isset($_FILES["photo"]["type"])) {
    $fileName = $_POST['empname'] . '_' . $_FILES['photo']['name'];
    $valid_extensions = array("jpeg", "jpg", "png", "gif", "bmp", "webp", "svg", "tiff", "ico");
    $valid_mime_types = array("image/jpeg", "image/jpg", "image/png", "image/gif", "image/bmp", "image/webp", "image/svg+xml", "image/tiff", "image/x-icon");

    $temporary = explode(".", $_FILES["photo"]["name"]);
    $file_extension = strtolower(end($temporary));
    $file_mime_type = $_FILES["photo"]["type"];

    if (in_array($file_extension, $valid_extensions) && in_array($file_mime_type, $valid_mime_types)) {
        $sourcePath = $_FILES['photo']['tmp_name'];
        $targetPath = "Photos/" . $fileName;

        if (move_uploaded_file($sourcePath, $targetPath)) {
            $photo = $fileName;
        } else {
            echo "Error uploading file.";
            exit();
        }
    } else {
        echo "Invalid file type.";
        exit();
    }
}

$pic = $_POST['pic'];

$mssg = '';

if (!empty($_POST['mssg1'])) {
    $mssg = $_POST['mssg1'];
} elseif (!empty($_POST['mssg2'])) {
    $mssg = $_POST['mssg2'];
} elseif (!empty($_POST['mssg3'])) {
    $mssg = $_POST['mssg3'];
}

$posted = date('Y-m-d H:i:s');

$sql_max_post_id = "SELECT MAX(post_id) AS max_post_id FROM akonnect";
$result_max_post_id = $con->query($sql_max_post_id);

if ($result_max_post_id->num_rows > 0) {
    $row_max_post_id = $result_max_post_id->fetch_assoc();
    $max_post_id = $row_max_post_id['max_post_id'];
    if (!empty($max_post_id)) {
        $next_post_id = sprintf('%02d', intval($max_post_id) + 1);
    } else {
        $next_post_id = '01';
    }
} else {
    $next_post_id = '01';
}

$sql = "INSERT INTO akonnect(empname, pic, mssg, posted, post_content, post_id) 
        VALUES ('$empname', '$pic', '$mssg', '$posted', '$photo', '$next_post_id')";

if ($con->query($sql) === TRUE) {
    echo "Done!";
} else {
    echo "Error updating record: " . $con->error;
}

$con->close();
