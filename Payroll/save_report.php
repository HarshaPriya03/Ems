<?php
// Establishing a database connection
$con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");

// Check the connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize response array
    $response = array();

    // Retrieve form data
    $empname = $_POST['empname'];
    $report = $_POST['report'];

    // Perform validation (you can add more validation rules as needed)
    if (empty($empname) || empty($report)) {
        // If any required field is empty, return an error response
        $response['success'] = false;
        $response['message'] = 'Please fill in all required fields.';
    } else {
        // Prepare and execute SQL query to update payroll_ss table
        $sql = "UPDATE payroll_ss SET report = ? , status1 = 2 WHERE empname = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $report, $empname);

        if ($stmt->execute()) {
            // If the query is successful, return a success response
            $response['success'] = true;
            $response['message'] = 'Report saved successfully.';
        } else {
            // If there's an error executing the query, return an error response
            $response['success'] = false;
            $response['message'] = 'Error saving report. Please try again later.';
        }

        // Close statement
        $stmt->close();
    }

    // Output JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If the request method is not POST, return an error response
    $response['success'] = false;
    $response['message'] = 'Invalid request method.';
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Close database connection
mysqli_close($con);
?>
