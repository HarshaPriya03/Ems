<?php

$con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  header('location:loginpage.php');
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="../css/global.css" />
  <link rel="stylesheet" href="../css/attendence.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .udbtn:hover {
      color: black !important;
      background-color: white !important;
      outline: 1px solid #F46114;
    }

    input {
      border: none;
      text-align: center;
      width: 100px;
    }
    .rectangle-parent23 {
  position: absolute;
  width: 107%;
  top: calc(50% - 360px);
  /*right: 1.21%;*/
  left: -70px;
  height: 850px;
  font-size: var(--font-size-xl);
}
.highlight {
      pointer-events: none;
    }

    .addim {
      border: 1px solid #008DDA;
      border-radius: 5px;
    }
  </style>
</head>

<body>
  <div class="attendence4">
    <div class="bg14"></div>

    <div class="rectangle-parent23" style="margin-top: -60px; overflow: auto;scale:0.9;">
      <select style="position: sticky;font-size:20px; border: 1px solid #ff5400; border-radius:5px; left:0px; margin-bottom:10px;" id="monthYearSelect" onchange="filterData()">
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
      <br>
      <form>
        <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400" id="ssTableBody" >
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr style="border-top: 1px solid rgb(224, 224, 224);">
              <th colspan="23" style="text-align: center;" scope="col" class="px-6 py-3">
                SALARY STATEMENT - MARCH 2024
              </th>
            </tr>
            <tr style="border-top: 1px solid rgb(224, 224, 224);">
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
              <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160);position: sticky; right: 0; background-color: #fdfdfd;" class="px-6 py-3">
                NET Payable
              </th>
            </tr>
            <tr style="border-top: 1px solid rgb(224, 224, 224);">
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
              <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); position: sticky; right: 0; background-color: #fdfdfd;" class="px-6 py-3">Salary Payout</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $firstDayOfMonth = date("Y-m-01");
            $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth)) . ' 23:59:59';
            $totalDaysInMonth = date("t", strtotime($firstDayOfMonth));
            $sundaysCount = 0;
            for ($j = 1; $j <= $totalDaysInMonth; $j++) {
              $dateOfAttendance = date("Y-m-$j");
              $dayOfWeek = date('N', strtotime($dateOfAttendance));
              if ($dayOfWeek == 7) {
                $sundaysCount++;
              }
            }
            ?>

            <?php
       $sql = "SELECT 
       ms.empname, 
       ms.bp, 
       ms.hra, 
       ms.oa, 
       ms.epf1, 
       ms.esi1,
       ms.ctc,
       emi.empname AS emi_empname,
       emi.emi,
       lop.empname AS lop_empname,
       lop.flop,
       bonus.empname AS bonus_empname,
       bonus.amt,
       misc.empname AS misc_empname,
    misc.damt
   FROM payroll_msalarystruc ms
   LEFT JOIN payroll_emi emi ON ms.empname = emi.empname
   LEFT JOIN payroll_lop lop ON ms.empname = lop.empname
   LEFT JOIN payroll_bonusamt bonus ON ms.empname = bonus.empname
   LEFT JOIN payroll_misc misc ON ms.empname = misc.empname";
   

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

                  $ciCoCount = mysqli_fetch_assoc($ciCoColumn)['count'];
                  $ciCoCount = $ciCoCount - $leaveCount1;
                  $ciCoCount1 = $ciCoCount;
                  $totalLeavesValue1 = $iclValue +  $islValue + $icoValue;
                  $currentLeavesValue = $cclValue +  $cslValue + $ccoValue;

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

                  $totaldeduct = $row['epf1'] + $row['esi1'] + $row['emi'] + $lopamt;
                  $bonus = $row['amt'];
                  $payout = floor($gross - $totaldeduct + $bonus);
                  if (($payout - floor($payout)) > 0.5) {
                    $payout = ceil($payout);
                  }
                } else {
                  $gs = $row['bp'] + $row['hra'] + $row['oa'];
                  $lopamt = ($gs / $totalDaysInMonth) * $row['flop'];
                  $paydays = $totalDaysInMonth - $row['flop'];

                  // as per no of days
                  $basic = $row['bp'] * $paydays / $totalDaysInMonth;
                  $hra = $row['hra'] * $paydays / $totalDaysInMonth;
                  $oa = $row['oa'] * $paydays / $totalDaysInMonth;
                  $gross = $basic + $hra + $oa;

                  $totaldeduct = $row['epf1'] + $row['esi1'] + $row['emi'] + $lopamt;
                  $bonus = $row['amt'];
                  $payout = floor($gross - $totaldeduct + $bonus);
                  if (($payout - floor($payout)) > 0.5) {
                    $payout = ceil($payout);
                  }
                  $employeeID = 0;
                  $ciCoCount1 = 0;
                  $totalLeavesValue1 = 0;
                  $lopamt = 0;
                  $flop = 0;
                  $bonus= 0;
                }

            ?>

                <tr style="border-top: 1px solid rgb(224, 224, 224);" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224);position: sticky; left: 0; background-color: #fdfdfd;">
                    <?php echo $row['empname']; ?>
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
                    <input type="number" name="leaves" value="<?php echo $totalLeavesValue1; ?>" style="background-color: rgba(194, 238, 255, 0.01); width: 80px;">
                  </td>
                  <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
                    <input type="number" name="sundays" value="<?php echo $sundaysCount ?>" style="background-color: rgba(194, 238, 255, 0.01); width: 60px;">
                  </td>
                  <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
                    <input type="number" name="flop" id="flop" value="<?php echo isset($row['flop']) ? $row['flop'] : 0; ?>" style="background-color: rgba(194, 238, 255, 0.01); width: 60px;">
                  </td>
                  <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
                    <input type="number" name="paydays" id="paydays" value="" style="background-color: rgba(194, 238, 255, 0.01); width: 60px;">
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
                    <input type="number" name="esi1" value="<?php echo $row['esi1']; ?>" style="background-color: rgba(194, 238, 255, 0.01);">
                  </td>
                  <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);">
                    <input type="number" name="tds" value="0" style="background-color: rgba(194, 238, 255, 0.01);">
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

            ?>
          </tbody>
        </table>
        <button style="position:sticky; left:0; margin-top:10px;" type="button" onclick="submitFormData()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          Submit
        </button>
      </form>
    </div>
    <img class="attendence-child" alt="" src="../public/rectangle-1@2x.png" />

    <img width="90px" style="position: absolute; left:20px;" src="../public/logo-1@2x.png" />
    <a class="anikahrm14" href="./index.html" style="top:20px; left:120px;" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./index.html" style="margin-left:500px;" id="attendenceManagement">Payroll Management</a>


    
  </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function filterData() {
    var selectedMonthYear = document.getElementById("monthYearSelect").value;
    if (selectedMonthYear !== "") {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("ssTableBody").innerHTML = this.responseText;
        }
      };
      xhttp.open("GET", "fetch_ss.php?monthYear=" + selectedMonthYear, true);
      xhttp.send();
    }
  }

  document.addEventListener("DOMContentLoaded", function() {});
