<?php
session_start();
@include 'inc/config.php';
$currentDate = date("Y-m-d");
// Check if user is logged in
if (!isset($_SESSION['email'])) {
  header("Location: loginpage.php");
  exit();
}


// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the module name from the URL (assuming the modkule pages have a parameter in the URL)
$module_name = basename($_SERVER['PHP_SELF']);

// Sanitize module name to prevent directory traversal attacks
$module_name = mysqli_real_escape_string($con, $module_name);

// Retrieve email from session
$email = $_SESSION['email'];

// Check if the module is linked to the user
$sql = "SELECT COUNT(*) AS count FROM user_modules INNER JOIN modules ON user_modules.module_id = modules.id INNER JOIN user_form ON user_modules.email = user_form.email WHERE user_form.email = '$email' AND modules.module_name = '$module_name'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['count'] == 0) {
  // If the module is not linked to the user, redirect to the login page
  header("Location: loginpage.php");
  exit();
}

// Fetch all users
$sql_users = "SELECT * FROM user_form";
$result_users = mysqli_query($con, $sql_users);
$users = mysqli_fetch_all($result_users, MYSQLI_ASSOC);

// Fetch all modules
$sql_modules = "SELECT * FROM modules";
$result_modules = mysqli_query($con, $sql_modules);
$modules = mysqli_fetch_all($result_modules, MYSQLI_ASSOC);

