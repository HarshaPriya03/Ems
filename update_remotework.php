<?php
include 'inc/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST['id'];

    // Sanitize inputs to prevent SQL injection
    $id = mysqli_real_escape_string($con, $id);

    // Update query
    $sql = "UPDATE remotework 
            SET 
                status = '2'
            WHERE id = '$id'";

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