<?php
@include 'inc/config.php';
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
  ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./global.css" />
    <link rel="stylesheet" href="./salary.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap"
    />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <style>
        input{
           font-size:20px; 
        }
        
              .myButton {
	box-shadow:inset 0px 1px 0px 0px #fff6af;
	background:linear-gradient(to bottom, #ffec64 5%, #FB8A0C 100%);
	background-color:#FB8A0C;
	border-radius:6px;
	border:1px solid #ffaa22;
	display:inline-block;
	cursor:pointer;
	color:#333333;
	font-family:Arial;
	font-size:15px;
	font-weight:bold;
	padding:6px 24px;
	text-decoration:none;
	text-shadow:0px 1px 0px #ffee66;
}
.myButton:hover {
	background:linear-gradient(to bottom, #FB8A0C 5%, #ffec64 100%);
	background-color:#FB8A0C;
}
.myButton:active {
	position:relative;
	top:1px;
}
input {
    border: none;
    text-align:center;
}

.deduction-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    width: 100%;
    max-width: 500px; /* Adjust this value as needed */
}

.deduction-item .label {
    flex: 1;
    text-align: left;
    font-size: 16px;
    font-weight: normal;
}

.deduction-item .separator {
    flex: 0 0 20px;
    text-align: center;
}

.deduction-item .input-wrapper {
    flex: 1;
    text-align: right;
}

.deduction-item input {
    border: none;
    background-color: rgba(194, 238, 255, 0.01);
    text-align: right;
    width: 100%;
    max-width: 120px; 
}
.deductions-note {
    background-color: #f8f8f8;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    padding: 15px;
    margin-top: 20px;
    font-size: 14px;
    line-height: 1.5;
    width:58%;
}

.deductions-note strong {
    color: #d32f2f;
}
    </style>
  </head>
  <body>
    <div class="salary1">
      <div class="bg1"></div>
      <img class="salary-child" alt="" src="./public1/rectangle-1@2x.png" />

      <img class="salary-item" alt="" src="./public1/rectangle-2@2x.png" />

      <a class="anikahrm1">
        <span>Anika</span>
        <span class="hrm1">HRM</span>
      </a>
      <a class="employee-management1" id="employeeManagement"
        >Employee Management</a
      >
      <a style="display: block; left: 90%; margin-top: 5px; font-size: 27px;" href="./employee-dashboard.php" class="employee-management1" id="employeeManagement"></a>
      <button class="salary-inner"></button>
      <a href="logout.php" > <div class="logout1">Logout</div></a>
      <a class="leaves1" href="apply-leave-emp.php">Leaves</a>
      <a class="attendance1" href="attendenceemp2.php">Attendance</a>
    <a href="card.php" style="text-decoration: none; color: #222222;" class="payroll1">Directory</a>
      <a class="fluentperson-clock-20-regular1">
        <img class="vector-icon4" alt="" src="./public1/vector.svg" />
      </a>
      <img class="uitcalender-icon1" alt="" src="./public1/uitcalender.svg" />

      <img
        class="arcticonsgoogle-pay1"
        alt=""
        src="./public1/arcticonsgooglepay.svg"
      />
      <?php
$user_name = $_SESSION['user_name'];

$sql1 = "SELECT emp.empname
        FROM emp
        INNER JOIN user_form ON emp.empemail = user_form.email
        WHERE user_form.email = '$user_name'";

$result1 = mysqli_query($con, $sql1);

if ($result1) {
    if (mysqli_num_rows($result1) > 0) {
        $row1 = mysqli_fetch_assoc($result1);
        $empname = $row1['empname'];
    } else {
        $empname = "Unknown"; 
    }
} else {
    $empname = "Unknown"; 
}

?>

      <img class="salary-child2" alt="" src="./public1/rectangle-4@2x.png" />

      <img class="tablerlogout-icon1" alt="" src="./public1/tablerlogout.svg" />

      <a class="uitcalender1">
        <img class="vector-icon5" alt="" src="./public1/vector1.svg" />
      </a>
      <a class="dashboard1" id="dashboard">Dashboard</a>
      <a class="akar-iconsdashboard1" id="akarIconsdashboard">
        <img class="vector-icon6" alt="" src="./public1/vector2.svg" />
      </a>
      <div class="rectangle-container">
        <div class="frame-child4"></div>
        <img class="frame-child5" alt="" src="./public1/line-39.svg" />

        <a href="./personal-details.php" class="frame-child6" id="rectangleLink"> </a>
        <a href="./personal-details.php" class="personal-details1" id="personalDetails">Personal Details</a>
        <a href="./job.php" class="frame-child7" id="rectangleLink1"> </a>
        <a href="./directory.php" class="frame-child8" id="rectangleLink2"> </a>
        <a class="frame-child9"> </a>
        <a href="./job.php" class="job1" id="job">Job</a>
        <a href="./directory.php" class="document1" id="document">Document</a>
        <a class="salary2">Salary</a>
       <a href="./employee-dashboard.php"> <img
          class="bxhome-icon1"
          alt=""
          src="./public1/bxhome.svg"
          id="bxhomeIcon"
        /></a>
      </div>
      <?php
      $sql = "SELECT smonth FROM payroll_schedule WHERE approval = 0 LIMIT 1";

      $result = $con->query($sql);

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $smonth = $row["smonth"];
      } else {
        $smonth = "No month found with status = 0";
      }
      ?>
      <div class="frame-div">
        <div class="frame-child10"></div>
           <h3 class="salary-details" style="width:100%;"><b><?php echo $smonth ?></b> - Month Salary Breakdown Based on Working Days</b>
        </h3>
        <img class="frame-child11" alt="" src="./public1/line-12@2x.png" />

        <div class="cost-to-the">
       
        <div style=" overflow-y:auto;  width:58%;">
        <form>
          <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400" id="ssTableBody">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr style="border-top: 1px solid rgb(224, 224, 224);position: sticky; top: 0px; ">
            <th colspan="4" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 238, 255, 0.5);" scope="col" class="px-2 py-3">
              FIXED SALARY COMPONENTS
            </th>
            <th colspan="7" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 231, 194, 0.5);" scope="col" class="px-2 py-3">
              Days Calculation
            </th>
            <th colspan="4" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 255, 204, 0.5);" scope="col" class="px-2 py-3">
              SALARY AS PER NO OF PAY DAYS
            </th>
            <th colspan="1" scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 161, 161, 0.5);" class="px-2 py-3">
            Total Deductions
            </th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160);background-color: rgba(194, 255, 204, 0.5);" class="px-2 py-3">
              Additional Compensation
              </th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160);position: sticky; right: 0; top:0; background-color: #fdfdfd;" class="px-2 py-3">
                NET Payable
              </th>
          </tr>
          <tr style="border-top: 1px solid rgb(224, 224, 224);position: sticky; top: 60px; ">
            <th scope="col" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 238, 255, 0.2);" class="px-2 py-3">Basic Salary</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);" class="px-2 py-3">HRA</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);" class="px-2 py-3">OA</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);" class="px-2 py-3">Gross Salary</th>
            <th scope="col" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 231, 194, 0.2);" class="px-2 py-3">Total Days</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-2 py-3">Present Days</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-2 py-3">Leaves</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-2 py-3">Week Off Days</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-2 py-3">holidays</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-2 py-3">LOP</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-2 py-3">Pay Days</th>
            
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 255, 204, 0.2);" class="px-2 py-3">Basic Salary</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);" class="px-2 py-3">HRA</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);" class="px-2 py-3">OA</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);" class="px-2 py-3">Gross Salary</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-2 py-3"> Deductions</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160);  background-color: rgba(194, 255, 204, 0.2);" class="px-2 py-3">Bonus</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); position: sticky; right: 0; top: 50px; background-color: #fdfdfd;" class="px-2 py-3">Salary Payout</th>
          </tr>
            </thead>
            <tbody>
            <?php
