<?php
include 'inc/config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Perform the deletion
    $deleteQuery = "DELETE FROM leavetype WHERE id = $id";

    if (mysqli_query($con, $deleteQuery)) {
        // Deletion successful
        header("Location: leave-type.php"); // Redirect back to the page with the table
        exit();
    } else {
        // Deletion failed
        echo "Error deleting record: " . mysqli_error($con);
    }
} else {
    // ID not provided or not numeric
    echo "Invalid request.";
}

// Close the database connection
mysqli_close($con);
?>
