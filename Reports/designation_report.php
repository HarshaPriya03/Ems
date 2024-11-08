<?php
session_start();
@include '../inc/config.php';

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  header('location:loginpage.php');
  exit();
}

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
if ($user_name === '') {
  header('location:loginpage.php');
  exit();
}

$query = "SELECT user_type,user_type1 FROM user_form WHERE email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if ($row && isset($row['user_type']) && isset($row['user_type1'])) {
    $user_type = $row['user_type'];
    $user_type1 = $row['user_type1'];

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
  <link rel="stylesheet" href="./css/attendence.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  <style>
    .rectangle-parent23 {
      position: absolute;
      width: 98%;
      top: calc(50% - 360px);
      /*right: 1.21%;*/
      left: 20px;
      height: 850px;
      font-size: var(--font-size-xl);
    }

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
  </style>
</head>

<body>
  <div class="attendence4">
    <div class="bg14"></div>

    <div class="rectangle-parent23">
      <div style="display: flex; position: absolute; top: -20px; right: 60px;">
        <a href="print_desg_report.php" target="_blank" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
          <div style="display: flex; gap: 10px;"><img src="./public/pdf.png" width="25px" alt="">
            <span style="margin-top: 4px;">Export as PDF</span>
          </div>
        </a>
      </div>
      <div style="margin-top: 30px;overflow-x:auto;height:800px;">
        <table class="data w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="attendanceTable">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">
                S.No.
              </th>
              <th scope="col" class="px-6 py-3">
                Designation
              </th>
              <th scope="col" class="px-6 py-3">
                Number of Shifts
              </th>
              <th scope="col" class="px-6 py-3">
                Shift Timings
              </th>
            </tr>
          </thead>
          <?php
          $sql = "SELECT * FROM dept  ORDER BY desg ASC";
          $que = mysqli_query($con, $sql);
          $cnt = 1;
          while ($result = mysqli_fetch_assoc($que)) {
          ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4"><?php echo $cnt++; ?></td>
              <td class="px-6 py-4"><?php echo $result['desg']; ?></td>
              <td class="px-6 py-4"><?php echo $result['shifts']; ?></td>
              <td class="px-6 py-4">  <?php
                if ($result['fromshifttime1'] != '00:00:00' && $result['toshifttime1'] != '00:00:00') {
                    echo $result['fromshifttime1'] . ' to ' . $result['toshifttime1'] . '<br>';
                }
                if ($result['fromshifttime2'] != '00:00:00' && $result['toshifttime2'] != '00:00:00') {
                    echo $result['fromshifttime2'] . ' to ' . $result['toshifttime2'] . '<br>';
                }
                if ($result['fromshifttime3'] != '00:00:00' && $result['toshifttime3'] != '00:00:00') {
                    echo $result['fromshifttime3'] . ' to ' . $result['toshifttime3'];
                }
                ?></td>
            </tr>
          <?php 
          } ?>
        </table>
      </div>
    </div>
    <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

    <img width="90px" style="position: absolute; left:20px;" src="./public/logo-1@2x.png" />
    <a class="anikahrm14" href="./index.html" style="top:20px; left:120px;" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./reports.html" style="text-align: center; width: 60%;" id="attendenceManagement">Designations Report</a>
  </div>
</body>

</html>