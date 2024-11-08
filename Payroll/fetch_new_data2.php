<?php
// Database connection
$con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");

// Check if the ID is received through POST
if(isset($_POST['id'])) {
    // Sanitize the received ID
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $created = date('Y-m-d H:i:s');
    // Update status to 1 for the given ID
    $sql = "UPDATE payroll_ss SET status1 = 2, confirm2 = '$created' WHERE id = '$id'";
    if(mysqli_query($con, $sql)) {
        // Status updated successfully
        // Fetch the next available data
        $query = "SELECT * FROM payroll_ss WHERE status1 = 0 OR status1 = 1 LIMIT 1";
        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $nextData = mysqli_fetch_assoc($result);
            echo json_encode($nextData); // Output next available data as JSON
        } else {
            echo json_encode(false); // No more data available
        }
    } else {
        echo json_encode(false); // Failed to update status
    }
} else {
    // ID not received, fetch data with status 0 for initial modal opening
    $query = "SELECT * FROM payroll_ss WHERE status1 = 0 LIMIT 1";
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $initialData = mysqli_fetch_assoc($result);
        echo json_encode($initialData); // Output initial data as JSON
    } else {
        echo json_encode(false); // No initial data with status 0 found
    }
}
?>
