<?php
@include 'inc/config.php';

// Check if the connection to MySQL is successful
if (mysqli_connect_errno()) {
    $error = 'Failed to connect to MySQL: ' . mysqli_connect_error();
    echo json_encode(array('error' => $error));
    exit();
}

// Check if the 'empname' parameter is provided and not empty
if (isset($_GET['empname']) && !empty($_GET['empname'])) {
    $empname = $_GET['empname'];

    // Prepare and execute the SQL query to fetch employee details
    $stmt = $con->prepare("SELECT emp_no, desg, dept, hra, oa, epf1, esi1, epf2, esi2, bp, epf3, netpay, ctc, tde, tes FROM payroll_msalarystruc WHERE empname = ?");
    $stmt->bind_param("s", $empname);
    $stmt->execute();
    $stmt->bind_result($emp_no, $desg, $dept, $hra, $oa, $epf1, $esi1, $epf2, $esi2, $bp, $epf3, $netpay, $ctc, $tde, $tes);

    // Fetch the result and store it in an associative array
    $stmt->fetch();
    $stmt->close();

    // Create an associative array with the fetched employee details
    $result = array(
        'emp_no' => $emp_no,
        'desg' => $desg,
        'dept' => $dept,
        'hra' => $hra,
        'oa' => $oa,
        'epf1' => $epf1,
        'esi1' => $esi1,
        'epf2' => $epf2,
        'esi2' => $esi2,
        'bp' => $bp,
        'epf3' => $epf3,
        'netpay' => $netpay,
        'ctc' => $ctc,
        'tde' => $tde,
        'tes' => $tes
    );

    // Encode the array as JSON and echo it
    echo json_encode($result);
} else {
    // If 'empname' parameter is missing or empty, return an error message as JSON
    echo json_encode(array('error' => 'empname is missing'));
}

// Close the database connection
mysqli_close($con);
?>
