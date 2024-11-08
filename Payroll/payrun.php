<?php

@include 'inc/config.php';

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  header('location:loginpage.php');
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
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default@5/default.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .swal2-progress-bar {
      background-color: red;
    }

    .swal2-progress {
      border-radius: 60px;
    }
  </style>
</head>

<body>
  <div class="attendence4">
    <div class="bg14"></div>
    <div class="rectangle-parent23" style="margin-top: -40px; margin-left: -20px;">
      <div style="background-color: #f4f1fa; height: 100px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); margin-top: -40px;">
        <img src="./public/calend.png" width="90px" style="position: absolute; top: -35px; left: 10px;" alt="">
        <?php
        $sql = "SELECT smonth FROM payroll_schedule WHERE status = 0 LIMIT 1";

        $result = $con->query($sql);

        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          $smonth = $row["smonth"];
          $nextMonth = date('F Y', strtotime('+1 month', strtotime($row['smonth'])));

          $dateParts = explode(' ', $smonth);
          $month = $dateParts[0];
          $year = $dateParts[1];

          $numDays = cal_days_in_month(CAL_GREGORIAN, date('n', strtotime($month)), $year);
        } else {
          $smonth = "No month found with status = 0";
        }
        ?>


        <div style="position: absolute; left: 110px; top: -10px;">
          <label for="">Processing Payroll For </label>&nbsp;
          <input type="text" name="smonth" value="<?php echo $smonth; ?>" readonly style="border-radius: 5px;width:40%;text-align:center;" />
        </div>

        <a id="runPayrollBtn" href="p1_salarytable.php">
          <button style="position: absolute; right: 60px; top: -10px;" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Run Payroll
          </button>
        </a>

      </div><br>
      <div style="position: absolute; background-color: #fcfbff; border: 1px solid #dadada; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); width: 440px; height: 180px; border-radius: 10px;">
        <p style="font-size: 18px; color: #7e7e7e; position: absolute; left: 20px; top: 20px;">Period: <span style="font-size: 19px; color: rgb(88, 88, 88);">
            <?php echo $smonth ?></span> | <?php echo $numDays ?> Pay Days</p>
        <div style="position: absolute; left: 20px; top: 75px; display: flex; align-items: center; justify-content: center; background-color: #e4dfff; border-radius: 50%; width: 50px; height: 50px;">
          <img src="./public/Group-2.svg" width="20px" alt="">
        </div>
        <div style="position: absolute; right: 180px; top: 75px; display: flex; align-items: center; justify-content: center; background-color: #dfffef; border-radius: 50%; width: 50px; height: 50px;">
          <img src="./public/Vector-1231.svg" width="20px" alt="">
        </div>
        <div>
          <?php
          $sql = "SELECT SUM(netpay + epf1 + epf2 + esi1 + esi2 + epf3) AS total_payroll FROM payroll_msalarystruc";
          $result = $con->query($sql);
          $row = $result->fetch_assoc();
          $total_payroll = $row['total_payroll'];

          $sql1 = "SELECT SUM(emi) AS total_emi FROM payroll_emi";
          $result = $con->query($sql1);
          $row = $result->fetch_assoc();
          $total_emi = $row['total_emi'];
          $payroll =  $total_payroll;
          if (($total_payroll - floor($total_payroll)) > 0.5) {
            $payroll = ceil($total_payroll);
          } elseif (($total_payroll - floor($total_payroll)) < 0.5) {
            $payroll = floor($total_payroll);
          }
          ?>
          <p style="position: absolute; left: 73px; top: 70px; font-size: 30px;">₹<?php echo $payroll; ?></p>
          <p style="position: absolute; left: 76px; top: 110px; font-size: 15px; color: #7e7e7e;">PAYROLL COST*</p>
        </div>
        <div>
          <?php
          $sql = "SELECT SUM(netpay) AS total_payout FROM payroll_msalarystruc";
          $result = $con->query($sql);
          $row = $result->fetch_assoc();
          $sum = $row['total_payout'];
          ?>
          <p style="position: absolute; right: 20px; top: 70px; font-size: 30px;">₹<?php echo $sum; ?></p>
          <p style="position: absolute; right: 21px; top: 110px; font-size: 15px; color: #7e7e7e;">EMPLOYEE'S NET PAY*</p>
        </div>
      </div>
      <?php
      $sql = "SELECT smonth,sdate FROM payroll_schedule WHERE approval = 0 LIMIT 1";
      $result = $con->query($sql);
      $row = $result->fetch_assoc();
      $smonth = $row['smonth'];
      $sdate = $row['sdate'];
      ?>
      <div style="position: absolute; background-color: rgb(255, 255, 255); box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); width: 200px; height: 180px; border-radius: 10px; margin-left: 470px; border: 1px solid #e7e7e7;">
        <p style="position: absolute; left: 66px; color: #7e7e7e; top: 20px; font-size: 18px;">PAY DAY</p>
        <p style="position: absolute; left: 77px; top: 50px; font-size: 37px; font-weight: lighter;"> <?php echo $sdate; ?></p>
        <p style="position: absolute; top: 100px; font-size: 18px; border-bottom: 1px solid #e7e7e7; width: 200px; text-align: center; padding-bottom: 10px;">
          <?php echo $nextMonth; ?></p>
        <?php
        $sql4 = "SELECT COUNT(*) as count FROM payroll_msalarystruc";

        $result4 = $con->query($sql4);
        $row4 = $result4->fetch_assoc();
        $count4 = $row4['count'];
        ?>
        <p style="position: absolute; left: 46px; color: #7e7e7e; top: 145px; font-size: 15px;"><?php echo $count4; ?> EMPLOYEES</p>
      </div>
      <?php
      $sql = "SELECT SUM(netpay) AS total_payout FROM payroll_msalarystruc";
      $result = $con->query($sql);
      $row = $result->fetch_assoc();
      $sum = $row['total_payout'];

      $sql_1 = "SELECT SUM(epf1 + epf2  + epf3) AS total_epf FROM payroll_msalarystruc";
      $result = $con->query($sql_1);
      $row = $result->fetch_assoc();
      $sumEpf = $row['total_epf'];
      if (($sumEpf - floor($sumEpf)) > 0.5) {
        $sumEpf = ceil($sumEpf);
      } elseif (($sumEpf - floor($sumEpf)) < 0.5) {
        $sumEpf = floor($sumEpf);
      }
      $sql_2 = "SELECT SUM(esi1 + esi2) AS total_esi FROM payroll_msalarystruc";
      $result = $con->query($sql_2);
      $row = $result->fetch_assoc();
      $sumEsi = $row['total_esi'];
      if (($sumEsi - floor($sumEsi)) > 0.5) {
        $sumEsi = ceil($sumEsi);
      } elseif (($sumEsi - floor($sumEsi)) < 0.5) {
        $sumEsi = floor($sumEsi);
      }
      $sql_3 = "SELECT SUM(emi) AS total_emi FROM payroll_emi";
      $result = $con->query($sql_3);
      $row = $result->fetch_assoc();
      $sumEmi = $row['total_emi'];
      if (($sumEmi - floor($sumEmi)) > 0.5) {
        $sumEmi = ceil($sumEmi);
      } elseif (($sumEmi - floor($sumEmi)) < 0.5) {
        $sumEmi = floor($sumEmi);
      }

      $total = $sum + $sumEpf + $sumEsi ;
      ?>
      <div style="margin-top: 200px;">
        <table style="border: 1px solid rgb(219, 219, 219); box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 rounded-lg border">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3" colspan="5">
                Employee Payables
              </th>
            </tr>
          </thead>
          <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4" style="padding-bottom:17px;">
                <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffdfdf; border-radius: 50%; top: 340px; width: 50px; height: 50px;">
                  <img src="./public/banktransfer.svg" width="20px" alt="">
                </div>
                <span style="margin-left: 60px;">BANK TRANSFER <br> <span style="margin-left: 60px;">₹<?php echo $sum; ?></span></span>
              </td>
              <td class="px-6 py-4">
                <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffe8df; border-radius: 50%; top: 340px; width: 50px; height: 50px;">
                  <img src="./public/EPFESIC.svg" width="20px" alt="">
                </div>
                <span style="margin-left: 60px;">EPF <br> <span style="margin-left: 60px;">₹<?php echo $sumEpf; ?></span></span>
              </td>
              <td class="px-6 py-4">
                <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffe8df; border-radius: 50%; top: 340px; width: 50px; height: 50px;">
                  <img src="./public/EPFESIC.svg" width="20px" alt="">
                </div>
                <span style="margin-left: 60px;">ESIC <br> <span style="margin-left: 60px;">₹<?php echo $sumEsi; ?></span></span>
              </td>
              <td class="px-6 py-4">
                <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #fff1df; border-radius: 50%; top: 340px; width: 50px; height: 50px;">
                  <img src="./public/others.svg" width="20px" alt="">
                </div>
                <span style="margin-left: 60px;">OTHERS <br> <span style="margin-left: 60px;">₹<?php echo $sumEmi; ?></span></span>
              </td>
              <td class="px-6 py-4">
                <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #dfedff; border-radius: 50%; top: 340px; width: 50px; height: 50px;">
                  <img src="./public/totalsvg.svg" width="20px" alt="">
                </div>
                <span style="margin-left: 60px;">TOTAL <br> <span style="margin-left: 60px;">₹<?php echo $total; ?></span></span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div style="margin-top: 10px;  overflow-y:auto; height:430px;">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">
                Emp Name
              </th>
              <th scope="col" class="px-6 py-3">
                Salary Type
              </th>
              <th scope="col" class="px-6 py-3">
                Pay Days
              </th>
              <th scope="col" class="px-6 py-3">
                LOP
              </th>
              <th scope="col" class="px-6 py-3">
                Deductions
              </th>
              <th scope="col" class="px-6 py-3">
                Net Pay
              </th>
            </tr>
          </thead>
          <?php
       $sql = "SELECT payroll_msalarystruc.*, payroll_lop.flop
       FROM payroll_msalarystruc
       LEFT JOIN payroll_lop ON payroll_msalarystruc.empname = payroll_lop.empname
       LEFT JOIN payroll_schedule ON payroll_schedule.smonth = payroll_lop.lopmonth
       WHERE payroll_schedule.status = 0
       ORDER BY payroll_msalarystruc.empname ASC";



          $que = mysqli_query($con, $sql);

          if (mysqli_num_rows($que) > 0) {
            while ($result = mysqli_fetch_assoc($que)) {
              $deduct =  $result['epf1'] + $result['epf2'] + $result['esi1'];
          ?>
              <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['salarytype']; ?></td>
                  <td class="px-6 py-4"><?php echo $numDays ?></td>
                  <td class="px-6 py-4"><?php echo (!empty($result['flop']) ? $result['flop'] : '0'); ?></td>
                  <td class="px-6 py-4"><?php echo $deduct; ?></td>
                  <td class="px-6 py-4"><?php echo $result['netpay']; ?></td>
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
</body>
<script>
  document.getElementById('runPayrollBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default link behavior

    // Define array of dynamic texts
    var dynamicTexts = ['Data Collection and Validation', 'Data Allocation and Processing', 'Package Preparation and Bundling', 'Response Generation and Delivery', 'Process started !!!'];

    // Show SweetAlert2 loading animation
    Swal.fire({
      title: 'Initiating Payroll Run',
      text: dynamicTexts[0], // Initial text
      allowOutsideClick: false, // Prevent user from closing the popup
      allowEscapeKey: false, // Prevent user from closing the popup with Esc key
      showConfirmButton: false, // Hide the confirm button
      showCancelButton: false, // Hide the cancel button
      showCloseButton: false, // Hide the close button
      showLoaderOnConfirm: true, // Show loader animation
      timer: 8000, // Set a timer for 5 seconds
      timerProgressBar: true, // Show progress bar during timer
      didOpen: () => {
        var currentIndex = 0;

        // Update text every second
        var intervalId = setInterval(() => {
          currentIndex++;
          if (currentIndex < dynamicTexts.length) {
            Swal.update({
              text: dynamicTexts[currentIndex]
            });
          }
        }, 1500);

        // Redirect after 5 seconds
        setTimeout(() => {
          clearInterval(intervalId);
          window.location.href = 'p1_salarytable.php';
        }, 8000); // 5000 milliseconds = 5 seconds
      }
    });
  });
</script>
<script>
  function toggleCheckboxes(checkbox) {
    var checkboxes = document.querySelectorAll('.absentCheckbox');
    checkboxes.forEach(function(cb) {
      cb.checked = checkbox.checked;
    });
    updateSelectedCount();
  }

  function updateSelectedCount() {
    var count = document.querySelectorAll('.absentCheckbox:checked').length;
    document.getElementById('selectedCount').textContent = '(' + count + ')';
  }

  updateSelectedCount();
</script>

</html>