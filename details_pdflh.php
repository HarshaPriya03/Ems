<?php
	$con=mysqli_connect("localhost","Anika12","Anika12","ems");
$user_name = isset($_GET['user_name']) ? urldecode($_GET['user_name']) : null;

$sqlStatusCheck = "SELECT empstatus FROM emp WHERE empemail = ?";
$stmtStatusCheck = mysqli_prepare($con, $sqlStatusCheck);

if ($stmtStatusCheck) {
    mysqli_stmt_bind_param($stmtStatusCheck, "s", $user_name);

    mysqli_stmt_execute($stmtStatusCheck);

    // Get the result
    $resultStatusCheck = mysqli_stmt_get_result($stmtStatusCheck);

    // Fetch the row
    $statusRow = mysqli_fetch_assoc($resultStatusCheck);

    // Close the statement
    mysqli_stmt_close($stmtStatusCheck);
} else {
    // Handle the error if the statement couldn't be prepared
    echo "Error in preparing SQL statement for status check.";
}

if ($statusRow['empstatus'] == 0) {
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
            height:10px;
        }
        .wrapper {
  display: flex;
  justify-content: space-around !important;
}
.missing-wrapper {
  margin-top: -60px;
}
table{
    font-size: 15px !important;
}
    </style>
</head>
<?php
  $currentDateTime = date("Y-m-d H:i:s", strtotime("+5 hours 30 mins"));
    echo "<p style='font-family: monospace ;font-size:15px;'>Leave_balance sheet generated on: $currentDateTime</p>";
    ?>

<div style='display:block;margin-left:auto;margin-right:auto;width:110px;'>
<img alt='logo'  src='https://ik.imagekit.io/akkldfjrf/Anika_logo%20(1).jpg?updatedAt=1691746754121' width=100px height=80px>
</div><br>
<header style="text-align:center;color:black !important; ">
        <a class="header" href="" style="Font-size:30px;text-decoration:none !important;">Anika Sterilis Private Limited</a>
	
    <p style="text-align:center;">Anika ONE, AMTZ Campus,Pragati Maidan,VM Steel Project S.O,Visakhapatnam,Andhra Pradesh-530031</p>
    <p style="text-align:center;">Phone: 0891-5193101 | Email: info@anikasterilis.com</p>
    </header>
    <hr>
<body>
<h3 style="text-align: center;"><u>Leave Balance Sheet</u></h3>
<div style=" position: relative;">

</div>
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
<table border="1" style="border-color: rgb(170, 170, 170);width:100%" cellspacing="0">
    <tr>
        <td style="text-align:center;"> <b>Employee Name</b>: <?php echo isset($row['empname']) ? $row['empname'] : 'N/A'; ?></td>
        <td style="text-align:center;"> <b>Employee ID</b>: <?php echo isset($row['emp_no']) ? $row['emp_no'] : 'N/A'; ?> </td> 
    </tr>
</table>
    <br>
