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

// Check if data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if at least one checkbox is checked
    if (isset($_POST['confirm']) && is_array($_POST['confirm']) && count($_POST['confirm']) > 0) {
        // Prepare and bind the statement
        $created = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO payroll_statement (emp_name, gross_salary, loan_deductables, lop, epf, esi, net_salary, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $emp_name, $gross_salary, $loan_deductables, $lop, $epf, $esi, $net_salary, $created);

        // Set parameters and execute for each checked row
        foreach ($_POST['confirm'] as $empname) {
            $emp_name = $empname;
            $gross_salary = $_POST['gross_salary'][$empname];
            $loan_deductables = $_POST['loan_deductables'][$empname];
            $lop = $_POST['lop'][$empname];
            $epf = $_POST['epf'][$empname];
            $esi = $_POST['esi'][$empname];
            $net_salary = $_POST['net_salary'][$empname];
            $stmt->execute();
        }

        // Close statement
        $stmt->close();

        echo "Payroll statements inserted successfully.";
    } else {
        echo "No payroll statements selected.";
    }
}

// Close connection
$conn->close();
