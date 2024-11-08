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

$sql = "SELECT DISTINCT E.empname, lb.*
FROM CamsBiometricAttendance AS CBA
INNER JOIN emp AS E ON CBA.UserID = E.UserID
INNER JOIN leavebalance AS lb ON E.empname = lb.empname
WHERE E.empstatus = 0
ORDER BY E.emp_no ASC;

";

$result = mysqli_query($con, $sql);
$employees = array();
$cnt = 1;
while ($row = mysqli_fetch_assoc($result)) {
  $employees[] = $row['empname'];
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    .rectangle-parent23 {
      position: absolute;
      width: 98%;
      top: calc(50% - 360px);
      /*right: 1.21%;*/
      left: 20px;
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
  </style>
</head>

<body>
  <div class="attendence4">
    <div class="bg14"></div>

    <div class="rectangle-parent23">
      <div style="display: flex; position: absolute; top: -20px; right: 60px;">
        <a id="exportPDFLink" href="print_lb_report.php" target="_blank" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
          <div style="display: flex; gap: 10px;"><img src="./public/pdf.png" width="25px" alt="">
            <span style="margin-top: 4px;">Export as PDF</span>
          </div>
        </a>
      </div>
      <div style="margin-top: 30px;overflow-x:auto;height:800px;">
        <table class="data w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="attendanceTable">
          <thead style="position:sticky;top:0;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th></th>
              <th class="px-6 py-3">Employee Name</th>
              <th colspan=2>Leave Balance Allocated</th>
              <?php $colspan = count($months[$year]); ?>
              <th class="text-center" colspan="<?php echo $colspan; ?>">Monthly Leave Balance Costed</th>
              <th></th>
              <th colspan=2>
                Current Leave Balance
              </th>
              <th>
                Total
              </th>
              <th>

              </th>
            </tr>
            <tr class="static-cell">
              <th class="px-6 py-3">S.NO.</th>
              <th class="px-6 py-3">
                <input id="empnameFilter" name="empname" style="height: 35px; border-radius: 5px; border: 1px solid rgb(198, 198, 198);" type="text" placeholder="Search for employee" oninput="filterTable()">
              </th>
              <th>CL + SL</th>
              <th>CO</th>
              <?php foreach ($months as $year => $year_months) : ?>
                <?php foreach ($year_months as $month_num => $month_name) : ?>
                  <th><?php echo $month_name . ' ' . $year; ?></th>
                <?php endforeach; ?>
              <?php endforeach; ?>
              <th>Total Leave <br>Balance Costed</th>
              <th>CL+SL</th>
              <th>
                CO
              </th>
              <th>
                <select name="selectFilter" style="height: 35px; border-radius: 5px; border: 1px solid rgb(198, 198, 198);" id="selectFilter" onchange="filterTable()">
                  <option value="">All</option>
                  <option value="+ve">+ve</option>
                  <option value="-ve">-ve</option>
                </select>
              </th>
              <th>
                Last Updation
              </th>
            </tr>
          </thead>
          <tbody id="tableBody">
            <?php foreach ($employees as $employee) : ?>
              <?php
              $totalLeaveCount = 0;
              ?>
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4">
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
                <td><?php echo date('Y-m-d H:i:s', strtotime($result['lastupdate'] . ' +5 hours +30 minutes')); ?></td>

              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

      </div>
    </div>
    <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

    <img width="90px" style="position: absolute; left:20px;" src="./public/logo-1@2x.png" />
    <a class="anikahrm14" href="./index.html" style="top:20px; left:120px;" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./reports.html" style="text-align: center; width: 60%;" id="attendenceManagement">Leave Balance</a>
  </div>
  <script>
    function filterTable() {
        var selectFilter = document.getElementById("selectFilter").value;
        var empnameFilter = document.getElementById("empnameFilter").value.toUpperCase();
        var table = document.getElementById("attendanceTable");
        var rows = table.getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            var cells = row.getElementsByTagName("td");
            var totalCell = cells[cells.length - 2];
            if (!totalCell) {
                continue;
            }
            var totalLeaves1 = parseFloat(totalCell.textContent || totalCell.innerText);

            var empnameCell = row.getElementsByTagName("td")[1];
            var empnameValue = empnameCell.textContent || empnameCell.innerText;

            if ((empnameValue.toUpperCase().indexOf(empnameFilter) > -1) &&
                (selectFilter === "" ||
                    (selectFilter === "+ve" && totalLeaves1 >= 0) ||
                    (selectFilter === "-ve" && totalLeaves1 < 0))) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }

        // Update the href attribute of the anchor tag with the filtered values
        var exportPDFLink = document.getElementById("exportPDFLink");
        exportPDFLink.href = "print_lb_report.php?empnameFilter=" + encodeURIComponent(empnameFilter) + "&selectFilter=" + encodeURIComponent(selectFilter);
    }
</script>


</body>

</html>