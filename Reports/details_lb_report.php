<?php
$con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");

// Get the empnameFilter and selectFilter values from the URL parameters
$empnameFilter = isset($_GET['empnameFilter']) ? $_GET['empnameFilter'] : '';
$selectFilter = isset($_GET['selectFilter']) ? $_GET['selectFilter'] : '';

// Prepare the SQL query to fetch the data based on filters
$sql = "SELECT DISTINCT MONTH(AttendanceTime) AS month_num, YEAR(AttendanceTime) AS year 
        FROM CamsBiometricAttendance 
        WHERE AttendanceTime IS NOT NULL AND AttendanceTime <> ''
              AND (MONTH(AttendanceTime) != 1 OR YEAR(AttendanceTime) != 2024)
        ORDER BY year ASC, month_num ASC";

$result = mysqli_query($con, $sql);
$months = array();

while ($row = mysqli_fetch_assoc($result)) {
    $month_num = $row['month_num'];
    $year = $row['year'];
    $month_name = date('F', mktime(0, 0, 0, $month_num, 1, $year));
    $months[$year][$month_num] = $month_name;
}

// Prepare the SQL query to fetch employee data based on filters
$sql = "SELECT DISTINCT E.empname
        FROM emp AS E
        JOIN leavebalance AS LB ON E.empname = LB.empname
        WHERE E.empstatus = 0 ";

// Apply the empnameFilter if provided
if (!empty($empnameFilter)) {
    $sql .= " AND E.empname LIKE '%" . mysqli_real_escape_string($con, $empnameFilter) . "%'";
}

// Add condition based on selectFilter value
if ($selectFilter === "+ve") {
    // Only include records where leave total is positive
    $sql .= " AND (LB.cl + LB.sl + LB.co) >= 0";
} elseif ($selectFilter === "-ve") {
    // Only include records where leave total is negative or zero
    $sql .= " AND (LB.cl + LB.sl + LB.co) < 0";
}

$sql .= " ORDER BY E.emp_no ASC";