$sql = "SELECT smonth FROM payroll_schedule WHERE approval = 0 LIMIT 1";
$result = $con->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    // Get the smonth value directly from the database
    $smonth = $row['smonth'];
    
    // Get the first day of the month
    $firstDayOfMonth = date("Y-m-01", strtotime($smonth));
    // Get the last day of the month
    $lastDayOfMonth = date('Y-m-t', strtotime($smonth)) . ' 23:59:59';
    // Get the total number of days in the month
    $totalDaysInMonth = date("t", strtotime($smonth));
} else {
    // If no smonth is found, set default values
    $smonth = "No month found";
    $firstDayOfMonth = '';
    $lastDayOfMonth = '';
    $totalDaysInMonth = 0;
}
              ?>

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
ms.netpay,
emi.empname AS emi_empname,
emi.emi,
lop.empname AS lop_empname,
lop.flop,
bonus.empname AS bonus_empname,
bonus.amt,
misc.empname AS misc_empname,
misc.damt,
COALESCE(emp.work_location, '') AS work_location
FROM payroll_msalarystruc ms
LEFT JOIN payroll_emi emi ON ms.empname = emi.empname AND emi.emimonth = '$smonth'
LEFT JOIN payroll_lop lop ON ms.empname = lop.empname AND lop.lopmonth = '$smonth'
LEFT JOIN payroll_bonusamt bonus ON ms.empname = bonus.empname AND bonus.paymonth = '$smonth'
LEFT JOIN payroll_misc misc ON ms.empname = misc.empname AND misc.paymonth = '$smonth'
LEFT JOIN emp ON ms.empname = emp.empname
LEFT JOIN payroll_schedule ON payroll_schedule.smonth = '$smonth'
LEFT JOIN payroll_sp sp ON ms.empname = sp.empname
WHERE payroll_schedule.approval = 0
AND COALESCE(emp.work_location, '') = 'Visakhapatnam'
AND sp.empname IS NULL
AND emp.empstatus = 0
AND ms.empname = '$empname'
ORDER BY ms.emp_no ASC

