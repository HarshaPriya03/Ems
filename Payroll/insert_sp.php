
<?php
@include 'inc/config.php';

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if all necessary POST variables are set
    if (isset($_POST['empname']) && isset($_POST['ctc']) && isset($_POST['sfper']) && isset($_POST['sfee']) && isset($_POST['service_provider'])) {
        // Sanitize input data
        $empname = array_map(array($con, 'real_escape_string'), $_POST['empname']);
        $ctc = array_map(array($con, 'real_escape_string'), $_POST['ctc']);
        $sfper = array_map(array($con, 'real_escape_string'), $_POST['sfper']);
        $sfee = array_map(array($con, 'real_escape_string'), $_POST['sfee']);
        $service_provider = array_map(array($con, 'real_escape_string'), $_POST['service_provider']);
        

        // Prepare SQL statement and insert data for each row
        for ($i = 0; $i < count($empname); $i++) {
            $sql = "INSERT INTO payroll_sp (empname, ctc, sfper, sfee, service_provider) 
                    VALUES ('{$empname[$i]}', '{$ctc[$i]}', '{$sfper[$i]}', '{$sfee[$i]}', '{$service_provider[$i]}')";

            // Execute SQL statement
            if ($con->query($sql) !== TRUE) {
                // Provide feedback for AJAX request
                $response = array("success" => false, "message" => "Error: " . $sql . "<br>" . $con->error);
                echo json_encode($response);
                exit; // Exit script if an error occurs
            }
        }

        // Provide feedback for AJAX request if all rows inserted successfully
        $response = array("success" => true, "message" => "Data inserted successfully!");
        echo json_encode($response);
    } else {
        // Required form data is missing
        $response = array("success" => false, "message" => "Required form data is missing.");
        echo json_encode($response);
    }
} else {
    // Invalid request method
    $response = array("success" => false, "message" => "Invalid request method.");
    echo json_encode($response);
}

// Close connection
$con->close();
?>

