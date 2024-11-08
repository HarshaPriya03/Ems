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
      <h5 class="hr-management">HR Management</h5>
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
      <div class="logout18">Logout</div></a>
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
      <a class="onboarding22" id="onboarding" href="./attendence_mgr.php">Attendance</a>
      <a class="fluentpeople-32-regular18" id="fluentpeople32Regular">
        <img class="vector-icon94" alt="" src="./public/vector7.svg" />
      </a>
      <a class="fluent-mdl2leave-user18" id="fluentMdl2leaveUser">
        <img class="vector-icon95" alt="" src="./public/vector4.svg" />
      </a>
      <a
        class="fluentperson-clock-20-regular18"
        id="fluentpersonClock20Regular"
      >
        <img class="vector-icon96" alt="" src="./public/vector1.svg" />
      </a>

      <img class="index-child2" alt="" src="./public/rectangle-4@2x.png" />

      <a class="dashboard18">Dashboard</a>
      <a class="akar-iconsdashboard18">
        <img class="vector-icon98" alt="" src="./public/vector14.svg" />
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
      <section class="frame-parent">
      <div id="main">
        <div class="frame-item">
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
$manager_query = "SELECT desg FROM manager WHERE email = '$user_name'";
$manager_result = mysqli_query($con, $manager_query);

if ($manager_result) {
    $manager_designations = array();

    while ($row = mysqli_fetch_assoc($manager_result)) {
        $designations = array_map('trim', explode(',', $row['desg']));
        $manager_designations = array_merge($manager_designations, $designations);
    }
    $manager_designations = array_unique(array_filter($manager_designations));

    if (!empty($manager_designations)) {
        $inClause = implode("','", $manager_designations);
        if ($work_location == 'Visakhapatnam') {
        $employee_query = "SELECT emp.emp_no, emp.empname, emp.pic, emp.dept, CamsBiometricAttendance.*
        FROM emp
        INNER JOIN CamsBiometricAttendance ON emp.UserID = CamsBiometricAttendance.UserID
        WHERE emp.desg IN ('$inClause') AND DATE(AttendanceTime) = '$currentDate' ORDER BY AttendanceTime DESC";
  }elseif ($work_location == 'Gurugram') {
        $employee_query = "SELECT emp.emp_no, emp.empname, emp.pic, emp.dept, CamsBiometricAttendance_GGM.*
        FROM emp
        INNER JOIN CamsBiometricAttendance_GGM ON emp.UserID = CamsBiometricAttendance_GGM.UserID
        WHERE emp.desg IN ('$inClause') AND DATE(AttendanceTime) = '$currentDate' ORDER BY AttendanceTime DESC";
  }
        $employee_result = mysqli_query($con, $employee_query);
        $cnt = 1;

        while ($row = mysqli_fetch_assoc($employee_result)) {
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
            if (strtotime($row['AttendanceTime']) >= strtotime("17:30:00")) {
                echo '<p style="font-size: 13px; margin-left: 30px; margin-top: -8px; color: black;">' . $row['AttendanceTime'] . '</p>';
            } elseif (strtotime($row['AttendanceTime']) > strtotime("9:40:00 AM")) {
                echo '<p style="font-size: 13px; margin-left: 30px; margin-top: -8px; color: red;">' . $row['AttendanceTime'] . '</p>';
            } else {
                echo '<p style="font-size: 13px; margin-left: 30px; margin-top: -8px; color: green;">' . $row['AttendanceTime'] . '</p>';
            }

            echo '<p style="font-size: 13px; margin-left: 30px; margin-top: -8px;">' . $row['InputType'] . '</p>
                <img class="hovpic" src="pics/' . $row['pic'] . '" width="50px" style="margin-top: -40px; margin-left: 200px; border-radius: 60%; height: 50px;" alt="">
                </td>
                </tr>
                </table>';
        }
        mysqli_free_result($employee_result);
    } else {
        die("Error: No valid designations found for the manager.");
    }
} else {
    die("Error: " . mysqli_error($con));
}
?>

          </div>
        </div>
      </div>
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
$manager_query = "SELECT desg FROM manager WHERE email = '$user_name'";
$manager_result = mysqli_query($con, $manager_query);

