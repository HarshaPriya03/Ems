<?php
// Include your database connection file
$con = mysqli_connect("localhost", "root", "", "ems");

// Check if the employee's name is received via AJAX
if (isset($_GET['empname'])) {
    // Retrieve the employee's name from the AJAX request
    $empname = $_GET['empname'];

    // Query to retrieve the employee's designations and work location from the database
    $designation_query = "SELECT work_location, desg FROM emp WHERE empname = '$empname'";
    $designation_result = mysqli_query($con, $designation_query);

    if ($designation_result) {
        // Fetch the employee's designations and work location from the result set
        $desgs = array();
        $work_location = '';
        while ($row = mysqli_fetch_assoc($designation_result)) {
            // Extract individual designations from the string and add them to the array
            $individual_desgs = array_map('trim', explode(',', $row['desg']));
            $desgs = array_merge($desgs, $individual_desgs);
            $work_location = $row['work_location'];
        }

        // Implode the employee's multiple designations into a comma-separated string
        $desgs_string = implode(', ', $desgs);

        // Construct the WHERE clause to search for any of the manager's designations matching any of the employee's designations
        $where_clause = "";
        foreach ($desgs as $designation) {
            $where_clause .= " OR manager.desg LIKE '%$designation%'";
        }
        // Remove the leading 'OR'
        $where_clause = substr($where_clause, 4);

        // Query to fetch the manager's name based on the employee's designations and work location
        $manager_query = "SELECT manager.empname
                          FROM manager 
                          WHERE ($where_clause) AND manager.work_location = '$work_location'";

        // Execute the query
        $manager_result = mysqli_query($con, $manager_query);

        if ($manager_result) {
            // Check if there are any rows returned
            if (mysqli_num_rows($manager_result) > 0) {
                // Fetch the manager's name from the result set
                $row = mysqli_fetch_assoc($manager_result);
                $manager_name = $row['empname'];

                // Return the manager's name as the response
                echo $manager_name;
            } else {
                // Debugging: Log no manager found

                // No manager found for the given employee
                echo "No manager found";
            }
        } else {
            // Debugging: Log query execution error

            // Error in executing the query
            echo "Error: " . mysqli_error($con);
        }
    } else {
        // Debugging: Log designation query execution error

        // Error in executing the designation query
        echo "Error: " . mysqli_error($con);
    }
} else {
    // Debugging: Log missing employee name

    // Employee's name not received via AJAX
    echo "Employee's name not provided";
}
?>
