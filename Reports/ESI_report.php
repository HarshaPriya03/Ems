<?php
session_start();
@include '../inc/config.php';
$currentDate = date("Y-m-d");
// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: loginpage.php");
    exit();
}


// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the module name from the URL (assuming the module pages have a parameter in the URL)
$module_name = basename($_SERVER['PHP_SELF']);

// Sanitize module name to prevent directory traversal attacks
$module_name = mysqli_real_escape_string($con, $module_name);

// Retrieve email from session
$email = $_SESSION['email'];

// Check if the module is linked to the user
$sql = "SELECT COUNT(*) AS count FROM user_modules INNER JOIN modules ON user_modules.module_id = modules.id INNER JOIN user_form ON user_modules.email = user_form.email WHERE user_form.email = '$email' AND modules.module_name = '$module_name'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['count'] == 0) {
    // If the module is not linked to the user, redirect to the login page
    header("Location: ../loginpage.php");
    exit();
}

// Fetch all users
$sql_users = "SELECT * FROM user_form";
$result_users = mysqli_query($con, $sql_users);
$users = mysqli_fetch_all($result_users, MYSQLI_ASSOC);

// Fetch all modules
$sql_modules = "SELECT * FROM modules";
$result_modules = mysqli_query($con, $sql_modules);
$modules = mysqli_fetch_all($result_modules, MYSQLI_ASSOC);

// Fetch user-module associations
$user_module_associations = array();
$sql_user_modules = "SELECT * FROM user_modules";
$result_user_modules = mysqli_query($con, $sql_user_modules);
while ($row = mysqli_fetch_assoc($result_user_modules)) {
    $user_module_associations[$row['email']][] = $row['module_id'];
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
        <a href="../Payroll/print-details_esi.php" target="_blank" class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
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
                Employee name
              </th>
              <th scope="col" class="px-6 py-3">
                ESI Number
              </th>
              <th scope="col" class="px-6 py-3">
                Salary Month
              </th>
              <th scope="col" class="px-6 py-3">
                Gross Salary
              </th>
              <th scope="col" class="px-6 py-3">
                Employee Share (0.75%)
              </th>
              <th scope="col" class="px-6 py-3">
                Employer Share (3.25%)
              </th>

            </tr>
          </thead>
          <?php
          $sql = "SELECT payroll_ss.*, payroll_ban.*, emp.pic
          FROM payroll_ss
          JOIN payroll_ban ON payroll_ss.empname = payroll_ban.empname
          JOIN emp ON payroll_ss.empname = emp.empname
          WHERE payroll_ban.uan IS NOT NULL AND payroll_ban.uan <> ''
            ORDER BY salarymonth DESC
                    ";
          $que = mysqli_query($con, $sql);
          $cnt = 1;
          if (mysqli_num_rows($que) > 0) {
            while ($result = mysqli_fetch_assoc($que)) {
          ?>
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4"><?php echo $cnt; ?></td>
                <td class="px-6 py-4">
                  <?php echo $result['empname']; ?></td>
                <td class="px-6 py-4">
                  <?php echo $result['esin']; ?>
                </td>
                <td class="px-6 py-4">
                  <?php echo $result['salarymonth']; ?>
                </td>
                <td class="px-6 py-4">
                  <?php echo $result['gross']; ?>
                </td>
                <td class="px-6 py-4">
                  <?php echo $result['esi1']; ?>
                </td>
                <td class="px-6 py-4">
                  <?php echo $result['esi2']; ?>
                </td>
              </tr>
            <?php
              $cnt++;
            }
          } else {
            ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td colspan="8" class="px-6 py-4 text-center">No upload history</td>
            </tr>
          <?php
          }
          ?>
        </table>

      </div>
    </div>
    <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

    <img width="90px" style="position: absolute; left:20px;" src="./public/logo-1@2x.png" />
    <a class="anikahrm14" href="./index.html" style="top:20px; left:120px;" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./reports.html" style="text-align: center; width: 60%;" id="attendenceManagement">ESI Statement</a>
  </div>
</body>

</html>