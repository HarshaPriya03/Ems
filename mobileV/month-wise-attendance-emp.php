<?php
require_once("../inc/config.php");
require_once("dbConfig.php");
session_start();
if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                icon: 'error',
                title: 'Account Terminated',
              text: 'Login Again, if your still facing issues Contact HR!',
              }).then(function() {
                window.location.href = 'login-mob.php';
              });
            });
          </script>";
  exit();
}
if (isset($_GET['redirect'])) {
  // Assuming you have retrieved the department value from the 'emp' table
  $result = mysqli_query($con, "SELECT desg FROM emp WHERE empemail = '{$_SESSION['user_name']}'");
  $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

  if (!empty($rows)) {
    $department = $rows[0]['desg']; // Access the first row and the 'dept' column
    if ($department === 'SECURITY GAURDS') {
      header("Location: ../print-details3.php");
      exit();
    } else {
      header("Location:  ../print-details1.php");
      exit();
    }
  } else {
    // Handle the case when no rows are returned
    echo "No department found.";
  }
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
  $EmployeesIDsArray = array();
  $counter = 0;
  while ($Employees = mysqli_fetch_assoc($fetchingEmployees)) {
    $EmployeesNamesArray[] = $Employees['empname'];
    $EmployeesIDsArray[] = $Employees['UserID'];
  }
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./empmobcss/globalqw.css" />
    <link rel="stylesheet" href="./empmobcss/attendenceemp-mob.css" />
    <link rel="stylesheet" href="./empmobcss/emp-salary-details-mob.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
      .udbtn:hover {
        background-color: #FB8A0B !important;
        color: white;
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
        0% {
          transform: rotate(0deg);
        }

        100% {
          transform: rotate(360deg);
        }
      }
    </style>
  </head>

  <body>
    <div class="attendenceemp-mob" style="height: 100svh;">
      <div class="logo-1-group">
        <img class="logo-1-icon1" alt="" src="./public/logo-1@2x.png" />

        <a class="attendance-management" style="width: 300px;">Attendance Management</a>
      </div>
      <div class="attendenceemp-mob-child"></div>
      <div class="attendenceemp-mob-item"></div>
      <div class="rectangle-parent">
        <a class="frame-item" href="attendenceemp-mob.php" style="background-color: #E8E8E8;"> </a>
        <a class="frame-inner" href="./attendancelogemp-mob.php"> </a>
        <a class="rectangle-a" style="width: 100px; background-color: #ffe2c6;"> </a>
        <a class="attendance" href="attendenceemp-mob.php" style="color: BLACK;">Attendance</a>
        <a class="punch-inout" href="./attendancelogemp-mob.php" style="width: 100px; margin-left: -5px;">Attendance Log</a>
        <a class="my-attendance" style="width: 100px; margin-left: -1px; color: #ff5400;">Monthly Attendance</a>
      </div>
      <!-- Loading animation -->
      <div id="loadingAnimation">
        <div class="loader"></div>
      </div>
      <div class="rectangle-parent9" style="margin-top: 15px;">
        <div class="frame-child23"></div>
        <a class="employee-management1">Month-Wise Attendance</a>
        <img class="frame-child24" style="margin-top:-40px;" alt="" src="./public/line-12@2x.png">
        <h3 class="uploaded-docs">
          <div class="row" style="color: red; width: 300px; font-size: 13px;">
            <div class="col-md-8">
              <div class="input-group mb-1">
                <!--<label>Select Attendance Sheet : </label>-->
                <select style="position: absolute;font-size:20px; border: 1px solid #ff5400; border-radius:5px; left:50px;top:10px; " id="monthYearSelect" onchange="filterData()">
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
              </div>
            </div>
          </div>
        </h3>
        <h3 class="selected-option uploaded-docs">
        <a style="position:absolute;left:-18px;top:50px;width:300%;"></a>
    </h3>

        <!-- <?php $employeeName = $EmployeesNamesArray[0]; ?>

        <h3 class="documentspdf" style="margin-left:-80px; white-space: nowrap;">
          Attendance_<?php echo (strlen($employeeName) > 15) ? substr($employeeName, 0, 15) . '...' : $employeeName; ?>.pdf
        </h3> -->
        <div style="overflow-x:auto;">
          <table id="attendanceTable" border="1" style="width:20% !important;margin-left:-260px;position:absolute;top:140px;border-color: rgb(170, 170, 170);scale:0.6;" cellspacing="0" class="table table-bordered table-hover">
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
            </td>
            </tr>
            <!-- <table  border="1" style="border-color: rgb(170, 170, 170);scale:0.9;" cellspacing="0" class="table table-bordered table-hover">
                            <tr>
                                <th style='text-align:center;' colspan="8">
                                    Total
                                </th>
                            </tr>
                            <tr>
                            <td class='static-cell'>Ab</td>
                            <td class='static-cell'>TL</td>
                            <td class='static-cell'>CO</td>
                            <td class='static-cell'>LB</td>
                            <td class='static-cell'>AWD</td>
                            <td class='static-cell'>P</td>
                            <td class='static-cell'>NWD</td>
                            <td class='static-cell'>AP(%)</td>
                            </tr>
                            <tr>
                                <td>
                                    <?php echo  $absentCount ?>
                                </td>
                                <td>
                                <?php echo  $totalleavesCount . '/' . $totalLeavesValue ?>
                                </td>
                                <td>
                                <?php echo  $ccoValue . '/' . $icoValue ?>
                                </td>
                                <td>
                                <?php echo  $currentLeavesValue . '/' . $totalLeavesValue1 ?>
                                </td>
                                <td>
                                <?php echo  $ciCoCount2 ?>
                                </td>
                                <td>
                                <?php echo  $ciCoCount . '/' . $CurrentDays ?>
                                </td>
                                <td>
                                <?php echo  $ciCoCount1 . '/' . $totalWorkingDays ?>
                                </td>
                                <td>
                                <?php echo  round($attendancePercentage, 2) . '%' ?>
                                </td>
                            </tr>
                        </table> -->
          </table>
        </div>

        <div class="frame-child26"></div>
      </div>
      <div class="arcticonsgoogle-pay-parent">
        <img class="arcticonsgoogle-pay1" alt="" src="./public/arcticonsgooglepay1@2x.png" id="arcticonsgooglePay" />

        <div class="ellipse-div"></div>
        <a class="akar-iconsdashboard1" id="akarIconsdashboard">
          <img class="vector-icon3" alt="" src="./public/vector1dash.svg" />
        </a>
        <a class="fluentperson-clock-20-regular1" id="fluentpersonClock20Regular">
          <img class="vector-icon4" alt="" src="./public/vector1@2xleaves.png" />
        </a>
        <a class="uitcalender1">
          <img class="vector-icon5" alt="" src="./public/vector3@2xattenblack.png" />
        </a>
      </div>
    </div>
    <script>
      var arcticonsgooglePay = document.getElementById("arcticonsgooglePay");
      if (arcticonsgooglePay) {
        arcticonsgooglePay.addEventListener("click", function(e) {
          window.location.href = "./directoryemp-mob.php";
        });
      }

      var akarIconsdashboard = document.getElementById("akarIconsdashboard");
      if (akarIconsdashboard) {
        akarIconsdashboard.addEventListener("click", function(e) {
          window.location.href = "./emp-dashboard-mob.php";
        });
      }

      var fluentpersonClock20Regular = document.getElementById(
        "fluentpersonClock20Regular"
      );
      if (fluentpersonClock20Regular) {
        fluentpersonClock20Regular.addEventListener("click", function(e) {
          window.location.href = "./apply-leaveemp-mob.php";
        });
      }
    </script>
   <script>
        function filterData() {
            var selectedMonthYear = document.getElementById("monthYearSelect").value;
            if (selectedMonthYear !== "") {
                // Show the loading animation
                document.getElementById("loadingAnimation").style.display = "block";

                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        // Hide the loading animation
                        document.getElementById("loadingAnimation").style.display = "none";
                        document.getElementById("attendanceTable").innerHTML = this.responseText;

                        // Update the selected option value in the <h3> tag
                        var parts = selectedMonthYear.split('-');
                        var monthName = new Date(parts[0], parts[1] - 1).toLocaleString('en-us', { month: 'long' });
                        var formattedDate = 'Showing Attendance for the Month:' + monthName + ' ' + parts[0];
                        document.querySelector('.selected-option a').textContent = formattedDate;
                    }
                };
                xhttp.open("GET", "../fetch_emp_attendance.php?monthYear=" + selectedMonthYear, true);
                xhttp.send();
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            // Your other JavaScript code here
        });
    </script>
  </body>

  </html>
<?php
} else {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Account Terminated',
              text: 'Contact HR, also check your mail for more info.',
            }).then(function() {
              window.location.href = 'login-mob.php';
            });
          });
        </script>";
  exit();
}
?>