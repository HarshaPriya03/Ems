<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../loginpage.php");
    exit();
}

// Connect to MySQL
@include '../inc/config.php';
$currentDate = date("Y-m-d");
// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the module ID for the payroll module
$sql_payroll_module = "SELECT id FROM modules WHERE module_name = 'payroll'";
$result_payroll_module = mysqli_query($con, $sql_payroll_module);
$payroll_module = mysqli_fetch_assoc($result_payroll_module);

// Retrieve the logged-in user's email
$email = $_SESSION['email'];

// Check if the logged-in user has access to the payroll module
$sql_check_access = "SELECT COUNT(*) AS count FROM user_modules WHERE email = '$email' AND module_id = " . $payroll_module['id'];
$result_check_access = mysqli_query($con, $sql_check_access);
$row_check_access = mysqli_fetch_assoc($result_check_access);

if ($row_check_access['count'] == 0) {
    // If the user doesn't have access to the payroll module, redirect them to the dashboard or display an error message
    header("Location: ../loginpage.php");
    exit();
}

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  header('location:loginpage.php');
}
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
if ($user_name === '') {
  header('location:loginpage.php');
  exit();
}

$query = "SELECT * FROM user_form WHERE email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if ($row && isset($row['user_type']) && isset($row['user_type1'])) {
      $user_type = $row['user_type'];
      $user_type1 = $row['user_type1'];
      $work_location = $row['work_location'];

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .rectangle-div {
      position: absolute;
      border-radius: 10px;
      background-color: #ffffff;
      width: 250px;
      height: 40px;
      border: 1px solid rgb(185, 185, 185);
      box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);
    }

    .hidden111 {
      display: none;
    }
  </style>
  <script>
    function toggleCheckboxes() {
      var masterCheckbox = document.getElementById("masterCheckbox");
      var checkboxes = document.querySelectorAll("#payrollTable tbody input[type='checkbox']");
      checkboxes.forEach(function(checkbox) {
        checkbox.checked = masterCheckbox.checked;
      });
    }
  </script>
</head>

<body>
  <div class="attendence4">
    <div class="bg14"></div>
    <div class="rectangle-parent22" style="margin-left: 60px;">
      <div class="frame-child187" style="margin-left: 80px;"></div>
      <a class="frame-child188" href="salarystatement.php"> </a>
      <a class="frame-child189" id="rectangleLink1" href="epf.php"> </a>
      <a class="frame-child190" id="rectangleLink2" href="esi.php"> </a>
      <!-- <a class="frame-child191" id="rectangleLink3" href="advances.html"> </a> -->
      <!-- <a class="frame-child191" id="rectangleLink3" href="loans.html" style="margin-left: 220px; "> </a> -->
      <a class="attendence5" style="margin-left: 7px; width: 140px; margin-top: -4px;" href="salarystatement.php">Statement</a>
      <a class="records5" id="records" style="margin-left: 20px; width: 110px; margin-top: -4px;" href="epf.php">EPF</a>
      <a class="punch-inout4" id="punchINOUT" style="margin-left: 60px; margin-top: -4px;" href="esi.php">ESI</a>
      <!-- <a class="my-attendence4" href="advances.html" id="myAttendence" style="margin-left: 30px; margin-top: -4px;  ">Advances</a> -->
      <!-- <a class="my-attendence4" href="loans.html" id="myAttendence" style="margin-left: 270px; margin-top: -4px;">Loans</a> -->
    </div>
    <div class="rectangle-parent23">
      <br>

      <div id="payrollForm" style="overflow-x:auto;height:700px;">

        <table id="payrollTable" style="margin-top: -40px;" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
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

    <img class="attendence-item" alt="" src="./public/rectangle-2@2x.png" />

    <img class="logo-1-icon14" alt="" src="../public/logo-1@2x.png" />
    <a class="anikahrm14" href="./index.html" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./index.html" id="attendenceManagement">Payroll Management</a>
    <button class="attendence-inner"></button>
    <div class="logout14">Logout</div>
    <a class="payroll14" href="payroll.php" style="color: white; z-index:9999;">Payroll</a>
    <div class="reports14">Reports</div>
    <img class="uitcalender-icon14" alt="" src="./public/uitcalender.svg" />

    <img style="-webkit-filter: grayscale(1) invert(1);
      filter: grayscale(1) invert(1); z-index:9999;" class="arcticonsgoogle-pay14" alt="" src="./public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon14" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />



    <img class="attendence-child2" alt="" style="margin-top: 66px;" src="./public/rectangle-4@2x.png" />

    <a class="dashboard14" href="../index.php" style="z-index: 99999;" id="dashboard">Dashboard</a>
    <a class="fluentpeople-32-regular14" style="z-index: 99999;" id="fluentpeople32Regular">
      <img class="vector-icon73" alt="" src="./public/vector7.svg" />
    </a>
    <a class="employee-list14" href="../employee-management.php" style="z-index: 99999;" id="employeeList">Employee List</a>
    <a class="akar-iconsdashboard14" style="z-index: 99999;" href="../index.php" id="akarIconsdashboard">
      <img class="vector-icon74" alt="" src="./public/vector3.svg" />
    </a>
    <img class="tablerlogout-icon14" style="z-index: 99999;" alt="" src="./public/tablerlogout.svg" />

    <a class="leaves14" id="leaves" style="z-index: 99999;" href="../leave-management.php">Leaves</a>
    <a class="fluentperson-clock-20-regular14" id="fluentpersonClock20Regular">
      <img class="vector-icon75" style="z-index: 99999;" alt="" src="./public/vector1.svg" />
    </a>
    <a class="onboarding16" style="z-index: 99999;" id="onboarding" href="../onboarding.php">Onboarding</a>
    <a class="fluent-mdl2leave-user14" style="z-index: 99999;" id="fluentMdl2leaveUser">
      <img class="vector-icon76" alt="" src="./public/vector.svg" />
    </a>
    <a class="attendance14" href="../attendence.php" style="color: black; z-index: 99999;">Attendance</a>
    <a class="uitcalender14">
      <img class="vector-icon77" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1); z-index: 99999;" alt="" src="./public/vector11.svg" />
    </a>
    <div class="oouinext-ltr3"></div>
  </div>
  <?php
if ($work_location == 'Gurugram') {
    // Check if payroll_ss_ggm table is not empty
    $checkTableQuery = "SELECT COUNT(*) AS count FROM payroll_ss_ggm";
    $result = mysqli_query($con, $checkTableQuery);
    $row = mysqli_fetch_assoc($result);
    
    if ($row['count'] > 0) {
        // Table is not empty, output the JavaScript for Gurugram
        echo '<script>
            function openPayrollHistory(monthYear) {
                const thresholdMonthYear = new Date("2024-05-01");
                const currentMonthYear = new Date(monthYear + "-01");
                
                if (currentMonthYear >= thresholdMonthYear) {
                    window.location.href = "payroll_history.php?smonth=" + monthYear;
                }
            }
        </script>';
    }
} elseif ($work_location == 'All' || $work_location == 'Visakhapatnam') {
    // Output the JavaScript for All or Visakhapatnam
    echo '<script>
        function openPayrollHistory(monthYear) {
            const thresholdMonthYear = new Date("2024-05-01");
            const currentMonthYear = new Date(monthYear + "-01");
            
            if (currentMonthYear >= thresholdMonthYear) {
                window.location.href = "payroll_history.php?smonth=" + monthYear;
            } else {
                window.location.href = "payroll_history_old.php?smonth=" + monthYear;
            }
        }
    </script>';
}
?>


</body>
</html>