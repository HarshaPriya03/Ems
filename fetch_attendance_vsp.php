<?php
// Establish database connection
require_once("dbConfig.php");

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}

// Check if monthYear parameter is set
if(isset($_GET['monthYear'])) {
    $monthYear = $_GET['monthYear'];
    
    $selectedMonthYear = explode("-", $monthYear);
    $selectedMonth = $selectedMonthYear[1];
    $selectedYear = $selectedMonthYear[0];

// Calculate the first and last day of the selected month
$firstDayOfMonth = date("Y-m-01", strtotime($selectedYear . "-" . $selectedMonth . "-01"));
$lastDayOfMonth = date("Y-m-t", strtotime($selectedYear . "-" . $selectedMonth . "-01"));
$totalDaysInMonth = date("t", strtotime($firstDayOfMonth));

    
    // Fetch data from database based on selected month and year
    $fetchingEmployees = mysqli_query($db, "SELECT * FROM emp
    WHERE empstatus = 0 AND desg != 'SECURITY GAURDS'
    AND ServiceTagId = 'ZXQI19009096'
    ORDER BY emp_no ASC;") or die(mysqli_error($db));
    
    $totalNumberOfEmployees = mysqli_num_rows($fetchingEmployees);
    
    $EmployeesNamesArray = array();
    $EmployeesIDsArray = array();
    $counter = 0;
    $cnt = 1;

    // Check if data is found
    while ($Employees = mysqli_fetch_assoc($fetchingEmployees)) {
        $EmployeesNamesArray[] = $Employees['empname'];
        $EmployeesIDsArray[] = $Employees['UserID'];
    }
            $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth)) . ' 23:59:59';
            // Calculate the number of Sundays in the current month
            $sundaysCount = 0;
            for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                $dateOfAttendance = date("Y-m-$j", strtotime($selectedYear . "-" . $selectedMonth . "-$j"));
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
                    echo "<td class='static-cell'>AWD</td>";
                    echo "<td class='static-cell'>NWD</td>";
                    echo "<td class='static-cell'>AP(%)</td>";
                    echo "<td >Confirmed by employee</td>";
                    echo "</tr>";
                } else {
            echo "<tr>";
            echo "<td>" . $cnt++ . "</td>";
            echo "<td>" . $EmployeesNamesArray[$counter] . "</td>";

            $color = "";
            for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                $dateOfAttendance = date("Y-m-$j", strtotime($selectedYear . "-" . $selectedMonth . "-$j"));

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
                $dateOfAttendance = date("Y-m-$j", strtotime($selectedYear . "-" . $selectedMonth . "-$j"));
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


            $firstDayOfMonth = date("Y-m-01", strtotime($selectedYear . "-" . $selectedMonth . "-01"));
$lastDayOfMonth = date("Y-m-t", strtotime($selectedYear . "-" . $selectedMonth . "-01"));

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
                    $currentDayTimestamp = $from + $k;
                    $currentDay = date('N', $currentDayTimestamp);
                    $currentDate = date('Y-m-d', $currentDayTimestamp);
                    
                    // Check if the current day is not a holiday
                    $isHoliday = false;
                    $fetchingHolidays1 = mysqli_query($db, "
                        SELECT * FROM holiday
                        WHERE date = '$currentDate'
                    ") or die(mysqli_error($db));
            
                    if (mysqli_num_rows($fetchingHolidays1) > 0) {
                        $isHoliday = true;
                    }
            
                    if ($currentDay != 7 && $currentDate >= $firstDayOfMonth && $currentDate <= $lastDayOfMonth && !$isHoliday) {
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
WHERE date <= '$currentDays1'
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
            $ciCoCount1 = $ciCoCount + $leaveCount2;
            $totalWorkingDays = $totalDaysInMonth - $sundaysCount - $holidaysCount;
            $CurrentDays = $totalDaysTillCurrentDay - $sundaysCount1;
            $attendancePercentage = ($ciCoCount1 / $totalWorkingDays) * 100;
            $totalLeavesValue = $iclValue +  $islValue;
            $totalLeavesValue1 = $iclValue +  $islValue + $icoValue;
            $currentLeavesValue = $cclValue +  $cslValue + $ccoValue;
            $fontWeightStyle = ($totalleavesCount < 0) ? 'bold' : 'normal';
            $fontWeightStyle1 = ($leaveCountSL > $islValue) ? 'bold' : 'normal';
            $fontWeightStyle2 = ($currentLeavesValue < 0) ? 'bold' : 'normal';
            echo "<td style='background-color:rgb(200, 10, 25);color:white;text-align:center;'> $absentCount</td>";
            echo "<td style='background-color:#dcdcdc;color:black;text-align:center;'>$ciCoCount2</td>";
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
            echo "<td style='background-color: lightgreen;text-align:center;'>$confirmedText</td>";

            $currentDate = date('Y-m-d');
            $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));

            if ($currentDate === $lastDayOfMonth) {
                echo "<td style='background-color: lightgreen;text-align:center;'>$confirmedText</td>";
            } else {
                echo "";
            }


            echo "</tr>";
            $counter++;
        }}
} else {
    // If monthYear parameter is not set, redirect to homepage or display an error message
    echo "Error: Month and year parameter not provided.";
}
?>
