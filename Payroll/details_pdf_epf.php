<?php
@include 'inc/config.php';

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
    <title>EPF Statement PDF</title>
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
        td{
            text-align: center;
        }
        td,th{
            border: 1px solid goldenrod; 
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


footer b{
    text-align:center !important;
    display: block; 
    /* font-family: monospace ; */
    font-size:15px;
}
.centered-image {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0.07; 
}
.centered-h1{
    position: absolute;
    top: 70%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0.08; 
    font-size:100px;
}
    </style>
</head>
<?php
$currentDateTime = date("Y-m-d H:i:s", strtotime("+5 hours 30 mins"));
echo "<p style='font-family: monospace ;font-size:15px;'>EPF Statement generated on: $currentDateTime</p>";
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
        <u>EPF Report</u>
    </h3>
</div>

<!--    <div class="centered-image">-->
<!--    <img src="https://ik.imagekit.io/akkldfjrf/Anika_logo%20(1).jpg?updatedAt=1691746754121" alt="Centered Image">-->
<!--</div>-->
<!--<div class="centered-h1">-->
<!--<h1>ASPL HRM</h1>-->
<!--</div>-->
    <form method="post" action="">
        <table border="1" style="margin-top:-70px;border-color: rgb(170, 170, 170);width:100%" cellspacing="0">
            <thead style="text-align: center;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr style="background:lemonchiffon;">
                <th scope="col" class="px-6 py-3">
                Employee Name
              </th>
              <th scope="col" class="px-6 py-3">
                EPF A/C Number
              </th>
              <th scope="col" class="px-6 py-3">
                UAN
              </th>
              <th scope="col" class="px-6 py-3">
                Salary Month
              </th>
              <th scope="col" class="px-6 py-3">
                Basic Salary
              </th>
              <th scope="col" class="px-9 py-3">
                Employee Share <br>
                ( 12% )
              </th>
              <th scope="col" class="px-9 py-3">
                Employer Share
                <br>
                ( 3.67% )
              </th>
              <th scope="col" class="px-9 py-3">
                Pension Share
                <br>
                ( 8.33% )
              </th>
                </tr>
            </thead>
            <?php
            $currentMonth = date('F Y');
            $nextMonth = date('F Y', strtotime('+1 month'));
            
              if ( $work_location == 'All') {
            $sql = "SELECT payroll_ss.*, payroll_ban.*, emp.pic, emp.work_location
          FROM payroll_ss
          JOIN payroll_ban ON payroll_ss.empname = payroll_ban.empname
          JOIN emp ON payroll_ss.empname = emp.empname
          WHERE payroll_ban.uan IS NOT NULL
            AND payroll_ban.uan <> ''
            AND payroll_ban.uan NOT LIKE '0%'
          ORDER BY salarymonth ASC";
          } elseif ($work_location == 'Visakhapatnam' ) {
            $sql = "SELECT payroll_ss.*, payroll_ban.*, emp.pic, emp.work_location
  FROM payroll_ss
  JOIN payroll_ban ON payroll_ss.empname = payroll_ban.empname
  JOIN emp ON payroll_ss.empname = emp.empname
  WHERE payroll_ban.uan IS NOT NULL
    AND payroll_ban.uan <> ''
    AND payroll_ban.uan NOT LIKE '0%'
    AND emp.work_location = 'Visakhapatnam'
  ORDER BY salarymonth ASC";
          }
          elseif ($work_location == 'Gurugram') {
            $sql = "SELECT payroll_ss.*, payroll_ban.*, emp.pic, emp.work_location
FROM payroll_ss
JOIN payroll_ban ON payroll_ss.empname = payroll_ban.empname
JOIN emp ON payroll_ss.empname = emp.empname
WHERE payroll_ban.uan IS NOT NULL
  AND payroll_ban.uan <> ''
  AND payroll_ban.uan NOT LIKE '0%'
  AND emp.work_location = 'Gurugram'
ORDER BY salarymonth ASC";
          }

            $que = mysqli_query($con, $sql);

            if (mysqli_num_rows($que) > 0) {
                while ($result = mysqli_fetch_assoc($que)) {
            ?>
                    <tbody style="text-align: center;">
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                            <td class="px-6 py-4" style="background: rgba(250, 250, 210, 0.5);"> <?php echo $result['epfn']; ?></td>
                            <td class="px-6 py-4" style="background: rgba(250, 250, 210, 0.5);"><?php echo $result['uan']; ?></td>
                            <td class="px-6 py-4" style="background: rgba(250, 250, 210, 0.5);"><?php echo $result['salarymonth']; ?></td>

                            <td class="px-6 py-4" style="background: rgba(250, 250, 210, 0.5);"><?php echo $result['bp']; ?></td>
                            <td class="px-6 py-4" style="background: rgba(250, 250, 210, 0.5);"><?php echo $result['epf1']; ?></td>
                            <td class="px-6 py-4" style="background: rgba(250, 250, 210, 0.5);"><?php echo $result['epf2']; ?></td>
                            <td class="px-6 py-4" style="background: rgba(250, 250, 210, 0.5);"><?php echo $result['pension']; ?></td>
                       
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
 <tfoot class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <?php
            $sql = "SELECT 
            SUM(epf1) AS sum_epf1,
            SUM(epf2) AS sum_epf2,
            SUM(pension) AS sum_pension
            FROM 
            payroll_ss";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);

            $sum_epf1 = $row['sum_epf1'];
            $sum_epf2 = $row['sum_epf2'];
            $sum_pension = $row['sum_pension'];
            ?>
            <tr>
                <th></th>
              <th style="text-align:right;border-right:1px solid transparent;" colspan="4">Total</th>
              <th scope="col" class="px-6 py-3" style="text-align: center; font-size: 18px;"><?php echo $sum_epf1; ?></th>
              <th scope="col" class="px-6 py-3" style="text-align: center; font-size: 18px;"><?php echo $sum_epf2; ?></th>
              <th scope="col" class="px-6 py-3" style="text-align: center; font-size: 18px;"><?php echo $sum_pension; ?></th>
            </tr>
          </tfoot>
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
        if ($PAGE_COUNT > 1) {
            $font = $fontMetrics->get_font("monospace", "normal");
            $size = 12;
            $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
            $y = 15;
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
            $pdf->text(570, 870, "ASPL HRM", $font, 100);
            $pdf->image("logo.jpg", 570, 870, 0, 0, "JPG", "", true, 150);
            $pdf->set_opacity(1); // Reset opacity to default (1)
        ');
    }
</script>
</body>

</html>