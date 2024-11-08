<?php
session_start();
@include 'inc/config.php';
$currentDate = date("Y-m-d");
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
    $work_location = $row['work_location'];
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
    <link rel="stylesheet" href="./css/index.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400&display=swap" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://kit.fontawesome.com/26eea4c998.js" crossorigin="anonymous"></script>
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

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  position: absolute;
  background-color: #f9f9f9;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
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
    .dropbtn1 {
      background-color: #ffe2c6;
      color: #ff5400;
      padding: 16px;
      font-size: 16px;
      border: none;
      cursor: pointer;
      /* box-shadow: 0px 8px 16px 0px #ffe2c6; */
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
            margin-left:20px;
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
.icon-button__badge  {
  box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.5);
  animation: pulse 1.5s infinite;
}
.notifi-box {
  z-index:99999;
	width: 300px;
	height: 0px;
	opacity: 0;
	position: absolute;
	top: 63px;
	right: 35px;
	transition: 1s opacity, 250ms height;
  background:#FFFFFF;
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

.mgr-view{
          margin-top:-625px;
          margin-left:-20px;
          color:white;
          font-size:20px;
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

.hidden {
    display: none;
}

/* Additional styling for dropdown and submenu (from previous code) */
.log-div
{
    position:absolute;
    background-color:white;
    top:4vw;
    left:18vw;
    padding:1vw;
    display:flex;
    flex-direction:row;
    justify-content:space-around;
    width:80vw;
}
.log-div button
{
          border-radius:1vw;
          background-color:#f0f0f0;
          color:black;
          padding:0.5vw;
          border:none;
          width:10vw;
          height:2vw;
          font-size:1vw;
}


/* Table styling */
.table-div {
    top:10vw;
    left:23vw;
    position:absolute;
   
}

table {
    width: 70vw;
    border-collapse: collapse;
    background-color:white;
    

}


table th, table td {
    padding: 1vw;
    text-align: left;
    
}

.hidden {
    display: none;
}
.type
{
    background-color:#f3e8ff;
    color:#b647ce;
    /* width:5vw; */
    padding:0.2vw;
    width:3.65vw;
    border-radius:0.5vw;
}
.thumb-icon-1
{
    padding:0.5vw;
    background-color:#dcfce7;
    color:#16a34a;
    border-radius:50%;
}
.thumb-icon-2
{
    padding:0.5vw;
    background-color:#fee2e2;
    color:#dc2626;
    border-radius:50%;
}
.action{
    display:flex;
    flex-direction:row;
    gap:1vw;
}
.status-approve
{
    padding:0.5vw;
    background-color:#dcfce7;
    color:#16a34a;
    border-radius:0.5vw;
    width:4vw;
}
.status-reject
{
    padding:0.5vw;
    background-color:#fee2e2;
    color:#dc2626;
    border-radius:0.5vw;
    width:4vw;
}
.type-1
{
    background-color:#dbeafe;
    color:#1d4eda;
    /* width:5vw; */
    padding:0.2vw;
    width:3vw;
    border-radius:0.5vw;
}
.log-div button.active
{
    background-color:#FFE2C6;
    color:#FF5400;
}
.gatepass-approval
{
    position:absolute;
    top:54.5%;
    left: 64px;
    width:270px;
    background: linear-gradient(90deg, #F35C16 13.72%, #FA840D 76.92%);
    padding:0.5vw;
    padding-left:1vw;
    border-radius:2vw;
    /* width:14vw; */

   
}
.gatepass-approval a{
       color:#fff;
       font-size:20px;
       text-decoration:none;
       font-weight:300;
       margin-left:0.5vw;
}
.gatepass-approval i
{
    font-size:20px;
    color:#fff;
}
.arrow
{
    position:absolute;
    top:49.8%;
    left:295px;
}
.dashboard18
{
    color:black;
}

.logout18{
    left:82px !important;
}

.logout{
    top:1px;
    left:38px;
}

  </style>
    <script>
    function checkForUpdates() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
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

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$select = "SELECT uf.*, m.status as manager_status 
           FROM user_form uf
           LEFT JOIN manager m ON uf.email = m.email 
           WHERE uf.email = ?";

$stmt = mysqli_prepare($con, $select);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user_name'] = $row['email'];
    $_SESSION['admin_name'] = $row['name'];

    $manager_status = $row['manager_status'];
} else {
    // Handle case where user is not found
    echo "User not found";
    exit;
}
?>
  <?php
 $manager_query = "SELECT desg, work_location FROM manager WHERE email = '$user_name'";
$manager_result = mysqli_query($con, $manager_query);

if ($manager_result) {
    $manager_designations = array();

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
                           AND (status = 0 OR status = 4)
                           AND leaves.work_location = '$work_location'
                           ORDER BY leaves.applied DESC";

        $employee_result = mysqli_query($con, $employee_query);
        $cnt = 1;

        // Count the number of results
        $result_count = mysqli_num_rows($employee_result);
    }}
        
    $sql_leaves = "SELECT COUNT(*) AS count FROM leaves WHERE status = 0  AND work_location = '$work_location'";
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

    $total_count = $count_leaves + $count_onb + $count_payroll ;
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
      <h5 class="hr-management">Gatepass Approval</h5>
      <button style="border-radius: 50%;position:absolute;right:50px; top:7px;" onclick="window.location.href='./faqs/faq.php'" class="dropbtn1" for="btnControl"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#ff5400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg></button>
        <?php if ($manager_status == 1): ?>
        <a href="employee-dashboard.php" target="_blank" class="index-inner employeedashboard-inner mgr-view">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                <polygon points="12 15 17 21 7 21 12 15"></polygon>
            </svg>
            <span>My View</span>
        </a>
    <?php endif; ?>
        <div class="dropdown" style="position:absolute;left:1700px;top:15px;">
        <!-- <button type="button" class="icon-button dropbtn1" onclick="toggleNotifi()">
    <span class="material-icons">notifications</span>
    <span class="icon-button__badge"><?php echo $total_count ?></span>
  </button> -->
        </div> 
        <div class="notifi-box " id="box">
			<h2>Notifications : <span><?php echo $total_count ?></span></h2>
      <?php if($count_leaves > 0) { ?>
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
      <?php if($count_onb > 0) { ?>
        <a href="onboarding.php" style="text-decoration:none;">
      <div class="notifi-item" style="	border-bottom: 1px solid #dddddd;">
				<div class="text">
				   <h4>Onboarding</h4>
				   <p>Onboard the new recruits</p>
			    </div> 
			</div>
      </a>
      <?php
      }
      ?>
      <a href="Payroll/payroll.php" style="text-decoration:none;">
      <?php if($count_payroll > 0) { ?>
      <div class="notifi-item" >
				<div class="text">
				   <h4>Payroll Notification</h4>
				   <p>Complete the pending steps in payroll</p>
			    </div> 
			</div>
      </a>
      <?php
      }
      ?>
    </div>
        <a href="logout.php">
          <button class="index-inner"></button>
      <div class="logout18">  <img class="tablerlogout-icon17" alt="" src="./public/tablerlogout.svg" /><p class="logout">Logout</p></div></a>
      <a class="employee-list18" id="employeeList">Employee List</a>
      <a class="leaves18" id="leaves">Leaves

      <?php if($result_count > 0) { ?>
    <span class="circle">
      <?php echo $result_count ?>
    </span>
    <?php
}
    ?>
      </a>
      

<!-- Icon Link with Dropdown -->
<!-- Attendance Link -->
<a class="onboarding22"  id="onboarding" href="./attendence_mgr.php">Attendance</a>
<div class="arrow"  onclick="toggleGatepass()"><i class="fa-solid fa-angle-down"></i></div>

<!-- Gatepass Approval Div -->
<div id="gatepassApproval" class="gatepass-approval ">
<i class="fa-solid fa-right-from-bracket"></i>

<a href="">Gatepass Approval</a>
</div>
  <a class="fluentpeople-32-regular18" id="fluentpeople32Regular">
    <img class="vector-icon94" alt="icon" src="./public/vector7.svg" />
  </a>

<script>
  function toggleGatepass() {
    const gatepassDiv = document.getElementById("gatepassApproval");
    gatepassDiv.classList.toggle("hidden");
  }
</script>


  
      <a class="fluent-mdl2leave-user18" id="fluentMdl2leaveUser">
        <img class="vector-icon95" alt="" src="./public/vector4.svg" />
      </a>
      <a
        class="fluentperson-clock-20-regular18"
        id="fluentpersonClock20Regular"
      >
        <img class="vector-icon96" alt="" src="./public/vector1.svg" />
      </a>

      <!-- <img class="index-child2" alt="" src="./public/rectangle-4@2x.png" /> -->

      <a class="dashboard18">Dashboard</a>
      <a class="akar-iconsdashboard18" >
        <img class="vector-icon98" alt="" src="./public/vector3.svg" />
      </a>
      <div class="index-child3"></div>
      <div>
      <?php
     $manager_query = "SELECT desg, work_location FROM manager WHERE email = '$user_name'";
    $manager_result = mysqli_query($con, $manager_query);
    $manager_designations = array();
    $work_location = '';
    while ($row = mysqli_fetch_assoc($manager_result)) {
        $designations = array_map('trim', explode(',', $row['desg']));
        $manager_designations = array_merge($manager_designations, $designations);
        $work_location = $row['work_location'];
    }
    $manager_designations = array_unique(array_filter($manager_designations));
    $inClause = implode("','", $manager_designations);
    
    if ($work_location == 'Visakhapatnam') {
    $sql1 = "SELECT COUNT(*) as count
        FROM emp e
        JOIN CamsBiometricAttendance c ON e.UserID = c.UserID
        WHERE  e.desg IN ('$inClause') AND DATE(AttendanceTime) = '$currentDate' 
            AND AttendanceType = 'CheckIn'
            AND NOT EXISTS (
                SELECT 1
                FROM CamsBiometricAttendance co
                WHERE co.UserID = c.UserID
                    AND DATE(co.AttendanceTime) = DATE(c.AttendanceTime)
                    AND co.AttendanceType = 'CheckOut'
                    AND co.AttendanceTime > c.AttendanceTime
            )";
 }elseif ($work_location == 'Gurugram') {
  $sql1 = "SELECT COUNT(*) as count
  FROM emp e
  JOIN CamsBiometricAttendance_GGM c ON e.UserID = c.UserID
  WHERE  e.desg IN ('$inClause') AND DATE(AttendanceTime) = '$currentDate' 
      AND AttendanceType = 'CheckIn'
      AND NOT EXISTS (
          SELECT 1
          FROM CamsBiometricAttendance_GGM co
          WHERE co.UserID = c.UserID
              AND DATE(co.AttendanceTime) = DATE(c.AttendanceTime)
              AND co.AttendanceType = 'CheckOut'
              AND co.AttendanceTime > c.AttendanceTime
      )";
      }
    $result1 = $con->query($sql1);
    $row1 = $result1->fetch_assoc();
    $count1 = $row1['count'];
    
    if ($work_location == 'Visakhapatnam') {
    $sql2 = "SELECT COUNT(*) as count FROM emp e
        JOIN leaves l ON e.empname = l.empname 
        WHERE e.desg IN ('$inClause') AND l.work_location='$work_location'  AND l.status = 1 AND l.status1 = 1 AND '$currentDate'  BETWEEN DATE(l.from) AND DATE(l.to)";
 }elseif ($work_location == 'Gurugram') {
  $sql2 = "SELECT COUNT(*) as count FROM emp e
        JOIN leaves l ON e.empname = l.empname 
        WHERE e.desg IN ('$inClause') AND l.work_location='$work_location'  AND l.status = 1 AND l.status1 = 1 AND '$currentDate'  BETWEEN DATE(l.from) AND DATE(l.to)";
 }
 
    $result2 = $con->query($sql2);
    $row2 = $result2->fetch_assoc();
    $count2 = $row2['count'];

    $sql3 = "SELECT COUNT(*) as count FROM absent a
        JOIN emp e ON a.empname = e.empname
        WHERE  e.desg IN ('$inClause')  AND TIMESTAMP(DATE(AttendanceTime)) = '$currentDate' ";

    $result3 = $con->query($sql3);
    $row3 = $result3->fetch_assoc();
    $count3 = $row3['count'];

    if ($work_location == 'Visakhapatnam') {
    $sql4 = "SELECT COUNT(*) as count FROM emp WHERE emp.desg IN ('$inClause') AND work_location='$work_location'";
  }elseif ($work_location == 'Gurugram') {
    $sql4 = "SELECT COUNT(*) as count FROM emp WHERE emp.desg IN ('$inClause') AND work_location='$work_location'";
  }
    $result4 = $con->query($sql4);
    $row4 = $result4->fetch_assoc();
    $count4 = $row4['count'];

    ?>
     
    </div>
    <div class="log-div">
    <button id="pendingButton" onclick="showTable('pending')" class="active">Pending Approvals</button>
    <button id="logButton" onclick="showTable('log')">Gatepass Log</button>
</div>

<!-- Pending Approvals Table (Visible by default) -->
<div id="pendingTable" class="table-div">
    <h3>Pending Approvals</h3>
    <table class="data" style="margin-left:auto; margin-right:auto;">
      <tr>
        <th>Employee </th>
        <th>Contact</th>
        <th>Designation</th>
        <th>Exit Time</th>
        <th>Type</th>
        <th>Purpose</th>
        <th>Actions</th>
      </tr>
      <tr>
        <td>John doe</td>
        <td>9885284841</td>
        <td>Software Engineer</td>
        <td>14:30</td>
        <td ><div class="type">Personal</div></td>
        <td>Doctor's Appointment</td>
        <td><div class="action">
            <div class="thumb-icon-1"><i class="fa-regular fa-thumbs-up"></i></div>
            <div class="thumb-icon-2"><i class="fa-regular fa-thumbs-down"></i></div>
          </div>
        </td>
      </tr>
      <tr>
        <td>Selena</td>
        <td>7995264841</td>
        <td>Senior Developer</td>
        <td>15:00</td>
        <td ><div class="type-1">Official</div></td>
        <td>Client Meeting</td>
        <td><div class="action">
            <div class="thumb-icon-1"><i class="fa-regular fa-thumbs-up"></i></div>
            <div class="thumb-icon-2"><i class="fa-regular fa-thumbs-down"></i></div>
          </div>
        </td>
      </tr>
     
    </table>
</div>

<!-- Gatepass Log Table (Hidden by default) -->
<div id="logTable" class="table-div hidden">
    <h3>Gatepass Log</h3>
    <table >
    <tr>
        <th>Employee </th>
        <th>Contact</th>
        <th>Designation</th>
        <th>Exit Time</th>
        <th>Type</th>
        <th>Purpose</th>
        <th>Status</th>
      </tr>
      <tr>
        <td>John doe</td>
        <td>9885284841</td>
        <td>Software Engineer</td>
        <td>14:30</td>
        <td ><div class="type">Personal</div></td>
        <td>Doctor's Appointment</td>
        <td><div class="status-approve">Approved</div></td>
      </tr>
      <tr>
        <td>Justin</td>
        <td>7995264841</td>
        <td>Product Manager</td>
        <td>14:30</td>
        <td ><div class="type-1">Official</div></td>
        <td>Bank Visit</td>
        <td><div class="status-reject">Rejected</div></td>
      </tr>
    </table>
</div>

<script>
    function showTable(tableType) {
        const pendingTable = document.getElementById("pendingTable");
        const logTable = document.getElementById("logTable");
        const pendingButton = document.getElementById("pendingButton");
        const logButton = document.getElementById("logButton");
        
        if (tableType === 'pending') {
            pendingTable.classList.remove("hidden");
            logTable.classList.add("hidden");
            pendingButton.classList.add("active");
            logButton.classList.remove("active");
        } else if (tableType === 'log') {
            logTable.classList.remove("hidden");
            pendingTable.classList.add("hidden");
            logButton.classList.add("active");
            pendingButton.classList.remove("active");
        }
    }
</script>



    <script>
      var employeeList = document.getElementById("employeeList");
      if (employeeList) {
        employeeList.addEventListener("click", function (e) {
          window.location.href = "./employee-management_mgr.php";
        });
      }
      
      var leaves = document.getElementById("leaves");
      if (leaves) {
        leaves.addEventListener("click", function (e) {
          window.location.href = "./leave-management_mgr.php";
        });
      }
      
      var onboarding = document.getElementById("onboarding");
      if (onboarding) {
        onboarding.addEventListener("click", function (e) {
          window.location.href = "./attendence_mgr.php";
        });
      }
      
      var attendance = document.getElementById("attendance");
      if (attendance) {
        attendance.addEventListener("click", function (e) {
          window.location.href = "./attendence_mgr.php";
        });
      }
      
      var fluentpeople32Regular = document.getElementById("fluentpeople32Regular");
      if (fluentpeople32Regular) {
        fluentpeople32Regular.addEventListener("click", function (e) {
          window.location.href = "./employee-management_mgr.php";
        });
      }
      
      var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
      if (fluentMdl2leaveUser) {
        fluentMdl2leaveUser.addEventListener("click", function (e) {
          window.location.href = "./attendence_mgr.php";
        });
      }
      
      var fluentpersonClock20Regular = document.getElementById(
        "fluentpersonClock20Regular"
      );
      if (fluentpersonClock20Regular) {
        fluentpersonClock20Regular.addEventListener("click", function (e) {
          window.location.href = "./leave-management_mgr.php";
        });
      }
      
      var uitcalender = document.getElementById("uitcalender");
      if (uitcalender) {
        uitcalender.addEventListener("click", function (e) {
          window.location.href = "./documents.php";
        });
      }
      
      var leavesList = document.getElementById("leavesList");
      if (leavesList) {
        leavesList.addEventListener("click", function (e) {
          window.location.href = "./leave-management_mgr.php";
        });
      }
      
      var attendanceReport = document.getElementById("attendanceReport");
      if (attendanceReport) {
        attendanceReport.addEventListener("click", function (e) {
          window.location.href = "./documents.php";
        });
      }
      
      var onboarding1 = document.getElementById("onboarding1");
      if (onboarding1) {
        onboarding1.addEventListener("click", function (e) {
          window.location.href = "./attendence_mgr.php";
        });
      }
      
      var employeeList1 = document.getElementById("employeeList1");
      if (employeeList1) {
        employeeList1.addEventListener("click", function (e) {
          window.location.href = "./employee-management_mgr.php";
        });
      }
      
      var applyLeave = document.getElementById("applyLeave");
      if (applyLeave) {
        applyLeave.addEventListener("click", function (e) {
          window.location.href = "./apply-leave.html";
        });
      }
      
      var solarnotesOutline = document.getElementById("solarnotesOutline");
      if (solarnotesOutline) {
        solarnotesOutline.addEventListener("click", function (e) {
          window.location.href = "./leave-management_mgr.php";
        });
      }
      
      var ionperson = document.getElementById("ionperson");
      if (ionperson) {
        ionperson.addEventListener("click", function (e) {
          window.location.href = "./designation.php";
        });
      }
      
      var fluentpersonClock24Filled = document.getElementById(
        "fluentpersonClock24Filled"
      );
      if (fluentpersonClock24Filled) {
        fluentpersonClock24Filled.addEventListener("click", function (e) {
          window.location.href = "./apply-leave.html";
        });
      }
      
      var uiscalender = document.getElementById("uiscalender");
      if (uiscalender) {
        uiscalender.addEventListener("click", function (e) {
          window.location.href = "./documents.php";
        });
      }
      
      var fluentpersonArrowBack28Fi = document.getElementById(
        "fluentpersonArrowBack28Fi"
      );
      if (fluentpersonArrowBack28Fi) {
        fluentpersonArrowBack28Fi.addEventListener("click", function (e) {
          window.location.href = "./attendence_mgr.php";
        });
      }
      </script>
  </body>
</html>
