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

// If the user has access to the payroll module, continue loading the payroll page
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

    ol {
      display: flex;
      justify-content: center;
      margin-left: 200px;
      ;
    }

    @keyframes blink {
      0% {
        opacity: 1;
      }

      50% {
        opacity: 0;
      }

      100% {
        opacity: 1;
      }
    }

    .blink {
      animation: blink 0.9s infinite;
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
        Other Deductions

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
        Bonus Allocation
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
        Review Salary Structure
        <svg class="w-3 h-3 ms-2 sm:ms-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4" />
        </svg>
      </li>
      <li class="flex items-center text-blue-600 dark:text-blue-500">
        <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-blue-700 rounded-full shrink-0 dark:border-gray-400">
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
          <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">Finally, HR needs to confirm the salary adjustments for each employee in this step. This includes reviewing the finalized salary structure, obtaining necessary approvals, and confirming the salary adjustments with employees before processing payroll.
          </p>
        </div>
      </div>
      <a href="p6_finalstatement.php" style="position:absolute; right:220px;"><button type="button" class="text-white bg-[#FF9119] hover:bg-[#FF9119]/80 focus:ring-4 focus:outline-none focus:ring-[#FF9119]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:hover:bg-[#FF9119]/80 dark:focus:ring-[#FF9119]/40 me-2 mb-2">
          <svg style="margin-right:10px;" class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4" />
          </svg>

          Previous
        </button></a>

      <?php
      $sql = "SELECT smonth FROM payroll_schedule WHERE status = 6 LIMIT 1";

      $result = $con->query($sql);

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $smonth = $row["smonth"];
      } else {
        $smonth = "No month found with status = 0";
      }
      ?>
      <form id="employeeForm">
        <input type="hidden" name="status" value=7>
        <input type="hidden" name="smonth" value="<?php echo $smonth; ?>">
        <a style="position:absolute; right:0; ">
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
      <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" style="margin-top:-200px;" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
              <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Approve Payroll
              </h3>
              <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="static-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
              </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
              <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                You are about to approve this payroll for March, 2024. Once you approve it, you can make payments for all your employees on the paydate 06/04/2024.
              </p>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
              <button data-modal-hide="static-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Confirm & Approve
              </button>
              <button data-modal-hide="static-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
            </div>
          </div>
        </div>
      </div>
      <?php
      $currentMonthYear = date('F Y');
      ?>
      <!-- Main modal -->
      <div id="crud-modal" data-modal-placement="top-right" style="margin-top:200px; right:40px;" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-10/12 p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5  rounded-t">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Please enter the transaction ref. number to access <?php echo $currentMonthYear ?> salary statement.
              </h3>
              <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
              </button>
            </div>
            <!-- Modal body -->
            <?php
            $currentMonthYear = date('F Y');
            ?>
            <form id="transId" class="p-4 md:p-5">
              <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                  <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Transaction Reference Number</label>
                  <input type="text" name="transid" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type here" required="">
                </div>
                <input type="hidden" value="<?php echo $currentMonthYear ?>" name="salarymonth">
              </div>

              <button type="submit" data-drawer-target="drawer-contact" data-drawer-show="drawer-contact" aria-controls="drawer-contact" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-5.5 h-5.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 18 23">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-4m5-13v4a1 1 0 0 1-1 1H5m0 6h9m0 0-2-2m2 2-2 2" />
                </svg>
                Save & Access
                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
              </button>
            </form>
          </div>
        </div>
      </div>
      <div style="position:absolute; height:700px; overflow-y:auto; margin-top:50px; width:100%;">
        <form id="payrollForm">
          <div id="payrollTableContainer">
            <table id="payrollTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
              <thead style="text-align: center;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:text-blue-800 ">
                  <td colspan="9">
                    <div class="inline-flex self-center items-center" style="padding:10px;">
                      <button type="button" id="openModalBtn" data-modal-target="default-modal" data-modal-toggle="default-modal" class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Confirm
                      </button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <th scope="col" class="px-6 py-3">
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Emp Name
                  </th>
                  <th scope="col" class="px-6 py-3">
                    View
                  </th>
                  <th scope="col" class="px-6 py-3">
                    Status
                  </th>
                </tr>
              </thead>
              <?php

