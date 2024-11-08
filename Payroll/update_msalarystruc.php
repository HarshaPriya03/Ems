<?php
@include 'inc/config.php';

// Check if the connection to MySQL is successful
if (mysqli_connect_errno()) {
    echo json_encode(array('error' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
    exit();
}

// Check if all required parameters are provided and empname is passed
if (isset($_POST['empname'], $_POST['bp'], $_POST['hra'], $_POST['oa'], $_POST['epf1'], $_POST['esi1'], $_POST['esi2'], $_POST['epf2'], $_POST['epf3'], $_POST['netpay'], $_POST['ctc'], $_POST['tde'], $_POST['tes'])) {
    // Sanitize input data to prevent SQL injection
    $empname = mysqli_real_escape_string($con, $_POST['empname']);
    $bp = mysqli_real_escape_string($con, $_POST['bp']);
    $hra = mysqli_real_escape_string($con, $_POST['hra']);
    $oa = mysqli_real_escape_string($con, $_POST['oa']);
    $epf1 = mysqli_real_escape_string($con, $_POST['epf1']);
    $esi1 = mysqli_real_escape_string($con, $_POST['esi1']);
    $esi2 = mysqli_real_escape_string($con, $_POST['esi2']);
    $epf2 = mysqli_real_escape_string($con, $_POST['epf2']);
    $epf3 = mysqli_real_escape_string($con, $_POST['epf3']);
    $netpay = mysqli_real_escape_string($con, $_POST['netpay']);
    $ctc = mysqli_real_escape_string($con, $_POST['ctc']);
    $tde = mysqli_real_escape_string($con, $_POST['tde']);
    $tes = mysqli_real_escape_string($con, $_POST['tes']);


    // Get the current timestamp for the 'created' field
    $created = date('Y-m-d H:i:s');

    // Prepare and execute the SQL query to update the record
    $stmt = $con->prepare("UPDATE payroll_msalarystruc SET  bp=?, hra=?, oa=?, epf1=?, esi1=?, esi2=?, epf2=?, epf3=?, netpay=?, ctc=?, tde=?, tes=?, created=? WHERE empname=?");
    $stmt->bind_param("ssssssssssssss", $bp, $hra, $oa, $epf1, $esi1, $esi2, $epf2, $epf3, $netpay, $ctc, $tde, $tes, $created, $empname);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo json_encode(array('success' => 'Record updated successfully'));
    } else {
        // Debug: Output SQL execution error
        echo json_encode(array('error' => 'SQL execution error: ' . $stmt->error));
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // If any required parameter is missing, return an error message
    echo json_encode(array('error' => 'Missing parameters'));
}

// Close the database connection
mysqli_close($con);
?>
