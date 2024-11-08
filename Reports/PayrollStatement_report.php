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

    <div class="rectangle-parent23" style="margin-top: -60px;">
      <!-- <div style="display: flex; position: absolute; top: -20px; right: 60px;">
        <a href="print_payroll_details.php" target="_blank" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
          <div style="display: flex; gap: 10px;"><img src="./public/pdf.png" width="25px" alt="">
            <span style="margin-top: 4px;">Export as PDF</span>
          </div>
        </a>
      </div> -->
      <div>
      <table id="payrollTable"  class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead style="text-align: center;" class="py-4 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr class="px-6 py-3">
              <th scope="col" class="px-6 py-3">
                Payment Date
              </th>
              <th scope="col" class="px-6 py-3">
                Payroll Month
              </th>
              <th scope="col" class="px-6 py-3">
                Details
              </th>
              <th scope="col" class="px-6 py-3">
                Total Number of Paid Employees
              </th>
              <th scope="col" class="px-6 py-3">
              </th>
              <th></th>
            </tr>
          </thead>
          <?php

          $sql = "SELECT * FROM payroll_schedule where approval != 0 ";

          $que = mysqli_query($con, $sql);

          if (mysqli_num_rows($que) > 0) {
            while ($result = mysqli_fetch_assoc($que)) {
              $monthYear = $result['smonth'];

              $startOfMonth = date('d/m/Y', strtotime('first day of ' . $monthYear));

              $endOfMonth = date('d/m/Y', strtotime('last day of ' . $monthYear));
          ?>
              <tbody style="text-align: center;">
              <tr style="cursor: pointer;" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" onclick="openPayrollHistory('<?php echo $monthYear; ?>')">
    <td class="px-6 py-4"><?php echo $result['paid']; ?></td>
    <td class="px-6 py-4"><?php echo $monthYear; ?></td>
    <td class="px-6 py-4"><?php echo $startOfMonth . ' to ' . $endOfMonth; ?></td>
    <td class="px-6 py-4"><?php echo $result['paid_emp']; ?></td>
    <td class="px-6 py-4 text-green-400">PAID</td>
    <td>
    <svg class="w-6 h-6 text-blue-800 dark:text-blue" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 14v4.833A1.166 1.166 0 0 1 16.833 20H5.167A1.167 1.167 0 0 1 4 18.833V7.167A1.166 1.166 0 0 1 5.167 6h4.618m4.447-2H20v5.768m-7.889 2.121 7.778-7.778"/>
</svg>

    </td>
</tr>
              </tbody>

            <?php
            }
          } else {
            ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td colspan="8" class="px-6 py-4 text-center">No data</td>
            </tr>
          <?php
          }
          ?>
          <br />
        </table>


       
      </div>
    </div>
    <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

    <img width="90px" style="position: absolute; left:20px;" src="./public/logo-1@2x.png" />
    <a class="anikahrm14" href="./index.html" style="top:20px; left:120px;" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./reports.html" style="text-align: center; width: 60%;" id="attendenceManagement">Payroll Statement</a>
  </div>
<script>
            function openPayrollHistory(monthYear) {
                const thresholdMonthYear = new Date('2024-05-01');
                const currentMonthYear = new Date(monthYear + '-01');
                
                if (currentMonthYear >= thresholdMonthYear) {
                    window.location.href = "../Payroll/payroll_history.php?smonth=" + monthYear;
                } else {
                    window.location.href = "../Payroll/payroll_history_old.php?smonth=" + monthYear;
                }
            }
        </script>
</body>
</html>