";



 $cnt = 1;
               $result = mysqli_query($con, $sql);
 
               if (mysqli_num_rows($result) > 0) {
                
                 while ($row = mysqli_fetch_assoc($result)) {
                   $fetchingEmployees = mysqli_query($con, "SELECT UserID,empstatus FROM emp WHERE empname = '" . $row['empname'] . "' AND empstatus = 0") or die(mysqli_error($con));
                   $employeeData = mysqli_fetch_assoc($fetchingEmployees);
                   $employeeID = 0;


                   $sundaysCount = 0;
                   $holidaysCount = 0;
                   $empQuery = "SELECT empdoj FROM emp WHERE empname = '$empname'";
                   $empResult = $con->query($empQuery);
           
                   if ($empResult->num_rows > 0) {
                       while ($empRow = $empResult->fetch_assoc()) {
                           $empdoj = $empRow['empdoj'];
                           
                           $dojYear = date('Y', strtotime($empdoj));
                           $dojMonth = date('m', strtotime($empdoj));
                           $dojDay = date('d', strtotime($empdoj));
                           
                           $currentYear = date('Y', strtotime($smonth));
                           $currentMonth = date('m', strtotime($smonth));
                           
                           if ($dojYear == $currentYear && $dojMonth == $currentMonth) {
                            $startDay = $dojDay;
                        } else {
                            $startDay = 1;
                        }
    
                        $totalDaysInMonth = date('t', strtotime($smonth));

                          for ($j = $startDay; $j <= $totalDaysInMonth; $j++) {
                        $dateOfAttendance = date("$currentYear-$currentMonth-$j");
                        $dayOfWeek = date('N', strtotime($dateOfAttendance));
                        if ($dayOfWeek == 7) {
                            $sundaysCount++;
                        }
                    }


                    $fetchingHolidays = mysqli_query($con, "
                    SELECT date
                    FROM holiday
                    WHERE date >= '$firstDayOfMonth'
                    AND date <= '$lastDayOfMonth'
                ") or die(mysqli_error($con));
        
                while ($holiday = mysqli_fetch_assoc($fetchingHolidays)) {
                    $holidayDate = $holiday['date'];
                    $holidayDay = date('d', strtotime($holidayDate));
        
                    if ($holidayDay >= $startDay) {
                        $holidaysCount++;
                    }
                }
                       }
                   }
                   
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
                     $ciCoColumn1 = mysqli_query($con, "
                     SELECT COUNT(*) AS count
                     FROM CamsBiometricAttendance
                     WHERE UserID = '$employeeID'
                     AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                     AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                     AND AttendanceType = 'CheckIn'
                 ") or die(mysqli_error($con));

                 
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
                 $ciCoCount11 = mysqli_fetch_assoc($ciCoColumn1)['count'];
                     $ciCoCount = mysqli_fetch_assoc($ciCoColumn)['count'];
                     $ciCoCount = $ciCoCount - $leaveCount1;
                     $ciCoCount1 = $ciCoCount;
                     $weekoff = $sundaysCount +  $holidaysCount;
                     $totalleavesCount1 =($leaveCount + $leaveCount1); 
                   $tds = $row['tds'];
                   $desg = $row['desg'];
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

                                       $netpay = $row['netpay'];
                                       $ciCoCount1 = $ciCoCount1 ?? 0; 
                     
                                       if ($ciCoCount1 == 0) {
                                         $perday = 0;
                                     } else {
                                         $perday = number_format((($netpay / $totalDaysInMonth) * ($ciCoCount1 + $weekoff + ($totalleavesCount1 - $flop))), 2, '.', '');
                                     }


                                     if ($desg != 'SECURITY GAURDS') {
                                      $displayValue = $ciCoCount1;
                                  } else {
                                      $displayValue = $ciCoCount11;
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

                                       $netpay = $row['netpay'];
                                       $ciCoCount1 = $ciCoCount1 ?? 0; 
                     
                                       if ($ciCoCount1 == 0) {
                                         $perday = 0;
                                     } else {
                                         $perday = number_format((($netpay / $totalDaysInMonth) * ($ciCoCount1 + $weekoff + ($totalleavesCount1 - $flop))), 2, '.', '');
                                     }
                                       $employeeID = 0;
                                       $ciCoCount1 = 0;
                                       $totalleavesCount1 = 0;
                                       $lopamt = 0;
                                       $flop = 0;
                                       $bonus = 0;
                                         $weekoff = 0;
                                        $displayValue = 0;
                                     }

              ?>

                  <tr style="border-top: 1px solid rgb(224, 224, 224);" class="clickable-row bg-white border-b dark:bg-gray-800 dark:border-gray-700 ">
                
                    <td class="px-2 py-4" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 238, 255, 0.2);">
                      <input type="number" name="fbp" value="<?php echo $row['bp']; ?>" style="width:100px;background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-2 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);">
                      <input type="number" name="fhra" value="<?php echo $row['hra']; ?>" style="width:100px;background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-2 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);">
                      <input type="number" name="foa" value="<?php echo $row['oa']; ?>" style="width:100px;background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-2 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);">
                      <input type="number" name="fgs" value="<?php echo $row['ctc']; ?>" style="width:100px;background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-2 py-4" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 231, 194, 0.2);">
                      <input type="number" name="monthdays" id="monthdays" value="<?php echo $totalDaysInMonth ?>" class="highlight" style="background-color: rgba(194, 238, 255, 0.01); width: 60px;">
                    </td>
                    <td class="px-2 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
                      <input type="number" name="present"  value="<?php echo $displayValue; ?>" style="background-color: rgba(194, 238, 255, 0.01); width: 80px;" class="highlight">
                    </td>
                    <td class="px-2 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
                      <input type="number" name="leaves" value="<?php echo $totalleavesCount1; ?>" style="background-color: rgba(194, 238, 255, 0.01); width: 80px;" class="highlight">
                    </td>
                    <td class="px-2 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
                      <input type="number" name="sundays" value="<?php echo $sundaysCount ?>" style="background-color: rgba(194, 238, 255, 0.01); width: 60px;" class="highlight">
                    </td>
                    <td class="px-2 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
                      <input type="number" name="holidays" value="<?php echo $holidaysCount ?>" style="background-color: rgba(194, 238, 255, 0.01); width: 60px;" class="highlight">
                    </td>
                    <td class="px-2 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
                      <input type="number" name="flop" id="flop" value="<?php echo isset($row['flop']) ? $row['flop'] : 0; ?>" class="highlight" style="background-color: rgba(194, 238, 255, 0.01); width: 60px;">
                    </td>

                    <td class="px-2 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
                      <input type="number" name="paydays" id="paydays" value="" style="background-color: rgba(194, 238, 255, 0.01); width: 90px;" class="highlight">
                    </td>
                  
                    <td class="px-2 py-4" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 255, 204, 0.2);">
                      <input type="number" name="bp" id="bp" value="" style="width:100px;background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-2 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);">
                      <input type="number" name="hra" id="hra" value="" style="width:100px;background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-2 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);">
                      <input type="number" name="oa" value="" style="width:100px;background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-2 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);">
                      <input type="number" name="gross" value="<?php echo $gross ?>" style="width:120px;background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-2 py-4" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 194, 194, 0.2);">
                      <!-- <input type="number" name="epf1" value="<?php echo $row['epf1']; ?>" style="background-color: rgba(194, 238, 255, 0.01);" class="highlight"> -->
                      <button data-modal-target="default-modal" data-modal-toggle="default-modal"  class=" hidden-btn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                        Deductions
                                    </button>
                    </td>
                    <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-2xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-xxl font-semibold text-gray-900 dark:text-white">
                                Deductions Summary <br>
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4" >
                        <div class="deductions-container">
    <div class="deduction-item">
        <span class="label">EPF</span>
        <span class="separator">-</span>
        <div class="input-wrapper">
            <input type="number" name="epf1" value="<?php echo $row['epf1']; ?>" class="highlight">
        </div>
    </div>
    <div class="deduction-item">
        <span class="label">ESIC</span>
        <span class="separator">-</span>
        <div class="input-wrapper">
            <input type="number" name="esi1" value="<?php echo $row['esi1']; ?>" class="highlight">
        </div>
    </div>
    <div class="deduction-item">
        <span class="label">TDS</span>
        <span class="separator">-</span>
        <div class="input-wrapper">
            <input type="number" name="tds" value="<?php echo $tds; ?>" class="highlight">
        </div>
    </div>
    <div class="deduction-item">
        <span class="label">LOAN EMI</span>
        <span class="separator">-</span>
        <div class="input-wrapper">
            <input type="number" name="emi" value="<?php echo isset($row['emi']) ? $row['emi'] : 0; ?>"  class="highlight">
        </div>
    </div>
    <div class="deduction-item">
        <span class="label">LOP AMOUNT</span>
        <span class="separator">-</span>
        <div class="input-wrapper">
            <input type="number" name="lopamt" value="<?php echo $lopamt; ?>" class="highlight">
        </div>
    </div>
    <div class="deduction-item">
        <span class="label">MISC. DEDUCTIONS</span>
        <span class="separator">-</span>
        <div class="input-wrapper">
            <input type="number" name="misc" value="<?php echo isset($row['damt']) ? $row['damt'] : 0; ?>" class="highlight">
        </div>
    </div>
    
    <div class="total-deduction"></div>
    <hr>
    <div class="deduction-item">
        <span class="label"><b>Total Deductions</b></span>
        <span class="separator">-</span>
        <div class="input-wrapper">
            <b><input type="number" name="totaldeduct" value="" class="highlight"></b>
        </div>
    </div>
