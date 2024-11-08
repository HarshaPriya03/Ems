<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the approval and smonth are set and not empty
    if (isset($_POST['approval']) && isset($_POST['smonth']) && !empty($_POST['approval']) && !empty($_POST['smonth'])) {
        // Get the approval and smonth values from the form
        $approval = $_POST['approval'];
        $smonth = $_POST['smonth'];
        $notify = isset($_POST['notify']) && !empty($_POST['notify']) ? $_POST['notify'] : 'No';
        $paid = $_POST['paid'];
        $count = isset($_POST['count']) ? $_POST['count'] : '0';
        // Replace 'your_database_credentials' with your actual database credentials
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
        $created = date('Y-m-d H:i:s');
        // SQL query to update the approval in the database where smonth matches the submitted value
        $sql = "UPDATE payroll_schedule SET approval = '$approval', notify = '$notify', paid = '$paid', paid_emp = '$count', created = '$created' WHERE smonth = '$smonth'";

        if ($conn->query($sql) === TRUE) {
            // If the query is successful, echo a success message
            echo " updated successfully";
        } else {
            // If there is an error with the query, echo the error message
            echo "Error updating approval: " . $conn->error;
        }

        // Close the database connection
        $conn->close();
    } else {
        // If the approval or smonth is not set or empty, echo an error message
        echo "approval or smonth is not set or empty";
    }
} else {
    // If the request method is not POST, echo an error message
    echo "Invalid request method";
}
?>
