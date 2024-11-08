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
      background-color: #ebecf0;
      width: 400px;
      height: 200px;
      border: 1px solid rgb(185, 185, 185);
      box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);
    }

    .inputselect {
      border: none;
      pointer-events: none;
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

    .hidden-btn {
      display: none;
    }

    tr:hover .hidden-btn {
      display: block;
      transition: 300ms ease all;
    }

    tr:hover .hideon1 {
      display: none;
      transition: 300ms ease all;
    }

    .emi_img:hover {
      background-color: #F3F4F6;
    }

    .modalemi {
      display: none;
      position: fixed;
      z-index: 1;
      right: 0;
      top: 0;
      width: 50%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modalemi-content {
      background-color: #fefefe;
      padding: 20px;
      border: 1px solid #888;
      width: 100%;
      height: 100%;
    }

    .modalemi.active {
      display: block;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    }

    .close {
      color: #aaa;
      float: left;
      font-size: 28px;
      font-weight: bold;
      position: absolute;
      top: 400px;
      left: 0px;
      border: none;
      height: 40px;
      width: 40px;
      border-radius: 50%;
      box-shadow: 0px 1px 4px 1px rgba(0, 0, 0, .3);
      transform: translateX(-50%);
      cursor: pointer;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    @keyframes slideIn {
      from {
        right: -100%;
      }

      to {
        right: 0;
      }
    }

    @keyframes slideOut {
      from {
        right: 0;
      }

      to {
        right: -100%;
      }
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
      <a class="frame-child188" style="background-color: #e8e8e8;"> </a>
      <a class="frame-child189" id="rectangleLink1"> </a>
      <a class="frame-child190" id="rectangleLink2"> </a>
      <a class="frame-child191" id="rectangleLink3" href="advances.html"> </a>
      <a class="frame-child191" id="rectangleLink3" href="loans.html" style="margin-left: 220px; background-color: #ffe2c6;"> </a>
      <a class="attendence5" style="margin-left: -7px; width: 140px; color: black; margin-top: -4px;" href="updatesalary.html">Update Salary</a>
      <a class="records5" id="records" style="margin-left: -10px; width: 110px; margin-top: -4px;">Loss Of Pay</a>
      <a class="punch-inout4" id="punchINOUT" style="margin-left: 40px; margin-top: -4px;" href="bonus.html">Bonus</a>
      <a class="my-attendence4" href="advances.html" id="myAttendence" style="margin-left: 30px; margin-top: -4px;">Advances</a>
      <a class="my-attendence4" href="loans.html" id="myAttendence" style="margin-left: 270px; color: #ff6e24; margin-top: -4px;">Loans</a>
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
      <li class="flex items-center text-blue-600 dark:text-blue-500">
        <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-blue-700 rounded-full shrink-0 dark:border-gray-400">
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
    <?php
    $sql = "SELECT SUM(loamt) AS total_loamt, MAX(created) AS last_created FROM payroll_loan";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    $sum = $row['total_loamt'];
    $last_created = $row['last_created'];


    $sql = "SELECT 
            (SELECT SUM(loamt) FROM payroll_loan) AS total_loamt, 
            ( SELECT MAX(created) FROM payroll_emi) AS last_created, 
            (SELECT SUM(emi) FROM payroll_emi) AS total_emi ";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    $total_loamt = $row['total_loamt'];
    $total_emi = $row['total_emi'];
    $last_created1 = $row['last_created'];
    $balance = $total_loamt - $total_emi;

    ?>

    <div class="rectangle-parent23">
      <div id="marketing-banner" style="position:absolute; top:-30px; margin-left:-235px;" tabindex="-1" class="flex justify-between w-[calc(110%-2rem)] p-4 -translate-x-1/2 bg-white border border-gray-100 rounded-lg shadow-sm lg:max-w-7xl left-1/2 dark:bg-gray-700 dark:border-gray-600">
        <div class="flex flex-col items-start mb-3 me-4 md:items-center md:flex-row md:mb-0">
          <a href="#" class="flex items-center mb-2 border-gray-200 md:pe-4 md:me-4 md:border-e md:mb-0 dark:border-gray-600">
            <svg class="w-6 h-6 text-blue-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd" />
            </svg>

          </a>
          <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">In this step, HR should handle the deduction of loan EMIs (Equated Monthly Installments) from employee salaries. This includes verifying the loan details, calculating the appropriate deductions, and ensuring timely repayment.
          </p>
        </div>
      </div>
      <a href="p2_lop.php" style="position:absolute; right:220px;"><button type="button" class="text-white bg-[#FF9119] hover:bg-[#FF9119]/80 focus:ring-4 focus:outline-none focus:ring-[#FF9119]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:hover:bg-[#FF9119]/80 dark:focus:ring-[#FF9119]/40 me-2 mb-2">
          <svg style="margin-right:10px;" class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4" />
          </svg>
          Previous
        </button></a>


        <?php
            $sql = "SELECT smonth FROM payroll_schedule WHERE status = 2 LIMIT 1";

            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $smonth = $row["smonth"];
            } else {
                $smonth = "No month found with status = 0";
            }
            ?>
            <form id="employeeForm">
                <input type="hidden" name="status" value=3>
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



      <!-- deductions modal  -->
      <div id="modal" class="modalemi" style="background:none; border-top-left-radius:20px;border-bottom-left-radius:20px;">
        <div class="modalemi-content slide-left" style="border:none;border-top-left-radius:20px;border-bottom-left-radius:20px; background-color:#f6f5fb; ">
          <div style="display:inline-block;position:relative;">
            <div class="close"><img src="public/rightarrow.svg"></div>
          </div>
          <?php
          $current_month = date('m');
          $current_year = date('Y');
          $sql1 = "SELECT SUM(emi) AS total_cemi FROM payroll_emi WHERE MONTH(created) = $current_month AND YEAR(created) = $current_year";
          $result = mysqli_query($con, $sql1);
          $row = mysqli_fetch_assoc($result);
          $total_cemi = $row['total_cemi'];

          $sql = "SELECT SUM(emi) AS total_emi FROM payroll_emi";
          $result = mysqli_query($con, $sql);
          $row = mysqli_fetch_assoc($result);
          $total_emi = $row['total_emi'];
          ?>

          <div class="rectangle-div">
            <p style="position: absolute; top: 10px; left:10px; font-size: 20px;">Total Deduction's</p>
            <p style="position: absolute; top: 60px; left:10px; font-size: 30px; font-weight: 700;">₹ <?php echo $total_emi ?></p>
            <p style="position: absolute; top: 130px; left:10px; font-size: 15px; width: 200px; color: rgb(141, 141, 141);">Updated on <?php echo date('d-m-Y H:i:s', strtotime('+5 hours 30 minutes', strtotime($last_created1))); ?></p>
            <img src="./public/totalamt.png" style="position: absolute; right:10px; top: 60px;" width="120px" alt="">
          </div>
          <div class="rectangle-div" style="margin-left:500px;">
            <p style="position: absolute; top: 10px; left:10px; font-size: 20px;">Deduction's this month</p>
            <p style="position: absolute; top: 60px; left:10px; font-size: 30px; font-weight: 700;">₹ <?php echo $total_cemi ?></p>
            <p style="position: absolute; top: 130px; left:10px; font-size: 15px; width: 200px; color: rgb(141, 141, 141);">Updated on <?php echo date('d-m-Y H:i:s', strtotime('+5 hours 30 minutes', strtotime($last_created1))); ?></p>
            <img src="./public/dedamt.png" style="position: absolute; right:10px; top: 60px;" width="120px" alt="">
          </div>


          <h1 style="text-align:center; margin-top:220px;">Total EMI Deductions</h1>
          <hr style="margin-top: 20px;" />
          <table style="margin-top: 20px;" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead style="text-align: center;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr>
                <th scope="col" class="px-6 py-3">
                  Emp Name
                </th>
                <th scope="col" class="px-6 py-3">
                  EMI Month
                </th>
                <th scope="col" class="px-6 py-3">
                  EMI
                </th>
                <th scope="col" class="px-6 py-3">
                  Loan Number
                </th>
                <th scope="col" class="px-6 py-3">
                  Deducted on
                </th>
              </tr>
            </thead>
            <?php
            $sql = "SELECT * FROM payroll_emi  ORDER BY ID DESC";
            $que = mysqli_query($con, $sql);

            if (mysqli_num_rows($que) > 0) {
              while ($result = mysqli_fetch_assoc($que)) {
            ?>
                <tbody style="text-align: center;">

                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                    <td class="px-6 py-4"><?php echo $result['emimonth']; ?></td>
                    <td class="px-6 py-4"><?php echo $result['emi']; ?></td>
                    <td class="px-6 py-4"><?php echo $result['loanno']; ?></td>
                    <td class="px-6 py-4"><?php echo date('d-m-Y H:i:s', strtotime('+5 hours 30 minutes', strtotime($result['created']))); ?></td>
                  </tr>
                </tbody>
              <?php
              }
            } else {
              ?>
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td colspan="8" class="px-6 py-4 text-center">No EMI history</td>
              </tr>
            <?php
            }
            ?>
          </table>

        </div>
      </div>

      <div style="position:absolute; height:700px; overflow-y:auto; margin-top:50px; width:100%;">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 ">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:text-blue-800 ">
              <td colspan="9">
                <div class="inline-flex self-center items-center" style="padding:10px;">
                  <button id="openModalBtn" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                    EMI Deductions
                  </button>
                </div>
              </td>
            </tr>
            <tr>
              <th scope="col" class="px-6 py-3">
              </th>
              <th scope="col" class="px-6 py-3">
                Employee Name
              </th>
              <th scope="col" class="px-6 py-3">
                Loan No.
              </th>
              <th scope="col" class="px-6 py-3">
                Loan Amt
              </th>
              <th scope="col" class="px-6 py-3">
                Balance
              </th>
              <th scope="col" class="px-6 py-3">
                emi
              </th>
              <th scope="col" class="px-6 py-3">
                Loan Term
              </th>
              <th scope="col" class="px-6 py-3">
                Loan Status
              </th>
              <th scope="col" class="px-6 py-3">
                Action
              </th>
            </tr>
          </thead>
          <?php
          $sql = "SELECT pl.*, SUM(pe.emi) AS total_emi, emp.pic 
        FROM payroll_loan pl 
        LEFT JOIN payroll_emi pe ON pl.empname = pe.empname AND pl.loanno = pe.loanno 
        LEFT JOIN emp ON pl.empname = emp.empname 
        GROUP BY pl.empname, pl.loanno 
        ORDER BY pl.loanno ASC";
          $que = mysqli_query($con, $sql);

          if (mysqli_num_rows($que) > 0) {
            while ($result = mysqli_fetch_assoc($que)) {
              $balance = $result['loamt'] - $result['total_emi'];
          ?>
              <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <td class="px-6 py-4">
                    <img src="../pics/<?php echo $result['pic']; ?>" width="50px" style="border-radius: 50%;">
                  </td>
                  <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['loanno']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['loamt']; ?></td>
                  <td class="px-6 py-4">
                    <?php echo $balance; ?>
                  </td>
                  <td class="px-6 py-4"><?php echo $result['emi']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['loterm']; ?></td>
                  <td class="px-6 py-4">
                    <?php
                    if ($result['status'] == 1) {
                      echo '<span class="hideon1"><span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 inline-flex items-center px-2.5 py-0.5 rounded me-2 dark:bg-green-900 dark:text-green-300 border border-green-500">
                      <svg class="w-6 h-6 me-1.5 text-green-900 dark:text-white" xmlns="http://www.w3.org/2000/svg" width="37" height="37" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                      OPEN
                      </span></span>';
                    } else {
                      echo '<span class="hideon1"><span class="bg-gray-100 text-gray-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded me-2 dark:bg-gray-700 dark:text-gray-400 border border-gray-500 ">
                      <svg class="w-6 h-6 me-1.5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                      <path fill="currentColor" d="m18.774 8.245-.892-.893a1.5 1.5 0 0 1-.437-1.052V5.036a2.484 2.484 0 0 0-2.48-2.48H13.7a1.5 1.5 0 0 1-1.052-.438l-.893-.892a2.484 2.484 0 0 0-3.51 0l-.893.892a1.5 1.5 0 0 1-1.052.437H5.036a2.484 2.484 0 0 0-2.48 2.481V6.3a1.5 1.5 0 0 1-.438 1.052l-.892.893a2.484 2.484 0 0 0 0 3.51l.892.893a1.5 1.5 0 0 1 .437 1.052v1.264a2.484 2.484 0 0 0 2.481 2.481H6.3a1.5 1.5 0 0 1 1.052.437l.893.892a2.484 2.484 0 0 0 3.51 0l.893-.892a1.5 1.5 0 0 1 1.052-.437h1.264a2.484 2.484 0 0 0 2.481-2.48V13.7a1.5 1.5 0 0 1 .437-1.052l.892-.893a2.484 2.484 0 0 0 0-3.51Z"/>
                      <path fill="#fff" d="M8 13a1 1 0 0 1-.707-.293l-2-2a1 1 0 1 1 1.414-1.414l1.42 1.42 5.318-3.545a1 1 0 0 1 1.11 1.664l-6 4A1 1 0 0 1 8 13Z"/>
                  </svg>
                      CLOSED
                      </span></span>';
                    }
                    ?>
                    <button data-modal-target="default-modals" data-modal-toggle="default-modals" id="<?php echo $result['empname']; ?>" class="edit_data6 hidden-btn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  rounded-lg text-s px-2 py-2.5  dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                      View more
                    </button>
                  </td>
                  <td class="px-6 py-4 emi_img">
                    <a data-modal-target="default-modala" data-modal-toggle="default-modala" id="<?php echo $result['empname']; ?>" class="edit_data5">
                      <img src="./public/emi.svg" class="cursor-pointer " style="width:60px;">
                    </a>
                  </td>
                </tr>
              </tbody>
            <?php
            }
          } else {
            ?>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td colspan="9" class="px-6 py-4 text-center">No loan history</td>
            </tr>
          <?php
          }
          ?>

        </table>
        <div id="default-modals" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                  Loan Details <br>
                  <!-- <span style="font-size: 16px; font-weight: normal;">jan 15, 2024</span> -->
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modals">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                  <span class="sr-only">Close modal</span>
                </button>
              </div>
              <!-- Modal body -->
              <div class="p-4 md:p-5 space-y-4" id="info_update6">
                <?php @include("view_loanmodal.php"); ?>
              </div>
              <!-- Modal footer -->
            </div>
          </div>
        </div>
        <!--action modal-->
        <div id="default-modala" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                  EMI Details <br>
                  <!-- <span style="font-size: 16px; font-weight: normal;">jan 15, 2024</span> -->
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modala">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                  <span class="sr-only">Close modal</span>
                </button>
              </div>
              <!-- Modal body -->
              <div class="p-4 md:p-5 space-y-4" id="info_update5">
                <?php @include("p3_view_loandeduct.php"); ?>
              </div>
              <!-- Modal footer -->
              <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">

                <button data-modal-hide="default-modala" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
              </div>
            </div>
          </div>
        </div>

      
      </div>
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
  <a class="logout14" style="margin-top:-4px;">Logout</a>
  <a class="payroll14" href="payroll.php" style="color: white; z-index:9999; font-size:25px; font-weight:350; margin-top:-4px;">Payroll</a>
  <div class="reports14" style=" font-size:25px; font-weight:350; margin-top:-4px;">Reports</div>
  <img class="uitcalender-icon14" alt="" src="./public/uitcalender.svg" />

  <img style="-webkit-filter: grayscale(1) invert(1);
      filter: grayscale(1) invert(1); z-index:9999;" class="arcticonsgoogle-pay14" alt="" src="./public/arcticonsgooglepay.svg" />

  <img class="streamlineinterface-content-c-icon14" alt="" src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />

 

  <img class="attendence-child2" alt="" style="margin-top: 66px;" src="./public/rectangle-4@2x.png" />

  <a class="dashboard14" href="../index.php" style="z-index: 99999; font-size:25px; font-weight:350; margin-top:-4px;" id="dashboard">Dashboard</a>
  <a class="fluentpeople-32-regular14" style="z-index: 99999;" id="fluentpeople32Regular">
    <img class="vector-icon73" alt="" src="./public/vector7.svg" />
  </a>
  <a class="employee-list14" href="../employee-management.php" style="z-index: 99999; font-size:25px; font-weight:350; margin-top:-4px;" id="employeeList">Employee List</a>
  <a class="akar-iconsdashboard14" style="z-index: 99999;" href="../index.php" id="akarIconsdashboard">
    <img class="vector-icon74" alt="" src="./public/vector3.svg" />
  </a>
  <img class="tablerlogout-icon14" alt="" src="./public/tablerlogout.svg" />

  <a class="leaves14" id="leaves" style="z-index: 99999; font-size:25px; font-weight:350; margin-top:-4px;" href="../leave-management.php">Leaves</a>
  <a class="fluentperson-clock-20-regular14" id="fluentpersonClock20Regular">
    <img class="vector-icon75" style="z-index: 99999;" alt="" src="./public/vector1.svg" />
  </a>
  <a class="onboarding16" style="z-index: 99999; font-size:25px; font-weight:350; margin-top:-4px;" id="onboarding" href="../onboarding.php">Onboarding</a>
  <a class="fluent-mdl2leave-user14" style="z-index: 99999;" id="fluentMdl2leaveUser">
    <img class="vector-icon76" alt="" src="./public/vector.svg" />
  </a>
  <a class="attendance14" href="../attendence.php" style="color: black; z-index: 99999; font-size:25px; font-weight:350; margin-top:-4px;">Attendance</a>
  <a class="uitcalender14">
    <img class="vector-icon77" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1); z-index: 99999;" alt="" src="./public/vector11.svg" />
  </a>
  <div class="oouinext-ltr3"></div>
  </div>
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
                        window.location.href = 'p4_misc.php';
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
    document.getElementById('openModalBtn').addEventListener('click', function() {
      var modal = document.getElementById('modal');
      modal.classList.add('active');
      modal.style.animation = 'slideIn 0.5s forwards';
    });

    document.getElementsByClassName('close')[0].addEventListener('click', function() {
      var modal = document.getElementById('modal');
      modal.style.animation = 'slideOut 0.5s forwards';
      setTimeout(() => {
        modal.classList.remove('active');
      }, 500);
    });
  </script>
  <script>
    function setSelectedButton(value) {
      document.getElementById('selectedValue').value = value;

      console.log("Selected Value:", value);
    }
  </script>

  <script>
    window.onload = function() {
      myFuncdet11();

      document.querySelector('input[name="loamt"]').addEventListener('input', function() {
        myFuncdet11();
      });
    };

    function myFuncdet11() {
      // Get the value from input "loamt"
      var loamtValue = document.querySelector('input[name="loamt"]').value;

      // Set default value of input "emi" to loamtValue
      document.querySelector('input[name="emi"]').value = loamtValue;

      // Set default value of select "loterm" to "1 Month"
      document.querySelector('select[name="loterm"]').value = "1 Month";

      // Check if stmonth input is empty before setting its value
      var stmonthInput = document.querySelector('input[name="stmonth"]');
      if (stmonthInput.value === "") {
        // Calculate default value for input "stmonth" (next month, current year)
        var currentDate = new Date();
        currentDate.setMonth(currentDate.getMonth() + 1);
        var formattedDate = currentDate.toLocaleString('en-US', {
          month: 'long',
          year: 'numeric'
        });

        // Set default value of input "stmonth" to formattedDate
        stmonthInput.value = formattedDate;
      }



      console.log("loamtValue:", loamtValue);
      console.log("Default emiValue:", loamtValue);
      console.log("Default stmonth:", formattedDate);
      console.log("Default loterm:", "1 Month");
    }
  </script>


  <script type="text/javascript">
    $(document).ready(function() {
      // Download link click event
      $(document).on('click', '.download-link', function(e) {
        e.preventDefault();
        var empname = $(this).data('id');
        window.open("print-detailsld.php?empname=" + empname);
      });

      // View more button click event
      $(document).on('click', '.edit_data6', function() {
        var edit_id5 = $(this).attr('id');
        $.ajax({
          url: "view_loanmodal.php",
          type: "post",
          data: {
            edit_id5: edit_id5
          },
          success: function(data) {
            $("#info_update6").html(data);
            $("body").addClass("modal-open");
          }
        });
      });
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function() {
      $(document).on('click', '.edit_data5', function() {
        var edit_id5 = $(this).attr('id');
        $.ajax({
          url: "p3_view_loandeduct.php",
          type: "post",
          data: {
            edit_id5: edit_id5
          },
          success: function(data) {
            $("#info_update5").html(data);
            $("body").addClass("modal-open");
          }
        });
      });
    });
  </script>
</body>

<script>
  $(document).ready(function() {
    $('#employeeForm').submit(function(e) {
      e.preventDefault();

      $.ajax({
        type: 'POST',
        url: 'insert_loan.php',
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
              window.location.href = 'p4_misc.php';
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
  $(document).on('click', '[data-modal-hide="default-modals"]', function() {
    $("#default-modals").removeClass("show");
    $("body").removeClass("modal-open");
  });

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

  function myFuncdet3() {
    document.getElementById("disbtn").classList.add("backclr");
    document.getElementById("tdisbtn").classList.remove("backclr");
    document.getElementById("scheper1").classList.remove("remove");
  }

  function myFuncdet2() {
    document.getElementById("disbtn").classList.remove("backclr");
    document.getElementById("tdisbtn").classList.add("backclr");
    document.getElementById("scheper1").classList.add("remove");
  }
</script>

</html>