// Fetch user-module associations
$user_module_associations = array();
$sql_user_modules = "SELECT * FROM user_modules";
$result_user_modules = mysqli_query($con, $sql_user_modules);
while ($row = mysqli_fetch_assoc($result_user_modules)) {
  $user_module_associations[$row['email']][] = $row['module_id'];
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
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="./css/global.css" />
  <link rel="stylesheet" href="./css/index.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style>
    .dropbtn {
      background-color: #ffe2c6;
      color: #ff5400;
      padding: 16px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      min-width: 160px;
      /* box-shadow: 0px 8px 16px 0px #ffe2c6; */
    }

    .dropbtn1 {
      background-color: #ffe2c6;
      color: #ff5400;
      padding: 12px;
      margin-top: 5px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      /* box-shadow: 0px 8px 16px 0px #ffe2c6; */
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      position: absolute;
      background-color: #f9f9f9;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 99999;
      max-height: 0;
      min-width: 160px;
      transition: max-height 0.15s ease-out;
      overflow: hidden;
    }

    .dropdown-content a {
      color: black;
      background-color: #f9f9f9;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {
      background-color: #e2e2e2;
    }

    .dropdown:hover .dropdown-content {
      max-height: 500px;
      min-width: 160px;
      transition: max-height 0.25s ease-in;
    }

    .dropdown:hover .dropbtn {
      /* background-color: #f9f9f9;
  border-bottom: 1px solid #e0e0e0; */
      transition: max-height 0.25s ease-in;
    }

    .digital-watch .hour,
    .digital-watch .minute,
    .digital-watch .second {
      position: relative;
      display: inline-block;
      /* margin: 30px; */
      top: 3px;
      font-size: 0;
    }

    .digital-watch .hour::before,
    .digital-watch .hour::after,
    .digital-watch .minute::before,
    .digital-watch .minute::after {
      content: '';
      position: absolute;
      right: -9px;
      width: 6px;
      height: 6px;
      background-color: #ffa048;
    }

    .digital-watch .hour::before,
    .digital-watch .minute::before {
      top: 10px;
    }

    .digital-watch .hour::after,
    .digital-watch .minute::after {
      top: 25px;
    }

    .digital-watch svg {
      display: inline-block;
      margin: 6px;
    }

    .digital-watch svg .segment {
      fill: rgba(0, 0, 0, 0.027);
      transition: .3s ease-in-out;
    }

    .digital-watch svg.num-1 .b,
    .digital-watch svg.num-1 .c,

    .digital-watch svg.num-2 .a,
    .digital-watch svg.num-2 .b,
    .digital-watch svg.num-2 .d,
    .digital-watch svg.num-2 .e,
    .digital-watch svg.num-2 .g,

    .digital-watch svg.num-3 .a,
    .digital-watch svg.num-3 .b,
    .digital-watch svg.num-3 .c,
    .digital-watch svg.num-3 .d,
    .digital-watch svg.num-3 .g,

    .digital-watch svg.num-4 .b,
    .digital-watch svg.num-4 .c,
    .digital-watch svg.num-4 .f,
    .digital-watch svg.num-4 .g,

    .digital-watch svg.num-5 .a,
    .digital-watch svg.num-5 .c,
    .digital-watch svg.num-5 .d,
    .digital-watch svg.num-5 .f,
    .digital-watch svg.num-5 .g,

    .digital-watch svg.num-6 .a,
    .digital-watch svg.num-6 .c,
    .digital-watch svg.num-6 .d,
    .digital-watch svg.num-6 .e,
    .digital-watch svg.num-6 .f,
    .digital-watch svg.num-6 .g,

    .digital-watch svg.num-7 .a,
    .digital-watch svg.num-7 .b,
    .digital-watch svg.num-7 .c,

    .digital-watch svg.num-8 .a,
    .digital-watch svg.num-8 .b,
    .digital-watch svg.num-8 .c,
    .digital-watch svg.num-8 .d,
    .digital-watch svg.num-8 .e,
    .digital-watch svg.num-8 .f,
    .digital-watch svg.num-8 .g,

    .digital-watch svg.num-9 .a,
    .digital-watch svg.num-9 .b,
    .digital-watch svg.num-9 .c,
    .digital-watch svg.num-9 .d,
    .digital-watch svg.num-9 .f,
    .digital-watch svg.num-9 .g,

    .digital-watch svg.num-0 .a,
    .digital-watch svg.num-0 .b,
    .digital-watch svg.num-0 .c,
    .digital-watch svg.num-0 .d,
    .digital-watch svg.num-0 .e,
    .digital-watch svg.num-0 .f {
      fill: #ff5400;
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
      width: 330px;
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

    .flex {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .toggle-container,
    .toggle-switch {
      cursor: pointer;
      width: 140px;
      height: 40px;
      margin-top: -5px;
      font-size: 20px;
    }

    .toggle-container input[type="checkbox"] {
      display: none;
    }

    .toggle-container input[type="checkbox"]:checked~label .toggle-switch:before {
      content: attr(data-unchecked);
      left: 0;
    }

    .toggle-container input[type="checkbox"]:checked~label .toggle-switch:after {
      content: attr(data-checked);
      -webkit-transform: translate3d(100%, 0, 0);
      transform: translate3d(100%, 0, 0);
    }

    .toggle-switch {
      position: relative;
      background: rgba(0, 0, 0, 0.15);
      border-radius: 6px;
      box-shadow: 0 0 0px white;
      transition: all 1s ease-in-out;
    }

    .toggle-switch:before,
    .toggle-switch:after {
      position: absolute;
      height: calc(100% - 4px);
      width: calc(50% - 2px);
      top: 2px;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .toggle-switch:before {
      content: attr(data-checked);
      color: rgba(255, 255, 255, 0.75);
      left: 50%;
    }

    .toggle-switch:after {
      content: attr(data-unchecked);
      left: 2px;
      border-radius: 6px;
      z-index: 1;
      background: #ffe2c6;
      transform: translate3d(0, 0, 0);
      transition: transform 0.3s cubic-bezier(0, 1, 0.5, 1);
      box-shadow: 0 0 7.5px white;
    }

    .toggle-switch:hover:after {
      box-shadow: 0 0 12.5px white;
    }

    .circle {
      background: #F56A12;
      border-radius: 50%;
      display: inline-block;
      width: 30px;
      height: 30px;
      line-height: 30px;
      text-align: center;
      color: white;
      font-size: 15px;
      font-weight: bold;
      margin-left: 20px;
      position: relative;
      top: -5px;
    }

    @keyframes circle {
      0% {
        opacity: 1;
      }

      50% {
        opacity: 0;
      }

      100% {
        opacity: 1;
      }
    }

    .circle {
      animation: circle 0.9s infinite;
    }

    .icon-button {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 50px;
      height: 50px;
      color: #ff5400;
      background: #ffe2c6;
      border: none;
      outline: none;
      border-radius: 50%;
    }

    .icon-button:hover {
      cursor: pointer;
    }

    .icon-button:active {
      background: #cccccc;
    }

    .icon-button__badge {
      font-size: 15px;
      position: absolute;
      top: -10px;
      right: -10px;
      width: 25px;
      height: 25px;
      background: red;
      color: #ffffff;
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 50%;
      font-weight: bold;
    }

    .circleAnimate {
      animation: circle 0.9s infinite;
    }

    @keyframes icon-button {
      0% {
        opacity: 1;
      }

      50% {
        opacity: 0;
      }

      100% {
        opacity: 1;
      }
    }

    .icon-button__badge {
      animation: icon-button 0.9s infinite;
    }

    @keyframes pulse {
      0% {
        -moz-transform: scale(0.9);
        -ms-transform: scale(0.9);
        -webkit-transform: scale(0.9);
        transform: scale(0.9);
      }

      70% {
        -moz-transform: scale(1);
        -ms-transform: scale(1);
        -webkit-transform: scale(1);
        transform: scale(1);
        box-shadow: 0 0 0 50px rgba(255, 0, 0, 0);
      }

      100% {
        -moz-transform: scale(0.9);
        -ms-transform: scale(0.9);
        -webkit-transform: scale(0.9);
        transform: scale(0.9);
        box-shadow: 0 0 0 0 rgba(255, 0, 0, 0);
      }
    }

    .icon-button__badge {
      box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.5);
      animation: pulse 1.5s infinite;
    }

    .notifi-box {
      z-index: 99999;
      width: 300px;
      height: 0px;
      opacity: 0;
      position: absolute;
      top: 63px;
      right: 35px;
      transition: 1s opacity, 250ms height;
      background: #FFFFFF;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      border-radius: 5%;
    }

    .notifi-box h2 {
      font-size: 14px;
      padding: 10px;
      border-bottom: 1px solid black;
      color: #777;
    }

    .notifi-box h2 span {
      color: #f00;
    }

    .notifi-item {
      display: flex;
      padding: 15px 5px;
      /* margin-bottom: 15px; */
      cursor: pointer;
    }

    .notifi-item:hover {
      background-color: #e2e2e2;
      border-radius: 5%;
    }

    .notifi-item img {
      display: block;
      width: 50px;
      margin-right: 10px;
      border-radius: 50%;
    }

    .notifi-item .text h4 {
      color: #777;
      font-size: 16px;
      margin-top: 10px;
    }

    .notifi-item .text p {
      color: BLACK;
      font-size: 12px;
    }

    .mgr-view {
      margin-top: -625px;
      margin-left: -20px;
      color: white;
      font-size: 20px;
      text-decoration: none;
      white-space: nowrap;
    }

    .employeedashboard-inner {
      display: flex;
      align-items: center;
      background-color: #007bff;
      color: white;
      border: none;
      padding: 4px 15px;
      height: 50px;
      width: 110px;
      cursor: pointer;
    }

    .employeedashboard-inner svg {
      flex-shrink: 0;
    }

    .employeedashboard-inner span {
      margin-left: 5px;
    }
  </style>
  <script>
    function checkForUpdates() {
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
          if (xhr.status == 200) {
            try {
              var response = JSON.parse(xhr.responseText.replace(/(['"])?([a-zA-Z0-9_]+)(['"])?:/g, '"$2":'));

              console.log(response);

              if (response && response.hasUpdates) {
                console.log('Reloading page...');
                // Reload the page if updates are found
                location.reload();
              }
            } catch (error) {
              console.error('Error parsing JSON response. Raw response:', xhr.responseText);
              console.error('Error details:', error);
            }
          } else {
            console.error('Error in AJAX request. Status:', xhr.status);
          }
        }
      };

      xhr.open("GET", "getattendence.php", true);
      xhr.send();
    }

    setInterval(checkForUpdates, 1000);
  </script>
</head>

<body>

  <?php
   if ($work_location == 'All') {
    $sql_leaves = "SELECT COUNT(*) AS count FROM leaves WHERE status = 0";
} elseif ($work_location == 'Visakhapatnam') {
  $sql_leaves = "
  SELECT COUNT(*) AS count
  FROM leaves
  INNER JOIN emp ON leaves.empname = emp.empname
  WHERE leaves.status = 0 AND emp.work_location = 'Visakhapatnam';
  ";
} elseif ($work_location == 'Gurugram') {
  $sql_leaves = "
  SELECT COUNT(*) AS count
  FROM leaves
  INNER JOIN emp ON leaves.empname = emp.empname
  WHERE leaves.status = 0 AND emp.work_location = 'Gurugram';
  ";
}
  $result_leaves = $con->query($sql_leaves);
  $row_leaves = $result_leaves->fetch_assoc();
  $count_leaves = $row_leaves['count'];

  $sql_onb = "SELECT COUNT(*) AS count FROM onb WHERE status = 0";
  $result_onb = $con->query($sql_onb);
  $row_onb = $result_onb->fetch_assoc();
  $count_onb = $row_onb['count'];

  $sql_payroll = "SELECT COUNT(*) AS count FROM payroll_schedule WHERE status = 7 AND approval = 0";
  $result_payroll = $con->query($sql_payroll);
  $row_payroll = $result_payroll->fetch_assoc();
  $count_payroll = $row_payroll['count'];
  ?>
  <div class="index1">
    <div class="bg18"></div>
    <img class="index-child" alt="" src="./public/rectangle-11@2x.png" />

    <img class="index-item" alt="" src="./public/rectangle-21@2x.png" />

    <img class="logo-1-icon18" alt="" src="./public/logo-1@2x.png" />
    <a class="anikahrm18">
      <span>Anika</span>
      <span class="hrm18">HRM</span>
    </a>
    <?php
    $email1 = $email;

    $sql = "SELECT * FROM user_form WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email1);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
      $user_type = $row['user_type'];
      $user_type1 = $row['user_type1'];

      $is_enabled = ($user_type == 'user' && $user_type1 == 'admin');
    } else {
      $is_enabled = false;
    }
    ?>
    <?php
    if ($is_enabled) {
    ?>
      <a href="employee-dashboard.php" class="index-inner employeedashboard-inner mgr-view">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
          <polygon points="12 15 17 21 7 21 12 15"></polygon>
        </svg>
        <span>My View</span>
      </a>
    <?php
    }
    ?>
    <h5 class="hr-management">HR Management</h5>
    <a href="logout.php"><button class="index-inner"></button>
      <div class="logout18">Logout</div>
    </a>
    <a class="employee-list18" id="employeeList">Employee List
    </a>
    <a class="leaves18" id="leaves">Leaves
      <?php if ($count_leaves > 0) { ?>
        <span class="circle">
          <?php echo $count_leaves ?>
        </span>
      <?php
      }
      ?>
    </a>
    <a class="onboarding22" id="onboarding" href="./onboarding.php">Onboarding
      <?php if ($count_onb > 0) { ?>
        <span class="circle">
          <?php echo $count_onb ?>
        </span>
      <?php
      }
      ?>
    </a>
    <?php
  $sql_payroll_loan = "SELECT COUNT(*) AS count FROM payroll_loan_req WHERE status = 0 ";
  $result_payroll_loan = $con->query($sql_payroll_loan);
  $row_payroll_loan = $result_payroll_loan->fetch_assoc();
  $count_payroll_loan = $row_payroll_loan['count'];

    $sql = "SELECT emp.emp_no, emp.empname, emp.pic, emp.empstatus, emp.dept, CamsBiometricAttendance.*
FROM emp
INNER JOIN CamsBiometricAttendance ON emp.UserID = CamsBiometricAttendance.UserID
AND emp.ServiceTagId = CamsBiometricAttendance.ServiceTagId
WHERE emp.empstatus = 0
AND emp.desg != 'SECURITY GAURDS'
AND emp.ServiceTagId = 'ZXQI19009096'
ORDER BY CamsBiometricAttendance.AttendanceTime DESC;
";

    $que = mysqli_query($con, $sql);

    $attendanceCount = 0;
    $checkInOutStatus = array(); // Array to track CheckIn and CheckOut statuses

    $previousDay = date('Y-m-d', strtotime('-1 day')); // Get the previous day in 'Y-m-d' format

    while ($result = mysqli_fetch_assoc($que)) {
      $userId = $result['UserID'];
      $attendanceDate = date('Y-m-d', strtotime($result['AttendanceTime']));
      $dayOfMonth = date('j', strtotime($result['AttendanceTime']));

      // Process only if the attendance is from the previous day
      if ($attendanceDate == $previousDay) {
        if (!isset($checkInOutStatus[$userId])) {
          $checkInOutStatus[$userId] = array();
        }

        if (!isset($checkInOutStatus[$userId][$dayOfMonth])) {
          $checkInOutStatus[$userId][$dayOfMonth] = array('CheckIn' => 0, 'CheckOut' => 0);
        }

        if ($result['AttendanceType'] == 'CheckIn') {
          $checkInOutStatus[$userId][$dayOfMonth]['CheckIn']++;
        }

        if ($result['AttendanceType'] == 'CheckOut') {
          $checkInOutStatus[$userId][$dayOfMonth]['CheckOut']++;
        }
      }
    }

    foreach ($checkInOutStatus as $userId => $days) {
      foreach ($days as $day => $status) {
        if ($status['CheckIn'] > 0 && $status['CheckOut'] == 0) {
          $attendanceCount++;
        }
      }
    }

    ?>
    <?php

    $sqlGGM = "SELECT emp.*, CamsBiometricAttendance_GGM.*
FROM emp
INNER JOIN CamsBiometricAttendance_GGM ON emp.UserID = CamsBiometricAttendance_GGM.UserID
WHERE emp.empstatus = 0
AND emp.desg != 'SECURITY GAURDS'
";

    $que = mysqli_query($con, $sqlGGM);

    $attendanceCountGGM = 0;
    $checkInOutStatus = array(); // Array to track CheckIn and CheckOut statuses

    $previousDay = date('Y-m-d', strtotime('-1 day')); // Get the previous day in 'Y-m-d' format

    while ($resultGGM = mysqli_fetch_assoc($que)) {
      $userId = $resultGGM['UserID'];
      $attendanceDate = date('Y-m-d', strtotime($resultGGM['AttendanceTime']));
      $dayOfMonth = date('j', strtotime($resultGGM['AttendanceTime']));

      // Process only if the attendance is from the previous day
      if ($attendanceDate == $previousDay) {
        if (!isset($checkInOutStatus[$userId])) {
          $checkInOutStatus[$userId] = array();
        }

        if (!isset($checkInOutStatus[$userId][$dayOfMonth])) {
          $checkInOutStatus[$userId][$dayOfMonth] = array('CheckIn' => 0, 'CheckOut' => 0);
        }

        if ($resultGGM['AttendanceType'] == 'CheckIn') {
          $checkInOutStatus[$userId][$dayOfMonth]['CheckIn']++;
        }

        if ($resultGGM['AttendanceType'] == 'CheckOut') {
          $checkInOutStatus[$userId][$dayOfMonth]['CheckOut']++;
        }
      }
    }

    foreach ($checkInOutStatus as $userId => $days) {
      foreach ($days as $day => $status) {
        if ($status['CheckIn'] > 0 && $status['CheckOut'] == 0) {
          $attendanceCountGGM++;
        }
      }
    }
    $totalattendance = $attendanceCount + $attendanceCountGGM;
    ?>
    <a class="attendance18" id="attendance">Attendance
      <?php if ($totalattendance > 0) { ?>
        <span class="circleAnimate">
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="19" viewBox="0 0 24 24" fill="none" stroke="#F66E12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
            <line x1="12" y1="9" x2="12" y2="13"></line>
            <line x1="12" y1="17" x2="12.01" y2="17"></line>
          </svg>
        </span>
      <?php
      }
      ?>
    </a>
    <a href="./Payroll/payroll.php" style="text-decoration:none; color:black" class="payroll18">Payroll
      <?php if ($count_payroll > 0 || $count_payroll_loan > 0) { 
        $total_payroll_count = $count_payroll + $count_payroll_loan
        ?>
        <span class="circle">
          <?php echo $total_payroll_count ?>
        </span>
      <?php
      }
      ?>
    </a>
    <a href="./Reports/reports.php" style="text-decoration:none; color:black" class="reports18">Reports</a>
    <a class="fluentpeople-32-regular18" id="fluentpeople32Regular">
      <img class="vector-icon94" alt="" src="./public/vector7.svg" />
    </a>
    <a class="fluent-mdl2leave-user18" id="fluentMdl2leaveUser">
      <img class="vector-icon95" alt="" src="./public/vector.svg" />
    </a>
    <a class="fluentperson-clock-20-regular18" id="fluentpersonClock20Regular">
      <img class="vector-icon96" alt="" src="./public/vector1.svg" />
    </a>
    <a class="uitcalender18" id="uitcalender">
      <img class="vector-icon97" alt="" src="./public/vector4.svg" />
    </a>
    <img class="arcticonsgoogle-pay18" alt="" src="./public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon18" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />

    <img class="index-child2" alt="" src="./public/rectangle-4@2x.png" />

    <a class="dashboard18">Dashboard</a>
    <a class="akar-iconsdashboard18">
      <img class="vector-icon98" alt="" src="./public/vector14.svg" />
    </a>
    <div class="index-child3"></div>
    <div>
      <?php
      @include 'inc/config.php';

      $sql1 = "SELECT COUNT(DISTINCT e.UserID) as count
      FROM emp e 
      JOIN CamsBiometricAttendance c ON e.UserID = c.UserID AND e.ServiceTagId = c.ServiceTagId
      WHERE e.empstatus = 0
        AND c.ServiceTagId = 'ZXQI19009096'
        AND DATE(c.AttendanceTime) = '$currentDate' 
        AND c.AttendanceType = 'CheckIn'
        AND NOT EXISTS (
            SELECT 1
            FROM CamsBiometricAttendance co
            WHERE co.UserID = c.UserID
              AND co.ServiceTagId = c.ServiceTagId
              AND DATE(co.AttendanceTime) = DATE(c.AttendanceTime)
              AND co.AttendanceType = 'CheckOut'
              AND co.AttendanceTime > c.AttendanceTime
        )";




      $result1 = $con->query($sql1);
      $row1 = $result1->fetch_assoc();
      $count1 = $row1['count'];


      $sql2 = "SELECT COUNT(*) as count
         FROM emp e
         JOIN leaves l ON e.empname = l.empname 
         WHERE empstatus = 0
           AND l.leavetype != 'WORK FROM HOME'
           AND ((l.status = 1 AND l.status1 = 1) OR (l.status = 1 AND l.status1 = 0))
           AND '$currentDate' BETWEEN DATE(l.from) AND DATE(l.to)";


      $result2 = $con->query($sql2);
      $row2 = $result2->fetch_assoc();
      $count2 = $row2['count'];

      $sql21 = "SELECT COUNT(*) as count
          FROM emp e
          JOIN leaves l ON e.empname = l.empname  
          WHERE empstatus = 0
          AND e.work_location = 'Visakhapatnam'
            AND ((l.status = 1 AND l.status1 = 1) OR (l.status = 1 AND l.status1 = 0))
            AND '$currentDate' BETWEEN DATE(l.from) AND DATE(l.to)
            AND l.leavetype != 'HALF DAY'";


      $result21 = $con->query($sql21);
      $row21 = $result21->fetch_assoc();
      $count21 = $row21['count'];

      $sql3 = "SELECT COUNT(*) as count FROM absent a
        JOIN emp e ON a.empname = e.empname
        WHERE TIMESTAMP(DATE(AttendanceTime)) = '$currentDate'
              AND e.work_location = 'Visakhapatnam'
        ";


      $result3 = $con->query($sql3);
      $row3 = $result3->fetch_assoc();
      $count3 = $row3['count'];

      $sql4 = "SELECT COUNT(work_location) as count FROM emp WHERE empstatus= 0 AND work_location='Visakhapatnam' ";

      $result4 = $con->query($sql4);
      $row4 = $result4->fetch_assoc();
      $count4 = $row4['count'];

      $sql5 = "SELECT COUNT(*) as count
         FROM emp e
         WHERE empstatus = 0
         AND e.work_location = 'Visakhapatnam'
          AND e.UserID != '0'
           AND NOT EXISTS (
               SELECT 1
               FROM CamsBiometricAttendance c
               WHERE e.UserID = c.UserID
                 AND DATE(c.AttendanceTime) = '$currentDate'
                 AND c.AttendanceType = 'CheckIn'
           )
           AND e.UserID NOT IN (
               SELECT e.UserID
               FROM emp e
               JOIN leaves l ON e.empname = l.empname 
               WHERE ((l.status = 1 AND l.status1 = 1) OR (l.status = 1 AND l.status1 = 0))
                 AND '$currentDate' BETWEEN DATE(l.from) AND DATE(l.to)
               UNION
               SELECT e.UserID
               FROM absent a
               JOIN emp e ON a.empname = e.empname
               WHERE TIMESTAMP(DATE(a.AttendanceTime)) = '$currentDate'
           )";


      $result5 = $con->query($sql5);
      $row5 = $result5->fetch_assoc();
      $count5 = $row5['count'];

      // gurugram

      $sql1_ggm = "SELECT COUNT(DISTINCT e.UserID) as count
      FROM emp e 
      JOIN CamsBiometricAttendance_GGM c ON e.UserID = c.UserID AND e.ServiceTagId = c.ServiceTagId
      WHERE e.empstatus = 0
        AND c.ServiceTagId = 'ZYSA07001899'
        AND DATE(c.AttendanceTime) = '$currentDate' 
        AND c.AttendanceType = 'CheckIn'
        AND NOT EXISTS (
            SELECT 1
            FROM CamsBiometricAttendance_GGM co
            WHERE co.UserID = c.UserID
              AND co.ServiceTagId = c.ServiceTagId
              AND DATE(co.AttendanceTime) = DATE(c.AttendanceTime)
              AND co.AttendanceType = 'CheckOut'
              AND co.AttendanceTime > c.AttendanceTime
        )";




      $result1_ggm = $con->query($sql1_ggm);
      $row1_ggm = $result1_ggm->fetch_assoc();
      $count1_ggm = $row1_ggm['count'];

      $sql2_ggm = "SELECT COUNT(*) as count
      FROM emp e
      JOIN leaves l ON e.empname = l.empname 
      WHERE empstatus = 0
          AND e.work_location = 'Gurugram'
        AND ((l.status = 1 AND l.status1 = 1) OR (l.status = 1 AND l.status1 = 0))
        AND '$currentDate' BETWEEN DATE(l.from) AND DATE(l.to)";


      $result2_ggm = $con->query($sql2_ggm);
      $row2_ggm = $result2_ggm->fetch_assoc();
      $count2_ggm = $row2_ggm['count'];


      $sql21_ggm = "SELECT COUNT(*) as count
       FROM emp e
       JOIN leaves l ON e.empname = l.empname  
       WHERE empstatus = 0
       AND e.work_location = 'Gurugram'
         AND ((l.status = 1 AND l.status1 = 1) OR (l.status = 1 AND l.status1 = 0))
         AND '$currentDate' BETWEEN DATE(l.from) AND DATE(l.to)
         AND l.leavetype != 'HALF DAY'";


      $result21_ggm = $con->query($sql21_ggm);
      $row21_ggm = $result21_ggm->fetch_assoc();
      $count21_ggm = $row21_ggm['count'];

      $sql3_ggm = "SELECT COUNT(*) as count FROM absent a
     JOIN emp e ON a.empname = e.empname
     WHERE TIMESTAMP(DATE(AttendanceTime)) = '$currentDate'
           AND e.work_location = 'Gurugram'
     ";


      $result3_ggm = $con->query($sql3_ggm);
      $row3_ggm = $result3_ggm->fetch_assoc();
      $count3_ggm = $row3_ggm['count'];

      $sql4_ggm = "SELECT COUNT(work_location) as count FROM emp WHERE empstatus= 0 AND work_location='Gurugram' ";

      $result4_ggm = $con->query($sql4_ggm);
      $row4_ggm = $result4_ggm->fetch_assoc();
      $count4_ggm = $row4_ggm['count'];

      $sql5_ggm = "SELECT COUNT(*) as count
      FROM emp e
      WHERE e.empstatus = 0
      AND e.work_location = 'Gurugram'
        AND NOT EXISTS (
            SELECT 1
            FROM CamsBiometricAttendance_GGM c
            WHERE e.UserID = c.UserID
              AND DATE(c.AttendanceTime) = '$currentDate'
              AND c.AttendanceType = 'CheckIn'
        )
        AND e.UserID NOT IN (
            SELECT e.UserID
            FROM emp e
            JOIN leaves l ON e.empname = l.empname 
            WHERE ((l.status = 1 AND l.status1 = 1) OR (l.status = 1 AND l.status1 = 0))
              AND '$currentDate' BETWEEN DATE(l.from) AND DATE(l.to)
            UNION
            SELECT e.UserID
            FROM absent a
            JOIN emp e ON a.empname = e.empname
            WHERE TIMESTAMP(DATE(a.AttendanceTime)) = '$currentDate'
        )";


      $result5_ggm = $con->query($sql5_ggm);
      $row5_ggm = $result5_ggm->fetch_assoc();
      $count5_ggm = $row5_ggm['count'];
      ?>

      <?php
      $sql_leaves = "SELECT COUNT(*) AS count FROM leaves WHERE status = 0";
      $result_leaves = $con->query($sql_leaves);
      $row_leaves = $result_leaves->fetch_assoc();
      $count_leaves = $row_leaves['count'];

      $sql_onb = "SELECT COUNT(*) AS count FROM onb WHERE status = 0";
      $result_onb = $con->query($sql_onb);
      $row_onb = $result_onb->fetch_assoc();
      $count_onb = $row_onb['count'];

      $sql_payroll = "SELECT COUNT(*) AS count FROM payroll_schedule WHERE status = 7 AND approval = 0";
      $result_payroll = $con->query($sql_payroll);
      $row_payroll = $result_payroll->fetch_assoc();
      $count_payroll = $row_payroll['count'];

      
      $sql_payroll_loan = "SELECT COUNT(*) AS count FROM payroll_loan_req WHERE status = 0 ";
      $result_payroll_loan = $con->query($sql_payroll_loan);
      $row_payroll_loan = $result_payroll_loan->fetch_assoc();
      $count_payroll_loan = $row_payroll_loan['count'];

      if ($totalattendance > 0) {
        $attendanceDCount = 1;
      } else {
        $attendanceDCount = 0;
      }
      $total_count = $count_leaves + $count_onb + $count_payroll + $attendanceDCount + $count_payroll_loan;
      ?>
      <div class="rectangle-parent" style="position: absolute; right: 380px;">
        <?php 
      if ($work_location == 'All') {
        ?>
        <div class="flex items-center" style="position:absolute;top:20px;left:-500px;">
          <div class="toggle-container">
            <input class="skills-toggle toggle hidden" type="checkbox" id="toggle" name="toggle">
            <label for="toggle">
              <div style="color:#ff5400" class="toggle-switch" data-checked="GGM" data-unchecked="VSP"></div>
            </label>
          </div>
        </div>
        <?php
        }
        ?>

        <div class="dropdown" style="margin-left:-70px;">
          <button type="button" class="icon-button" onclick="toggleNotifi()">
            <span class="material-icons">notifications</span>
            <?php if ($total_count > 0) { ?>
            <span class="icon-button__badge"><?php echo $total_count ?></span>
            <?php
          }
          ?>
          </button>
        </div>
        
        <div class="notifi-box " id="box">
          <!-- <h2>Notifications : <span><?php echo $total_count ?></span></h2> -->
          <?php if ($total_count <= 0) { ?>
            <div class="notifi-item" id="notification">
              <div class="text">
                <p>No Notifications</p>
              </div>
            </div>
      <?php
          }
      ?>

          <?php if ($count_leaves > 0) { ?>
            <a href="leave-management.php" style="text-decoration:none;">
              <div class="notifi-item" style="	border-bottom: 1px solid #dddddd;">
                <div class="text">
                  <h4>Employee Leave</h4>
                  <p>Kindly perform an action - either submit the employee leave request to the manager or reject it. </p>
                </div>
              </div>
            </a>
          <?php
          }
          ?>
          <?php if ($count_onb > 0) { ?>
            <a href="onboarding.php" style="text-decoration:none;">
              <div class="notifi-item" style="	border-bottom: 1px solid #dddddd;">
                <div class="text">
                  <h4>Onboarding</h4>
                  <p>Onboard the new recruits !</p>
                </div>
              </div>
            </a>
          <?php
          }
          ?>
          <a href="Payroll/payroll.php" style="text-decoration:none;">
            <?php if ($count_payroll > 0) { ?>
              <div class="notifi-item" style="	border-bottom: 1px solid #dddddd;">
                <div class="text">
                  <h4>Payroll Notification</h4>
                  <p>Complete the pending steps in payroll !</p>
                </div>
              </div>
          </a>
        <?php
            }
        ?>
        <a href="Payroll/loans.php" style="text-decoration:none;">
            <?php if ($count_payroll_loan > 0) { ?>
              <div class="notifi-item" style="	border-bottom: 1px solid #dddddd;">
                <div class="text">
                  <h4>Payroll Notification</h4>
                  <p>New Loan Request: An employee has submitted a loan application, kindly review.</p>
                </div>
              </div>
          </a>
        <?php
            }
        ?>
        <a href="attendence.php" style="text-decoration:none;">
          <?php if ($totalattendance > 0) { ?>
            <div class="notifi-item">
              <div class="text">
                <h4>Attendance Discrepancy</h4>
                <p>Discrepancies in the Attendance found, kindly rectify it !</p>
              </div>
            </div>
        </a>
      <?php
          }
      ?>
         
        </div>
        <div class="dropdown" style="z-index:99999; margin-left: 20px;">
          <button style="border-radius: 10px;" class="dropbtn" for="btnControl"><span style='font-weight:500; margin-left:15px; font-size:18px;'>Quick Access</span></button>
          <img src="./public/mdithunder1.png" width="15px" style='margin-top:-38px; margin-left:15px;' />
          <div class="dropdown-content" style="border-radius: 10px; width: 200px; margin-left: -20px;">
            <div style="display: none; gap: 5px; border-bottom: 1px solid rgba(223, 223, 223, 0.397);">
              <div style="background-color: #ebecf0; width: 40px; height: 40px; border-radius: 5px; margin-left: 7px; margin-top: 7px; margin-bottom: 5px;">
                <img style="margin-left: 7px; margin-top: 7px;" src="./public/maillog-removebg-preview.png" width="25px" alt="">
              </div>
              <a href="maillog.php" style="font-size: 16px; margin-top: 6px;">Mail Log</a>
            </div>
            <div style="display: flex; gap: 5px; border-bottom: 1px solid rgba(223, 223, 223, 0.397);">
              <div style="background-color: #ebecf0; width: 40px; height: 40px; border-radius: 5px; margin-left: 7px; margin-top: 7px; margin-bottom: 5px;">
                <img style="margin-left: 7px; margin-top: 7px;" src="./public/maillog-removebg-preview.png" width="25px" alt="">
              </div>
              <a href="maillog.php" style="font-size: 16px; margin-top: 6px;">Mail Log</a>
            </div>
            <div style="display: flex; gap: 5px; border-bottom: 1px solid rgba(223, 223, 223, 0.397);">
              <div style="background-color: #ebecf0; width: 40px; height: 40px; border-radius: 5px; margin-left: 7px; margin-top: 7px;  margin-bottom: 5px;">
                <img style="margin-left: 7px; margin-top: 7px;" src="./public/desig.png" width="25px" alt="">
              </div>
              <a href="designation.php" style="font-size: 16px; margin-top: 6px;">Designation</a>
            </div>
            <div style="display: flex; gap: 5px; border-bottom: 1px solid rgba(223, 223, 223, 0.397);">
              <div style="background-color: #ebecf0; width: 40px; height: 40px; border-radius: 5px; margin-left: 7px; margin-top: 7px;  margin-bottom: 5px;">
                <img style="margin-left: 7px; margin-top: 7px;" src="./public/4817116.png" width="25px" alt="">
              </div>
              <a href="location.php" style="font-size: 16px; margin-top: 6px;">Add Location</a>
            </div>
            <div style="display: flex; gap: 5px; border-bottom: 1px solid rgba(223, 223, 223, 0.397);">
              <div style="background-color: #ebecf0; width: 40px; height: 40px; border-radius: 5px; margin-left: 7px; margin-top: 7px;  margin-bottom: 5px;">
                <img style="margin-left: 7px; margin-top: 7px;" src="./public/doc.png" width="25px" alt="">
              </div>
              <a href="documents.php" style="font-size: 16px; margin-top: 6px;">Documents</a>
            </div>
            <div style="display: flex; gap: 5px; border-bottom: 1px solid rgba(223, 223, 223, 0.397);">
              <div style="background-color: #ebecf0; width: 40px; height: 40px; border-radius: 5px; margin-left: 7px; margin-top: 7px;  margin-bottom: 5px;">
                <img style="margin-left: 5px; margin-top: 5px;" src="./public/users-removebg-preview.png" width="30px" alt="">
              </div>
              <a href="users.php" style="font-size: 16px; margin-top: 6px;">Users</a>
            </div>
            <div style="display: flex; gap: 5px;  margin-bottom: 5px; border-bottom: 1px solid rgba(223, 223, 223, 0.397);">
              <div style="background-color: #ebecf0; width: 40px; height: 40px; border-radius: 5px; margin-left: 7px; margin-top: 7px; ">
                <img style="margin-left: 7px; margin-top: 7px;" src="./public/fingerprint_preview-removebg-preview.png" width="25px" alt="">
              </div>
              <a href="map.php" style="font-size: 16px; margin-top: 6px;">Map Biometric</a>
            </div>
            <div style="display: flex; gap: 5px;  margin-bottom: 5px;">
              <div style="background-color: #ebecf0; width: 40px; height: 40px; border-radius: 5px; margin-left: 7px; margin-top: 7px; ">
                <img style="margin-left: 7px; margin-top: 7px;" src="./public/manager123.png" width="25px" alt="">
              </div>
              <a href="manager.php" style="font-size: 16px; margin-top: 6px;">Managers</a>
            </div>
            <!--  <div style="display: flex; gap: 5px;  margin-bottom: 5px;">-->
            <!--  <div style="background-color: #ebecf0; width: 40px; height: 40px; border-radius: 5px; margin-left: 7px; margin-top: 7px; ">-->
            <!--    <img style="margin-left: 7px; margin-top: 7px;" src="./public/confirm.png" width="25px" alt="">-->
            <!--  </div>-->
            <!--<a href="confirmAttendance.php" style="font-size: 16px; margin-top: 6px;">Confirm</a>-->
            <!--</div>-->
          </div>
        </div>

      </div>
      <!-- <img class="vector-icon5" alt="" src="./public/vector@2x.png" /> -->
      <!--</div>-->
      <div style="top: 15px; position: absolute; right: 130px; background-color: #ffe2c6; border-radius: 10px; display: flex;">
        <img src="./public/flag.png" style="height:35px; margin-top: 5px;" />
        <div class="digital-watch" style="margin-left:-20px;">
          <svg width="0" height="0" viewBox="0 0 0 0">
            <defs>
              <g id="unit-h">
                <path d="M0 20 L20 40 L180 40 L200 20 L180 0 L20 0 Z"></path>
              </g>
              <g id="unit-v">
                <path d="M20 0 L0 20 L0 180 L20 200 L40 180 L40 20 Z"></path>
              </g>
            </defs>
          </svg>
          <div class="hour">
            <svg id="hour-1" class="num-0" width="20" height="30" viewBox="0 0 260 480">
              <use xlink:href="#unit-h" class="segment a" x="30" y="0"></use>
              <use xlink:href="#unit-v" class="segment b" x="220" y="30"></use>
              <use xlink:href="#unit-v" class="segment c" x="220" y="250"></use>
              <use xlink:href="#unit-h" class="segment d" x="30" y="440"></use>
              <use xlink:href="#unit-v" class="segment e" x="0" y="250"></use>
              <use xlink:href="#unit-v" class="segment f" x="0" y="30"></use>
              <use xlink:href="#unit-h" class="segment g" x="30" y="220"></use>
            </svg>
            <svg id="hour-2" class="num-0" width="20" height="30" viewBox="0 0 260 480">
              <use xlink:href="#unit-h" class="segment a" x="30" y="0"></use>
              <use xlink:href="#unit-v" class="segment b" x="220" y="30"></use>
              <use xlink:href="#unit-v" class="segment c" x="220" y="250"></use>
              <use xlink:href="#unit-h" class="segment d" x="30" y="440"></use>
              <use xlink:href="#unit-v" class="segment e" x="0" y="250"></use>
              <use xlink:href="#unit-v" class="segment f" x="0" y="30"></use>
              <use xlink:href="#unit-h" class="segment g" x="30" y="220"></use>
            </svg>
          </div>
          <div class="minute">
            <svg id="minute-1" class="num-0" width="20" height="30" viewBox="0 0 260 480">
              <use xlink:href="#unit-h" class="segment a" x="30" y="0"></use>
              <use xlink:href="#unit-v" class="segment b" x="220" y="30"></use>
              <use xlink:href="#unit-v" class="segment c" x="220" y="250"></use>
              <use xlink:href="#unit-h" class="segment d" x="30" y="440"></use>
              <use xlink:href="#unit-v" class="segment e" x="0" y="250"></use>
              <use xlink:href="#unit-v" class="segment f" x="0" y="30"></use>
              <use xlink:href="#unit-h" class="segment g" x="30" y="220"></use>
            </svg>
            <svg id="minute-2" class="num-0" width="20" height="30" viewBox="0 0 260 480">
              <use xlink:href="#unit-h" class="segment a" x="30" y="0"></use>
              <use xlink:href="#unit-v" class="segment b" x="220" y="30"></use>
              <use xlink:href="#unit-v" class="segment c" x="220" y="250"></use>
              <use xlink:href="#unit-h" class="segment d" x="30" y="440"></use>
              <use xlink:href="#unit-v" class="segment e" x="0" y="250"></use>
              <use xlink:href="#unit-v" class="segment f" x="0" y="30"></use>
              <use xlink:href="#unit-h" class="segment g" x="30" y="220"></use>
            </svg>
          </div>
          <div class="second">
            <svg id="second-1" class="num-0" width="20" height="30" viewBox="0 0 260 480">
              <use xlink:href="#unit-h" class="segment a" x="30" y="0"></use>
              <use xlink:href="#unit-v" class="segment b" x="220" y="30"></use>
              <use xlink:href="#unit-v" class="segment c" x="220" y="250"></use>
              <use xlink:href="#unit-h" class="segment d" x="30" y="440"></use>
              <use xlink:href="#unit-v" class="segment e" x="0" y="250"></use>
              <use xlink:href="#unit-v" class="segment f" x="0" y="30"></use>
              <use xlink:href="#unit-h" class="segment g" x="30" y="220"></use>
            </svg>
            <svg id="second-2" class="num-0" width="20" height="30" viewBox="0 0 260 480">
              <use xlink:href="#unit-h" class="segment a" x="30" y="0"></use>
              <use xlink:href="#unit-v" class="segment b" x="220" y="30"></use>
              <use xlink:href="#unit-v" class="segment c" x="220" y="250"></use>
              <use xlink:href="#unit-h" class="segment d" x="30" y="440"></use>
              <use xlink:href="#unit-v" class="segment e" x="0" y="250"></use>
              <use xlink:href="#unit-v" class="segment f" x="0" y="30"></use>
              <use xlink:href="#unit-h" class="segment g" x="30" y="220"></use>
            </svg>
          </div>
        </div>
      </div>
      <button style="border-radius: 50%;position:absolute;right:50px; top:7px;" onclick="window.location.href='./faqs/faq.php'" class="dropbtn1" for="btnControl"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#ff5400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"></circle>
          <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
          <line x1="12" y1="17" x2="12.01" y2="17"></line>
        </svg></button>
      <section class="frame-parent">
        <div id="main">

          <!-- vizag -->
          <?php 
      if ($work_location == 'Visakhapatnam' || $work_location == 'All') {
        ?>
          <div class="frame-item" id="kanbanBoard1">
            <h3 class="check-inout">Employee's on Duty<span style="font-size:14px;margin-left:20px;">
                <div class="image-2024-01-17-154939738-rem-parent" style="scale:0.3;z-index:10000;">
                  <img class="image-2024-01-17-154939738-rem-icon" alt="" src="./public/image-20240117-154939738removebgpreview-1@2x.png" />

                  <div class="ellipse-container">
                    <div class="frame-child"></div>
                    <b class="b2"><?php echo $count1; ?></b>
                  </div>
                </div>
              </span></h3>
            <div class="frame-inner"></div>
            <div style="overflow-y: auto; overflow-x: hidden; height: 460px; width: 285px; margin-top: 60px;">
              <?php
              @include 'inc/config.php';
              if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
              }

              $sql = "SELECT e.UserID, e.empname, e.pic, c.AttendanceTime, c.InputType, c.AttendanceType
        FROM emp e
        JOIN (
            SELECT UserID, ServiceTagId, MIN(AttendanceTime) AS MinAttendanceTime
            FROM CamsBiometricAttendance
            WHERE DATE(AttendanceTime) = '$currentDate'
              AND AttendanceType = 'CheckIn'
            GROUP BY UserID, ServiceTagId
        ) AS min_attendance
        ON e.UserID = min_attendance.UserID 
        AND e.ServiceTagId = min_attendance.ServiceTagId
        JOIN CamsBiometricAttendance c 
        ON e.UserID = c.UserID 
        AND e.ServiceTagId = c.ServiceTagId
        AND (min_attendance.MinAttendanceTime = c.AttendanceTime OR c.AttendanceType = 'CheckOut')
        WHERE e.empstatus = 0 
          AND DATE(c.AttendanceTime) = '$currentDate'
          AND (c.AttendanceType = 'CheckOut' OR c.AttendanceType = 'CheckIn')
        ORDER BY c.AttendanceTime DESC";

              $result = $con->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $attendanceTime = strtotime($row['AttendanceTime']);
                  echo '<table style="margin-top: -60px;">
                  <tr>
                  <td style="display: block; margin-bottom: 15px; padding: 4px;">
                    <div style="z-index: 9999; margin-top: 60px; margin-left: 12px; border-radius: var(--br-mini); background-color: var(--color-white); box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25); width: 257px; height: 145px;"></div>';

                  if ($row['AttendanceType'] == 'CheckIn') {
                    echo '<div class="asdf"></div>';
                  } elseif ($row['AttendanceType'] == 'CheckOut') {
                    echo '<div class="qwer"></div>';
                  }
                  echo '<p style="font-size: 16px; margin-left: 33px; margin-top: -20px;">' . $row['AttendanceType'] . '</p>
                          <p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['empname'] . '</p>';
                  if (strtotime($row['AttendanceTime']) >= strtotime("13:00:00")) {
                    echo '<p style="font-size: 13px; margin-left: 30px; margin-top: -8px; color: black;">' . date("H:i:s", strtotime($row['AttendanceTime'])) . '</p>';
                  } elseif (strtotime($row['AttendanceTime']) > strtotime("9:40:00 AM")) {
                    echo '<p style="font-size: 13px; margin-left: 30px; margin-top: -8px; color: red;">' . date("H:i:s", strtotime($row['AttendanceTime'])) . '  &nbsp; [Late]' . '</p>';
                  } else {
                    echo '<p style="font-size: 13px; margin-left: 30px; margin-top: -8px; color: green;">' . date("H:i:s", strtotime($row['AttendanceTime'])) . '  &nbsp; [On-Time]' . '</p>';
                  }
                  echo '<p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['InputType'] . '</p>
                          <img class="hovpic" src="pics/' . $row['pic'] . '" width="50px" style="margin-top: -40px; margin-left: 200px; border-radius: 60%; height: 50px;" alt="">
                        </td>
                      </tr>       
            </table>';
                }
              } else {
                echo '<div style="text-align: center; margin-top: 50px; font-size: 18px;color:#097969;">No CheckIn/CheckOut today</div>';
              }
              $con->close();
              ?>

            </div>

            <dialog class="dialog" id="modal-option-1">
              <div class="dialog__wrapper">
                <button class="dialog__close">✕</button>
                <div class="send-email-parent" style="background-color:#EBECF0; border-radius:10px; padding:10px;">
                  <p>Employees yet to Check-In </p>
                  <div class="image-2024-01-17-154712686-rem-parent" style="scale:0.3;z-index:10;margin-top:70px;margin-left:112px;">
                    <img class="image-2024-01-17-154712686-rem-icon" alt="" src="./public/image-20240117-154712686removebgpreview-1@2x.png" />

                    <div class="ellipse-group">
                      <div class="frame-child"></div>
                      <b class="b"><?php echo $count5; ?></b>
                    </div>
                  </div>
                  <hr />
                  <?php
                  @include 'inc/config.php';
                  if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                  }
                  $sql = "SELECT *
                  FROM emp e
                  WHERE empstatus = 0
                  AND e.work_location = 'Visakhapatnam'
                  AND e.UserID != '0'
                    AND NOT EXISTS (
                        SELECT 1
                        FROM CamsBiometricAttendance c
                        WHERE e.UserID = c.UserID
                          AND DATE(c.AttendanceTime) = '$currentDate'
                          AND c.AttendanceType = 'CheckIn'
                    )
                    AND e.UserID NOT IN (
                        SELECT e.UserID
                        FROM emp e
                        JOIN leaves l ON e.empname = l.empname 
                        WHERE ((l.status = 1 AND l.status1 = 1) OR (l.status = 1 AND l.status1 = 0))
                          AND '$currentDate' BETWEEN DATE(l.from) AND DATE(l.to)
                        UNION
                        SELECT e.UserID
                        FROM absent a
                        JOIN emp e ON a.empname = e.empname
                        WHERE TIMESTAMP(DATE(a.AttendanceTime)) = '$currentDate'
                    )";



                  $result = $con->query($sql);

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo '<table style="margin-top: -60px; margin-left:-6px;">
                  <tr>
                  <td style="display: block; margin-bottom: 15px; padding: 4px;">
                    <div style="z-index: 9999; margin-top: 60px; margin-left: 12px; border-radius: var(--br-mini); background-color: var(--color-white); box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25); width: 257px; height: 145px;"></div>';

                      echo '<div class="qwer" style="width:130px;"></div>';
                      echo '<p style="font-size: 16px; margin-left: 33px; margin-top: -20px;">' . 'Yet to Check In' . '</p>
                          <p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['empname'] . '</p>';
                      echo '<p style="font-size: 13px; margin-left: 30px; margin-top: -8px; color: blue;">' . $row['empph'] . '</p>';
                      echo '<p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['desg'] . '</p>
                          <img class="hovpic" src="pics/' . $row['pic'] . '" width="50px" style="margin-top: -40px; margin-left: 200px; border-radius: 60%; height: 50px;" alt="">
                        </td>
                      </tr>       
            </table>';
                    }
                  } else {
                    echo '<div style="text-align: center; margin-top: 50px; font-size: 18px;color:#097969;">No employee to be CheckedIn</div>';
                  }
                  $con->close();
                  ?>
                </div>
              </div>
            </dialog>
          </div>

