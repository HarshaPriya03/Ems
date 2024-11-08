<?php
@include 'inc/config.php';
$smonth = isset($_GET['smonth']) ? $_GET['smonth'] : '';

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
if ($user_name === '') {
    header('location:loginpage.php');
    exit();
}

$query = "SELECT * FROM user_form WHERE email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    if ($row && isset($row['user_type']) && isset($row['user_type1'])) {
        $user_type = $row['user_type'];
        $user_type1 = $row['user_type1'];
        $work_location = $row['work_location'];

        if ($user_type1 !== 'admin' && $user_type !== 'user') {
            header('location:loginpage.php');
            exit();
        }
    } else {
        die("Error: Unable to fetch user details.");
    }
} else {
    die("Error: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Statement PDF[1]</title>
    <style>
        .report-no {
            position: absolute;
            right: 10;
            top: -15;
            height: 10px;
        }

        .wrapper {
            display: flex;
            justify-content: space-around !important;
        }

        .missing-wrapper {
            margin-top: -60px;
        }

        table {
            font-size: 15px !important;
        }

        td {
            text-align: center;
        }

        footer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #f2f2f2;
            border-top: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }


        footer b {
            text-align: center !important;
            display: block;
            /* font-family: monospace ; */
            font-size: 15px;
        }
    </style>
</head>
<?php
$currentDateTime = date("Y-m-d H:i:s", strtotime("+5 hours 30 mins"));
$formattedDate = date("Y/m/d", strtotime($currentDateTime));
echo "<p style='font-family: monospace ;font-size:15px;'>Employees Salary Statement generated on: $currentDateTime</p>";
?>

<div style='display:block;margin-left:auto;margin-right:auto;width:110px;'>
    <img alt='logo' src='https://ik.imagekit.io/akkldfjrf/Anika_logo%20(1).jpg?updatedAt=1691746754121' width=100px height=80px>
</div><br>
<header style="text-align:center;color:black !important; ">
    <a class="header" href="" style="Font-size:30px;text-decoration:none !important;">Anika Sterilis Private Limited</a>

    <p style="text-align:center;">Anika ONE, AMTZ Campus,Pragati Maidan,VM Steel Project S.O,Visakhapatnam,Andhra Pradesh-530031</p>
    <p style="text-align:center;">Phone: 0891-5193101 | Email: info@anikasterilis.com | Website: www.anikasterilis.com</p>
</header>
<hr>

<body>
    <div style="display: flex; justify-content: space-between;margin-bottom: 0;">
        <h4 style="text-align:center;border: 1px solid #ccc; flex: 1;width:30%;">
            The data presented in this report is sourced directly from the Payroll Module of our HRMS
        </h4>
        <h3 style="text-align: center;">
            <u>Employee's Salary Statement</u>
        </h3>
        <h4 style="text-align: right;">
            Report No: ASPL/HRMS/Payroll/<?php echo  $formattedDate ?>
        </h4>
    </div>
    <form method="post" action="">
        <table border="1" style="border-color: rgb(170, 170, 170);width:100%;margin-top:-100px;" cellspacing="0">
            <thead style="text-align: center;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="7" style="background:lightyellow;">**Net Payable = (Earnings - Salary Deductibles - Other Deductions) </th>
                    <th colspan="4" style="background:linen;">
                    ***CTC = (Earnings + EmployerContributions) - (SalaryDeductibles + OtherDeductions)
                </th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="3" style="background:lightyellow;">Earnings</th>
                    <th colspan="2" style="background:lightyellow;">Salary Deductibles</th>
                    <th style="background:lightyellow;">Other Deductions</th>
                    <th style="background:lightyellow;">Net Payable</th>
                    <th colspan="3" style="background:linen;">Employer Contribution</th>
                    <th style="background:linen;"></th>
                </tr>
                <tr style="background-color: #363062;color:white;">
                    <th>
                        S No.
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Employee Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                    Work Location
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Basic Pay(Rs.)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        HRA(Rs.)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        OA(Rs.)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        EPF EE(Rs.)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        ESI EE(Rs.)
                    </th>
                    <th scope="col" class="px-6 py-3">
                    Deductions(Rs.)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Net Salary(Rs.)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        EPF ER(Rs.)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        EPF Pension(Rs.)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        ESI ER(Rs.)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        CTC(Rs.)
                    </th>
                </tr>
            </thead>
            <?php
           $cnt = 1;
           $smonth = mysqli_real_escape_string($con, $smonth);
             if ($work_location == 'All') {
          $sql = "
    SELECT p.empname,p.payout,p.bp, p.hra, p.oa,  p.epf1, p.epf2, p.pension,p.gross, p.esi1, p.esi2, e.work_location,e.emp_no, b.sbn, b.sban, b.sifsc, b.epfn, b.uan, b.esin
    FROM payroll_ss_vsp p
    JOIN emp e ON p.empname = e.empname
    JOIN payroll_ban b ON p.empname = b.empname
    WHERE p.salarymonth = '$smonth'
    UNION ALL
    SELECT p.empname,p.payout,p.bp, p.hra, p.oa,  p.epf1, p.epf2, p.pension, p.esi1,p.gross, p.esi2, e.work_location,e.emp_no, b.sbn, b.sban, b.sifsc, b.epfn, b.uan, b.esin
    FROM payroll_ss_ggm p
    JOIN emp e ON p.empname = e.empname
    JOIN payroll_ban b ON p.empname = b.empname
    WHERE p.salarymonth = '$smonth'
    UNION ALL
    SELECT p.empname,p.payout, p.bp, p.hra, p.oa, p.epf1, p.epf2, p.pension, p.esi1,p.gross, p.esi2, e.work_location,e.emp_no, b.sbn, b.sban, b.sifsc, b.epfn, b.uan, b.esin
    FROM payroll_ss_sp p
    JOIN emp e ON p.empname = e.empname
    JOIN payroll_ban b ON p.empname = b.empname
    WHERE p.salarymonth = '$smonth'
      ORDER BY emp_no ASC
";
            } 
            
            elseif ($work_location == 'Visakhapatnam') {
$sql = "
    SELECT p.empname, p.bp, p.hra, p.oa, p.epf1, p.esi1, p.payout, p.emi, p.lopamt, p.tds, p.misc, p.epf2, p.pension, p.esi2, p.gross, e.work_location, e.emp_no
    FROM payroll_ss_vsp p
    JOIN emp e ON p.empname = e.empname
    WHERE p.salarymonth = '$smonth' AND e.work_location = 'Visakhapatnam'
    UNION ALL
    SELECT p.empname, p.bp, p.hra, p.oa, p.epf1, p.esi1, p.payout, p.emi, p.lopamt, p.tds, p.misc, p.epf2, p.pension, p.esi2, p.gross, e.work_location, e.emp_no
    FROM payroll_ss_ggm p
    JOIN emp e ON p.empname = e.empname
    WHERE p.salarymonth = '$smonth' AND e.work_location = 'Visakhapatnam'
    UNION ALL
    SELECT p.empname, p.bp, p.hra, p.oa, p.epf1, p.esi1, p.payout, p.emi, p.lopamt, p.tds, p.misc, p.epf2, p.pension, p.esi2, p.gross, e.work_location, e.emp_no
    FROM payroll_ss_sp p
    JOIN emp e ON p.empname = e.empname
    WHERE p.salarymonth = '$smonth' AND e.work_location = 'Visakhapatnam'
    ORDER BY emp_no ASC
";
   }elseif ($work_location == 'Gurugram') {
$sql = "
    SELECT p.empname, p.bp, p.hra, p.oa, p.epf1, p.esi1, p.payout, p.emi, p.lopamt, p.tds, p.misc, p.epf2, p.pension, p.esi2, p.gross, e.work_location, e.emp_no
    FROM payroll_ss_vsp p
    JOIN emp e ON p.empname = e.empname
    WHERE p.salarymonth = '$smonth' AND e.work_location = 'Gurugram'
    UNION ALL
    SELECT p.empname, p.bp, p.hra, p.oa, p.epf1, p.esi1, p.payout, p.emi, p.lopamt, p.tds, p.misc, p.epf2, p.pension, p.esi2, p.gross, e.work_location, e.emp_no
    FROM payroll_ss_ggm p
    JOIN emp e ON p.empname = e.empname
    WHERE p.salarymonth = '$smonth' AND e.work_location = 'Gurugram'
    UNION ALL
    SELECT p.empname, p.bp, p.hra, p.oa, p.epf1, p.esi1, p.payout, p.emi, p.lopamt, p.tds, p.misc, p.epf2, p.pension, p.esi2, p.gross, e.work_location, e.emp_no
    FROM payroll_ss_sp p
    JOIN emp e ON p.empname = e.empname
    WHERE p.salarymonth = '$smonth' AND e.work_location = 'Gurugram'
    ORDER BY emp_no ASC
";
   }
           $que = mysqli_query($con, $sql);

            if (mysqli_num_rows($que) > 0) {
                while ($result = mysqli_fetch_assoc($que)) {
                    $deduct = $result['emi'] + $result['lopamt'] + $result['tds'] +  $result['misc'];
            ?>
                    <tbody style="text-align: center;">
                        <tr>
                            <td>
                                <?php echo $cnt++; ?>
                            </td>

                            <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                            <td class="px-6 py-4"><?php echo $result['work_location']; ?></td>
                            <td class="px-6 py-4" style="background: rgba(250, 250, 210, 0.5);"><?php echo $result['bp']; ?></td>
                            <td class="px-6 py-4" style="background: rgba(250, 250, 210, 0.5);"><?php echo $result['hra']; ?></td>
                            <td class="px-6 py-4" style="background: rgba(250, 250, 210, 0.5);"><?php echo $result['oa']; ?></td>


                            <td class="px-6 py-4" style="background: rgba(250, 250, 210, 0.5);"><?php echo $result['epf1']; ?></td>
                            <td class="px-6 py-4" style="background: rgba(250, 250, 210, 0.5);"><?php echo $result['esi1']; ?></td>
                            <td class="px-6 py-4" style="background: rgba(250, 250, 210, 0.5);"><?php echo $deduct; ?></td>
                            <td class="px-6 py-4" style="background: rgba(250, 250, 210, 0.5);"><?php echo $result['payout']; ?></td>
                            <td style="background: rgba(250, 240, 230, 0.4);" class="px-6 py-4"><?php echo $result['epf2']; ?></td>
                            <td style="background: rgba(250, 240, 230, 0.4);" class="px-6 py-4"><?php echo $result['pension']; ?></td>
                            <td style="background: rgba(250, 240, 230, 0.4);" class="px-6 py-4"><?php echo $result['esi2']; ?></td>
                            <td style="background: rgba(250, 240, 230, 0.4);" class="px-6 py-4"><?php echo $result['gross']; ?></td>
                        </tr>
                    </tbody>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center">No data</td>
                </tr>
            <?php
            }
            ?>

        </table>
    </form>
    <footer>
        <b>
            This report is generated by the ASPL HRM System and is for informational purposes only. Any discrepancies or errors should be reported to the HR Department for review and correction or to the IT Department for any technical issues.
        </b><br>
        <b>
            Confidential: This report contains proprietary information and is intended for internal use only. Unauthorized distribution or disclosure is prohibited.
        </b>
    </footer>
    <script type="text/php">
        if ( isset($pdf) ) { 
    $pdf->page_script('
        if ($PAGE_COUNT = 1) {
            $font = $fontMetrics->get_font("monospace", "normal");
            $size = 12;
            $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
            $y = 45;
            $x = 1520;
            $pdf->text($x, $y, $pageText, $font, $size);
        } 
    ');
}
</script>
<script type="text/php">
    if (isset($pdf)) {
        // Set opacity for all pages
        $pdf->page_script('
            $font = $fontMetrics->get_font("times", "normal");
            $pdf->set_opacity(0.1); 
            $pdf->text(550, 870, "ASPL HRM", $font, 100);
            $pdf->image("logo.jpg", 550, 870, 0, 0, "JPG", "", true, 150);
            $pdf->set_opacity(1); // Reset opacity to default (1)
        ');
    }
</script>
</body>

</html>