<!DOCTYPE html>
<?php
require_once("dbConfig.php");
$currentDate = date("Y-m-d");
$firstDayOfMonth = date("Y-m-01");
$totalDaysInMonth = date("t", strtotime($firstDayOfMonth));

// Fetching Employees 
$fetchingEmployees = mysqli_query($db, "SELECT * FROM emp
WHERE empstatus = 0 AND desg = 'SECURITY GAURDS'
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
  /* margin-top: -120px; */
  /* padding: 1rem; */
}

.missing-wrapper {
  /* width: 50%; */
  margin-top: -60px;
}

    </style>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<?php
  $currentDateTime = date("Y-m-d H:i:s", strtotime("+5 hours 30 mins"));
    echo "<p style='font-family: monospace ;font-size:15px;'>Attendance sheet generated on: $currentDateTime</p>";
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
<h3 style="text-align: center;"><u> Security Gaurd's Attendance Sheet</u> </h3>
<div style=" position: relative;">
<p> Month: <b><?php echo date("F Y"); ?></b></p><?php
 $serialNumberQuery = "SELECT MAX(serial_number) AS max_serial FROM pdf_table WHERE month_year = ?";
 $stmt = mysqli_prepare($db, $serialNumberQuery);
 $currentMonthYear = date("m-Y");
 mysqli_stmt_bind_param($stmt, "s", $currentMonthYear);
 mysqli_stmt_execute($stmt);

 $result = mysqli_stmt_get_result($stmt);
 $row = mysqli_fetch_assoc($result);
 $serialNumber = ($row['max_serial'] !== null) ? $row['max_serial'] + 1 : 1;
 echo "<p class='report-no'>Report No: <b>ASPL/HR/AS/" . date('Ymd') . "/0$serialNumber</b></p>";
 mysqli_stmt_close($stmt);
 ?>
