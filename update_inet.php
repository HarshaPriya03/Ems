<?php
// Include the database connection configuration
include 'inc/config.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'id' and 'status' parameters are set in the POST data
    if (isset($_POST['id']) && isset($_POST['status']) && isset($_POST['email'])) {
        // Sanitize and store the POST data
        $id = mysqli_real_escape_string($con, $_POST['id']);
        $status = mysqli_real_escape_string($con, $_POST['status']);
        $email = mysqli_real_escape_string($con, $_POST['email']);

        // Update the status of the row in the database
        $sql = "UPDATE inet_access SET status = '$status', action = '$email' WHERE ID = '$id'";
        $result = mysqli_query($con, $sql);

        // Check if the query was successful
        if ($result) {
            // Return a success message (optional)
            echo "Status updated successfully.";
        } else {
            // Return an error message (optional)
            echo "Error updating status: " . mysqli_error($con);
        }
    } else {
        // Return an error message if 'id' or 'status' parameters are not set
        echo "Error: 'id' and 'status' parameters are required.";
    }
} else {
    // Return an error message if the request method is not POST
    echo "Error: Only POST requests are allowed.";
}
?>
