<?php
// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the transid and salarymonth parameters are set
    if (isset($_POST["transid"]) && isset($_POST["salarymonth"])) {
        // Retrieve the transid and salarymonth values from the POST data
        $transid = $_POST["transid"];
        $salarymonth = $_POST["salarymonth"];

        // Database connection parameters
        $servername = "localhost";
        $username = "Anika12";
        $password = "Anika12";
        $dbname = "ems";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL statement to update the payroll_ss table
        $sql = "UPDATE payroll_ss_sp SET transid = ? WHERE salarymonth = ?";
        
        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $transid, $salarymonth);

        // Execute the statement
        if ($stmt->execute()) {
            // If the update was successful, return a success message
            echo json_encode(["success" => true, "message" => "Transaction ID updated successfully"]);
        } else {
            // If there was an error, return an error message
            echo json_encode(["success" => false, "message" => "Error updating Transaction ID: " . $conn->error]);
        }

        // Close statement and database connection
        $stmt->close();
        $conn->close();
    } else {
        // If transid or salarymonth is not set, return an error message
        echo json_encode(["success" => false, "message" => "Transid and salarymonth parameters are required"]);
    }
} else {
    // If the request method is not POST, return an error message
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}
?>