</script>

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

    // Function to calculate and update lopamt
    function updateLopamt() {
        $('tbody tr').each(function() {
            var monthdays = parseFloat($(this).find('input[name="monthdays"]').val()) || 0;
            var gs = parseFloat($(this).find('input[name="fgs"]').val()) || 0;
            var flop = parseFloat($(this).find('input[name="flop"]').val()) || 0;
            var lopamt = (gs / monthdays) * flop;
            $(this).find('input[name="lopamt"]').val(lopamt.toFixed(2));
        });
    }

    // Function to calculate and update bp and epf1
    function updateBpAndEpf1() {
        $('tbody tr').each(function() {
            var monthdays = parseFloat($(this).find('input[name="monthdays"]').val()) || 0;
            var flop = parseFloat($(this).find('input[name="flop"]').val()) || 0;
            var paydays = parseFloat($(this).find('input[name="paydays"]').val()) || 0;
            var bp = parseFloat($(this).find('input[name="fbp"]').val()) || 0;
            var newBp = (bp * paydays) / monthdays;
            $(this).find('input[name="bp"]').val(newBp.toFixed(2));
            var epf1 = Math.round(newBp * 0.12);
            $(this).find('input[name="epf1"]').val(epf1);
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

    // Function to calculate and update totaldeduct
    function updateTotalDeduct() {
        $('tbody tr').each(function() {
            var epf1 = parseFloat($(this).find('input[name="epf1"]').val()) || 0;
            var esi1 = parseFloat($(this).find('input[name="esi1"]').val()) || 0;
            var emi = parseFloat($(this).find('input[name="emi"]').val()) || 0;
            var gs = parseFloat($(this).find('input[name="fgs"]').val()) || 0;
            var monthdays = parseFloat($(this).find('input[name="monthdays"]').val()) || 0;
            var flop = parseFloat($(this).find('input[name="flop"]').val()) || 0;
            var misc = parseFloat($(this).find('input[name="misc"]').val()) || 0;
            var lopamt = (gs / monthdays) * flop;
            var totaldeduct = epf1 + esi1 + emi + lopamt + misc;
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

    // Listen for input events on relevant fields
    $(document).on('input', 'input[name="monthdays"], input[name="flop"], input[name="fgs"], input[name="fbp"], input[name="fhra"], input[name="foa"], input[name="esi1"], input[name="emi"],input[name="bonus"],input[name="damt"]', function() {
        updatePaydays();
        updateLopamt();
        updateBpAndEpf1();
        updateHra();
        updateOa();
        updateTotalDeduct();
        updateGrossDeductAndPayout();
    });

    // Trigger initial calculations
    updatePaydays();
    updateLopamt();
    updateBpAndEpf1();
    updateHra();
    updateOa();
    updateTotalDeduct();
    updateGrossDeductAndPayout();
});

</script>


<script>
  function submitFormData() {
    var formData = new FormData();
    $("#ssTableBody tbody tr").each(function(index, element) {
      var empName = $(element).find('td:eq(0)').text().trim() || '';
      var salarymonth = $(element).find('td:eq(1)').text().trim() || '';
      var fbp = $(element).find('input[name="fbp"]').val().trim() || '';

      var fhra = $(element).find('input[name="fhra"]').val().trim() || '';

      var foa = $(element).find('input[name="foa"]').val().trim() || '';

      var fgs = $(element).find('input[name="fgs"]').val().trim() || '';

      var monthdays = $(element).find('input[name="monthdays"]').val().trim() || '';

      var present = $(element).find('input[name="present"]').val().trim() || '';

      var leaves = $(element).find('input[name="leaves"]').val().trim() || '';

      var sundays = $(element).find('input[name="sundays"]').val().trim() || '';

      var flop = $(element).find('input[name="flop"]').val().trim() || '';

      var paydays = $(element).find('input[name="paydays"]').val().trim() || '';

      var bp = $(element).find('input[name="bp"]').val().trim() || '';

      var hra = $(element).find('input[name="hra"]').val().trim() || '';

      var oa = $(element).find('input[name="oa"]').val().trim() || '';

      var gross = $(element).find('input[name="gross"]').val().trim() || '';

      var epf1 = $(element).find('input[name="epf1"]').val().trim() || '';

      var esi1 = $(element).find('input[name="esi1"]').val().trim() || '';
      var tds = $(element).find('input[name="tds"]').val().trim() || '';
      var emi = $(element).find('input[name="emi"]').val().trim() || '';

      var lopamt = $(element).find('input[name="lopamt"]').val().trim() || '';
      var misc = $(element).find('input[name="misc"]').val().trim() || '';
      var totaldeduct = $(element).find('input[name="totaldeduct"]').val().trim() || '';
      var bonus = $(element).find('input[name="bonus"]').val().trim() || '';
      var payout = $(element).find('input[name="payout"]').val().trim() || '';


      formData.append('empname[]', empName);
      formData.append('salarymonth[]', salarymonth);
      formData.append('fbp[]', fbp);
      formData.append('fhra[]', fhra);
      formData.append('foa[]', foa);
      formData.append('fgs[]', fgs);
      formData.append('monthdays[]', monthdays);
      formData.append('present[]', present);
      formData.append('leaves[]', leaves);
      formData.append('sundays[]', sundays);
      formData.append('flop[]', flop);
      formData.append('paydays[]', paydays);
      formData.append('bp[]', bp);
      formData.append('hra[]', hra);
      formData.append('oa[]', oa);
      formData.append('gross[]', gross);
      formData.append('epf1[]', epf1);
      formData.append('esi1[]', esi1);
      formData.append('tds[]', tds);
      formData.append('emi[]', emi);
      formData.append('lopamt[]', lopamt);
      formData.append('misc[]', misc);
      formData.append('totaldeduct[]', totaldeduct);
      formData.append('bonus[]', bonus);
      formData.append('payout[]', payout);
    });

    Swal.fire({
      title: 'Are you sure?',
      text: 'Do you want to submit the data?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, submit',
      cancelButtonText: 'No, cancel',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'POST',
          url: 'insert_ss.php',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            console.log('Success:', response);
            Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: 'Data submitted successfully',
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.isConfirmed) {
                location.reload();
              }
            });
          },
          error: function(xhr, status, error) {
            console.log('Error:', xhr.responseText);
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'An error occurred while processing your request.',
              confirmButtonText: 'OK'
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelled',
          text: 'The submission was cancelled',
          icon: 'info',
          confirmButtonText: 'OK'
        });
      }
    });
  }
</script>

</html>