<?php
// Establish database connection
@include 'inc/config.php';

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}

// Check if monthYear parameter is set
if (isset($_GET['monthYear'])) {
    $monthYear = $_GET['monthYear'];

    $selectedMonthYear = explode("-", $monthYear);
    $selectedMonth = $selectedMonthYear[1];
    $selectedYear = $selectedMonthYear[0];

    // Calculate the first and last day of the selected month
    $firstDayOfMonth = date("Y-m-01", strtotime($selectedYear . "-" . $selectedMonth . "-01"));
    $lastDayOfMonth = date("Y-m-t", strtotime($selectedYear . "-" . $selectedMonth . "-01"));
?>
    <thead style="text-align: center;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3"></th>
            <th scope="col" class="px-6 py-3">Employee Name</th>
            <th scope="col" class="px-6 py-3">LOP Month</th>
            <th scope="col" class="px-6 py-3">Total Days</th>
            <th scope="col" class="px-6 py-3">Worked Days</th>
            <th scope="col" class="px-6 py-3">Leave Balance</th>
            <th scope="col" class="px-6 py-3">LOP</th>
            <th scope="col" class="px-6 py-3">Lop Adjustment</th>
            <th scope="col" class="px-6 py-3">Final LOP</th>
            <th scope="col" class="px-6 py-3">Comments</th>
        </tr>
    </thead>
    <?php
    $totalDaysInMonth = date("t", strtotime($firstDayOfMonth));
    $sundaysCount = 0;
    for ($j = 1; $j <= $totalDaysInMonth; $j++) {
        $dateOfAttendance = date("Y-m-$j");
        $dayOfWeek = date('N', strtotime($dateOfAttendance));
        if ($dayOfWeek == 7) {
            $sundaysCount++;
        }
    }
    $fetchingHolidays = mysqli_query($con, "
SELECT COUNT(DISTINCT date) AS count
FROM holiday
WHERE date >= '$firstDayOfMonth'
AND date <= '$lastDayOfMonth'
") or die(mysqli_error($con));
    $holidaysCount = mysqli_fetch_assoc($fetchingHolidays)['count'];
    $totalWorkingDays = $totalDaysInMonth - $sundaysCount - $holidaysCount;


    // Fetch data from database based on selected month and year
    $sql = "SELECT lb.empname, 
    (lb.cl + lb.sl + lb.co) AS lop, 
    pl.lopadj, 
    pl.comment,
    emp.pic
FROM leavebalance lb 
LEFT JOIN payroll_lop pl 
ON lb.empname = pl.empname 
AND pl.lopmonth = '" . date('F Y', mktime(0, 0, 0, $selectedMonth, 1)) . "' 
LEFT JOIN emp 
ON lb.empname = emp.empname
WHERE (lb.cl + lb.sl + lb.co) < 0";


    $que = mysqli_query($con, $sql);

    // Check if data is found
    if (mysqli_num_rows($que) > 0) {
        while ($result = mysqli_fetch_assoc($que)) {
            $fetchingEmployees = mysqli_query($con, "SELECT UserID FROM emp WHERE empname = '" . $result['empname'] . "'") or die(mysqli_error($con));
            $employeeData = mysqli_fetch_assoc($fetchingEmployees);
            $employeeID = $employeeData['UserID'];

            $leavesData1 = mysqli_query($con, "
            SELECT `from`, `to`
            FROM leaves
            WHERE empname = '" . $result['empname'] . "'
            AND ((status = 1 AND status1 = 1) OR (status = 1 AND status1 = 0)) 
            AND leavetype = 'HALF DAY'
            AND (
                (`from` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                OR (`to` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                OR (`from` <= '$firstDayOfMonth' AND `to` >= '$lastDayOfMonth')
            )
        ") or die(mysqli_error($con));

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

            $ciCoColumn = mysqli_query($con, "
          SELECT COUNT(DISTINCT DATE(AttendanceTime)) AS count
          FROM CamsBiometricAttendance
           WHERE UserID = '$employeeID'
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
                   WHERE UserID = '$employeeID'
                  AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                  AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                  AND AttendanceType = 'CheckOut'
                  AND DAYOFWEEK(AttendanceTime) != 1  -- Exclude entries on Sunday
              ))
              OR (AttendanceType = 'CheckOut' AND DATE(AttendanceTime) IN (
                  SELECT DATE(AttendanceTime)
                  FROM CamsBiometricAttendance
                   WHERE UserID = '$employeeID'
                  AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                  AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                  AND AttendanceType = 'CheckIn'
                  AND DAYOFWEEK(AttendanceTime) != 1  -- Exclude entries on Sunday
              ))
          )
      ") or die(mysqli_error($con));
            $leavesCountCL = mysqli_query($con, "
      SELECT icl
      FROM leavebalance 
      WHERE empname = '" . $result['empname'] . "'
  ") or die(mysqli_error($con));
            $leavesCountSL = mysqli_query($con, "
  SELECT isl
  FROM leavebalance 
  WHERE empname = '" . $result['empname'] . "'
") or die(mysqli_error($con));
            $leavesCountCO = mysqli_query($con, "
SELECT ico
FROM leavebalance 
WHERE empname = '" . $result['empname'] . "'
") or die(mysqli_error($con));

            $leavesCountCCL = mysqli_query($con, "
SELECT cl
FROM leavebalance 
WHERE empname = '" . $result['empname'] . "'
") or die(mysqli_error($con));
            $leavesCountCSL = mysqli_query($con, "
SELECT sl
FROM leavebalance 
WHERE empname = '" . $result['empname'] . "'
") or die(mysqli_error($con));
            $leavesCountCCO = mysqli_query($con, "
SELECT co
FROM leavebalance 
WHERE empname = '" . $result['empname'] . "'
") or die(mysqli_error($con));

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

            $ciCoCount = mysqli_fetch_assoc($ciCoColumn)['count'];

            $ciCoCount = $ciCoCount - $leaveCount1;
            $ciCoCount1 = $ciCoCount;
            $totalLeavesValue1 = $iclValue +  $islValue + $icoValue;
            $currentLeavesValue = $cclValue +  $cslValue + $ccoValue;

    ?>
            <form id="lopForm">
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4"><img src="../pics/<?php echo $result['pic']; ?>" width="50px" style="border-radius: 50%;" alt=""></td>
                    <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                    <td class="px-6 py-4"><?php echo date('F', mktime(0, 0, 0, $selectedMonth, 1)) . ' ' . $selectedYear; ?></td>
                    <td class="px-6 py-4"><?php echo $totalDaysInMonth; ?></td>
                    <td class="px-6 py-4"><?php echo $ciCoCount1; ?></td>
                    <td class="px-6 py-4"><?php echo $currentLeavesValue; ?>/<?php echo $totalLeavesValue1; ?></td>
                    <td class="px-6 py-4"><?php echo abs($result['lop']); ?></td>
                    <td class="px-6 py-4">
                        <?php if ($result['lopadj'] !== null) : ?>
                            <?php echo $result['lopadj']; ?>
                        <?php else : ?>
                            <input oninput="updateFinalLop(this)" value="0" type="number" name="lopadj" style="width: 70px; border-radius: 10px;">
                        <?php endif; ?>
                    </td>


                    <td class="px-6 py-4 final-lop-cell"><?php echo abs($result['lop']); ?></td>
                    <td class="px-6 py-4">
                        <?php if ($result['lopadj'] !== null) : ?>
                            <?php echo $result['comment']; ?>
                        <?php else : ?>
                            <input type="text" name="comment" class="comment-input" style="border-radius: 10px;" required>
                        <?php endif; ?>
                    </td>

                </tr>
            <?php
        }
    } else {
            ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td colspan="8" class="px-6 py-4 text-center">No LOP</td>
            </tr>
    <?php
    }
} else {
    echo "Error: Month and year parameter not provided.";
}
    ?>
    <br>
    <button type="button" onclick="submitFormData()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Submit
    </button>
            </form>
            <script>
                function updateFinalLop(input) {
                    // Get the custom value entered by the user
                    var adjustment = parseFloat(input.value.trim());
                    // If the input is empty, set it to 0
                    if (isNaN(adjustment)) {
                        adjustment = 0;
                    }
                    const tr = input.closest('tr');
                    const lopDaysCell = tr.querySelector('td:nth-child(6)');
                    const finalLopCell = tr.querySelector('.final-lop-cell');
                    const lopDays = parseFloat(lopDaysCell.textContent);
                    finalLopCell.textContent = Math.abs(lopDays + adjustment);
                }
            </script>