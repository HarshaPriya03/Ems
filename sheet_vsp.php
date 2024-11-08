<?php
require_once("dbConfig.php");
$currentDate = date("Y-m-d");
$firstDayOfMonth = date("Y-m-01");
$totalDaysInMonth = date("t", strtotime($firstDayOfMonth));
// $totalDaysInMonth = date('t', strtotime($firstDayOfMonth)) . ' 23:59:59';
// Fetching Employees 
$fetchingEmployees = mysqli_query($db, "SELECT * FROM emp
WHERE empstatus = 0 AND desg != 'SECURITY GAURDS'
AND ServiceTagId = 'ZXQI19009096'
ORDER BY emp_no ASC;") or die(mysqli_error($db));

$totalNumberOfEmployees = mysqli_num_rows($fetchingEmployees);

$EmployeesNamesArray = array();
$EmployeescitiesArray = array();
$EmployeesIDsArray = array();
$counter = 0;
$cnt = 1;
while ($Employees = mysqli_fetch_assoc($fetchingEmployees)) {
    $EmployeesNamesArray[] = $Employees['empname'];
    if ($Employees['work_location'] === 'Visakhapatnam') {
        $EmployeescitiesArray[] = 'VSP';
    } elseif ($Employees['work_location'] === 'Gurugram') {
        $EmployeescitiesArray[] = 'GGM';
    } else {
        $EmployeescitiesArray[] = $Employees['work_location'];
    }
    $EmployeesIDsArray[] = $Employees['UserID'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/global6.css" />
    <link rel="stylesheet" href="./css/email-form.css" />
    <link rel="stylesheet" href="./css/email-form2.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <style>
        .lead {
            white-space: nowrap;
            pointer-events: none;
        }

        .udbtn:hover {
            color: black !important;
            background-color: white !important;
            outline: 1px solid #F46114;
        }

        .select {
            position: relative;
            min-width: 200px;
        }

        .select svg {
            position: absolute;
            right: 12px;
            top: calc(50% - 3px);
            width: 10px;
            height: 6px;
            stroke-width: 2px;
            stroke: #9098a9;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
            pointer-events: none;
        }

        .select select {
            padding: 7px 40px 7px 12px;
            width: 100%;
            border: 1px solid #e8eaed;
            border-radius: 5px;
            background: #fff;
            box-shadow: 0 1px 3px -2px #9098a9;
            cursor: pointer;
            font-family: inherit;
            font-size: 16px;
            transition: all 150ms ease;
        }

        .select select:required:invalid {
            color: #5a667f;
        }

        .select select option {
            color: #223254;
        }

        .select select option[value=""][disabled] {
            display: none;
        }

        .select select:focus {
            outline: none;
            border-color: #07f;
            box-shadow: 0 0 0 2px rgba(0, 119, 255, 0.2);
        }

        .select select:hover+svg {
            stroke: #07f;
        }

        .sprites {
            position: absolute;
            width: 0;
            height: 0;
            pointer-events: none;
            user-select: none;
        }

        .container {
            margin-top: 10px;
            padding-bottom: 20px;
        }

        .input-text:focus {
            box-shadow: 0px 0px 0px;
            border-color: #fd7e14;
            outline: 0px;
        }

        .form-control {
            border: 1px solid #fd7e14;
        }
        #loadingAnimation {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1000;
        background-color: rgba(0, 0, 0, 0.5); 
        padding: 20px;
        border-radius: 10px;
    }

    .loader {
        border: 8px solid #f3f3f3;
        border-radius: 50%;
        border-top: 8px solid #F36115;
        width: 50px;
        height: 50px;
        background-color: rgba(0, 0, 0, 0.5); 
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    </style>
</head>

<body style="overflow:hidden;">
    <div class="emailform">
        <div class="bg1"></div>
        <img class="emailform-child" alt="" src="./public/rectangle-1@2x.png" />

        <img class="logo-1-icon1" alt="" src="./public/logo-1@2x.png" />

        <a class="anikahrm1">
            <span>Anika</span>
            <span class="hrm1">HRM</span>
        </a>
        <a class="employee-management1" id="employeeManagement">Attendance Management</a>
        <img class="uitcalender-icon1" alt="" src="./public/uitcalemnder.svg" />
   
    <!-- Loading animation -->
    <div id="loadingAnimation">
        <div class="loader"></div>
    </div>

        <div style="position: absolute; font-size: 15px;margin-top:100px;overflow-y:auto; height:850px;">
            <div class="container justify-content-center">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group mb-1">
                          
                            <select style="position: absolute; top: 10px; left: -250px; font-size:20px; border: 1px solid #ff5400; border-radius:5px; " id="monthYearSelect" onchange="filterData()">
    <option value="">Select Month-Year</option>
    <?php
    $currentYear = date("Y");
    $currentMonth = date("n");

    for ($i = 1; $i <= $currentMonth; $i++) {
        $monthName = date("F", mktime(0, 0, 0, $i, 1));
        $optionValue = date("Y-m", mktime(0, 0, 0, $i, 1, $currentYear));
        echo "<option value=\"$optionValue\">$monthName $currentYear</option>";
    }
    ?>
</select>

                            <div>
                                <span>
                                    <?php
                                    $sql1 = "SELECT COUNT(*) as count
            FROM emp e 
            JOIN CamsBiometricAttendance c ON e.UserID = c.UserID
            WHERE desg != 'SECURITY GAURDS'
              AND empstatus = 0
              AND DATE(AttendanceTime) = '$currentDate' 
              AND AttendanceType = 'CheckIn'
              AND NOT EXISTS (
                  SELECT 1
                  FROM CamsBiometricAttendance co
                  WHERE co.UserID = c.UserID
                    AND DATE(co.AttendanceTime) = DATE(c.AttendanceTime)
                    AND co.AttendanceType = 'CheckOut'
                    AND co.AttendanceTime > c.AttendanceTime
              )";

                                    $result1 = $db->query($sql1);
                                    $row1 = $result1->fetch_assoc();
                                    $count1 = $row1['count'];
                                    $count = count($EmployeesNamesArray);

                                    $sql2 = "SELECT COUNT(*) as count
                                    FROM emp e
                                    JOIN leaves l ON e.empname = l.empname 
                                    WHERE empstatus = 0
                                      AND ((l.status = 1 AND l.status1 = 1) OR (l.status = 1 AND l.status1 = 0))
                                      AND '$currentDate' BETWEEN DATE(l.from) AND DATE(l.to)";


                                    $result2 = $db->query($sql2);
                                    $row2 = $result2->fetch_assoc();
                                    $count2 = $row2['count'];
                                    $sql3 = "SELECT COUNT(*) as count FROM absent a
        JOIN emp e ON a.empname = e.empname
        WHERE TIMESTAMP(DATE(AttendanceTime)) = '$currentDate'";


                                    $result3 = $db->query($sql3);
                                    $row3 = $result3->fetch_assoc();
                                    $count3 = $row3['count'];
                                    ?>
                                </span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form method="post" action="">
                <table border="1" style="border-color: rgb(170, 170, 170);scale:0.9;margin-top:-50px;" cellspacing="0" id="attendanceTable" class="table table-bordered table-hover">
                   


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
                            echo "<td class='static-cell text-center'>P</td>";
                            echo "<td class='static-cell'>NWD</td>";
                             echo "<td class='static-cell'>WO</td>";
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
                            $ciCoCount1 = $ciCoCount + $leaveCount2 ;
                            $totalWorkingDays = $totalDaysInMonth - $sundaysCount - $holidaysCount;
                            $CurrentDays = $totalDaysTillCurrentDay - $sundaysCount1 - $holidaysCount1;
                            $attendancePercentage = ($ciCoCount1 / $totalWorkingDays) * 100;
                            $weekoff = $sundaysCount + $holidaysCount;
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
                             echo "<td style='background-color:#dcdcdc;color:black;text-align:center;'>$weekoff</td>";
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
                    <tr>
                        <td colspan="<?php echo $totalDaysInMonth + 10; ?>">
                            <a class="btn udbtn" style="background-color: #FB8A0B;color:white;" href="print-details_vsp.php" target="_blank">Download</a>
                            <?php
                            $currentDate = date('Y-m-d');
                            $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));

                            if ($currentDate === $lastDayOfMonth) {
                                // echo "<a class='btn udbtn' style='background-color: #FB8A0B;color:white;' href='javascript:void(0);' onclick='downloadAndUpload()'>Upload</a>";
                            } else {
                                echo "";
                            }
                            ?>
                        </td>
                    </tr>

                </table>
            </form>
          
        </div>
    </div>

</body>
<script>
    function filterData() {
        var selectedValue = document.getElementById("monthYearSelect").value;
        if (selectedValue === "<?php echo date('Y-m'); ?>") {
            location.reload(); // Reload the page if current month-year is selected
        } else {
            // Handle other filtering logic here
            
            if (selectedValue !== "") {
                // Show the loading animation
                document.getElementById("loadingAnimation").style.display = "block";

                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Hide the loading animation
                        document.getElementById("loadingAnimation").style.display = "none";
                        document.getElementById("attendanceTable").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "fetch_attendance_vsp.php?monthYear=" + selectedValue, true);
                xhttp.send();
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Your other JavaScript code here
    });
</script>


<script>
    function filterTable() {
        // Get input element for filtering
        var input = document.getElementById('filterInput');
        var filter = input.value.toUpperCase();

        // Get the table rows
        var table = document.getElementById('attendanceTable');
        var rows = table.getElementsByTagName('tr');

        // Loop through all table rows, and hide those that don't match the search query
        for (var i = 0; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName('td');
            var shouldShow = false;

            for (var j = 0; j < cells.length; j++) {
                var cell = cells[j];

                // Check if it's a header cell or a static cell
                var isHeaderCell = cell.classList.contains('static-cell');

                // Skip hiding for header cells and static cells
                if (isHeaderCell) {
                    shouldShow = true;
                    break;
                }

                var txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    shouldShow = true;
                    break;
                }
            }

            if (shouldShow) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
</script>



<script>
    function updateIframeSource() {
        const pdfSelector = document.getElementById('pdfSelector');
        const selectedPdf = pdfSelector.value;

        const pdfContainer = document.getElementById('pdfContainer');
        const pdfTitle = document.getElementById('pdfTitle');
        const downloadLink = document.getElementById('downloadLink');
        const pdfIframe = document.getElementById('pdfIframe');

        if (selectedPdf) {
            pdfContainer.style.display = 'block';
            pdfTitle.textContent = `Attendance Sheet: ${selectedPdf}`;
            const pdfPath = `attendencepdf/${selectedPdf}`;
            pdfIframe.src = `${pdfPath}#toolbar=0`;
            downloadLink.href = pdfPath;
            downloadLink.style.display = 'block';
        } else {
            pdfContainer.style.display = 'none';
            pdfTitle.textContent = '';
            pdfIframe.src = '';
            downloadLink.href = '';
            downloadLink.style.display = 'none';
        }
    }
</script>

<script>
    function downloadAndUpload() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "print-details.php", true);
        xhr.responseType = "blob";

        xhr.onload = function() {
            if (xhr.status === 200) {
                var formData = new FormData();
                var pdfBlob = new Blob([xhr.response], {
                    type: "application/pdf"
                });
                formData.append("pdfFile", pdfBlob, "Attendance.pdf");

                var uploadXhr = new XMLHttpRequest();
                uploadXhr.open("POST", "upload_pdf.php", true);
                uploadXhr.onload = function() {
                    if (uploadXhr.status === 200) {
                        alert("Attendance successfully uploaded to server!");
                    } else {
                        alert("Error uploading PDF. Please try again.");
                    }
                };
                uploadXhr.send(formData);
            } else {
                alert("Error generating PDF. Please try again.");
            }
        };
        xhr.send();
    }
</script>



</html>