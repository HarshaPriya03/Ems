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
  <link rel="stylesheet" href="./empmobcss/mgr-emp-list-mob1.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap" />
  <style>
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
      height: calc(100% - 160px);
      top: 111px;
      bottom: 103px;
      left: calc(50% - 167px);
      width: 333px;
      overflow-y: auto;
      font-size: var(--font-size-smi);
      color: var(--color-darkslategray-200);
    }

    .logo-1-icon10 {
      position: absolute;
      top: 10px;
      right: 10px;
      width: 55px;
      height: 55px;
      object-fit: cover;
    }
  </style>
</head>

<body>
  <div class="mgremplist-mob1" style="height: 100svh;">
    <div class="logo-1-parent1">
      <img class="logo-1-icon4" alt="" src="./public/logo-11@2x.png" />

      <a class="employee-management1" style="width: 300px;">Employee Management</a>
    </div>
    <a href="../logout.php"><img class="logo-1-icon10" alt="" src="./public/Logout-removebg-preview.png" /></a>
    <div class="mgremplist-mob-item"></div>
    <a class="fluentpeople-32-regular" id="fluentpeople32Regular"> </a>
    <div class="fluentperson-clock-20-regular-parent">
      <a class="fluentperson-clock-20-regular3" href="leave-management_mgr.php">
        <img class="vector-icon9" alt="" src="./public/vectorleave.svg" />
      </a>
      <a class="uitcalender3" href="attendence_mgr.php">
        <img class="vector-icon10" alt="" src="./public/vectoratten.svg" />
      </a>
      <div class="frame-child9"></div>
      <a class="akar-iconsdashboard3" href="dash_mgr.php">
        <img class="vector-icon11" alt="" src="./public/vector1dash.svg" />
      </a>
      <img class="frame-child10" alt="" src="./public/frame-1561.svg" />
    </div>
    <div class="rectangle-parent23" style="margin-top: -40px;">
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
          $employee_query = "SELECT emp.* FROM emp 
                           WHERE emp.desg IN ('$inClause') 
                             AND work_location = '$work_location'  ORDER BY emp.emp_no ASC";

          $employee_result = mysqli_query($con, $employee_query);
          $cnt = 1;
      ?>
          <table class="data">
            <thead>
              <tr>
                <td></td>
                <td>Emp ID</td>
                <td>Emp Name</td>
                <td>Designation</td>
                <td>Department</td>
                <td>Status</td>
              </tr>
            </thead>
            <?php
            while ($result = mysqli_fetch_assoc($employee_result)) {
            ?>
              <tr>
                <td><img src="../pics/<?php echo $result['pic']; ?>" width="50px" height="52px" style="border-radius: 70%; margin-top:5px;" alt=""></td>
                <td data-label="Employee ID"><?php echo $result['emp_no']; ?></td>
                <td data-label="Employee Name"><?php
                                                $empname = $result['empname'];
                                                echo strlen($empname) > 22 ? substr($empname, 0, 22) . '...' : $empname;
                                                ?></td>
                <td data-label="Designation"><?php echo $result['desg']; ?></td>
                <td data-label="Department"><?php echo $result['dept']; ?></td>
                <td data-label="Status">
                  <?php
                  if ($result['empstatus'] == '0') {
                    echo 'Active';
                  } elseif ($result['empstatus'] == '1') {
                    echo 'Terminated';
                  } elseif ($result['empstatus'] == '2') {
                    echo 'Resigned';
                  }
                  ?>
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
      </tbody>
      </table>
    </div>
  </div>

  <script>
    var fluentpeople32Regular = document.getElementById("fluentpeople32Regular");
    if (fluentpeople32Regular) {
      fluentpeople32Regular.addEventListener("click", function(e) {
        // Please sync "EmployeeManagement" to the project
      });
    }
  </script>
</body>

</html>