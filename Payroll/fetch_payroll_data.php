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

// Fetch data
$sql = "
    SELECT 
        salarymonth,
        SUM(total_payout) AS total_payout
    FROM (
        SELECT 
            SUBSTRING_INDEX(salarymonth, ' ', -1) AS year,
            STR_TO_DATE(CONCAT('01 ', salarymonth), '%d %M %Y') AS salarymonth,
            payout AS total_payout 
        FROM payroll_ss_vsp
        UNION ALL
        SELECT 
            SUBSTRING_INDEX(salarymonth, ' ', -1) AS year,
            STR_TO_DATE(CONCAT('01 ', salarymonth), '%d %M %Y') AS salarymonth,
            payout AS total_payout 
        FROM payroll_ss_sp
        UNION ALL
        SELECT 
            SUBSTRING_INDEX(salarymonth, ' ', -1) AS year,
            STR_TO_DATE(CONCAT('01 ', salarymonth), '%d %M %Y') AS salarymonth,
            payout AS total_payout 
        FROM payroll_ss_ggm
        UNION ALL
        SELECT 
            SUBSTRING_INDEX(salarymonth, ' ', -1) AS year,
            STR_TO_DATE(CONCAT('01 ', salarymonth), '%d %M %Y') AS salarymonth,
            payout AS total_payout 
        FROM payroll_ss
    ) AS combined
    GROUP BY salarymonth
    ORDER BY year, salarymonth";


$result = $conn->query($sql);

$months = [];
$payouts = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $months[] = $row['salarymonth'];
        $payouts[] = $row['total_payout'];
    }
} else {
    echo "0 results";
}
$conn->close();

// Output data as JavaScript arrays
echo "const months = " . json_encode($months) . ";";
echo "const payouts = " . json_encode($payouts) . ";";