$result = mysqli_query($con, $sql);
$employees = array();
$cnt = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $employees[] = $row['empname'];
}

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
        }

        .missing-wrapper {
            margin-top: -60px;
        }

        table {
            font-size: 20px !important;
            text-align: center;
        }

        thead th {
            padding: 7px 0 7px;

        }

        tr td:nth-child(3),
        tr td:nth-child(4) {
            background: #A1EEBD;
        }

        tr td:nth-child(12),
        tr td:nth-child(13) {
            background: #FFBB64;
        }
        footer {
    position: fixed;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #f2f2f2;
    border-top: 1px solid #ccc; 
    padding: 1px;
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
$formattedDate = date("Y/m/d", strtotime($currentDateTime));
echo "<p style='font-family: monospace ;font-size:15px;'>Leave_balance sheet generated on: $currentDateTime</p>";
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
        The data presented in this report is sourced directly from the LMS Module of our HRMS
    </h4>
    <h3 style="text-align: center;">
        <u>Employees Leave Balance Report</u>
    </h3>
    <h4 style="text-align: right;">
        Report No: ASPL/HRMS/LMS/<?php echo  $formattedDate ?>
    </h4>
</div>

<!--    <div class="centered-image">-->
<!--    <img src="https://ik.imagekit.io/akkldfjrf/Anika_logo%20(1).jpg?updatedAt=1691746754121" alt="Centered Image">-->
<!--</div>-->
<!--<div class="centered-h1">-->
<!--<h1>ASPL HRM</h1>-->
<!--</div>-->

    <form method="post" action="">
        <?php
        $sqlStatusCheck = "SELECT empname, emp_no FROM emp WHERE empemail = ?";
        $stmtStatusCheck = mysqli_prepare($con, $sqlStatusCheck);

        if ($stmtStatusCheck) {
            mysqli_stmt_bind_param($stmtStatusCheck, "s", $user_name);

            mysqli_stmt_execute($stmtStatusCheck);

            $resultStatusCheck = mysqli_stmt_get_result($stmtStatusCheck);

            $row = mysqli_fetch_assoc($resultStatusCheck);

            mysqli_stmt_close($stmtStatusCheck);
        } else {
            echo "Error in preparing SQL statement for status check.";
        }
        ?>
        <table border="1" style="border-color: rgb(170, 170, 170);width:100%;margin-top:-110px;" cellspacing="0">
            <thead style="position:sticky;top:0;font-size:17px !important;">
                <tr>
                    <th></th>
                    <th></th>
                    <th colspan=2 style="background-color: #A1EEBD;">Leave Balance Allocated</th>
                    <?php $colspan = count($months[$year]); ?>
                    <th style="background-color: #453F70;color:white;" colspan="<?php echo $colspan; ?>">Monthly Leave Balance Costed</th>
                    <th></th>
                    <th colspan=3 style="background-color: #FFBB64;">
                        Current Leave Balance
                    </th>
                </tr>
                <tr class="static-cell">
                    <th></th>
                    <th>Employee Name</th>
                    <th style="background-color: #A1EEBD;">CL + SL</th>
                    <th style="background-color: #A1EEBD;">CO</th>
                    <?php foreach ($months as $year => $year_months) : ?>
                        <?php foreach ($year_months as $month_num => $month_name) : ?>
                            <th style="background-color: #453F70;color:white;"><?php echo $month_name . ' ' . $year; ?></th>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                    <th style="background-color: #453F70;color:white;">Total Leave <br>Balance Costed</th>
                    <th style="background-color: #FFBB64;">CL+SL</th>
                    <th style="background-color: #FFBB64;">
                        CO
                    </th>
                    <th style="background-color: #A1EEBD;">
                        Total
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $employee) : ?>
                    <?php
                    // Initialize total leave count for the employee
                    $totalLeaveCount = 0;
                    ?>
                    <?php
                    $leaveBalanceQuery = "SELECT lb.cl, lb.sl, lb.co 
                      FROM leavebalance lb
                      JOIN emp ON lb.empname = emp.empname
                      WHERE lb.empname = '" . $employee . "'
                      ORDER BY lb.lastupdate DESC";
                    $leaveBalanceResult = mysqli_query($con, $leaveBalanceQuery);
                    $result = mysqli_fetch_assoc($leaveBalanceResult);
                    $leaveTotal = $result['cl'] + $result['sl'] + $result['co'];
                    ?>

                    <tr style="<?php
                                if ($leaveTotal > 0) {
                                    echo 'background-color: #CDFADB;';
                                } elseif ($leaveTotal < 0) {
                                    echo 'background-color: #FF8080;';
                                } elseif ($leaveTotal == 0) {
                                    echo 'background-color: #F2C18D;';
                                }
                                ?>">
                        <td>
                            <?php echo $cnt++; ?>
                        </td>
                        <td><?php echo $employee; ?></td>
                        <td>
                            <?php
                            $leaveBalanceQuery = "SELECT *
                      FROM leavebalance lb
                      JOIN emp ON lb.empname = emp.empname
                      WHERE lb.empname = '" . $employee . "'
                      ORDER BY lb.lastupdate DESC";
                            $leaveBalanceResult = mysqli_query($con, $leaveBalanceQuery);
                            $result = mysqli_fetch_assoc($leaveBalanceResult);
                            $totalLeaves = $result['icl'] + $result['isl'];
                            echo $totalLeaves;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $result['ico'];
                            ?>
                        </td>
                        <?php foreach ($months as $year => $year_months) : ?>
                            <?php foreach ($year_months as $month_num => $month_name) : ?>
                                <td>
                                    <?php

                                    $fetchingHolidaysa = mysqli_query($con, "
                    SELECT date
                    FROM holiday
                    WHERE date >= '$year-$month_num-01'
                    AND date <= LAST_DAY('$year-$month_num-01')
                ") or die(mysqli_error($con));
                                    $holidays = [];
                                    while ($holiday = mysqli_fetch_assoc($fetchingHolidaysa)) {
                                        $holidays[] = $holiday['date'];
                                    }

                                    $leaveCount = 0;
                                    $leaveCount1 = 0;
                                    $leavesData = mysqli_query($con, "
                        SELECT `from`, `to`
                        FROM leaves 
                        WHERE empname = '" . $employee . "'
                              AND ((status = 1 AND status1 = 1) OR (status = 1 AND status1 = 0)) 
                              AND leavetype != 'HALF DAY'
                              AND leavetype != 'OFFICIAL LEAVE'
                              AND (
                                  (`from` BETWEEN '$year-$month_num-01' AND LAST_DAY('$year-$month_num-01'))
                                  OR (`to` BETWEEN '$year-$month_num-01' AND LAST_DAY('$year-$month_num-01'))
                                  OR (`from` <= '$year-$month_num-01' AND `to` >= '$year-$month_num-01')
                              )
                    ") or die(mysqli_error($con));

                                    while ($leaveEntry = mysqli_fetch_assoc($leavesData)) {
                                        $from = strtotime($leaveEntry['from']);
                                        $to = strtotime($leaveEntry['to']);

                                        $current_date = $from;

                                        while ($current_date <= $to) {
                                            $current_month = date('n', $current_date);
                                            $current_year = date('Y', $current_date);
                                            $days_in_current_month = date('t', $current_date);
                                            $end_of_current_month = strtotime(date('Y-m-t', $current_date));
                                            $segment_end_date = min($end_of_current_month, $to);
                                            $leave_days = 0;
                                            for ($date = $current_date; $date <= $segment_end_date; $date += 24 * 60 * 60) {
                                                $day_of_week = date('N', $date);
                                                $current_date_str = date('Y-m-d', $date);
                                                if ($day_of_week != 7 && !in_array($current_date_str, $holidays)) {
                                                    $leave_days++;
                                                }
                                            }
                                            if ($current_month == $month_num && $current_year == $year) {
                                                $leaveCount += $leave_days;
                                            }
                                            $current_date = strtotime('+1 month', $current_date);
                                            $current_date = strtotime('first day of', $current_date);
                                        }
                                    }


                                    $leavesData1 = mysqli_query($con, "
                    SELECT `from`, `to`
                    FROM leaves
                    WHERE empname = '" . $employee . "'
                    AND ((status = 1 AND status1 = 1) OR (status = 1 AND status1 = 0)) 
                    AND leavetype = 'HALF DAY'
                    AND (
                      (`from` BETWEEN '$year-$month_num-01' AND LAST_DAY('$year-$month_num-01'))
                      OR (`to` BETWEEN '$year-$month_num-01' AND LAST_DAY('$year-$month_num-01'))
                      OR (`from` <= '$year-$month_num-01' AND `to` >= '$year-$month_num-01')
                  )
                ") or die(mysqli_error($con));

                                    while ($leaveEntry = mysqli_fetch_assoc($leavesData1)) {
                                        $from = strtotime($leaveEntry['from']);
                                        $to = strtotime($leaveEntry['to']);

                                        for ($k = 0; $k <= $to - $from; $k += 24 * 60 * 60) {
                                            $currentDay = date('N', $from + $k);
                                            if ($currentDay != 7) {
                                                $leaveCount1 += 0.5;
                                            }
                                        }
                                    }
                                    $totalLeaveCount += $leaveCount + $leaveCount1;
                                    echo $leaveCount + $leaveCount1;
                                    ?>
                                </td>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <td>
                            <?php echo $totalLeaveCount; ?>
                        </td>
                        <td>
                            <?php
                            $leaveBalanceQuery = "SELECT *
                      FROM leavebalance lb
                      JOIN emp ON lb.empname = emp.empname
                      WHERE lb.empname = '" . $employee . "'
                      ORDER BY lb.lastupdate DESC";
                            $leaveBalanceResult = mysqli_query($con, $leaveBalanceQuery);
                            $result = mysqli_fetch_assoc($leaveBalanceResult);
                            $totalLeaves = $result['cl'] + $result['sl'];
                            echo $totalLeaves;
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $result['co'];
                            ?>
                        </td>
                        <td>
                            <?php
                            $totalLeaves1 = $result['cl'] + $result['sl'] +  $result['co'];
                            echo $totalLeaves1;
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
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
</div>
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
            $pdf->text(570, 870, "ASPL HRM", $font, 100);
            $pdf->image("logo.jpg", 570, 870, 0, 0, "JPG", "", true, 150);
            $pdf->set_opacity(1); // Reset opacity to default (1)
        ');
    }
</script>
</body>

</html>