<?php
include 'inc/config.php'; // Adjust path as per your file structure

// Check if POST data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs (you should perform more validation as per your requirements)
    $empname = mysqli_real_escape_string($con, $_POST['empname']);
    $post_id = mysqli_real_escape_string($con, $_POST['post_id']);

    // Update query to set status = 0 where empname and post_id match
    $sql = "UPDATE aKonnect_likes SET status = 0 WHERE empname = '$empname' AND post_id = '$post_id'";

    if ($con->query($sql) === TRUE) {
        echo "Like status updated successfully.";
    } else {
        echo "Error updating like status: " . $con->error;
    }
} else {
    echo "Invalid request method.";
}

$con->close();
?>
