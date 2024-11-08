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

  <link rel="stylesheet" href="./global.css" />
  <link rel="stylesheet" href="./salary.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" />
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

  <style>
    .rejected-container {
      position: relative;
      display: inline-block;
    }

    .view-reason-btn {
      display: none;
      position: absolute;
      top: 0;
      left: 0;
      z-index: 1;
    }

    .rejected-container:hover .view-reason-btn {
      display: block;
      height: 100%;
      width: 100%;
    }
  </style>
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
      <a class="salary2">Payroll</a>
      <a href="./employee-dashboard.html"> <img class="bxhome-icon1" alt="" src="./public1/bxhome.svg" id="bxhomeIcon" /></a>
    </div>
    <?php
    $sql = "SELECT * FROM emp WHERE empemail = '" . $_SESSION['user_name'] . "' ";
    $que = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($que);
    $empname = $row['empname'];
    $work_location = $row['work_location'];

    // Check for pending loan requests (status = 0)
    $sql1 = "SELECT COUNT(*) as count FROM payroll_loan_req WHERE empname = ? AND status = 0";
    $stmt = mysqli_prepare($con, $sql1);
    mysqli_stmt_bind_param($stmt, "s", $empname);
    mysqli_stmt_execute($stmt);
    $result1 = mysqli_stmt_get_result($stmt);

    $pendingCount = 0;
    if ($result1) {
      $row1 = mysqli_fetch_assoc($result1);
      $pendingCount = $row1['count'];
    }
    mysqli_stmt_close($stmt);

    // Check for active loans (status = 1)
    $sql2 = "SELECT COUNT(*) as count FROM payroll_loan WHERE empname = ? AND status = 1";
    $stmt = mysqli_prepare($con, $sql2);
    mysqli_stmt_bind_param($stmt, "s", $empname);
    mysqli_stmt_execute($stmt);
    $result2 = mysqli_stmt_get_result($stmt);

    $activeCount = 0;
    if ($result2) {
      $row2 = mysqli_fetch_assoc($result2);
      $activeCount = $row2['count'];
    }
    mysqli_stmt_close($stmt);

    // Determine if the button should be disabled
    $isDisabled = ($pendingCount > 0 || $activeCount > 0) ? 'disabled' : '';
    $opacity = ($pendingCount > 0 || $activeCount > 0) ? 'opacity-20' : '';

    ?>
    <div class="frame-div">

      <div class="employee-loan-illustration" style="margin-top:-30px;margin-left:350px;width: 600px; height: 260px; background-color: #f0f4f8; border-radius: 10px; padding: 20px; position: relative; overflow: hidden; border: 2px solid #cbd5e0;">
        <div style="position: absolute; top: 10px; left: 10px; right: 10px; text-align: center; font-size: 20px; color: #2d3748; font-weight: bold;">
          Employee Loan Service Workflow
        </div>

        <!-- Background workflow -->
        <svg width="560" height="2" viewBox="0 0 560 2" fill="none" xmlns="http://www.w3.org/2000/svg" style="position: absolute; left: 20px; top: 150px;">
          <path d="M0 1H560" stroke="#cbd5e0" stroke-width="2" stroke-dasharray="5 5" />
        </svg>

        <!-- Step 1: Application -->
        <div style="position: absolute; left: 30px; top: 70px; width: 120px; text-align: center; display: flex; flex-direction: column; align-items: center;">
          <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="5" y="5" width="40" height="40" rx="5" fill="#4299e1" />
            <path d="M15 25H35M15 15H35M15 35H25" stroke="white" stroke-width="2" />
          </svg>
          <p style="font-size: 14px; color: #4a5568; margin-top: 10px;">1. Submit Application</p>
        </div>

        <!-- Step 2: Review -->
        <div style="position: absolute; left: 180px; top: 70px; width: 120px; text-align: center; display: flex; flex-direction: column; align-items: center;">
          <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="25" cy="25" r="20" fill="#48bb78" />
            <path d="M17 25L22 30L33 20" stroke="white" stroke-width="3" />
          </svg>
          <p style="font-size: 14px; color: #4a5568; margin-top: 10px;">2. HR Review</p>
        </div>

        <!-- Step 3: Approval -->
        <div style="position: absolute; left: 330px; top: 70px; width: 120px; text-align: center; display: flex; flex-direction: column; align-items: center;">
          <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="5" y="15" width="40" height="30" rx="5" fill="#ed8936" />
            <path d="M15 15V10C15 7.23858 17.2386 5 20 5H30C32.7614 5 35 7.23858 35 10V15" stroke="#ed8936" stroke-width="2" />
            <circle cx="25" cy="30" r="5" fill="white" />
          </svg>
          <p style="font-size: 14px; color: #4a5568; margin-top: 10px;">3. Loan Approval</p>
        </div>

        <!-- Step 4: Disbursement -->
        <div style="position: absolute; left: 480px; top: 70px; width: 120px; text-align: center; display: flex; flex-direction: column; align-items: center;">
          <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="5" y="15" width="40" height="30" rx="5" fill="#667eea" />
            <path d="M25 10V40M20 35L25 40L30 35" stroke="white" stroke-width="2" />
          </svg>
          <p style="font-size: 14px; color: #4a5568; margin-top: 10px;">4. Loan Disbursement</p>
        </div>

        <!-- Company and Employee -->
        <div style="position: absolute; left: 30px; bottom: 20px; display: flex; align-items: center;">
          <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="5" y="20" width="40" height="25" fill="#4a5568" />
            <polygon points="25,5 45,20 5,20" fill="#4a5568" />
            <rect x="15" y="25" width="10" height="10" fill="#fff" />
            <rect x="30" y="25" width="10" height="10" fill="#fff" />
          </svg>
          <span style="margin-left: 10px; font-size: 16px; color: #4a5568;">Company</span>
        </div>

        <div style="position: absolute; right: 30px; bottom: 20px; display: flex; align-items: center;">
          <span style="margin-right: 10px; font-size: 16px; color: #4a5568;">Employee</span>
          <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="25" cy="15" r="12" fill="#4299e1" />
            <path d="M5 50C5 36.2 13.5 25 25 25C36.5 25 45 36.2 45 50" fill="#4299e1" />
          </svg>
        </div>
      </div>

      <div class="relative">
        <button style="position: absolute; top: -50px; left: 1000px;" data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 <?php echo $opacity; ?>" type="button" <?php echo $isDisabled; ?>>
          + Request Loan
        </button>
        <div class="absolute left-[0px] bg-blue-800 rounded-full p-1 shadow-lg z-10" style="top:-50px;">
          <h3 class="text-white text-lg font-bold px-6 py-2 rounded-full bg-gradient-to-r from-blue-500 to-blue-800 shadow-inner">
            Loan Requests Table
          </h3>
        </div>
        <div style="margin-top: 80px;">
          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="width: 1240px;">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 ">
              <tr>
                <th scope="col" class="px-6 py-3">
                  Loan Amount
                </th>
                <th scope="col" class="px-6 py-3">
                  Purpose
                </th>
                <th scope="col" class="px-6 py-3">
                  Requested Date
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
            $sql_req = "SELECT * FROM payroll_loan_req WHERE empname = '$empname'";
            $que_req = mysqli_query($con, $sql_req);

            if (mysqli_num_rows($que_req) > 0) {
              $que = $que_req;
            } else {
              $sql_loan = "SELECT * FROM payroll_loan WHERE empname = '$empname'";
              $que = mysqli_query($con, $sql_loan);
            }

            if (mysqli_num_rows($que) > 0) {
              while ($result = mysqli_fetch_assoc($que)) {
                $rejection = isset($result['rejection_reason']) ? $result['rejection_reason'] : '';
            ?>
                <tbody>
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4"><?php echo $result['loamt']; ?></td>
                    <td class="px-6 py-4"><?php echo $result['notes']; ?></td>
                    <td class="px-6 py-4"><?php echo $result['created']; ?></td>
                    <td class="px-4 py-4">
                      <?php
                      if ($result['status'] == 1) {
                        echo '<span class="hideon1"><span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 inline-flex items-center px-2.5 py-0.5 rounded me-2 dark:bg-green-900 dark:text-green-300 border border-green-500">
                        <svg class="w-6 h-6 me-1.5 text-green-900 dark:text-white" xmlns="http://www.w3.org/2000/svg" width="37" height="37" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        Approved
                        </span></span>';
                      } elseif ($result['status'] == 2) {
                        echo ' <div class="rejected-container">
  <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 inline-flex items-center px-2.5 py-0.5 rounded me-2 dark:bg-red-900 dark:text-red-300 border border-red-500">
    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#d0021b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="12" cy="12" r="10"></circle>
      <line x1="15" y1="9" x2="9" y2="15"></line>
      <line x1="9" y1="9" x2="15" y2="15"></line>
    </svg> 
    Rejected
  </span>

</div>';
                      } elseif ($result['status'] == 0) {
                        echo '<span class="hideon1"><span class="bg-gray-100 text-gray-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded me-2 dark:bg-gray-700 dark:text-gray-400 border border-gray-500 ">
                        <svg class="w-6 h-6 me-1.5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path fill="currentColor" d="m18.774 8.245-.892-.893a1.5 1.5 0 0 1-.437-1.052V5.036a2.484 2.484 0 0 0-2.48-2.48H13.7a1.5 1.5 0 0 1-1.052-.438l-.893-.892a2.484 2.484 0 0 0-3.51 0l-.893.892a1.5 1.5 0 0 1-1.052.437H5.036a2.484 2.484 0 0 0-2.48 2.481V6.3a1.5 1.5 0 0 1-.438 1.052l-.892.893a2.484 2.484 0 0 0 0 3.51l.892.893a1.5 1.5 0 0 1 .437 1.052v1.264a2.484 2.484 0 0 0 2.481 2.481H6.3a1.5 1.5 0 0 1 1.052.437l.893.892a2.484 2.484 0 0 0 3.51 0l.893-.892a1.5 1.5 0 0 1 1.052-.437h1.264a2.484 2.484 0 0 0 2.481-2.48V13.7a1.5 1.5 0 0 1 .437-1.052l.892-.893a2.484 2.484 0 0 0 0-3.51Z"/>
                        <path fill="#fff" d="M8 13a1 1 0 0 1-.707-.293l-2-2a1 1 0 1 1 1.414-1.414l1.42 1.42 5.318-3.545a1 1 0 0 1 1.11 1.664l-6 4A1 1 0 0 1 8 13Z"/>
                        </svg>
                        Application Submitted
                        </span></span>';
                      }
                      ?>
                    </td>
                    <td class="px-2 py-4">
                      <?php
                      if ($result['status'] == 0 || $result['status'] == 1) {
                      ?>
                        <button data-modal-target="default-modals" data-modal-toggle="default-modals" id="<?php echo $result['empname']; ?>" class="edit_data6 hidden-btn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  rounded-lg text-s px-2 py-2.5  dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                          View more
                        </button>
                      <?php }
                      ?>
                      <?php
                      if ($result['status'] == 2) {
                      ?>
                        <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" id="<?php echo $result['empname']; ?>" class="edit_data6 hidden-btn block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  rounded-lg text-s px-2 py-2.5  dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                          View Reason
                        </button>
                      <?php }
                      ?>
                    </td>
                  </tr>
                </tbody>
              <?php
              }
            } else {
              ?>
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td colspan="9" class="px-6 py-4 text-center">No loan requests</td>
              </tr>
            <?php
            }
            ?>

          </table>
          <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
              <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                  <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                  <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                  </svg>
                  <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                    <?php
                    $cnt = 1;
                    $sql = "SELECT * FROM payroll_loan_req ";
                    $que = mysqli_query($con, $sql);

                    if (mysqli_num_rows($que) > 0) {
                      while ($result = mysqli_fetch_assoc($que)) {
                    ?>
                        <div>
                          Your Loan Has Been Rejected Due To
                          <?php echo $result['rejection']; ?>
                        </div>
                    <?php
                      }
                    } else {
                      echo "No results found.";
                    }
                    ?>
                  </h3>
                </div>
              </div>
            </div>
          </div>
          <div id="default-modals" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
              <!-- Modal content -->
              <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Loan Details <br>
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
                  <?php @include("Payroll/view_loanmodal.php"); ?>
                </div>
                <!-- Modal footer -->
              </div>
            </div>
          </div>
        </div>

        <!-- Main modal -->
        <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <form id="employeeForm">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Employee Loan Request
                  </h3>
                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                  </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4" style="font-size:20px;">
                  <!-- Illustration block -->
                  <div class="mb-6 p-4 bg-blue-50 rounded-lg dark:bg-gray-800">
                    <div class="flex items-center justify-center mb-4">
                      <svg class="w-12 h-12 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Loan Application Process</h4>
                    <ol class="list-decimal list-inside text-sm text-gray-700 dark:text-gray-300">
                      <li>Apply: Fill loan amount, purpose, and submit.</li>
                      <li>HR Review: Your request is sent to HR for eligibility check and due diligence.</li>
                      <li>Approval & Credit: If approved, the amount is credited to your salary account.</li>
                      <li>Track Status: Check your loan request status anytime in the "Your Loan Requests" table.</li>
                    </ol>
                  </div>
                  <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="space-y-6">
                      <input type="hidden" name="empname" value="<?php echo $empname ?>">
                      <input type="hidden" name="work_location" value="<?php echo $work_location ?>">

                      <div class="space-y-1">
                        <label for="loanAmount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Loan Amount:</label>
                        <div class="flex">
                          <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                            ₹
                          </span>
                          <input type="text" name="loamt" id="loanAmount" class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter loan amount">
                          <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-l-0 border-gray-300 rounded-r-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                            /-
                          </span>
                        </div>
                      </div>

                      <div class="space-y-1">
                        <label for="loanPurpose" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Purpose of Loan:</label>
                        <textarea id="loanPurpose" name="notes" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Please describe the purpose of your loan request"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal footer -->
                <div class="flex flex-col items-start p-4 md:p-5 ">
                  <div class="w-full p-4 bg-gray-100 border border-gray-300 rounded-lg dark:bg-gray-700 dark:border-gray-600">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                      <strong class="font-medium">Disclaimer:</strong> Submitting a loan request does not guarantee approval. The final decision is subject to various eligibility criteria, including but not limited to:
                    </p>
                    <ul class="list-disc list-inside mt-2 text-sm text-gray-600 dark:text-gray-400">
                      <li>Service tenure with the company</li>
                      <li>Gross salary</li>
                      <li>Employee profile and performance</li>
                    </ul>
                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                      For comprehensive information, please consult the <strong class="font-medium">Employee Loan Policy</strong>. If you have any questions, don't hesitate to contact the HR department.
                    </p>
                  </div>
                  <br>
                  <button style="margin-left:400px;" data-modal-hide="default-modal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mb-4">Submit Request</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>


    </div>
    <img class="logo-1-icon1" alt="" src="./public1/logo-1@2x.png" />
  </div>
  <script type="text/javascript">
    $(document).ready(function() {
      // Download link click event
      $(document).on('click', '.download-link', function(e) {
        e.preventDefault();
        var empname = $(this).data('id');
        window.open("Payroll/print-detailsld.php?empname=" + empname);
      });

      // View more button click event
      $(document).on('click', '.edit_data6', function() {
        var edit_id5 = $(this).attr('id');
        $.ajax({
          url: "Payroll/view_emploanmodal.php",
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
    $(document).ready(function() {
      $('#employeeForm').submit(function(e) {
        e.preventDefault();

        $.ajax({
          type: 'POST',
          url: 'insert_loanreq.php',
          data: new FormData(this),
          processData: false,
          contentType: false,
          success: function(response) {
            console.log('Success:', response);
            Swal.fire({
              icon: 'success',
              title: 'Submitted!',
              text: response,
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = 'emploan.php';
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