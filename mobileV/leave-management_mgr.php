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
  <link rel="stylesheet" href="./empmobcss/mgr-emp-list-mob.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
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
  <div class="mgremplist-mob" style="height: 100svh;">
    <div class="frame-div">
      <img class="logo-1-icon3" alt="" src="./public/logo-11@2x.png" />

      <a class="leave-management" style="width: 300px;">Leave Management</a>
    </div>
     <a href="../logout.php"><img class="logo-1-icon10" alt="" src="./public/Logout-removebg-preview.png" /></a>
    <div class="mgremplist-mob-child"></div>
    <div class="frame-container">
      <a href="employee-management_mgr.php"><img class="frame-child7" alt="" src="./public/frame-156.svg" /></a>

      <a class="uitcalender2" href="attendence_mgr.php">
        <img class="vector-icon6" alt="" src="./public/vectoratten.svg" />
      </a>
      <div class="frame-child8"></div>
      <a class="akar-iconsdashboard2" href="dash_mgr.php">
        <img class="vector-icon7" alt="" src="./public/vector1dash.svg" />
      </a>
      <a class="fluentperson-clock-20-regular2">
        <img class="vector-icon8" alt="" src="./public/vector3leaveblack.svg" />
      </a>
    </div>
    <div class="rectangle-parent23" style="margin-top: -40px;">
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
          <table class="data">
            <thead>
              <tr>
                <td></td>
                <td>Emp Name</td>
                <td>Designation</td>
                <td>Leave Type</td>
                <td>Applied on</td>
                <td>Leave Dates</td>
                <td>Status</td>
                <td></td>
              </tr>
            </thead>
            <?php
            while ($result = mysqli_fetch_assoc($employee_result)) {
              $employeeSql = "SELECT pic FROM emp WHERE empname = '{$result['empname']}'";
              $employeeQuery = mysqli_query($con, $employeeSql);
              $employeeData = mysqli_fetch_assoc($employeeQuery);
            ?>
              <tr>
                <td><img src="../pics/<?php echo $employeeData['pic']; ?>" width="55px" height= "45px" style="border-radius: 70%;height:55px;"alt=""></td>
                <td data-label="Employee Name"><?php
                                                $empname = $result['empname'];
                                                echo strlen($empname) > 22 ? substr($empname, 0, 22) . '...' : $empname;
                                                ?></td>

                <td data-label="Designation"><?php echo $result['desg']; ?></td>
                <td data-label="Leave Type"><?php echo $result['leavetype']; ?></td>
                <td data-label="Applied On"><?php
                                            $status2 = isset($result['status2']) ? $result['status2'] : '';
                                            ?>
                  <?php echo date('d-m-Y', strtotime('+12 hours +30 minutes', strtotime($result['applied']))); ?>
                  <span style='font-size:16px;  white-space:nowrap;'>
                    <?php echo ($status2 == '1') ? '[Thru HR]' : '[self]'; ?>
                  </span>
                </td>
                <?php
                $leavetype2 = $result['leavetype2'];

                if ($leavetype2 === 'FN' || $leavetype2 === 'AN') {
                  echo '<td data-label="From Date:">' . date('d-m-Y H:i', strtotime($result['from'])) . ' to ' . date('d-m-Y H:i', strtotime($result['to'])) . '</td>';
                } else {
                  echo '<td data-label="From Date:">' . date('d-m-Y', strtotime($result['from'])) . ' to ' . date('d-m-Y', strtotime($result['to'])) . '</td>';
                }
                ?>
                <td data-label="Status" style="margin-top:20px;">
                  <?php
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
      </span> ';
  }elseif ($status == '3' && $status1 == '0') {
      echo '<span class=\'bg-yellow-100 text-yellow-800 text-xs font-medium inline-flex items-center px-3 py-1.5 rounded dark:bg-gray-700 dark:text-yellow-400 border border-yellow-400\'>
      <svg class=\'w-3.5 h-5.5 me-1\' aria-hidden=\'true\' xmlns=\'http://www.w3.org/2000/svg\' fill=\'currentColor\' viewBox=\'0 0 20 20\'>
      <path d=\'M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z\'/>
      </svg>Pending at Approver
      </span>';
  }
    ?>
</p>
                </td>
                <td style="border-left:1px solid rgba(120, 130, 140, 0.13) ; margin-top:20px;"><a href="leave-Details_mgr.php?id=<?php echo $result['ID']; ?>"><button type="button" class="text-gray-900 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-4 py-2 text-center inline-flex items-center dark:focus:ring-gray-500 ">
                      View details</a><svg class="rtl:rotate-180 w-3 h-3.5 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                  </svg></td>
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
      </tbody>
      </table>
    </div>
  </div>
</body>

</html>