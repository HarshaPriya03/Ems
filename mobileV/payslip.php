<?php

@include '../inc/config.php';

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  header('location:main.php');
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

  <link rel="stylesheet" href="../global.css" />
  <link rel="stylesheet" href="../salary.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" />
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</head>

<body>

  <table id="payrollTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
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

  <!-- <script>
    function openPayrollHistory(monthYear) {
      window.location.href = "payslip1.php?smonth=" + monthYear;
    }
  </script> -->
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