<?php
}
?>
          <!-- gurugram -->
          <?php 
        if ($work_location == 'All') {
          $displayStyle = 'display:none;';
      } else {
          $displayStyle = '';
      }
      if ($work_location == 'Gurugram' || $work_location == 'All') {
        ?>
          <div class="frame-item" id="kanbanBoard2" style="<?php echo $displayStyle; ?>">
            <h3 class="check-inout">Employee's on Duty<span style="font-size:14px;margin-left:20px;">
                <div class="image-2024-01-17-154939738-rem-parent" style="scale:0.3;z-index:10000;">
                  <img class="image-2024-01-17-154939738-rem-icon" alt="" src="./public/image-20240117-154939738removebgpreview-1@2x.png" />

                  <div class="ellipse-container">
                    <div class="frame-child"></div>
                    <b class="b2"><?php echo $count1_ggm; ?></b>
                  </div>
                </div>
              </span></h3>
            <div class="frame-inner"></div>
            <div style="overflow-y: auto; overflow-x: hidden; height: 460px; width: 285px; margin-top: 60px;">
              <?php
              @include 'inc/config.php';
              if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
              }

              $sql = "SELECT e.UserID, e.empname, e.pic, c.AttendanceTime, c.InputType, c.AttendanceType
        FROM emp e
        JOIN (
            SELECT UserID, ServiceTagId, MIN(AttendanceTime) AS MinAttendanceTime
            FROM CamsBiometricAttendance_GGM
            WHERE DATE(AttendanceTime) = '$currentDate'
              AND AttendanceType = 'CheckIn'
            GROUP BY UserID, ServiceTagId
        ) AS min_attendance
        ON e.UserID = min_attendance.UserID 
        AND e.ServiceTagId = min_attendance.ServiceTagId
        JOIN CamsBiometricAttendance_GGM c 
        ON e.UserID = c.UserID 
        AND e.ServiceTagId = c.ServiceTagId
        AND (min_attendance.MinAttendanceTime = c.AttendanceTime OR c.AttendanceType = 'CheckOut')
        WHERE e.empstatus = 0 
          AND DATE(c.AttendanceTime) = '$currentDate'
          AND (c.AttendanceType = 'CheckOut' OR c.AttendanceType = 'CheckIn')
        ORDER BY c.AttendanceTime DESC";

              $result = $con->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  $attendanceTime = strtotime($row['AttendanceTime']);
                  echo '<table style="margin-top: -60px;">
                  <tr>
                  <td style="display: block; margin-bottom: 15px; padding: 4px;">
                    <div style="z-index: 9999; margin-top: 60px; margin-left: 12px; border-radius: var(--br-mini); background-color: var(--color-white); box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25); width: 257px; height: 145px;"></div>';

                  if ($row['AttendanceType'] == 'CheckIn') {
                    echo '<div class="asdf"></div>';
                  } elseif ($row['AttendanceType'] == 'CheckOut') {
                    echo '<div class="qwer"></div>';
                  }
                  echo '<p style="font-size: 16px; margin-left: 33px; margin-top: -20px;">' . $row['AttendanceType'] . '</p>
                          <p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['empname'] . '</p>';
                  if (strtotime($row['AttendanceTime']) >= strtotime("13:00:00")) {
                    echo '<p style="font-size: 13px; margin-left: 30px; margin-top: -8px; color: black;">' . date("H:i:s", strtotime($row['AttendanceTime'])) . '</p>';
                  } elseif (strtotime($row['AttendanceTime']) > strtotime("9:40:00 AM")) {
                    echo '<p style="font-size: 13px; margin-left: 30px; margin-top: -8px; color: red;">' . date("H:i:s", strtotime($row['AttendanceTime'])) . '  &nbsp; [Late]' . '</p>';
                  } else {
                    echo '<p style="font-size: 13px; margin-left: 30px; margin-top: -8px; color: green;">' . date("H:i:s", strtotime($row['AttendanceTime'])) . '  &nbsp; [On-Time]' . '</p>';
                  }
                  echo '<p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['InputType'] . '</p>
                          <img class="hovpic" src="pics/' . $row['pic'] . '" width="50px" style="margin-top: -40px; margin-left: 200px; border-radius: 60%; height: 50px;" alt="">
                        </td>
                      </tr>       
            </table>';
                }
              } else {
                echo '<div style="text-align: center; margin-top: 50px; font-size: 18px;color:#097969;">No CheckIn/CheckOut today</div>';
              }
              $con->close();
              ?>

            </div>

            <dialog class="dialog" id="modal-option-11">
              <div class="dialog__wrapper">
                <button class="dialog__close">✕</button>
                <div class="send-email-parent" style="background-color:#EBECF0; border-radius:10px; padding:10px;">
                  <p>Employees yet to Check-In </p>
                  <div class="image-2024-01-17-154712686-rem-parent" style="scale:0.3;z-index:10;margin-top:70px;margin-left:112px;">
                    <img class="image-2024-01-17-154712686-rem-icon" alt="" src="./public/image-20240117-154712686removebgpreview-1@2x.png" />

                    <div class="ellipse-group">
                      <div class="frame-child"></div>
                      <b class="b"><?php echo $count5_ggm; ?></b>
                    </div>
                  </div>
                  <hr />
                  <?php
                  @include 'inc/config.php';
                  if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                  }
                  $sql = "SELECT *
                  FROM emp e
                  WHERE empstatus = 0
                  AND e.work_location = 'Gurugram'
                    AND NOT EXISTS (
                        SELECT 1
                        FROM CamsBiometricAttendance_GGM c
                        WHERE e.UserID = c.UserID
                          AND DATE(c.AttendanceTime) = '$currentDate'
                          AND c.AttendanceType = 'CheckIn'
                    )
                    AND e.UserID NOT IN (
                        SELECT e.UserID
                        FROM emp e
                        JOIN leaves l ON e.empname = l.empname 
                        WHERE ((l.status = 1 AND l.status1 = 1) OR (l.status = 1 AND l.status1 = 0))
                          AND '$currentDate' BETWEEN DATE(l.from) AND DATE(l.to)
                        UNION
                        SELECT e.UserID
                        FROM absent a
                        JOIN emp e ON a.empname = e.empname
                        WHERE TIMESTAMP(DATE(a.AttendanceTime)) = '$currentDate'
                    )";



                  $result = $con->query($sql);

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo '<table style="margin-top: -60px; margin-left:-6px;">
                  <tr>
                  <td style="display: block; margin-bottom: 15px; padding: 4px;">
                    <div style="z-index: 9999; margin-top: 60px; margin-left: 12px; border-radius: var(--br-mini); background-color: var(--color-white); box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25); width: 257px; height: 145px;"></div>';

                      echo '<div class="qwer" style="width:130px;"></div>';
                      echo '<p style="font-size: 16px; margin-left: 33px; margin-top: -20px;">' . 'Yet to Check In' . '</p>
                          <p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['empname'] . '</p>';
                      echo '<p style="font-size: 13px; margin-left: 30px; margin-top: -8px; color: blue;">' . $row['empph'] . '</p>';
                      echo '<p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['desg'] . '</p>
                          <img class="hovpic" src="pics/' . $row['pic'] . '" width="50px" style="margin-top: -40px; margin-left: 200px; border-radius: 60%; height: 50px;" alt="">
                        </td>
                      </tr>       
            </table>';
                    }
                  } else {
                    echo '<div style="text-align: center; margin-top: 50px; font-size: 18px;color:#097969;">No employee to be CheckedIn</div>';
                  }
                  $con->close();
                  ?>
                </div>
              </div>
            </dialog>
          </div>
          <?php
          }
          ?>
        </div>
        <!-- END OF GURUGRAM -->

        <!-- vizag -->
        <div id="kanbanBoard11">
        <?php 
      if ($work_location == 'Visakhapatnam' || $work_location == 'All') {
        ?>
          <div id="main1">

            <div class="frame-item" style="margin-left: 300px; z-index: 100;">
              <h3 class="check-inout" style=" z-index: 100;">Employee's on leave<span style="font-size:14px;margin-left:20px;">
                  <div class="image-2024-01-17-154424414-rem-parent" style="scale:0.3;z-index:10000;">
                    <img class="image-2024-01-17-154424414-rem-icon" alt="" src="./public/image-20240117-154424414removebgpreview-1@2x.png" />
                    <div class="ellipse-parent">
                      <div class="frame-child"></div>
                      <b class="b"><?php echo $count2; ?></b>
                    </div>
                  </div>
                </span></h3>
              <div class="frame-inner"></div>
              <div style="overflow-y: auto; height: 460px; width: 285px; margin-top: 60px; z-index: 99999 !important;">
                <?php
                include 'inc/config.php';

                function formatDateTime($dateTime)
                {
                  $formattedDate = date('Y-m-d', strtotime($dateTime));
                  return (substr($dateTime, 11) === '00:00:00') ? $formattedDate : $dateTime;
                }

                $sql = "SELECT e.empname, e.empph, e.pic, e.work_location, l.*
    FROM emp e
    JOIN leaves l ON e.empname = l.empname 
    WHERE e.empstatus = 0 
      AND e.work_location = 'Visakhapatnam'
      AND l.leavetype != 'WORK FROM HOME'
      AND ((l.status = 1 AND l.status1 = 1) OR (l.status = 1 AND l.status1 = 0))
      AND '$currentDate' BETWEEN DATE(l.from) AND DATE(l.to)
    ORDER BY l.mgrtime DESC";

                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    $fromDateTime = date('Y-m-d H:i:s', strtotime($row['from']));
                    $toDateTime = date('Y-m-d H:i:s', strtotime($row['to']));

                    echo '<table style="margin-top: -60px;">
      <tr>
          <td style="display: block; margin-bottom: 24px;">
              <div style="z-index: 9999; margin-top: 60px; margin-left: 12px; border-radius: var(--br-mini);background-color: var(--color-white);box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);width: 257px;height: 130px;"></div>
              <div style="z-index: 9999; margin-top: -120px; margin-left: 30px; border-radius: var(--br-8xs); background-color: var(--color-lavender);width: 148px; height: 24px;"></div>
              <p style="font-size: 16px; margin-left: 45px; margin-top: -20px;font-size:14px;">' . $row['leavetype'] . '</p>
              <p style="font-size: 12px; margin-left: 30px; margin-top: -8px;">' . $row['empname'] . '</p>
              <p style="font-size: 12px; margin-left: 30px; margin-top: -8px; width: 130px;">' . $row['empph'] . '</p>
              <p class="leave-request-datetime" style="font-size: 12px; margin-left: 30px; margin-top: -8px; width: 170px;">' .
                      formatDateTime($fromDateTime) . ' to ' . formatDateTime($toDateTime) . '</p>
              <img class="hovpic" src="pics/' . $row['pic'] . '" width="50px" style="margin-left: 200px; border-radius: 100px; margin-top: -40px;height:50px;" alt="">
          </td>
      </tr>
  </table>';
                  }
                } else {
                  echo '<div style="text-align: center; margin-top: 50px; font-size: 18px;color:#097969;">No employee on Leave today</div>';
                }

                $result->close();
                $con->close();
                ?>

              </div>
            </div>
          </div>
       
          <div id="main2">

            <div class="frame-item" style="margin-left: 600px; z-index: 100;">

              <h3 class="check-inout" style=" z-index: 100;">Absentees<span style="font-size:14px;margin-left:20px;">
                  <div class="image-2024-01-17-154712686-rem-parent" style="scale:0.3;z-index:10000;">
                    <img class="image-2024-01-17-154712686-rem-icon" alt="" src="./public/image-20240117-154712686removebgpreview-1@2x.png" />

                    <div class="ellipse-group">
                      <div class="frame-child"></div>
                      <b class="b"><?php echo $count3; ?></b>
                    </div>
                  </div>
                </span> </h3>
              <div class="frame-inner"></div>
              <div style="overflow-y: auto; height: 460px; width: 285px; margin-top: 60px; z-index: 99999 !important;">
                <?php
                @include 'inc/config.php';
                $sql = "SELECT a.empname, e.empph, e.pic, e.desg 
