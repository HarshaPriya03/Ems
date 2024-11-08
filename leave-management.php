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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  <style>
    /* Scrollbar Styling */
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
      transform: scale(6, 6);
    }

    .container {
      padding-bottom: 20px;
      margin-right: 0px;
    }

    .input-text:focus {
      box-shadow: 0px 0px 0px;
      border-color: #fd7e14;
      outline: 0px;
      width: 1000px !important;
    }

    .form-control {
      border: 1px solid #fd7e14;
    }

    .circle {
      background: #F56A12 !important;
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

      animation: circle 0.9s infinite;
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
  </style>
</head>

<body>
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
  ?>
  <div class="leavemanagement">
    <div class="bg16"></div>
    <div class="rectangle-parent25" style="margin-left: 150px;">
      <div class="frame-child215"></div>
      <div class="dropdown">
        <button class="attendence5" style="margin-left: -350px; border: none; background: none; margin-top: -14px;" for="btnControl"><img src="./public/9710841.png" width="50px" alt="">
          <div class="dropdown-content" style="margin-left: -60px; border-radius: 20px;">
            <?php

            if ($work_location == 'Visakhpatnam') {
            ?>
              <a href="holiday.php" style="font-size:15px; border-bottom: 2px solid rgb(185,185,185)">Holidays</a>

            <?php
            } elseif ($work_location == 'Gurugram') {
            ?>
              <a href="holiday_ggm.php" style="font-size:15px; border-bottom: 2px solid rgb(185,185,185)">Holidays</a>
            <?php
            } else {
            ?>
              <a href="holiday.php" style="font-size:15px; border-bottom: 2px solid rgb(185,185,185)">Holidays</a>
            <?php
            }
            ?>
            <a href="Leave_Balance.php" style="font-size:15px; border-bottom: 2px solid rgb(185,185,185)">Leave Balance</a>
            <?php if ($user_name === 'prabhdeep.singh@teknoscan.co.in' || $user_name === 'it@anikasterilis.com') {
              echo '<a href="Approval-mob.php?email=prabhdeep.singh@teknoscan.co.in"  target="_blank" style="font-size:15px">Pending Approvals</a>';
            }  ?>
          </div>
        </button>
      </div>
      <a class="frame-child216"></a>
      <a class="frame-child217" id="rectangleLink1"> </a> <a href="./leave-type.php" class="frame-child217" style="margin-left: -470px;" id="rectangleLink1"> </a>
      <a class="frame-child218" id="rectangleLink2"> </a>
      <a class="frame-child219" id="rectangleLink3"> </a>
      <a class="leaves-list5" style="margin-top:-4px;">Leaves List</a>
      <a class="assign-leave5" style="margin-top:-4px;  margin-left:10px;" id="assignLeave">Approvers</a> <a href="./leave-type.php" class="assign-leave5" style="margin-left: -484px; margin-top:-4px;  width: 200px;" id="assignLeave">New Leave Type</a>
      <a class="apply-leave5" style="margin-top:-4px;" id="applyLeave">Apply Leave</a>
      <a class="my-leaves4" style="margin-top:-4px; margin-left:-4px;" id="myLeaves">My Leaves</a>

    </div>
    <img class="leavemanagement-child" alt="" src="./public/rectangle-1@2x.png" />

    <img class="leavemanagement-item" alt="" src="./public/rectangle-2@2x.png" />

    <img class="logo-1-icon16" alt="" src="./public/logo-1@2x.png" />

    <a class="anikahrm16" href="./index.php" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm16">HRM</span>
    </a>
    <a class="leave-management4" href="./index.php" id="leaveManagement">Leave Management

    </a>
    <button class="leavemanagement-inner"><a href="logout.php" style="color:white; text-decoration:none; font-size:25px; margin-left:20px;">Logout</a></button>
    <a class="onboarding20" id="onboarding">Onboarding

      <?php if ($count_onb > 0) { ?>
        <span class="circle">
          <?php echo $count_onb ?>
        </span>
      <?php
      }
      ?>
    </a>
    <a class="attendance16" id="attendance">Attendance</a>
    <a href="./Payroll/payroll.php" class="payroll16" style="text-decoration:none; color:black;">
      Payroll
      <?php if ($count_payroll > 0) { ?>
        <span class="circle">
          <?php echo $count_payroll ?>
        </span>
      <?php } ?>
    </a>
    <a href="./Reports/reports.php" class="reports16">Reports</a>
    <a class="fluent-mdl2leave-user16" id="fluentMdl2leaveUser">
      <img class="vector-icon83" alt="" src="./public/vector.svg" />
    </a>
    <img class="uitcalender-icon16" alt="" src="./public/uitcalender.svg" />

    <img class="arcticonsgoogle-pay16" alt="" src="./public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon16" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />

    <img class="leavemanagement-child2" alt="" src="./public/rectangle-4@2x.png" />

    <a class="dashboard16" href="./index.php" id="dashboard">Dashboard</a>
    <a class="fluentpeople-32-regular16" id="fluentpeople32Regular">
      <img class="vector-icon84" alt="" src="./public/vector7.svg" />
    </a>
    <a class="employee-list16" id="employeeList">Employee List
    </a>
    <a class="akar-iconsdashboard16" href="./index.php" id="akarIconsdashboard">
      <img class="vector-icon85" alt="" src="./public/vector3.svg" />
    </a>
    <img class="tablerlogout-icon16" alt="" src="./public/tablerlogout.svg" />

    <a class="uitcalender16" id="uitcalender">
      <img class="vector-icon86" alt="" src="./public/vector4.svg" />
    </a>
    <a class="leaves16">Leaves


    </a>
    <a class="fluentperson-clock-20-regular16">
      <img class="vector-icon87" alt="" src="./public/vector10.svg" />
    </a>
    <div class="container" style="margin-top:170px; display:flex; justify-content:center;">
      <div class="row">
        <div class="col-md-8">
          <div class="input-group mb-3" style="width:1000px;">
            <input type="text" class="form-control input-text" id="filterInput" onkeyup="filterTable()" placeholder="Search for employee name...">
            <div class="input-group-append" style="background:white;width:00px;">
              <span style="border-radius:0px;pointer-events: none; border-color: #fd7e14;padding:10px;" class="btn btn-outline-warning btn-lg" type="button"><i class="fa fa-search"></i></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="rectangle-parent26 overflow-x-auto " style="margin-top:50px;">

      <table class="data w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="attendanceTable" style="margin-left: auto; margin-right: auto;">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">

            </th>
            <th scope="col" class="px-6 py-3">
              Employee Name
            </th>
            <th scope="col" class="px-6 py-3">
              Designation
            </th>
            <th scope="col" class="px-6 py-3">
              Leave Type
            </th>
            <th scope="col" class="px-6 py-3">
              Applied on
            </th>
            <th scope="col" class="px-6 py-3">
              Leave Date(s)
            </th>
            <th scope="col" class="px-6 py-3">
              Leave Status
            </th>
            <th scope="col" class="px-6 py-3">
              Leave Bal. Costed
            </th>
            <th style="border-left:1px solid rgba(120, 130, 140, 0.13);scale:0.9;">
              <div>
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center ">
                  <li class="me-2">
                    <a href="./Reports/leavebalance_report.php" class="inline-flex items-center justify-center p-1 text-blue-600  border-b-2 border-blue-600 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">

                      <svg class="w-6 h-6 me-2 text-blue-600 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m8-2h3m-3 3h3m-4 3v6m4-3H8M19 4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 12v6h8v-6H8Z" />
                      </svg>

                      Leave Balance Report
                    </a>
                  </li>
                  <li class="me-2">
                    <a href="./Reports/leavedetails_report.php" class="inline-flex items-center justify-center p-1 text-blue-600  border-b-2 border-blue-600 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                      <svg class="w-6 h-6 me-2 text-blue-600 dark:text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 3v4a1 1 0 0 1-1 1H5m8-2h3m-3 3h3m-4 3v6m4-3H8M19 4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 12v6h8v-6H8Z" />
                      </svg>

                      Leaves Report
                    </a>
                  </li>
              </div>
              <!-- <a class="btn udbtn text-center" style="background-color: #FB8A0B; color: white;" href="print-detailslb.php" target="_blank">Download</a> -->
            </th>
          </tr>
        </thead>

        <?php

        if ($work_location == 'All') {
          $sql = "SELECT * FROM leaves ORDER BY applied DESC";
        } else {
          $sql = "SELECT * FROM leaves
       WHERE work_location= '$work_location'  ORDER BY applied DESC";
        }
        
        

        $que = mysqli_query($con, $sql);
        $cnt = 1;
        while ($result = mysqli_fetch_assoc($que)) {
          $employeeSql = "SELECT pic FROM emp WHERE empname = '{$result['empname']}'";
          $employeeQuery = mysqli_query($con, $employeeSql);
          $employeeData = mysqli_fetch_assoc($employeeQuery);
        ?>
          <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="px-6 py-4">
              <?php
              if (!empty($employeeData['pic'])) {
                echo '<img class="hovpic" src="pics/' . $employeeData['pic'] . '" width="80px" height="80px" style="border-radius: 48px; border: 1px solid rgb(161, 161, 161);" alt="">';
              } else {
                echo '<img src="placeholder.jpg" width="80px" height="80px" alt="Placeholder">';
              }
              ?>

            </td>
            <td class="px-6 py-4"><?php echo $result['empname']; ?>
            </td>
            <td class="px-6 py-4"><?php echo $result['desg']; ?></td>
            <td class="px-6 py-4"><?php echo $result['leavetype']; ?></td>
            <td class="px-6 py-4"><?php
                                  $status2 = isset($result['status2']) ? $result['status2'] : '';
                                  ?>
              <?php echo date('d-m-Y', strtotime('+12 hours +30 minutes', strtotime($result['applied']))); ?><BR>
              <span style='font-size:16px; border-top:0.1px solid black; white-space:nowrap;'>
                <?php echo ($status2 == '1') ? 'Thru HR' : 'self'; ?>
              </span>
            </td>
            <td class="px-6 py-4"><?php echo date('d-m-Y', strtotime($result['from'])); ?> to <?php echo date('d-m-Y', strtotime($result['to'])); ?></td>
            <td class="px-6 py-4"> <?php
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
                } elseif ($status == '4' && $status1 == '0') {
                  echo '<span class=\'bg-yellow-100 text-yellow-800 text-xs font-medium inline-flex items-center px-3 py-1.5 rounded dark:bg-gray-700 dark:text-yellow-400 border border-yellow-400\'>
      <svg class=\'w-3.5 h-5.5 me-1\' aria-hidden=\'true\' xmlns=\'http://www.w3.org/2000/svg\' fill=\'currentColor\' viewBox=\'0 0 20 20\'>
      <path d=\'M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z\'/>
      </svg>Pending at Manager
      </span>  <br>     <span style="font-size:16px;white-space:nowrap;">' . $result['aprname'] . '</span> ';
                } elseif ($status == '3' && $status1 == '0') {
                  echo '<span class=\'bg-yellow-100 text-yellow-800 text-xs font-medium inline-flex items-center px-3 py-1.5 rounded dark:bg-gray-700 dark:text-yellow-400 border border-yellow-400\'>
      <svg class=\'w-3.5 h-5.5 me-1\' aria-hidden=\'true\' xmlns=\'http://www.w3.org/2000/svg\' fill=\'currentColor\' viewBox=\'0 0 20 20\'>
      <path d=\'M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z\'/>
      </svg>Pending at Approver
      </span>  <br>     <span style="font-size:16px;white-space:nowrap;">' . $result['aprname'] . '</span> ';
                }
                ?>
              </p>
            </td>
            <td class="px-6 py-4">
              <?php
              if (
                (($status == '1' && $status1 == '1') || ($status == '1' && $status1 == '0')) &&
                strtotime($result['from']) >= strtotime('2024-02-01')
              ) {
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
              } else
                echo "";
              ?>
            </td>
            <td class="px-6 py-4" style="border-left:1px solid rgba(120, 130, 140, 0.13);">
              <?php if ($result['desg'] == "SECURITY GAURDS") : ?>
                <button type="button" class="pointer-events-none text-green-900 bg-green-200 hover:bg-green-300 focus:ring-4 focus:outline-none focus:ring-green-100 font-medium rounded-lg text-sm px-4 py-2 text-center inline-flex items-center dark:focus:ring-gray-500">
                  System Approved
                </button>
              <?php else : ?>
                <a href="leaveDetails.php?id=<?php echo $result['ID']; ?>">
                  <button type="button" class="text-gray-900 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-4 py-2 text-center inline-flex items-center dark:focus:ring-gray-500">
                    View details
                    <svg class="rtl:rotate-180 w-3 h-3.5 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                  </button>
                </a>
              <?php endif; ?>
            </td>

          </tr>
        <?php
        }
        ?>
      </table>

    </div>
  </div>
  <script>
    function filterTable() {
      var input = document.getElementById('filterInput');
      var filter = input.value.toUpperCase();

      var table = document.getElementById('attendanceTable');

      var rows = table.getElementsByTagName('tr');

      for (var i = 0; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName('td');
        var shouldShow = false;

        if (i === 0) {
          shouldShow = true;
        } else {
          for (var j = 0; j < cells.length; j++) {
            var cell = cells[j];

            var isHeaderCell = cell.classList.contains('static-cell');

            if (!isHeaderCell) {
              var txtValue = cell.textContent || cell.innerText;
              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                shouldShow = true;
                break;
              }
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
        window.location.href = "./index.php";
      });
    }

    var leaveManagement = document.getElementById("leaveManagement");
    if (leaveManagement) {
      leaveManagement.addEventListener("click", function(e) {
        window.location.href = "./index.php";
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

    var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
    if (fluentMdl2leaveUser) {
      fluentMdl2leaveUser.addEventListener("click", function(e) {
        window.location.href = "./onboarding.php";
      });
    }

    var dashboard = document.getElementById("dashboard");
    if (dashboard) {
      dashboard.addEventListener("click", function(e) {
        window.location.href = "./index.php";
      });
    }

    var fluentpeople32Regular = document.getElementById("fluentpeople32Regular");
    if (fluentpeople32Regular) {
      fluentpeople32Regular.addEventListener("click", function(e) {
        window.location.href = "./employee-management.php";
      });
    }

    var employeeList = document.getElementById("employeeList");
    if (employeeList) {
      employeeList.addEventListener("click", function(e) {
        window.location.href = "./employee-management.php";
      });
    }

    var akarIconsdashboard = document.getElementById("akarIconsdashboard");
    if (akarIconsdashboard) {
      akarIconsdashboard.addEventListener("click", function(e) {
        window.location.href = "./index.php";
      });
    }

    var uitcalender = document.getElementById("uitcalender");
    if (uitcalender) {
      (120, 130, 140, 0.13);
      uitcalender.addEventListener("click", function(e) {
        window.location.href = "./attendence.php";
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