</div>
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                        </div>
                    </div>
                </div>
            </div>

                    <td class="px-2 py-4" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160);   background-color: rgba(194, 255, 204, 0.2);">
                      <input type="number" name="bonus" value="<?php echo isset($row['amt']) ? $row['amt'] : 0; ?>" class="highlight" style="width:100px;background-color: rgba(194, 238, 255, 0.01);">
                    </td>
                    <td class="px-2 py-4" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); position: sticky; right: 0; background-color: #fdfdfd;">
                      <input type="number" name="payout" value="<?php echo $payout; ?>" style="width:100px;background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                  </tr>
                <?php
                }
              } else {
                ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <td colspan="8" class="px-2 py-4 text-center">No Data</td>
                </tr>
              <?php
              }

              ?>
            </tbody>
          </table>
       
        </form>
      </div>
      <div class="deductions-note">
    <p><strong>Note:</strong> All salary figures shown are in Rs/- (Indian Rupees). The actual salary payout may vary due to changes made during the payrun process by the HR department. These figures should not be considered final, as there may be variations at the time of payrun. If you have any doubts or queries, please reach out to the HR department for clarification.</p>
</div>
       </div>
      </div>

      <img class="logo-1-icon1" alt="" src="./public1/logo-1@2x.png" />
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('input.highlight').prop('disabled', true);
  function filterData() {
    var selectedMonthYear = document.getElementById("monthYearSelect").value;
    if (selectedMonthYear !== "") {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("ssTableBody").innerHTML = this.responseText;
          
          // Call functions to update data after loading
          updateData();
        }
      };
      xhttp.open("GET", "/Payroll/fetch_ss.php?monthYear=" + selectedMonthYear, true);
      xhttp.send();
    }
  }

  document.addEventListener("DOMContentLoaded", function() {
    // Call filterData when the document is loaded
    filterData();
  });

  function updateData() {
    // Call functions to update data
    updatePaydays();
    updateSalariesAndAllowances();
    
  }
