<?php
$con = new mysqli("localhost", "root", "", "ems");

if(isset($_POST['id']) && isset($_POST['score'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $score = mysqli_real_escape_string($con, $_POST['score']);

    // Prepare the SQL statement
    $sql = "UPDATE remotework_emp SET status = 1, score = ? WHERE id = ? AND status = 0";
    
    // Prepare and bind
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ii", $score, $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error updating record: " . $con->error;
    }

    // Close statement
    $stmt->close();
} else {
    echo "Invalid data received";
}

// Close connection
$con->close();
?>