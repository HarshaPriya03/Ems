<?php
session_start();
@include '../inc/config.php';
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

  <link rel="stylesheet" href="./empmobcss/global.css" />
  <link rel="stylesheet" href="./empmobcss/mgr-dashboard-mob.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap" />
  <style>
    .logo-1-icon10 {
      position: absolute;
      top: 10px;
      right: 10px;
      width: 55px;
      height: 55px;
      object-fit: cover;
    }

    ::-webkit-scrollbar {
      width: 6px;
    }

    ::-webkit-scrollbar-track {
      background-color: #ebebeb;
      -webkit-border-radius: 10px;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
      -webkit-border-radius: 10px;
      border-radius: 10px;
      background: #bebebe;
    }

    .circle {
      background: red;
      border-radius: 50%;
      display: inline-block;
      width: 30px;
      height: 30px;
      line-height: 30px;
      text-align: center;
      color: black;
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

    .button-87 {
      margin-left: 180px;
      padding: 10px 10px;
      text-align: center;
      text-transform: uppercase;
      transition: 0.5s;
      background-size: 200% auto;
      color: white;
      outline: 1px solid white;
      border-radius: 10px;
      display: block;
      border: 0px;
      font-weight: bold;
      touch-action: manipulation;
      box-shadow: 0px 0px 14px -7px #f09819;
      background-image: linear-gradient(45deg, #FF512F 0%, #F09819 51%, #FF512F 100%);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .button-87:hover {
      background-position: right center;
      color: #fff;
      text-decoration: none;
    }

    .button-87:active {
      transform: scale(0.95);
    }

    .button-87 svg {
      flex-shrink: 0;
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

      xhr.open("GET", "../getattendence.php", true);
      xhr.send();
    }

    setInterval(checkForUpdates, 1000);
  </script>
</head>

<body>
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
    }
  }
  ?>
  <?php

  if (!isset($_SESSION['user_name'])) {
    header("Location: loginpage.php");
    exit;
  }

  $select = "SELECT uf.*, m.status as manager_status 
           FROM user_form uf
           LEFT JOIN manager m ON uf.email = m.email 
           WHERE uf.email = ?";

  $stmt = mysqli_prepare($con, $select);
  mysqli_stmt_bind_param($stmt, "s", $_SESSION['user_name']);
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
  <div class="mgrdashboard-mob" style="height: 100svh;">
    <div class="logo-1-group">
      <img class="logo-1-icon1" alt="" src="./public/logo-11@2x.png" />

      <a class="employee-management1" style="width: 300px;">Employee Management</a>
    </div>
    <a href="../logout.php"><img class="logo-1-icon10" alt="" src="./public/Logout-removebg-preview.png" /></a>
    <div class="mgrdashboard-mob-child"></div>
    <div class="mgrdashboard-mob-item">

      <?php if ($manager_status == 1) : ?>
        <a href="emp-dashboard-mob.php">
          <button class="button-87">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
              <polygon points="12 15 17 21 7 21 12 15"></polygon>
            </svg>
            My View
          </button>
        </a>
      <?php endif; ?>

    </div>
    <div class="frame-parent">
      <a href="employee-management_mgr.php"><img class="frame-inner" alt="" src="./public/frame-156.svg" /></a>
      <?php if ($result_count > 0) { ?>
        <span class="circle" style="position: relative;top:20px;">
          <?php echo $result_count ?>
        </span>
      <?php
      }
      ?>
      <a class="fluentperson-clock-20-regular" href="leave-management_mgr.php">
        <img class="vector-icon" alt="" src="./public/vectorleave.svg" />

      </a>
      <a class="uitcalender" href="attendence_mgr.php">
        <img class="vector-icon1" alt="" src="./public/vectoratten.svg" />
      </a>
      <div class="ellipse-div"></div>
      <a class="akar-iconsdashboard">
        <img class="vector-icon2" alt="" src="./public/vector.svg" />
      </a>
    </div>
    <div class="frame-group" style="width: 340px;">
      <!-- Emp on duty -->
      <div class="rectangle-parent">
        <div class="rectangle-div"></div>
        <div class="employees-on-duty">Employee’s on duty</div>
        <div class="line-div"></div>
        <div class="frame-container" style="width: 310px;">
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
              if ($work_location == 'Visakhapatnam') {
                $employee_query = "SELECT emp.emp_no, emp.empname, emp.pic, emp.dept, CamsBiometricAttendance.*
              FROM emp
              INNER JOIN CamsBiometricAttendance ON emp.UserID = CamsBiometricAttendance.UserID
              WHERE emp.desg IN ('$inClause') AND DATE(AttendanceTime) = '$currentDate' ORDER BY AttendanceTime DESC";
              } elseif ($work_location == 'Gurugram') {
                $employee_query = "SELECT emp.emp_no, emp.empname, emp.pic, emp.dept, CamsBiometricAttendance_GGM.*
        FROM emp
        INNER JOIN CamsBiometricAttendance_GGM ON emp.UserID = CamsBiometricAttendance_GGM.UserID
        WHERE emp.desg IN ('$inClause') AND DATE(AttendanceTime) = '$currentDate' ORDER BY AttendanceTime DESC";
              }
              $employee_result = mysqli_query($con, $employee_query);
              $cnt = 1;

              while ($row = mysqli_fetch_assoc($employee_result)) {
                $attendanceTime = strtotime($row['AttendanceTime']);
                echo '<table style="margin-top: -50px; margin-left: -15px;">
                <tr>
                    <td style="display: block; margin-bottom: 145px;">
                        <div style="z-index: 99999; position: absolute; background-color: white; width: 300px; margin-left: 10px; margin-top: 50px; height: 90px; border-radius: 10px;"></div>
                        <img src="../pics/' . $row['pic'] . '" alt="" width="50px" style="position: absolute; margin-left: 257px; margin-top:65px; z-index: 99999999; border-radius: 70%;height:55px; ">
                        <div style="position: absolute; z-index: 999999; background-color: #d9ffcc; margin-top: 60px; margin-left: 25px; width: 60px; height: 20px; display: flex; align-items: center; justify-content: center; border-radius: 5px; font-size:12px">' . $row['AttendanceType'] . '</div>
                        <p style="position: absolute; margin-top: 85px; z-index: 9999999999; margin-left: 25px; font-size:12px">' . $row['empname'] . '</p>
                        <p style="position: absolute; margin-top: 100px; color: rgb(255, 47, 47); z-index: 9999999999; margin-left: 25px; font-size:12px">' . $row['AttendanceTime'] . '</p>
                        <p style="position: absolute; margin-top: 115px; z-index: 9999999999; margin-left: 25px; font-size:12px">' . $row['InputType'] . '</p>
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
      <div class="rectangle-parent9">
        <div class="rectangle-div"></div>
        <div class="employees-on-duty">Employee’s on Leave</div>
        <div class="line-div"></div>
        <div class="frame-container" style="width: 310px;">
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

              function formatDateTime($dateTime)
              {
                $formattedDate = date('Y-m-d', strtotime($dateTime));
                return (substr($dateTime, 11) === '00:00:00') ? $formattedDate : $dateTime;
              }
              $employee_query = "SELECT e.empname, e.empph, l.leavetype, l.from, l.to, l.status, l.status1, e.pic
        FROM emp e
        JOIN leaves l ON e.empname = l.empname 
        WHERE e.desg IN ('$inClause') AND l.work_location = '$work_location'
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

                  echo '<table style="margin-top: -50px; margin-left: -15px;">
                    <tr>
                        <td style="display: block; margin-bottom: 145px;">
                            <div style="z-index: 99999; position: absolute; background-color: white; width: 300px; margin-left: 10px; margin-top: 50px; height: 90px; border-radius: 10px;"></div>
                            <img src="../pics/' . $row['pic'] . '" alt="" width="50px" style="position: absolute; margin-left: 257px;  margin-top:65px; z-index: 99999999; border-radius: 70%;height:55px;">
                            <div style="position: absolute; z-index: 999999; background-color: #e5e1ff; margin-top: 60px; margin-left: 25px; width: 80px; height: 20px; display: flex; align-items: center; justify-content: center; border-radius: 5px; font-size:10px">' . $row['leavetype'] . '</div>
                            <p style="position: absolute; margin-top: 85px; z-index: 9999999999; margin-left: 25px; font-size:12px">' . $row['empname'] . '</p>
                            <p style="position: absolute; margin-top: 100px; z-index: 9999999999; margin-left: 25px; font-size:12px">' . $row['empph'] . '</p>
                            <p style="position: absolute; margin-top: 115px; z-index: 9999999999; margin-left: 25px; font-size:12px">' .
                    formatDateTime($fromDateTime) . ' to ' . formatDateTime($toDateTime) . '</p>
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
      <!-- Absentees -->
      <div class="rectangle-parent4">
        <div class="rectangle-div"></div>
        <div class="employees-on-duty">Absentees</div>
        <div class="line-div"></div>
        <div class="frame-container" style="width: 310px;">
          <!-- <table style="margin-top: -50px; margin-left: -15px;">
              <tr>
                  <td style="display: block; margin-bottom: 95px;">
                      <div style="z-index: 99999; position: absolute; background-color: white; width: 300px; margin-left: 10px; margin-top: 50px; height: 90px; border-radius: 10px;"></div>
                      <img src="./public/ellipse-1@2x.png" alt="" width="50px" style="position: absolute; margin-left: 257px; margin-top:85px; z-index: 99999999; ">
                      <div style="position: absolute; z-index: 999999; background-color: #e5e1ff; margin-top: 60px; margin-left: 25px; width: 130px; height: 20px; display: flex; align-items: center; justify-content: center; border-radius: 5px;">desg</div>
                      <p style="position: absolute; margin-top: 85px; z-index: 9999999999; margin-left: 25px;">empname</p>
                      <p style="position: absolute; margin-top: 100px; z-index: 9999999999; margin-left: 25px;">empph</p>
                    </td>
              </tr>
            </table> -->
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
            WHERE e.desg IN ('$inClause') AND DATE(a.AttendanceTime) = '$currentDate' ";
              $employee_result = mysqli_query($con, $employee_query);

              if (mysqli_num_rows($employee_result) > 0) {
                while ($row = mysqli_fetch_assoc($employee_result)) {
                  echo '<table style="margin-top: -50px; margin-left: -15px;">
                        <tr>
                            <td style="display: block; margin-bottom: 95px;">
                                <div style="z-index: 99999; position: absolute; background-color: white; width: 300px; margin-left: 10px; margin-top: 50px; height: 90px; border-radius: 10px;"></div>
                                <img src="../pics/' . $row['pic'] . '" alt="" width="50px" style="position: absolute; margin-left: 257px;  margin-top:65px; z-index: 99999999; border-radius: 70%;height:55px;">
                                <div style="position: absolute; z-index: 999999; background-color: #e5e1ff; margin-top: 60px; margin-left: 25px; width: 130px; height: 20px; display: flex; align-items: center; justify-content: center; border-radius: 5px; font-size:10px;">' . $row['desg'] . '</div>
                                <p style="position: absolute; margin-top: 85px; z-index: 9999999999; margin-left: 25px;font-size:12px;">' . $row['empname'] . '</p>
                                <p style="position: absolute; margin-top: 100px; z-index: 9999999999; margin-left: 25px;font-size:12px;">' . $row['empph'] . '</p>
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
      <!-- Emp Requets -->
      <div class="rectangle-parent13">
        <div class="rectangle-div"></div>
        <div class="employees-on-duty">Employee Requests</div>
        <div class="line-div"></div>
        <div class="frame-container" style="width: 310px;">
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
            WHERE emp.desg IN ('$inClause') AND leaves.work_location = '$work_location' AND ((leaves.status = 0 AND leaves.status1 = 0) OR (leaves.status = 4 AND leaves.status1 = 0)) 
            ORDER BY leaves.applied DESC";
              $employee_result = mysqli_query($con, $employee_query);

              if (mysqli_num_rows($employee_result) > 0) {
                $formattedDate = '';
                while ($row = mysqli_fetch_assoc($employee_result)) {
                  $status = $row['status'];
                  $status1 = $row['status1'];
                  $formattedDate = date('H:i:s d-m-Y', strtotime($row['applied']));

                  echo '<table style="margin-top: -50px; margin-left: -15px;">
                    <tr>
                        <td style="display: block; margin-bottom: 155px;">
                            <div style="z-index: 99999; position: absolute; background-color: white; width: 300px; margin-left: 10px; margin-top: 50px; height: 90px; border-radius: 10px;"></div>
                            <img src="../pics/' . $row['pic'] . '" alt="" width="50px" style="position: absolute; margin-left: 257px;  margin-top:65px; z-index: 99999999; border-radius: 70%;height:55px; ">
                            <div style="position: absolute; z-index: 999999; background-color: #cdedff; margin-top: 60px; margin-left: 25px; width: 100px; height: 20px; display: flex; align-items: center; justify-content: center; border-radius: 5px; font-size:10px;">Leave Requests</div>
                            <p style="position: absolute; margin-top: 85px; z-index: 9999999999; margin-left: 25px; font-size:12px;">' . $row['empname'] . '</p>
                            <p style="position: absolute; margin-top: 100px; z-index: 9999999999; margin-left: 25px; font-size:12px;">Pending From - ' . $formattedDate . '</p>
                            <p style="position: absolute; margin-top: 115px; z-index: 9999999999; margin-left: 25px; font-size:12px;">' .
                    (($status == '0' && $status1 == '0') ? 'HR-Action Pending' : (($status == '3' && $status1 == '0') ? 'Pending at Approver' : '')) . '</p>
                        </td>
                    </tr>
                </table>';
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
  </div>
</body>

</html>