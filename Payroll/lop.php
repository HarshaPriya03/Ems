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
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default@5/default.min.css">
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
      .hovpic {
      transition: all 0.5s ease-in-out;
      z-index:1000 !important;
    }


    .hovpic:hover {
      transform: scale(5, 5);
    }
  </style>

</head>

<body>
  <div class="attendence4">
    <div class="bg14"></div>
    <?php
    $firstDayOfMonth = date("Y-m-01");
    $lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth)) . ' 23:59:59';
    $totalDaysInMonth = date("t", strtotime($firstDayOfMonth));
    $sundaysCount = 0;
    for ($j = 1; $j <= $totalDaysInMonth; $j++) {
      $dateOfAttendance = date("Y-m-$j");
      $dayOfWeek = date('N', strtotime($dateOfAttendance));
      if ($dayOfWeek == 7) {
        $sundaysCount++;
      }
    }
    $fetchingHolidays = mysqli_query($con, "
SELECT COUNT(DISTINCT date) AS count
FROM holiday
WHERE date >= '$firstDayOfMonth'
AND date <= '$lastDayOfMonth'
") or die(mysqli_error($con));
    $holidaysCount = mysqli_fetch_assoc($fetchingHolidays)['count'];
    $totalWorkingDays = $totalDaysInMonth - $sundaysCount - $holidaysCount;
    ?>
    <!-- <select style="position: absolute;font-size:20px; border: 1px solid #e8e8e8; background-color:#fcfcfc; border-radius:5px; left:440px; top:100px;" id="monthYearSelect" onchange="filterData()">
      <option value="">Select Month-Year</option>
      <?php
      $currentYear = date("Y");
      $currentMonth = date("n");

      for ($i = 1; $i <= $currentMonth; $i++) {
        $monthName = date("F", mktime(0, 0, 0, $i, 1));
        $optionValue = date("Y-m", mktime(0, 0, 0, $i, 1, $currentYear));
        echo "<option value=\"$optionValue\">$monthName $currentYear</option>";
      }
      ?>
    </select> -->
     <?php
         if ($work_location == 'All') {
    $sql1 = "SELECT SUM(flop) AS total_flop1 FROM payroll_lop";
         }
         if ($work_location == 'Visakhapatnam') {
    $sql1 = "
    SELECT 
        SUM(p.flop) AS total_flop1
    FROM 
        payroll_lop p
    LEFT JOIN 
        emp e ON p.empname = e.empname
    WHERE 
        e.work_location = 'Visakhapatnam'
";
         }
         if ($work_location == 'Gurugram') {
$sql1 = "
    SELECT 
        SUM(p.flop) AS total_flop1
    FROM 
        payroll_lop p
    LEFT JOIN 
        emp e ON p.empname = e.empname
    WHERE 
        e.work_location = 'Gurugram'
";
         }
    $result = mysqli_query($con, $sql1);
    $row = mysqli_fetch_assoc($result);
    $total_flop1 = $row['total_flop1'];
    if ($total_flop1 === null) {
      $total_flop1 = 0;
    }

    $currentMonth = date('F Y');
    if ($work_location == 'All') {
    $sql2 = "SELECT SUM(flop) AS total_mflop FROM payroll_lop WHERE lopmonth = '$currentMonth'";
    }
    if ($work_location == 'Visakhapatnam') {
    $sql2 = "
    SELECT 
        SUM(p.flop) AS total_mflop
    FROM 
        payroll_lop p
    LEFT JOIN 
        emp e ON p.empname = e.empname
    WHERE 
        p.lopmonth = '$currentMonth' 
        AND e.work_location = 'Visakhapatnam'
";
    }
if ($work_location == 'Gurugram') {
$sql2 = "
    SELECT 
        SUM(p.flop) AS total_mflop
    FROM 
        payroll_lop p
    LEFT JOIN 
        emp e ON p.empname = e.empname
    WHERE 
        p.lopmonth = '$currentMonth' 
        AND e.work_location = 'Gurugram'
";
}
    $result = mysqli_query($con, $sql2);
    if ($result) {
      $row = mysqli_fetch_assoc($result);
      $total_mflop = $row['total_mflop'];
    } else {
      $total_mflop = 0;
    }
    if ($total_mflop === null) {
      $total_mflop = 0;
    }
    if ($work_location == 'All') {
    $sql3 = "SELECT COUNT(DISTINCT empname) AS distinct_empname_count FROM payroll_lop";
    }
    if ($work_location == 'Visakhapatnam') {
    $sql3 = "
    SELECT COUNT(DISTINCT p.empname) AS distinct_empname_count 
    FROM payroll_lop p
    LEFT JOIN emp e ON p.empname = e.empname
    WHERE e.work_location = 'Visakhapatnam'
";
    }
if ($work_location == 'Gurugram') {
$sql3 = "
    SELECT COUNT(DISTINCT p.empname) AS distinct_empname_count 
    FROM payroll_lop p
    LEFT JOIN emp e ON p.empname = e.empname
    WHERE e.work_location = 'Gurugram'
";
}
    $result2 = mysqli_query($con, $sql3);
    if ($result2) {
      $row2 = mysqli_fetch_assoc($result2);
      $distinct_empname_count = $row2['distinct_empname_count'];
    } else {
      $distinct_empname_count = 0;
    }

    ?>
    <div style="position:absolute; left:440px; top:150px; border: 1px solid #e8e8e8; background-color:#fcfcfc; border-radius:5px; width:450px; height:150px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);">
      <p style="color:#777777; font-size:25px; left:30px; top:20px; position:absolute;">Total LOP Days:</p>
      <img src="./public/loptotal.png" width="90px" style="position:absolute; left:30px; top:50px;" />
      <div class="main" style="position:absolute; right:10px; width:130px; height:130px; top:10px; display:flex; align-items:center; justify-content:center;"><span style="position:absolute; color:#333333; font-size:40px;"><?php echo $total_flop1 ?></span></div>
    </div>
    <div style="position:absolute; left:49%; top:150px; border: 1px solid #e8e8e8; background-color:#fcfcfc; border-radius:5px; width:450px; height:150px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);">
      <p style="color:#777777; font-size:25px; left:30px; top:20px; position:absolute;">This Month LOP:</p>
      <img src="./public/thismonthlop.png" width="90px" style="position:absolute; left:30px; top:50px;" />
      <div class="main1" style="position:absolute; right:10px; width:130px; height:130px; top:10px; display:flex; align-items:center; justify-content:center;"><span style="position:absolute; color:#333333; font-size:40px;"><?php echo $total_mflop ?></span></div>
    </div>
    <div style="position:absolute; right:30px; top:150px; border: 1px solid #e8e8e8; background-color:#fcfcfc; border-radius:5px; width:450px; height:150px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);">
      <p style="color:#777777; font-size:25px; left:30px; top:20px; position:absolute;">Employee LOP Ranking:</p>
      <img src="./public/empranking.png" width="90px" style="position:absolute; left:30px; top:50px;" />
      <button data-modal-target="top-right-modal" data-modal-toggle="top-right-modal" style="margin-top:80px; margin-left:150px;" class="block w-full md:w-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
        View Rankings
      </button>
      <div class="main2" style="position:absolute; right:10px; width:130px; height:130px; top:10px; display:flex; align-items:center; justify-content:center;"><span style="position:absolute; color:#333333; font-size:40px;"><?php echo $distinct_empname_count ?></span></div>
    </div>
    <div id="top-right-modal" data-modal-placement="top-right" style="margin-top:200px; right:-200px;" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-10/12 p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700" style="width:70%">
          <!-- Modal header -->
          <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-medium text-gray-900 dark:text-white">
              Employee Rankings
            </h3>
            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="top-right-modal">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
              </svg>
              <span class="sr-only">Close modal</span>
            </button>
          </div>
          <!-- Modal body -->
          <div class="p-4 md:p-5 space-y-4">

            <div class="p-5 border border-gray-100 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
              <ol class="relative border-s border-gray-200 dark:border-gray-700" style="margin-top:17px;">
                       <?php
                       if ($work_location == 'All') {
        $sql = "SELECT emp.empname, emp.pic, SUM(payroll_lop.flop) AS total_flop 
   FROM emp 
   INNER JOIN payroll_lop ON emp.empname = payroll_lop.empname 
   GROUP BY emp.empname 
   ORDER BY total_flop DESC";
                       }
if ($work_location == 'Visakhapatnam') {
$sql = "
SELECT 
    emp.empname, 
    emp.pic, 
    SUM(payroll_lop.flop) AS total_flop 
FROM 
    emp 
INNER JOIN 
    payroll_lop ON emp.empname = payroll_lop.empname 
WHERE 
    emp.work_location = 'Visakhapatnam'
GROUP BY 
    emp.empname 
ORDER BY 
    total_flop DESC
";
}
if ($work_location == 'Gurugram') {
$sql = "
    SELECT 
        emp.empname, 
        emp.pic, 
        SUM(payroll_lop.flop) AS total_flop 
    FROM 
        emp 
    INNER JOIN 
        payroll_lop ON emp.empname = payroll_lop.empname 
    WHERE 
        emp.work_location = 'Gurugram'
    GROUP BY 
        emp.empname 
    ORDER BY 
        total_flop DESC
";
}
                $result = mysqli_query($con, $sql);

                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    $empname = $row['empname'];
                    $total_flop = $row['total_flop'];
                    $pic = $row['pic'];
                ?>
                    <li class="mb-10 ms-6">
                      <span style="margin-top:8px;margin-left:-5px;" class="absolute flex items-center justify-center w-9 h-8 bg-blue-100 rounded-full -start-3 ring-7 ring-white dark:ring-gray-900 dark:bg-blue-900">
                        <img class="rounded-full shadow-lg hovpic" src="../pics/<?php echo $pic ?>" />
                      </span>
                      <div class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:bg-gray-700 dark:border-gray-600">
                        <time class="mb-1 text-xs font-normal text-gray-400 sm:order-last sm:mb-0"><?php echo $total_flop; ?> Days</time>
                        <div class="text-sm font-normal text-gray-500 dark:text-gray-300"><?php echo $empname; ?></div>
                      </div>
                    </li>
                <?php
                  }
                } else {
                  echo "No data available";
                }
                ?>
              </ol>
            </div>


          </div>
        </div>
      </div>
    </div>
    <div class="rectangle-parent23" style="height: 60vh;overflow-y: auto;display:block; margin-top:140px;">


      <form>
        <table id="lopTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead style="text-align: center;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:text-blue-800" style="position:sticky; top:0;">
            <td colspan="8">
            <div class="px-1 py-2 flex items-center">
                    <select style="border-radius:5px;" id="monthYearSelect" hidden>
                      <?php
                      $sql = "SELECT smonth FROM payroll_schedule WHERE approval = 0 LIMIT 1";
                      $result = $con->query($sql);

                      if ($result && $row = $result->fetch_assoc()) {
                        $smonth = $row['smonth'];
                        $date = DateTime::createFromFormat('F Y', $smonth);
                        $optionValue = $date->format('Y-m');
                        echo "<option value=\"$optionValue\">$smonth</option>";
                      }
                      echo "<input class='bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block  p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' type='text' value=\"$smonth\">";
                      ?>
                    </select>
                    <button onclick="fetchLop(event)" class="px-1 py-2 ml-2 text-sm font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                      <svg class="w-6 h-6 text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v5m0 0 2-2m-2 2-2-2M3 6v1a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Zm2 2v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8H5Z" />
                      </svg>

                      Fetch
                    </button>
                  </div>
            </td>
              <td colspan="2">
                <div class="px-1 py-2 flex items-center">
                  <a href="print-detailslop.php" target="_blank" class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-blue-600 rounded-lg hover:bg-blue-200 focus:ring-4 focus:outline-none dark:text-white focus:ring-blue-50 dark:bg-blue-700 dark:hover:bg-blue-600 dark:focus:ring-blue-600">
                    <svg class="w-4 h-4 text-white dark:text-white hover:text-blue-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z" />
                      <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                    </svg> <span class="text-white hover:text-blue-800 focus:ring-4  font-medium rounded-lg text-sm text-center px-1">Download</span>
                  </a>
                </div>
              </td>
            </tr>
            <tr>
              <th scope="col" class="px-6 py-3"></th>
              <th scope="col" class="px-6 py-3">Emp Name</th>
              <th scope="col" class="px-6 py-3">LOP Month</th>
              <th scope="col" class="px-6 py-3">Worked Days</th>
              <th scope="col" class="px-6 py-3">Leave Balance</th>
              <th scope="col" class="px-6 py-3">LOP</th>
              <th scope="col" class="px-6 py-3">Lop Adjustment</th>
              <th scope="col" class="px-6 py-3">Final LOP</th>
              <th scope="col" class="px-6 py-3">Comment</th>
              <th scope="col" class="px-6 py-3">LOP Marked On</th>
            </tr>
          </thead>
          <tbody style="text-align: center;">
            <?php
            if ($work_location == 'All') {
         $sql = "SELECT payroll_lop.*, emp.pic 
           FROM payroll_lop 
           INNER JOIN emp ON payroll_lop.empname = emp.empname ORDER BY created ASC";
            }if ($work_location == 'Visakhapatnam') {
$sql = "
SELECT payroll_lop.*, emp.pic 
FROM payroll_lop 
INNER JOIN emp ON payroll_lop.empname = emp.empname 
WHERE emp.work_location = 'Visakhapatnam'
ORDER BY payroll_lop.created ASC
";
            }if ($work_location == 'Gurugram') {

$sql = "
    SELECT payroll_lop.*, emp.pic 
    FROM payroll_lop 
    INNER JOIN emp ON payroll_lop.empname = emp.empname 
    WHERE emp.work_location = 'Gurugram'
    ORDER BY payroll_lop.created ASC
";
            }
            $que = mysqli_query($con, $sql);

            if (mysqli_num_rows($que) > 0) {
              while ($result = mysqli_fetch_assoc($que)) {


            ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <td class="px-6 py-4"><img src="../pics/<?php echo $result['pic']; ?>"  width="50px" style="border-radius: 50%;" alt=""></td>
                  <td class="px-6 py-4"><?php echo $result['empname']; ?></php>
                  </td>
                  <td class="px-6 py-4"><?php echo ($result['lopmonth']); ?></td>
                  <td class="px-6 py-4"><?php echo ($result['worked']); ?></td>
                  <td class="px-6 py-4"><?php echo ($result['leavebal']); ?></td>
                  <td class="px-6 py-4"><?php echo abs($result['lop']); ?></td>
                  <td class="px-6 py-4"><?php echo ($result['lopadj']); ?></td>
                  <td class="px-6 py-4 final-lop-cell"><?php echo ($result['flop']); ?></td>
                  <td class="px-6 py-4"><?php echo ($result['comment']); ?></td>
                  <td class="px-6 py-4"><?php echo ($result['created']); ?></td>
                </tr>
              <?php
              }
            } else {
              ?>
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td colspan="10" class="px-6 py-4 text-center">No LOP</td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </form>

    </div>
    <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

    <img class="attendence-item" alt="" src="./public/rectangle-2@2x.png" />

    <img class="logo-1-icon14" alt="" src="./public/logo-1@2x.png" />
    <a class="anikahrm14" href="./index.html" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./index.html" id="attendenceManagement">Payroll Management</a>
    <button class="attendence-inner"></button>
    <div class="logout14">Logout</div>
    <a class="payroll14" href="./payroll.php" style="color: white; z-index:9999;">Payroll</a>
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
</body>

<script src='https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.0/d3.js'></script>
<script src='https://rawgit.com/pablomolnar/radial-progress-chart/master/dist/radial-progress-chart.js'></script>
<script>
  var mainChart = new RadialProgressChart('.main', {
    diameter: 300,
    max: 20,
    series: [{
      labelStart: '\uF106',
      value: <?php echo $total_flop1; ?> 
    }]
  });

  var mainChart1 = new RadialProgressChart('.main1', {
    diameter: 300,
    max: 20,
    series: [{
      labelStart: '\uF101',
      value: <?php echo $total_mflop; ?> 
    }]
  });

  var mainChart2 = new RadialProgressChart('.main2', {
    diameter: 300,
    max: 20,
    series: [{
      labelStart: '\uF105',
      value: <?php echo $distinct_empname_count; ?> 
    }]
  });
</script>
<script>
  function fetchLop(event) {
    event.preventDefault();

    var selectedMonthYear = document.getElementById("monthYearSelect").value;
    if (selectedMonthYear !== "") {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("lopTable").innerHTML = this.responseText;
        }
      };
      xhttp.open("GET", "fetch_lop.php?monthYear=" + selectedMonthYear, true);
      xhttp.send();
    }
  }
