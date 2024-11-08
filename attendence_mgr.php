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

  <link rel="stylesheet" href="./css/global.css" />
  <link rel="stylesheet" href="./css/attendence.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <style>
    table {
      z-index: 100;
      border-collapse: collapse;
      background-color: white;
    }

    th,
    td {
      padding: 1em;
      border-bottom: 2px solid rgb(193, 193, 193);
    }

    .even {
      border-bottom: 2px solid #e8e8e8ba;
    }

    .odd {
      background-color: #e9e9e9 !important;
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
      transition: max-height 0.25s ease-in;
    }

    .mgr-view{
          margin-top:-85px;
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
            margin-left:-90px;
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
  <div class="attendence4">
    <div class="bg14"></div>
    <div class="rectangle-parent22" style="margin-left:260px;">
      <div class="frame-child187"></div>
      <div class="dropdown">
        <button class="attendence5" style="margin-left: -300px; border: none; background: none; margin-top: -14px;" for="btnControl"><img src="./public/9710841.png" width="50px" alt="">
          <div class="dropdown-content" style="margin-left: -40px; border-radius: 20px;">

            
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
            if (in_array('SECURITY GAURDS', $manager_designations)) {
              $inClause = implode("','", $manager_designations);
              $sql = "SELECT empname FROM emp WHERE emp.desg IN ('$inClause')";

              $result = mysqli_query($con, $sql);

              if (mysqli_num_rows($result) > 0) {
                echo '<a href="sheet_gaurd_mgr.php" target="_blank">Overall Attendance(SG)</a>';
              }
            } else {
              echo '';
            }
            ?>
            <?php
      if ($work_location == 'Visakhapatnam') {
        ?>
<a href="sheet_mgr.php" target="_blank" style="border-bottom: 1px solid rgb(185, 185, 185);">Overall Attendance</a>
     
<?php } ?>
          </div>
        </button>
      </div>
      <a class="frame-child188" style="margin-left: -150px;"> </a>
      <a class="frame-child189" style="margin-left: -150px;" id="rectangleLink1"> </a>
      <a class="attendence5" style="margin-left: -150px;">Attendance</a>
      <a class="records5" href="attendancelog_mgr.php" id="records" style="margin-left: -180px; width:200px;">Attendance Log</a>
      <a class="frame-child189" style="margin-left: 85px;" id="rectangleLink1"> </a>
      <a class="punch-inout4" href="remote_attendance_mgr.php" id="punchINOUT"style="margin-left: -169px; width:250px;">Remote Attendance</a>
    </div>
    <div class="rectangle-parent23" style="overflow-y:auto;">
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
          $employee_query = "SELECT emp.empstatus,emp.emp_no, emp.empname, emp.pic, emp.dept, CamsBiometricAttendance.*
          FROM emp
          INNER JOIN CamsBiometricAttendance ON emp.UserID = CamsBiometricAttendance.UserID
          WHERE emp.desg IN ('$inClause') 
          ORDER BY CamsBiometricAttendance.AttendanceTime DESC";
          }elseif ($work_location == 'Gurugram') {
            $employee_query = "SELECT emp.empstatus,emp.emp_no, emp.empname, emp.pic, emp.dept, CamsBiometricAttendance_GGM.*
            FROM emp
            INNER JOIN CamsBiometricAttendance_GGM ON emp.UserID = CamsBiometricAttendance_GGM.UserID
            WHERE emp.desg IN ('$inClause') 
            ORDER BY CamsBiometricAttendance_GGM.AttendanceTime DESC";
            }
          $employee_result = mysqli_query($con, $employee_query);
          $cnt = 1;
      ?>

          <table class="data" style="margin-left: auto; margin-right:auto;">
            <tr>
              <th>Date</th>
              <th style="border-left: 2px solid rgb(182, 182, 182);"></th>
              <th>Employee Name</th>
              <th colspan="2" style="white-space:nowrap; border-left: 2px solid rgb(182, 182, 182);">In Time <span style="margin-left:110px;"> -</span><span style="margin-left:50px;"> Input Type</span></th>
              <th colspan="2" style="white-space:nowrap;border-left: 2px solid rgb(182, 182, 182);">Out Time <span style="margin-left:70px;"> -</span><span style="margin-left:30px;"> Input Type</span></th>
            </tr>
            <?php
            $userCheckOut = array();
            $prevDay = null;

            while ($result = mysqli_fetch_assoc($employee_result)) {
              $userId = $result['UserID'];
              $dayOfMonth = date('j', strtotime($result['AttendanceTime']));
              $formattedDate = date('D j M', strtotime($result['AttendanceTime']));
              $rowColorClass = ($dayOfMonth % 2 == 0) ? 'even' : 'odd';

              if ($result['AttendanceType'] == 'CheckOut') {
                $userCheckOut[$userId] = array(
                  'AttendanceTime' => $result['AttendanceTime'],
                  'InputType' => $result['InputType'],
                  'Department' => $result['dept']
                );
              } elseif ($result['AttendanceType'] == 'CheckIn') {
                $currentDay = date('j', strtotime($result['AttendanceTime']));
                $borderBottom = ($prevDay !== null && $currentDay !== $prevDay) ? 'border-top: 4px solid #FB8B0B;' : '';

                $inTimeColor = (strtotime($result['AttendanceTime']) > strtotime('9:40 AM', strtotime($result['AttendanceTime']))) ? 'color: red !important;' : 'color: green !important;';

                $outTimeColors = isset($userCheckOut[$userId]) ? getColorForCheckOut($userCheckOut[$userId]) : array('color: red !important;', 'color: red !important;');
                $outTimeColor = $outTimeColors[0];

            ?>
                <tr class="<?php echo $rowColorClass; ?>" style="<?php echo $borderBottom; ?>">
                  <td style="white-space:nowrap;"><?php echo $formattedDate; ?></td>
                  <td style="border-left: 2px solid rgb(182, 182, 182);"><img class="hovpic" src="pics/<?php echo $result['pic']; ?>" width="40px" height="40px" style="border-radius: 50px; border: 0.5px solid rgb(161, 161, 161);"></td>
                  <td><?php echo $result['empname']; ?></td>

                  <td style="border-left: 2px solid rgb(182, 182, 182); <?php echo $inTimeColor; ?>">
                    <?php echo $result['AttendanceTime']; ?>
                  </td>
                  <td>
                    <?php echo $result['InputType']; ?>
                  </td>
                  <td style="border-left: 2px solid rgb(182, 182, 182); <?php echo $outTimeColor; ?>">
                    <?php
                    if (isset($userCheckOut[$userId])) {
                      echo $userCheckOut[$userId]['AttendanceTime'];
                    } else {
                      echo '<span style="color: red !important;">Yet to Check Out!</span>';
                    }
                    ?>
                  </td>
                  <td>
                    <?php
                    if (isset($userCheckOut[$userId])) {
                      echo $userCheckOut[$userId]['InputType'];
                    } else {
                      echo '<span style="color: red !important;">Yet to Check Out!</span>';
                    }
                    ?>
                  </td>
                </tr>
            <?php

                $prevDay = $currentDay;
              }
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
      <?php
      function getColorForCheckOut($checkOutInfo)
      {
        $outTimeColor = 'color: red !important;';
        $outTimeColor1 = 'color: green !important;';

        if ($checkOutInfo['Department'] == 'HOUSE KEEPING' || $checkOutInfo['Department'] == 'KITCHEN') {
          // Check if the time is beyond 5:30 PM
          if (strtotime($checkOutInfo['AttendanceTime']) >= strtotime('5:30 PM', strtotime($checkOutInfo['AttendanceTime']))) {
            $outTimeColor = 'color: green !important;';
          } else {
            $outTimeColor1 = 'color: red !important;';
          }
        } else {
          // For other departments, check if the time is beyond 6:00 PM
          if (strtotime($checkOutInfo['AttendanceTime']) >= strtotime('6:00 PM', strtotime($checkOutInfo['AttendanceTime']))) {
            $outTimeColor = 'color: green !important;';
          } else {
            $outTimeColor1 = 'color: red !important;';
          }
        }

        // Return both colors as an array
        return array($outTimeColor, $outTimeColor1);
      }
      ?>



    </div>
    <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

    <img class="attendence-item" alt="" src="./public/rectangle-2@2x.png" />

    <img class="logo-1-icon14" alt="" src="./public/logo-1@2x.png" />

    <a class="anikahrm14" href="./dash_mgr.php" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./dash_mgr.php" id="attendenceManagement">Attendance Management</a>

     <?php if ($manager_status == 1): ?>
      <a href="employee-dashboard.php" target="_blank" class="attendence-inner employeedashboard-inner mgr-view dashboard14">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                <polygon points="12 15 17 21 7 21 12 15"></polygon>
            </svg>
            <span>My View</span>
        </a>
    <?php endif; ?>
    <button class="attendence-inner"><a href="logout.php" style="color:white; text-decoration:none; font-size:25px; margin-left:20px;">Logout</a></button>
   
    <img class="attendence-child2" style="margin-top: -50px;" alt="" src="./public/rectangle-4@2x.png" />

    <a class="dashboard14" href="./dash_mgr.php" id="dashboard">Dashboard</a>
    <a class="fluentpeople-32-regular14" id="fluentpeople32Regular">
      <img class="vector-icon73" alt="" src="./public/vector7.svg" />
    </a>
    <a class="employee-list14" id="employeeList">Employee List</a>
    <a class="akar-iconsdashboard14" href="./dash_mgr.php" id="akarIconsdashboard">
      <img class="vector-icon74" alt="" src="./public/vector3.svg" />
    </a>
    <img class="tablerlogout-icon14" alt="" src="./public/tablerlogout.svg" />

    <a class="leaves14" id="leaves">Leaves</a>
    <a class="fluentperson-clock-20-regular14" id="fluentpersonClock20Regular">
      <img class="vector-icon75" alt="" src="./public/vector1.svg" />
    </a>
    <a class="attendance14" style="margin-top: -50px;">Attendance</a>
    <a class="uitcalender14" style="margin-top: -50px;">
      <img class="vector-icon77" alt="" src="./public/vector11.svg" />
    </a>
    <div class="oouinext-ltr3"></div>
  </div>

  <script>
    var rectangleLink1 = document.getElementById("rectangleLink1");
    if (rectangleLink1) {
      rectangleLink1.addEventListener("click", function(e) {
        window.location.href = "./attendancelog_mgr.php";
      });
    }

    var rectangleLink2 = document.getElementById("rectangleLink2");
    if (rectangleLink2) {
      rectangleLink2.addEventListener("click", function(e) {
        window.location.href = "./attendancelog_mgr.php";
      });
    }

    var rectangleLink3 = document.getElementById("rectangleLink3");
    if (rectangleLink3) {
      rectangleLink3.addEventListener("click", function(e) {
        window.location.href = "./my-attendence.php";
      });
    }

    var records = document.getElementById("records");
    if (records) {
      records.addEventListener("click", function(e) {
        window.location.href = "./attendancelog_mgr.php";
      });
    }

    var punchINOUT = document.getElementById("punchINOUT");
    if (punchINOUT) {
      punchINOUT.addEventListener("click", function(e) {
        window.location.href = "./punchout.php";
      });
    }

    var myAttendence = document.getElementById("myAttendence");
    if (myAttendence) {
      myAttendence.addEventListener("click", function(e) {
        window.location.href = "./my-attendence.php";
      });
    }

    var anikaHRM = document.getElementById("anikaHRM");
    if (anikaHRM) {
      anikaHRM.addEventListener("click", function(e) {
        window.location.href = "./dash_mgr.php";
      });
    }

    var attendenceManagement = document.getElementById("attendenceManagement");
    if (attendenceManagement) {
      attendenceManagement.addEventListener("click", function(e) {
        window.location.href = "./dash_mgr.php";
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

    var leaves = document.getElementById("leaves");
    if (leaves) {
      leaves.addEventListener("click", function(e) {
        window.location.href = "./leave-management_mgr.php";
      });
    }

    var fluentpersonClock20Regular = document.getElementById(
      "fluentpersonClock20Regular"
    );
    if (fluentpersonClock20Regular) {
      fluentpersonClock20Regular.addEventListener("click", function(e) {
        window.location.href = "./leave-management_mgr.php";
      });
    }

    var onboarding = document.getElementById("onboarding");
    if (onboarding) {
      onboarding.addEventListener("click", function(e) {
        window.location.href = "./onboarding.php";
      });
    }

    var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
    if (fluentMdl2leaveUser) {
      fluentMdl2leaveUser.addEventListener("click", function(e) {
        window.location.href = "./onboarding.php";
      });
    }
  </script>
</body>

</html>