<!DOCTYPE html>
<?php
session_start();
@include 'inc/config.php';

if (empty($_SESSION['user_name']) && empty($_SESSION['name'])) {
  header('location:loginpage.php');
  exit();
}

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
if (empty($user_name)) {
  header('location:loginpage.php');
  exit();
}

$query = "SELECT uf.*, m.status as manager_status 
              FROM user_form uf
              LEFT JOIN manager m ON uf.email = m.email 
              WHERE uf.email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if ($row && isset($row['user_type'])) {
    $user_type = $row['user_type'];
    $work_location = $row['work_location'];
    if ($user_type !== 'admin' && $user_type !== 'user') {
      header('location:loginpage.php');
      exit();
    }
    if ($user_type === 'user' && empty($row['manager_status'])) {
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

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="initial-scale=1, width=device-width" />

  <link rel="stylesheet" href="./css/global.css" />
  <link rel="stylesheet" href="./css/attendence.css" />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/foundation/6.4.4-rc1/css/foundation.css'>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    table {
      z-index: 100;
      border-collapse: collapse;
      background-color: white;
    }

    th,
    td {
      padding: 1em;
      border-bottom: 2px solid rgb(193, 193, 193);
    }

    .even {
      border-bottom: 2px solid #e8e8e8ba;
    }

    .odd {
      background-color: #e9e9e9 !important;
    }

    .quote-imgs-thumbs {
      background: #eee;
      border: 1px solid #ccc;
      border-radius: 0.25rem;
      margin: 1.5rem 0;
      padding: 0.75rem;
    }

    .quote-imgs-thumbs--hidden {
      display: none;
    }

    .img-preview-thumb {
      background: #fff;
      border: 1px solid #777;
      border-radius: 0.25rem;
      box-shadow: 0.125rem 0.125rem 0.0625rem rgba(0, 0, 0, 0.12);
      margin-right: 1rem;
      max-width: 140px;
      padding: 0.25rem;
    }

    .container {
      max-width: 800px;
      width: 100%;
      background-color: #f9f9f9;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .toolbar {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      margin-bottom: 10px;
    }

    button {
      font-size: 16px;
      cursor: pointer;
      margin: 4px;
      padding: 8px 12px;
      border: none;
      background: #ffffff;
      border-radius: 4px;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #f3f3f3;
    }

    .editor {
      border: 1px solid #ccc;
      min-height: 200px;
      padding: 10px;
      overflow-y: auto;
      border-radius: 8px;
    }

    #charCount,
    #wordCount {
      float: right;
      margin-top: 10px;
      color: #777;
      text-align: left;
      margin-right: 10px;
    }

    /* Responsive Styles */
    @media (max-width: 600px) {
      .toolbar {
        flex-direction: column;
        align-items: center;
      }

      .toolbar button {
        margin: 4px 0;
      }

      .editor {
        min-height: 150px;
      }
    }

    ::-webkit-scrollbar {
      width: 6px;
    }

    ::-webkit-scrollbar-track {
      background-color: #ebebeb;
      -webkit-border-radius: 10px;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
      -webkit-border-radius: 10px;
      border-radius: 10px;
      background: #bebebe;
    }

    .process-block {
      background-color: white;
      border: 2px solid #F35F14;
      border-radius: 10px;
      padding: 15px;
      width: 700px;
      max-width: 100%;
      max-height: 94%;
      font-size: 15px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #F35F14;
      font-size: 20px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 2px;
      position: relative;
    }

    h2::after {
      content: '';
      display: block;
      width: 50px;
      height: 3px;
      background-color: #F35F14;
      margin: 10px auto 0;
    }

    .step {
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      background-color: #f9f9f9;
      border-radius: 8px;
      padding: 4px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .step-number {
      background-color: #F35F14;
      color: white;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-right: 15px;
      font-weight: bold;
      font-size: 18px;
    }

    .step-text {
      color: #333;

      flex-grow: 1;
    }

    .custom-scrollbar::-webkit-scrollbar {
      width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
      background-color: #F46114;
      border-radius: 10px;
      border: 3px solid #FFFFFF;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
      background: #F0F0F0;
    }

    .custom-scrollbar {
      scrollbar-width: thin;
      scrollbar-color: #F46114 #F0F0F0;
    }
    
    .mgr-view{
          margin-top:-85px;
          margin-left:-20px;
          color:white;
          font-size:20px;
          text-decoration: none;
          white-space: nowrap;
        }
        .employeedashboard-inner {
            display: flex;
            align-items: center;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 4px 15px;
            height: 50px;
            width: 140px;
            cursor: pointer;
            margin-left:-90px;
        }

        .employeedashboard-inner svg {
            flex-shrink: 0;
        }

        .employeedashboard-inner span {
            margin-left: 5px;
        }
  </style>
</head>

<body>
  <div class="attendence4" style="margin-left:auto;margin-right:auto;">
    <div class="bg14"></div>
    <div class="rectangle-parent22" style="margin-left:0px;">
      <div class="frame-child187"></div>
      <a class="frame-child188" style="background-color: #E8E8E8;"> </a>
      <a class="attendence5" style="color: black;">Attendance</a>
      <a class="frame-child191" id="rectangleLink3" style="margin-left: -450px;"> </a>
      <a class="frame-child191" id="rectangleLink3" style="margin-left: 35px; background-color: #ffe2c6;"> </a>
      <a href="attendanceemp.php" class="my-attendence4" id="myAttendence" style="margin-left: -450px;">Attendance log</a>
      <a class="frame-child191" id="rectangleLink3" href="sheet_emp.php" target="_blank" style="margin-left: -200px;"> </a>
      <a href="sheet_emp.php" class="my-attendence4" id="myAttendence" target="_blank" style="margin-left: -205px; margin-top:2px; font-size:18px; width:200px">Monthly Attendance</a>
      <a href="sheet_emp.php" class="my-attendence4" id="myAttendence" style="margin-left: 32px; margin-top:2px; font-size:18px; width:200px; color: #ff5400;">Remote Attendance</a>
    </div>

    <!-- main div -->
    <div class="rectangle-parent23 " style="margin-left: 0px;">
      <div style="background-color: white; height: 600px; width: 250vh; max-width:100%;border-radius: 20px;"></div>

<div style="display: flex; justify-content: space-between; align-items: center; margin-top: -575px; border: 1px solid #d1d5db; border-radius: 8px; padding: 8px;">
  <div>
    <p style="font-size: 25px; color: rgb(83, 83, 83); margin: 0;">Remote Work Approval</p>
  </div>
  <div style="display: flex; gap: 10px;">
    <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" style="border: 1px solid #3b82f6;" type="button" data-drawer-target="drawer-example" data-drawer-show="drawer-example" aria-controls="drawer-example">
      Remote Work Applications
    </button>
    <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" style="border: 1px solid #3b82f6;" type="button" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example" data-drawer-placement="right" aria-controls="drawer-right-example">
      Remote Work Verification
    </button>
  </div>
</div>
      <?php
      $sql = "SELECT * FROM emp WHERE (empemail = '" . $_SESSION['user_name'] . "' && empstatus= 0 )";
      $que = mysqli_query($con, $sql);
      $row = mysqli_fetch_array($que);
      $empname = $row['empname'];

      ?>

      <!--<hr style="width: 148vh; max-width:100%; margin-left: 20px; color: rgb(26, 26, 26);">-->
      <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 ">
          <!-- <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Add a new product</h2> -->
          <form id="remoteInsert">
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
              <div class="sm:col-span-2">
                <label for="employee" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Employee for Remote Work Access</label>
                <select id="employee-select" name="empname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                  <option value="">--Select Employee--</option>
                  <?php
                  $manager_query = "SELECT desg, work_location FROM manager WHERE email = '$user_name'";
                  $manager_result = mysqli_query($con, $manager_query);

                  if ($manager_result) {
                    $manager_designations = array();
                    $work_location = '';
                    while ($row = mysqli_fetch_assoc($manager_result)) {
                      $designations = array_map('trim', explode(',', $row['desg']));
                      $manager_designations = array_merge($manager_designations, $designations);
                      $work_location = $row['work_location'];
                    }
                    $manager_designations = array_unique(array_filter($manager_designations));

                    if (!empty($manager_designations)) {
                      $inClause = implode("','", $manager_designations);
                      $employee_query = "SELECT emp.* FROM emp 
                           WHERE emp.desg IN ('$inClause') 
                           AND work_location = '$work_location' AND emp.empstatus = 0
                           ORDER BY emp.emp_no ASC";
                      $employee_result = mysqli_query($con, $employee_query);

                      if ($employee_result && mysqli_num_rows($employee_result) > 0) {
                        while ($row = mysqli_fetch_assoc($employee_result)) {
                          echo "<option value='" . $row["empname"] . "' 
                      data-work_location='" . $row["work_location"] . "' 
                      data-empemail='" . $row["empemail"] . "' 
                      data-empph='" . $row["empph"] . "' 
                      data-desg='" . $row["desg"] . "'>" . $row["empname"] . "</option>";
                        }
                      } else {
                        echo "<option value=''>0 results</option>";
                      }
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="w-full">
                <label for="brand" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employee Designation</label>
                <input type="text" id="desg-input" name="desg" value="" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="" required="">
              </div>

              <div id="date-range-picker" date-rangepicker class="flex items-center gap-3">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remote Work Duration </label>
                <div class="relative">
                  <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mb-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                  </div>
                  <input id="datepicker-range-start" name="from" type="text" class="datepicker bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select Start Date ">
                </div>
                <span class="mx-4 text-gray-500 mb-5">to</span>
                <div class="relative">
                  <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mb-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                  </div>
                  <input id="datepicker-range-end" name="to" type="text" class="datepicker bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select End Date ">
                </div>
              </div>
              <div>

                <div id="duration-display" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">Daily Work Hours</div>
              </div>
              <!-- <br> -->

              <div class="sm:col-span-2">
                <div class="process-block">
                  <h2>Remote Work Process</h2>

                  <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-text">Manager authorizes WFH request</div>
                  </div>

                  <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-text">Employee starts remote timer</div>
                  </div>

                  <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-text">Employee submits work report when timer stopped <br>
                      and gets attendance for the day
                    </div>
                  </div>

                  <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-text">Manager verifies work</div>
                  </div>
                </div>
              </div>

              <div class="sm:col-span-2">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Project/Task for Remote Work Request</label>
                <textarea id="description" rows="8" name="reason" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Your description here"></textarea>
                <div style="margin-left:190px;margin-top:50px;">
                  <!--<button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">-->
                  <!--  Submit Remote Work Approval-->
                  <!--</button>-->
                  
                  <button type="submit" class="text-white bg-[#2557D6] hover:bg-[#2557D6]/90 focus:ring-4 focus:ring-[#2557D6]/50 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#2557D6]/50 me-2 mb-2">
<svg class="w-7 h-7 me-2 -ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-4m5-13v4a1 1 0 0 1-1 1H5m0 6h9m0 0-2-2m2 2-2 2"/>
</svg>

Submit Remote Work Approval
</button>
                </div>

              </div>

              <div>
                <input type="hidden" value="<?php echo $empname ?>" name="mgrname">
              </div>

            </div>

          </form>
        </div>
      </section>

      <!-- drawer component -->
      <div style="width:70%;" id="drawer-example" class="fixed top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white w-80 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-label">
      <h5 id="drawer-label" class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">
    <svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
    </svg>Remote Work Requests
</h5>

<p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
    Review and manage remote work applications from your team members. Quickly approve or deny requests, and maintain an overview of your team's remote work status.
</p>

<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
    <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
        Remote Work Applications
        <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">
            Overview of pending remote work requests from your team members
        </p>
    </caption>
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">
                Employee Name
              </th>
              <th scope="col" class="px-6 py-3">
                Remote Work Duration
              </th>
              <th scope="col" class="px-6 py-3">
                Project/Task
              </th>
              <th scope="col" class="px-6 py-3">
               Status
              </th>
              <th scope="col" class="py-3">
                Action
              </th>
            </tr>
          </thead>
          <?php
          $sql = "SELECT * FROM remotework where mgrname = '$empname'  ORDER BY id desc";

          $que = mysqli_query($con, $sql);
          $cnt = 1;
          if (mysqli_num_rows($que) == 0) {
            echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"><td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No remote work applications for approval</td></tr>';
          } else {
            while ($result = mysqli_fetch_assoc($que)) {
            $apr = $result['apr'];
          ?>
              <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                  <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <?php echo $result['empname']; ?>
                  </th>
                  <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <?php echo $result['from']; ?> to <?php echo $result['to']; ?>
                  </th>
                  <td class="px-6 py-4" style="width: 350px; overflow: hidden; text-overflow: ellipsis; ">
                    <?php echo $result['reason']; ?>
                  </td>
               <td>
    <?php
    if ($apr == 0) {
        echo '<sub>
            <div style="width:80%;max-width:100%;" class="flex items-center p-1 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-400 dark:border-yellow-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Pending for Approval</span>
                </div>
            </div>
        </sub>';
    } elseif ($apr == 1) {
        echo '<div class="flex items-center p-1 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Approved</span>
            </div>
        </div>';
    } elseif ($apr == 2) {
        echo '<div class="flex items-center p-1 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Rejected</span>
            </div>
        </div>';
    }
    ?>
</td>
                 <?php
if ($apr == 0) {
    echo '<td><div class="inline-flex rounded-md shadow-sm" role="group">
    <a data-approve-id="' . $result['id'] . '" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-green-900 rounded-s-lg hover:bg-green-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-green-500 focus:bg-green-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-green-700 dark:focus:bg-green-700 approve-btn">
        <svg class="w-6 h-6 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd" />
        </svg>
        Approve
    </a>
    <button type="hidden" class="pointer-events-none inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border-t border-b border-gray-900 hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
    </button>
    <a data-reject-id="' . $result['id'] . '" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-900 bg-transparent border border-red-900 rounded-e-lg hover:bg-red-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-red-500 focus:bg-red-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-red-700 dark:focus:bg-red-700 reject-btn">
        <svg class="w-6 h-6 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd" />
        </svg>
        Reject
    </a>
</div></td>';
} elseif ($apr == 1) {
    echo '<td><div class="flex items-center p-1 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Approved</span>
            </div>
        </div></td>';
} elseif ($apr == 2) {
    echo '<td><div class="flex items-center p-1 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Rejected</span>
            </div>
        </div></td>';
} 
?>
                </tr>
              </tbody>
          <?php
              $cnt++;
            }
          }
          ?>
        </table>
      </div>

      <!-- drawer component -->
      <div style="width:80%;" id="drawer-right-example" class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-80 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-right-label">
        <h5 id="drawer-right-label" class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">
          <svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
          </svg>
          Verify Remote Work and Productivity Score
        </h5>

        <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
          </svg>
          <span class="sr-only">Close menu</span>
        </button>
        <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
          Review the remote work details provided by your teammates. Verify the tasks completed and assign a productivity score based on their performance. Your assessment will help ensure accountability and recognize their efforts appropriately.
        </p>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="overflow-x:auto;height:400px;">
          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
              Remote Work History
              <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">
                Overview of your teammates remote work sessions and attendance records.
              </p>
            </caption>
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr>
                <th scope="col" class="px-6 py-3">
                  Employee Name
                </th>
                <th scope="col" class="px-6 py-3">
                  Remote Work Duration
                </th>
                <th scope="col" class="px-6 py-3">
                  Project/Task
                </th>
                <th scope="col" class="px-6 py-3">
                  Approving Authority
                </th>
                <th scope="col" class="px-6 py-3">
                   Status
                </th>
                <th scope="col" class="px-6 py-3">
                  <span class="sr-only">View</span>
                  Action
                </th>
                <th scope="col" class="px-6 py-3">
                  Productivity Score
                </th>
              </tr>
            </thead>
            <?php
            $sql = "SELECT remotework.*, 
(SELECT SUM(score) FROM remotework_emp WHERE remotework.id = remotework_emp.link_id) AS total_score 
FROM remotework where remotework.mgrname = '$empname' ORDER BY id desc";

            $que = mysqli_query($con, $sql);
            $cnt = 1;
            if (mysqli_num_rows($que) == 0) {
              echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"><td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No remote work history</td></tr>';
            } else {
              while ($result = mysqli_fetch_assoc($que)) {
                $apr = $result['apr'];
                   $status = $result['status'];
            ?>
                <tbody>
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                      <?php echo $result['empname']; ?>
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                      <?php echo $result['from']; ?> to <?php echo $result['to']; ?>
                    </th>
                    <td class="px-6 py-4" style="width: 350px; overflow: hidden; text-overflow: ellipsis; ">
                      <?php echo $result['reason']; ?>
                    </td>
                    <td class="px-6 py-4">
                      <?php echo $result['mgrname']; ?>
                    </td>
                     <td>
                <?php
if ($apr == 1) {
    echo '<sub>
        <div style="width:80%;max-width:100%;" class="flex items-center p-1 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Approved</span>
            </div>
        </div>
    </sub>';
    echo htmlspecialchars($result['approved']);
} elseif ($apr == 0) {
    echo '<sub>
        <div style="width:80%;max-width:100%;" class="flex items-center p-1 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Pending for Approval</span>
            </div>
        </div>
    </sub>';
} elseif ($apr == 2) {
    echo '<sub>
        <div style="width:80%;max-width:100%;" class="flex items-center p-1 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">Request Rejected</span>
            </div>
        </div>
    </sub>';
}
?>
                </td>
                <td>
    <?php
    if ($apr == 1) {
        if ($status == 0) {
            echo '<div class="inline-flex items-center px-1 py-1 bg-yellow-100 border border-yellow-400 rounded-lg">
                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm font-medium text-yellow-700">Session not started</span>
            </div>';
        } elseif ($status == 1) {
            echo '<div class="inline-flex items-center px-1 py-1 bg-green-100 border border-green-400 rounded-lg">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-sm font-medium text-green-700">Session started</span>
            </div>';
        } else {
            echo '<a id="readProductButton" data-link-id="' . htmlspecialchars($result['id']) . '" data-modal-target="readProductModal" data-modal-toggle="readProductModal" type="button" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>';
        }
    } elseif ($apr == 0) {
        echo '<sub>
            <div style="width:80%;max-width:100%;" class="flex items-center p-1 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Pending for Approval</span>
                </div>
            </div>
        </sub>';
    } elseif ($apr == 2) {
        echo '<sub>
            <div style="width:80%;max-width:100%;" class="flex items-center p-1 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Request Rejected</span>
                </div>
            </div>
        </sub>';
    }
    ?>
</td>
             <td>
    <?php
    if ($apr == 1) {
        if ($status == 0) {
            echo '<div class="inline-flex items-center px-1 py-1 bg-yellow-100 border border-yellow-400 rounded-lg">
                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm font-medium text-yellow-700">Session not started</span>
            </div>';
        } elseif ($status == 1) {
            echo '<div class="inline-flex items-center px-1 py-1 bg-green-100 border border-green-400 rounded-lg">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-sm font-medium text-green-700">Session started</span>
            </div>';
        } elseif ($status == 2) {
            if (is_null($result['total_score']) || $result['total_score'] == 0) {
                echo '<div class="inline-flex items-center px-1 py-1 bg-yellow-100 border border-yellow-400 rounded-lg">
                    <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-medium text-yellow-700">Work Verification Pending</span>
                </div>';
            } else {
                echo '<div class="inline-flex items-center px-1 py-1 bg-blue-100 border border-blue-400 rounded-lg">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5v2m6-2v2"></path>
                    </svg>
                    <span class="text-sm font-medium text-blue-700">Score: ' . htmlspecialchars($result['total_score']) . '</span>
                </div>';
            }
        }
    } elseif ($apr == 0) {
        echo '<sub>
            <div style="width:80%;max-width:100%;" class="flex items-center p-1 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Pending for Approval</span>
                </div>
            </div>
        </sub>';
    } elseif ($apr == 2) {
        echo '<sub>
            <div style="width:80%;max-width:100%;" class="flex items-center p-1 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Request Rejected</span>
                </div>
            </div>
        </sub>';
    }
    ?>
</td>
                  </tr>
                </tbody>
            <?php
                $cnt++;
              }
            }
            ?>
          </table>
        </div>
      </div>
    </div>
  </div>


  <!-- Main modal -->
  <div id="readProductModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-xl h-full md:h-auto">
      <!-- Modal content -->
      <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5 custom-scrollbar" style="height:780px;overflow-x:auto;">
        <!-- Modal header -->
        <div class="flex justify-between mb-4 rounded-t sm:mb-5">
          <div class="text-lg text-gray-900 md:text-xl dark:text-white">
            <h3 class="font-semibold">Remote Work Sessions</h3>
          </div>
        </div>
        <!-- Modal body -->
        <div id="modalContent">
          <!-- Content -->
        </div>
      </div>
    </div>
  </div>

  <?php

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$select = "SELECT uf.*, m.status as manager_status 
           FROM user_form uf
           LEFT JOIN manager m ON uf.email = m.email 
           WHERE uf.email = ?";

$stmt = mysqli_prepare($con, $select);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user_name'] = $row['email'];
    $_SESSION['admin_name'] = $row['name'];

    $manager_status = $row['manager_status'];
} else {
    // Handle case where user is not found
    echo "User not found";
    exit;
}
?>


  <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

  <img class="attendence-item" alt="" src="./public/rectangle-2@2x.png" />

  <img class="logo-1-icon14" alt="" src="./public/logo-1@2x.png" />

  <a class="anikahrm14" href="./employee-dashboard.php" id="anikaHRM">
    <span>Anika</span>
    <span class="hrm14">HRM</span>
  </a>
  <a class="attendence-management4" href="./employee-dashboard.php" id="attendenceManagement">Attendance Management</a>
  <button class="attendence-inner"><a href="logout.php" style="margin-left:25px; color:white; text-decoration:none; font-size:25px">Logout</a></button>

  <?php if ($manager_status == 1): ?>
      <a href="employee-dashboard.php" target="_blank" class="attendence-inner employeedashboard-inner mgr-view dashboard14">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path>
                <polygon points="12 15 17 21 7 21 12 15"></polygon>
            </svg>
            <span>My View</span>
        </a>
    <?php endif; ?>

  <!--<div class="logout14">Logout</div>-->
  <a style="margin-top: -35px; text-decoration:none; color:black;font-size:22px;font-weight: normal !important;" href="card.php" class="payroll14">Directory</a>
  <img class="uitcalender-icon14" alt="" src="./public/uitcalender.svg" />

  <img style="margin-top: -35px;" class="arcticonsgoogle-pay14" alt="" src="./public/arcticonsgooglepay.svg" />

  <img style="margin-top: -50px;" class="attendence-child2" alt="" src="./public/rectangle-4@2x.png" />

  <a class="dashboard14" style="margin-top: 60px;font-size:22px;font-weight: normal !important;" href="./employee-dashboard.php" id="dashboard">Dashboard</a>
  <a style="margin-top: 60px;" class="akar-iconsdashboard14" href="./employee-dashboard.php" id="akarIconsdashboard">
    <img class="vector-icon74" alt="" src="./public/vector3.svg" />
  </a>
  <img class="tablerlogout-icon14" alt="" src="./public/tablerlogout.svg" />

  <a class="leaves14" id="leaves" href="apply-leave-emp.php" style="font-size:22px;font-weight: normal !important;">Leaves</a>
  <a class="fluentperson-clock-20-regular14" id="fluentpersonClock20Regular">
    <img class="vector-icon75" alt="" src="./public/vector1.svg" />
  </a>
  <a style="margin-top: -50px;font-size:22px;font-weight: normal !important;" class="attendance14">Attendance</a>
  <a style="margin-top: -50px;" class="uitcalender14">
    <img class="vector-icon77" alt="" src="./public/vector11.svg" />
  </a>
  <div class="oouinext-ltr3"></div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function(){
        $('.approve-btn').click(function(e){
            e.preventDefault();
            var id = $(this).data('approve-id');
            $.ajax({
                url: 'update_approval_remotework.php',
                type: 'POST',
                data: { id: id, status: 1 },
                success: function(response){
                    // Handle success with SweetAlert
                    Swal.fire({
                        title: 'Success!',
                        text: 'Approved successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload(); // Reload the page to reflect changes
                        }
                    });
                },
                error: function(xhr, status, error){
                    // Handle error
                    alert('Error: ' + error);
                }
            });
        });

        $('.reject-btn').click(function(e){
            e.preventDefault();
            var id = $(this).data('reject-id');
            $.ajax({
                url: 'update_approval_remotework.php',
                type: 'POST',
                data: { id: id, status: 2 },
                success: function(response){
                    // Handle success with SweetAlert
                    Swal.fire({
                        title: 'Success!',
                        text: 'Rejected successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload(); // Reload the page to reflect changes
                        }
                    });
                },
                error: function(xhr, status, error){
                    // Handle error
                    alert('Error: ' + error);
                }
            });
        });
    });
    </script>


  <script type="text/javascript">
    $(document).ready(function() {
      $(document).on('click', '.verify-work', function() {
        var edit_id5 = $(this).data('id');
        $.ajax({
          url: "remotework_modal.php",
          type: "post",
          data: {
            edit_id5: edit_id5
          },
          success: function(data) {
            $("#modalVerify").html(data);
            $("#modalVerify").removeClass('hidden');
            $("body").addClass("modal-open");
          }
        });
      });

      // Close modal
      $(document).on('click', '#close-modalVerify', function() {
        $("#modalVerify").addClass('hidden');
        $("body").removeClass("modal-open");
      });

      // Handle form submission
      $(document).on('submit', '#verifyForm', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
          url: "update_remotework_score.php",
          type: "post",
          data: formData,
          success: function(response) {
            if (response == 'success') {
              Swal.fire({
                title: 'Success!',
                text: 'Work verified successfully!',
                icon: 'success',
                confirmButtonText: 'OK',
                  confirmButtonColor: '#3085d6'
              }).then((result) => {
                if (result.isConfirmed) {
                  $("#modalVerify").addClass('hidden');
                  $("body").removeClass("modal-open");
                  location.reload(); // Reload the page
                }
              });
            } else {
              Swal.fire({
                title: 'Error!',
                text: 'Error: ' + response,
                icon: 'error',
                confirmButtonText: 'OK'
              });
            }
          },
          error: function(xhr, status, error) {
            Swal.fire({
              title: 'Error!',
              text: 'An error occurred: ' + error,
              icon: 'error',
              confirmButtonText: 'OK'
            });
          }
        });
      });
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const modal = document.getElementById('readProductModal');
      const modalContent = document.getElementById('modalContent');
      const buttons = document.querySelectorAll('[data-modal-toggle="readProductModal"]');

      buttons.forEach(button => {
        button.addEventListener('click', function() {
          const linkId = this.getAttribute('data-link-id');
          fetch('get_remote_work_data_verify.php?link_id=' + linkId)
            .then(response => response.text())
            .then(data => {
              modalContent.innerHTML = data;
              modal.classList.remove('hidden');
            })
            .catch(error => console.error('Error:', error));
        });
      });

      // Close modal when clicking outside
      modal.addEventListener('click', function(event) {
        if (event.target === modal) {
          modal.classList.add('hidden');
        }
      });

      // Close modal when clicking close button
      const closeButton = modal.querySelector('[data-modal-toggle="readProductModal"]');
      closeButton.addEventListener('click', function() {
        modal.classList.add('hidden');
      });
    });
  </script>
  <script>
    function showPreviewModal(pics) {
      const previewModal = document.getElementById('previewModal');
      const previewContent = document.getElementById('previewContent');
      previewContent.innerHTML = '';

      pics.forEach(pic => {
        const imgElement = document.createElement('img');
        imgElement.src = 'work_pics/' + pic;
        imgElement.alt = pic;
        imgElement.classList.add('max-w-full', 'h-auto', 'rounded-lg', 'shadow-md');
        previewContent.appendChild(imgElement);
      });

      previewModal.classList.remove('hidden');
    }

    function hidePreviewModal() {
      const previewModal = document.getElementById('previewModal');
      previewModal.classList.add('hidden');
    }
  </script>
  <script>
    $(document).ready(function() {
      $("#remoteInsert").submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
          type: "POST",
          url: "insert_remoteWork.php",
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            Swal.fire({
              icon: 'success',
              title: 'Approval Successful!',
              text: 'Remote work request has been approved.',
              confirmButtonText: 'OK',
              confirmButtonColor: '#3085d6',
              allowOutsideClick: false
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = 'remote_attendance_mgr.php';
              }
            });
          },
          error: function(xhr, status, error) {
            Swal.fire({
              icon: 'error',
              title: 'Approval Failed',
              text: 'An error occurred while processing your request. Please try again.',
              confirmButtonText: 'OK',
              confirmButtonColor: '#d33'
            });
          }
        });
      });
    });
  </script>

  <script>
    document.getElementById('employee-select').addEventListener('change', function() {
      var selectedEmpName = this.value;
      if (selectedEmpName) {
        fetch('get_duration.php?empname=' + encodeURIComponent(selectedEmpName))
          .then(response => response.text())
          .then(data => {
            document.getElementById('duration-display').innerHTML = data;
          });
      } else {
        document.getElementById('duration-display').innerHTML = '';
      }
    });
  </script>
  <script>
    document.getElementById('employee-select').addEventListener('change', function() {
      var selectedOption = this.options[this.selectedIndex];
      var employee = selectedOption.getAttribute('data-desg');
      document.getElementById('desg-input').value = employee;
    });
  </script>
  <script>
    var rectangleLink1 = document.getElementById("rectangleLink1");
    if (rectangleLink1) {
      rectangleLink1.addEventListener("click", function(e) {
        window.location.href = "./punch-i-n.php";
      });
    }

    var rectangleLink2 = document.getElementById("rectangleLink2");
    if (rectangleLink2) {
      rectangleLink2.addEventListener("click", function(e) {
        window.location.href = "./punch-i-n.php";
      });
    }

    var rectangleLink3 = document.getElementById("rectangleLink3");
    if (rectangleLink3) {
      rectangleLink3.addEventListener("click", function(e) {
        window.location.href = "./attendanceemp.php";
      });
    }

    var records = document.getElementById("records");
    if (records) {
      records.addEventListener("click", function(e) {
        window.location.href = "./punch-i-n.php";
      });
    }

    var punchINOUT = document.getElementById("punchINOUT");
    if (punchINOUT) {
      punchINOUT.addEventListener("click", function(e) {
        window.location.href = "./punchout.php";
      });
    }

    var myAttendence = document.getElementById("myAttendence");
    if (myAttendence) {
      myAttendence.addEventListener("click", function(e) {
        window.location.href = "./attendanceemp.php";
      });
    }

    var anikaHRM = document.getElementById("anikaHRM");
    if (anikaHRM) {
      anikaHRM.addEventListener("click", function(e) {
        window.location.href = "./employee-dashboard.php";
      });
    }

    var attendenceManagement = document.getElementById("attendenceManagement");
    if (attendenceManagement) {
      attendenceManagement.addEventListener("click", function(e) {
        window.location.href = "./employee-dashboard.php";
      });
    }

    var dashboard = document.getElementById("dashboard");
    if (dashboard) {
      dashboard.addEventListener("click", function(e) {
        window.location.href = "./employee-dashboard.php";
      });
    }

    var fluentpeople32Regular = document.getElementById("fluentpeople32Regular");
    if (fluentpeople32Regular) {
      fluentpeople32Regular.addEventListener("click", function(e) {
        window.location.href = "./employee-management.php";
      });
    }

    var employeeList = document.getElementById("employeeList");
    if (employeeList) {
      employeeList.addEventListener("click", function(e) {
        window.location.href = "./employee-management.php";
      });
    }

    var akarIconsdashboard = document.getElementById("akarIconsdashboard");
    if (akarIconsdashboard) {
      akarIconsdashboard.addEventListener("click", function(e) {
        window.location.href = "./employee-dashboard.php";
      });
    }

    var leaves = document.getElementById("leaves");
    if (leaves) {
      leaves.addEventListener("click", function(e) {
        window.location.href = "./leave-management.php";
      });
    }

    var fluentpersonClock20Regular = document.getElementById(
      "fluentpersonClock20Regular"
    );
    if (fluentpersonClock20Regular) {
      fluentpersonClock20Regular.addEventListener("click", function(e) {
        window.location.href = "./leave-management.php";
      });
    }

    var onboarding = document.getElementById("onboarding");
    if (onboarding) {
      onboarding.addEventListener("click", function(e) {
        window.location.href = "./onboarding.php";
      });
    }

    var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
    if (fluentMdl2leaveUser) {
      fluentMdl2leaveUser.addEventListener("click", function(e) {
        window.location.href = "./onboarding.php";
      });
    }
  </script>
</body>

</html>