FROM absent a
JOIN emp e ON a.empname = e.empname
WHERE DATE(a.AttendanceTime) = '$currentDate' 
      AND e.work_location = 'Visakhapatnam'
 ";


                $result = $con->query($sql);
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo '<table style="margin-top: -60px;">
    <tr>
      <td style="display: block;margin-bottom: 15px;padding:4px;">
        <div style="z-index: 9999; margin-top: 60px; margin-left: 12px; border-radius: var(--br-mini);background-color: var(--color-white);box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);width: 257px;height: 120px;"></div>
        <div style="z-index: 9999; margin-top: -110px; margin-left: 30px; border-radius: var(--br-8xs); background-color: var(--color-lavender);width: 148px; height: 24px;"></div>
        <p style="font-size: 16px; margin-left: 30px; margin-top: -22px;font-size:14px;">' . $row['desg'] . '</p>
        <p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['empname'] . '</p>
        <p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['empph'] . '</p>
        <img class="hovpic" src="pics/' . $row['pic'] . '" width="50px" style="margin-top: -35px; margin-left: 190px; border-radius: 50px;height:50px;" alt="">
        </td>
      </td>
    </tr>
  </table>';
                  }
                } else {
                  echo '<div style="text-align: center; margin-top: 50px; font-size: 18px;color:#097969;">No absentees today</div>';
                }

                $con->close();
                ?>
              </div>
            </div>
          </div>
          <div id="main3">

            <div class="frame-item" style="margin-left: 900px; z-index: 100;">

              <h3 class="check-inout" style=" z-index: 100;">Employee Request's</h3>
              <div class="frame-inner" style=" z-index: 100;"></div>
              <div style="overflow-y: auto; height: 460px; width: 287px; margin-top: 60px; z-index: 99999 !important;">
                <?php
                include 'inc/config.php';
                $sql = "SELECT leaves.empname, leaves.applied, leaves.status, leaves.status1, emp.pic
