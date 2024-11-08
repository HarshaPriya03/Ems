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

  <link rel="stylesheet" href="./css/my-attendence.css" />
  <link rel="stylesheet" href="./css/attendence.css" />
  <link rel="stylesheet" href="./css/global.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;600&display=swap" />
  <style>
    td {
      display: block;
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <div class="my-attendence">
    <div class="bg"></div>
    <img class="my-attendence-child" alt="" src="./public/rectangle-1@2x.png" />

    <img class="my-attendence-item" alt="" src="./public/rectangle-2@2x.png" />

    <a class="anikahrm" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm">HRM</span>
    </a>
    <a class="attendance-management" id="attendanceManagement">Attendance Management</a>
    <button class="my-attendence-inner"><a href="logout.php" style="color:white; text-decoration:none; font-size:25px; margin-left:20px;">Logout</a></button>

    <img class="rectangle-icon" style=" margin-top: -50px;" alt="" src="./public/rectangle-4@2x.png" />

    <a class="dashboard" id="dashboard" href="./dash_mgr.php">Dashboard</a>
    <a class="employee-list" id="employeeList" href="./employee-management_mgr.php">Employee List</a>
    <a class="akar-iconsdashboard" style="margin-top: 130px;" id="akarIconsdashboard">
      <img class="vector-icon1" alt="" src="./public/vector1.svg" />
    </a>
    <img class="tablerlogout-icon" alt="" src="./public/tablerlogout.svg" />

    <a class="leaves" id="leaves" href="./leave-management_mgr.php">Leaves</a>
    <a class="fluentperson-clock-20-regular" style="margin-top: -65px;" id="fluentpersonClock20Regular">
      <img class="vector-icon2" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector2.svg" />
    </a>
    <a class="fluent-mdl2leave-user" style="margin-top: -200px;" id="fluentMdl2leaveUser">
      <img class="vector-icon3" alt="" src="./public/vector3.svg" />
    </a>
    <a class="attendance" style=" margin-top: -50px;" href="attendence.php">Attendance</a>
    <a class="uitcalender" style="margin-top: -50px">
      <img class="vector-icon4" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector4.svg" />
    </a>
    <div class="rectangle-parent" style="width: 1200px;">
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
                  $cssClass = 'frame-child';
                  $typeLabel = 'CHECK IN:';
                  break;
                case 'BreakIn':
                  $cssClass = 'frame-child';
                  $typeLabel = 'BREAK IN:';
                  break;
                case 'CheckOut':
                case 'BreakOut':
                  $cssClass = 'frame-child123';
                  $typeLabel = $result['AttendanceType'] == 'CheckOut' ? 'CHECK OUT:' : 'BREAK OUT:';
                  break;
              }
            ?>
              <tr>
                <td>
                  <div class="<?php echo $cssClass; ?>"></div>
                  <div class="frame-child1" style=" margin-top: -130px; margin-left: 10px;"></div>
                  <p style="margin-left: 13px; margin-top: -50px;font-size: 20px; color:white;"><?php echo $formattedDate1; ?></p>
                  <p style="margin-left: 32px; margin-top: -90px; font-weight: 800; font-size: 35px; color:white;"><?php echo $formattedDate; ?></p>
                  <div class="line-div" style="margin-left: <?php echo $cssClass === 'frame-child' ? '545' : '545'; ?>px; margin-top: -80px;"></div>
                  <p style="font-size: 30px; color: black; margin-left: 600px; margin-top: -60px;">Input Type:</p>
                  <p style="font-size: 30px; color: black; margin-left: 760px; margin-top: -64px;"><?php echo $result['InputType']; ?></p>

                  <p style="font-size: 30px; color: black; margin-left: 150px; margin-top: -80px;"><?php echo $typeLabel; ?></p>
                  <p style="font-size: 30px; color: black; margin-left: 320px; margin-top: -65px;"><?php echo $formattedDateWithLabels; ?></p>
                  <p style="font-size: 20px; color: black; margin-left: 150px; margin-top: -20px;"><?php echo $result['empname']; ?></p>
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
    <div class="rectangle-parent22" style="margin-left:260px;">
      <div class="frame-child187"></div>

      <a class="frame-child188" style="margin-left: -150px; background-color: #E8E8E8;"> </a>
      <a class="frame-child189" style="margin-left: -150px; background-color: #ffe2c6;" id="rectangleLink1"> </a>
      <a href="" class="frame-child190" style="margin-left: -150px;" id="rectangleLink2"> </a>
      <a class="attendence5" href="attendence_mgr.php" style="margin-left: -150px; color: black;">Attendance</a>
      <a class="records5" href="attendancelog_mgr.php" id="records" style="margin-left: -180px; width:200px; color:#ff5400;">Attendance Log</a>
    </div>
    <img class="logo-1-icon" alt="" src="./public/logo-1@2x.png" />
  </div>
</body>

</html>