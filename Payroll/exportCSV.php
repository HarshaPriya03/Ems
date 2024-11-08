<?php
$con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");

$currentMonth = date('F Y');
$nextMonth = date('F Y', strtotime('+1 month'));
$query = mysqli_query($con, "SELECT emp.pic, p.*, 
               COALESCE(e.emi, 0) AS emi,
               COALESCE(e.emimonth, '$nextMonth') AS emimonth
        FROM payroll_msalarystruc AS p
        LEFT JOIN emp ON emp.empname = p.empname
        LEFT JOIN (SELECT empname, emi, emimonth
                   FROM payroll_emi
                   WHERE emimonth = '$nextMonth') AS e 
                   ON p.empname = e.empname ORDER BY p.empname ASC");

if(mysqli_num_rows($query) > 0) {
    $delimiter = ",";
    $filename = "payroll_data_" . date('Y-m-d') . ".csv";

    $f = fopen('php://memory', 'w');

    $fields = array('Emp Name', 'Gross salary', 'Loan Deductables', 'Lop', 'EPF', 'ESI', 'Net Salary');
    fputcsv($f, $fields, $delimiter);
    while($row = mysqli_fetch_assoc($query)) {
        $pay = $row['netpay'] - $row['emi'];
        $lineData = array(
            $row['empname'],
            $row['ctc'],
            $row['emi'],
            '0', 
            $row['epf1'],
            $row['esi1'],
            $pay
        );
        fputcsv($f, $lineData, $delimiter);
    }

    fseek($f, 0);

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    fpassthru($f);
    exit;
}
?>
