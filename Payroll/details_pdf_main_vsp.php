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
    <title>Salary Statement - <?php echo $smonth; ?></title>
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
             margin-left: -40px !important;
            font-size: 16.7px !important;
        }

        tr th {
            text-transform: uppercase;
            padding: 20px;
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
            padding: 0px;
            text-align: center;
            font-size: 40px !important;
        }


        footer b {
            text-align: center !important;
            display: block;
            /* font-family: monospace ; */
            font-size: 15px;
        }
                  .data td:nth-child(3),
          .data td:nth-child(7),
       .data td:nth-child(8),
       .data td:nth-child(9),
       .data td:nth-child(10),
       .data td:nth-child(17),
       .data td:nth-child(18),
       .data td:nth-child(19),
       .data td:nth-child(20),
       .data td:nth-child(21), 
       .data td:nth-child(22),
       .data td:nth-child(23),
       .data td:nth-child(26),
       .data td:nth-child(27),
       .data td:nth-child(28),
       .data td:nth-child(29),
       .data td:nth-child(30),
       .data td:nth-child(32){
            font-size:28px !important;
            
        }
        .data th{
            font-size:28px !important;
        }
        .data1 th{
            font-size:17px !important;
        }
    </style>
</head>
<?php
$currentDateTime = date("Y-m-d H:i:s", strtotime("+5 hours 30 mins"));
$formattedDate = date("Y/m/d", strtotime($currentDateTime));
echo "<p style='font-family: monospace ;font-size:30px;'>Salary Statement generated on: $currentDateTime</p>";
?>

<div style='display:block;margin-left:auto;margin-right:auto;width:180px;'>
    <img alt='logo' src='https://ik.imagekit.io/akkldfjrf/Anika_logo%20(1).jpg?updatedAt=1691746754121' width=180px height=140px>
</div><br>
<header style="font-size:30px;text-align:center;color:black !important; ">
    <a class="header" href="" style="font-size:35px;text-decoration:none !important;">Anika Sterilis Private Limited</a>

    <p style="text-align:center;">Anika ONE, AMTZ Campus,Pragati Maidan,VM Steel Project S.O,Visakhapatnam,Andhra Pradesh-530031</p>
    <p style="text-align:center;">Phone: 0891-5193101 | Email: info@anikasterilis.com | Website: www.anikasterilis.com</p>
</header>
<hr>

