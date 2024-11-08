<?php

@include 'inc/config.php';

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  header('location:loginpage.php');
}

$sqlStatusCheck = "SELECT * FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultStatusCheck = mysqli_query($con, $sqlStatusCheck);
$statusRow = mysqli_fetch_assoc($resultStatusCheck);

$work_location = $statusRow['work_location'];
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="./global.css" />
  <link rel="stylesheet" href="./salary.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" />
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</head>

<body>
  <div class="salary1">
    <div class="bg1"></div>
    <img class="salary-child" alt="" src="./public1/rectangle-1@2x.png" />

    <img class="salary-item" alt="" src="./public1/rectangle-2@2x.png" />

    <a class="anikahrm1">
      <span>Anika</span>
      <span class="hrm1">HRM</span>
    </a>
    <a class="employee-management1" id="employeeManagement">Employee Management</a>
    <button class="salary-inner"></button>
    <a href="logout.php">
      <div class="logout1">Logout</div>
    </a>
    <a class="leaves1">Leaves</a>
    <a class="attendance1">Attendance</a>
    <div class="payroll1">Payroll</div>
    <a class="fluentperson-clock-20-regular1">
      <img class="vector-icon4" alt="" src="./public1/vector.svg" />
    </a>
    <img class="uitcalender-icon1" alt="" src="./public1/uitcalender.svg" />

    <img class="arcticonsgoogle-pay1" alt="" src="./public1/arcticonsgooglepay.svg" />
    <?php
    $sql = "SELECT * FROM emp WHERE empemail = '" . $_SESSION['user_name'] . "' ";
    $que = mysqli_query($con, $sql);
    $cnt = 1;
    $row = mysqli_fetch_array($que);
    ?>
    <!--<img class="salary-child1" alt="" src="pics/<?php echo $row['pic']; ?>" />-->
    <!-- 
      <img
        class="material-symbolsperson-icon1"
        alt=""
        src="./public1/materialsymbolsperson.svg"
      /> -->

    <img class="salary-child2" alt="" src="./public1/rectangle-4@2x.png" />

    <img class="tablerlogout-icon1" alt="" src="./public1/tablerlogout.svg" />

    <a class="uitcalender1">
      <img class="vector-icon5" alt="" src="./public1/vector1.svg" />
    </a>
    <a class="dashboard1" id="dashboard">Dashboard</a>
    <a class="akar-iconsdashboard1" id="akarIconsdashboard">
      <img class="vector-icon6" alt="" src="./public1/vector2.svg" />
    </a>
    <div class="rectangle-container">
      <div class="frame-child4"></div>
      <img class="frame-child5" alt="" src="./public1/line-39.svg" />

      <a href="./personal-details.html" class="frame-child6" id="rectangleLink"> </a>
      <a href="./personal-details.html" class="personal-details1" id="personalDetails">Personal Details</a>
      <a href="./job.php" class="frame-child7" id="rectangleLink1"> </a>
      <a href="./directory.php" class="frame-child8" id="rectangleLink2"> </a>
      <a class="frame-child9"> </a>
      <a href="./job.php" class="job1" id="job">Job</a>
      <a href="./directory.php" class="document1" id="document">Document</a>
      <a class="salary2">Salary</a>
      <a href="./employee-dashboard.html"> <img class="bxhome-icon1" alt="" src="./public1/bxhome.svg" id="bxhomeIcon" /></a>
    </div>
    <div class="frame-div">

      <table id="payrollTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="margin-top:-50px;">
      <caption style="background:#FFE2C6;" class="p-5 text-left  dark:bg-gray-800 rounded-t-lg">
        <div class="flex items-center mb-3">
            <svg class="w-8 h-8 mr-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            <h2 class="text-2xl font-semibold dark:text-white" style="color:#FF5400;">Payroll Information</h2>
        </div>
        <p class="mb-4 text-sm font-normal text-gray-700 dark:text-gray-300">
            <svg class="inline w-6 h-5 mr-1 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Click on any row to access the payslip for the respective pay period.
        </p>
        <div class="flex items-start mb-2">
            <svg class="w-5 h-5 mr-2 text-green-500 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Payslips are crucial documents that provide a detailed breakdown of your earnings and deductions.
            </p>
        </div>
        <div class="flex items-start">
            <svg class="w-5 h-5 mr-2 text-green-500 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                They serve as proof of income and are essential for financial records and tax purposes.
            </p>
        </div>
    </caption>
      <thead style="text-align: center;" class="py-4 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">
              Payment Date
            </th>
            <th scope="col" class="px-6 py-3">
          Pay Period
            </th>
            <th scope="col" class="px-6 py-3">
            Pay Period  Details
            </th>
            <th scope="col" class="px-6 py-3">
              Status
            </th>
          </tr>
        </thead>
        <?php
        $user_name = $_SESSION['user_name'];

        $sql1 = "SELECT emp.empname
        FROM emp
        INNER JOIN user_form ON emp.empemail = user_form.email
        WHERE user_form.email = '$user_name'";

        $result1 = mysqli_query($con, $sql1);

        if ($result1) {
          if (mysqli_num_rows($result1) > 0) {
            $row1 = mysqli_fetch_assoc($result1);
            $empname = $row1['empname'];
          } else {
            $empname = "Unknown";
          }
        } else {
          $empname = "Unknown";
        }

        ?>
        <?php
        $sql = "SELECT * FROM payroll_schedule WHERE approval != 0 ORDER BY ID DESC";
        $que = mysqli_query($con, $sql);

        if ($work_location == 'Visakhapatnam') {
          $checkEmpnameSql = "SELECT salarymonth FROM payroll_ss_vsp WHERE empname = '$empname'";
        } elseif ($work_location == 'Gurugram') {
          $checkEmpnameSql = "SELECT salarymonth FROM payroll_ss_ggm WHERE empname = '$empname'";
        }

        $checkEmpnameResult = mysqli_query($con, $checkEmpnameSql);
        $empnameExists = mysqli_num_rows($checkEmpnameResult) > 0;

        if ($empnameExists) {
          $salaryMonths = [];
          while ($row = mysqli_fetch_assoc($checkEmpnameResult)) {
            $salaryMonths[] = $row['salarymonth'];
          }

          if (mysqli_num_rows($que) > 0) {
            while ($result = mysqli_fetch_assoc($que)) {
              $monthYear = $result['smonth'];

              if (in_array($monthYear, $salaryMonths)) {
                $startOfMonth = date('d/m/Y', strtotime('first day of ' . $monthYear));
                $endOfMonth = date('d/m/Y', strtotime('last day of ' . $monthYear));
        ?>
                <tbody style="text-align: center;">
                  <tr style="cursor: pointer;" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" onclick="openPayrollHistory('<?php echo $monthYear; ?>')">
                    <td class="px-6 py-4"><?php echo $result['paid']; ?></td>
                    <td class="px-6 py-4"><?php echo $monthYear; ?></td>
                    <td class="px-6 py-4"><?php echo $startOfMonth . ' to ' . $endOfMonth; ?></td>
                    <td class="px-6 py-4 text-green-400">PAID</td>
                  </tr>
                </tbody>
            <?php
              }
            }
          } else {
            ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td colspan="8" class="px-6 py-4 text-center">No data</td>
            </tr>
          <?php
          }
        } else {
          ?>
          <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td colspan="8" class="px-6 py-4 text-center">No data found</td>
          </tr>
        <?php
        }
        ?>
        <br />
      </table>


    </div>
    <img class="logo-1-icon1" alt="" src="./public1/logo-1@2x.png" />
  </div>

  <script>
    function openPayrollHistory(monthYear) {
      const thresholdMonthYear = new Date('2024-05-01');
      const currentMonthYear = new Date(monthYear + '-01');

      if (currentMonthYear >= thresholdMonthYear) {
        window.location.href = "payslip1_new.php?smonth=" + monthYear;
      } else {
        window.location.href = "payslip1.php?smonth=" + monthYear;
      }
    }
  </script>
</body>

</html>