FROM leaves
INNER JOIN emp ON leaves.empname = emp.empname
WHERE ((leaves.status = 0 AND leaves.status1 = 0) OR (leaves.status = 3 AND leaves.status1 = 0)OR (leaves.status = 4 AND leaves.status1 = 0))
AND emp.work_location = 'Visakhapatnam'
ORDER BY leaves.applied DESC";
                $result = mysqli_query($con, $sql);
                if ($result->num_rows > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    $status = $row['status'];
                    $status1 = $row['status1'];
                    echo '<table style="margin-top: -60px;">';
                    echo '<tr class="hover-dim">';
                    echo '<td style="display: block;margin-bottom: 5px;padding:4px;">';
                    echo '<a href="leave-management.php" style="text-decoration:none;color:black;">';
                    echo '<div style="z-index: 9999; margin-top: 60px; margin-left: 12px; border-radius: var(--br-mini);background-color: var(--color-white);box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);width: 257px;height: 130px;"></div>';
                    echo '<div style="z-index: 9999; margin-top: -120px; margin-left: 30px; border-radius: var(--br-8xs); background-color: var(--color-lightblue);width: 148px; height: 24px;"></div>';
                    echo '<p style="font-size: 14px; margin-left: 43px; margin-top: -22px;">Leave Request</p>';
                    echo '<p style="font-size: 12px; word-wrap:break-word; width:200px; margin-left: 30px; margin-top: -5px;">' . $row['empname'] . '</p>';
                    $formattedDate = date('H:i:s d-m-Y', strtotime($row['applied'] . ' + 12 hours 30 mins'));
                    echo '<p style="font-size: 12px; margin-left: 30px; margin-top: -5px; width: 130px;">[Pending from-</p>';
                    echo '<p style="font-size: 12px; margin-left: 30px; margin-top: -10px; width: 130px;">' . $formattedDate . ']</p>';
                    echo '<p style="font-size: 12px; margin-left: 30px; margin-top: -7px;">' .
                      (($status == '0' && $status1 == '0') ? 'HR-Action Pending' : (($status == '3' && $status1 == '0') ? 'Pending at Approver' : (($status == '4' && $status1 == '0') ? 'Pending at Manager' : ''))) . '</p>';
                    echo '<img class="hovpic" src="pics/' . $row['pic'] . '" width="50px" style="margin-top: -60px; margin-left: 190px; border-radius: 50px;height:50px;" alt="">';
                    echo '</a>';
                    echo '</td>';
                    echo '</tr>';
                    echo '</table>';
                  }
                  mysqli_free_result($result);
                } else {
                  echo '<div style="text-align: center; margin-top: 50px; font-size: 18px;color:#097969;">No requests today</div>';
                }
                mysqli_close($con);
                ?>

              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
        <!-- gurugram -->
        <?php 
        if ($work_location == 'All') {
          $displayStyle = 'display:none;';
      } else {
          $displayStyle = '';
      }
      if ($work_location == 'Gurugram' || $work_location == 'All') {
        ?>
        <div id="kanbanBoard21" style="<?php echo $displayStyle; ?>">
          <div id="main1">

            <div class="frame-item" style="margin-left: 300px; z-index: 100;">
              <h3 class="check-inout" style=" z-index: 100;">Employee's on leave<span style="font-size:14px;margin-left:20px;">
                  <div class="image-2024-01-17-154424414-rem-parent" style="scale:0.3;z-index:10000;">
                    <img class="image-2024-01-17-154424414-rem-icon" alt="" src="./public/image-20240117-154424414removebgpreview-1@2x.png" />
                    <div class="ellipse-parent">
                      <div class="frame-child"></div>
                      <b class="b"><?php echo $count2_ggm; ?></b>
                    </div>
                  </div>
                </span></h3>
              <div class="frame-inner"></div>
              <div style="overflow-y: auto; height: 460px; width: 285px; margin-top: 60px; z-index: 99999 !important;">
                <?php
                include 'inc/config.php';

                function formatDateTime1($dateTime)
                {
                  $formattedDate = date('Y-m-d', strtotime($dateTime));
                  return (substr($dateTime, 11) === '00:00:00') ? $formattedDate : $dateTime;
                }

                $sql = "SELECT e.empname, e.empph, e.pic, e.work_location, l.*
              FROM emp e
              JOIN leaves l ON e.empname = l.empname 
              WHERE e.empstatus = 0 
                AND e.work_location = 'Gurugram'
                AND ((l.status = 1 AND l.status1 = 1) OR (l.status = 1 AND l.status1 = 0))
                AND '$currentDate' BETWEEN DATE(l.from) AND DATE(l.to)
              ORDER BY l.mgrtime DESC";

                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    $fromDateTime = date('Y-m-d H:i:s', strtotime($row['from']));
                    $toDateTime = date('Y-m-d H:i:s', strtotime($row['to']));

                    echo '<table style="margin-top: -60px;">
                <tr>
                    <td style="display: block; margin-bottom: 24px;">
                        <div style="z-index: 9999; margin-top: 60px; margin-left: 12px; border-radius: var(--br-mini);background-color: var(--color-white);box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);width: 257px;height: 130px;"></div>
                        <div style="z-index: 9999; margin-top: -120px; margin-left: 30px; border-radius: var(--br-8xs); background-color: var(--color-lavender);width: 148px; height: 24px;"></div>
                        <p style="font-size: 16px; margin-left: 45px; margin-top: -20px;font-size:14px;">' . $row['leavetype'] . '</p>
                        <p style="font-size: 12px; margin-left: 30px; margin-top: -8px;">' . $row['empname'] . '</p>
                        <p style="font-size: 12px; margin-left: 30px; margin-top: -8px; width: 130px;">' . $row['empph'] . '</p>
                        <p class="leave-request-datetime" style="font-size: 12px; margin-left: 30px; margin-top: -8px; width: 170px;">' .
                      formatDateTime1($fromDateTime) . ' to ' . formatDateTime1($toDateTime) . '</p>
                        <img class="hovpic" src="pics/' . $row['pic'] . '" width="50px" style="margin-left: 200px; border-radius: 100px; margin-top: -40px;height:50px;" alt="">
                    </td>
                </tr>
            </table>';
                  }
                } else {
                  echo '<div style="text-align: center; margin-top: 50px; font-size: 18px;color:#097969;">No employee on Leave today</div>';
                }

                $result->close();
                $con->close();
                ?>

              </div>
            </div>
          </div>
          <div id="main2">

            <div class="frame-item" style="margin-left: 600px; z-index: 100;">

              <h3 class="check-inout" style=" z-index: 100;">Absentees<span style="font-size:14px;margin-left:20px;">
                  <div class="image-2024-01-17-154712686-rem-parent" style="scale:0.3;z-index:10000;">
                    <img class="image-2024-01-17-154712686-rem-icon" alt="" src="./public/image-20240117-154712686removebgpreview-1@2x.png" />

                    <div class="ellipse-group">
                      <div class="frame-child"></div>
                      <b class="b"><?php echo $count3_ggm; ?></b>
                    </div>
                  </div>
                </span> </h3>
              <div class="frame-inner"></div>
              <div style="overflow-y: auto; height: 460px; width: 285px; margin-top: 60px; z-index: 99999 !important;">
                <?php
                @include 'inc/config.php';
                $sql = "SELECT a.empname, e.empph, e.pic, e.desg 
        FROM absent a
    
        JOIN emp e ON a.empname = e.empname
        WHERE DATE(a.AttendanceTime) = '$currentDate' 
            AND e.work_location = 'Gurugram'
         ";


                $result = $con->query($sql);
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo '<table style="margin-top: -60px;">
              <tr>
                <td style="display: block;margin-bottom: 15px;padding:4px;">
                  <div style="z-index: 9999; margin-top: 60px; margin-left: 12px; border-radius: var(--br-mini);background-color: var(--color-white);box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);width: 257px;height: 120px;"></div>
                  <div style="z-index: 9999; margin-top: -110px; margin-left: 30px; border-radius: var(--br-8xs); background-color: var(--color-lavender);width: 148px; height: 24px;"></div>
                  <p style="font-size: 16px; margin-left: 30px; margin-top: -22px;font-size:14px;">' . $row['desg'] . '</p>
                  <p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['empname'] . '</p>
                  <p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['empph'] . '</p>
                  <img class="hovpic" src="pics/' . $row['pic'] . '" width="50px" style="margin-top: -35px; margin-left: 190px; border-radius: 50px;height:50px;" alt="">
                  </td>
                </td>
              </tr>
            </table>';
                  }
                } else {
                  echo '<div style="text-align: center; margin-top: 50px; font-size: 18px;color:#097969;">No absentees today</div>';
                }

                $con->close();
                ?>
              </div>
            </div>
          </div>
          <div id="main3">

            <div class="frame-item" style="margin-left: 900px; z-index: 100;">

              <h3 class="check-inout" style=" z-index: 100;">Employee Request's</h3>
              <div class="frame-inner" style=" z-index: 100;"></div>
              <div style="overflow-y: auto; height: 460px; width: 287px; margin-top: 60px; z-index: 99999 !important;">
                <?php
                include 'inc/config.php';
                $sql = "SELECT leaves.empname, leaves.applied, leaves.status, leaves.status1, emp.pic
        FROM leaves
        INNER JOIN emp ON leaves.empname = emp.empname
        WHERE ((leaves.status = 0 AND leaves.status1 = 0) OR (leaves.status = 3 AND leaves.status1 = 0)OR (leaves.status = 4 AND leaves.status1 = 0))
        AND emp.work_location = 'Gurugram'
        ORDER BY leaves.applied DESC";
                $result = mysqli_query($con, $sql);
                if ($result->num_rows > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    $status = $row['status'];
                    $status1 = $row['status1'];
                    echo '<table style="margin-top: -60px;">';
                    echo '<tr class="hover-dim">';
                    echo '<td style="display: block;margin-bottom: 5px;padding:4px;">';
                    echo '<a href="leave-management.php" style="text-decoration:none;color:black;">';
                    echo '<div style="z-index: 9999; margin-top: 60px; margin-left: 12px; border-radius: var(--br-mini);background-color: var(--color-white);box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);width: 257px;height: 130px;"></div>';
                    echo '<div style="z-index: 9999; margin-top: -120px; margin-left: 30px; border-radius: var(--br-8xs); background-color: var(--color-lightblue);width: 148px; height: 24px;"></div>';
                    echo '<p style="font-size: 14px; margin-left: 43px; margin-top: -22px;">Leave Request</p>';
                    echo '<p style="font-size: 12px; word-wrap:break-word; width:200px; margin-left: 30px; margin-top: -5px;">' . $row['empname'] . '</p>';
                    $formattedDate = date('H:i:s d-m-Y', strtotime($row['applied']));
                    echo '<p style="font-size: 12px; margin-left: 30px; margin-top: -5px; width: 130px;">[Pending from-</p>';
                    echo '<p style="font-size: 12px; margin-left: 30px; margin-top: -10px; width: 130px;">' . $formattedDate . ']</p>';
                    echo '<p style="font-size: 12px; margin-left: 30px; margin-top: -7px;">' .
                      (($status == '0' && $status1 == '0') ? 'HR-Action Pending' : (($status == '3' && $status1 == '0') ? 'Pending at Approver' : (($status == '4' && $status1 == '0') ? 'Pending at Manager' : ''))) . '</p>';
                    echo '<img class="hovpic" src="pics/' . $row['pic'] . '" width="50px" style="margin-top: -60px; margin-left: 190px; border-radius: 50px;height:50px;" alt="">';
                    echo '</a>';
                    echo '</td>';
                    echo '</tr>';
                    echo '</table>';
                  }
                  mysqli_free_result($result);
                } else {
                  echo '<div style="text-align: center; margin-top: 50px; font-size: 18px;color:#097969;">No requests today</div>';
                }
                mysqli_close($con);
                ?>

              </div>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
        <!-- end of gurugram  -->
        <?php 
      if ($work_location == 'Visakhapatnam' || $work_location == 'All') {
        ?>
        <div id="count" class="chart" style="display: flex; gap: 20px; margin-left: 400px; width: 335px; margin-top: 520px;">
          <div class="frame-item" style="height: 340px; margin-top: 540px; margin-left: 300px; width: 584px;"></div>
          <canvas id="myChart1" style="width: 500px; height: 400px; margin-top: 90px; z-index: 999999;"></canvas>
          <!--<canvas id="myChart" style="margin-top: 20px; z-index: 999999;"></canvas>-->
          <div style="z-index: 999999999; background-color: white; height: 40px; width: 270px; margin-left: -400px; margin-top: 30px; border-radius: 10px; display: flex; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);">
            <img src="./public/groupicon.png" width="62px" height="60px" style="margin-top: -12px;" alt="">
            <p style="font-size: 14px;margin-top: 8px;margin-left:-10px;">Total Active Employee's => <sub style="font-size: 20px; font-weight: 600;background:#FB8C0B;border-radius:20%;color:white;padding:04px;">
                <?php echo $count4; ?></sub></p>
          </div>
        </div>
        <?php
      }?>
        <!-- gurugram -->
        <?php 
        if ($work_location == 'All') {
          $displayStyle = 'display:none;';
      } else {
          $displayStyle = '';
      }
      if ($work_location == 'Gurugram' || $work_location == 'All') {
        ?>
        <div id="count1" class="chart" style="<?php echo $displayStyle; ?> display: flex; gap: 20px; margin-left: 400px; width: 335px; margin-top: 520px;">
          <div class="frame-item" style="height: 340px; margin-top: 540px; margin-left: 300px; width: 584px;"></div>
          <canvas id="myChartG" style="width: 500px; height: 400px; margin-top: 90px; z-index: 999999;"></canvas>
          <!--<canvas id="myChart" style="margin-top: 20px; z-index: 999999;"></canvas>-->
          <div style="z-index: 999999999; background-color: white; height: 40px; width: 270px; margin-left: -400px; margin-top: 30px; border-radius: 10px; display: flex; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);">
            <img src="./public/groupicon.png" width="62px" height="60px" style="margin-top: -12px;" alt="">
            <p style="font-size: 14px;margin-top: 8px;margin-left:-10px;">Total Active Employee's => <sub style="font-size: 20px; font-weight: 600;background:#FB8C0B;border-radius:20%;color:white;padding:04px;">
                <?php echo $count4_ggm; ?></sub></p>
          </div>
        </div>
        <?php
      }?>


        <div id="main4">
        <?php 
      if ($work_location == 'Visakhapatnam' || $work_location == 'All') {
        ?>
          <div id="kanbanBoard111" class="frame-item" style="  margin-top: 540px; margin-left:900px; height: 340px;">
            <h3 class="check-inout">Birthday's</h3>
            <div class="frame-inner"></div>
            <div style="position:absolute;overflow-y: auto; height: 270px; width: 285px; margin-top: 60px; background-color: white; width: 270px; margin-left: 7px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);">
              <?php
              include('inc/config.php');

              $query = "SELECT pic, empname, empdob, empstatus, work_location 
          FROM emp 
          WHERE empstatus = 0 
          AND work_location = 'Visakhapatnam'
          AND empdob != '0000-00-00'
          ORDER BY MONTH(empdob), DAY(empdob)";


              $result = mysqli_query($con, $query);

              if ($result) {
                $todayData = '';
                $otherData = '';

                while ($row = mysqli_fetch_assoc($result)) {
                  $limitedEmpName = substr($row['empname'], 0, 13);
                  $formattedEmpDob = date('M, d', strtotime($row['empdob']));
                  $isCurrentDate = date('M, d') == $formattedEmpDob;
                  $trBackgroundColor = $isCurrentDate ? 'background: url(https://i.pinimg.com/originals/9a/1c/94/9a1c94e764a96733ff449a592bb64cfb.jpg);background-size: cover;outline:2px solid #ad8047;border-radius:25px;' : '';
                  $trPicColor = $isCurrentDate ? 'outline:1px solid  #FFCC33;border-radius:30px;' : '';

                  $rowData = '<table>
                        <tr >
                            <td></td>
                            <td> <img class="hovpic1" src="pics/' . $row['pic'] . '" width="30px" style="border-radius: 50px;' . $trPicColor . '" alt=""> </td>
                            <td style="font-size: 14px;' . $trBackgroundColor . '"><input type="text" value=" ' . $limitedEmpName . ' "  style="width:150px; border:none; pointer-events:none; background:transparent;/></td>
                            <td style="font-size: 14px; margin-top:12px; float:right;' . $trBackgroundColor . '">' . $formattedEmpDob . '</td>
                        </tr>
                    </table>';

                  if ($isCurrentDate) {
                    $todayData .= $rowData;
                  } else {
                    $otherData .= $rowData;
                  }
                }

                echo $todayData . $otherData;
                mysqli_free_result($result);
              } else {
                echo "Error: " . mysqli_error($con);
              }

              mysqli_close($con);
              ?>
            </div>
          </div>
          <?php
      }?>