</script>
<script>
$(document).ready(function() {
    // Function to calculate and update paydays
    function updatePaydays() {
    $('tbody tr').each(function() {
        var present = parseFloat($(this).find('input[name="present"]').val()) || 0;
        var sundays = parseFloat($(this).find('input[name="sundays"]').val()) || 0;
        var leaves = parseFloat($(this).find('input[name="leaves"]').val()) || 0;
        var holidays = parseFloat($(this).find('input[name="holidays"]').val()) || 0;
        var flop = parseFloat($(this).find('input[name="flop"]').val()) || 0;
        var paydays = (present + sundays + leaves + holidays) - flop;
        $(this).find('input[name="paydays"]').val(paydays);
    });
}

function updateSalariesAndAllowances() {
    var modal = $('#default-modal');
    var tds = parseFloat(modal.find('input[name="tds"]').val()) || 0;
    var epf1FromDB = parseFloat(modal.find('input[name="epf1"]').val()) || 0;
    var esi1FromDB = parseFloat(modal.find('input[name="esi1"]').val()) || 0;
    var emi = parseFloat(modal.find('input[name="emi"]').val()) || 0;
    var misc = parseFloat(modal.find('input[name="misc"]').val()) || 0;
    var lopamt = parseFloat(modal.find('input[name="lopamt"]').val()) || 0;

    $('tbody tr').each(function() {
        var monthdays = parseFloat($(this).find('input[name="monthdays"]').val()) || 0;
        var paydays = parseFloat($(this).find('input[name="paydays"]').val()) || 0;

        // Calculate and update basic salary
        var fixed = parseFloat($(this).find('input[name="fbp"]').val()) || 0;
        var gross = parseFloat($(this).find('input[name="gross"]').val()) || 0;
        var basicBP = (fixed * paydays) / monthdays;
        $(this).find('input[name="bp"]').val(basicBP.toFixed(2));

        // Calculate and update HRA
        var hra = parseFloat($(this).find('input[name="fhra"]').val()) || 0;
        var newHra = (hra * paydays) / monthdays;
        $(this).find('input[name="hra"]').val(newHra.toFixed(2));

        // Calculate and update OA
        var oa = parseFloat($(this).find('input[name="foa"]').val()) || 0;
        var newOa = (oa * paydays) / monthdays;
        $(this).find('input[name="oa"]').val(newOa.toFixed(2));

        // Calculate and update newGross
        var newGross = basicBP + newHra + newOa;
        $(this).find('input[name="gross"]').val(newGross.toFixed(2));

        // Calculate and update EPF1 and ESI1
        var epf1 = 0;
        var esi1 = 0;

        if (epf1FromDB !== 0 || esi1FromDB !== 0) {
            if (tds === 0) {
                epf1 = Math.round(basicBP * 0.12);
                if (basicBP > 15000) {
                    epf1 = 1800;
                }
                esi1 = (gross < 21000) ? Math.round(newGross * 0.0075) : 0;
            } else {
                epf1 = epf1FromDB;
                esi1 = esi1FromDB;
            }
        }

        modal.find('input[name="epf1"]').val(epf1);
        modal.find('input[name="esi1"]').val(esi1);

        // Calculate and update total deductions
        var gs = parseFloat($(this).find('input[name="fgs"]').val()) || 0;
        var flop = parseFloat($(this).find('input[name="flop"]').val()) || 0;
        var bonus = parseFloat($(this).find('input[name="bonus"]').val()) || 0;

        if (lopamt === 0) {
            lopamt = (gs / monthdays) * flop;
        }
        modal.find('input[name="lopamt"]').val(lopamt.toFixed(2));

        var totaldeduct = epf1 + tds + esi1 + emi + lopamt + misc;
        modal.find('input[name="totaldeduct"]').val(totaldeduct.toFixed(2));
        var payout = (newGross - totaldeduct + bonus);
        payout = Math.floor(payout) + (payout % 1 > 0.5 ? 1 : 0);
        $(this).find('input[name="totaldeduct"]').val(totaldeduct.toFixed(2));
        $(this).find('input[name="payout"]').val(payout.toFixed(2));
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
    $(document).on('input', 'input[name="monthdays"], input[name="lopamt"], input[name="misc"], input[name="flop"], input[name="tds"], input[name="fgs"], input[name="fbp"], input[name="fhra"], input[name="foa"], input[name="emi"], input[name="bonus"], input[name="damt"]', function() {
      updatePaydays();
      updateSalariesAndAllowances();
});

// Trigger initial calculations
updatePaydays();
updateSalariesAndAllowances();
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
              window.location.href = 'loginpage.php';
            });
          });
        </script>";
  exit();
}
?>