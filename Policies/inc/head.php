<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" href="https://ik.imagekit.io/rzral9lq4/as/as/Anika_logo.png?ik-sdk-version=javascript-1.4.3&updatedAt=1677236863740" type="image/x-icon" width="" height="">
  <link rel="stylesheet" href="../css/GPMScss/font-awesome.min.css">
  <link rel="stylesheet" href="../css/GPMScss/bootstrap.css">
  <link rel="stylesheet" href="../css/GPMScss/style.css">
  <title>PolicyMaker</title>
</head>

<?php
@include 'inc/config.php';
session_start();

// Initialize login attempts if not set
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass = md5($_POST['password']);
    $latitude = 'N/A';
    $longitude = 'N/A';

    // Increment login attempts
    $_SESSION['login_attempts']++;

    // Check if location is provided or if login attempts are 3 or more
    if ($_SESSION['login_attempts'] < 3 && (empty($_POST['latitude']) || empty($_POST['longitude']))) {
        echo '<script>alert("Please enable location access to proceed.");</script>';
        echo "<script>window.location.href = 'https://hrms.anikasterilis.com/loginpage.php';</script>";
        exit;
    }

    if ($_SESSION['login_attempts'] >= 3) {
        // Use N/A for latitude and longitude if attempts are 3 or more
        $latitude = 'N/A';
        $longitude = 'N/A';
    } else {
        // Use provided latitude and longitude
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
    }

    $select = "SELECT uf.*, m.status as manager_status 
               FROM user_form uf
               LEFT JOIN manager m ON uf.email = m.email 
               WHERE uf.email = '$email' AND uf.password = '$pass'";
    $result = mysqli_query($con, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $_SESSION['email'] = $email;

        $module_sql = "SELECT module_name FROM modules INNER JOIN user_modules ON modules.id = user_modules.module_id WHERE user_modules.email = '$email'";
        $module_result = mysqli_query($con, $module_sql);

        $insertQuery = "INSERT INTO loggedin (empemail, loggedtime, device, browser, longitude, latitude) VALUES ('$email', NOW(), 'desktopapp', '" . $_SERVER['HTTP_USER_AGENT'] . "', '$longitude', '$latitude')";
        mysqli_query($con, $insertQuery);

        if ($row['user_type'] == 'acc') {
            $_SESSION['user_name'] = $row['email'];
            $_SESSION['admin_name'] = $row['name'];
            header('location:Payroll/acc/acc_payroll.php');
            exit;
        } elseif ($row['user_type'] == 'admin') {
            $_SESSION['user_name'] = $row['email'];
            $_SESSION['admin_name'] = $row['name'];
            header('location:index.php');
            exit;
        } elseif ($row['manager_status'] == 1) {
            $_SESSION['user_name'] = $row['email'];
            $_SESSION['admin_name'] = $row['name'];
            header('location:index_mgr.php');
            exit;
        } elseif ($module_row = mysqli_fetch_assoc($module_result)) {
            $_SESSION['user_name'] = $row['email'];
            $_SESSION['admin_name'] = $row['name'];
            $module_name = $module_row['module_name'];
            header("Location: $module_name");
            exit();
        } else {
            header('location:employee-dashboard.php');
            exit;
        }
    } else {
        echo '<script>alert("Incorrect Email or Password!");</script>';
        echo "<script>window.location.href = 'https://hrms.anikasterilis.com/loginpage.php';</script>";
    }

    $select_email = "SELECT * FROM user_form WHERE email = '$email'";
    $result_email = mysqli_query($con, $select_email);

    if (mysqli_num_rows($result_email) === 0) {
        echo '<script>alert("Email does not exist!");</script>';
        echo "<script>window.location.href = 'https://hrms.anikasterilis.com/loginpage.php';</script>";
    }
}
?>
