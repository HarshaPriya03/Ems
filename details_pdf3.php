<!DOCTYPE html>
<?php
require_once("dbConfig.php");

$firstDayOfMonth = date("Y-m-01");
$totalDaysInMonth = date("t", strtotime($firstDayOfMonth));

// Fetching Employees 
$fetchingEmployees = mysqli_query($db, "SELECT * FROM emp WHERE empemail = '{$_SESSION['user_name']}'") or die(mysqli_error($db));
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
        header{
            color:black !important; 
        }
        .badge-success {
  background-color: #5cb85c; 
}
.badge-warning{
    
    background-color: #f0ad4e;
}
.badge-danger{
    background-color: #d9534f;
}
.emage {
  display: inline-block;
  overflow: hidden;
  position: relative;
left:30%;
bottom:1.5%;
  width: 100%;
  height: 5%;
}
.eemage{
    z-index: -100;
    position: absolute;
    top: 7%;
    left: 20%;
}
    </style>
   
</head>
<?php
  $currentDateTime = date("Y-m-d H:i:s", strtotime("+4 hours 30 mins"));
    echo "<p style='font-family: monospace ;font-size:15px;'>Attendance sheet generated on: $currentDateTime</p>";
    ?>
<div style='display:block;margin-left:auto;margin-right:auto;width:110px;'>
<img alt='logo'  src='https://ik.imagekit.io/akkldfjrf/Anika_logo%20(1).jpg?updatedAt=1691746754121' width=100px height=80px>
</div><br>

<header style="text-align:center;">
        <a class="header" href="" style="Font-size:30px;text-decoration:none !important;">Anika Sterilis Private Limited</a>
	
    <p style="text-align:center;">Anika ONE, AMTZ Campus,Pragati Maidan,VM Steel Project S.O,Visakhapatnam,Andhra Pradesh-530031</p>
    <p style="text-align:center;">Phone: 0891-5193101 | Email: info@anikasterilis.com</p>
    </header>
    <hr>
    
<body>
<h3 style="text-align: center;"><u>Attendance Sheet</u></h3>
<form method="post" action="">
<table border="1" style="border-color: rgb(170, 170, 170);scale:0.9; " cellspacing="0" class="table table-bordered table-hover">
                    <?php
                    $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth)). ' 23:59:59';
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
                            echo "<td>Leaves</td>";
                            echo "<td>Present</td>";
                            echo "<td>NWD</td>";
                            echo "<td>AP(%)</td>";
                            echo "</tr>";
                        } else {
                            echo "<tr>";
                            echo "<td>" . $EmployeesNamesArray[$counter] ."</td>";
                
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
                    
                             // Default value for non-holiday
                $attendanceText = '';
                
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
                                                $attendanceText .= $checkInText . " " . $checkOutText;
                                            } elseif ($checkOutText !== '') {
                                                $attendanceText .= $checkOutText;
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
                
                                // Set orange color for 'Sun' only in the current cell
                                $tdStyle = ($dayOfWeek == 7 && $isHoliday == 0) ? "style='background-color: orange; color: white'" : "";
                
                                echo "<td $tdStyle>" . $attendanceText . "</td>";
                                
                            }
                            $ciCoColumn = mysqli_query($db, "
                            SELECT COUNT(*) AS count
                            FROM (
                                SELECT DISTINCT a.AttendanceDate
                                FROM (
                                    SELECT DATE(AttendanceTime) AS AttendanceDate
                                    FROM CamsBiometricAttendance
                                    WHERE UserID = '" . $EmployeesIDsArray[$counter] . "'
                                    AND MONTH(AttendanceTime) = 1
                                    AND YEAR(AttendanceTime) = 2024
                                    AND AttendanceType = 'CheckIn'
                                ) AS a
                                JOIN (
                                    SELECT DATE(AttendanceTime) AS AttendanceDate
                                    FROM CamsBiometricAttendance
                                    WHERE UserID = '" . $EmployeesIDsArray[$counter] . "'
                                    AND MONTH(AttendanceTime) = 1
                                    AND YEAR(AttendanceTime) = 2024
                                    AND AttendanceType = 'CheckOut'
                                ) AS b ON DATEDIFF(b.AttendanceDate, a.AttendanceDate) <= 1
                            ) AS matching_pairs
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
                            $ciCoCount= $ciCoCount-$leaveCount1;
                            $totalleavesCount = $leaveCount+$leaveCount1 ;
                            $ciCoCount1 = $ciCoCount;
                            $totalWorkingDays = $totalDaysInMonth;
                            $attendancePercentage = ($ciCoCount1 / $totalWorkingDays) * 100;
                          
                            echo "<td style='background-color:rgb(200, 10, 25);color:white;text-align:center;'> $absentCount</td>";
                            echo "<td style='background-color:silver;color:black;text-align:center;'>$totalleavesCount</td>";
                            echo "<td style='background-color:rgb(40, 200, 85);color:black;text-align:center;'>$ciCoCount</td>";
                            echo "<td style='background-color:rgb(1, 100, 255);color:white;text-align:center;'>$ciCoCount1/$totalWorkingDays</td>";
                            echo "<td style='background-color:rgb(1, 100, 255);color:white;text-align:center;'>" . round($attendancePercentage, 2) . "%</td>";
                            $caRecord = mysqli_query($db, "
                            SELECT COUNT(empname) AS count
                            FROM CA
                            WHERE empname = '" . $EmployeesNamesArray[$counter] . "'
                            AND submissionTime >= '$firstDayOfMonth'
                            AND submissionTime <= '$lastDayOfMonth 23:59:59'
                        ") or die(mysqli_error($db));
                        
                        
                
                        $caCount = mysqli_fetch_assoc($caRecord)['count'];
                            $confirmedText = ($caCount > 0) ? 'Yes' : '';
                         
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
        <div style="display: inline-block; margin-right: 10px;">Ab: Absent</div>
        <div style="display: inline-block; margin-right: 10px;">CI: CheckedIn</div>
        <div style="display: inline-block; margin-right: 10px;">CO: CheckedOut</div>
        <div style="display: inline-block; margin-right: 10px;">HDL: Half Day Leave</div>
        <div style="display: inline-block; margin-right: 10px;">L: Leave</div>
        <div style="display: inline-block; margin-right: 10px;">!: Check <a href="attendancelog.php" target="_blank">Attendance Log</a></div>
        <div style="display: inline-block; margin-right: 10px;">NWD: Net Working Days</div>
        <div style="display: inline-block;">AP: Attendance Percentage</div>
   <h4 style="text-align: center;">@ANIKA STERILIS | WWW.ANIKASTERILIS.COM</h4>

</div>
</body>
</html>