<table border="1" style="border-color: rgb(170, 170, 170);" cellspacing="0" class="table table-bordered table-hover">
    <tr class='header-row'>
        <th colspan="4" style="font-size:12px;">Indications: LB = Leave Balance , D/A = Deductions/Allocations</th>
    </tr>
    <tr>
    <th colspan="4">*Total Leave Balance Allocated</th>
    </tr>
    <tr>
        <th >Transaction</th>
        <th>D/A</th>
        <th colspan="1">Description</th>
        <th>Transaction Time</th>
    </tr>
    <?php
    $sql = "SELECT leaves.*, lb.iupdate,lb.lastupdate, lb.icl, lb.isl, lb.ico,lb.cl, lb.sl, lb.co, leaves.status, leaves.status1
    FROM leaves 
    INNER JOIN leavebalance lb ON leaves.empemail = lb.empemail
    WHERE leaves.empemail = ?
    AND leaves.applied > '2024-02-01'
    ORDER BY leaves.ID DESC";

    $stmtLeaves = mysqli_prepare($con, $sql);

    if ($stmtLeaves) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmtLeaves, "s", $user_name);

        // Execute the statement
        mysqli_stmt_execute($stmtLeaves);

        // Get the result
        $que = mysqli_stmt_get_result($stmtLeaves);
        $totalLeaves = 0;
        if (mysqli_num_rows($que) == 0) {
            echo '<tr><td colspan="5" style="text-align:center;">No Leave Records</td></tr>';
        } else {
            while ($row = mysqli_fetch_assoc($que)) {
                ?>
                <?php
                $status = $row['status'];
                $status1 = $row['status1'];
                if (($status == '1' && $status1 == '1') || ($status == '1' && $status1 == '0')) {
                    ?>
                    <tr>
                        <td style="text-align:center;">Deducted</td>
                        <td style="text-align:center;">
                            <?php
                            $status = $row['status'];
                            $status1 = $row['status1'];

                            if (
                                (($status == '1' && $status1 == '1') || ($status == '1' && $status1 == '0')) &&
                                strtotime($row['from']) >= strtotime('2024-02-01')
                            ) {
                                $fromDate = new DateTime($row['from']);
                                $toDate = new DateTime($row['to']);
                                if ($row['leavetype'] === "HALF DAY") {
                                       echo '<span>-0.5</span>';
                                } else {
                                    $toDate->modify('+1 day');

                                    $interval = new DateInterval('P1D');
                                    $dateRange = new DatePeriod($fromDate, $interval, $toDate);

                                    $fetchHolidaysQuery = "SELECT `date` FROM holiday";
                                    $holidaysResult = mysqli_query($con, $fetchHolidaysQuery);
                                    $holidayDates = [];

                                    while ($holidayRow = mysqli_fetch_assoc($holidaysResult)) {
                                        $holidayDates[] = $holidayRow['date'];
                                    }

                                    $excludedDays = 0;

                                    foreach ($dateRange as $date) {
                                        if ($date->format('w') != 0 && !in_array($date->format('Y-m-d'), $holidayDates)) {
                                            $excludedDays++;
                                        }
                                    }

                                    $totalDays = $excludedDays;
                                    $totalLeaves += $totalDays;
                                    echo '<span>' . '-' . $totalDays . '</span>';

                                    $cl= $row['icl'];
                                    $sl= $row['isl'];
                                    $co= $row['ico'];
                                    
                                    $cl1= $row['cl'];
                                    $sl1= $row['sl'];
                                    $co1= $row['co'];
                                        $itime= date('Y-m-d H:i:s', strtotime($row['iupdate'] . ' +5 hours +30 minutes'));
                            $ltime= date('Y-m-d H:i:s', strtotime($row['lastupdate'] . ' +5 hours +30 minutes'));
                                    $allocated = $row['icl'] + $row['isl'] + $row['ico'];
                                    $avail =($row['cl'] + $row['sl'] + $row['co']);
                                    $deduct =  $allocated - ($row['cl'] + $row['sl'] + $row['co']);
                                }
                            } else {
                                echo "";
                            }
                            ?>
                        </td>
                        <td style="width:340px;">for <?php echo $row['leavetype'];?>
                        from <?php echo date('d-m-Y', strtotime($row['from'])); ?> to <?php echo date('d-m-Y', strtotime($row['to'])); ?></td>
                 
                        <td style="white-space:nowrap;text-align:center;"><?php echo date('Y-m-d H:i:s', strtotime($row['mgrtime'] . ' +5 hours +30 minutes'));?></td>
                    </tr>
                    <?php
                }
            }
        }
    }
    ?>
    <?php
    $sqlLeaveBalance = "SELECT lb.iupdate,lb.lastupdate, lb.icl, lb.isl, lb.ico, lb.cl, lb.sl, lb.co
    FROM leavebalance lb
    WHERE lb.empemail = ?";
    $stmtLeaveBalance = mysqli_prepare($con, $sqlLeaveBalance);
    
    if ($stmtLeaveBalance) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmtLeaveBalance, "s", $user_name);

        // Execute the statement
        mysqli_stmt_execute($stmtLeaveBalance);

        // Get the result
        $resultLeaveBalance = mysqli_stmt_get_result($stmtLeaveBalance);

        if (mysqli_num_rows($resultLeaveBalance) == 0) {
            echo '<tr><td colspan="4" style="text-align:center;">No Leave Records</td></tr>';
        } else {
            while ($rowLeaveBalance = mysqli_fetch_assoc($resultLeaveBalance)) {
                $cl= $rowLeaveBalance['icl'];
                $sl= $rowLeaveBalance['isl'];
                $co= $rowLeaveBalance['ico'];
                
                $cl1= $rowLeaveBalance['cl'];
                $sl1= $rowLeaveBalance['sl'];
                $co1= $rowLeaveBalance['co'];
                $itime= date('Y-m-d H:i:s', strtotime($rowLeaveBalance['iupdate'] . ' +5 hours +30 minutes'));
                $ltime= date('Y-m-d H:i:s', strtotime($rowLeaveBalance['lastupdate'] . ' +5 hours +30 minutes'));
                $allocated = $rowLeaveBalance['icl'] + $rowLeaveBalance['isl'] + $rowLeaveBalance['ico'];
                $avail =($rowLeaveBalance['cl'] + $rowLeaveBalance['sl'] + $rowLeaveBalance['co']);
                $deduct =  $allocated - ($rowLeaveBalance['cl'] + $rowLeaveBalance['sl'] + $rowLeaveBalance['co']);
                ?>
                <tr style="border-top:3px solid black;">
                    <td style="white-space:nowrap;">Total LB Allocated* :</td>
                    <td style="padding-left:20px;">+<?php echo $rowLeaveBalance['icl'] + $rowLeaveBalance['isl'] + $rowLeaveBalance['ico']; ?></td>
                    <td style="text-align:center;"></td>
                    <td style="text-align:center;"><?php echo $itime; ?></td>
                </tr>
                <tr>
                    <td colspan="2">Total Deductions : <span style="padding-left:60px;">-<?php echo $rowLeaveBalance['icl'] + $rowLeaveBalance['isl'] + $rowLeaveBalance['ico'] - ($rowLeaveBalance['cl'] + $rowLeaveBalance['sl'] + $rowLeaveBalance['co']); ?> </span></td>
                    <td colspan=2 style="text-align:center;"></td>
                </tr>
                <tr style="border-bottom:2.5px solid black;">
                    <td colspan =2>Available Balance : <span style="padding-left:60px;font-weight:bold;font-size:17px !important;"><?php echo $rowLeaveBalance['cl'] + $rowLeaveBalance['sl'] + $rowLeaveBalance['co']; ?> </span></td>
                    <td colspan =2></td>
                </tr>
                <?php
            }
        }
    }
    ?>
</table>[ Updated as of <?php echo $ltime; ?> ]
                </form>
                <?php
} else {
  echo "";
  exit();
}
?>
</body>
</html>
