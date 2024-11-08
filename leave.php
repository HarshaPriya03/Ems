<?php
session_start();
@include 'inc/config.php';

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  header('location:loginpage.php');
  exit();
}

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
if ($user_name === '') {
  header('location:loginpage.php');
  exit();
}

$query = "SELECT * FROM user_form WHERE email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if ($row && isset($row['user_type']) && isset($row['user_type1'])) {
    $user_type = $row['user_type'];
    $user_type1 = $row['user_type1'];
    $work_location = $row['work_location'];

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

if ($work_location == 'All') {
  $sql = "SELECT DISTINCT E.empname, lb.*
FROM CamsBiometricAttendance AS CBA
INNER JOIN emp AS E ON CBA.UserID = E.UserID
INNER JOIN leavebalance AS lb ON E.empname = lb.empname
WHERE E.empstatus = 0
ORDER BY lb.lastupdate DESC";
} else {
  $sql = "SELECT DISTINCT E.empname, E.work_location, lb.*
        FROM CamsBiometricAttendance AS CBA
        INNER JOIN emp AS E ON CBA.UserID = E.UserID
        INNER JOIN leavebalance AS lb ON E.empname = lb.empname
        WHERE E.empstatus = 0
        AND  E.work_location = '$work_location'
        ORDER BY lb.lastupdate DESC";
}

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

  <link rel="stylesheet" href="./css/map.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'></script>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  <style>
    table {
      z-index: 100;
      border-collapse: collapse;
      background-color: white;
      text-align: center;
    }

    th,
    td {
      padding: 1em;
      background: white;
      color: rgb(52, 52, 52);
      border-bottom: 2px solid rgb(193, 193, 193);
    }

    input,
    select {
      font-size: 20px;
    }

    .container {
      padding-bottom: 20px;
      margin-right: -60px;
    }

    .input-text:focus {
      box-shadow: 0px 0px 0px;
      border-color: #fd7e14;
      outline: 0px;
    }

    .form-control {
      border: 1px solid #fd7e14;
    }

    .udbtn:hover {
      color: black !important;
      background-color: white !important;
      outline: 1px solid #F46114;
    }

    .dialog {
      padding: 20px;
      border: 0;
      background: transparent;
    }

    .dialog::backdrop {
      background-color: rgba(0, 0, 0, .3);
      backdrop-filter: blur(4px);
    }

    .dialog__wrapper {
      padding: 20px;
      background: #fff;
      width: 740px;
      border-radius: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, .3);
    }

    .dialog__close {
      border: 0;
      padding: 0;
      width: 24px;
      aspect-ratio: 1;
      display: grid;
      place-items: center;
      background: #000;
      color: #fff;
      border-radius: 50%;
      font-size: 12px;
      line-height: 20px;
      position: absolute;
      top: 5px;
      right: 5px;
      cursor: pointer;
      --webkit-appearance: none;
      appearance: none;
    }

    tr td:nth-child(3),
    tr td:nth-child(4) {
      background: #A1EEBD;
    }

    tr td:nth-child(12) {
      background: #FFDD95;
    }

    tr td:nth-child(15) {
      background: #A1EEBD;
    }
    .cards{
        position:absolute;
        top:83px;
        left:370px;
        width:100vw;
        border-bottom:1px solid rgb(193, 193, 193);
        display:flex;
        flex-direction:row;
        background-color:#fff;
    }
    .card-1{
        border-right:1px solid rgb(193, 193, 193);
        padding:10px;
        width:40vw;
        padding-left:300px;
        cursor:pointer;
        
    }
    .card-2{
        width:60vw;
        padding:10px;
        margin:auto;
        padding-left:230px;
        cursor:pointer
    }
    .active
    {
        background-color:#45C380;
        color:white;
      
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
  <div class="biometricmap">
    <div class="bg"></div>
    <img class="biometricmap-child" alt="" src="./public/rectangle-1@2x.png" />

    <img class="biometricmap-item" alt="" src="./public/rectangle-2@2x.png" />

    <img class="logo-1-icon" alt="" src="./public/logo-1@2x.png" />

    <a class="anikahrm">
      <span>Anika</span>
      <span class="hrm">HRM</span>
    </a>
    <h5 class="hr-management">Leave Management/Leave Balance</h5>
    <button class="biometricmap-inner" autofocus="{true}"></button>
    <div class="logout">Logout</div>
    <a class="employee-list" href="./employee-management.php">Employee List</a>
    <a class="leaves" style="color: white; z-index: 99999;" href="./leave-management.php">Leaves</a>
    <a class="onboarding" href="./onboarding.php">Onboarding</a>
    <a class="attendance" href="./attendence.php">Attendance</a>
    <a href="./Payroll/payroll.php" style="text-decoration:none; color:black; z-index:99;" class="payroll">Payroll</a>
    <div class="reports">Reports</div>
    <a class="fluentpeople-32-regular" style="margin-top:130px;">
      <img class="vector-icon" alt="" src="./public/vector.svg" />
    </a>
    <a class="fluent-mdl2leave-user" style="margin-top:-65px; z-index: 99999; -webkit-filter: grayscale(1) invert(1);
	  filter: grayscale(1) invert(1);">
      <img class="vector-icon1" alt="" src="./public/vector1.svg" />
    </a>
    <a class="fluentperson-clock-20-regular" style="margin-top:-65px;">
      <img class="vector-icon2" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector2.svg" />
    </a>
    <a class="uitcalender" style="margin-top:-260px; z-index:9999;">
      <img class="vector-icon3" alt="" src="./public/vector3.svg" />
    </a>
    <img class="arcticonsgoogle-pay" alt="" src="./public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />


    <a href="leave-management.php"><img class="rectangle-icon" alt="" src="./public/rectangle-4@2x.png" style="margin-top: 132px;" /></a>

    <a href="./index.php" style="color: black;" class="dashboard">Dashboard</a>
    <a class="akar-iconsdashboard" style="margin-top:263px;">
      <img class="vector-icon4" alt="" src="./public/vector4.svg" />
    </a>
    <img class="tablerlogout-icon" alt="" src="./public/tablerlogout.svg" />
    <div class="cards">
        <div class="card-1 active">
              Leave Balance
        </div>
        <div class="card-2" onclick="previous()">
              Previous Year Leave Balance
        </div>
    </div>

    
    <div class="container" style="margin-top:170px;margin-left:370px;background-color:#fff;">
      <div class="row">
        <div class="col-md-8">
          <div class="input-group mb-3" style="width:145%;">
            <input type="text" class="form-control input-text" id="filterInput" onkeyup="filterTable()" placeholder="Search for employee name...">
            <div class="input-group-append" style="background:white;">
              <span style="border-radius:0px;pointer-events: none; border-color: #fd7e14;padding:10px;" class="btn btn-outline-warning btn-lg" type="button"><i class="fa fa-search"></i></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div style="position: absolute; margin-top: -120px; width:1830px; overflow-y:auto;overflow-x:auto; height:850px;scale:0.8;margin-left:200px;">
      <table class="table-bordered" id="attendanceTable" style="margin-left:auto; margin-right:auto;font-size:15px !important;">
        <thead style="position:sticky;top:0;">
          <tr>
            <th></th>
            <th></th>
            <th colspan=2>Leave Balance Allocated</th>
            <?php $colspan = count($months[$year]); ?>
            <th class="text-center" colspan="<?php echo $colspan; ?>">Monthly Leave Balance Costed</th>
            <th></th>
            <th colspan=3>
              Current Leave Balance
            </th>
            <th class="text-center" colspan=2>
              <div class="border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                  <li class="me-2">
                    <a href="./Reports/leavebalance_report.php" class="inline-flex items-center justify-center p-4 text-blue-600  border-b-2 border-blue-600 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">

                      <svg class="w-6 h-6 me-2 text-blue-600 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m8-2h3m-3 3h3m-4 3v6m4-3H8M19 4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 12v6h8v-6H8Z" />
                      </svg>
                      Leave Balance Report
                    </a>
                  </li>
                  <li class="me-2">
                    <a href="./Reports/leavedetails_report.php" class="inline-flex items-center justify-center p-4 text-blue-600  border-b-2 border-blue-600 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                      <svg class="w-6 h-6 me-2 text-blue-600 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m8-2h3m-3 3h3m-4 3v6m4-3H8M19 4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 12v6h8v-6H8Z" />
                      </svg>
                      Leaves Report
                    </a>
                  </li>
              </div>
            </th>
          </tr>
          <tr class="static-cell">
            <th></th>
            <th>Employee Name</th>
            <th style="background: #A1EEBD;">CL + SL</th>
            <th style="background: #A1EEBD;">CO</th>
            <?php foreach ($months as $year => $year_months) : ?>
              <?php foreach ($year_months as $month_num => $month_name) : ?>
                <th><?php echo $month_name . ' ' . $year; ?></th>
              <?php endforeach; ?>
            <?php endforeach; ?>
            <th style="background: #FFDD95;">Total Leave <br>Balance Costed</th>
            <th>CL+SL</th>
            <th>
              CO
            </th>
            <th style="background: #A1EEBD;">
              Total
            </th>
            <th>
              Last Updation
            </th>
            <th>
              Action
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($employees as $employee) : ?>
            <?php
            // Initialize total leave count for the employee
            $totalLeaveCount = 0;
            ?>
            <tr>
              <td>
                <?php echo $cnt++; ?>
              </td>
              <td><?php echo $employee; ?>

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
                              AND leavetype != 'WORK FROM HOME'
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
              <td>
                <a class="btn udbtn" style="background-color: #FB8A0B; color: white;" href="#modal-option-1" onclick="populateDialog('<?php echo $result['ico'] . ',' . $result['icl'] . ',' . $result['isl'] . ',' . $result['empname'] . ',' . $result['empemail']; ?>')">Update</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <dialog class="dialog" id="modal-option-1" style="overflow:hidden;">
      <div class="dialog__wrapper">
        <button class="dialog__close">✕</button>
        <div class="send-email-parent">
          <form id="frm">
            <h5 class="modal-title" id="exampleModalLabel" style="font-size:25px;">Update Leave Balance</h5>
            <div style="display:flex; gap:30px; padding:20px; justify-content:center;">
              <div style="font-size:20px; font-weight: lighter; background-color:#FB8A0B; color:white; width:200px;max-width:100%; height:40px; display:flex; justify-content:center; align-items:center; border-radius:10px;">
                Allocated CL: <span id="currentCL"></span></div>
              <div style="font-size:20px; font-weight: lighter; background-color:#FB8A0B; color:white;width:200px;max-width:100%; height:40px; display:flex; justify-content:center; align-items:center; border-radius:10px;">
                Allocated SL: <span id="currentSL"></span></div>
              <div style="font-size:20px; font-weight: lighter; background-color:#FB8A0B; color:white; width:200px;max-width:100%; height:40px; display:flex; justify-content:center; align-items:center; border-radius:10px;">
                Allocated Comp.Off: <span id="currentCompOff"></span></div>
            </div>
            <div class="container">
              <label class="form-label" style="font-size:20px; font-weight: lighter;">Enter the adjustment CL value: </label>
              <input type="text" class="form-control" style="margin-bottom:10px; width:550px;" name='ucl'>

              <label style="font-size:20px; font-weight: lighter;">Enter the adjustment SL value:</label>
              <input class="form-control" type="text" style="margin-bottom:10px; width:550px;" name='usl'>

              <label style="font-size:20px; font-weight: lighter;">Enter the adjustment Comp.Off value:</label>
              <input class="form-control" type="text" style="margin-bottom:10px; width:550px;" name='uco' id="empemailInputCO">
            </div>
            <br />
            <input type="hidden" name='ccl' id="empemailInputCL1" value="">
            <input type="hidden" name='csl' id="empemailInputSL1" value="">
            <input type="hidden" name='cco' id="empemailInputCO1" value="">
            <input type="hidden" name='uempname' id="empnameInput" value="">
            <input type="hidden" name='uempemail' id="empemailInput" value="">
            <input type="hidden" name="by_user" value="<?php echo $_SESSION['user_name']; ?>">
            <button type="button" onclick="submitForm();" class="frame-item dialog__close1 btn udbtn" style=" font-size: 20px; position:absolute; right:50px; background-color: #FB8A0B; color: white;">Submit</button><br />
          </form>
        </div>
      </div>
    </dialog>

    
  </div>
  <script>
    function populateDialog(values) {
      var valueArray = values.split(',');

      var coValue = valueArray[0];
      var clValue = valueArray[1];
      var slValue = valueArray[2];
      var empnameValue = valueArray[3];
      var empemailValue = valueArray[4];

      document.getElementById('currentCompOff').innerText = coValue;
      document.getElementById('currentCL').innerText = clValue;
      document.getElementById('currentSL').innerText = slValue;
      document.getElementById('empemailInputCO1').value = coValue;
      document.getElementById('empemailInputCL1').value = clValue;
      document.getElementById('empemailInputSL1').value = slValue;
      document.getElementById('empnameInput').value = empnameValue;
      document.getElementById('empemailInput').value = empemailValue;
    }
  </script>
  <script>
    function submitForm() {
      var formData = $('#frm').serialize();
      $.ajax({
        type: 'POST',
        url: 'insert_ulb.php',
        data: formData,
        success: function(response) {
          if (response === 'success') {
            $.ajax({
              type: 'POST',
              url: 'update_ulb.php',
              data: formData,
              success: function(updateResponse) {
                Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: updateResponse
                }).then(function() {
                  window.location = 'Leave_Balance.php';
                });
              },
              error: function(xhr, status, error) {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'An error occurred while updating. Please try again later.'
                });
              }
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred while inserting. Please try again later.'
            });
          }
        },
        error: function(xhr, status, error) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while processing your request. Please try again later.'
          });
        }
      });
    }

    $('#frm').submit(function(event) {
      event.preventDefault();
      submitForm();
    });
  </script>

  <script>
    const modalLinks = document.querySelectorAll('a[href^="#modal"]');

    modalLinks.forEach(function(modalLink, index) {
      // Get modal ID to match the modal
      const modalId = modalLink.getAttribute('href');

      // Click on link
      modalLink.addEventListener('click', function(event) {

        // Get modal element
        const modal = document.querySelector(modalId);
        // If modal with an ID exists
        if (modal) {
          // Get close button
          const closeBtn = modal.querySelector('.dialog__close');
          event.preventDefault();
          modal.showModal(); // Open modal

          // Close modal on click
          closeBtn.addEventListener('click', function(event) {
            modal.close();
          });
          const closeBtn1 = modal.querySelector('.dialog__close1');
          event.preventDefault();
          modal.showModal(); // Open modal

          // Close modal on click
          closeBtn1.addEventListener('click', function(event) {
            modal.close();
          });

          // Close modal when clicking outside modal
          document.addEventListener('click', function(event) {

            const dialogEl = event.target.tagName;
            const dialogElId = event.target.getAttribute('id');
            if (dialogEl == 'DIALOG') {
              // Close modal
              modal.close();
            }
          }, false);

          // If modal ID not exists
        } else {
          console.log('Modal doesn\'t exist');
        }
      });
    });
  </script>
  <script>
    function updateFields() {
      var selectedEmployee = document.getElementsByClassName("employeeSelect")[0];
      var nameField = document.getElementById("employeeNameField");
      var emailField = document.getElementById("employeeEmailField");

      var selectedValue = selectedEmployee.options[selectedEmployee.selectedIndex].value;
      var values = selectedValue.split("|");

      nameField.value = values[0];
      emailField.value = values[1];
    }
  </script>
  <script>
    function filterTable() {
      var input = document.getElementById('filterInput');
      var filter = input.value.toUpperCase();

      var table = document.getElementById('attendanceTable');

      var rows = table.getElementsByTagName('tr');

      for (var i = 0; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName('td');
        var shouldShow = false;

        if (i === 0 || rows[i].classList.contains('static-cell')) { // Exclude header row and static cells
          shouldShow = true;
        } else {
          for (var j = 0; j < cells.length; j++) {
            var cell = cells[j];

            var txtValue = cell.textContent || cell.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              shouldShow = true;
              break;
            }
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
    var rectangleButton1 = document.getElementById("rectangleButton1");
    if (rectangleButton1) {
      rectangleButton1.addEventListener("click", function(e) {});
    }

    var map = document.getElementById("map");
    if (map) {
      map.addEventListener("click", function(e) {});
    }
  </script>
  <script>
    $(document).ready(function() {

      $("#updateForm").submit(function(e) {
        e.preventDefault();
        var empname = $("input[name='empname']").val();
        var empemail = $("input[name='empemail']").val();
        var sl = $("input[name='sl']").val();
        var cl = $("input[name='cl']").val();
        var co = $("input[name='co']").val();

        $.ajax({
          type: "POST",
          url: "insert_lb.php",
          data: {
            empname: empname,
            empemail: empemail,
            sl: sl,
            cl: cl,
            co: co
          },
          success: function(response) {
            Swal.fire({
              icon: 'success',
              title: 'Added!',
              text: response,
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = 'Leave_Balance.php';
              }
            });
          }
        });
      });
    });
  </script>
  <script>
    function previous()
    {
        window.location.href = 'prev_leave.php';
    }
  </script>
</body>

</html>