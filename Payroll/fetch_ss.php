<?php
// Establish database connection
@include 'inc/config.php';

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}
$smonth = isset($_GET['smonth']) ? $_GET['smonth'] : '';
// Check if monthYear parameter is set
if (isset($_GET['monthYear'])) {
    // $monthYear = $_GET['smonth'];

    $selectedMonthYear = explode("-", $monthYear);
    $selectedMonth = $selectedMonthYear[1];
    $selectedYear = $selectedMonthYear[0];

    // Calculate the first and last day of the selected month
    $firstDayOfMonth = date("Y-m-01", strtotime($selectedYear . "-" . $selectedMonth . "-01"));
    $lastDayOfMonth = date("Y-m-t", strtotime($selectedYear . "-" . $selectedMonth . "-01"));

    $totalDaysInMonth = date("t", strtotime($firstDayOfMonth));
    $fetchingHolidays = mysqli_query($con, "
    SELECT COUNT(DISTINCT date) AS count
    FROM holiday
    WHERE date >= '$firstDayOfMonth'
    AND date <= '$lastDayOfMonth'
") or die(mysqli_error($con));

$holidaysCount = mysqli_fetch_assoc($fetchingHolidays)['count'];
    $sundaysCount = 0;
    for ($j = 1; $j <= $totalDaysInMonth; $j++) {
      $dateOfAttendance = date("Y-m-$j");
      $dayOfWeek = date('N', strtotime($dateOfAttendance));
      if ($dayOfWeek == 7) {
        $sundaysCount++;
      }
    }
    ?>

   <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
    
        <tr style="border-top: 1px solid rgb(224, 224, 224);">
        <th colspan="2" scope="col" class="px-9 py-4">
        <label class="inline-flex items-center me-5 cursor-pointer" style="position: sticky; left:25px;">
                    <input type="checkbox" id="toggleCheckbox" value="" class="sr-only peer">
                    <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-orange-300 dark:peer-focus:ring-orange-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-orange-500"></div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Edit Mode</span>
                  </label>
                  </th>
            <th colspan="23" style="text-align: center;" scope="col" class="px-6 py-3">
            SALARY STATEMENT -  <?php echo date('F', mktime(0, 0, 0, $selectedMonth, 1)) . ' ' . $selectedYear; ?>
            </th>
  </tr>
          <tr style="border-top: 1px solid rgb(224, 224, 224);position: sticky; top: 0; ">
          <th colspan="1" style="text-align: center;position: sticky; left: 0; background-color: #fdfdfd;" scope="col" class="px-6 py-3">
                Employee Details
              </th>
            <th colspan="4" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 238, 255, 0.5);" scope="col" class="px-6 py-3">
              FIXED SALARY COMPONENTS
            </th>
            <th colspan="6" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 231, 194, 0.5);" scope="col" class="px-6 py-3">
              Days Calculation
            </th>
            <th colspan="4" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 255, 204, 0.5);" scope="col" class="px-6 py-3">
              SALARY AS PER NO OF DAYS
            </th>
            <th colspan="7" scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 161, 161, 0.5);" class="px-6 py-3">
              Deductions
            </th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160);background-color: rgba(194, 255, 204, 0.5);" class="px-6 py-3">
              Additional Compensation
              </th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160);position: sticky; right: 0; top:0; background-color: #fdfdfd;" class="px-6 py-3">
                NET Payable
              </th>
          </tr>
          <tr style="border-top: 1px solid rgb(224, 224, 224);position: sticky; top: 50px; ">
          <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224);position: sticky; left: 0; background-color: #fdfdfd;" class="px-6 py-3">Emp Name</th>
            <th scope="col" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 238, 255, 0.2);" class="px-6 py-3">Basic Pay</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);" class="px-6 py-3">HRA</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);" class="px-6 py-3">OA</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);" class="px-6 py-3">Gross Salary</th>
            <th scope="col" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 231, 194, 0.2);" class="px-6 py-3">Total Days</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-6 py-3">Present Days</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-6 py-3">Leaves</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-6 py-3">Week Off Days</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-6 py-3">LOP</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-6 py-3">Pay Days</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 255, 204, 0.2);" class="px-6 py-3">Basic salary</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);" class="px-6 py-3">HRA</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);" class="px-6 py-3">OA</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);" class="px-6 py-3">Gross Salary</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 194, 194, 0.2);" class="px-6 py-3">EPF</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);" class="px-6 py-3">ESIC</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);" class="px-6 py-3">TDS Deduction</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);" class="px-6 py-3">Loan EMI</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);" class="px-6 py-3">LOP Amount</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);" class="px-6 py-3">Misc. Deductions</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);" class="px-6 py-3">Total Deduction</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160);  background-color: rgba(194, 255, 204, 0.2);" class="px-6 py-3">Bonus</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); position: sticky; right: 0; top: 50px; background-color: #fdfdfd;" class="px-6 py-3">Salary Payout</th>
          </tr>
        </thead>

        <?php
     $sql = "SELECT 
     ms.empname, 
     ms.emp_no,
     ms.desg,
     ms.dept,
     ms.bp, 
     ms.hra, 
     ms.oa, 
     ms.epf1, 
     ms.esi1,
     ms.ctc,
     ms.tds,
     emi.empname AS emi_empname,
     emi.emi,
     lop.empname AS lop_empname,
     lop.flop,
     bonus.empname AS bonus_empname,
     bonus.amt,
     misc.empname AS misc_empname,
     misc.damt
 FROM payroll_msalarystruc ms
 LEFT JOIN payroll_emi emi ON ms.empname = emi.empname AND emi.emimonth = '$smonth'
 LEFT JOIN payroll_lop lop ON ms.empname = lop.empname AND lop.lopmonth = '$smonth'
 LEFT JOIN payroll_bonusamt bonus ON ms.empname = bonus.empname AND bonus.paymonth = '$smonth'
 LEFT JOIN payroll_misc misc ON ms.empname = misc.empname AND misc.paymonth = '$smonth'
 LEFT JOIN payroll_schedule ON payroll_schedule.smonth = '$smonth'
 WHERE payroll_schedule.approval = 0
