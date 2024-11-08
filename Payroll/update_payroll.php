<?php
session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
    exit(); // Add this to stop further execution if the user is not logged in
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare SQL statement for updating payroll
    $sql = "UPDATE payroll_ss SET 
                fgs = ?, 
                fhra = ?, 
                foa = ?, 
                fbp = ?, 
                monthdays = ?, 
                present = ?, 
                leaves = ?, 
                sundays = ?, 
                flop = ?, 
                paydays = ?, 
                gross = ?, 
                hra = ?, 
                oa = ?, 
                bp = ?, 
                epf1 = ?, 
                esi1 = ?, 
                tds = ?, 
                emi = ?, 
                lopamt = ?, 
                totaldeduct = ?, 
                bonus = ?, 
                payout = ?,
                status1 = ?
            WHERE empname = ?";

    // Prepare and bind parameters to prevent SQL injection
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssssssssssssssssssssss", $_POST['fgs'], $_POST['fhra'], $_POST['foa'], $_POST['fbp'], $_POST['monthdays'], $_POST['present'], $_POST['leaves'], $_POST['sundays'], $_POST['flop'], $_POST['paydays'], $_POST['gross'], $_POST['hra'], $_POST['oa'], $_POST['bp'], $_POST['epf1'], $_POST['esi1'], $_POST['tds'], $_POST['emi'], $_POST['lopamt'], $_POST['totaldeduct'], $_POST['bonus'], $_POST['payout'],  $_POST['status1'], $_POST['empname']);


    // Execute the update statement
    if ($stmt->execute()) {
        // If update is successful, return success message
        echo json_encode(array("success" => true));
    } else {
        // If update fails, return error message
        echo json_encode(array("success" => false));
    }

    // Close statement and connection
    $stmt->close();
    mysqli_close($con);
} else {
    // If request method is not POST, redirect to homepage or handle appropriately
    header("Location: index.php");
    exit();
}
?>