</div>
<form method="post" action="">
<table border="1" style="border-color: rgb(170, 170, 170);scale:0.9; " cellspacing="0" class="table table-bordered table-hover">
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
                            echo "<tr>";
                            echo "<td rowspan='2'>Employee Name</td>";
                            for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                                echo "<td>$j</td>";
                            }
                            echo "<td colspan='5' style='text-align:center;'>Total</td>";
                            $currentDate = date('Y-m-d');
                            $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));

                            if ($currentDate === $lastDayOfMonth) {
                                echo "<td rowspan='2' >Confirmed by employee</td>";
                            } else {
                                echo "";
                            }
                            echo "</tr>";
                        } else if ($i == 2) {
                            echo "<tr>";
                            for ($j = 0; $j < $totalDaysInMonth; $j++) {
                                echo "<td>" . date("D", strtotime("+$j days", strtotime($firstDayOfMonth))) . "</td>";
                            }
                            echo "<td>Absent</td>";
                            echo "<td>Week Off(s)</td>";
                            echo "<td>Present</td>";
                            echo "<td>NWD</td>";
                            echo "<td>AP(%)</td>";
                            echo "</tr>";
                        } else {
                            echo "<tr>";
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

                                // Default value for non-holiday
                                $attendanceText = '';

                                $dayCI = '';
                                $nightCO = '';
                                $dayCO = '';
                                $nightCI = '';
                                if ($dayOfWeek != 7) {
                                    // Check for leaves entries

                                    $fetchingLeaves = mysqli_query($db, "
                                    SELECT empname, leavetype
                                    FROM leaves
                                    WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
                                    AND DATE(`from`) <= '$dateOfAttendance'
                                    AND DATE(`to`) >= '$dateOfAttendance'
                                    AND status = 1
                                    AND status1 = 1
                                ") or die(mysqli_error($db));

                                    $isLeavesAdded = mysqli_num_rows($fetchingLeaves);

                                    if ($isLeavesAdded > 0) {
                                        $leaveEntry = mysqli_fetch_assoc($fetchingLeaves);

                                        // Check the leavetype and set the attendance text accordingly
                                        if ($leaveEntry['leavetype'] == 'HALF DAY') {
                                            $attendanceText = '<span style="font-weight: 600; color:rgb(104, 104, 104); padding: 0.1em;">HDL</span>';

                                            // Fetch attendance data for weekdays (excluding Sundays)
                                            $fetchingEmployeesAttendance = mysqli_query($db, "
                                            SELECT CBA.AttendanceType, CBA.AttendanceTime, E.empname
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

                                                foreach ($EmployeeAttendanceArray as $EmployeeAttendance) {
                                                    if ($EmployeeAttendance['AttendanceType'] == 'CheckIn') {
                                                        // Check if CheckIn time is between 07:00:00 and 09:00:00
                                                        $attendanceTime = strtotime($EmployeeAttendance['AttendanceTime']);
                                                        if ($attendanceTime >= strtotime('07:00:00') && $attendanceTime <= strtotime('09:00:00')) {
                                                            $dayCI = '<span style="font-weight: 600; color:rgb(0, 146, 0);">CI</span>';
                                                        }
                                                    } elseif ($EmployeeAttendance['AttendanceType'] == 'CheckOut') {
                                                        // Check if CheckOut time is between 17:00:00 and 20:00:00
                                                        $attendanceTime = strtotime($EmployeeAttendance['AttendanceTime']);
                                                        if ($attendanceTime >= strtotime('17:00:00') && $attendanceTime <= strtotime('20:00:00')) {
                                                            $nightCO = '<span style="font-weight: 600; color:rgb(0, 146, 0);">CO</span>';
                                                        }
                                                    }
                                                }

                                                // Display attendance data for weekdays
                                                if ($checkInText !== '' && $checkOutText !== '') {
                                                    $attendanceText .= $checkInText . ":" . $checkOutText;
                                                } elseif ($checkOutText !== '') {
                                                    $attendanceText .= $checkOutText;
                                                } elseif ($checkInText !== '') {
                                                    $attendanceText .= $checkInText;
                                                }
                                                $empName = $EmployeeAttendance['empname'];
                                            }
                                        } else {
                                            $attendanceText = '<span style="font-weight: 600; color:rgb(104, 104, 104); padding: 0.1em;">L</span>';
                                        }
                                    } else {
                                        // Fetch attendance data for weekdays (excluding Sundays)
                                        $fetchingEmployeesAttendance = mysqli_query($db, "
                                        SELECT CBA.AttendanceType, CBA.AttendanceTime, E.empname
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

                                            usort($EmployeeAttendanceArray, function($a, $b) {
                                                return strcmp($a['AttendanceType'], $b['AttendanceType']);
                                            });
                                           
                                            foreach ($EmployeeAttendanceArray as $EmployeeAttendance) {
                                                $attendanceTime = strtotime($EmployeeAttendance['AttendanceTime']);
                                                if ($EmployeeAttendance['AttendanceType'] == 'CheckIn') {
                                                    // Check if CheckIn time is between 07:00:00 and 09:00:00
                                                    if (date('H:i:s', $attendanceTime) >= '07:00:00' && date('H:i:s', $attendanceTime) <= '09:00:00') {
                                                        $dayCI = '<span style="color:rgb(0, 146, 0);">DCI</span>';
                                                    }
                                                    // Check if CheckIn time is between 17:00:00 and 20:00:00
                                                    if (date('H:i:s', $attendanceTime) >= '17:00:00' && date('H:i:s', $attendanceTime) <= '20:00:00') {
                                                        $nightCI = '<span style="color:rgb(0, 146, 0);">NCI</span>';
                                                    }
                                                } elseif ($EmployeeAttendance['AttendanceType'] == 'CheckOut') {
                                                    // Check if CheckOut time is between 17:00:00 and 20:00:00
                                                    if (date('H:i:s', $attendanceTime) >= '17:00:00' && date('H:i:s', $attendanceTime) <= '20:00:00') {
                                                        $nightCO = '<span style="color:rgb(0, 146, 0);">NCO</span>';
                                                    }
                                                    // Check if CheckOut time is between 07:00:00 and 09:00:00
                                                    if (date('H:i:s', $attendanceTime) >= '07:00:00' && date('H:i:s', $attendanceTime) <= '09:00:00') {
                                                        $dayCO = '<span style=" color:rgb(0, 146, 0);">DCO</span>';
                                                    }
                                                }
                                            }

                                            // Now construct the attendanceText based on the conditions
                                            if ($dayCI !== '' && $nightCO !== '') {
                                                $attendanceText .= $dayCI . " " . $nightCO;
                                            } elseif ($nightCO !== '') {
                                                $attendanceText .= $nightCO;
                                            } elseif ($dayCI !== '') {
                                                $attendanceText .= $dayCI;
                                            }

                                            if ($dayCO !== '' && $nightCI !== '') {
                                                $attendanceText .= $dayCO . " " . $nightCI;
                                            } elseif ($nightCI !== '') {
                                                $attendanceText .= $nightCI;
                                            } elseif ($dayCO !== '') {
                                                $attendanceText .= $dayCO;
                                            }
                                            $empName = $EmployeeAttendance['empname'];
                                        }

                                        // If absent, override other values
                                        if ($absentText !== '') {
                                            $attendanceText = $absentText;
                                        }
                                    }
                                }

                                echo "<td>
                                <table>
                                    <tr id='day'>
                                        <td>";
                                        // Check if CheckIn is before CheckOut
                                        if ($dayCI !== '' && $dayCO !== '') {
                                            echo "$dayCO $dayCI";
                                        } else {
                                            echo "$dayCI $dayCO";
                                        }
                            echo "</td>
                                    </tr>
                                    <tr id='night' >
                                        <td>
                                            <hr>";
                                            // Check if CheckIn is before CheckOut
                                            if ($nightCO !== '' && $nightCI !== '') {
                                                echo "$nightCO $nightCI";
                                            } else {
                                                echo " $nightCI $nightCO";
                                            }
                            echo "</td>
                                    </tr>
                                </table>
                            </td>";
                            
                            }
                            $firstDayOfMonth = date("Y-m-01");
                            $lastDayOfMonth = date("Y-m-t");

                            $ciCoColumn = mysqli_query($db, "
                            SELECT COUNT(*) AS count
                            FROM CamsBiometricAttendance
                            WHERE UserID = '" . $EmployeesIDsArray[$counter] . "'
                            AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                            AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                            AND AttendanceType = 'CheckIn'
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


                            $leavesData = mysqli_query($db, "
                            SELECT `from`, `to`
                            FROM leaves
                            WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
                            AND status = 1
                            AND status1 = 1
                            AND leavetype != 'HALF DAY'
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
                    AND status = 1
                    AND status1 = 1
                    AND leavetype = 'HALF DAY'
                    AND (
                        (`from` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                        OR (`to` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                        OR (`from` <= '$firstDayOfMonth' AND `to` >= '$lastDayOfMonth')
                    )
                ") or die(mysqli_error($db));


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
                            // Calculate the number of working days in the current month, excluding Sundays and holidays
                            $totalWorkingDays = $totalDaysInMonth - $sundaysCount;

                            $fetchingHolidays = mysqli_query($db, "
                    SELECT COUNT(DISTINCT date) AS count
                    FROM holiday
                    WHERE date >= '$firstDayOfMonth'
                    AND date <= '$lastDayOfMonth'
                ") or die(mysqli_error($db));

                            $holidaysCount = mysqli_fetch_assoc($fetchingHolidays)['count'];

                            $absentCount = mysqli_fetch_assoc($absentColumn)['count'];
                            $ciCoCount = mysqli_fetch_assoc($ciCoColumn)['count'];

                            // Calculate the number of working days in the current month
                            $ciCoCount = $ciCoCount - $leaveCount1;
                            $totalleavesCount = $leaveCount + $leaveCount1;
                            $ciCoCount1 = $ciCoCount;
                            $totalWorkingDays = $totalDaysInMonth;
                            $attendancePercentage = ($ciCoCount1 / $totalWorkingDays) * 100;

                            echo "<td style='background-color:rgb(200, 10, 25);color:white;text-align:center;'> $absentCount</td>";
                            echo "<td style='background-color:silver;color:black;text-align:center;'>$totalleavesCount</td>";
                            echo "<td style='background-color:rgb(40, 200, 85);color:black;text-align:center;'>$ciCoCount</td>";
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
        <div style="display: inline-block; margin-right: 10px;">INDICATIONS =</div>
        <div style="display: inline-block; margin-right: 10px;">Ab: Absent</div>
        <div style="display: inline-block; margin-right: 10px;">DCI:Day CheckedIn</div>
        <div style="display: inline-block; margin-right: 10px;">DCO:Day CheckedOut</div>
        <div style="display: inline-block; margin-right: 10px;">NCI:Night CheckedIn</div>
        <div style="display: inline-block; margin-right: 10px;">NCO:Night CheckedOut</div>
        <div style="display: inline-block; margin-right: 10px;">!: Check Attendance Log</div>
        <div style="display: inline-block; margin-right: 10px;">NWD: Net Working Days</div>
        <div style="display: inline-block; ">AP: Attendance Percentage</div>
    </div>
   <!-- <h4 style="text-align: center;">@ANIKA STERILIS | WWW.ANIKASTERILIS.COM</h4> -->
</div>

</body>
</html>