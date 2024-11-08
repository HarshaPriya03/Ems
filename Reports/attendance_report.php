<?php
session_start();
@include '../inc/config.php';

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  header('location:loginpage.php');
  exit();
}

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
if ($user_name === '') {
  header('location:loginpage.php');
  exit();
}

$query = "SELECT user_type,user_type1 FROM user_form WHERE email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if ($row && isset($row['user_type']) && isset($row['user_type1'])) {
    $user_type = $row['user_type'];
    $user_type1 = $row['user_type1'];

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
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="./css/global.css" />
  <link rel="stylesheet" href="./css/attendence.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  <style>
    .rectangle-parent23 {
      position: absolute;
      width: 100%;
      top: calc(50% - 360px);
      /*right: 1.21%;*/
      left: 15px;
      height: 850px;
      font-size: var(--font-size-xl);
    }

    ::-webkit-scrollbar {
      width: 8px;
    }

    ::-webkit-scrollbar-track {
      background-color: #ebebeb;
      -webkit-border-radius: 10px;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
      -webkit-border-radius: 10px;
      border-radius: 10px;
      background: #cacaca;
    }

    table {
      z-index: 100;
      border-collapse: collapse;
      background-color: white;
    }

    th,
    td {
      padding: 1em;
      border-bottom: 2px solid rgb(193, 193, 193);
    }
  </style>
</head>

<body>
  <div class="attendence4">
    <div class="bg14"></div>

    <div class="rectangle-parent23">
      <!-- <div style="display: flex; position: absolute; top: -20px; right: 20px;">
        <a href="print_attendance_report.php" target="_blank" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
          <div style="display: flex; gap: 10px;"><img src="./public/pdf.png" width="25px" alt="">
            <span style="margin-top: 4px;">Export as PDF</span>
          </div>
        </a>
      </div> -->
      <div style="margin-top: 30px;overflow-x:auto;height:800px;">
        <table class="data" id="attendanceTable">
          <tr class='header-row'>
            <th class='static-cell'>S.No.</th>
            <th class='static-cell'>Date <br>
              <div style="display: flex;">
              <input id="fromDate" onchange="filterTableByDateRange()" style="height: 35px; border-radius: 5px; border: 1px solid rgb(198, 198, 198); width: 100px;" type="date"> 
<input id="toDate" onchange="filterTableByDateRange()" style="height: 35px; border-radius: 5px; border: 1px solid rgb(198, 198, 198); width: 100px;" type="date">


            </div>
            </th>
            <th class='static-cell' style="border-left: 2px solid rgb(182, 182, 182);">Employee Name <br>
              <input id="empnameFilter" name="empname" style="height: 35px; border-radius: 5px; border: 1px solid rgb(198, 198, 198);" type="text" placeholder="Search for employee" oninput="filterTable()">
            </th>
            <th class='static-cell' colspan="2" style="white-space:nowrap; border-left: 2px solid rgb(182, 182, 182);">In Time <span style="margin-left:110px;"> -</span><span style="margin-left:50px;"> Input Type</span></th>
            <th class='static-cell' colspan="2" style="white-space:nowrap;border-left: 2px solid rgb(182, 182, 182);">Out Time <span style="margin-left:70px;"> -</span><span style="margin-left:30px;"> Input Type</span></th>
            <th style="border-left: 2px solid rgb(182, 182, 182); cursor: pointer;">Total Hrs</th>
            <th style="border-left: 2px solid rgb(182, 182, 182);">Actual Working Hrs</th>
          </tr>
          <?php
          $sql = "SELECT emp.emp_no, emp.empname, emp.pic, emp.empstatus, emp.dept, CamsBiometricAttendance.*