ORDER BY emp_no ASC";



              $result = mysqli_query($con, $sql);

              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  $fetchingEmployees = mysqli_query($con, "SELECT UserID FROM emp WHERE empname = '" . $row['empname'] . "'") or die(mysqli_error($con));
                  $employeeData = mysqli_fetch_assoc($fetchingEmployees);
                  $employeeID = 0;
                  if ($employeeData) {
                    $employeeID = $employeeData['UserID'];

                    $leavesData1 = mysqli_query($con, "
                SELECT `from`, `to`
                FROM leaves
                WHERE empname = '" . $row['empname'] . "'
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

                      for ($k = 0; $k <= $to - $from; $k += 24 * 60 * 60) {
                        $currentDay = date('N', $from + $k);
                        if ($currentDay != 7 && $from + $k >= strtotime($firstDayOfMonth) && $from + $k <= strtotime($lastDayOfMonth)) {
                          $leaveCount1 += 0.5;
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
          WHERE empname = '" . $row['empname'] . "'
      ") or die(mysqli_error($con));
                    $leavesCountSL = mysqli_query($con, "
      SELECT isl
      FROM leavebalance 
      WHERE empname = '" . $row['empname'] . "'
  ") or die(mysqli_error($con));
                    $leavesCountCO = mysqli_query($con, "
  SELECT ico
  FROM leavebalance 
  WHERE empname = '" . $row['empname'] . "'
") or die(mysqli_error($con));

                    $leavesCountCCL = mysqli_query($con, "
SELECT cl
FROM leavebalance 
WHERE empname = '" . $row['empname'] . "'
") or die(mysqli_error($con));
                    $leavesCountCSL = mysqli_query($con, "
SELECT sl
FROM leavebalance 
WHERE empname = '" . $row['empname'] . "'
") or die(mysqli_error($con));
                    $leavesCountCCO = mysqli_query($con, "
SELECT co
FROM leavebalance 
WHERE empname = '" . $row['empname'] . "'
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
                    $leavesData = mysqli_query($con, "
                    SELECT `from`, `to`
                    FROM leaves 
                    WHERE empname = '" . $row['empname'] . "'
                          AND ((status = 1 AND status1 = 1) OR (status = 1 AND status1 = 0)) 
                    AND leavetype != 'HALF DAY'
                    AND leavetype != 'OFFICIAL LEAVE'
                    AND (
                        (`from` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                        OR (`to` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                        OR (`from` <= '$firstDayOfMonth' AND `to` >= '$lastDayOfMonth')
                    )
                ") or die(mysqli_error($con));
                    $fetchingHolidaysa = mysqli_query($con, "
                    SELECT date
                    FROM holiday
                    WHERE date >= '$firstDayOfMonth'
                    AND date <= '$lastDayOfMonth'
                ") or die(mysqli_error($con));
                
                $holidays = [];
                while ($holiday = mysqli_fetch_assoc($fetchingHolidaysa)) {
                    $holidays[] = $holiday['date'];
                }   
                
                $leaveCount = 0;
                while ($leaveEntry = mysqli_fetch_assoc($leavesData)) {
                    $from = strtotime($leaveEntry['from']);
                    $to = strtotime($leaveEntry['to']);
                
                    // Calculate leave duration in days, excluding Sundays and holidays
                    for ($k = 0; $k <= $to - $from; $k += 24 * 60 * 60) {
                        $currentDay = date('N', $from + $k);
                        $currentDate = date('Y-m-d', $from + $k);
                        if ($currentDay != 7 && $from + $k >= strtotime($firstDayOfMonth) && $from + $k <= strtotime($lastDayOfMonth) && !in_array($currentDate, $holidays)) {
                            $leaveCount++;
                        }
                    }
                }
                    $ciCoCount = mysqli_fetch_assoc($ciCoColumn)['count'];
                    $ciCoCount = $ciCoCount - $leaveCount1;
                    $ciCoCount1 = $ciCoCount;
                    $weekoff = $sundaysCount +  $holidaysCount;
                    $totalleavesCount1 =($leaveCount + $leaveCount1); 
                  $tds = $row['tds'];
                                      $flop = $row['flop'];
                                      // $epf1= $row['epf1'];
                                      $gs = $row['bp'] + $row['hra'] + $row['oa'];
                                      $lopamt = ($gs / $totalDaysInMonth) * $row['flop'];
                                      $paydays = $totalDaysInMonth - $flop;
                  
                                      // as per no of days
                                      $basic = $row['bp'] * $paydays / $totalDaysInMonth;
                                      $hra = $row['hra'] * $paydays / $totalDaysInMonth;
                                      $oa = $row['oa'] * $paydays / $totalDaysInMonth;
                                      $gross = $basic + $hra + $oa;
                  
                                      $totaldeduct = $row['epf1'] + $row['esi1'] + $row['emi'] + $lopamt + $tds;
                                      $bonus = $row['amt'];
                                      $payout = floor($gross - $totaldeduct + $bonus);
                                      if (($payout - floor($payout)) > 0.5) {
                                        $payout = ceil($payout);
                                      }
                                    } else {
                                         $tds = $row['tds'];
                                      $gs = $row['bp'] + $row['hra'] + $row['oa'];
                                      $lopamt = ($gs / $totalDaysInMonth) * $row['flop'];
                                      $paydays = $totalDaysInMonth - $row['flop'];
                  
                                      // as per no of days
                                      $basic = $row['bp'] * $paydays / $totalDaysInMonth;
                                      $hra = $row['hra'] * $paydays / $totalDaysInMonth;
                                      $oa = $row['oa'] * $paydays / $totalDaysInMonth;
                                      $gross = $basic + $hra + $oa;
                  
                                      $totaldeduct = $row['epf1'] + $row['esi1'] + $row['emi'] + $lopamt + $tds;
                                      $bonus = $row['amt'];
                                      $payout = floor($gross - $totaldeduct + $bonus);
                                      if (($payout - floor($payout)) > 0.5) {
                                        $payout = ceil($payout);
                                      }
                                      $employeeID = 0;
                                      $ciCoCount1 = 0;
                                      $totalleavesCount1 = 0;
                                      $lopamt = 0;
                                      $flop = 0;
                                      $bonus = 0;
                                        $weekoff = 0;
                                       
                                    }

              ?>
        <tbody>
        <tr style="border-top: 1px solid rgb(224, 224, 224);" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224);position: sticky; left: 0; background-color: #fdfdfd;">
            <?php echo $row['empname']; ?>
          </td>
          <td class="px-6 py-4 hidden" style=" text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 238, 255, 0.2);">
           <?php echo date('F', mktime(0, 0, 0, $selectedMonth, 1)) . ' ' . $selectedYear; ?>
          </td>
          <td class="px-6 py-4" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 238, 255, 0.2);">
            <input type="number" name="fbp" value="<?php echo $row['bp']; ?>" style="background-color: rgba(194, 238, 255, 0.01);" class="highlight">
          </td>
          <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);">
            <input type="number" name="fhra" value="<?php echo $row['hra']; ?>" style="background-color: rgba(194, 238, 255, 0.01);">
          </td>
          <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);">
            <input type="number" name="foa" value="<?php echo $row['oa']; ?>" style="background-color: rgba(194, 238, 255, 0.01);">
          </td>
          <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);">
            <input type="number" name="fgs" value="<?php echo $gs; ?>" style="background-color: rgba(194, 238, 255, 0.01);">
          </td>
          <td class="px-6 py-4" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 231, 194, 0.2);">
            <input type="number" name="monthdays" id="monthdays" value="<?php echo $totalDaysInMonth ?>" style="background-color: rgba(194, 238, 255, 0.01); width: 60px;">
          </td>
          <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
            <input type="number" name="present" value="<?php echo $ciCoCount1; ?>" style="background-color: rgba(194, 238, 255, 0.01); width: 80px;">
          </td>
          <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
            <input type="number" name="leaves" value="<?php echo $totalleavesCount1; ?>" style="background-color: rgba(194, 238, 255, 0.01); width: 80px;">
          </td>
          <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
            <input type="number" name="sundays" value="<?php echo $weekoff ?>" style="background-color: rgba(194, 238, 255, 0.01); width: 60px;">
          </td>
          <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
            <input type="number" name="flop" id="flop" value="<?php echo isset($row['flop']) ? $row['flop'] : 0; ?>" style="background-color: rgba(194, 238, 255, 0.01); width: 60px;">
          </td>
          <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
            <input type="number" name="paydays" id="paydays" value="<?php echo $paydays ?>" style="background-color: rgba(194, 238, 255, 0.01); width: 80px;">
          </td>
          <td class="px-6 py-4" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 255, 204, 0.2);">
            <input type="number" name="bp" id="bp" value="<?php echo $basic; ?>" style="background-color: rgba(194, 238, 255, 0.01);">
          </td>
          <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);">
            <input type="number" name="hra" id="hra" value="<?php echo $hra ?>" style="background-color: rgba(194, 238, 255, 0.01);">
          </td>
          <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);">
            <input type="number" name="oa" value="<?php echo $oa ?>" style="background-color: rgba(194, 238, 255, 0.01);">
          </td>
          <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);">
            <input type="number" name="gross" value="<?php echo $gross ?>" style="background-color: rgba(194, 238, 255, 0.01);">
          </td>
          <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 194, 194, 0.2);">
            <input type="number" name="epf1" value="<?php echo $row['epf1']; ?>" style="background-color: rgba(194, 238, 255, 0.01);">
          </td>
          <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);">
            <input type="number" name="esi1" value="<?php echo isset($row['esi1']) ? $row['esi1'] : 0; ?>"  style="background-color: rgba(194, 238, 255, 0.01);">
          </td>
          <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);">
            <input type="number" name="tds"  value="<?php echo $tds; ?>"  style="background-color: rgba(194, 238, 255, 0.01);">
          </td>
          <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);">
            <input type="number" name="emi" value="<?php echo isset($row['emi']) ? $row['emi'] : 0; ?>" style="background-color: rgba(194, 238, 255, 0.01);">
          </td>
          <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);">
            <input type="number" name="lopamt" value="<?php echo $lopamt; ?>" style="background-color: rgba(194, 238, 255, 0.01);">
          </td>
          <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);">
                    <input type="number" name="misc" value="<?php echo isset($row['damt']) ? $row['damt'] : 0; ?>" style="background-color: rgba(194, 238, 255, 0.01);">
                  </td>
          <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);">
            <input type="number" name="totaldeduct" value="<?php echo $totaldeduct; ?>" style="background-color: rgba(194, 238, 255, 0.01);">
          </td>
          <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160);   background-color: rgba(194, 255, 204, 0.2);">
                    <input type="number" name="bonus" value="<?php echo isset($row['amt']) ? $row['amt'] : 0; ?>" style="background-color: rgba(194, 238, 255, 0.01);">
                  </td>
          <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); position: sticky; right: 0; background-color: #fdfdfd;">
            <input type="number" name="payout" value="<?php echo $payout; ?>" style="background-color: rgba(194, 238, 255, 0.01);">
          </td>
          <td class="px-6 py-4 hidden" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); position: sticky; right: 0; background-color: #fdfdfd;">
                    <input type="hidden" name="emp_no" value=" <?php echo $row['emp_no']; ?> " style="background-color: rgba(194, 238, 255, 0.01);">
                  </td>
                  <td class="px-6 py-4 hidden" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); position: sticky; right: 0; background-color: #fdfdfd;">
                    <input type="hidden" name="desg" value=" <?php echo $row['desg']; ?> " style="background-color: rgba(194, 238, 255, 0.01);">
                  </td>
                  <td class="px-6 py-4 hidden" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); position: sticky; right: 0; background-color: #fdfdfd;">
                    <input type="hidden" name="dept" value=" <?php echo $row['dept']; ?> " style="background-color: rgba(194, 238, 255, 0.01);">
                  </td>
        </tr>
    </tbody>
      <?php
      }
    } else {
      ?>
      <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <td colspan="24" class="px-6 py-4 text-center">No LOP</td>
      </tr>
    <?php
    }

    ?>