</script>


<script>
  function updateFinalLop(input) {
    // Get the custom value entered by the user
    var adjustment = parseFloat(input.value.trim());
    // If the input is empty, set it to 0
    if (isNaN(adjustment)) {
      adjustment = 0;
    }
    const tr = input.closest('tr');
    const lopDaysCell = tr.querySelector('td:nth-child(6)');
    const finalLopCell = tr.querySelector('.final-lop-cell');
    const lopDays = parseFloat(lopDaysCell.textContent);
    finalLopCell.textContent = Math.abs(lopDays + adjustment);
  }
</script>

<script>
  function myFuncdet() {
    document.getElementById("emibtn").classList.add("backclr");
    document.getElementById("onebtn").classList.remove("backclr");
    document.getElementById("scheper").classList.remove("remove");
  }

  function myFuncdet1() {
    document.getElementById("emibtn").classList.remove("backclr");
    document.getElementById("onebtn").classList.add("backclr");
    document.getElementById("scheper").classList.add("remove");
  }
</script>
<script>
  function submitFormData() {
    var formData = new FormData();
    // Iterate through each table row
    $("#lopTable tbody tr").each(function() {
      // Get the input elements within the current row
      var lopadj = $(this).find('input[name="lopadj"]').val().trim();
      // Check if the comment input element exists
      var commentInput = $(this).find('.comment-input');
      if (commentInput.length > 0) { // Check if comment input field exists
        var comment = commentInput.val().trim(); // Get comment value if exists
      } else {
        var comment = '';
      }
      var empName = $(this).find('td:eq(1)').text().trim();
      var lopMonth = $(this).find('td:eq(2)').text().trim();
      var worked = $(this).find('td:eq(4)').text().trim();
      var leavebal = $(this).find('td:eq(5)').text().trim();
      var lop = $(this).find('td:eq(6)').text().trim();
      var lopAdj = $(this).find('td:eq(7)').text().trim();
      var flop = $(this).find('td:eq(8)').text().trim();
      var Comment = $(this).find('td:eq(9)').text().trim();
      // Append the data to the formData object
      formData.append('empname[]', empName);
      formData.append('lopmonth[]', lopMonth);
      formData.append('lop[]', lop);
      formData.append('worked[]', worked);
      formData.append('leavebal[]', leavebal);
      formData.append('lopadj[]', lopadj);
      formData.append('flop[]', flop);
      formData.append('comment[]', comment);
    });


    // Check if at least one adjustment is provided
    var adjustmentsProvided = false;
    $("#lopTable tbody tr").each(function() {
      var lopadj = $(this).find('input[name="lopadj"]').val().trim();
      if (lopadj !== "") {
        adjustmentsProvided = true;
        return false; // Exit the loop if at least one adjustment is provided
      }
    });

    if (adjustmentsProvided) {
      Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to submit the LOP adjustments?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, submit',
        cancelButtonText: 'No, cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: 'POST',
            url: 'insert_lop.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              console.log('Success:', response);
              Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'LOP created successfully',
                confirmButtonText: 'OK'
              }).then((result) => {
                if (result.isConfirmed) {
                  location.reload();
                }
              });
            },
            error: function(xhr, status, error) {
              console.log('Error:', xhr.responseText);
              Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'An error occurred while processing your request.',
                confirmButtonText: 'OK'
              });
            }
          });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            title: 'Cancelled',
            text: 'The submission of LOP adjustments was cancelled',
            icon: 'info',
            confirmButtonText: 'OK'
          });
        }
      });
    } else {
      Swal.fire({
        title: 'Error!',
        text: 'Please provide at least one adjustment before submitting.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  }
</script>




</html>