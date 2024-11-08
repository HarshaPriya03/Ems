<?php
session_start();
@include '../inc/config.php';

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

    <link rel="stylesheet" href="./empmobcss/globalzxc.css" />
    <link rel="stylesheet" href="./empmobcss/mgr-attendance-mob.css" />
    <!-- <link rel="stylesheet" href="./css/attendenceemp-mob.css" /> -->
    <link rel="stylesheet" href="./empmobcss/empjob-details-mob.css" />
    <link rel="stylesheet" href="./empmobcss/attendancelogemp-mob.css" />
    <link rel="stylesheet" href="./llog.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap"
    />
    <style>
      .rectangle-parent23 {
position: absolute;
height: calc(100% - 214px);
top: 111px;
bottom: 103px;
left: calc(50% - 167px);
width: 333px;
overflow-y: auto;
font-size: var(--font-size-smi);
color: var(--color-darkslategray-200);
}
    </style>
  </head>
  <body>
    <div class="mgrattendance-mob" style="height: 100svh;">
      <div class="logo-1-group">
        <img class="logo-1-icon1" alt="" src="./public/logo-11@2x.png" />

        <a class="attendance-management" style="width: 300px;">Attendance Management</a>
      </div>
      <div class="mgrattendance-mob-child"></div>
      <div class="mgrattendance-mob-item"></div>
      <div class="rectangle-parent">
        <a class="frame-inner"> </a>
        <a class="rectangle-a"> </a>
        <!--<a class="frame-child1"> </a>-->
        <a href="attendence_mgr.php" class="attendance" style="margin-left: 25px;">Attendance</a>
        <a class="attendance-log">Attendance Log</a>
        <!--<a class="remote-attendance">Remote Attendance</a>-->
      </div>
      <div class="frame-parent">
        <a href="employee-management_mgr.php"><img class="frame-icon" alt="" src="./public/frame-156.svg" /></a>

        <a class="fluentperson-clock-20-regular" href="leave-management_mgr.php">
          <img class="vector-icon" alt="" src="./public/vectorleave.svg" />
        </a>
        <div class="ellipse-div"></div>
        <a class="akar-iconsdashboard" href="dash_mgr.php">
          <img class="vector-icon1" alt="" src="./public/vector1dash.svg" />
        </a>
        <a class="uitcalender" href="attendence_mgr.php">
          <img
            class="vector-icon2"
            alt=""
            src="./public/vector2attenblack.svg"
          />
        </a>
      </div>
      <div class="rectangle-parent23" style="width: 400px; overflow-x: hidden;">
      <?php
      $manager_query = "SELECT desg, work_location FROM manager WHERE email = '$user_name'";
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
          if ($work_location == 'Visakhapatnam') {
            $employee_query = "SELECT emp.emp_no, emp.empname, emp.pic, emp.dept, CamsBiometricAttendance.*
            FROM emp
            INNER JOIN CamsBiometricAttendance ON emp.UserID = CamsBiometricAttendance.UserID
            WHERE emp.desg IN ('$inClause') 
            ORDER BY CamsBiometricAttendance.AttendanceTime DESC";
            }elseif ($work_location == 'Gurugram') {
              $employee_query = "SELECT emp.emp_no, emp.empname, emp.pic, emp.dept, CamsBiometricAttendance_GGM.*
              FROM emp
              INNER JOIN CamsBiometricAttendance_GGM ON emp.UserID = CamsBiometricAttendance_GGM.UserID
              WHERE emp.desg IN ('$inClause') 
              ORDER BY CamsBiometricAttendance_GGM.AttendanceTime DESC";
            }


          $employee_result = mysqli_query($con, $employee_query);
          $cnt = 1;
      ?>
        <table>
        <?php
            while ($result = mysqli_fetch_assoc($employee_result)) {
              $timestamp = strtotime($result['AttendanceTime']);
              $formattedDate = date('D', $timestamp);
              $formattedDate1 = date('d-m-Y', $timestamp);
              $hours = date('H', $timestamp);
              $minutes = date('i', $timestamp);
              $formattedDateWithLabels = "$hours Hrs $minutes mins";

              $cssClass = '';
              $typeLabel = '';

              switch ($result['AttendanceType']) {
                case 'CheckIn':
                  $cssClass = 'frame-child106';
                  $typeLabel = 'CHECK IN:';
                  break;
                case 'BreakIn':
                  $cssClass = 'frame-child106';
                  $typeLabel = 'BREAK IN:';
                  break;
                case 'CheckOut':
                case 'BreakOut':
                  $cssClass = 'frame-child107';
                  $typeLabel = $result['AttendanceType'] == 'CheckOut' ? 'CHECK OUT:' : 'BREAK OUT:';
                  break;
              }
            ?>
          <tr>
            <td style="display: block;">
            <div style="margin-bottom: 18px;">
                <div class="frame-child106 <?php echo $cssClass; ?>"></div>
              <div class="frame-child108" style="margin-top: -67px; margin-left: 4px;"></div>
              <h3 style="color: white; font-size: 21px; font-weight: 500; margin-top: -55px; margin-left: 14px;"><?php echo $formattedDate; ?></h3>
              <h3 style="color: white; font-size: 11px; font-weight: 300; margin-top: -18px; margin-left: 8px;"><?php echo $formattedDate1; ?></h3>
              <p style="margin-left: 80px; margin-top: -52px;"><?php echo $typeLabel; ?></p>
              <p style="margin-left: 80px; margin-top: -10px;"><?php echo $formattedDateWithLabels; ?></p>
              
              <p style="margin-left: 200px; margin-top: -62px;">Input Type:</p>
              <p style="margin-left: 200px; margin-top: -8px;"><?php echo $result['InputType']; ?></p>
              <p style="font-size:10px; margin-left:80px; margin-top:-17px;"><?php echo $result['empname']; ?></p>
              <div class="line-div" style="margin-left: 195px; <?php echo $cssClass === 'frame-child106' ? '545' : '545'; ?>px; margin-top: -70px;"></div>
              </div>
              </td>
          </tr>
          <?php
              $cnt++;
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
  </body>
</html>
