<?php
// Check if the empname parameter is provided in the GET request
$smonth = isset($_GET['smonth']) ? $_GET['smonth'] : '';
if(isset($_GET['empname'])) {
    // Establish a connection to the database
    @include 'inc/config.php';

    // Check if the connection was successful
    if ($con) {
        // Sanitize the empname parameter to prevent SQL injection
        $empname = mysqli_real_escape_string($con, $_GET['empname']);

        // Prepare the SQL queries to check which table contains the empname
        $sql_vsp = "SELECT empname FROM payroll_ss_vsp WHERE empname = '$empname' AND salarymonth = '$smonth'";
        $sql_ggm = "SELECT empname FROM payroll_ss_ggm WHERE empname = '$empname' AND salarymonth = '$smonth'";
        $sql_sp = "SELECT empname FROM payroll_ss_sp WHERE empname = '$empname' AND salarymonth = '$smonth'";

        // Initialize the final query
        $sql = "";

        // Check each table and set the appropriate query
        $result_vsp = mysqli_query($con, $sql_vsp);
        if (mysqli_num_rows($result_vsp) > 0) {
            $sql = "SELECT *
                    FROM payroll_ss_vsp
                    WHERE empname = '$empname' AND salarymonth = '$smonth'";
        } else {
            $result_ggm = mysqli_query($con, $sql_ggm);
            if (mysqli_num_rows($result_ggm) > 0) {
                $sql = "SELECT *
                        FROM payroll_ss_ggm
                        WHERE empname = '$empname' AND salarymonth = '$smonth'";
            } else {
                $result_sp = mysqli_query($con, $sql_sp);
                if (mysqli_num_rows($result_sp) > 0) {
                    $sql = "SELECT *
                            FROM payroll_ss_sp
                            WHERE empname = '$empname' AND salarymonth = '$smonth'";
                } else {
                    // empname does not exist in any of the tables
                    echo json_encode(['error' => 'No data found']);
                    exit;
                }
            }
        }

        // Execute the final query
        if (!empty($sql)) {
            $result = mysqli_query($con, $sql);

            // Check if any rows were returned
            if ($result) {
                // Check if at least one row was found
                if (mysqli_num_rows($result) > 0) {
                    // Fetch the data from the result set
                    $data = mysqli_fetch_assoc($result);
                    // Output the data as JSON
                    echo json_encode($data);
                } else {
                    // No data found for the provided empname
                    echo json_encode(['error' => 'No data found']);
                }
            } else {
                // Error executing the query
                echo json_encode(['error' => 'Query execution error: ' . mysqli_error($con)]);
            }
        }

        // Close the database connection
        mysqli_close($con);
    } else {
        // Error establishing connection
        echo json_encode(['error' => 'Database connection error']);
    }
} else {
    // empname parameter not provided in the GET request
    echo json_encode(['error' => 'empname parameter is missing']);
}
?>