// $sql = "SELECT payroll_ss.*, emp.pic 
// FROM payroll_ss 
// LEFT JOIN emp ON payroll_ss.empname = emp.empname
// INNER JOIN payroll_schedule ON payroll_ss.salarymonth = payroll_schedule.smonth
// WHERE payroll_ss.status = 1 AND payroll_schedule.approval = 0
// ORDER BY payroll_ss.confirm1 DESC";
$sql = "
SELECT 
    ps.*, 
    emp.pic 
FROM (
    SELECT empname,status,salarymonth,confirm1, 'vsp' AS source FROM payroll_ss_vsp
    UNION ALL
    SELECT empname,status,salarymonth,confirm1, 'ggm' AS source FROM payroll_ss_ggm
    UNION ALL
    SELECT empname,status,salarymonth,confirm1, 'sp' AS source FROM payroll_ss_sp
) AS ps
LEFT JOIN emp ON ps.empname = emp.empname
INNER JOIN payroll_schedule ON ps.salarymonth = payroll_schedule.smonth
WHERE ps.status = 1 AND payroll_schedule.approval = 0
ORDER BY ps.confirm1 DESC
";


              $que = mysqli_query($con, $sql);

              if (mysqli_num_rows($que) > 0) {
                while ($result = mysqli_fetch_assoc($que)) {
              ?>
                  <tbody style="text-align: center;">
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                      <td class="px-6 py-4">
                        <img src="../pics/<?php echo $result['pic']; ?>" width="50px" style="border-radius: 50%;" alt="pic">
                      </td>
                      <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                      <td class="px-6 py-4">
                        <button style="margin-left:230px;" data-modal-target="default-modals" data-modal-toggle="default-modals" id="<?php echo $result['empname']; ?>" class="edit_data6 hidden-btn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  rounded-lg text-s px-2 py-2.5  dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                          View more
                        </button>
                      </td>
                      <td class="px-6 py-4">
                        HR Confirmed
                      </td>
                    </tr>

                  </tbody>
                <?php
                }
              } else {
                ?><br>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <td colspan="4" class="px-6 py-4 text-center">No data</td>
                </tr>
              <?php
              }
              ?>
            </table>
          </div>
        </form>
      </div>
    </div>
    <div id="default-modals" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-8/10 md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700" style="width: 113%;">
          <!-- Modal header -->
          <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
              Salary Details <br>
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
          <div class="p-4 md:p-5 space-y-2" id="info_update6">
            <?php @include("view_ss.php"); ?>
          </div>
          <!-- Modal footer -->
        </div>
      </div>
    </div>


    <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-10/12 md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700" style="width: 113%;">
          <div class="p-4 md:p-5 space-y-4">
            <p style="display:flex; justify-content:center; color: #666666;" id="empName"></p>
            <hr />
            <p style="display:flex; margin-left:20px; margin-top:0px;">Fixed Salary Components:</p>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Gross Salary:</label>
                <div style="display: flex; margin-left: 16px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="fgs" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">HRA:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="fhra" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">OA:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="foa" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="fbp" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <p style="display:flex; margin-left:20px;">Days Calculation:</p>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Total Days:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="ags" id="monthdays" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Present Days:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="ags" id="present" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Leaves:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="ags" id="leaves" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Week Off's:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="ags" id="sundays" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">LOP:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="ags" id="flop" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Pay Day's:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="ags" id="paydays" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <p style="display:flex; margin-left:20px;">Salary as per number of days:</p>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Gross Salary (CTC):</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="gross" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">HRA:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="empHRA" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">OA:</label>
                <div style="display: flex; margin-left:20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="oa" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="bp" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <p style="display:flex; margin-left:20px;">Deductions:</p>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">EPF:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="epf1" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">ESIC:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="esi1" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">TDS:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="tds" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Loan EMI:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="emi" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">LOP:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="lopamt" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>

              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Misc. Deductions:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="misc" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Total Deductions:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="totaldeduct" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <p style="display:flex; margin-left:20px;">Additional Compensation:</p>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Bonus:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="ags" id="bonus" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <hr />
            <div style="display: flex; justify-content:center;">
              <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Net Payout:</label>
              <div style="display: flex; margin-left:10px;">
                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                <input name="ags" id="payout" type="text" style="font-size: 18px; width: 110px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
              </div>
            </div>
          </div>
          <!-- Modal footer -->
          <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
            <button id="confirmBtn" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Confirm</button>
            <button data-modal-hide="default-modal" type="button" class="close py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
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
                window.location.href = 'summary.php';
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
      $("#transId").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
          type: "POST",
          url: "update_ss1.php",
          data: formData,
          dataType: "json",
          success: function(response) {
            if (response.success) {
              Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.message,
              }).then(function() {
                window.open('print-details_bank.php', '_blank');
                window.open('exportCSV_bank.php', '_blank');
                window.location.reload();
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.message,
              });
            }
          },
          error: function(xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred while processing your request. Please try again later.',
            });
          }
        });
      });
    });
  </script>


  <script>
    // Function to fetch data from the server and update the table
    function updateTable() {
      $.ajax({
        url: 'check-status.php',
        type: 'GET',
        success: function(response) {
          // If there's a need to reload the table
          if (response === 'reload') {
            // Reload only the table content
            $("#payrollTableContainer").load(location.href + " #payrollTable");
          }
        },
        error: function(xhr, status, error) {
          console.error("Error:", error);
        }
      });
    }

    setInterval(updateTable, 1000); // Adjust the interval as per your requirement
  </script>



  <script type="text/javascript">
    $(document).ready(function() {
      // View more button click event
      $(document).on('click', '.edit_data6', function() {
        var edit_id5 = $(this).attr('id');
        $.ajax({
          url: "view_ss.php",
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
  <script>
    var modal = document.getElementById('default-modal');
    var btn = document.getElementById("openModalBtn");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
      fetchData();
    }

    function showLoading() {
      Swal.fire({
        title: 'Loading...',
        allowOutsideClick: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        }
      });
    }

    function hideLoading() {
      Swal.close();
    }

    function fetchData() {
      showLoading(); // Show loading animation
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          hideLoading(); // Hide loading animation
          var data = JSON.parse(xhr.responseText);
          if (data) {
            console.log("Data fetched successfully:", data);
            document.getElementById("empName").innerText = data.empname;
            document.getElementById("empHRA").value = data.hra;
            document.getElementById("fgs").value = data.fgs;
            document.getElementById("fbp").value = data.fbp;
            document.getElementById("fhra").value = data.fhra;
            document.getElementById("foa").value = data.foa;
            document.getElementById("monthdays").value = data.monthdays;
            document.getElementById("present").value = data.present;
            document.getElementById("leaves").value = data.leaves;
            document.getElementById("sundays").value = data.sundays;
            document.getElementById("flop").value = data.flop;
            document.getElementById("paydays").value = data.paydays;
            document.getElementById("oa").value = data.oa;
            document.getElementById("bp").value = data.bp;
            document.getElementById("gross").value = data.gross;
            document.getElementById("epf1").value = data.epf1;
            document.getElementById("esi1").value = data.esi1;
            document.getElementById("tds").value = data.tds;
            document.getElementById("emi").value = data.emi;
            document.getElementById("lopamt").value = data.lopamt;
            document.getElementById("misc").value = data.misc;
            document.getElementById("totaldeduct").value = data.totaldeduct;
            document.getElementById("bonus").value = data.bonus;
            document.getElementById("payout").value = data.payout;
            modal.setAttribute("data-id", data.id);
          } else {
            console.log("No data fetched");
            showNoDataAvailable(); // Show "No Data Available" message
          }
        }
      };
      xhr.open("GET", "fetch_new_data.php", true);
      xhr.send();
    }

    function showNoDataAvailable() {
      Swal.fire({
        icon: 'error',
        title: 'No Data Available',
        text: 'There is no data further available to confirm !',
        showConfirmButton: false,
        timer: 2000
      }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
          modal.style.display = "none";
          location.reload(); // Reload the page
        }
      });
    }

    // Prevent the modal from closing automatically on Confirm
    document.getElementById("confirmBtn").onclick = function() {
      // Get the id from the modal content
      var id = modal.getAttribute("data-id");

      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          var data = JSON.parse(xhr.responseText);
          if (data) {
            console.log("Confirm button clicked for ID: " + id);
            console.log("Response:", xhr.responseText);
            showLoading(); // Show loading animation
            setTimeout(function() {
              hideLoading(); // Hide loading animation after a delay
              showSuccessMessage(); // Show "Success" message
            }, 1000); // Adjust the delay as needed
          } else {
            modal.style.display = "none";
          }
        }
      };
      xhr.open("POST", "fetch_new_data.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("id=" + id + "&confirm=1");
    }

    function showSuccessMessage() {
      Swal.fire({
        icon: 'success',
        title: 'Confirmed!',
        text: 'Data has been confirmed successfully.',
        showConfirmButton: false,
        timer: 1000
      }).then((result) => {
        if (result.dismiss === Swal.DismissReason.timer) {
          // Load the next data
          fetchData();
        }
      });
    }

    span.onclick = function() {
      modal.style.display = "none";
    }
  </script>




  <script>
    function submitFormData() {
      var formData = new FormData();
      // Iterate through each table row
      $("#payrollTable tbody tr").each(function() {
        // Get the input elements within the current row
        var inputs = $(this).find('input[name^="confirm"]:checked');
        // Check if at least one checkbox is checked in the row
        if (inputs.length > 0) {
          // Get the data attributes from the row
          var empName = $(this).find('td:eq(1)').text().trim();
          var grossSalary = $(this).find('td:eq(2)').text().trim();
          var loanDeductables = $(this).find('td:eq(3)').text().trim();
          var lop = $(this).find('td:eq(4)').text().trim();
          var epf = $(this).find('td:eq(5)').text().trim();
          var esi = $(this).find('td:eq(6)').text().trim();
          var netSalary = $(this).find('td:eq(7)').text().trim();
          // Append the data to the formData object
          formData.append('confirm[]', empName);
          formData.append('gross_salary[' + empName + ']', grossSalary);
          formData.append('loan_deductables[' + empName + ']', loanDeductables);
          formData.append('lop[' + empName + ']', lop);
          formData.append('epf[' + empName + ']', epf);
          formData.append('esi[' + empName + ']', esi);
          formData.append('net_salary[' + empName + ']', netSalary);
        }
      });

      // Check if at least one checkbox is checked
      if ($('input[name="confirm[]"]:checked').length > 0) {
        Swal.fire({
          title: 'Are you sure?',
          text: 'Do you want to confirm payroll statements?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Yes, confirm',
          cancelButtonText: 'No, cancel',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: 'POST',
              url: 'insert_statement.php',
              data: formData,
              processData: false,
              contentType: false,
              success: function(response) {
                console.log('Success:', response);
                Swal.fire({
                  icon: 'success',
                  title: 'Success!',
                  text: response,
                  confirmButtonText: 'OK'
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href = 'salarystatement.php';
                    $('#payrollForm')[0].reset();
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
              text: 'The submission of payroll statements was cancelled',
              icon: 'info',
              confirmButtonText: 'OK'
            });
          }
        });
      } else {
        Swal.fire({
          title: 'Error!',
          text: 'Please select at least one employee to confirm payroll statements.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
    }
  </script>

</body>

</html>