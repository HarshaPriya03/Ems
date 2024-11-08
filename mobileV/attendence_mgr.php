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
    <link rel="stylesheet" href="./empmobcss/mgr-attendance-mob1.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap"
    />
    <style>
          .logo-1-icon10 {
                  position: absolute;
                  top: 10px;
                  right: 10px;
                  width: 55px;
                  height: 55px;
                  object-fit: cover;
                }
           table {
       border: 0;
       width: 100%;
       margin: 0;
       padding: 0;
       border-collapse: collapse;
       border-spacing: 0;
       box-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
     }
     table thead {
       background: #F0F0F0;
       height: 60px !important;
     }
     table thead tr th:first-child {
       padding-left: 45px;
     }
     table thead tr th {
       text-transform: uppercase;
       line-height: 60px !important;
       text-align: left;
       font-size: 11px;
       padding-top: 0px !important;
       padding-bottom: 0px !important;
     }
     table tbody {
       background: #fff;
     }
     table tbody tr {
       border-top: 1px solid #e5e5e5;
       height: 60px;
     }
     table tbody tr td:first-child {
       padding-left: 45px;
     }
     table tbody tr td {
       height: 60px;
       line-height: 60px !important;
       text-align: left;
       padding: 0 10px;
       font-size: 14px;
     }
     table tbody tr td i {
       margin-right: 8px;
     }
     
     @media screen and (max-width: 850px) {
       table {
         border: 1px solid transparent;
         box-shadow: none;
       }
       table thead {
         display: none;
       }
       table tbody tr {
         border-bottom: 20px solid #F6F5FB;
       }
       table tbody tr td:first-child {
         padding-left: 10px;
       }
       table tbody tr td:before {
         content: attr(data-label);
         float: left;
         font-size: 10px;
         text-transform: uppercase;
         font-weight: bold;
       }
       table tbody tr td {
         display: block;
         text-align: right;
         font-size: 14px;
         padding: 0px 10px !important;
         box-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
       }
     }
     .rectangle-parent23 {
  position: absolute;
  height: calc(100% - 200px);
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
    <div class="mgrattendance-mob1" style="height: 100svh;">
      <div class="logo-1-container">
        <img class="logo-1-icon2" alt="" src="./public/logo-11@2x.png" />

        <a class="attendance-management1" style="width: 300px;">Attendance Management</a>
      </div>
      <a href="../logout.php"><img class="logo-1-icon10" alt="" src="./public/Logout-removebg-preview.png" /></a>
      <div class="mgrattendance-mob-inner"></div>
      <div class="rectangle-div"></div>
      <div class="rectangle-group">
        <a class="frame-child2"> </a>
        <a class="frame-child3" href="attendancelog_mgr.php"> </a>
        <!--<a class="frame-child4"> </a>-->
        <a class="attendance1">Attendance</a>
        <a class="attendance-log1" href="attendancelog_mgr.php">Attendance Log</a>
      </div>
      <div class="frame-group">
        <a href="employee-management_mgr.php"><img class="frame-child5" alt="" src="./public/frame-156.svg" /></a>

        <a class="fluentperson-clock-20-regular1" href="leave-management_mgr.php">
          <img class="vector-icon3" alt="" src="./public/vectorleave.svg" />
        </a>
        <div class="frame-child6"></div>
        <a class="akar-iconsdashboard1" href="dash_mgr.php">
          <img class="vector-icon4" alt="" src="./public/vector1dash.svg" />
        </a>
        <a class="uitcalender1">
          <img
            class="vector-icon5"
            alt=""
            src="./public/vector2attenblack.svg"
          />
        </a>
      </div>
      <div class="rectangle-parent23">
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
        <table class="data">
        <thead>
      <tr>
        <th >Date</th>
          <th style="border-left: 2px solid rgb(182, 182, 182);"></th>
          <th>Employee Name</th>
               <th colspan="2" style="white-space:nowrap;">In Time <span style="margin-left:110px;"> -</span><span style="margin-left:50px;"> Input Type</span></th>
          <th colspan="2" style="white-space:nowrap;">Out Time <span style="margin-left:70px;"> -</span><span style="margin-left:30px;"> Input Type</span></th>
      </tr>
    </thead>
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
                  <td data-label="Date" style="white-space:nowrap;"><?php echo $formattedDate; ?></td>
                  <!-- <td style="border-left: 2px solid rgb(182, 182, 182);"><img class="hovpic" src="pics/<?php echo $result['pic']; ?>" width="40px" height="40px" style="border-radius: 50px; border: 0.5px solid rgb(161, 161, 161);"></td> -->
                  <td data-label="Employee Name"><?php
                $empname = $result['empname'];
                echo strlen($empname) > 22 ? substr($empname, 0, 22) . '...' : $empname;
            ?>
                  </td>
  
                  <td data-label="In Time"  <?php echo $inTimeColor; ?>">
                  <?php echo $result['AttendanceTime']; ?>
                  </td>
                  <td data-label="In Input-Type">
                  <?php echo $result['InputType']; ?>
                  </td>
                  <td data-label="Out Time"  <?php echo $outTimeColor; ?>">
                  <?php
                    if (isset($userCheckOut[$userId])) {
                        echo $userCheckOut[$userId]['AttendanceTime'];
                    } else {
                        echo '<span style="color: red !important;">Yet to Check Out!</span>';
                    }
                    ?>
                  </td>
                  <td data-label="out Input-Type">
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
    </tbody>
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
    </div>
  </body>
</html>
