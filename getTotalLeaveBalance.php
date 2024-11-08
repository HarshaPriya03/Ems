<?php
// Database connection parameters
$servername = "localhost";
$username = "Anika12";
$password = "Anika12";
$dbname = "ems";

// Establishing connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieving employee email from the GET request
$empEmail = $_GET['empemail'];

// Query to retrieve the total leave balance for the employee
$sql = "SELECT SUM(cl) AS cl_total, SUM(sl) AS sl_total, SUM(co) AS co_total FROM leavebalance WHERE empemail = '$empEmail'";
$result = $conn->query($sql);

// Check if the query was successful
if ($result->num_rows > 0) {
    // Fetching the row
    $row = $result->fetch_assoc();

    // Calculating the total leave balance
    $totalLeaveBalance = $row['cl_total'] + $row['sl_total'] + $row['co_total'];

    // Returning the total leave balance as response
    echo $totalLeaveBalance;
} else {
    // If no records were found, return 0
    echo 0;
}

// Closing the database connection
$conn->close();
?>