FROM emp
INNER JOIN CamsBiometricAttendance ON emp.UserID = CamsBiometricAttendance.UserID
WHERE emp.empstatus = 0
AND emp.desg != 'SECURITY GAURDS'
ORDER BY CamsBiometricAttendance.AttendanceTime DESC";

          $que = mysqli_query($con, $sql);
          $cnt = 1;
          $userCheckOut = array();
          $userEntriesCount = array();
          $prevDay = null;
          $showDiscrepancyDiv = false;

          while ($result = mysqli_fetch_assoc($que)) {
            $userId = $result['UserID'];
            $dayOfMonth = date('j', strtotime($result['AttendanceTime']));
            $formattedDate = $result['AttendanceTime'];
            $rowColorClass = ($dayOfMonth % 2 == 0) ? 'even' : 'odd';

            $showWarningSVG = false;

            if ($dayOfMonth == date('j')) {
              if ($result['AttendanceType'] == 'CheckIn' && !isset($userEntriesCount[$userId][$dayOfMonth])) {
                $userEntriesCount[$userId][$dayOfMonth] = 1;
              } elseif ($result['AttendanceType'] == 'CheckIn') {
                $userEntriesCount[$userId][$dayOfMonth]++;
                $showWarningSVG = true;
              }
            }

            if ($result['AttendanceType'] == 'CheckOut') {
              $userCheckOut[$userId] = array(
                'AttendanceTime' => $result['AttendanceTime'],
                'InputType' => $result['InputType'],
                'Department' => $result['dept']
              );
            } elseif ($result['AttendanceType'] == 'CheckIn') {
              $currentDay = date('j', strtotime($result['AttendanceTime']));


          ?>
              <tr>
                <td><?php echo $cnt; ?></td>
                <td><?php echo $formattedDate; ?></td>
                <td style="border-left: 2px solid rgb(182, 182, 182);"><?php echo $result['empname']; ?></td>
                <td style="border-left: 2px solid rgb(182, 182, 182);"> <?php echo $result['AttendanceTime']; ?></td>
                <td> <?php echo $result['InputType']; ?></td>
                <td style="border-left: 2px solid rgb(182, 182, 182);">
                  <?php
                  if (isset($userCheckOut[$userId])) {
                    echo $userCheckOut[$userId]['AttendanceTime'];
                  } else {
                    echo '<span style="color: red !important;">Yet to Check Out!</span>';
                  }
                  ?>
                </td>
                <td>
                  <?php
                  if (isset($userCheckOut[$userId])) {
                    echo $userCheckOut[$userId]['InputType'];
                  } else {
                    echo '<span style="color: red !important;">Yet to Check Out!</span>';
                  }
                  ?>
                </td>
                <td style="border-left: 2px solid rgb(182, 182, 182);">
                  <?php
                  $empname = $result['empname'];

                  $sql = "SELECT dept.*
            FROM emp
            INNER JOIN dept ON emp.desg = dept.desg
            WHERE emp.empname = '$empname'";

                  $result_dept = $con->query($sql);

                  if ($result_dept->num_rows > 0) {
                    while ($row = $result_dept->fetch_assoc()) {
                      $fromShiftTime = new DateTime($row['fromshifttime1']);
                      $toShiftTime = new DateTime($row['toshifttime1']);

                      $interval = $fromShiftTime->diff($toShiftTime);

                      $duration = $interval->format('%s');
                    }
                  } else {
                    echo "No designation found for this employee";
                  }
                  ?>
                  <?php
                  if (isset($userCheckOut[$userId])) {
                    $inTime = strtotime($result['AttendanceTime']);
                    $outTime = strtotime($userCheckOut[$userId]['AttendanceTime']);

                    // Calculate the difference in seconds
                    $secondsDiff = $outTime - $inTime;

                    // Calculate hours and minutes
                    $hours = floor($secondsDiff / 3600);
                    $minutes = floor(($secondsDiff % 3600) / 60);
                    $durationMinutes = $interval->h * 60 + $interval->i;
                    $totalMinutes = $hours * 60 + $minutes;
                    $difference = $durationMinutes - $totalMinutes;

                    if (($hours * 60 + $minutes) < $durationMinutes) {
                      echo '<span style="color: red;">' . $hours . ' hrs ' . $minutes . ' mins</span>';
                      $differenceHours = floor($difference / 60);
                      $differenceMinutes = $difference % 60;
                      echo '<br><span style="color: red;">[-' . $differenceHours . ' hrs ' . $differenceMinutes . ' mins]</span>';
                    } elseif (($hours * 60 + $minutes) > 720) {
                      echo '<span title="12 Hrs exceeded">' . $hours . ' hrs ' . $minutes . ' mins</span>';
                    } else {
                      echo '<span style="color: green;">' . $hours . ' hrs ' . $minutes . ' mins</span>';
                    }
                  } else {
                    $timeInput = strtotime($result['AttendanceTime']);
                    $origin = new DateTime(date('Y-m-d H:i:s', $timeInput));
                    $target = new DateTime(); // Current time
                    $target->modify('+5 hours 30 minutes');
                    $interval = $origin->diff($target);
                    if ($interval->h > 10) {
                      echo '<span title="12 Hrs exceeded"><img src="public/warn.png" width=40px></span>';
                    }
                    echo $interval->format('%h hrs %i mins') . PHP_EOL;
                  }
                  ?>
                </td>
                <td style="border-left: 2px solid rgb(182, 182, 182);">
                  <?php
                  $empname = $result['empname'];

                  $sql = "SELECT dept.*
            FROM emp
            INNER JOIN dept ON emp.desg = dept.desg
            WHERE emp.empname = '$empname'";

                  $result = $con->query($sql);

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      // Convert fromshifttime1 and toshifttime1 to DateTime objects
                      $fromShiftTime = new DateTime($row['fromshifttime1']);
                      $toShiftTime = new DateTime($row['toshifttime1']);

                      // Calculate the difference between the times
                      $interval = $fromShiftTime->diff($toShiftTime);

                      // Format the difference
                      $duration = $interval->format('%h hrs %i mins');

                      echo $duration;
                    }
                  } else {
                    echo "No designation found for this employee";
                  }
                  ?>
                </td>
              </tr>
          <?php
              $prevDay = $currentDay;
            }
            $cnt++;
          }
          ?>
        </table>
      </div>
    </div>
    <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

    <img width="90px" style="position: absolute; left:20px;" src="./public/logo-1@2x.png" />
    <a class="anikahrm14" href="./index.html" style="top:20px; left:120px;" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./reports.html" style="text-align: center; width: 60%;" id="attendenceManagement">Attendance Management</a>
  </div>
  <script>
  function filterTableByDateRange() {
    var fromDateInput = document.getElementById("fromDate").value;
    var toDateInput = document.getElementById("toDate").value;

    // Parse input dates
    var fromDate = fromDateInput ? new Date(fromDateInput).setHours(0, 0, 0, 0) : null;
    var toDate = toDateInput ? new Date(toDateInput).setHours(23, 59, 59, 999) : null;

    var rows = document.getElementById("attendanceTable").getElementsByTagName("tr");
    for (var i = 0; i < rows.length; i++) {
      var dateCell = rows[i].getElementsByTagName("td")[1]; // Assuming Date column is the second column
      if (dateCell) {
        var cellDate = new Date(dateCell.textContent).getTime(); // Convert cell date to timestamp

        if ((fromDate && toDate) && (cellDate >= fromDate && cellDate <= toDate)) {
          rows[i].style.display = "";
        } else if ((fromDate && !toDate) && cellDate >= fromDate) {
          rows[i].style.display = "";
        } else if ((!fromDate && toDate) && cellDate <= toDate) {
          rows[i].style.display = "";
        } else {
          rows[i].style.display = "none";
        }
      }
    }
  }
</script>
  <script>
    function filterTable() {
      var empnameFilter = document.getElementById("empnameFilter").value.toUpperCase();
      var table = document.getElementById("attendanceTable");
      var rows = table.getElementsByTagName("tr");

      for (var i = 1; i < rows.length; i++) {
        var row = rows[i];
        var empnameCell = row.getElementsByTagName("td")[2];
        var empnameValue = empnameCell.textContent || empnameCell.innerText;

        if (empnameValue.toUpperCase().indexOf(empnameFilter) > -1) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      }
      var exportPDFLink = document.getElementById("exportPDFLink");
      exportPDFLink.href = "print_mgr_report.php?empnameFilter=" + encodeURIComponent(empnameFilter);
    }
  </script>
</body>

</html>