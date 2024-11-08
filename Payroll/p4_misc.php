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
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-default@5/default.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <style>
    .rectangle-div {
      position: absolute;
      /* top: 136px; */
      border-radius: 20px;
      background-color: #ffffff;
      width: 400px;
      height: 200px;
      border: 1px solid rgb(185, 185, 185);
      box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);
    }

    label {
      font-weight: normal;
    }

    .backclr {
      background-color: #dfebff;
    }

    .remove {
      display: none;
    }

    .hide-calendar .ui-datepicker-calendar {
      display: none;
      width: 120px !important;
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
    <!-- <div class="rectangle-parent22" style="margin-left: -80px;">
      <div class="frame-child187" style="margin-left: 80px;"></div>
      <a class="frame-child188" style="background-color: #e8e8e8;" href="updatesalary.html"> </a>
      <a class="frame-child189" id="rectangleLink1" href="lop.html"> </a>
      <a class="frame-child190" id="rectangleLink2" href="bonus.php"> </a>
      <a class="frame-child191" style="background-color: #ffe2c6;" id="rectangleLink3" href="advances.html"> </a>
      <a class="frame-child191" id="rectangleLink3" href="loans.html" style="margin-left: 220px; "> </a>
      <a class="attendence5" style="margin-left: -7px; width: 140px; color: black; margin-top: -4px;" href="updatesalary.html">Update Salary</a>
      <a class="records5" id="records" style="margin-left: -10px; width: 110px; margin-top: -4px;" href="lop.html">Loss Of Pay</a>
      <a class="punch-inout4" id="punchINOUT" style="margin-left: 40px; margin-top: -4px;" href="bonus.php">Bonus</a>
      <a class="my-attendence4" href="advances.html" id="myAttendence" style="margin-left: -1px; width: 200px; margin-top: -4px;  color: #ff6e24;">Misc. Deductions</a>
      <a class="my-attendence4" href="loans.html" id="myAttendence" style="margin-left: 270px; margin-top: -4px;">Loans</a>
    </div> -->
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
        Leave Adjustments
        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
        </svg>
      </li>
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
        Loan Repayments
        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
        </svg>
      </li>
      <li class="flex items-center text-blue-600 dark:text-blue-500">
        <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-blue-700 rounded-full shrink-0 dark:border-gray-400">
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
      <div id="marketing-banner" style="position:absolute; top:-30px; margin-left:-235px;" tabindex="-1" class="flex justify-between w-[calc(110%-2rem)] p-4 -translate-x-1/2 bg-white border border-gray-100 rounded-lg shadow-sm lg:max-w-7xl left-1/2 dark:bg-gray-700 dark:border-gray-600">
        <div class="flex flex-col items-start mb-3 me-4 md:items-center md:flex-row md:mb-0">
          <a href="#" class="flex items-center mb-2 border-gray-200 md:pe-4 md:me-4 md:border-e md:mb-0 dark:border-gray-600">
            <svg class="w-6 h-6 text-blue-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd" />
            </svg>

          </a>
          <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">HR needs to manage miscellaneous deductions in this step, such as Training Fees, Fines, or any other deductions apart from regular salary components.
          </p>
        </div>
      </div>
      <a href="p3_loans.php" style="position:absolute; right:220px;"><button type="button" class="text-white bg-[#FF9119] hover:bg-[#FF9119]/80 focus:ring-4 focus:outline-none focus:ring-[#FF9119]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:hover:bg-[#FF9119]/80 dark:focus:ring-[#FF9119]/40 me-2 mb-2">
          <svg style="margin-right:10px;" class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4" />
          </svg>

          Previous
        </button></a>
      <?php

      $sql = "SELECT smonth FROM payroll_schedule WHERE status = 3 LIMIT 1";

      $result = $con->query($sql);

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $smonth = $row["smonth"];
      } else {
        $smonth = "No month found with status = 0";
      }
      ?>
      <form id="employeeForm">
        <input type="hidden" name="status" value=4>
        <input type="hidden" name="smonth" value="<?php echo $smonth; ?>">
        <a style="position:absolute; right:0;">
          <button id="steps" type="submit" class="text-white bg-[#FF9119] hover:bg-[#FF9119]/80 focus:ring-4 focus:outline-none focus:ring-[#FF9119]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:hover:bg-[#FF9119]/80 dark:focus:ring-[#FF9119]/40 me-3 mb-2">
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

      <div style="position:absolute; height:700px; overflow-y:auto; margin-top:50px; width:100%;">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:text-blue-800 ">
              <td colspan="9">
                <div class="inline-flex self-center items-center" style="padding:10px;">
                  <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                    + Create New Deduction
                  </button>
                </div>
              </td>
            </tr>
            <tr>
              <th scope="col" class="px-6 py-3">
                Deduction ID
              </th>
              <th scope="col" class="px-6 py-3">
                Emp Name
              </th>
              <th scope="col" class="px-6 py-3">
                Deduction Type
              </th>
              <th scope="col" class="px-6 py-3">
                Deduction amount
              </th>
              <th scope="col" class="px-6 py-3">
                Deduction Paymonth
              </th>
              <th scope="col" class="px-6 py-3">
                Reason
              </th>
              <th scope="col" class="px-6 py-3">
                Created on
              </th>
            </tr>
          </thead>
          <?php
           $cnt = 1;
           $sql = "SELECT payroll_misc.*
           FROM payroll_misc
           INNER JOIN payroll_schedule ON payroll_misc.paymonth = payroll_schedule.smonth
           WHERE payroll_schedule.approval = 0
           ORDER BY payroll_misc.ID ASC";
   
          $que = mysqli_query($con, $sql);

          if (mysqli_num_rows($que) > 0) {
            while ($result = mysqli_fetch_assoc($que)) {
          ?>
              <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                     <td class="px-6 py-4"><?php echo $cnt++; ?></td>
                  <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['dtype']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['damt']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['paymonth']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['reason']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['created']; ?></td>

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

        <!-- Main modal -->
        <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                  Create a New Deduction
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                  <span class="sr-only">Close modal</span>
                </button>
              </div>
              <!-- Modal body -->
              <form id="employeeForm">
                <div class="p-4 md:p-5 space-y-4" style="margin-left: 65px;">
                  <p style="font-size: 13px; font-weight: 500; position: absolute; right: 30px;">DEDUCTION ID: ASPLDEDUCTION202401230001</p> <br>
                  <label for="">Employee Name:</label>
                  <select name="empname" id="" style="width: 300px; border-radius: 5px; ">
                    <option value="" disabled selected>--Select--</option>
                    <?php
                    $sql = "SELECT empname FROM emp where empstatus=0 ORDER BY emp_no ASC";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["empname"] . "'>" . $row["empname"] . "</option>";
                      }
                    } else {
                      echo "0 results";
                    }
                    ?>
                  </select>
                  <label for="">Deduction Type:</label>
                  <select name="dtype" id="" style="width: 300px; border-radius: 5px; margin-left: 5px;">
                    <option value="">--Select--</option>
                    <option value="Training Fees">Training Fees</option>
                    <option value="Fine">Fine</option>
                    <option value="Other">Other</option>
                  </select>
                  <div style="display: flex;">
                    <label for="">Deduction Amount:</label>
                    <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px; margin-left: 18px;">₹</div>
                    <input type="text" name="damt" style="font-size: 18px; width: 200px; height: 40px; border: 1px solid rgb(185,185,185);">
                    <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                  </div>
                  <label for="">Payout Month:</label>
                  <input id="datepicker" name="paymonth" class="datepicker-without-calendar" type="text" style="width: 300px; border-radius: 5px; margin-left: 20px;">
                  <div style="margin-top: 20px;">
                    <label for="">Reason:</label><br>
                    <textarea name="reason" cols="47" rows="3" style="border-radius: 5px;"></textarea>
                  </div>
                </div>

                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                  <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
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
$(document).ready(function() {
    $('#steps').click(function(e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'update_steps.php',
            data: new FormData($('#employeeForm')[0]),
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
                        window.location.href = 'p5_bonus.php';
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
  $(document).ready(function() {
    $('#employeeForm').submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: 'insert_misc.php',
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function(response) {
          console.log('Success:', response);
          Swal.fire({
            icon: 'success',
            title: 'Created!',
            text: response,
            confirmButtonText: 'OK'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'misc.php';
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
  $('.datepicker-without-calendar').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'MM yy',
    beforeShow: function(input) {
      $(input).datepicker("widget").addClass('hide-calendar');
    },
    onClose: function(dateText, inst) {
      $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
      $(this).datepicker('widget').removeClass('hide-calendar');
    }
  });

  $('.datepicker').datepicker();
</script>

</html>