if ($manager_result) {
    $manager_designations = array();

    while ($row = mysqli_fetch_assoc($manager_result)) {
        $designations = array_map('trim', explode(',', $row['desg']));
        $manager_designations = array_merge($manager_designations, $designations);
    }
    $manager_designations = array_unique(array_filter($manager_designations));

    if (!empty($manager_designations)) {
        $inClause = implode("','", $manager_designations);
        
        function formatDateTime($dateTime)
        {
            $formattedDate = date('Y-m-d', strtotime($dateTime));
            return (substr($dateTime, 11) === '00:00:00') ? $formattedDate : $dateTime;
        }
       
$employee_query = "SELECT e.empname, e.empph, l.leavetype, l.from, l.to, l.status, l.status1, e.pic
FROM emp e
JOIN leaves l ON e.empname = l.empname 
WHERE e.desg IN ('$inClause') and l.work_location='$work_location'
    AND e.empstatus = 0 
    AND (
        (l.status = 1 AND l.status1 = 1) OR 
        (l.status = 1 AND l.status1 = 0)
    ) 
    AND '$currentDate' BETWEEN DATE(l.from) AND DATE(l.to)";
    
  
        $employee_result = mysqli_query($con, $employee_query);

        if (mysqli_num_rows($employee_result) > 0) {
            while ($row = mysqli_fetch_assoc($employee_result)) {
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
            mysqli_free_result($employee_result);
        } else {
          echo '<div style="text-align: center; margin-top: 50px; font-size: 18px;color:#097969;">No employee on leave today</div>';
        }
    } else {
        die("Error: No valid designations found for the manager.");
    }
} else {
    die("Error: " . mysqli_error($con));
}
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
$manager_query = "SELECT desg FROM manager WHERE email = '$user_name'";
$manager_result = mysqli_query($con, $manager_query);

if ($manager_result) {
    $manager_designations = array();

    while ($row = mysqli_fetch_assoc($manager_result)) {
        $designations = array_map('trim', explode(',', $row['desg']));
        $manager_designations = array_merge($manager_designations, $designations);
    }
    $manager_designations = array_unique(array_filter($manager_designations));

    if (!empty($manager_designations)) {
        $inClause = implode("','", $manager_designations);

        $employee_query = "SELECT a.empname, e.empph, e.pic, e.desg 
            FROM absent a
            JOIN emp e ON a.empname = e.empname
            WHERE e.desg IN ('$inClause') AND DATE(a.AttendanceTime) = '$currentDate'";
        $employee_result = mysqli_query($con, $employee_query);

        if (mysqli_num_rows($employee_result) > 0) {
            while ($row = mysqli_fetch_assoc($employee_result)) {
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
                        </tr>
                    </table>';
            }
            mysqli_free_result($employee_result);
        } else {
          echo '<div style="text-align: center; margin-top: 50px; font-size: 18px;color:#097969;">No absentees today</div>';
        }
    } else {
        die("Error: No valid designations found for the manager.");
    }
} else {
    die("Error: " . mysqli_error($con));
}
?>
          </div>
        </div>
      </div>
      <div id="main3">

        <div class="frame-item" style="margin-left: 900px; z-index: 100;">

          <h3 class="check-inout" style=" z-index: 100;">Employee Request's</h3>
          <div class="frame-inner" style=" z-index: 100;"></div>
          <div style="overflow-y: auto; height: 460px; width: 285px; margin-top: 60px; z-index: 99999 !important;">
          <?php
$manager_query = "SELECT desg FROM manager WHERE email = '$user_name'";
$manager_result = mysqli_query($con, $manager_query);

if ($manager_result) {
    $manager_designations = array();

    while ($row = mysqli_fetch_assoc($manager_result)) {
        $designations = array_map('trim', explode(',', $row['desg']));
        $manager_designations = array_merge($manager_designations, $designations);
    }
    $manager_designations = array_unique(array_filter($manager_designations));

    if (!empty($manager_designations)) {
        $inClause = implode("','", $manager_designations);
        $employee_query = "SELECT leaves.empname, leaves.applied, leaves.status, leaves.status1, emp.pic
        FROM leaves
        INNER JOIN emp ON leaves.empname = emp.empname
        WHERE emp.desg IN ('$inClause') AND leaves.work_location='$work_location' AND ((leaves.status = 0 AND leaves.status1 = 0) OR (leaves.status = 4 AND leaves.status1 = 0)) 
        ORDER BY leaves.applied DESC";
        $employee_result = mysqli_query($con, $employee_query);

        if (mysqli_num_rows($employee_result) > 0) {
            $formattedDate = ''; 
            while ($row = mysqli_fetch_assoc($employee_result)) {
                $status = $row['status'];
                $status1 = $row['status1'];
                $formattedDate = date('H:i:s d-m-Y', strtotime($row['applied']));

                echo '<table style="margin-top: -60px;">';
                echo '<tr class="hover-dim">';
                echo '<td style="display: block;margin-bottom: 5px;padding:4px;">';
                echo '<a href="leave-management_mgr.php" style="text-decoration:none;color:black;">';
                echo '<div style="z-index: 9999; margin-top: 60px; margin-left: 12px; border-radius: var(--br-mini);background-color: var(--color-white);box-shadow: 0 4px 4px rgba(0, 0, 0, 0.25);width: 257px;height: 130px;"></div>';
                echo '<div style="z-index: 9999; margin-top: -120px; margin-left: 30px; border-radius: var(--br-8xs); background-color: var(--color-lightblue);width: 148px; height: 24px;"></div>';
                echo '<p style="font-size: 14px; margin-left: 43px; margin-top: -22px;">Leave Request</p>';
                echo '<p style="font-size: 12px; margin-left: 30px; margin-top: -5px;">' . $row['empname'] . '</p>';
                echo '<p style="font-size: 12px; margin-left: 30px; margin-top: -5px; width: 130px;">[Pending from-</p>';
                echo '<p style="font-size: 12px; margin-left: 30px; margin-top: -10px; width: 130px;">' . $formattedDate . ']</p>';
                echo '<p style="font-size: 12px; margin-left: 30px; margin-top: -7px;">' .
                    (($status == '0' && $status1 == '0') ? 'HR-Action Pending' : (($status == '3' && $status1 == '0') ? 'Pending at Approver' : '')) . '</p>';
                echo '<img class="hovpic" src="pics/' . $row['pic'] . '" width="50px" style="margin-top: -60px; margin-left: 190px; border-radius: 50px;height:50px;" alt="">';
                echo '</a>';
                echo '</td>';
                echo '</tr>';
                echo '</table>';
            }
            mysqli_free_result($employee_result);
        } else {
          echo '<div style="text-align: center; margin-top: 50px; font-size: 18px;color:#097969;">No requests today</div>';
        }
    } else {
        die("Error: No valid designations found for the manager.");
    }
} else {
    die("Error: " . mysqli_error($con));
}


?>

          </div>
        </div>
      </div>
      <div class="chart" style="display: flex; gap: 20px; margin-left: 400px; width: 335px; margin-top: 520px;">
        <div class="frame-item" style="height: 340px; margin-top: 540px; margin-left: 300px; width: 885px;"></div>
        <canvas id="myChart1" style="width: 500px; height: 400px; margin-top: 90px; z-index: 999999;"></canvas>
        <canvas id="myChart" style="margin-top: 20px; z-index: 999999;"></canvas>
        <div style="z-index: 999999999; background-color: white; height: 40px; width: 270px; margin-left: -800px; margin-top: 30px; border-radius: 10px; display: flex; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);">
          <img src="./public/groupicon.png" width="62px" height="60px" style="margin-top: -12px;" alt="">
          <p style="font-size: 14px;  margin-top: 10px;margin-left:-10px;">Total Employees Managed => <sub style="font-size: 20px; font-weight: 600;"><?php echo $count4; ?></sub> </p>
        </div>
      </div>
      <div id="main4">
        <div class="frame-item" style="  margin-top: 540px; height: 340px;">
          <h3 class="check-inout">Birthday's</h3>
          <div class="frame-inner"></div>
          <div style="position:absolute;overflow-y: auto; height: 270px; width: 285px; margin-top: 60px; background-color: white; width: 270px; margin-left: 7px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);">
            <?php
            $query = "SELECT pic, empname, empdob, empstatus, work_location 
            FROM emp 
            WHERE empstatus = 0 
            AND work_location = '$work_location'
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

            
            ?>
          </div>
        </div>
      </div>
    </section>
      </div>
      <img class="tablerlogout-icon18" alt="" src="./public/tablerlogout.svg" />
    </div>
    <?php
    $manager_query = "SELECT desg FROM manager WHERE email = '$user_name'";
    $manager_result = mysqli_query($con, $manager_query);
    $manager_designations = array();
    while ($row = mysqli_fetch_assoc($manager_result)) {
        $designations = array_map('trim', explode(',', $row['desg']));
        $manager_designations = array_merge($manager_designations, $designations);
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
    
    
    $sql2 = "SELECT COUNT(*) as count FROM emp e
        JOIN leaves l ON e.empname = l.empname 
        WHERE e.desg IN ('$inClause') AND l.work_location = '$work_location' AND l.status = 1 AND l.status1 = 1 AND '$currentDate'  BETWEEN DATE(l.from) AND DATE(l.to)";

    $result2 = $con->query($sql2);
    $row2 = $result2->fetch_assoc();
    $count2 = $row2['count'];

    $sql3 = "SELECT COUNT(*) as count FROM absent a
        JOIN emp e ON a.empname = e.empname
        WHERE  e.desg IN ('$inClause')  AND TIMESTAMP(DATE(AttendanceTime)) = '$currentDate' ";

    $result3 = $con->query($sql3);
    $row3 = $result3->fetch_assoc();
    $count3 = $row3['count'];

    $sql4 = "SELECT COUNT(*) as count FROM emp WHERE emp.desg IN ('$inClause') AND work_location = '$work_location' ";

    $result4 = $con->query($sql4);
    $row4 = $result4->fetch_assoc();
    $count4 = $row4['count'];

    ?>
</body>
<script>
  var box  = document.getElementById('box');
var down = false;


function toggleNotifi(){
	if (down) {
		box.style.height  = '0px';
		box.style.opacity = 0;
		down = false;
	}else {
		box.style.height  = '395px';
		box.style.opacity = 1;
		down = true;
	}
}
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-piechart-outlabels@0.1.4/dist/chartjs-plugin-piechart-outlabels.min.js"></script>
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
