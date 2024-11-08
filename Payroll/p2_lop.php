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
      z-index: 1000 !important;
    }


    .hovpic:hover {
      transform: scale(5, 5);
    }

    ol {
      display: flex;
      justify-content: center;
      margin-left: 200px;
      ;
    }
  </style>

</head>

<body>
  <div class="attendence4">
    <div class="bg14"></div>
    <ol class="flex items-center w-full p-3 space-x-2 text-sm font-medium text-center text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 sm:text-base dark:bg-gray-800 dark:border-gray-700 sm:p-4 sm:space-x-4 rtl:space-x-reverse" style="position: absolute; margin-top: 81px;">
      <li class="flex items-center text-green-400 dark:text-blue-500">
        <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400" style="background-color: #dbffd6; border: 1px solid rgb(127, 255, 127);">
          <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="10" height="10" viewBox="0,0,256,256">
            <g transform="">
              <g fill="#1eff1e" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                <g transform="scale(8.53333,8.53333)">
                  <path d="M26.98047,5.99023c-0.2598,0.00774 -0.50638,0.11632 -0.6875,0.30273l-15.29297,15.29297l-6.29297,-6.29297c-0.25082,-0.26124 -0.62327,-0.36647 -0.97371,-0.27511c-0.35044,0.09136 -0.62411,0.36503 -0.71547,0.71547c-0.09136,0.35044 0.01388,0.72289 0.27511,0.97371l7,7c0.39053,0.39037 1.02353,0.39037 1.41406,0l16,-16c0.29576,-0.28749 0.38469,-0.72707 0.22393,-1.10691c-0.16075,-0.37985 -0.53821,-0.62204 -0.9505,-0.60988z"></path>
                </g>
              </g>
            </g>
          </svg>
        </span>
        Salary Details
        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
        </svg>
      </li>
      <li class="flex items-center text-blue-600 dark:text-blue-500">
        <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-blue-700 rounded-full shrink-0 dark:border-gray-400">
          2
        </span>
        Leave Adjustments
        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
        </svg>
      </li>
      <li class="flex items-center">
        <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
          3
        </span>
        Loan Repayments
        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
        </svg>
      </li>
      <li class="flex items-center">
        <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
          4
        </span>
        Other Deductions
        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
        </svg>
      </li>
      <li class="flex items-center">
        <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
          5
        </span>
        Bonus Allocation
        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
        </svg>
      </li>
      <li class="flex items-center">
        <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
          6
        </span>
        Review Salary Structure
        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
        </svg>
      </li>
      <li class="flex items-center">
        <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
          7
        </span>
        Confirm Salary
      </li>
    </ol>
    <div class="rectangle-parent23">
      <div id="marketing-banner" style="position:absolute; top:-30px; margin-left:-235px;" tabindex="-1" class="z-50 flex justify-between w-[calc(110%-2rem)] p-4 -translate-x-1/2 bg-white border border-gray-100 rounded-lg shadow-sm lg:max-w-7xl left-1/2 dark:bg-gray-700 dark:border-gray-600">
        <div class="flex flex-col items-start mb-3 me-4 md:items-center md:flex-row md:mb-0">
          <a href="#" class="flex items-center mb-2 border-gray-200 md:pe-4 md:me-4 md:border-e md:mb-0 dark:border-gray-600">
            <svg class="w-6 h-6 text-blue-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd" />
            </svg>

          </a>
          <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">HR needs to manage loss of pay (LOP) adjustments in this step. This involves recording any instances where employees have taken unpaid leave or have had deductions from their salary due to absence from work.
          </p>
        </div>
      </div>
      <a href="p1_salarytable.php" style="position:absolute; right:220px;"><button type="button" class="text-white bg-[#FF9119] hover:bg-[#FF9119]/80 focus:ring-4 focus:outline-none focus:ring-[#FF9119]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:hover:bg-[#FF9119]/80 dark:focus:ring-[#FF9119]/40 me-2 mb-2">
          <svg style="margin-right:10px;" class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4" />
          </svg>
          Previous
        </button></a>
      <?php


      $sql = "SELECT smonth FROM payroll_schedule WHERE status = 1 LIMIT 1";

      $result = $con->query($sql);

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $smonth = $row["smonth"];
      } else {
        $smonth = "No month found with status = 0";
      }
      ?>
      <form id="employeeForm">
        <input type="hidden" name="status" value=2>
        <input type="hidden" name="smonth" value="<?php echo $smonth; ?>">
        <a style="position:absolute; right:0;">
          <button type="submit" class="text-white bg-[#FF9119] hover:bg-[#FF9119]/80 focus:ring-4 focus:outline-none focus:ring-[#FF9119]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:hover:bg-[#FF9119]/80 dark:focus:ring-[#FF9119]/40 me-3 mb-2">
            <svg class="w-6 h-6 me-2 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.032 12 1.984 1.984 4.96-4.96m4.55 5.272.893-.893a1.984 1.984 0 0 0 0-2.806l-.893-.893a1.984 1.984 0 0 1-.581-1.403V7.04a1.984 1.984 0 0 0-1.984-1.984h-1.262a1.983 1.983 0 0 1-1.403-.581l-.893-.893a1.984 1.984 0 0 0-2.806 0l-.893.893a1.984 1.984 0 0 1-1.403.581H7.04A1.984 1.984 0 0 0 5.055 7.04v1.262c0 .527-.209 1.031-.581 1.403l-.893.893a1.984 1.984 0 0 0 0 2.806l.893.893c.372.372.581.876.581 1.403v1.262a1.984 1.984 0 0 0 1.984 1.984h1.262c.527 0 1.031.209 1.403.581l.893.893a1.984 1.984 0 0 0 2.806 0l.893-.893a1.985 1.985 0 0 1 1.403-.581h1.262a1.984 1.984 0 0 0 1.984-1.984V15.7c0-.527.209-1.031.581-1.403Z" />
            </svg>
            Confirm & Next
            <svg style="margin-left:10px;" class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
            </svg>
          </button>
        </a>
      </form>
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
      <div style="position:absolute; height:700px; overflow-y:auto; margin-top:50px; width:100%;">
        <form>
          <table id="lopTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead style="text-align: center;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:text-blue-800 " style="position:sticky; top:0;">
                <td colspan="10">
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
              </tr>
              <tr>
                <th scope="col" class="px-6 py-3"></th>
                <th scope="col" class="px-6 py-3">Employee Name</th>
                <th scope="col" class="px-6 py-3">LOP Month</th>
                <th scope="col" class="px-6 py-3">Worked Days</th>
                <th scope="col" class="px-6 py-3">Leave Balance</th>
                <th scope="col" class="px-6 py-3">LOP</th>
                <th scope="col" class="px-6 py-3">Lop Adjustment</th>
                <th scope="col" class="px-6 py-3">Final LOP</th>
                <th scope="col" class="px-6 py-3">Comments</th>
                <th scope="col" class="px-6 py-3">LOP Marked On</th>
              </tr>
            </thead>
            <tbody style="text-align: center;">
              <?php
              $sql = "SELECT payroll_lop.*, emp.pic 
           FROM payroll_lop 
           INNER JOIN emp ON payroll_lop.empname = emp.empname ORDER BY created DESC";
              $que = mysqli_query($con, $sql);

              if (mysqli_num_rows($que) > 0) {
                while ($result = mysqli_fetch_assoc($que)) {


              ?>
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4"><img src="../pics/<?php echo $result['pic']; ?>" width="50px" style="border-radius: 50%;" alt=""></td>
                    <td class="px-6 py-4"><?php echo $result['empname']; ?></php>
                    </td>
                    <td class="px-6 py-4"><?php echo ($result['lopmonth']); ?></td>
                    <td class="px-6 py-4"><?php echo ($result['worked']); ?></td>
                    <td class="px-6 py-4"><?php echo ($result['leavebal']); ?></td>
                    <td class="px-6 py-4"><?php echo abs($result['lop']); ?></td>
                    <td class="px-6 py-4"><?php echo ($result['lopadj']); ?></td>
                    <td class="px-6 py-4 final-lop-cell"><?php echo ($result['flop']); ?></td>
                    <td class="px-6 py-4"><?php echo ($result['comment']); ?></td>
                    <td class="px-6 py-4">
                      <?php echo date('d-m-Y H:i:s', strtotime('+5 hours 30 minutes', strtotime($result['created']))); ?>
                    </td>
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
    <a class="payroll14" style="color: white; z-index:9999;">Payroll</a>
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
  function selectFirstOption() {
    var selectElement = document.getElementById('monthYearSelect');
    selectElement.selectedIndex = 0; // Select the first option
    filterData(); // Call the function to handle filtering data
  }

  function filterData() {
    // Add your filtering logic here
    console.log('Filtering data...');
  }
</script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.0/d3.js'></script>
<script src='https://rawgit.com/pablomolnar/radial-progress-chart/master/dist/radial-progress-chart.js'></script>
<script>
  $(document).ready(function() {
    $('#employeeForm').submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: 'update_steps.php',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function(response) {
          console.log('Success:', response);
          Swal.fire({
            icon: 'success',
            title: 'Confirmed!',
            text: response,
            confirmButtonText: 'OK'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'p3_loans.php';
              $('#employeeForm')[0].reset();
            }
          });
        },
        error: function(xhr, status, error) {
          console.log('Error:', xhr.responseText);
        }
      });
    });
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