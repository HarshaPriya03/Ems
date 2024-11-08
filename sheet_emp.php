<?php
require_once("inc/config.php");
require_once("dbConfig.php");
session_start();
if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                icon: 'error',
                title: 'Account Terminated',
                text: 'Contact HR, also check your mail for more info.',
              }).then(function() {
                window.location.href = 'loginpage.php';
              });
            });
          </script>";
    exit();
}
$sqlStatusCheck = "SELECT empstatus FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultStatusCheck = mysqli_query($con, $sqlStatusCheck);
$statusRow = mysqli_fetch_assoc($resultStatusCheck);

if ($statusRow['empstatus'] == 0) {

    $firstDayOfMonth = date("Y-m-01");
    $totalDaysInMonth = date("t", strtotime($firstDayOfMonth));

    // Fetching Employees 
    $fetchingEmployees = mysqli_query($db, "SELECT * FROM emp WHERE empemail = '{$_SESSION['user_name']}'") or die(mysqli_error($db));
    $totalNumberOfEmployees = mysqli_num_rows($fetchingEmployees);

    $EmployeesNamesArray = array();
    $EmployeescitiesArray = array();
    $EmployeesIDsArray = array();
    $counter = 0;
    // while ($Employees = mysqli_fetch_assoc($fetchingEmployees)) {
    //     $EmployeesNamesArray[] = $Employees['empname'];
    //     $EmployeesIDsArray[] = $Employees['UserID'];
    // }

    while ($Employees = mysqli_fetch_assoc($fetchingEmployees)) {
        $EmployeesNamesArray[] = $Employees['empname'];
        if ($Employees['work_location'] === 'Visakhapatnam') {
            $EmployeescitiesArray[] = 'Visakhapatnam';
        } elseif ($Employees['work_location'] === 'Gurugram') {
            $EmployeescitiesArray[] = 'Gurugram';
        } else {
            $EmployeescitiesArray[] = $Employees['work_location'];
        }
        $EmployeesIDsArray[] = $Employees['UserID'];
    }

    $city = $EmployeescitiesArray[$counter];
$tableNameh = '';

if ($city === 'Gurugram') {
    $tableNameh = 'holiday_ggm';
} elseif ($city === 'Visakhapatnam') {
    $tableNameh = 'holiday';
} else {
    die('Unknown city: ' . $city);
}


?>

    <head>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/global6.css" />
        <link rel="stylesheet" href="./css/email-form.css" />
        <link rel="stylesheet" href="./css/email-form2.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" />
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
    <div class="emailform">
        <div class="bg1"></div>
        <img class="emailform-child" alt="" src="./public/rectangle-1@2x.png" />

        <img class="logo-1-icon1" alt="" src="./public/logo-1@2x.png" />

        <a class="anikahrm1">
            <span>Anika</span>
            <span class="hrm1">HRM</span>
        </a>

        <!-- Loading animation -->
    <div id="loadingAnimation">
        <div class="loader"></div>
    </div>
        <a class="employee-management1" id="employeeManagement">Attendance Management</a>
        <img class="uitcalender-icon1" alt="" src="./public/uitcalemnder.svg" />
        <div style="position: absolute; font-size: 15px;margin-top:130px;">
            <div class="container justify-content-center">
                <div class="row">
                     <div class="col-md-8">
                        <div class="input-group mb-1">
                            <?php
                            if ($city === 'Visakhapatnam') {
                                ?>
                            <select style="position: absolute;font-size:20px; border: 1px solid #ff5400; border-radius:5px; left:100px; " id="monthYearSelect" onchange="filterData()">
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
                            <?php
                            }
                            else {
                                echo '';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <form method="post" action="">
                    <table id="attendanceTable" border="1" style="border-color: rgb(170, 170, 170);scale:0.9;" cellspacing="0" class="table table-bordered table-hover">
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
                                echo "<td rowspan='2' class='static-cell'>Employee Name</td>";
                                for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                                    echo "<td class='static-cell'>$j</td>";
                                }
                                echo "<td colspan='5' style='text-align:center;' class='static-cell'>Total</td>";
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
                                // echo "<td class='static-cell text-center'>TL</td>";
                                // echo "<td class='static-cell'>CO</td>";
                                // echo "<td class='static-cell text-center'>LB</td>";
                                echo "<td class='static-cell'>AWD</td>";
                                echo "<td class='static-cell'>P</td>";
                                echo "<td class='static-cell'>NWD</td>";
                                echo "<td class='static-cell'>AP(%)</td>";
                                echo "</tr>";
                            } else {
                                echo "<tr>";
                                echo "<td>" . $EmployeesNamesArray[$counter] . "</td>";

                                $color = "";

                                
                                for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                                    $dateOfAttendance = date("Y-m-$j");

                                    // Check if the date is a holiday
                                    $fetchingHoliday = mysqli_query($db, "
                                    SELECT *
                                    FROM $tableNameh
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
                                    FROM $tableNameh
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
                                                $user_name = $_SESSION['user_name'];
                                                $sql = "SELECT serviceTagId FROM emp WHERE empemail = '$user_name'";
                                                $result = $con->query($sql);
                                                
                                                if ($result->num_rows > 0) {
                                                    $row = $result->fetch_assoc();
                                                    $serviceTagId = $row['serviceTagId'];
                                                
                                                    // Determine the table name based on serviceTagId
                                                    if ($serviceTagId == 'ZXQI19009096') {
                                                        $tableName = 'CamsBiometricAttendance';
                                                    } elseif ($serviceTagId == 'ZYSA07001899') {
                                                        $tableName = 'CamsBiometricAttendance_GGM';
                                                    } else {
                                                        die("No attendance table associated with this serviceTagId.");
                                                    }

                                                }
                                                // Fetch attendance data for weekdays (excluding Sundays)
                                                $fetchingEmployeesAttendance = mysqli_query($db, "
                                                SELECT CBA.AttendanceType, E.empname
                                                FROM $tableName AS CBA
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
                                            $user_name = $_SESSION['user_name'];
                                            $sql = "SELECT serviceTagId FROM emp WHERE empemail = '$user_name'";
                                            $result = $con->query($sql);
                                            
                                            if ($result->num_rows > 0) {
                                                $row = $result->fetch_assoc();
                                                $serviceTagId = $row['serviceTagId'];
                                            
                                                // Determine the table name based on serviceTagId
                                                if ($serviceTagId == 'ZXQI19009096') {
                                                    $tableName = 'CamsBiometricAttendance';
                                                } elseif ($serviceTagId == 'ZYSA07001899') {
                                                    $tableName = 'CamsBiometricAttendance_GGM';
                                                } else {
                                                    die("No attendance table associated with this serviceTagId.");
                                                }

                                            }
                                            // Fetch attendance data for weekdays (excluding Sundays)
                                            $fetchingEmployeesAttendance = mysqli_query($db, "
                                            SELECT CBA.AttendanceType, E.empname
                                            FROM $tableName AS CBA
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
                      FROM $tableName
                            WHERE UserID = '" . $EmployeesIDsArray[$counter] . "'
                            AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                            AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                            AND DAYOFWEEK(AttendanceTime) != 1  -- Exclude entries on Sunday
                            AND DATE(AttendanceTime) NOT IN (
                                SELECT date
                                FROM $tableNameh
                            )
                            AND (
                                (AttendanceType = 'CheckIn' AND DATE(AttendanceTime) IN (
                                    SELECT DATE(AttendanceTime)
                                  FROM $tableName
                                    WHERE UserID = '" . $EmployeesIDsArray[$counter] . "'
                                    AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                                    AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                                    AND AttendanceType = 'CheckOut'
                                    AND DAYOFWEEK(AttendanceTime) != 1  -- Exclude entries on Sunday
                                ))
                                OR (AttendanceType = 'CheckOut' AND DATE(AttendanceTime) IN (
                                    SELECT DATE(AttendanceTime)
                                    FROM $tableName
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
                      FROM $tableName
                        WHERE UserID = '" . $EmployeesIDsArray[$counter] . "'
                        AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                        AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                        AND (
                            (AttendanceType = 'CheckIn' AND DATE(AttendanceTime) IN (
                                SELECT DATE(AttendanceTime)
                            FROM $tableName
                                WHERE UserID = '" . $EmployeesIDsArray[$counter] . "'
                                AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                                AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                                AND AttendanceType = 'CheckOut'
                                AND DAYOFWEEK(AttendanceTime) = 1  -- Select only entries on Sunday
                            ))
                            OR (AttendanceType = 'CheckOut' AND DATE(AttendanceTime) IN (
                                SELECT DATE(AttendanceTime)
                              FROM $tableName
                                WHERE UserID = '" . $EmployeesIDsArray[$counter] . "'
                                AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                                AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                                AND AttendanceType = 'CheckIn'
                                AND DAYOFWEEK(AttendanceTime) = 1  -- Select only entries on Sunday
                            ))
                            OR DATE(AttendanceTime) IN (
                                SELECT date
                                FROM $tableNameh
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
                    AND status = 1
                    AND status1 = 1
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
                    FROM $tableNameh
                    WHERE date >= '$firstDayOfMonth'
                    AND date <= '$lastDayOfMonth'
                ") or die(mysqli_error($db));

                                $currentDays1 = date('Y-m-d');

                                // SQL query to fetch count of distinct dates until the current date
                                $fetchingHolidays1 = mysqli_query($db, "
SELECT COUNT(DISTINCT date) AS count
          FROM $tableNameh
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
                                $ciCoCount1 = $ciCoCount + $leaveCount2;
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
                                // echo "<td style='background-color:silver;color:black;text-align:center;font-weight: $fontWeightStyle;'>$totalleavesCount/$totalLeavesValue</td>";
                                // echo "<td style='background-color:silver;color:black;text-align:center;'>$ccoValue/$icoValue</td>";
                                // echo "<td style='background-color:silver;color:black;text-align:center;font-weight: $fontWeightStyle2;'>$currentLeavesValue/$totalLeavesValue1</td>";
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
                        <tr>
                            <td colspan="<?php echo $totalDaysInMonth + 9; ?>">

                                <a class="btn udbtn" style="background-color: #FB8A0B;color:white;" href="print-details1.php" target="_blank">Download</a>

                                <?php
                                $fetchingEmployees = mysqli_query($db, "SELECT * FROM emp WHERE empemail = '{$_SESSION['user_name']}'") or die(mysqli_error($db));
                                $totalNumberOfEmployees = mysqli_num_rows($fetchingEmployees);

                                $EmployeesNamesArray = array();
                                $EmployeesIDsArray = array();
                                $counter = 0;

                                while ($Employees = mysqli_fetch_assoc($fetchingEmployees)) {
                                    $EmployeesNamesArray[] = $Employees['empname'];
                                    $EmployeesIDsArray[] = $Employees['UserID'];

                                    $status_query = "SELECT status FROM CA WHERE empname = '" . $Employees['empname'] . "'
                                AND MONTH(submissionTime) = MONTH(CURRENT_DATE())
                                AND YEAR(submissionTime) = YEAR(CURRENT_DATE())";

                                    $status_result = mysqli_query($con, $status_query);

                                    if ($status_result) {
                                        if (mysqli_num_rows($status_result) > 0) {
                                            $row = mysqli_fetch_assoc($status_result);
                                            $status = $row['status'];
                                            $currentDate = date('Y-m-d');
                                            $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));
                                            if ($status == 1 && $currentDate === $lastDayOfMonth) {
                                                // If status is 1 and it's the last day of the month
                                                echo '<div style="display: flex; gap: 10px;margin-left:920px;">
                                                  <p class="h5" style="color:#28C855;margin-top:-30px !important;font-weight:600;">Current Month Attendance Confirmed Successfully 
                                                  <svg style="margin-top:-5px !important;" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#28C855" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                  <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                                                  </svg></p>';
                                            }
                                        } elseif ($currentDate === $lastDayOfMonth) {
                                            // If there's no data for the current month and it's the last day of the month
                                            echo '<a class="btn udbtn" style="background-color: #FB8A0B;color:white;" href="javascript:void(0);" onclick="confirmAttendance()">Confirm</a>';
                                        } elseif ($currentDate === $lastDayOfMonth) {
                                            // No record found, display the button
                                            echo '<a class="btn udbtn" style="background-color: #FB8A0B;color:white;" href="javascript:void(0);" onclick="confirmAttendance()">Confirm</a>';
                                        }

                                        mysqli_free_result($status_result);
                                    } else {
                                        die("Error: " . mysqli_error($con));
                                    }

                                    $counter++;
                                }
                                mysqli_free_result($fetchingEmployees);
                                ?>

                                <!-- <a class="btn udbtn" style="background-color: #FB8A0B;color:white;" href='javascript:void(0);' onclick='confirmAttendance()'>Confirm</a> -->
                            </td>
                        </tr>
                        </td>
                        </tr>
                    </table>
                </form>
                <div style="display: flex; gap: 10px; margin-left:40px;">
                    <p class="h5" style="color:black;margin-top:8px;">INDICATIONS:</p>
                    <P class="lead btn btn-sm  btn-outline-success">P: Present</P>
                    <p class="lead btn btn-sm btn-outline-danger">Ab: Absent</p>
                    <p class="lead btn btn-sm btn-outline-secondary">SL: Sick Leave</p>
                    <p class="lead btn btn-sm btn-outline-secondary">CL: Casual Leave</p>
                    <p class="lead btn btn-sm btn-outline-secondary">HDL: Half Day Leave</p>
                    <p class="lead btn btn-sm " style="outline: 1px solid darkgrey;">CO: Compensatory Off</p>
                    <p class="lead btn btn-sm " style="outline: 1px solid darkgrey;">AWD: Additional Worked days</p>
                    <p class="lead btn btn-sm " style="outline: 1px solid darkgrey;">TL: Total leave</p>
                    <p class="lead btn btn-sm " style="outline: 1px solid darkgrey;">LB: Leave balance</p>
                    <p class="lead btn btn-sm btn-outline-primary">NWD: Net Working Days</p>
                    <p class="lead btn btn-sm btn-outline-primary">AP: Attendance Percentage</p>
                    <a style="text-decoration: none; color: inherit;" href="attendancelog_mgr.php" target="_blank">
                        <P class=" btn" style="outline:1px solid #FB8A0B;color:#F46114;white-space:nowrap; font-size:14px;"><img style="margin-bottom:4px;" src="https://upload.wikimedia.org/wikipedia/commons/archive/3/3b/20180610093750%21OOjs_UI_icon_alert-warning.svg">: Check Attendance Log</P>
                    </a>
                </div>
            </div>
        </div>
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
                xhttp.open("GET", "fetch_emp_attendance.php?monthYear=" + selectedValue, true);
                xhttp.send();
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Your other JavaScript code here
    });
</script>

          <script>
    function confirmAttendance() {
        // Get the values to be sent to the server
        var empEmail = '<?php echo $_SESSION['user_name']; ?>';
        var empName = '<?php echo $EmployeesNamesArray[0]; ?>'; // Assuming there is only one employee for simplicity
        var submissionTime = new Date().toISOString().slice(0, 19).replace("T", " "); // Format date as string
        var confirm = "self";

        // Show a confirmation SweetAlert
        Swal.fire({
            title: 'Confirm Attendance',
            text: 'Confirming the attendance indicates that you dont have any discrepancies in your attendance,and this information will be used for further salary processing and other related process(s).This action is irreversible, so please ensure that your attendance details are accurate before confirming.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, confirm!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send an AJAX request to the server to update the 'CA' table
                $.ajax({
                    type: "POST",
                    url: "update_ca_table.php",
                    data: {
                        empEmail: empEmail,
                        empName: empName,
                        submissionTime: submissionTime,
                        confirm: confirm,
                    },
                    success: function(response) {
                        // Log the response to the console for debugging
                        console.log(response);

                        // Handle the response from the server using SweetAlert2
                        if (response === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Attendance confirmed successfully!',
                            }).then(function() {
                                // Redirect to sheet_emp.php after the user clicks "OK"
                                window.location = 'sheet_emp.php';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed to confirm attendance.',
                                text: response, // Display the error message from the server
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Log any AJAX errors to the console for debugging
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    }
</script>

    <?php
} else {
    echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Account Terminated',
              text: 'Contact HR, also check your mail for more info.',
            }).then(function() {
              window.location.href = 'loginpage.php';
            });
          });
        </script>";
    exit();
}
    ?>