<?php
require_once("dbConfig.php");
$currentDate = date("Y-m-d");
$firstDayOfMonth = date("Y-m-01");
$totalDaysInMonth = date("t", strtotime($firstDayOfMonth));

// Fetching Employees 
// $fetchingEmployees = mysqli_query($db, "SELECT * FROM emp WHERE desg != 'SECURITY GAURDS' ORDER BY emp_no ASC") or die(mysqli_error($db));
$fetchingEmployees = mysqli_query($db, "SELECT * FROM emp
WHERE empstatus = 0 AND desg != 'SECURITY GAURDS'
AND ServiceTagId = 'ZXQI19009096'
ORDER BY emp_no ASC;") or die(mysqli_error($db));

$totalNumberOfEmployees = mysqli_num_rows($fetchingEmployees);

$EmployeesNamesArray = array();
$EmployeesIDsArray = array();
$counter = 0;
while ($Employees = mysqli_fetch_assoc($fetchingEmployees)) {
    $EmployeesNamesArray[] = $Employees['empname'];
    $EmployeesIDsArray[] = $Employees['UserID'];
}

// Fetching holidays
$fetchingHolidays = mysqli_query($db, "SELECT value, date FROM holiday") or die(mysqli_error($db));
$holidayDates = array();
while ($holiday = mysqli_fetch_assoc($fetchingHolidays)) {
    $holidayDates[$holiday['date']] = $holiday['value'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Sheet</title>
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
            /* font-family: monospace ; */
            font-size: 15px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<?php
$currentDateTime = date("Y-m-d H:i:s", strtotime("+5 hours 30 mins"));
$formattedDate = date("Y/m/d", strtotime($currentDateTime));
echo "<p style='font-family: monospace ;font-size:15px;'>Attendance sheet generated on: $currentDateTime</p>";
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
            The data presented in this report is sourced directly from the AMS Module of our HRMS
        </h4>
        <h3 style="text-align: center;">
            <u>Attendance Sheet for the Month of <?php echo date("F Y"); ?></u>
        </h3>
        <h4 style="text-align: right;">
            Report No: ASPL/HRMS/AMS/<?php echo  $formattedDate ?>
        </h4>
    </div>
    <br>
    <form method="post" action="">
        <table border="1" style="border-color: rgb(170, 170, 170);scale:0.9;margin-top:-100px;" cellspacing="0" id="attendanceTable" class="table table-bordered table-hover">


            <?php
            $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth)) . ' 23:59:59';
            // Calculate the number of Sundays in the current month
            $sundaysCount = 0;
            for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                $dateOfAttendance = date("Y-m-$j");
                $dayOfWeek = date('N', strtotime($dateOfAttendance));
                if ($dayOfWeek == 7) {
                    $sundaysCount++;
                }
            }
            for ($i = 1; $i <= $totalNumberOfEmployees + 2; $i++) {
                if ($i == 1) {
                    echo "<tr class='header-row'>";
                    echo "<td  rowspan='2' class='static-cell'>No.</td>";
                    echo "<td rowspan='2' class='static-cell'>Employee Name</td>";
                    for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                        echo "<td class='static-cell'>$j</td>";
                    }
                    echo "<td colspan='8' style='text-align:center;' class='static-cell'>Total</td>";
                    $currentDate = date('Y-m-d');
                    $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));

                    if ($currentDate === $lastDayOfMonth) {
                        echo "<td rowspan='2' >Confirmed by employee</td>";
                    } else {
                        echo "";
                    }
                    echo "</tr>";
                } else if ($i == 2) {
                    echo "<tr class='header-row'>";
                    for ($j = 0; $j < $totalDaysInMonth; $j++) {
                        echo "<td class='static-cell' >" . date("D", strtotime("+$j days", strtotime($firstDayOfMonth))) . "</td>";
                    }
                    echo "<td class='static-cell'>Ab</td>";
                    echo "<td class='static-cell text-center'>TL</td>";
                    echo "<td class='static-cell'>CO</td>";
                    echo "<td class='static-cell text-center'>LB</td>";
                    echo "<td class='static-cell'>AWD</td>";
                    echo "<td class='static-cell'>P</td>";
                    echo "<td class='static-cell'>NWD</td>";
                    echo "<td class='static-cell'>AP(%)</td>";
                    echo "</tr>";
                } else {
                    echo "<tr>";
                    echo "<td>" . $cnt++ . "</td>";
                    echo "<td>" . $EmployeesNamesArray[$counter] . "</td>";

                    $color = "";
                    for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                        $dateOfAttendance = date("Y-m-$j");

                        // Check if the date is a holiday
                        $fetchingHoliday = mysqli_query($db, "
                                    SELECT value
                                    FROM holiday
                                    WHERE date = '$dateOfAttendance'
                                ") or die(mysqli_error($db));

                        $isHoliday = mysqli_num_rows($fetchingHoliday);
                        $dayOfWeek = date('N', strtotime($dateOfAttendance));
                        // Default value for non-holiday
                        $attendanceText = '';

                        // Default value for non-holiday
                        $attendanceText = '';

                        // Check if the date is a holiday
                        $fetchingHoliday = mysqli_query($db, "
                    SELECT value
                    FROM holiday
                    WHERE date = '$dateOfAttendance'
                ") or die(mysqli_error($db));

                        $isHoliday = mysqli_num_rows($fetchingHoliday);
                        // If it's a holiday, display 'H'
                        if ($isHoliday > 0) {
                            $attendanceText = '<span style="font-weight: 600; color:rgb(255, 144, 17); padding: 0.1em;" padding: 0.1em;">H</span>';
                        } else {
                            if ($dayOfWeek == 7) {
                                // Check for CheckIn and CheckOut entries on Sunday for the specific employee
                                $fetchingSundayEntries = mysqli_query($db, "
                        SELECT AttendanceType
                        FROM CamsBiometricAttendance
                        WHERE UserID = '" . $EmployeesIDsArray[$counter] . "'
                        AND DATE(AttendanceTime) = '$dateOfAttendance'
                        AND AttendanceType = 'CheckOut'
                    ") or die(mysqli_error($db));

                                $sundayEntriesCount = mysqli_num_rows($fetchingSundayEntries);

                                if ($sundayEntriesCount > 0) {
                                    $attendanceText = '<span style="font-weight: 600; color:rgb(0, 146, 0); padding: 0.1em;">P</span>';
                                } else {
                                    $attendanceText = 'Sun';
                                }
                            }
                        }

                        if ($dayOfWeek != 7) {
                            // Check for leaves entries

                            $fetchingLeaves = mysqli_query($db, "
                                    SELECT empname, leavetype
                                    FROM leaves
                                    WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
                                    AND DATE(`from`) <= '$dateOfAttendance'
                                    AND DATE(`to`) >= '$dateOfAttendance'
                                        AND ((status = 1 AND status1 = 1) OR (status = 1 AND status1 = 0)) 
                                ") or die(mysqli_error($db));

                            $isLeavesAdded = mysqli_num_rows($fetchingLeaves);

                            if ($isLeavesAdded > 0) {
                                $leaveEntry = mysqli_fetch_assoc($fetchingLeaves);

                                // Check the leavetype and set the attendance text accordingly
                                if ($leaveEntry['leavetype'] == 'HALF DAY') {
                                    $attendanceText = '<span style="font-weight: 600; color:rgb(104, 104, 104); padding: 0.1em;">HDL</span>';

                                    // Fetch attendance data for weekdays (excluding Sundays)
                                    $fetchingEmployeesAttendance = mysqli_query($db, "
                                            SELECT CBA.AttendanceType, E.empname
                                            FROM CamsBiometricAttendance AS CBA
                                            INNER JOIN emp AS E ON CBA.UserID = E.UserID
                                            WHERE CBA.UserID = '" . $EmployeesIDsArray[$counter] . "'
                                            AND DATE(CBA.AttendanceTime) = '$dateOfAttendance'
                                        ") or die(mysqli_error($db));

                                    $isAttendanceAdded = mysqli_num_rows($fetchingEmployeesAttendance);

                                    // Store the fetched rows in an array
                                    $EmployeeAttendanceArray = array();
                                    while ($row = mysqli_fetch_assoc($fetchingEmployeesAttendance)) {
                                        $EmployeeAttendanceArray[] = $row;
                                    }

                                    $absentText = '';

                                    // Check for absent entries
                                    $fetchingAbsent = mysqli_query($db, "
                                            SELECT empname
                                            FROM absent
                                            WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
                                            AND DATE(AttendanceTime) = '$dateOfAttendance'
                                        ") or die(mysqli_error($db));

                                    $isAbsentAdded = mysqli_num_rows($fetchingAbsent);

                                    if ($isAbsentAdded > 0) {
                                        $absentText = '<span style="font-weight: 600; color:rgb(255, 23, 23); padding: 0.1em;">Ab</span>';
                                    }

                                    if ($isAttendanceAdded > 0) {
                                        // Display attendance data for weekdays
                                        $checkInText = '';
                                        $checkOutText = '';

                                        foreach ($EmployeeAttendanceArray as $EmployeeAttendance) {
                                            if ($EmployeeAttendance['AttendanceType'] == 'CheckIn') {
                                                $checkInText = '<span style="font-weight: 600; color:rgb(0, 146, 0); padding: 0.1em;">CI</span>';
                                            } elseif ($EmployeeAttendance['AttendanceType'] == 'CheckOut') {
                                                $checkOutText = '<span style="font-weight: 600; color:rgb(0, 146, 0); padding: 0.1em;">CO</span>';
                                            }
                                        }

                                        // Display attendance data for weekdays
                                        if ($checkInText !== '' && $checkOutText !== '') {
                                            $attendanceText .=  "<span style='font-weight: 600; color:rgb(0, 146, 0);'>P</span>";
                                        } elseif ($checkOutText !== '') {
                                            $attendanceText .= '!';
                                        } elseif ($checkInText !== '') {
                                            $attendanceText .= $checkInText;
                                        }
                                        $empName = $EmployeeAttendance['empname'];
                                    }
                                } elseif ($leaveEntry['leavetype'] == 'CASUAL LEAVE') {
                                    $attendanceText = '<span style="font-weight: 600; color:rgb(194, 124, 104); padding: 0.1em;">CL</span>';
                                } elseif ($leaveEntry['leavetype'] == 'SICK LEAVE') {
                                    $attendanceText = '<span style="font-weight: 600; color:rgb(194, 124, 104); padding: 0.1em;">SL</span>';
                                } elseif ($leaveEntry['leavetype'] == 'COMP. OFF') {
                                    $attendanceText = '<span style="font-weight: 600; color:rgb(194, 124, 104); padding: 0.1em;">CO</span>';
                                } elseif ($leaveEntry['leavetype'] == 'OFFICIAL LEAVE') {
                                    $attendanceText = '<span style="font-weight: 600; color:rgb(194, 124, 104); padding: 0.1em;">OL</span>';
                                } else {
                                    $attendanceText = '<span style="font-weight: 600; color:rgb(104, 104, 104); padding: 0.1em;">L</span>';
                                }
                            } else {
                                // Fetch attendance data for weekdays (excluding Sundays)
                                $fetchingEmployeesAttendance = mysqli_query($db, "
                                            SELECT CBA.AttendanceType, E.empname
                                            FROM CamsBiometricAttendance AS CBA
                                            INNER JOIN emp AS E ON CBA.UserID = E.UserID
                                            WHERE CBA.UserID = '" . $EmployeesIDsArray[$counter] . "'
                                            AND DATE(CBA.AttendanceTime) = '$dateOfAttendance'
                                        ") or die(mysqli_error($db));

                                $isAttendanceAdded = mysqli_num_rows($fetchingEmployeesAttendance);

                                // Store the fetched rows in an array
                                $EmployeeAttendanceArray = array();
                                while ($row = mysqli_fetch_assoc($fetchingEmployeesAttendance)) {
                                    $EmployeeAttendanceArray[] = $row;
                                }

                                $absentText = '';

                                // Check for absent entries
                                $fetchingAbsent = mysqli_query($db, "
                                            SELECT empname
                                            FROM absent
                                            WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
                                            AND DATE(AttendanceTime) = '$dateOfAttendance'
                                        ") or die(mysqli_error($db));

                                $isAbsentAdded = mysqli_num_rows($fetchingAbsent);

                                if ($isAbsentAdded > 0) {
                                    $absentText = '<span style="font-weight: 600; color:rgb(255, 23, 23); padding: 0.1em;">Ab</span>';
                                }

                                if ($isAttendanceAdded > 0) {
                                    // Display attendance data for weekdays
                                    $checkInText = '';
                                    $checkOutText = '';

                                    foreach ($EmployeeAttendanceArray as $EmployeeAttendance) {
                                        if ($EmployeeAttendance['AttendanceType'] == 'CheckIn') {
                                            $checkInText = '<span style="font-weight: 600; color:rgb(0, 146, 0);">CI</span>';
                                        } elseif ($EmployeeAttendance['AttendanceType'] == 'CheckOut') {
                                            $checkOutText = '<span style="font-weight: 600; color:rgb(0, 146, 0);">CO</span>';
                                        }
                                    }

                                    // Display attendance data for weekdays
                                    if ($checkInText !== '' && $checkOutText !== '') {
                                        $attendanceText .=  "<span style='font-weight: 600; color:rgb(0, 146, 0);'>P</span>";
                                    } elseif ($checkOutText !== '') {
                                        $attendanceText .= '<img style="margin-bottom:4px;" src="https://upload.wikimedia.org/wikipedia/commons/archive/3/3b/20180610093750%21OOjs_UI_icon_alert-warning.svg">';
                                    } elseif ($checkInText !== '') {
                                        $attendanceText .= $checkInText;
                                    }
                                    $empName = $EmployeeAttendance['empname'];
                                }

                                // If absent, override other values
                                if ($absentText !== '') {
                                    $attendanceText = $absentText;
                                }
                            }
                        }
                        $dateOfAttendance = date("Y-m-$j");
                        $currentDate = date("Y-m-d");
                        $isCurrentDate = ($dateOfAttendance == $currentDate);

                        // Set orange color for 'Sun' only in the current cell
                        $baseStyle = ($dayOfWeek == 7 && $isHoliday == 0) ? "background-color: orange; color: white;" : "";

                        // Add style for the current date
                        $currentDateStyle = ($isCurrentDate) ? "background-color: #E5E4E2;" : "";
                        $tdStyle = $baseStyle . ' ' . $currentDateStyle;
                        echo "<td style='$tdStyle'>" . $attendanceText . "</td>";
                    }

                    $ciCoColumn = mysqli_query($db, "
                            SELECT COUNT(DISTINCT DATE(AttendanceTime)) AS count
                            FROM CamsBiometricAttendance
                            WHERE UserID = '" . $EmployeesIDsArray[$counter] . "'
                            AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                            AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                            AND DAYOFWEEK(AttendanceTime) != 1  -- Exclude entries on Sunday
                            AND DATE(AttendanceTime) NOT IN (
                                SELECT date
                                FROM holiday
                            )
                            AND (
                                (AttendanceType = 'CheckIn' AND DATE(AttendanceTime) IN (
                                    SELECT DATE(AttendanceTime)
                                    FROM CamsBiometricAttendance
                                    WHERE UserID = '" . $EmployeesIDsArray[$counter] . "'
                                    AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                                    AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                                    AND AttendanceType = 'CheckOut'
                                    AND DAYOFWEEK(AttendanceTime) != 1  -- Exclude entries on Sunday
                                ))
                                OR (AttendanceType = 'CheckOut' AND DATE(AttendanceTime) IN (
                                    SELECT DATE(AttendanceTime)
                                    FROM CamsBiometricAttendance
                                    WHERE UserID = '" . $EmployeesIDsArray[$counter] . "'
                                    AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                                    AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                                    AND AttendanceType = 'CheckIn'
                                    AND DAYOFWEEK(AttendanceTime) != 1  -- Exclude entries on Sunday
                                ))
                            )
                        ") or die(mysqli_error($db));


                    $ciCoColumn1 = mysqli_query($db, "
                        SELECT COUNT(DISTINCT DATE(AttendanceTime)) AS count
                        FROM CamsBiometricAttendance
                        WHERE UserID = '" . $EmployeesIDsArray[$counter] . "'
                        AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                        AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                        AND (
                            (AttendanceType = 'CheckIn' AND DATE(AttendanceTime) IN (
                                SELECT DATE(AttendanceTime)
                                FROM CamsBiometricAttendance
                                WHERE UserID = '" . $EmployeesIDsArray[$counter] . "'
                                AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                                AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                                AND AttendanceType = 'CheckOut'
                                AND DAYOFWEEK(AttendanceTime) = 1  -- Select only entries on Sunday
                            ))
                            OR (AttendanceType = 'CheckOut' AND DATE(AttendanceTime) IN (
                                SELECT DATE(AttendanceTime)
                                FROM CamsBiometricAttendance
                                WHERE UserID = '" . $EmployeesIDsArray[$counter] . "'
                                AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                                AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                                AND AttendanceType = 'CheckIn'
                                AND DAYOFWEEK(AttendanceTime) = 1  -- Select only entries on Sunday
                            ))
                            OR DATE(AttendanceTime) IN (
                                SELECT date
                                FROM holiday
                                WHERE date >= '$firstDayOfMonth' AND date <= '$lastDayOfMonth'
                            )
                        )
                    ") or die(mysqli_error($db));



                    $firstDayOfMonth = date("Y-m-01");
                    $lastDayOfMonth = date("Y-m-t");

                    $absentColumn = mysqli_query($db, "
                                SELECT COUNT(empname) AS count
                                FROM absent
                                WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
                                AND AttendanceTime >= '$firstDayOfMonth'
                                AND AttendanceTime <= '$lastDayOfMonth 23:59:59'
                            ") or die(mysqli_error($db));

                    $leavesCountCL = mysqli_query($db, "
                            SELECT icl
                            FROM leavebalance 
                            WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
                        ") or die(mysqli_error($db));
                    $leavesCountSL = mysqli_query($db, "
                        SELECT isl
                        FROM leavebalance 
                        WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
                    ") or die(mysqli_error($db));
                    $leavesCountCO = mysqli_query($db, "
                    SELECT ico
                    FROM leavebalance 
                    WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
                ") or die(mysqli_error($db));

                    $leavesCountCCL = mysqli_query($db, "
                SELECT cl
                FROM leavebalance 
                WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
            ") or die(mysqli_error($db));
                    $leavesCountCSL = mysqli_query($db, "
            SELECT sl
            FROM leavebalance 
            WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
        ") or die(mysqli_error($db));
                    $leavesCountCCO = mysqli_query($db, "
        SELECT co
        FROM leavebalance 
        WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
    ") or die(mysqli_error($db));

                    $leavesDataCL = mysqli_query($db, "
                            SELECT `from`, `to`
                            FROM leaves 
                            WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
                                  AND ((status = 1 AND status1 = 1) OR (status = 1 AND status1 = 0)) 
                            AND leavetype = 'CASUAL LEAVE'
                            AND leavetype != 'HALF DAY'
                            AND leavetype != 'OFFICIAL LEAVE'
                            AND (
                                (`from` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                                OR (`to` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                                OR (`from` <= '$firstDayOfMonth' AND `to` >= '$lastDayOfMonth')
                            )
                        ") or die(mysqli_error($db));
                    $leavesDataSL = mysqli_query($db, "
                        SELECT `from`, `to`
                        FROM leaves 
                        WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
                              AND ((status = 1 AND status1 = 1) OR (status = 1 AND status1 = 0)) 
                        AND leavetype = 'SICK LEAVE'
                        AND leavetype != 'HALF DAY'
                        AND leavetype != 'OFFICIAL LEAVE'
                        AND (
                            (`from` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                            OR (`to` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                            OR (`from` <= '$firstDayOfMonth' AND `to` >= '$lastDayOfMonth')
                        )
                    ") or die(mysqli_error($db));
                    $leavesDataCO = mysqli_query($db, "
                    SELECT `from`, `to`
                    FROM leaves 
                    WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
                          AND ((status = 1 AND status1 = 1) OR (status = 1 AND status1 = 0)) 
                    AND leavetype = 'COMP. OFF'
                    AND leavetype != 'HALF DAY'
                    AND leavetype != 'OFFICIAL LEAVE'
                    AND (
                        (`from` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                        OR (`to` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                        OR (`from` <= '$firstDayOfMonth' AND `to` >= '$lastDayOfMonth')
                    )
                ") or die(mysqli_error($db));
                    $leavesData = mysqli_query($db, "
                            SELECT `from`, `to`
                            FROM leaves 
                            WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
                                  AND ((status = 1 AND status1 = 1) OR (status = 1 AND status1 = 0)) 
                            AND leavetype != 'HALF DAY'
                            AND leavetype != 'OFFICIAL LEAVE'
                            AND (
                                (`from` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                                OR (`to` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                                OR (`from` <= '$firstDayOfMonth' AND `to` >= '$lastDayOfMonth')
                            )
                        ") or die(mysqli_error($db));
                    $leavesData1 = mysqli_query($db, "
                    SELECT `from`, `to`
                    FROM leaves
                    WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
                    AND ((status = 1 AND status1 = 1) OR (status = 1 AND status1 = 0)) 
                    AND leavetype = 'HALF DAY'
                    AND (
                        (`from` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                        OR (`to` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                        OR (`from` <= '$firstDayOfMonth' AND `to` >= '$lastDayOfMonth')
                    )
                ") or die(mysqli_error($db));

                    $leavesData2 = mysqli_query($db, "
                SELECT `from`, `to`
                FROM leaves
                WHERE leavetype ='OFFICIAL LEAVE'
                    AND empname = '" . $EmployeesNamesArray[$counter] . "'
                    AND (
                        (status = 1 AND status1 = 1) OR
                        (status = 1 AND status1 = 0)
                    ) 
            ") or die(mysqli_error($db));
                    $fetchingLeaves1 = mysqli_query($db, "
    SELECT empname, leavetype
    FROM leaves
    WHERE leavetype = 'OFFICIAL LEAVE'
        AND empname = '" . $EmployeesNamesArray[$counter] . "'
        AND DATE(`from`) <= '$dateOfAttendance'
        AND DATE(`to`) >= '$dateOfAttendance'
        AND ((status = 1 AND status1 = 1) OR (status = 1 AND status1 = 0)) 
") or die(mysqli_error($db));
                    $leaveEntry1 = mysqli_fetch_assoc($fetchingLeaves1);


                    $leaveCountCL = 0;
                    while ($leaveEntry = mysqli_fetch_assoc($leavesDataCL)) {
                        $from = strtotime($leaveEntry['from']);
                        $to = strtotime($leaveEntry['to']);

                        // Calculate leave duration in days, excluding Sundays
                        for ($k = 0; $k <= $to - $from; $k += 24 * 60 * 60) {
                            $currentDay = date('N', $from + $k);
                            if ($currentDay != 7 && $from + $k >= strtotime($firstDayOfMonth) && $from + $k <= strtotime($lastDayOfMonth)) {
                                $leaveCountCL++;
                            }
                        }
                    }
                    $leaveCountSL = 0;
                    while ($leaveEntry = mysqli_fetch_assoc($leavesDataSL)) {
                        $from = strtotime($leaveEntry['from']);
                        $to = strtotime($leaveEntry['to']);

                        // Calculate leave duration in days, excluding Sundays
                        for ($k = 0; $k <= $to - $from; $k += 24 * 60 * 60) {
                            $currentDay = date('N', $from + $k);
                            if ($currentDay != 7 && $from + $k >= strtotime($firstDayOfMonth) && $from + $k <= strtotime($lastDayOfMonth)) {
                                $leaveCountSL++;
                            }
                        }
                    }
                    $leaveCountCO = 0;
                    while ($leaveEntry = mysqli_fetch_assoc($leavesDataCO)) {
                        $from = strtotime($leaveEntry['from']);
                        $to = strtotime($leaveEntry['to']);

                        // Calculate leave duration in days, excluding Sundays
                        for ($k = 0; $k <= $to - $from; $k += 24 * 60 * 60) {
                            $currentDay = date('N', $from + $k);
                            if ($currentDay != 7 && $from + $k >= strtotime($firstDayOfMonth) && $from + $k <= strtotime($lastDayOfMonth)) {
                                $leaveCountCO++;
                            }
                        }
                    }
                    // Initialize leave count
                    $leaveCount = 0;
                    while ($leaveEntry = mysqli_fetch_assoc($leavesData)) {
                        $from = strtotime($leaveEntry['from']);
                        $to = strtotime($leaveEntry['to']);

                        // Calculate leave duration in days, excluding Sundays
                        for ($k = 0; $k <= $to - $from; $k += 24 * 60 * 60) {
                            $currentDay = date('N', $from + $k);
                            if ($currentDay != 7 && $from + $k >= strtotime($firstDayOfMonth) && $from + $k <= strtotime($lastDayOfMonth)) {
                                $leaveCount++;
                            }
                        }
                    }

                    $leaveCount1 = 0;
                    while ($leaveEntry = mysqli_fetch_assoc($leavesData1)) {
                        $from = strtotime($leaveEntry['from']);
                        $to = strtotime($leaveEntry['to']);

                        // Calculate leave duration in days, excluding Sundays
                        for ($k = 0; $k <= $to - $from; $k += 24 * 60 * 60) {
                            $currentDay = date('N', $from + $k);
                            if ($currentDay != 7 && $from + $k >= strtotime($firstDayOfMonth) && $from + $k <= strtotime($lastDayOfMonth)) {
                                $leaveCount1 += 0.5; // Increment by 0.5 for each valid leave day
                            }
                        }
                    }

                    $leaveCount2 = 0;
                    while ($leaveEntry1 = mysqli_fetch_assoc($leavesData2)) {
                        $from = strtotime($leaveEntry1['from']);
                        $to = strtotime($leaveEntry1['to']);

                        for ($k = 0; $k <= $to - $from; $k += 24 * 60 * 60) {
                            $currentDay = date('N', $from + $k);
                            if ($currentDay != 7 && $from + $k >= strtotime($firstDayOfMonth) && $from + $k <= strtotime($lastDayOfMonth)) {
                                $leaveCount2++;
                            }
                        }
                    }
                    // Calculate the number of working days in the current month, excluding Sundays and holidays
                    $totalWorkingDays = $totalDaysInMonth - $sundaysCount;

                    $fetchingHolidays = mysqli_query($db, "
                    SELECT COUNT(DISTINCT date) AS count
                    FROM holiday
                    WHERE date >= '$firstDayOfMonth'
                    AND date <= '$lastDayOfMonth'
                ") or die(mysqli_error($db));

                    $currentDays1 = date('Y-m-d');

                    // SQL query to fetch count of distinct dates until the current date
                    $fetchingHolidays1 = mysqli_query($db, "
SELECT COUNT(DISTINCT date) AS count
          FROM holiday
          WHERE date >= '$firstDayOfMonth'
          AND date <= '$currentDays1'
") or die(mysqli_error($db));

                    // Get the current day of the month
                    $currentDayOfMonth = date('j');

                    // Calculate the number of days till the current day
                    $totalDaysTillCurrentDay = 0;
                    for ($j = 1; $j <= $currentDayOfMonth; $j++) {
                        $totalDaysTillCurrentDay++;
                    }
                    $sundaysCount1 = 0;
                    for ($j = 1; $j <= $currentDayOfMonth; $j++) {
                        $dateOfAttendance = date("Y-m-$j");
                        $dayOfWeek = date('N', strtotime($dateOfAttendance));
                        if ($dayOfWeek == 7) {
                            $sundaysCount1++;
                        }
                    }



                    $holidaysCount = mysqli_fetch_assoc($fetchingHolidays)['count'];
                    $holidaysCount1 = mysqli_fetch_assoc($fetchingHolidays1)['count'];
                    $absentCount = mysqli_fetch_assoc($absentColumn)['count'];
                    $ciCoCount = mysqli_fetch_assoc($ciCoColumn)['count'];
                    $ciCoCount2 = mysqli_fetch_assoc($ciCoColumn1)['count'];
                    $CLresult = mysqli_fetch_assoc($leavesCountCL);
                    $iclValue = isset($CLresult['icl']) ? $CLresult['icl'] : '0';
                    $SLresult = mysqli_fetch_assoc($leavesCountSL);
                    $islValue = isset($SLresult['isl']) ? $SLresult['isl'] : '0';
                    $COresult = mysqli_fetch_assoc($leavesCountCO);
                    $icoValue = isset($COresult['ico']) ? $COresult['ico'] : '0';

                    $CCLresult = mysqli_fetch_assoc($leavesCountCCL);
                    $cclValue = isset($CCLresult['cl']) ? $CCLresult['cl'] : '0';
                    $CSLresult = mysqli_fetch_assoc($leavesCountCSL);
                    $cslValue = isset($CSLresult['sl']) ? $CSLresult['sl'] : '0';
                    $CCOresult = mysqli_fetch_assoc($leavesCountCCO);
                    $ccoValue = isset($CCOresult['co']) ? $CCOresult['co'] : '0';
                    // Calculate the number of working days in the current month
                    $ciCoCount = $ciCoCount - $leaveCount1;
                    // $totalleavesCount = $leaveCount + $leaveCount1;  $totalleavesCount
                    $totalleavesCount = $cclValue +  $cslValue;
                    $ciCoCount1 = $ciCoCount + $leaveCount2 - $holidaysCount;
                    $totalWorkingDays = $totalDaysInMonth - $sundaysCount - $holidaysCount;
                    $CurrentDays = $totalDaysTillCurrentDay - $sundaysCount1 - $holidaysCount1;
                    $attendancePercentage = ($ciCoCount1 / $totalWorkingDays) * 100;
                    $totalLeavesValue = $iclValue +  $islValue;
                    $totalLeavesValue1 = $iclValue +  $islValue + $icoValue;
                    $currentLeavesValue = $cclValue +  $cslValue + $ccoValue;
                    $fontWeightStyle = ($totalleavesCount < 0) ? 'bold' : 'normal';
                    $fontWeightStyle1 = ($leaveCountSL > $islValue) ? 'bold' : 'normal';
                    $fontWeightStyle2 = ($currentLeavesValue < 0) ? 'bold' : 'normal';
                    echo "<td style='background-color:rgb(200, 10, 25);color:white;text-align:center;'> $absentCount</td>";
                    echo "<td style='background-color:silver;color:black;text-align:center;font-weight: $fontWeightStyle;'>$totalleavesCount/$totalLeavesValue</td>";
                    echo "<td style='background-color:silver;color:black;text-align:center;'>$ccoValue/$icoValue</td>";
                    echo "<td style='background-color:silver;color:black;text-align:center;font-weight: $fontWeightStyle2;'>$currentLeavesValue/$totalLeavesValue1</td>";
                    echo "<td style='background-color:#dcdcdc;color:black;text-align:center;'>$ciCoCount2</td>";
                    echo "<td style='background-color:rgb(40, 200, 85);color:black;text-align:center;'>$ciCoCount/$CurrentDays</td>";
                    echo "<td style='background-color:rgb(1, 100, 255);color:white;text-align:center;'>$ciCoCount1/$totalWorkingDays</td>";
                    echo "<td style='background-color:rgb(1, 100, 255);color:white;text-align:center;'>" . round($attendancePercentage, 2) . "%</td>";
                    $caRecord = mysqli_query($db, "
                            SELECT COUNT(empname) AS count, MAX(confirmed) AS confirmedValue
                            FROM CA
                            WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
                            AND submissionTime >= '$firstDayOfMonth'
                            AND submissionTime <= '$lastDayOfMonth 23:59:59'
                        ") or die(mysqli_error($db));

                    $caData = mysqli_fetch_assoc($caRecord);
                    $caCount = $caData['count'];
                    $confirmedValue = $caData['confirmedValue'];

                    if ($caCount > 0) {
                        // If there are records for the employee in the specified time range
                        if ($confirmedValue === 'self') {
                            $confirmedText = 'Yes';
                        } elseif ($confirmedValue === 'mgr') {
                            $confirmedText = 'Mgr-C';
                        } elseif ($confirmedValue === 'hr') {
                            $confirmedText = 'HR-C';
                        } else {
                            // Handle other cases if needed
                            $confirmedText = ''; // Default case
                        }
                    } else {
                        $confirmedText = ''; // No records for the employee
                    }


                    $currentDate = date('Y-m-d');
                    $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));

                    if ($currentDate === $lastDayOfMonth) {
                        echo "<td style='background-color: lightgreen;text-align:center;'>$confirmedText</td>";
                    } else {
                        echo "";
                    }


                    echo "</tr>";
                    $counter++;
                }
            }
            ?>
        </table>
    </form>
    <div style="text-align: center; margin-top: 20px;">
        <div style="display: inline-block; margin-right: 10px;">INDICATIONS:</div>
        <div style="display: inline-block; margin-right: 10px;">SL: Sick Leave</div>
        <div style="display: inline-block; margin-right: 10px;">CL: Casual Leave</div>
        <div style="display: inline-block; margin-right: 10px;">HDL: Half Day Leave</div>

        <div style="display: inline-block; margin-right: 10px;">CO: Compensatory Off</div>
        <div style="display: inline-block; margin-right: 10px;">AWD: Additional Worked days</div>
        <div style="display: inline-block; margin-right: 10px;">TL: Total leaves</div>
        <div style="display: inline-block; margin-right: 10px;">LB: Leave balance</div>
        <div style="display: inline-block; margin-right: 10px;">NWD: Net Working Days</div>
        <div style="display: inline-block;">AP: Attendance Percentage</div>
    </div>
    <!-- <h4 style="text-align: center;">@ANIKA STERILIS | WWW.ANIKASTERILIS.COM</h4> -->
    </div>
    <!--<div style="margin-top:-30px; float: right;">-->
    <!--    <br><br><br>-->
    <!--    __________________-->
    <!--    <p>Authorised Signatory</p>-->
    <!--</div>-->
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