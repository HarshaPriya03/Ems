<?php
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

// Sanitize input data
$empname = array_map(array($conn, 'real_escape_string'), $_POST['empname']);
$emp_no = array_map(array($conn, 'real_escape_string'), $_POST['emp_no']);
$desg = array_map(array($conn, 'real_escape_string'), $_POST['desg']);
$dept = array_map(array($conn, 'real_escape_string'), $_POST['dept']);
$salarymonth = array_map(array($conn, 'real_escape_string'), $_POST['salarymonth']);
$fbp = array_map(array($conn, 'real_escape_string'), $_POST['fbp']);
$fhra = array_map(array($conn, 'real_escape_string'), $_POST['fhra']);
$foa = array_map(array($conn, 'real_escape_string'), $_POST['foa']);
$fgs = array_map(array($conn, 'real_escape_string'), $_POST['fgs']);
$monthdays = array_map(array($conn, 'real_escape_string'), $_POST['monthdays']);
$present = array_map(array($conn, 'real_escape_string'), $_POST['present']);
$leaves = array_map(array($conn, 'real_escape_string'), $_POST['leaves']);
$sundays = array_map(array($conn, 'real_escape_string'), $_POST['sundays']);
$holidays = array_map(array($conn, 'real_escape_string'), $_POST['holidays']);
$flop = array_map(array($conn, 'real_escape_string'), $_POST['flop']);
$paydays = array_map(array($conn, 'real_escape_string'), $_POST['paydays']);
$bp = array_map(array($conn, 'real_escape_string'), $_POST['bp']);
$hra = array_map(array($conn, 'real_escape_string'), $_POST['hra']);
$oa = array_map(array($conn, 'real_escape_string'), $_POST['oa']);
$gross = array_map(array($conn, 'real_escape_string'), $_POST['gross']);
$epf1 = array_map(array($conn, 'real_escape_string'), $_POST['epf1']);
$esi1 = array_map(array($conn, 'real_escape_string'), $_POST['esi1']);
$tds = array_map(array($conn, 'real_escape_string'), $_POST['tds']);
$emi = array_map(array($conn, 'real_escape_string'), $_POST['emi']);
$lopamt = array_map(array($conn, 'real_escape_string'), $_POST['lopamt']);
$totaldeduct = array_map(array($conn, 'real_escape_string'), $_POST['totaldeduct']);
$payout = array_map(array($conn, 'real_escape_string'), $_POST['payout']);
$misc = array_map(array($conn, 'real_escape_string'), $_POST['misc']);
$bonus = array_map(array($conn, 'real_escape_string'), $_POST['bonus']);

$created = date('Y-m-d H:i:s');

for ($i = 0; $i < count($empname); $i++) {
    $epf1 = floatval($_POST['epf1'][$i]);
    $epf2 = $epf1 * 0.694;
    $pension = $epf1 * 0.306;
    if ($esi1[$i] === "0" || $esi1[$i] === NULL) {
        $esi2 = 0;
    } else {
        if ($gross[$i] < 21000) {
            $esi2 = $gross[$i] * 0.0325;
        } else {
            $esi2 = 0;
        }
    }

    $sql = "INSERT INTO payroll_ss (empname,emp_no,desg,dept,salarymonth, fbp, fhra, foa, fgs, monthdays, present, leaves, sundays, holidays, flop, paydays, bp, hra, oa, gross, epf1, epf2, pension, esi1,esi2, tds, emi, lopamt, totaldeduct, payout, misc, bonus, created, status) 
    VALUES ('{$empname[$i]}', '{$emp_no[$i]}', '{$desg[$i]}','{$dept[$i]}',  '{$salarymonth[$i]}', '{$fbp[$i]}', '{$fhra[$i]}', '{$foa[$i]}', '{$fgs[$i]}', '{$monthdays[$i]}', '{$present[$i]}', '{$leaves[$i]}', '{$sundays[$i]}','{$holidays[$i]}', '{$flop[$i]}', '{$paydays[$i]}', '{$bp[$i]}', '{$hra[$i]}', '{$oa[$i]}', '{$gross[$i]}', '{$epf1}', '{$epf2}', '{$pension}', '{$esi1[$i]}','{$esi2}', '{$tds[$i]}', '{$emi[$i]}', '{$lopamt[$i]}', '{$totaldeduct[$i]}', '{$payout[$i]}', '{$misc[$i]}', '{$bonus[$i]}', NOW(), '0')";

// Execute SQL statement
if ($conn->query($sql) !== TRUE) {
// Provide feedback for AJAX request
$response = array("success" => false, "message" => "Error: " . $sql . "<br>" . $conn->error);
echo json_encode($response);
exit; // Exit script if an error occurs
}
}

// Provide feedback for AJAX request if all rows inserted successfully
$response = array("success" => true, "message" => "Data submitted successfully!");
echo json_encode($response);

// Close connection
$conn->close();
?>
