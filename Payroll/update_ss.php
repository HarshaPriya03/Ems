<?php
// Clean the output buffer
ob_clean();

$con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");

// Check for connection errors
if (mysqli_connect_errno()) {
    $response = array("error" => "Failed to connect to MySQL: " . mysqli_connect_error());
} else {
    // Function to update status in the database
    function updateStatus($id, $con) {
        $id = mysqli_real_escape_string($con, $id);
        $response = array();

        $sql = "UPDATE payroll_ss SET status = 1 WHERE id = '$id'";
        
        // Execute the SQL query
        if (mysqli_query($con, $sql)) {
            $response['success'] = true;
            
            // Fetch next ID
            $nextQuery = "SELECT id FROM payroll_ss WHERE status = 0 LIMIT 1";
            $nextResult = mysqli_query($con, $nextQuery);
            
            // Check if next ID fetched successfully
            if ($nextResult) {
                $nextData = mysqli_fetch_assoc($nextResult);
                
                // Check if next ID exists
                if ($nextData) {
                    $response['next_id'] = $nextData['id'];
                } else {
                    $response['next_id'] = 'no_data';
                }
            } else {
                $response["error"] = "Error fetching next ID: " . mysqli_error($con);
            }
        } else {
            $response["error"] = "Error updating status: " . mysqli_error($con);
        }

        return $response;
    }

    // Check if ID parameter is provided
    if (isset($_POST['id'])) {
        // Call the updateStatus function with provided ID
        $response = updateStatus($_POST['id'], $con);
    } else {
        $response = array("error" => "ID parameter not found");
    }
}

// Close the database connection
mysqli_close($con);

// Set proper HTTP header for JSON response
header('Content-Type: application/json');

// Output response as JSON
echo json_encode($response, JSON_UNESCAPED_UNICODE);

// Exit the script to prevent any further output
exit;
?>
