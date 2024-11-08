<?php
$con = new mysqli("localhost", "root", "", "ems");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Sanitize inputs to prevent SQL injection
    $id = mysqli_real_escape_string($con, $id);

    // Update query
    $sql = "UPDATE remotework 
            SET 
                status = '2'
            WHERE id = '$id'  AND status1 = '2' ";

    if (mysqli_query($con, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }

    mysqli_close($con);
} else {
    echo "Invalid request method";
}
?>