<?php 
        if ($work_location == 'All') {
          $displayStyle = 'display:none;';
      } else {
          $displayStyle = '';
      }
      if ($work_location == 'Gurugram' || $work_location == 'All') {
        ?>
          <div id="kanbanBoard211" class="frame-item" style=" <?php echo $displayStyle; ?> margin-top: 540px; margin-left:900px; height: 340px; ">
            <h3 class="check-inout">Birthday's</h3>
            <div class="frame-inner"></div>
            <div style="position:absolute;overflow-y: auto; height: 270px; width: 285px; margin-top: 60px; background-color: white; width: 270px; margin-left: 7px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);">
              <?php
              include('inc/config.php');

              $query = "SELECT pic, empname, empdob, empstatus, work_location FROM emp WHERE empstatus = 0 
              AND work_location='Gurugram'
              ORDER BY MONTH(empdob), DAY(empdob)";

              $result = mysqli_query($con, $query);

              if ($result) {
                $todayData = '';
                $otherData = '';

                while ($row = mysqli_fetch_assoc($result)) {
                  $limitedEmpName = substr($row['empname'], 0, 13);
                  $formattedEmpDob = date('M, d', strtotime($row['empdob']));
                  $isCurrentDate = date('M, d') == $formattedEmpDob;
                  $trBackgroundColor = $isCurrentDate ? 'background: url(https://i.pinimg.com/originals/9a/1c/94/9a1c94e764a96733ff449a592bb64cfb.jpg);background-size: cover;outline:2px solid #ad8047;border-radius:25px;' : '';
                  $trPicColor = $isCurrentDate ? 'outline:1px solid  #FFCC33;border-radius:30px;' : '';

                  $rowData = '<table>
                        <tr >
                            <td></td>
                            <td> <img class="hovpic1" src="pics/' . $row['pic'] . '" width="30px" style="border-radius: 50px;' . $trPicColor . '" alt=""> </td>
                            <td style="font-size: 14px;' . $trBackgroundColor . '"><input type="text" value=" ' . $limitedEmpName . ' "  style="width:150px; border:none; pointer-events:none; background:transparent;/></td>
                            <td style="font-size: 14px; margin-top:12px; float:right;' . $trBackgroundColor . '">' . $formattedEmpDob . '</td>
                        </tr>
                    </table>';

                  if ($isCurrentDate) {
                    $todayData .= $rowData;
                  } else {
                    $otherData .= $rowData;
                  }
                }

                echo $todayData . $otherData;
                mysqli_free_result($result);
              } else {
                echo "Error: " . mysqli_error($con);
              }

              mysqli_close($con);
              ?>
            </div>
          </div>
          <?php
          }?>
        </div>
        <!-- vizag -->
        <?php 
      if ($work_location == 'Visakhapatnam' || $work_location == 'All') {
        ?>
        <div id="main5" class="main5">
          <div class="frame-item" style="  margin-top: 540px; height: 340px;">
            <h3 class="check-inout">Stats</h3>
            <div class="frame-inner"></div>
            <div style="position:absolute;overflow-y: hidden; height: 270px; width: 285px; margin-top: 60px; background-color: white; width: 270px; margin-left: 7px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);">
              <p style="font-size:18px; margin-left:13px; padding-bottom:5px; border-bottom: 1px solid rgba(223, 223, 223, 0.397);">Employee's on Duty <span style="margin-left:20px;">=> <b><?php echo $count1; ?></b></span></p>
              <p style="font-size:13px; margin-left:28px; padding-bottom:5px; border-bottom: 1px solid rgba(223, 223, 223, 0.397);">|-> Checked In Employee's <span style="margin-left:20px;">=> <b><?php echo $count1; ?></b></span></p>
              <p style="font-size:13px; margin-left:0px; padding-bottom:5px; border-bottom: 1px solid rgba(223, 223, 223, 0.397);"><a href="#modal-option-1" style="position:relative;top:4;border-bottom:10px solid white !important;"><svg class="circleAnimate" xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 24 24" fill="none" stroke="#F46214" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                  </svg></a> |-> Yet to CheckIn Employee's <span style="margin-left:0px;">=> <b><?php echo $count5; ?></b></span></p>
              <p style="font-size:18px; margin-left:13px; padding-bottom:5px; border-bottom: 1px solid rgba(223, 223, 223, 0.397);">Employee's on Leave <span style="margin-left:10px;">=> <b><?php echo $count2; ?></b></span></p>
              <p style="font-size:18px; margin-left:13px; padding-bottom:5px; border-bottom: 3px solid rgba(223, 223, 223, 0.597);">Absentees <span style="margin-left:97px;">=> <b><?php echo $count3; ?></b></span></p>
              <p style="font-size:18px; margin-left:10px;margin-top:-5px;">Workforce Status <span style="margin-left:40px;font-size:22px;">=> <b style="background:#FB8C0B;border-radius:20%;color:white;padding:4px;"><?php echo $count1 + $count21 + $count3 + $count5; ?></b></span></p>

            </div>
          </div>
        </div>
        <?php
        }?>
        <!-- gurugram -->
        <?php 
        if ($work_location == 'All') {
          $displayStyle = 'display:none;';
      } else {
          $displayStyle = '';
      }
      if ($work_location == 'Gurugram' || $work_location == 'All') {
        ?>
     <div id="main51" style="<?php echo $displayStyle; ?>" class="main51">
          <div class="frame-item" style="  margin-top: 540px; height: 340px;">
            <h3 class="check-inout">Stats</h3>
            <div class="frame-inner"></div>
            <div style="position:absolute;overflow-y: hidden; height: 270px; width: 285px; margin-top: 60px; background-color: white; width: 270px; margin-left: 7px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);">
              <p style="font-size:18px; margin-left:13px; padding-bottom:5px; border-bottom: 1px solid rgba(223, 223, 223, 0.397);">Employee's on Duty <span style="margin-left:20px;">=> <b><?php echo $count1_ggm; ?></b></span></p>
              <p style="font-size:13px; margin-left:28px; padding-bottom:5px; border-bottom: 1px solid rgba(223, 223, 223, 0.397);">|-> Checked In Employee's <span style="margin-left:20px;">=> <b><?php echo $count1_ggm; ?></b></span></p>
              <p style="font-size:13px; margin-left:0px; padding-bottom:5px; border-bottom: 1px solid rgba(223, 223, 223, 0.397);"><a href="#modal-option-11" style="position:relative;top:4;border-bottom:10px solid white !important;"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 24 24" fill="none" stroke="#F46214" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="16" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12.01" y2="8"></line>
                  </svg></a> |-> Yet to CheckIn Employee's <span style="margin-left:0px;">=> <b><?php echo $count5_ggm; ?></b></span></p>
              <p style="font-size:18px; margin-left:13px; padding-bottom:5px; border-bottom: 1px solid rgba(223, 223, 223, 0.397);">Employee's on Leave <span style="margin-left:10px;">=> <b><?php echo $count21_ggm; ?></b></span></p>
              <p style="font-size:18px; margin-left:13px; padding-bottom:5px; border-bottom: 3px solid rgba(223, 223, 223, 0.597);">Absentees <span style="margin-left:97px;">=> <b><?php echo $count3_ggm; ?></b></span></p>
              <p style="font-size:18px; margin-left:10px;margin-top:-5px;">Workforce Status <span style="margin-left:40px;font-size:22px;">=> <b style="background:#FB8C0B;border-radius:20%;color:white;padding:4px;"><?php echo $count1_ggm + $count21_ggm + $count3_ggm + $count5_ggm; ?></b></span></p>

            </div>
          </div>
        </div>
        <?php
      }?>
      </section>
    </div>
    <img class="tablerlogout-icon18" alt="" src="./public/tablerlogout.svg" />
  </div>
  <?php
  @include 'inc/config.php';
  $sql1 = "SELECT COUNT(*) as count
  FROM emp e 
  JOIN CamsBiometricAttendance c ON e.UserID = c.UserID
  WHERE empstatus = 0
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

  $result1 = $con->query($sql1);
  $row1 = $result1->fetch_assoc();
  $count1 = $row1['count'];
  $sql2 = "SELECT COUNT(*) as count
         FROM emp e
         JOIN leaves l ON e.empname = l.empname 
         WHERE empstatus = 0
           AND ((l.status = 1 AND l.status1 = 1) OR (l.status = 1 AND l.status1 = 0))
           AND '$currentDate' BETWEEN DATE(l.from) AND DATE(l.to)";

  $result2 = $con->query($sql2);
  $row2 = $result2->fetch_assoc();
  $count2 = $row2['count'];

  $sql3 = "SELECT COUNT(*) as count FROM absent a
        JOIN emp e ON a.empname = e.empname
        WHERE TIMESTAMP(DATE(AttendanceTime)) = '$currentDate'  ";

  $result3 = $con->query($sql3);
  $row3 = $result3->fetch_assoc();
  $count3 = $row3['count'];

  $sql4 = "SELECT COUNT(*) as count FROM emp WHERE empstatus = 0";

  $result4 = $con->query($sql4);
  $row4 = $result4->fetch_assoc();
  $count4 = $row4['count'];
  $con->close();
  ?>
