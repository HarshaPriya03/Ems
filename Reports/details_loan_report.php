<?php
@include '../inc/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details Pdf</title>
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
            /* margin-top: -120px; */
            /* padding: 1rem; */
        }

        .missing-wrapper {
            /* width: 50%; */
            margin-top: -60px;
        }

        table {
            font-size: 15px !important;
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
            font-size: 10px;
        }

        .centered-image {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.07;

        }

        .centered-h1 {
            position: absolute;
            top: 65%;
            left: 49%;
            transform: translate(-50%, -50%);
            opacity: 0.08;
            font-size: 30px;
        }
        .green-background {
    background-color: #C3EDC0;
}

.red-background {
    background-color: #F7A4A4;
}

    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<?php
$currentDateTime = date("Y-m-d H:i:s", strtotime("+5 hours 30 mins"));
echo "<p style='font-family: monospace ;font-size:15px;'>Report generated on: $currentDateTime</p>";
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
        <h4 style="text-align:center;border: 1px solid #ccc; flex: 1;width:29%;">
            The data presented in this report is sourced directly from the Payroll Module of our HRMS
        </h4>
        <h3 style="text-align: center;">
            <u>Loan's Report</u>
        </h3>
    </div>

    <div class="centered-image">
        <img width=300px src="https://ik.imagekit.io/akkldfjrf/Anika_logo%20(1).jpg?updatedAt=1691746754121" alt="Centered Image">
    </div>
    <div class="centered-h1">
        <h1>ASPL HRM</h1>
    </div>

    <table border="1" cellspacing="0" id="attendanceTable" style="margin-left:0px;margin-top:-70px;">
        <thead>
            <tr style="background-color: #363062;color:white;">
                             <th>
                                 S.No.
                             </th>
                             <th>
                                 Employee name
                                  </th>
                             <th>
                                Loan No.
                            </th>
                             <th>
                                 Loan Amount
                             </th>
                             <th>
                              Balance
                          </th>
                             <th>
                                EMI
                             </th>
                             <th>
                             Tenure Start 
                             </th>
                             <th>
                             Tenure 
                             </th>
                             <th>
                             Mode of Transfer 
                             </th>
                             <th>
                             Transfer Date  
                             </th>
                             <th>
                             Transaction No  
                             </th>
                             <th>
                                Loan Status
                            </th>
                            
                         </tr>
        </thead>
        <tbody id="tableBody">
        <?php
                     $cnt = 1;
$sql = "SELECT pl.*, SUM(pe.emi) AS total_emi, emp.pic 
        FROM payroll_loan pl 
        LEFT JOIN payroll_emi pe ON pl.empname = pe.empname AND pl.loanno = pe.loanno 
        LEFT JOIN emp ON pl.empname = emp.empname 
        GROUP BY pl.empname, pl.loanno 
        ORDER BY pl.loanno ASC";
$que = mysqli_query($con, $sql);

if (mysqli_num_rows($que) > 0) {
    while ($result = mysqli_fetch_assoc($que)) {
        $balance = $result['loamt'] - $result['total_emi'];
        ?>
              <tr <?php echo ($result['status'] == 1) ? 'class="green-background"' : 'class="red-background"'; ?>>
                <td><?php echo $cnt++; ?></td>
                   <td><?php echo $result['empname']; ?></td>
                  <td><?php echo $result['loanno']; ?></td>
                  <td><?php echo $result['loamt']; ?></td>
                  <td>
                    <?php echo $balance; ?>
                  </td>
                  <td><?php echo $result['emi']; ?></td>
                  <td><?php echo $result['stmonth']; ?></td>
                  <td><?php echo $result['loterm']; ?></td>
                  <td><?php echo $result['mop']; ?></td>
                  <td><?php echo $result['pdate']; ?></td>
                  <td><?php echo $result['tno']; ?></td>
                   <td>
                   <?php
                  if ($result['status'] == 1) {
                      echo"OPEN";
                  } else {
                      echo"CLOSED";
                  }
        ?>
                      
                   </td>
                </tr>
                <?php
    }
} else {
    ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td colspan="9" class="px-6 py-4 text-center">No loan history</td>
            </tr>
          <?php
}
?>
        </tbody>
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
        if ($PAGE_COUNT = 1) {
            $font = $fontMetrics->get_font("monospace", "normal");
            $size = 12;
            $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
            $y = 45;
            $x = 500;
            $pdf->text($x, $y, $pageText, $font, $size);
        } 
    ');
}
</script>
</body>

</html>