<?php
session_start();
@include 'inc/config.php';

if (empty($_SESSION['user_name']) && empty($_SESSION['name'])) {
  header('location:loginpage.php');
  exit();
}

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
if (empty($user_name)) {
  header('location:loginpage.php');
  exit();
}


$query = "SELECT uf.*, m.status as manager_status 
              FROM user_form uf
              LEFT JOIN manager m ON uf.email = m.email 
              WHERE uf.email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if ($row && isset($row['user_type'])) {
    $user_type = $row['user_type'];

    if ($user_type !== 'admin' && $user_type !== 'user') {
      header('location:loginpage.php');
      exit();
    }
    if ($user_type === 'user' && empty($row['manager_status'])) {
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
  <link rel="stylesheet" href="./css/leave-management.css" />
  <link rel="stylesheet" href="./css/attendence.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
  <style>
    table {
      z-index: 100;
      border-collapse: collapse;
      /* border-radius: 200px; */
      background-color: white;
      /*   overflow: hidden; */
    }

    th,
    td {
      padding: 1em;
      background: white;
      color: rgb(52, 52, 52);
      border-bottom: 2px solid rgb(193, 193, 193);
    }

    .dropbtn {
      background-color: #45C380;
      color: #ffffff;
      padding: 16px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px #45C380;
    }

    .dropdown-content {
      position: absolute;
      background-color: #f9f9f9;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 98;
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

    .hovpic {
      transition: all 0.5s ease-in-out;
    }


    .hovpic:hover {
      transform: scale(3, 3);
    }
  </style>
</head>

<body>
  <div class="leavemanagement">
    <div class="bg16"></div>
    <!--<div class="rectangle-parent25" style="margin-left: 180px;">-->
    <!--  <div class="frame-child215"></div>-->
      <!-- <div class="dropdown">
        <button class="attendence5" style="margin-left: -350px; border: none; background: none; margin-top: -14px;" for="btnControl"><img src="./public/9710841.png" width="50px" alt="">
          <div class="dropdown-content" style="margin-left: -60px; border-radius: 20px;">
            <a href="holiday.php" style="font-size:15px; border-bottom: 2px solid rgb(185,185,185)">Holidays</a>
            <?php if ($user_name === 'prabhdeep.singh@teknoscan.co.in' || $user_name === 'it@anikasterilis.com') {
              echo '<a href="Approval-mob.php?email=prabhdeep.singh@teknoscan.co.in"  target="_blank" style="font-size:15px">Pending Approvals</a>';
            }  ?>
          </div>
      </button></div> -->
    <!--  <a class="frame-child216"></a>-->
    <!--  <a class="frame-child217" href="Approval-mob.php" id="rectangleLink1"> </a>-->
    <!--  <a class="leaves-list5" style="margin-top:-4px;">Leaves List</a>-->
    <!--  <a class="assign-leave5" href="Approval-mob.php" style="margin-top:-4px;  margin-left:10px;" id="assignLeave">Approvals</a>-->

    <!--</div>-->
    <img class="leavemanagement-child" alt="" src="./public/rectangle-1@2x.png" />

    <img class="leavemanagement-item" alt="" src="./public/rectangle-2@2x.png" />

    <img class="logo-1-icon16" alt="" src="./public/logo-1@2x.png" />

    <a class="anikahrm16" href="./dash_mgr.php" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm16">HRM</span>
    </a>
    <a class="leave-management4" href="./dash_mgr.php" id="leaveManagement">Leave Management</a>
    <button class="leavemanagement-inner"><a href="logout.php" style="color:white; text-decoration:none; font-size:25px; margin-left:20px;">Logout</a></button>
    <a class="attendance16" id="attendance" style="margin-top: -60px;">Attendance</a>
    <img class="uitcalender-icon16" alt="" src="./public/uitcalender.svg" />
    <img class="leavemanagement-child2" alt="" src="./public/rectangle-4@2x.png" />

    <a class="dashboard16" href="./dash_mgr.php" id="dashboard">Dashboard</a>
    <a class="fluentpeople-32-regular16" id="fluentpeople32Regular">
      <img class="vector-icon84" alt="" src="./public/vector7.svg" />
    </a>
    <a class="employee-list16" id="employeeList">Employee List</a>
    <a class="akar-iconsdashboard16" href="./dash_mgr.php" id="akarIconsdashboard">
      <img class="vector-icon85" alt="" src="./public/vector3.svg" />
    </a>
    <img class="tablerlogout-icon16" alt="" src="./public/tablerlogout.svg" />

    <a class="uitcalender16" id="uitcalender" style="margin-top: -60px;">
      <img class="vector-icon86" alt="" src="./public/vector4.svg" />
    </a>
    <a class="leaves16">Leaves</a>
    <a class="fluentperson-clock-20-regular16">
      <img class="vector-icon87" alt="" src="./public/vector10.svg" />
    </a>
    <div class="rectangle-parent26" style="overflow:auto; width:1450px; margin-left:-40px; margin-top:-50px;">
    <?php
      $manager_query = "SELECT desg,work_location FROM manager WHERE email = '$user_name'";
      $manager_result = mysqli_query($con, $manager_query);

      if ($manager_result) {
        $manager_designations = array();
        $work_location = '';
        while ($row = mysqli_fetch_assoc($manager_result)) {
          $designations = array_map('trim', explode(',', $row['desg']));
          $manager_designations = array_merge($manager_designations, $designations);
          $work_location = $row['work_location'];
        }
        $manager_designations = array_unique(array_filter($manager_designations));

        if (!empty($manager_designations)) {
          $inClause = implode("','", $manager_designations);
          $employee_query = "SELECT leaves.* FROM leaves 
                           WHERE leaves.desg IN ('$inClause') 
                           AND work_location = '$work_location'
                           ORDER BY leaves.applied desc";

          $employee_result = mysqli_query($con, $employee_query);
          $cnt = 1;
      ?>
      <table class="data" style="margin-left: auto; margin-right: auto;">
        <tr>
          <th></th>
          <th>Employee Name</th>
          <th>Designation</th>
          <th>Leave Type</th>
          <th>Applied On</th>
          <th>Leave Date(s)</th>
          <th>Leave Status</th>
          <th>Leave Bal. Costed</th>
          <th style="border-left:1px solid rgba(120, 130, 140, 0.13);"></th>
        </tr>
        <?php
        while ($result = mysqli_fetch_assoc($employee_result)) {
          $employeeSql = "SELECT pic FROM emp WHERE empname = '{$result['empname']}'";
          $employeeQuery = mysqli_query($con, $employeeSql);
          $employeeData = mysqli_fetch_assoc($employeeQuery);
        ?>
          <tr>
            <td>
              <img class="hovpic" src="pics/<?php echo $employeeData['pic']; ?>" width="60px" height="60px" style="border-radius: 48px; border: 1px solid rgb(161, 161, 161);" alt="">
            </td>
            <td><?php echo $result['empname']; ?></td>
            <td><?php echo $result['desg']; ?></td>
            <td><?php echo $result['leavetype']; ?></td>
            <td><?php
                $status2 = isset($result['status2']) ? $result['status2'] : '';
                ?>
              <?php echo date('d-m-Y', strtotime('+12 hours +30 minutes', strtotime($result['applied']))); ?><BR>
              <span style='font-size:16px; border-top:0.1px solid black; white-space:nowrap;'>
                <?php echo ($status2 == '1') ? 'Thru HR' : 'self'; ?>
              </span>
            </td>
            <td><?php echo date('d-m-Y', strtotime($result['from'])); ?> to <?php echo date('d-m-Y', strtotime($result['to'])); ?></td>
            <td> <?php
                  $status = $result['status'];
                  $status1 = $result['status1'];
                  ?>

              <p class="pending">
              <?php
    if ($status == '2' && $status1 == '0') {
      echo '<span class=\'bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 inline-flex items-center rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400\'>
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 24 24" fill="none" stroke="#d0021b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v18H3zM15 9l-6 6m0-6l6 6"/></svg>
      Rejected
      </span>';
    } elseif ($status == '2' && $status1 == '1') {
      echo '<span class=\'bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 inline-flex items-center rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400\'>
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 24 24" fill="none" stroke="#d0021b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v18H3zM15 9l-6 6m0-6l6 6"/></svg>
      Approver Rejected
      </span>';
    } elseif (($status == '1' && $status1 == '1') || ($status == '1' && $status1 == '0')) {
      echo '<span class=\'bg-green-100 text-green-800 text-xs font-medium inline-flex items-center me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400\'>
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 24 24" fill="none" stroke="#417505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
    Approved
      </span>';
    } elseif ($status == '0' && $status1 == '0') {
      echo '<span class=\'bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 inline-flex items-center rounded dark:bg-gray-700 dark:text-red-400 border border-red-400\'>
      <svg xmlns=\'http://www.w3.org/2000/svg\' width=\'22\' height=\'20\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'#fb0b0b\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'>
          <path d=\'M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z\'></path>
          <line x1=\'12\' y1=\'9\' x2=\'12\' y2=\'13\'></line>
          <line x1=\'12\' y1=\'17\' x2=\'12.01\' y2=\'17\'></line>
      </svg>
      HR-Action Pending
      </span>';
    }elseif ($status == '4' && $status1 == '0') {
      echo '<span class=\'bg-yellow-100 text-yellow-800 text-xs font-medium inline-flex items-center px-3 py-1.5 rounded dark:bg-gray-700 dark:text-yellow-400 border border-yellow-400\'>
      <svg class=\'w-3.5 h-5.5 me-1\' aria-hidden=\'true\' xmlns=\'http://www.w3.org/2000/svg\' fill=\'currentColor\' viewBox=\'0 0 20 20\'>
      <path d=\'M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z\'/>
      </svg>Pending at Manager
      </span>  <br>     <span style="font-size:16px;white-space:nowrap;">' . $result['aprname'] . '</span> ';
  }elseif ($status == '3' && $status1 == '0') {
      echo '<span class=\'bg-yellow-100 text-yellow-800 text-xs font-medium inline-flex items-center px-3 py-1.5 rounded dark:bg-gray-700 dark:text-yellow-400 border border-yellow-400\'>
      <svg class=\'w-3.5 h-5.5 me-1\' aria-hidden=\'true\' xmlns=\'http://www.w3.org/2000/svg\' fill=\'currentColor\' viewBox=\'0 0 20 20\'>
      <path d=\'M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z\'/>
      </svg>Pending at Approver
      </span>  <br> <span style="font-size:16px;white-space:nowrap;">' . $result['aprname'] . '</span> ';
  }
    ?>
              </p>
            </td>
            <td>
            <?php
            if (
    (($status == '1' && $status1 == '1') || ($status == '1' && $status1 == '0')) &&
    strtotime($result['from']) >= strtotime('2024-02-01')
){
$fromDate = new DateTime($result['from']);
$toDate = new DateTime($result['to']);
if ($result['leavetype'] === "HALF DAY") {
    echo '0.5';
} else {
    $toDate->modify('+1 day');

    $interval = new DateInterval('P1D');
    $dateRange = new DatePeriod($fromDate, $interval, $toDate);

    $fetchHolidaysQuery = "SELECT `date` FROM holiday";
    $holidaysResult = mysqli_query($con, $fetchHolidaysQuery);
    $holidayDates = [];

    while ($row = mysqli_fetch_assoc($holidaysResult)) {
        $holidayDates[] = $row['date'];
    }
    $excludedDays = 0;
    foreach ($dateRange as $date) {
        if ($date->format('w') != 0 && !in_array($date->format('Y-m-d'), $holidayDates)) {
            $excludedDays++;
        }
    }
    $totalDays = $excludedDays;
    echo $totalDays;
}
            } 
            else
            echo"";
?>
</td>
            <td style="border-left:1px solid rgba(120, 130, 140, 0.13) ;">
              <a href="leave-Details_mgr.php?id=<?php echo $result['ID']; ?>"><button type="button" class="text-gray-900 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-4 py-2 text-center inline-flex items-center dark:focus:ring-gray-500 ">
                  View details</a>
              <svg class="rtl:rotate-180 w-3 h-3.5 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
              </svg>
            </td>
          </tr>
        <?php
        }
        ?>
      </table>
      <?php
        } else {
          die("Error: No valid designations found for the manager.");
        }
      } else {
        die("Error: " . mysqli_error($con));
      }
      ?>
    </div>
  </div>

  <script>
    var rectangleLink1 = document.getElementById("rectangleLink1");
    if (rectangleLink1) {
      rectangleLink1.addEventListener("click", function(e) {
        window.location.href = "./approver.php";
      });
    }

    var rectangleLink2 = document.getElementById("rectangleLink2");
    if (rectangleLink2) {
      rectangleLink2.addEventListener("click", function(e) {
        window.location.href = "./apply-leave.php";
      });
    }

    var rectangleLink3 = document.getElementById("rectangleLink3");
    if (rectangleLink3) {
      rectangleLink3.addEventListener("click", function(e) {
        window.location.href = "./my-leaves.php";
      });
    }

    var assignLeave = document.getElementById("assignLeave");
    if (assignLeave) {
      assignLeave.addEventListener("click", function(e) {
        window.location.href = "./approver.php";
      });
    }

    var applyLeave = document.getElementById("applyLeave");
    if (applyLeave) {
      applyLeave.addEventListener("click", function(e) {
        window.location.href = "./apply-leave.php";
      });
    }

    var myLeaves = document.getElementById("myLeaves");
    if (myLeaves) {
      myLeaves.addEventListener("click", function(e) {
        window.location.href = "./my-leaves.php";
      });
    }

    var anikaHRM = document.getElementById("anikaHRM");
    if (anikaHRM) {
      anikaHRM.addEventListener("click", function(e) {
        window.location.href = "./dash_mgr.php";
      });
    }

    var leaveManagement = document.getElementById("leaveManagement");
    if (leaveManagement) {
      leaveManagement.addEventListener("click", function(e) {
        window.location.href = "./dash_mgr.php";
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
        window.location.href = "./attendence_mgr.php";
      });
    }

    var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
    if (fluentMdl2leaveUser) {
      fluentMdl2leaveUser.addEventListener("click", function(e) {
        window.location.href = "./onboarding.php";
      });
    }

    var dashboard = document.getElementById("dashboard");
    if (dashboard) {
      dashboard.addEventListener("click", function(e) {
        window.location.href = "./dash_mgr.php";
      });
    }

    var fluentpeople32Regular = document.getElementById("fluentpeople32Regular");
    if (fluentpeople32Regular) {
      fluentpeople32Regular.addEventListener("click", function(e) {
        window.location.href = "./employee-management_mgr.php";
      });
    }

    var employeeList = document.getElementById("employeeList");
    if (employeeList) {
      employeeList.addEventListener("click", function(e) {
        window.location.href = "./employee-management_mgr.php";
      });
    }

    var akarIconsdashboard = document.getElementById("akarIconsdashboard");
    if (akarIconsdashboard) {
      akarIconsdashboard.addEventListener("click", function(e) {
        window.location.href = "./dash_mgr.php";
      });
    }

    var uitcalender = document.getElementById("uitcalender");
    if (uitcalender) {
      uitcalender.addEventListener("click", function(e) {
        window.location.href = "./attendence_mgr.php";
      });
    }

    var mohanReddy = document.getElementById("mohanReddy");
    if (mohanReddy) {
      mohanReddy.addEventListener("click", function(e) {
        window.location.href = "./leave-overview.php";
      });
    }
  </script>
</body>

</html>