<?php
    }
 else {
    echo "Error: Month and year parameter not provided.";
}
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Function to calculate and update paydays
    function updatePaydays() {
        $('tbody tr').each(function() {
            var monthdays = parseFloat($(this).find('input[name="monthdays"]').val()) || 0;
            var flop = parseFloat($(this).find('input[name="flop"]').val()) || 0;
            var paydays = monthdays - flop;
            $(this).find('input[name="paydays"]').val(paydays);
        });
    }
    
    // Function to calculate and update bp, epf1, esi1
    function updateBpAndEpf1AndEsi1() {
        $('tbody tr').each(function() {
            var monthdays = parseFloat($(this).find('input[name="monthdays"]').val()) || 0;
            var flop = parseFloat($(this).find('input[name="flop"]').val()) || 0;
            var paydays = parseFloat($(this).find('input[name="paydays"]').val()) || 0;
            var bp = parseFloat($(this).find('input[name="fbp"]').val()) || 0;
            var gross = parseFloat($(this).find('input[name="gross"]').val()) || 0;
            var newBp = (bp * paydays) / monthdays;
            $(this).find('input[name="bp"]').val(newBp.toFixed(2));
            var epf1 = Math.round(newBp * 0.12);
            var esi1 = gross < 21000 ? Math.round(gross * 0.0075) : 0; 
            $(this).find('input[name="epf1"]').val(epf1);
            $(this).find('input[name="esi1"]').val(esi1);
        });
    }

    // Function to calculate and update hra
    function updateHra() {
        $('tbody tr').each(function() {
            var monthdays = parseFloat($(this).find('input[name="monthdays"]').val()) || 0;
            var flop = parseFloat($(this).find('input[name="flop"]').val()) || 0;
            var paydays = parseFloat($(this).find('input[name="paydays"]').val()) || 0;
            var hra = parseFloat($(this).find('input[name="fhra"]').val()) || 0;
            var newHra = (hra * paydays) / monthdays;
            $(this).find('input[name="hra"]').val(newHra.toFixed(2));
        });
    }

    // Function to calculate and update oa
    function updateOa() {
        $('tbody tr').each(function() {
            var monthdays = parseFloat($(this).find('input[name="monthdays"]').val()) || 0;
            var flop = parseFloat($(this).find('input[name="flop"]').val()) || 0;
            var paydays = parseFloat($(this).find('input[name="paydays"]').val()) || 0;
            var oa = parseFloat($(this).find('input[name="foa"]').val()) || 0;
            var newOa = (oa * paydays) / monthdays;
            $(this).find('input[name="oa"]').val(newOa.toFixed(2));
        });
    }

    // Function to calculate and update totaldeduct, and lopamt
    function updateTotalDeduct() {
        $('tbody tr').each(function() {
            var tds = parseFloat($(this).find('input[name="tds"]').val()) || 0; 
            var epf1 = parseFloat($(this).find('input[name="epf1"]').val()) || 0;
            var esi1 = parseFloat($(this).find('input[name="esi1"]').val()) || 0;
            var emi = parseFloat($(this).find('input[name="emi"]').val()) || 0;
            var gs = parseFloat($(this).find('input[name="fgs"]').val()) || 0;
            var monthdays = parseFloat($(this).find('input[name="monthdays"]').val()) || 0;
            var flop = parseFloat($(this).find('input[name="flop"]').val()) || 0;
            var misc = parseFloat($(this).find('input[name="misc"]').val()) || 0;
              var lopamt = parseFloat($(this).find('input[name="lopamt"]').val()) || 0; // Calculate lopamt only if not manually entered
          var  lopamt =  ((gs / monthdays) * flop);
            // Update lopamt field
            $(this).find('input[name="lopamt"]').val(lopamt.toFixed(2));
            
            var totaldeduct = epf1 + tds + esi1 + emi + lopamt + misc;
            $(this).find('input[name="totaldeduct"]').val(totaldeduct.toFixed(2));
        });
    }

    // Function to calculate and update gross, totaldeduct, and payout
    function updateGrossDeductAndPayout() {
        $('tbody tr').each(function() {
            var monthdays = parseFloat($(this).find('input[name="monthdays"]').val()) || 0;
            var gs = parseFloat($(this).find('input[name="fgs"]').val()) || 0;
            var flop = parseFloat($(this).find('input[name="flop"]').val()) || 0;
            var epf1 = parseFloat($(this).find('input[name="epf1"]').val()) || 0;
            var esi1 = parseFloat($(this).find('input[name="esi1"]').val()) || 0;
            var emi = parseFloat($(this).find('input[name="emi"]').val()) || 0;
            var gross = gs;

            // Call updateTotalDeduct to get the latest totaldeduct value
            updateTotalDeduct();

            // Retrieve the latest totaldeduct value
            var totaldeduct = parseFloat($(this).find('input[name="totaldeduct"]').val()) || 0;

            // Calculate payout
            var bonus = parseFloat($(this).find('input[name="bonus"]').val()) || 0;
            var payout = Math.floor(gross - totaldeduct + bonus);
            $(this).find('input[name="payout"]').val(payout.toFixed(2));
            var newBp = parseFloat($(this).find('input[name="bp"]').val()) || 0;
            var newHra = parseFloat($(this).find('input[name="hra"]').val()) || 0;
            var newOa = parseFloat($(this).find('input[name="oa"]').val()) || 0;
           
            var newGross = newBp + newHra + newOa ;
            $(this).find('input[name="gross"]').val(newGross.toFixed(2));
        });
    }

    // Update totaldeduct and payout when epf1 is manually changed
    $(document).on('change', 'input[name="epf1"]', function() {
        updateTotalDeduct();
        updateGrossDeductAndPayout();
    });
    
    // Update totaldeduct and payout when esi1 is manually changed
    $(document).on('change', 'input[name="esi1"]', function() {
        updateTotalDeduct();
        updateGrossDeductAndPayout();
    });
    
    // Update esi1 when flop is changed
    $(document).on('change', 'input[name="flop"]', function() {
        updateBpAndEpf1AndEsi1();
        updateTotalDeduct();
        updateGrossDeductAndPayout();
    });

    // Update totaldeduct and payout when lopamt is manually changed
    $(document).on('change', 'input[name="lopamt"]', function() {
        updateTotalDeduct();
        updateGrossDeductAndPayout();
    });

    // Listen for input events on relevant fields
    $(document).on('input', 'input[name="monthdays"], input[name="lopamt"], input[name="misc"],input[name="flop"],input[name="tds"], input[name="fgs"], input[name="fbp"], input[name="fhra"], input[name="foa"], input[name="emi"],input[name="bonus"],input[name="damt"]', function() {
        updatePaydays();
        updateBpAndEpf1AndEsi1();
        updateHra();
        updateOa();
        updateTotalDeduct();
        updateGrossDeductAndPayout();
    });

    // Trigger initial calculations
    updatePaydays();
    updateBpAndEpf1AndEsi1();
    updateHra();
    updateOa();
    updateTotalDeduct();
    updateGrossDeductAndPayout();
});
</script>