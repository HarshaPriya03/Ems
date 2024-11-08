<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: loginpage.php");
    exit();
}

// Check if AJAX request is sent
if (isset($_POST['user_module'])) {
    // Connect to MySQL
    @include 'inc/config.php';

    // Check if latitude and longitude are provided
    if (!empty($_POST['latitude']) && !empty($_POST['longitude'])) {
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
    } else {
        echo '<script>alert("Please enable location access to proceed.");</script>';
        echo "<script>window.location.href = 'https://hrms.anikasterilis.com/loginpage.php';</script>";
        exit;
    }

    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Loop through submitted data to update user-module associations
    foreach ($_POST['user_module'] as $email => $selected_modules) {
        // Delete existing associations for the user
        $sql_delete = "DELETE FROM user_modules WHERE email = ?";
        $stmt = mysqli_prepare($con, $sql_delete);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        // Insert new associations
        foreach ($selected_modules as $module_id) {
            $access_by = $_SESSION['email'];
            $sql_insert = "INSERT INTO user_modules (email, module_id, access_by) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql_insert);
            mysqli_stmt_bind_param($stmt, "sss", $email, $module_id, $access_by);
            mysqli_stmt_execute($stmt);
        }
    }
    // Insert into user_pages table for logging user activity
    $page = basename($_SERVER['PHP_SELF']);
    $empemail = $_SESSION['email'];
    $sql_insert_page = "INSERT INTO user_pages (email, loggedtime, page, longitude, latitude) VALUES (?, NOW(), ?, ?, ?)";
    $stmt_page = mysqli_prepare($con, $sql_insert_page);
    mysqli_stmt_bind_param($stmt_page, "ssdd", $empemail, $page, $longitude, $latitude);
    mysqli_stmt_execute($stmt_page);

    // Close MySQL connection
    mysqli_close($con);

    // Send success response
    echo "User-Modules Access updated successfully!";
} else {
    // If not an AJAX request, redirect back to dashboard
    header("Location: dashboard.php");
    exit();
}