</body>

<script>
  document.getElementById('toggle').addEventListener('change', function() {
    if (this.checked) {
      document.getElementById('kanbanBoard1').style.display = 'none';
      document.getElementById('kanbanBoard11').style.display = 'none';
      document.getElementById('kanbanBoard111').style.display = 'none';
      document.getElementById('count').style.display = 'none';
      document.getElementById('count1').style.display = 'flex';
      document.getElementById('main51').style.display = 'flex';
      document.getElementById('kanbanBoard2').style.display = 'flex';
      document.getElementById('kanbanBoard21').style.display = 'flex';
      document.getElementById('kanbanBoard211').style.display = 'flex';
    } else {
      document.getElementById('kanbanBoard1').style.display = 'flex';
      document.getElementById('kanbanBoard11').style.display = 'flex';
      document.getElementById('kanbanBoard111').style.display = 'flex';
      document.getElementById('count').style.display = 'flex';
      document.getElementById('count1').style.display = 'none';
      document.getElementById('main51').style.display = 'none';
      document.getElementById('kanbanBoard2').style.display = 'none';
      document.getElementById('kanbanBoard21').style.display = 'none';
      document.getElementById('kanbanBoard211').style.display = 'none';
    }
  });
</script>

<script>
  var box = document.getElementById('box');
  var down = false;

  function toggleNotifi() {
    if (down) {
      box.style.height = '60px';
      box.style.opacity = 0;
      down = false;
    } else {
      var notifiItems = document.getElementsByClassName('notifi-item');
      var totalHeight = 0;

      for (var i = 0; i < notifiItems.length; i++) {
        totalHeight += notifiItems[i].offsetHeight;
      }

      box.style.height = totalHeight + 'px';
      box.style.opacity = 1;
      down = true;
    }
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-piechart-outlabels@0.1.4/dist/chartjs-plugin-piechart-outlabels.min.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js'></script>
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
  function changeTime() {
    var hour = moment().format("HH");
    var minute = moment().format("mm");
    var second = moment().format("ss");

    document.getElementById("hour-1").setAttribute("class", "num-" + hour.substr(0, 1));
    document.getElementById("hour-2").setAttribute("class", "num-" + hour.substr(1, 1));
    document.getElementById("minute-1").setAttribute("class", "num-" + minute.substr(0, 1));
    document.getElementById("minute-2").setAttribute("class", "num-" + minute.substr(1, 1));
    document.getElementById("second-1").setAttribute("class", "num-" + second.substr(0, 1));
    document.getElementById("second-2").setAttribute("class", "num-" + second.substr(1, 1));

    setTimeout(changeTime, 1000);
  }

  changeTime();
</script>
<script>
  var maxCount = <?php echo ceil($count4); ?>;
  maxCount = Math.ceil(maxCount);
</script>
<script>
  var ctx = document.getElementById('myChart').getContext('2d');
  var count = Math.ceil(<?php echo $count4; ?>);
  var chart = new Chart(ctx, {
    type: 'polarArea',
    labels: ["Absentees", "Employee's on leave", "Employee's on Duty"],
    data: {
      datasets: [{
        label: 'EMS',
        data: [<?php echo $count3; ?>, <?php echo $count2; ?>, <?php echo $count1; ?>],
        backgroundColor: [
          'rgba(255, 99, 132, 0.4)',
          'rgba(54, 162, 235, 0.4)',
          'rgba(154, 255, 132, 0.4)',
        ],
        borderColor: [
          'rgba(255, 80, 132, 1)',
          'rgba(54, 70, 235, 1)',
          'rgba(154, 255, 13, 9)',
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        r: {
          beginAtZero: true,
          max: maxCount,
          ticks: {
            stepSize: 1,
          },
        }
      }
    }
  });
</script>
<script>
  var ctx = document.getElementById('myChart1').getContext('2d');
  var chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["Employee's on Duty", "Employee's on leave", "Absentees"],
      datasets: [{
        data: [<?php echo $count1; ?>, <?php echo $count2; ?>, <?php echo $count3; ?>],
        backgroundColor: [
          'rgba(154, 255, 132, 0.4)',
          'rgba(54, 162, 235, 0.4)',
          'rgba(255, 99, 132, 0.4)',
        ],
        borderColor: [
          'rgba(154, 255, 13, 9)',
          'rgba(54, 70, 235, 1)',
          'rgba(255, 80, 132, 1)',
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          max: maxCount,
          ticks: {
            stepSize: 1,
          },
        },
      },
      plugins: {
        legend: {
          display: false,
        },
      },
    }
  });
</script>

<!-- gurugram -->
<script>
  var ctx = document.getElementById('myChartG').getContext('2d');
  var chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["Employee's on Duty", "Employee's on leave", "Absentees"],
      datasets: [{
        data: [<?php echo $count1_ggm; ?>, <?php echo $count2_ggm; ?>, <?php echo $count3_ggm; ?>],
        backgroundColor: [
          'rgba(154, 255, 132, 0.4)',
          'rgba(54, 162, 235, 0.4)',
          'rgba(255, 99, 132, 0.4)',
        ],
        borderColor: [
          'rgba(154, 255, 13, 9)',
          'rgba(54, 70, 235, 1)',
          'rgba(255, 80, 132, 1)',
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          max: maxCount,
          ticks: {
            stepSize: 1,
          },
        },
      },
      plugins: {
        legend: {
          display: false,
        },
      },
    }
  });
