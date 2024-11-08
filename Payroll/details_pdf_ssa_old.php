<?php
@include 'inc/config.php';
$smonth = isset($_GET['smonth']) ? $_GET['smonth'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Statement PDF[2]</title>
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
                    <th colspan="4" style="background:rgba(250, 250, 210, 0.5);text-align:center;">Net Salary & Bank Details</th>
                    <th colspan="5" style="background:#FFF5E0;">EPF & EPF A/C Details</th>
                    <th colspan="3" style="background:linen;">ESI & ESI A/C Details</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th style="background:rgba(250, 250, 210, 0.5);">Net Payable</th>
                    <th colspan="3" style="background:rgba(250, 250, 210, 0.5);">Bank Details</th>
                    <th colspan="3" style="background:#FFF5E0;">EPF Amount</th>
                    <th colspan="2" style="background:#FFF5E0;">EPF A/C Details</th>
                    <th colspan="2" style="background:linen;">ESI Amount</th>
                    <th colspan="1" style="background:linen;">ESI A/C Details</th>
                </tr>
                <tr style="background-color: #363062;color:white;">
                    <th>
                        S No.
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Employee Name
                    </th>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Net Salary(Rs.)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Employee Bank Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Employee Bank A/C No.
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Employee Bank IFSC
                    </th>
                    <th scope="col" class="px-6 py-3">
                        EPF EE(Rs.)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        EPF ER(Rs.)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        EPF Pension(Rs.)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        PF A/C No.
                    </th>
                    <th scope="col" class="px-6 py-3">
                        UAN
                    </th>
                    <th scope="col" class="px-6 py-3">
                        ESI EE(Rs.)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        ESI ER(Rs.)
                    </th>
                    <th scope="col" class="px-6 py-3">
                        ESI No.
                    </th>
                </tr>
            </thead>
            <?php
            $cnt = 1;
            $currentMonthYear = $smonth;
            $sql = "SELECT payroll_ss.*, emp.*, payroll_ban.*
        FROM payroll_ss
        LEFT JOIN emp ON payroll_ss.empname = emp.empname
        LEFT JOIN payroll_ban ON payroll_ss.empname = payroll_ban.empname
        WHERE payroll_ss.salarymonth = '$currentMonthYear' 
        AND payroll_ss.epf1 != 0
        ORDER BY payroll_ss.id ASC";


            $que = mysqli_query($con, $sql);

            if (mysqli_num_rows($que) > 0) {
                while ($result = mysqli_fetch_assoc($que)) {
            ?>
                    <tbody style="text-align: center;">
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td style="background:#F6F5F2;">
                                <?php echo $cnt++; ?>
                            </td>

                            <td class="px-6 py-4" style="background:#F6F5F2;"><?php echo $result['empname']; ?></td>
                            <td class="px-6 py-4" style="background: rgba(250, 250, 210, 0.5);"><?php echo $result['payout']; ?></td>
                            <td style="background: rgba(250, 250, 210, 0.5);"><?php echo $result['sbn']; ?></td>
                            <td style="background: rgba(250, 250, 210, 0.5);"><?php echo $result['sban']; ?></td>
                            <td style="background: rgba(250, 250, 210, 0.5);"><?php echo $result['sifsc']; ?></td>
                            <td style="background: #FFF5E0;" class="px-6 py-4"><?php echo $result['epf1']; ?></td>
                            <td style="background: #FFF5E0;" class="px-6 py-4"><?php echo $result['epf2']; ?></td>
                            <td style="background: #FFF5E0;" class="px-6 py-4"><?php echo $result['pension']; ?></td>
                            <td style="background: #FFF5E0;"><?php echo $result['epfn']; ?></td>
                            <td style="background: #FFF5E0;"><?php echo $result['uan']; ?></td>
                            <td style="background: rgba(250, 240, 230, 0.4);" class="px-6 py-4"><?php echo $result['esi1']; ?></td>
                            <td style="background: rgba(250, 240, 230, 0.4);" class="px-6 py-4"><?php echo $result['esi2']; ?></td>
                            <td style="background: rgba(250, 240, 230, 0.4);"><?php echo $result['esin']; ?></td>
                        </tr>
                    </tbody>
                <?php
                }
            } else {
                ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
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
            $pdf->set_opacity(0.1); // Set opacity to 50%
            $pdf->text(550, 870, "ASPL HRM", $font, 100);
            $pdf->image("logo.jpg", 550, 870, 0, 0, "JPG", "", true, 150);
            $pdf->set_opacity(1); // Reset opacity to default (1)
        ');
    }
</script>
</body>

</html>