<body>
    <div style="display: flex; justify-content: space-between;margin-bottom: 0;">
        <h1 style="text-align:center;border: 1px solid #ccc; flex: 1;width:29%;">
            The data presented in this report is sourced directly from the Payroll Module of our HRMS
        </h1>
        <h1 style="text-align: center;">
            <u>VISAKHAPATNAM EMP's SALARY STATEMENT FOR THE MONTH of <?php echo $smonth; ?></u>
        </h1>
        <h2 style="text-align: right;margin-left:-20px;">
            Report No: ASPL/HRMS/Payroll/<?php echo  $formattedDate ?>
        </h2>
    </div>
    <table border="1" style="border-color: rgb(170, 170, 170);width:100%;margin-top:-120px;" cellspacing="0">
        <tr class="data">
            <th colspan="6" style="background:#ffc000;">Employee Details</th>
            <th colspan="4" style="background:#92d050;">Fixed Salary Components</th>
            <th colspan="7" style="background:#f4b084;">Days Calculation</th>
            <th colspan="4" style="background:#bdd7ee;">Salary as per no of days</th>
            <th colspan="7" style="background:#00b0f0;">Deductions</th>
            <th colspan="1" style="background:#91DDCF;"></th>
            <th colspan="4" style="background:#ffc000;">Bank Transfer Details</th>
            <th colspan="8" style="background:#92d050;">Other Details</th>
        </tr>
        <tr class="data1">
            <th style="background:#ffc000;">S No.</th>
            <th style="background:#ffc000;">Tran ID</th>
            <th style="background:#ffc000;">Employee Name</th>
            <th style="background:#ffc000;">Employee ID</th>
            <th style="background:#ffc000;">Department</th>
            <th style="background:#ffc000;">Designation</th>
            <th style="background:#92d050;">Basic Pay</th>
            <th style="background:#92d050;">HRA</th>
            <th style="background:#92d050;">OA</th>
            <th style="background:#92d050;">Gross Salary</th>
            <th style="background:#f4b084;">Total Days</th>
            <th style="background:#f4b084;">Present Days</th>
            <th style="background:#f4b084;">Week off Days</th>
            <th style="background:#f4b084;">Holidays</th>
            <th style="background:#f4b084;">Leaves</th>
            <th style="background:#f4b084;">LOP</th>
            <th style="background:#f4b084;">Pay Days</th>
            <th style="background:#bdd7ee;">Basic Salary</th>
            <th style="background:#bdd7ee;">HRA</th>
            <th style="background:#bdd7ee;">OA</th>
            <th style="background:#bdd7ee;">Gross Salary</th>
            <th style="background:#00b0f0;">EPF</th>
            <th style="background:#00b0f0;">ESIC</th>
            <th style="background:#00b0f0;">TDS</th>
            <th style="background:#00b0f0;">Advance Salary</th>
            <th style="background:#00b0f0;">Labour & Welfare fund</th>
            <th style="background:#00b0f0;">Loan & Misc</th>
            <th style="background:#00b0f0;">Total Deduction</th>
            <th style="background:#91DDCF;">Bonus/<br>Incentive</th>
            <th style="background:#ffc000;">Salary Payout</th>
            <th style="background:#ffc000;">Benificiary IFSC</th>
            <th style="background:#ffc000;">Benificiary Account Type</th>
            <th style="background:#ffc000;">Benificiary Account Number</th>
            <th style="background:#92d050;">Sender Account Type</th>
            <th style="background:#92d050;">Sender Account Number</th>
            <th style="background:#92d050;">Sender Name</th>
            <th style="background:#92d050;">SMS EML</th>
            <th style="background:#92d050;">Detail</th>
            <th style="background:#92d050;">OoR7002(Sender Name)</th>
            <!--<th style="background:#92d050;">Sender To Receiver Information</th>-->
            <!--<th style="background:#92d050;">Remarks</th>-->
        </tr>
        <tbody>
            <?php
            $cnt = 1;
            $currentMonth = $smonth;
            $sql = "SELECT 
          payroll_ss_vsp.emp_no, 
          payroll_ss_vsp.desg, 
          payroll_ss_vsp.dept, 
          payroll_ss_vsp.*, 
          emp.empname, 
          payroll_ban.*,
          (payroll_ss_vsp.emi + payroll_ss_vsp.misc) AS MISC
      FROM 
          payroll_ss_vsp
      LEFT JOIN 
          emp ON payroll_ss_vsp.empname = emp.empname
      LEFT JOIN 
          payroll_ban ON payroll_ss_vsp.empname = payroll_ban.empname
      WHERE 
          payroll_ss_vsp.salarymonth = '$currentMonth'
      ORDER BY 
          payroll_ss_vsp.emp_no ASC";


            $que = mysqli_query($con, $sql);

            if (mysqli_num_rows($que) > 0) {
                while ($result = mysqli_fetch_assoc($que)) {
            ?>
                       <tr class="data">
                        <td><?php echo $cnt++ ?></td>
                        <td><?php echo $result['transid']; ?></td>
                        <td style="background:#F6F5F2;"><?php echo $result['empname']; ?></td>
                        <td><?php echo $result['emp_no']; ?></td>
                        <td><?php echo $result['dept']; ?></td>
                        <td><?php echo $result['desg']; ?></td>
                        <td><?php echo $result['fbp']; ?></td>
                        <td><?php echo $result['fhra']; ?></td>
                        <td><?php echo $result['foa']; ?></td>
                        <td><?php echo $result['fgs']; ?></td>
                        <td><?php echo $result['monthdays']; ?></td>
                        <td><?php echo $result['present']; ?></td>
                        <td><?php echo $result['sundays']; ?></td>
                        <td><?php echo $result['holidays']; ?></td>
                        <td><?php echo $result['leaves']; ?></td>
                        <td style="<?php echo ($result['flop'] != 0) ? 'background-color: #FFAAAA;' : ''; ?>">
    <?php echo $result['flop']; ?></td>
                        <td><?php echo $result['paydays']; ?></td>
                        <td><?php echo $result['bp']; ?></td>
                        <td><?php echo $result['hra']; ?></td>
                        <td><?php echo $result['oa']; ?></td>
                        <td><?php echo $result['gross']; ?></td>
                        <td><?php echo $result['epf1']; ?></td>
                        <td><?php echo $result['esi1']; ?></td>
                        <td><?php echo $result['tds']; ?></td>
                        <td>0</td>
                        <td>0</td>
                        <td><?php echo $result['MISC']; ?></td>
                        <td><?php echo $result['totaldeduct']; ?></td>
                      <td style="<?php echo ($result['bonus'] != 0) ? 'background-color: #91DDCF;' : ''; ?>">
    <?php echo $result['bonus']; ?>
</td>

                        <td style="background:#FFCF96;padding:21px;"><?php echo $result['payout']; ?></td>
                        <td style="background:#F1F6F9;"><?php echo $result['sifsc']; ?></td>

                        <td>10</td>
                        <td style="background:#F1F6F9;"><?php echo $result['sban']; ?></td>
                        <td>11</td>
                        <td>436205000047</td>
                        <td>ANIKA STERILIS PRIVATE LIMITED</td>
                        <td>EML</td>
                        <td>info@anikasterilis.com</td>
                        <td>ANIKA STERILIS PRIVATE LIMITED</td>
                        <td></td>
                        <td></td>
                    </tr>

        </tbody>
<?php
                }
            }

?>
<tfoot>
<?php 
$sql = "SELECT 
    SUM(payroll_ss_vsp.payout) AS total_payout
FROM 
    payroll_ss_vsp
WHERE 
    payroll_ss_vsp.salarymonth = '$currentMonth'";
$que = mysqli_query($con, $sql);
$result = mysqli_fetch_assoc($que);
$sum = $result['total_payout'];
?>

   <tr >
        <td colspan=29>
        </td>
        <td style="font-size:30px !important;">
            <b><?php echo $sum; ?></b>
        </td>
        <td colspan=11>
        </td>
    </tr>
</tfoot>
    </table>

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
        if ($PAGE_COUNT > 1) {
            $font = $fontMetrics->get_font("monospace", "normal");
            $size = 20;
            $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
       $y = 2325;
            $x = 3150;
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
            $pdf->text(1370, 1470, "ASPL HRM", $font, 100);
            $pdf->image("logo.jpg", 1370, 1470, 0, 0, "JPG", "", true, 150);
            $pdf->set_opacity(1); // Reset opacity to default (1)
        ');
    }
</script>

</body>

</html>