</script>
<script>
  var ctx = document.getElementById('myChart2').getContext('2d');
  var chart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ["Employee's on Duty", "Employee's on leave", "Absentees"],
      datasets: [{
        data: [<?php echo $count1; ?>, <?php echo $count2; ?>, <?php echo $count3; ?>],
        backgroundColor: [
          'rgba(154, 255, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 99, 132, 0.2)',
        ],
        borderColor: [
          'rgba(154, 255, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 99, 132, 1)',
        ],
        borderWidth: 1
      }]
    },
    options: {
      plugins: {
        legend: {
          display: false,
        },
      },
      tooltips: {
        enabled: false
      },
      animation: {
        animateRotate: true,
        animateScale: true
      }
    }
  });
</script>
<script>
  var employeeList = document.getElementById("employeeList");
  if (employeeList) {
    employeeList.addEventListener("click", function(e) {
      window.location.href = "./employee-management.php";
    });
  }

  var leaves = document.getElementById("leaves");
  if (leaves) {
    leaves.addEventListener("click", function(e) {
      window.location.href = "./leave-management.php";
    });
  }

  var onboarding = document.getElementById("onboarding");
  if (onboarding) {
    onboarding.addEventListener("click", function(e) {
      window.location.href = "./onboarding.php";
    });
  }

  var attendance = document.getElementById("attendance");
  if (attendance) {
    attendance.addEventListener("click", function(e) {
      window.location.href = "./attendence.php";
    });
  }

  var fluentpeople32Regular = document.getElementById("fluentpeople32Regular");
  if (fluentpeople32Regular) {
    fluentpeople32Regular.addEventListener("click", function(e) {
      window.location.href = "./employee-management.php";
    });
  }

  var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
  if (fluentMdl2leaveUser) {
    fluentMdl2leaveUser.addEventListener("click", function(e) {
      window.location.href = "./onboarding.php";
    });
  }

  var fluentpersonClock20Regular = document.getElementById(
    "fluentpersonClock20Regular"
  );
  if (fluentpersonClock20Regular) {
    fluentpersonClock20Regular.addEventListener("click", function(e) {
      window.location.href = "./leave-management.php";
    });
  }

  var uitcalender = document.getElementById("uitcalender");
  if (uitcalender) {
    uitcalender.addEventListener("click", function(e) {
      window.location.href = "./documents.php";
    });
  }

  var leavesList = document.getElementById("leavesList");
  if (leavesList) {
    leavesList.addEventListener("click", function(e) {
      window.location.href = "./leave-management.php";
    });
  }

  var attendanceReport = document.getElementById("attendanceReport");
  if (attendanceReport) {
    attendanceReport.addEventListener("click", function(e) {
      window.location.href = "./documents.php";
    });
  }

  var onboarding1 = document.getElementById("onboarding1");
  if (onboarding1) {
    onboarding1.addEventListener("click", function(e) {
      window.location.href = "./onboarding.php";
    });
  }

  var employeeList1 = document.getElementById("employeeList1");
  if (employeeList1) {
    employeeList1.addEventListener("click", function(e) {
      window.location.href = "./employee-management.php";
    });
  }

  var applyLeave = document.getElementById("applyLeave");
  if (applyLeave) {
    applyLeave.addEventListener("click", function(e) {
      window.location.href = "./apply-leave.html";
    });
  }

  var solarnotesOutline = document.getElementById("solarnotesOutline");
  if (solarnotesOutline) {
    solarnotesOutline.addEventListener("click", function(e) {
      window.location.href = "./leave-management.php";
    });
  }

  var ionperson = document.getElementById("ionperson");
  if (ionperson) {
    ionperson.addEventListener("click", function(e) {
      window.location.href = "./designation.php";
    });
  }

  var fluentpersonClock24Filled = document.getElementById(
    "fluentpersonClock24Filled"
  );
  if (fluentpersonClock24Filled) {
    fluentpersonClock24Filled.addEventListener("click", function(e) {
      window.location.href = "./apply-leave.html";
    });
  }

  var uiscalender = document.getElementById("uiscalender");
  if (uiscalender) {
    uiscalender.addEventListener("click", function(e) {
      window.location.href = "./documents.php";
    });
  }

  var fluentpersonArrowBack28Fi = document.getElementById(
    "fluentpersonArrowBack28Fi"
  );
  if (fluentpersonArrowBack28Fi) {
    fluentpersonArrowBack28Fi.addEventListener("click", function(e) {
      window.location.href = "./onboarding.php";
    });
  }
</script>
</body>

</html>