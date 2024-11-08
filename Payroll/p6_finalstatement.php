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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .udbtn:hover {
      color: black !important;
      background-color: white !important;
      outline: 1px solid #F46114;
    }

    input {
      border: none;
      text-align: center;
      width: 150px;
    }

    .rectangle-parent23 {
      position: absolute;
      width: 107%;
      top: calc(50% - 360px);
      /*right: 1.21%;*/
      left: -70px;
      height: 850px;
      font-size: var(--font-size-xl);
    }

    ol {
      display: flex;
      justify-content: center;
    }

    .highlight {
      pointer-events: none;
    }

    .addim {
      border: 1px solid #008DDA;
      border-radius: 5px;
    }

    .highlight-row {
            background-color: #e0f7fa; 
            font-weight:bolder;
            outline: 2px solid #008DDD;
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
      <li class="flex items-center text-blue-600 dark:text-blue-500">
        <span class="flex items-center justify-center w-5 h-5 me-2 text-xs border border-blue-700 rounded-full shrink-0 dark:border-gray-400">
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
      <div id="marketing-banner" style="position:absolute; top:5px; margin-left:-270px;" tabindex="-1" class="flex justify-between w-[calc(110%-2rem)] p-4 -translate-x-1/2 bg-white border border-gray-100 rounded-lg shadow-sm lg:max-w-7xl left-1/2 dark:bg-gray-700 dark:border-gray-600">
        <div class="flex flex-col items-start mb-3 me-4 md:items-center md:flex-row md:mb-0">
          <a href="#" class="flex items-center mb-2 border-gray-200 md:pe-4 md:me-4 md:border-e md:mb-0 dark:border-gray-600">
            <svg class="w-6 h-6 text-blue-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd" />
            </svg>

          </a>
          <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">HR should review the entire salary structure generated by the system in this step. This involves verifying the accuracy of all components, ensuring compliance with company policies and legal requirements, and making any necessary adjustments or corrections.
          </p>
        </div>
      </div>
      <a href="p5_bonus.php" style="position:absolute; right:320px; top:35px"><button type="button" class="text-white bg-[#FF9119] hover:bg-[#FF9119]/80 focus:ring-4 focus:outline-none focus:ring-[#FF9119]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:hover:bg-[#FF9119]/80 dark:focus:ring-[#FF9119]/40 me-2 mb-2">
          <svg style="margin-right:10px;" class="w-6 h-6 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4" />
          </svg>

          Previous
        </button></a>
      <?php
      $sql = "SELECT smonth FROM payroll_schedule WHERE approval = 0 LIMIT 1";

      $result = $con->query($sql);

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $smonth = $row["smonth"];
      } else {
        $smonth = "No month found with status = 0";
      }
      ?>
      <form id="employeeForm">
        <input type="hidden" name="status" value=6>
        <input type="hidden" name="smonth" value="<?php echo $smonth; ?>">
        <a style="position:absolute; right:100px; top:35px">
          <button onclick="submitFormData()" type="button" class="text-white bg-[#FF9119] hover:bg-[#FF9119]/80 focus:ring-4 focus:outline-none focus:ring-[#FF9119]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:hover:bg-[#FF9119]/80 dark:focus:ring-[#FF9119]/40 me-3 mb-2">
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
      <div style="position:absolute; height:800px; overflow-y:auto; margin-top:50px; width:100%; scale:0.9; ">
        <form>
          <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400" id="ssTableBody">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr style="border-top: 1px solid rgb(224, 224, 224);">

                <th colspan=2 scope="col" class="px-6 py-3" style="position: sticky; top: 0;left: 0;z-index:100;background-color: #fdfdfd;">
                  <label class="inline-flex items-center me-5 cursor-pointer" style="position: sticky; left:25px;">
                    <input type="checkbox" id="toggleCheckbox" class="sr-only peer">
                    <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-orange-300 dark:peer-focus:ring-orange-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-orange-500"></div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Edit Mode</span>
                  </label>
                  <th colspan=23 style="text-align: center;" scope="col" class="px-6 py-3">
            SALARY STATEMENT - <?php echo $smonth; ?>
            </th>
                </th>
              </tr>
              <tr style="border-top: 1px solid rgb(224, 224, 224);position: sticky; top: 0; ">
          <th colspan="1" style="text-align: center;position: sticky; left: 0; background-color: #fdfdfd;" scope="col" class="px-6 py-3">
                Employee Details
              </th>
            <th colspan="4" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 238, 255, 0.5);" scope="col" class="px-6 py-3">
              FIXED SALARY COMPONENTS
            </th>
            <th colspan="8" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 231, 194, 0.5);" scope="col" class="px-6 py-3">
              Days Calculation
            </th>
            <th colspan="4" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 255, 204, 0.5);" scope="col" class="px-6 py-3">
              SALARY AS PER NO OF DAYS
            </th>
            <th colspan="7" scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 161, 161, 0.5);" class="px-6 py-3">
              Deductions
            </th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160);background-color: rgba(194, 255, 204, 0.5);" class="px-6 py-3">
              Additional Compensation
              </th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160);position: sticky; right: 0; top:0; background-color: #fdfdfd;" class="px-6 py-3">
                NET Payable
              </th>
          </tr>
          <tr style="border-top: 1px solid rgb(224, 224, 224);position: sticky; top: 50px; ">
          <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224);position: sticky; left: 0; background-color: #fdfdfd;" class="px-6 py-3">Emp Name</th>
            <th scope="col" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 238, 255, 0.2);" class="px-6 py-3">Basic Pay</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);" class="px-6 py-3">HRA</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);" class="px-6 py-3">OA</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);" class="px-6 py-3">Gross Salary</th>
            <th scope="col" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 231, 194, 0.2);" class="px-6 py-3">Total Days</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-6 py-3">Present Days</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-6 py-3">Leaves</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-6 py-3">Week Off Days</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-6 py-3">holidays</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-6 py-3">LOP</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-6 py-3">PAYOUT as per  days</th>
            <th scope="col" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);" class="px-6 py-3">Pay Days</th>

            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 255, 204, 0.2);" class="px-6 py-3">Basic salary</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);" class="px-6 py-3">HRA</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);" class="px-6 py-3">OA</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);" class="px-6 py-3">Gross Salary</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 194, 194, 0.2);" class="px-6 py-3">EPF</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);" class="px-6 py-3">ESIC</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);" class="px-6 py-3">TDS Deduction</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);" class="px-6 py-3">Loan EMI</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);" class="px-6 py-3">LOP Amount</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);" class="px-6 py-3">Misc. Deductions</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);" class="px-6 py-3">Total Deduction</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160);  background-color: rgba(194, 255, 204, 0.2);" class="px-6 py-3">Bonus</th>
            <th scope="col" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); position: sticky; right: 0; top: 50px; background-color: #fdfdfd;" class="px-6 py-3">Salary Payout</th>
          </tr>
            </thead>
            <tbody>
            <?php
