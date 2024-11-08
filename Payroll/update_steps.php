<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the status and smonth are set and not empty
    if (isset($_POST['status']) && isset($_POST['smonth']) && !empty($_POST['status']) && !empty($_POST['smonth'])) {
        // Get the status and smonth values from the form
        $status = $_POST['status'];
        $smonth = $_POST['smonth'];

        // Replace 'your_database_credentials' with your actual database credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ems";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $created = date('Y-m-d H:i:s');
        // SQL query to update the status in the database where smonth matches the submitted value
        $sql = "UPDATE payroll_schedule SET status = '$status', created = '$created' WHERE smonth = '$smonth'";

        if ($conn->query($sql) === TRUE) {
            // If the query is successful, echo a success message
            echo " updated successfully";
        } else {
            // If there is an error with the query, echo the error message
            echo "Error updating status: " . $conn->error;
        }

        // Close the database connection
        $conn->close();
    } else {
        // If the status or smonth is not set or empty, echo an error message
        echo "Status or smonth is not set or empty";
    }
} else {
    // If the request method is not POST, echo an error message
    echo "Invalid request method";
}
?>