$sql = "SELECT smonth FROM payroll_schedule WHERE approval = 0 LIMIT 1";
$result = $con->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    // Get the smonth value directly from the database
    $smonth = $row['smonth'];
    
    // Get the first day of the month
    $firstDayOfMonth = date("Y-m-01", strtotime($smonth));
    // Get the last day of the month
    $lastDayOfMonth = date('Y-m-t', strtotime($smonth)) . ' 23:59:59';
    // Get the total number of days in the month
    $totalDaysInMonth = date("t", strtotime($smonth));
} else {
    // If no smonth is found, set default values
    $smonth = "No month found";
    $firstDayOfMonth = '';
    $lastDayOfMonth = '';
    $totalDaysInMonth = 0;
}

              $fetchingHolidays = mysqli_query($con, "
              SELECT COUNT(DISTINCT date) AS count
              FROM holiday
              WHERE date >= '$firstDayOfMonth'
              AND date <= '$lastDayOfMonth'
          ") or die(mysqli_error($con));

          $holidaysCount = mysqli_fetch_assoc($fetchingHolidays)['count'];

              $sundaysCount = 0;
              for ($j = 1; $j <= $totalDaysInMonth; $j++) {
                $dateOfAttendance = date("Y-m-$j");
                $dayOfWeek = date('N', strtotime($dateOfAttendance));
                if ($dayOfWeek == 7) {
                  $sundaysCount++;
                }
              }
              ?>

              <?php
     $sql = "SELECT 
     ms.empname, 
     ms.emp_no,
     ms.desg,
     ms.dept,
     ms.bp, 
     ms.hra, 
     ms.oa, 
     ms.epf1, 
     ms.esi1,
     ms.ctc,
     ms.tds,
     ms.netpay,
     emi.empname AS emi_empname,
     emi.emi,
     lop.empname AS lop_empname,
     lop.flop,
     bonus.empname AS bonus_empname,
     bonus.amt,
     misc.empname AS misc_empname,
     misc.damt
 FROM payroll_msalarystruc ms
 LEFT JOIN payroll_emi emi ON ms.empname = emi.empname AND emi.emimonth = '$smonth'
 LEFT JOIN payroll_lop lop ON ms.empname = lop.empname AND lop.lopmonth = '$smonth'
 LEFT JOIN payroll_bonusamt bonus ON ms.empname = bonus.empname AND bonus.paymonth = '$smonth'
 LEFT JOIN payroll_misc misc ON ms.empname = misc.empname AND misc.paymonth = '$smonth'
 LEFT JOIN payroll_schedule ON payroll_schedule.smonth = '$smonth'
 WHERE payroll_schedule.approval = 0
ORDER BY emp_no ASC";

 
 
 
               $result = mysqli_query($con, $sql);
 
               if (mysqli_num_rows($result) > 0) {
                 while ($row = mysqli_fetch_assoc($result)) {
                   $fetchingEmployees = mysqli_query($con, "SELECT UserID FROM emp WHERE empname = '" . $row['empname'] . "'") or die(mysqli_error($con));
                   $employeeData = mysqli_fetch_assoc($fetchingEmployees);
                   $employeeID = 0;
                   if ($employeeData) {
                     $employeeID = $employeeData['UserID'];
 
                     $leavesData1 = mysqli_query($con, "
                 SELECT `from`, `to`
                 FROM leaves
                 WHERE empname = '" . $row['empname'] . "'
                 AND ((status = 1 AND status1 = 1) OR (status = 1 AND status1 = 0)) 
                 AND leavetype = 'HALF DAY'
                 AND (
                     (`from` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                     OR (`to` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                     OR (`from` <= '$firstDayOfMonth' AND `to` >= '$lastDayOfMonth')
                 )
             ") or die(mysqli_error($con));
 
                     $leaveCount1 = 0;
                     while ($leaveEntry = mysqli_fetch_assoc($leavesData1)) {
                       $from = strtotime($leaveEntry['from']);
                       $to = strtotime($leaveEntry['to']);
 
                       for ($k = 0; $k <= $to - $from; $k += 24 * 60 * 60) {
                         $currentDay = date('N', $from + $k);
                         if ($currentDay != 7 && $from + $k >= strtotime($firstDayOfMonth) && $from + $k <= strtotime($lastDayOfMonth)) {
                           $leaveCount1 += 0.5;
                         }
                       }
                     }
                     $ciCoColumn1 = mysqli_query($con, "
                     SELECT COUNT(*) AS count
                     FROM CamsBiometricAttendance
                     WHERE UserID = '$employeeID'
                     AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                     AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                     AND AttendanceType = 'CheckIn'
                 ") or die(mysqli_error($con));

                 
                     $ciCoColumn = mysqli_query($con, "
               SELECT COUNT(DISTINCT DATE(AttendanceTime)) AS count
               FROM CamsBiometricAttendance
                WHERE UserID = '$employeeID'
               AND DATE(AttendanceTime) >= '$firstDayOfMonth'
               AND DATE(AttendanceTime) <= '$lastDayOfMonth'
               AND DAYOFWEEK(AttendanceTime) != 1  -- Exclude entries on Sunday
               AND DATE(AttendanceTime) NOT IN (
                   SELECT date
                   FROM holiday
               )
               AND (
                   (AttendanceType = 'CheckIn' AND DATE(AttendanceTime) IN (
                       SELECT DATE(AttendanceTime)
                       FROM CamsBiometricAttendance
                        WHERE UserID = '$employeeID'
                       AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                       AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                       AND AttendanceType = 'CheckOut'
                       AND DAYOFWEEK(AttendanceTime) != 1  -- Exclude entries on Sunday
                   ))
                   OR (AttendanceType = 'CheckOut' AND DATE(AttendanceTime) IN (
                       SELECT DATE(AttendanceTime)
                       FROM CamsBiometricAttendance
                        WHERE UserID = '$employeeID'
                       AND DATE(AttendanceTime) >= '$firstDayOfMonth'
                       AND DATE(AttendanceTime) <= '$lastDayOfMonth'
                       AND AttendanceType = 'CheckIn'
                       AND DAYOFWEEK(AttendanceTime) != 1  -- Exclude entries on Sunday
                   ))
               )
           ") or die(mysqli_error($con));
 
                     $leavesCountCL = mysqli_query($con, "
           SELECT icl
           FROM leavebalance 
           WHERE empname = '" . $row['empname'] . "'
       ") or die(mysqli_error($con));
                     $leavesCountSL = mysqli_query($con, "
       SELECT isl
       FROM leavebalance 
       WHERE empname = '" . $row['empname'] . "'
   ") or die(mysqli_error($con));
                     $leavesCountCO = mysqli_query($con, "
   SELECT ico
   FROM leavebalance 
   WHERE empname = '" . $row['empname'] . "'
 ") or die(mysqli_error($con));
 
                     $leavesCountCCL = mysqli_query($con, "
 SELECT cl
 FROM leavebalance 
 WHERE empname = '" . $row['empname'] . "'
 ") or die(mysqli_error($con));
                     $leavesCountCSL = mysqli_query($con, "
 SELECT sl
 FROM leavebalance 
 WHERE empname = '" . $row['empname'] . "'
 ") or die(mysqli_error($con));
                     $leavesCountCCO = mysqli_query($con, "
 SELECT co
 FROM leavebalance 
 WHERE empname = '" . $row['empname'] . "'
 ") or die(mysqli_error($con));
 
                     $CLresult = mysqli_fetch_assoc($leavesCountCL);
                     $iclValue = isset($CLresult['icl']) ? $CLresult['icl'] : '0';
                     $SLresult = mysqli_fetch_assoc($leavesCountSL);
                     $islValue = isset($SLresult['isl']) ? $SLresult['isl'] : '0';
                     $COresult = mysqli_fetch_assoc($leavesCountCO);
                     $icoValue = isset($COresult['ico']) ? $COresult['ico'] : '0';
 
                     $CCLresult = mysqli_fetch_assoc($leavesCountCCL);
                     $cclValue = isset($CCLresult['cl']) ? $CCLresult['cl'] : '0';
                     $CSLresult = mysqli_fetch_assoc($leavesCountCSL);
                     $cslValue = isset($CSLresult['sl']) ? $CSLresult['sl'] : '0';
                     $CCOresult = mysqli_fetch_assoc($leavesCountCCO);
                     $ccoValue = isset($CCOresult['co']) ? $CCOresult['co'] : '0';
                     $leavesData = mysqli_query($con, "
                     SELECT `from`, `to`
                     FROM leaves 
                     WHERE empname = '" . $row['empname'] . "'
                           AND ((status = 1 AND status1 = 1) OR (status = 1 AND status1 = 0)) 
                     AND leavetype != 'HALF DAY'
                     AND leavetype != 'OFFICIAL LEAVE'
                     AND (
                         (`from` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                         OR (`to` BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth')
                         OR (`from` <= '$firstDayOfMonth' AND `to` >= '$lastDayOfMonth')
                     )
                 ") or die(mysqli_error($con));
                     $fetchingHolidaysa = mysqli_query($con, "
                     SELECT date
                     FROM holiday
                     WHERE date >= '$firstDayOfMonth'
                     AND date <= '$lastDayOfMonth'
                 ") or die(mysqli_error($con));
                 
                 $holidays = [];
                 while ($holiday = mysqli_fetch_assoc($fetchingHolidaysa)) {
                     $holidays[] = $holiday['date'];
                 }   
                 
                 $leaveCount = 0;
                 while ($leaveEntry = mysqli_fetch_assoc($leavesData)) {
                     $from = strtotime($leaveEntry['from']);
                     $to = strtotime($leaveEntry['to']);
                 
                     // Calculate leave duration in days, excluding Sundays and holidays
                     for ($k = 0; $k <= $to - $from; $k += 24 * 60 * 60) {
                         $currentDay = date('N', $from + $k);
                         $currentDate = date('Y-m-d', $from + $k);
                         if ($currentDay != 7 && $from + $k >= strtotime($firstDayOfMonth) && $from + $k <= strtotime($lastDayOfMonth) && !in_array($currentDate, $holidays)) {
                             $leaveCount++;
                         }
                     }
                 }
                 $ciCoCount11 = mysqli_fetch_assoc($ciCoColumn1)['count'];
                     $ciCoCount = mysqli_fetch_assoc($ciCoColumn)['count'];
                     $ciCoCount = $ciCoCount - $leaveCount1;
                     $ciCoCount1 = $ciCoCount;
                     $weekoff = $sundaysCount +  $holidaysCount;
                     $totalleavesCount1 =($leaveCount + $leaveCount1); 
                   $tds = $row['tds'];
                   $desg = $row['desg'];
                                       $flop = $row['flop'];
                                       // $epf1= $row['epf1'];
                                       $gs = $row['bp'] + $row['hra'] + $row['oa'];
                                       $lopamt = ($gs / $totalDaysInMonth) * $row['flop'];
                                       $paydays = $totalDaysInMonth - $flop;

                            
                                       // as per no of days
                                       $basic = $row['bp'] * $paydays / $totalDaysInMonth;
                                       $hra = $row['hra'] * $paydays / $totalDaysInMonth;
                                       $oa = $row['oa'] * $paydays / $totalDaysInMonth;
                                       $gross = $basic + $hra + $oa;
                   
                                       $totaldeduct = $row['epf1'] + $row['esi1'] + $row['emi'] + $lopamt + $tds;
                                       $bonus = $row['amt'];
                                       $payout = floor($gross - $totaldeduct + $bonus);
                                       if (($payout - floor($payout)) > 0.5) {
                                         $payout = ceil($payout);
                                       }

                                       $netpay = $row['netpay'];
                                       $ciCoCount1 = $ciCoCount1 ?? 0; 
                     
                                       if ($ciCoCount1 == 0) {
                                         $perday = 0;
                                     } else {
                                         $perday = number_format((($netpay / $totalDaysInMonth) * ($ciCoCount1 + $weekoff + ($totalleavesCount1 - $flop))), 2, '.', '');
                                     }


                                     if ($desg != 'SECURITY GAURDS') {
                                      $displayValue = $ciCoCount1;
                                  } else {
                                      $displayValue = $ciCoCount11;
                                  }
                                  
                                     } else {
                                          $tds = $row['tds'];
                                       $gs = $row['bp'] + $row['hra'] + $row['oa'];
                                       $lopamt = ($gs / $totalDaysInMonth) * $row['flop'];
                                       $paydays = $totalDaysInMonth - $row['flop'];
                   
                                       // as per no of days
                                       $basic = $row['bp'] * $paydays / $totalDaysInMonth;
                                       $hra = $row['hra'] * $paydays / $totalDaysInMonth;
                                       $oa = $row['oa'] * $paydays / $totalDaysInMonth;
                                       $gross = $basic + $hra + $oa;
                   
                                       $totaldeduct = $row['epf1'] + $row['esi1'] + $row['emi'] + $lopamt + $tds;
                                       $bonus = $row['amt'];
                                       $payout = floor($gross - $totaldeduct + $bonus);
                                       if (($payout - floor($payout)) > 0.5) {
                                         $payout = ceil($payout);
                                       }

                                       $netpay = $row['netpay'];
                                       $ciCoCount1 = $ciCoCount1 ?? 0; 
                     
                                       if ($ciCoCount1 == 0) {
                                         $perday = 0;
                                     } else {
                                         $perday = number_format((($netpay / $totalDaysInMonth) * ($ciCoCount1 + $weekoff + ($totalleavesCount1 - $flop))), 2, '.', '');
                                     }
                                       $employeeID = 0;
                                       $ciCoCount1 = 0;
                                       $totalleavesCount1 = 0;
                                       $lopamt = 0;
                                       $flop = 0;
                                       $bonus = 0;
                                         $weekoff = 0;
                                        $displayValue = 0;
                                     }

              ?>

                  <tr style="border-top: 1px solid rgb(224, 224, 224);" class="clickable-row bg-white border-b dark:bg-gray-800 dark:border-gray-700 ">
                    <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224);position: sticky; left: 0; background-color: #fdfdfd;">
                      <?php echo $row['empname']; ?>
                    </td>
                    <td class="px-6 py-4 hidden" style=" text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 238, 255, 0.2);">
           <?php echo $smonth ?>
          </td>
                    <td class="px-6 py-4" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 238, 255, 0.2);">
                      <input type="number" name="fbp" value="<?php echo $row['bp']; ?>" style="background-color: rgba(194, 238, 255, 0.01);" >
                    </td>
                    <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);">
                      <input type="number" name="fhra" value="<?php echo $row['hra']; ?>" style="background-color: rgba(194, 238, 255, 0.01);" >
                    </td>
                    <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);">
                      <input type="number" name="foa" value="<?php echo $row['oa']; ?>" style="background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(194, 238, 255, 0.2);">
                      <input type="number" name="fgs" value="<?php echo $gs; ?>" style="background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-6 py-4" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 231, 194, 0.2);">
                      <input type="number" name="monthdays" id="monthdays" value="<?php echo $totalDaysInMonth ?>" class="highlight" style="background-color: rgba(194, 238, 255, 0.01); width: 60px;">
                    </td>
                    <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
                      <input type="number" name="present"  value="<?php echo $displayValue; ?>" style="background-color: rgba(194, 238, 255, 0.01); width: 80px;" class="highlight">
                    </td>
                    <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
                      <input type="number" name="leaves" value="<?php echo $totalleavesCount1; ?>" style="background-color: rgba(194, 238, 255, 0.01); width: 80px;" class="highlight">
                    </td>
                    <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
                      <input type="number" name="sundays" value="<?php echo $sundaysCount ?>" style="background-color: rgba(194, 238, 255, 0.01); width: 60px;" class="highlight">
                    </td>
                    <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
                      <input type="number" name="holidays" value="<?php echo $holidaysCount ?>" style="background-color: rgba(194, 238, 255, 0.01); width: 60px;" class="highlight">
                    </td>
                    <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
                      <input type="number" name="flop" id="flop" value="<?php echo isset($row['flop']) ? $row['flop'] : 0; ?>" class="highlight" style="background-color: rgba(194, 238, 255, 0.01); width: 60px;">
                    </td>

                    <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
                  <input type="number" value="<?php echo $perday; ?>" style="width:110px;background-color: rgba(194, 238, 255, 0.01);">
                  </td>

                    <td class="px-6 py-4" style="text-align: center; border-left: 1px solid rgb(224, 224, 224); background-color: rgba(255, 231, 194, 0.2);">
                      <input type="number" name="paydays" id="paydays" value="" style="background-color: rgba(194, 238, 255, 0.01); width: 90px;" class="highlight">
                    </td>
                  
                    <td class="px-6 py-4" style="text-align: center; border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(194, 255, 204, 0.2);">
                      <input type="number" name="bp" id="bp" value="<?php echo $basic; ?>" style="background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);">
                      <input type="number" name="hra" id="hra" value="<?php echo $hra ?>" style="background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);">
                      <input type="number" name="oa" value="<?php echo $oa ?>" style="background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(194, 255, 204, 0.2);">
                      <input type="number" name="gross" value="<?php echo $gross ?>" style="background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); background-color: rgba(255, 194, 194, 0.2);">
                      <input type="number" name="epf1" value="<?php echo $row['epf1']; ?>" style="background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);">
                      <input type="number" name="esi1" value="<?php echo $row['esi1']; ?>" style="background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);">
                      <input type="number" name="tds" value="<?php echo $tds; ?>"  style="background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);">
                      <input type="number" name="emi" value="<?php echo isset($row['emi']) ? $row['emi'] : 0; ?>" class="highlight" style="background-color: rgba(194, 238, 255, 0.01);">
                    </td>
                    <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);">
                      <input type="number" name="lopamt" value="<?php echo $lopamt; ?>" style="background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);">
                      <input type="number" name="misc" value="<?php echo isset($row['damt']) ? $row['damt'] : 0; ?>" class="highlight" style="background-color: rgba(194, 238, 255, 0.01);">
                    </td>
                    <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(224, 224, 224); background-color: rgba(255, 194, 194, 0.2);">
                      <input type="number" name="totaldeduct" value="<?php echo $totaldeduct; ?>" style="background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160);   background-color: rgba(194, 255, 204, 0.2);">
                      <input type="number" name="bonus" value="<?php echo isset($row['amt']) ? $row['amt'] : 0; ?>" class="highlight" style="background-color: rgba(194, 238, 255, 0.01);">
                    </td>
                    <td class="px-6 py-4" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); position: sticky; right: 0; background-color: #fdfdfd;">
                      <input type="number" name="payout" value="<?php echo $payout; ?>" style="background-color: rgba(194, 238, 255, 0.01);" class="highlight">
                    </td>
                    <td class="px-6 py-4 hidden" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); position: sticky; right: 0; background-color: #fdfdfd;">
                    <input type="hidden" name="emp_no" value=" <?php echo $row['emp_no']; ?> " style="background-color: rgba(194, 238, 255, 0.01);">
                  </td>
                  <td class="px-6 py-4 hidden" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); position: sticky; right: 0; background-color: #fdfdfd;">
                    <input type="hidden" name="desg" value=" <?php echo $row['desg']; ?> " style="background-color: rgba(194, 238, 255, 0.01);">
                  </td>
                  <td class="px-6 py-4 hidden" style="text-align: center;  border-left: 1.5px solid rgb(160, 160, 160); position: sticky; right: 0; background-color: #fdfdfd;">
                    <input type="hidden" name="dept" value=" <?php echo $row['dept']; ?> " style="background-color: rgba(194, 238, 255, 0.01);">
                  </td>
                  </tr>
                <?php
                }
              } else {
                ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <td colspan="8" class="px-6 py-4 text-center">No Data</td>
                </tr>
              <?php
              }

              ?>
            </tbody>
          </table>
          <!-- <button style="position:sticky; left:0; margin-top:10px;" type="button" onclick="submitFormData()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          Submit
        </button> -->
        </form>
      </div>
    </div>
    <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

    <img width="90px" style="position: absolute; left:20px;" src="./public/logo-1@2x.png" />
    <a class="anikahrm14" href="./index.html" style="top:20px; left:120px;" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./index.html" style="margin-left:500px;" id="attendenceManagement">Payroll Management</a>
  </div>
</body>
<script>
        document.querySelectorAll('.clickable-row').forEach(function(row) {
            row.addEventListener('click', function() {
                document.querySelectorAll('.clickable-row').forEach(function(r) {
                    r.classList.remove('highlight-row');
                });
                row.classList.add('highlight-row');
            });
        });
    </script>

<script>
  document.getElementById('toggleCheckbox').addEventListener('change', function() {
    var inputs = document.querySelectorAll('input[type="number"]');
    for (var i = 0; i < inputs.length; i++) {
      if (this.checked) {
        inputs[i].classList.remove('highlight');
        inputs[i].classList.add('addim');
      } else {
        inputs[i].classList.add('highlight');
        inputs[i].classList.remove('addim');
      }
    }
  });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function filterData() {
    var selectedMonthYear = document.getElementById("monthYearSelect").value;
    if (selectedMonthYear !== "") {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("ssTableBody").innerHTML = this.responseText;
          
          // Call functions to update data after loading
          updateData();
        }
      };
      xhttp.open("GET", "fetch_ss.php?monthYear=" + selectedMonthYear, true);
      xhttp.send();
    }
  }

  document.addEventListener("DOMContentLoaded", function() {
    // Call filterData when the document is loaded
    filterData();
  });

  function updateData() {
    // Call functions to update data
    updatePaydays();
    updateBpAndEpf1AndEsi1();
    updateHra();
    updateOa();
    updateTotalDeduct();
    updateGrossDeductAndPayout();
    
  }
</script>
<script>
$(document).ready(function() {
    // Function to calculate and update paydays
    function updatePaydays() {
        $('tbody tr').each(function() {
            var monthdays = parseFloat($(this).find('input[name="monthdays"]').val()) || 0;
            var flop = parseFloat($(this).find('input[name="flop"]').val()) || 0;
            var paydays = monthdays - flop;
            $(this).find('input[name="paydays"]').val(paydays);
        });
    }
    
    // Function to calculate and update bp, epf1, esi1
 function updateBpAndEpf1AndEsi1() {
    $('tbody tr').each(function() {
        var monthdays = parseFloat($(this).find('input[name="monthdays"]').val()) || 0;
        var flop = parseFloat($(this).find('input[name="flop"]').val()) || 0;
        var paydays = parseFloat($(this).find('input[name="paydays"]').val()) || 0;
        var bp = parseFloat($(this).find('input[name="fbp"]').val()) || 0;
        var gross = parseFloat($(this).find('input[name="gross"]').val()) || 0;
        var tds = parseFloat($(this).find('input[name="tds"]').val()) || 0;
        var epf1FromDB = parseFloat($(this).find('input[name="epf1"]').val()) || 0;
        var esi1FromDB = parseFloat($(this).find('input[name="esi1"]').val()) || 0;
        
        // Check if epf1 and esi1 from DB are 0, if yes, keep them as 0
        if (epf1FromDB === 0 && esi1FromDB === 0) {
            $(this).find('input[name="epf1"]').val(0);
            $(this).find('input[name="esi1"]').val(0);
            // Exit the loop for this row if both values are 0
            return;
        }
        
        // If epf1 and esi1 from DB are not 0, check tds value
        if (tds === 0) {
            var newBp = (bp * paydays) / monthdays;
            $(this).find('input[name="bp"]').val(newBp.toFixed(2));
            var epf1 = Math.round(newBp * 0.12);
            // Set epf1 to 1800 if bp is more than 15,000
            if (bp > 15000) {
                epf1 = 1800;
            }
            $(this).find('input[name="epf1"]').val(epf1);
            // Check if esi1 from DB is 0, if yes, set esi1 to 0, else calculate esi1
            var esi1 = esi1FromDB === 0 ? 0 : (gross < 21000 ? Math.round(gross * 0.0075) : 0);
            $(this).find('input[name="esi1"]').val(esi1);
        }
    });
}




    // Function to calculate and update hra
    function updateHra() {
        $('tbody tr').each(function() {
            var monthdays = parseFloat($(this).find('input[name="monthdays"]').val()) || 0;
            var flop = parseFloat($(this).find('input[name="flop"]').val()) || 0;
            var paydays = parseFloat($(this).find('input[name="paydays"]').val()) || 0;
            var hra = parseFloat($(this).find('input[name="fhra"]').val()) || 0;
            var newHra = (hra * paydays) / monthdays;
            $(this).find('input[name="hra"]').val(newHra.toFixed(2));
        });
    }

    // Function to calculate and update oa
    function updateOa() {
        $('tbody tr').each(function() {
            var monthdays = parseFloat($(this).find('input[name="monthdays"]').val()) || 0;
            var flop = parseFloat($(this).find('input[name="flop"]').val()) || 0;
            var paydays = parseFloat($(this).find('input[name="paydays"]').val()) || 0;
            var oa = parseFloat($(this).find('input[name="foa"]').val()) || 0;
            var newOa = (oa * paydays) / monthdays;
            $(this).find('input[name="oa"]').val(newOa.toFixed(2));
        });
    }

    // Function to calculate and update totaldeduct, and lopamt
    function updateTotalDeduct() {
        $('tbody tr').each(function() {
            var tds = parseFloat($(this).find('input[name="tds"]').val()) || 0; 
            var epf1 = parseFloat($(this).find('input[name="epf1"]').val()) || 0;
            var esi1 = parseFloat($(this).find('input[name="esi1"]').val()) || 0;
            var emi = parseFloat($(this).find('input[name="emi"]').val()) || 0;
            var gs = parseFloat($(this).find('input[name="fgs"]').val()) || 0;
            var monthdays = parseFloat($(this).find('input[name="monthdays"]').val()) || 0;
            var flop = parseFloat($(this).find('input[name="flop"]').val()) || 0;
            var misc = parseFloat($(this).find('input[name="misc"]').val()) || 0;
              var lopamt = parseFloat($(this).find('input[name="lopamt"]').val()) || 0; // Calculate lopamt only if not manually entered
          var  lopamt =  ((gs / monthdays) * flop);
            // Update lopamt field
            $(this).find('input[name="lopamt"]').val(lopamt.toFixed(2));
            
            var totaldeduct = epf1 + tds + esi1 + emi + lopamt + misc;
            $(this).find('input[name="totaldeduct"]').val(totaldeduct.toFixed(2));
        });
    }

    // Function to calculate and update gross, totaldeduct, and payout
    function updateGrossDeductAndPayout() {
        $('tbody tr').each(function() {
            var monthdays = parseFloat($(this).find('input[name="monthdays"]').val()) || 0;
            var gs = parseFloat($(this).find('input[name="fgs"]').val()) || 0;
            var flop = parseFloat($(this).find('input[name="flop"]').val()) || 0;
     
            var epf1 = parseFloat($(this).find('input[name="epf1"]').val()) || 0;
            var esi1 = parseFloat($(this).find('input[name="esi1"]').val()) || 0;
            var emi = parseFloat($(this).find('input[name="emi"]').val()) || 0;
            var gross = gs;

            // Call updateTotalDeduct to get the latest totaldeduct value
            updateTotalDeduct();

            // Retrieve the latest totaldeduct value
            var totaldeduct = parseFloat($(this).find('input[name="totaldeduct"]').val()) || 0;

            // Calculate payout
            var bonus = parseFloat($(this).find('input[name="bonus"]').val()) || 0;
            var payout = Math.floor(gross - totaldeduct + bonus);
            $(this).find('input[name="payout"]').val(payout.toFixed(2));
            var newBp = parseFloat($(this).find('input[name="bp"]').val()) || 0;
            var newHra = parseFloat($(this).find('input[name="hra"]').val()) || 0;
            var newOa = parseFloat($(this).find('input[name="oa"]').val()) || 0;
           
            var newGross = newBp + newHra + newOa ;
            // $(this).find('input[name="gross"]').val(newGross.toFixed(2));
        });
    }

    // Update totaldeduct and payout when epf1 is manually changed
    $(document).on('change', 'input[name="epf1"]', function() {
        updateTotalDeduct();
        updateGrossDeductAndPayout();
    });
    
    // Update totaldeduct and payout when esi1 is manually changed
    $(document).on('change', 'input[name="esi1"]', function() {
        updateTotalDeduct();
        updateGrossDeductAndPayout();
    });
    
    // Update esi1 when flop is changed
    $(document).on('change', 'input[name="flop"]', function() {
        updateBpAndEpf1AndEsi1();
        updateTotalDeduct();
        updateGrossDeductAndPayout();
    });

    // Update totaldeduct and payout when lopamt is manually changed
    $(document).on('change', 'input[name="lopamt"]', function() {
        updateTotalDeduct();
        updateGrossDeductAndPayout();
    });

    // Listen for input events on relevant fields
    $(document).on('input', 'input[name="monthdays"], input[name="lopamt"], input[name="misc"],input[name="flop"],input[name="tds"], input[name="fgs"], input[name="fbp"], input[name="fhra"], input[name="foa"], input[name="emi"],input[name="bonus"],input[name="damt"]', function() {
        updatePaydays();
        updateBpAndEpf1AndEsi1();
        updateHra();
        updateOa();
        updateTotalDeduct();
        updateGrossDeductAndPayout();
    });

    // Trigger initial calculations
    updatePaydays();
    updateBpAndEpf1AndEsi1();
    updateHra();
    updateOa();
    updateTotalDeduct();
    updateGrossDeductAndPayout();
});
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  function submitFormData() {
    var formData = new FormData();
    $("#ssTableBody tbody tr").each(function(index, element) {
      var empName = $(element).find('td:eq(0)').text().trim() || '';
      var salarymonth = $(element).find('td:eq(1)').text().trim() || '';
      var fbp = $(element).find('input[name="fbp"]').val().trim() || '';
      var fhra = $(element).find('input[name="fhra"]').val().trim() || '';
      var foa = $(element).find('input[name="foa"]').val().trim() || '';
      var fgs = $(element).find('input[name="fgs"]').val().trim() || '';
      var monthdays = $(element).find('input[name="monthdays"]').val().trim() || '';
      var present = $(element).find('input[name="present"]').val().trim() || '';
      var leaves = $(element).find('input[name="leaves"]').val().trim() || '';
      var sundays = $(element).find('input[name="sundays"]').val().trim() || '';
      var holidays = $(element).find('input[name="holidays"]').val().trim() || '';
      var flop = $(element).find('input[name="flop"]').val().trim() || '';
      var paydays = $(element).find('input[name="paydays"]').val().trim() || '';
      var bp = $(element).find('input[name="bp"]').val().trim() || '';
      var hra = $(element).find('input[name="hra"]').val().trim() || '';
      var oa = $(element).find('input[name="oa"]').val().trim() || '';
      var gross = $(element).find('input[name="gross"]').val().trim() || '';
      var epf1 = $(element).find('input[name="epf1"]').val().trim() || '';
      var esi1 = $(element).find('input[name="esi1"]').val().trim() || '';
      var tds = $(element).find('input[name="tds"]').val().trim() || '';
      var emi = $(element).find('input[name="emi"]').val().trim() || '';
      var lopamt = $(element).find('input[name="lopamt"]').val().trim() || '';
      var misc = $(element).find('input[name="misc"]').val().trim() || '';
      var totaldeduct = $(element).find('input[name="totaldeduct"]').val().trim() || '';
      var bonus = $(element).find('input[name="bonus"]').val().trim() || '';
      var payout = $(element).find('input[name="payout"]').val().trim() || '';
      var emp_no = $(element).find('input[name="emp_no"]').val().trim() || '';
      var desg = $(element).find('input[name="desg"]').val().trim() || '';
      var dept = $(element).find('input[name="dept"]').val().trim() || '';


      formData.append('empname[]', empName);
      formData.append('salarymonth[]', salarymonth);
      formData.append('fbp[]', fbp);
      formData.append('fhra[]', fhra);
      formData.append('foa[]', foa);
      formData.append('fgs[]', fgs);
      formData.append('monthdays[]', monthdays);
      formData.append('present[]', present);
      formData.append('leaves[]', leaves);
      formData.append('sundays[]', sundays);
      formData.append('holidays[]', holidays);
      formData.append('flop[]', flop);
      formData.append('paydays[]', paydays);
      formData.append('bp[]', bp);
      formData.append('hra[]', hra);
      formData.append('oa[]', oa);
      formData.append('gross[]', gross);
      formData.append('epf1[]', epf1);
      formData.append('esi1[]', esi1);
      formData.append('tds[]', tds);
      formData.append('emi[]', emi);
      formData.append('lopamt[]', lopamt);
      formData.append('misc[]', misc);
      formData.append('totaldeduct[]', totaldeduct);
      formData.append('bonus[]', bonus);
      formData.append('payout[]', payout);
      
      formData.append('emp_no[]', emp_no);
      formData.append('desg[]', desg);
      formData.append('dept[]', dept);
    });

    Swal.fire({
      title: 'Are you sure?',
      text: 'Do you want to submit the data?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, submit',
      cancelButtonText: 'No, cancel',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        // First AJAX request to insert form data
        $.ajax({
          type: 'POST',
          url: 'insert_ss.php',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            console.log('Success (First AJAX):', response);
            // Show success message
            Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: 'Data submitted successfully',
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.isConfirmed) {
                // Second AJAX request to update steps
                console.log('Before Second AJAX'); // Debug statement
                $.ajax({
                  type: 'POST',
                  url: 'update_steps.php',
                  data: new FormData($('#employeeForm')[0]),
                  processData: false,
                  contentType: false,
                  success: function(response) {
                    console.log('Second AJAX Success:', response); // Debug statement
                    // Redirect to confirm salary page
                    window.location.href = 'p7_confirm_salary.php';
                    $('#employeeForm')[0].reset();
                  },
                  error: function(xhr, status, error) {
                    console.log('Second AJAX Error:', xhr.responseText); // Debug statement
                  }
                });
                console.log('After Second AJAX'); // Debug statement
              }
            });
          },
          error: function(xhr, status, error) {
            console.log('First AJAX Error:', xhr.responseText); // Debug statement
            // Show error message
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'An error occurred while processing your request.',
              confirmButtonText: 'OK'
            });
          }
        });
     
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        // Show cancellation message
        Swal.fire({
          title: 'Cancelled',
          text: 'The submission was cancelled',
          icon: 'info',
          confirmButtonText: 'OK'
        });
      }
    });
  }

  $(document).ready(function() {
    $('#steps').click(function(e) {
      e.preventDefault();

      // Call the function to submit form data
      submitFormData();
    });
  });
</script>


</html>