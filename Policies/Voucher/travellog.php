<?php

@include 'inc/config.php';

session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:login.php');
}
?>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/employee-management.css" />
    <link rel="stylesheet" href="./css/attendence.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css"  rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    <!-- jQuery -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <style>
        /* Scrollbar Styling */
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

        .dropbtn {
            background-color: #45C380;
            color: #ffffff;
            padding: 16px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px #45C380;
        }

        .swal2-container {
            z-index: 100000 !important;
        }

        .my-swal {
            z-index: 100000 !important;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            position: absolute;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 98;
            max-height: 0;
            min-width: 160px;
            transition: max-height 0.15s ease-out;
            overflow: hidden;
        }

        .dropdown-content a {
            color: black;
            background-color: #f9f9f9;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #e2e2e2;
        }

        .dropdown:hover .dropdown-content {
            max-height: 500px;
            min-width: 160px;
            transition: max-height 0.25s ease-in;
        }

        .dropdown:hover .dropbtn {
            /* background-color: #f9f9f9;
  border-bottom: 1px solid #e0e0e0; */
            transition: max-height 0.25s ease-in;
        }

        .dialog {
            padding: 20px;
            border: 0;
            background: transparent;
        }

        .dialog::backdrop {
            background-color: rgba(0, 0, 0, .3);
            backdrop-filter: blur(4px);
        }

        .dialog__wrapper {
            padding: 20px;
            background: #fff;
            width: 1000px;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .3);
        }

        .dialog__close {
            border: 0;
            padding: 0;
            width: 24px;
            aspect-ratio: 1;
            display: grid;
            place-items: center;
            background: #000;
            color: #fff;
            border-radius: 50%;
            font-size: 12px;
            line-height: 20px;
            position: absolute;
            top: 5px;
            right: 5px;
            cursor: pointer;
            --webkit-appearance: none;
            appearance: none;
        }

        .send-email {
            position: absolute;
            top: 101px;
            left: 388px;
            display: inline-block;
            width: 236px;
            height: 39px;
        }

        .email-id,
        .frame-child {
            position: absolute;
            left: 126px;
        }

        .email-id {
            cursor: pointer;
            top: 190px;
            font-size: 20px;
            font-weight: 300;
            color: #313131;
            display: inline-block;
            width: 165px;
            height: 22px;
        }

        .frame-child {
            border: 1px solid #7f7f7f;
            background-color: var(--color-white);
            top: 221px;
            border-radius: 10px;
            box-sizing: border-box;
            width: 727px;
            height: 50px;
        }

        .frame-item {
            cursor: pointer;
            border: 0;
            padding: 0;
            background-color: #2f82ff;
            position: absolute;
            top: 337px;
            left: 683px;
            border-radius: 50px;
            box-shadow: 5px 7px 4px rgba(47, 130, 255, 0.41);
            width: 170px;
            height: 43px;
        }

        .send-mail {
            text-decoration: none;
            position: absolute;
            top: 344px;
            left: 711px;
            font-size: 25px;
            line-height: 117.5%;
            color: var(--color-white);
            display: inline-block;
            width: 130px;
            height: 27px;
        }

        .send-email-parent {
            position: relative;
            border-radius: 20px;
            background-color: var(--color-white);
            width: 100%;
            height: 479px;
            overflow: hidden;
            text-align: left;
            font-size: 40px;
            color: #000;
            font-family: var(--font-rubik);
        }

        #loading-bar-spinner.spinner::backdrop {
            background-color: rgba(0, 0, 0, .3);
            backdrop-filter: blur(4px);
        }

        #loading-bar-spinner.spinner {
            display: none;
            left: 50%;
            margin-left: -20px;
            top: 50%;
            margin-top: -20px;
            position: absolute;
            z-index: 19 !important;
            -webkit-animation: loading-bar-spinner 400ms linear infinite;
            animation: loading-bar-spinner 400ms linear infinite;
        }

        #loading-bar-spinner.spinner .spinner-icon {
            width: 40px;
            height: 40px;
            border: solid 4px transparent;
            border-top-color: #ff6e24 !important;
            border-left-color: #ff6e24 !important;
            border-radius: 50%;
        }

        .spinner::backdrop {
            background-color: rgba(0, 0, 0, .3);
            backdrop-filter: blur(4px);
        }

        @-webkit-keyframes loading-bar-spinner {
            0% {
                transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes loading-bar-spinner {
            0% {
                transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        .hovpic {
            z-index: 9999;
            transition: all 0.5s ease-in-out;
        }

        .hovpic:hover {
            transform: scale(3, 3);
        }

        .container {
            padding-bottom: 20px;
            margin-right: 0px;
        }

        .input-text:focus {
            box-shadow: 0px 0px 0px;
            border-color: #fd7e14;
            outline: 0px;
        }

        .form-control {
            border: 1px solid #fd7e14;
        }

    
    </style>
</head>

<body>


    <div class="employeemanagement" id="submitBtn">
        <div class="bg17"></div>
        <img class="employeemanagement-child" alt="" src="./public/rectangle-1@2x.png" />

        <img class="employeemanagement-item" alt="" src="./public/rectangle-2@2x.png" />

        <img style="z-index:9999;" class="logo-1-icon17" alt="" src="./public/logo-1@2x.png" />

        <a class="anikahrm17" href="./index.php" id="anikaHRM">
            <span>Anika</span>
            <span class="hrm17">HRM</span>
        </a>
        <a class="employee-management4" href="./index.php" id="employeeManagement">Employee Management
        </a>
        <a style="display: block; left: 90%; margin-top: 5px; font-size: 27px;" href="./employee-dashboard.php"
            class="employee-management4" id="employeeManagement"></a>
        <button class="employeemanagement-inner"></button>
        <a href="logout.php">
            <div class="logout17">Logout</div>
        </a>
        <a class="leaves17" href="./leave-management.php" id="leaves">Leaves</a>
        <a class="onboarding21" id="onboarding">Onboarding</a>
        <a class="attendance17" href="./attendence.php" id="attendance">Attendance</a>
        <a href="./Payroll/payroll.php" class="payroll17">Payroll</a>
        <div class="reports17">Reports</div>
        <a class="fluent-mdl2leave-user17" id="fluentMdl2leaveUser">
            <img class="vector-icon88" alt="" src="./public/vector.svg" />
        </a>
        <a class="fluentperson-clock-20-regular17" id="fluentpersonClock20Regular">
            <img class="vector-icon89" alt="" src="./public/vector1.svg" />
        </a>
        <img class="uitcalender-icon17" alt="" src="./public/uitcalender.svg" />

        <img class="arcticonsgoogle-pay17" alt="" src="./public/arcticonsgooglepay.svg" />

        <img class="streamlineinterface-content-c-icon17" alt=""
            src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />


        <img class="employeemanagement-child2" alt="" src="./public/rectangle-4@2x.png" />

        <a class="dashboard17" href="./index.php" id="dashboard">Dashboard</a>
        <a class="fluentpeople-32-regular17">
            <img class="vector-icon90" alt="" src="./public/vector2.svg" />
        </a>
        <a class="employee-list17">Employee List</a>
        <a class="akar-iconsdashboard17" href="./index.php" id="akarIconsdashboard">
            <img class="vector-icon91" alt="" src="./public/vector3.svg" />
        </a>
        <div class="rectangle-parent27" style="overflow:auto; width:calc(100% - 420px); height: 830px; margin-top:-60px; margin-left: -100px;">
            

<!-- Modal toggle -->
<button style="float: right;" data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
    + Create a new Travel Log
  </button>
  
  <!-- Main modal -->
  <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative p-4 w-full max-w-2xl max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Travel Log Form
                  </h3>
                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                      </svg>
                      <span class="sr-only">Close modal</span>
                  </button>
              </div>
              <div class="p-4 md:p-5 space-y-4">
                    

              <form class="max-w-2xl" id="modalForm">
    <div class="mb-3">
      <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Voucher No.</label>
      <input type="text" id="email" name="voucherno" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter voucher no" required />
    </div>
    <div class="mb-3">
      <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Employee Name</label>
      <select name="empname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                <option value="">--select--</option>
                <?php
        $sql = "SELECT empname, empemail,emp_no FROM emp WHERE empstatus=0 ORDER BY emp_no asc";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {

            echo "<option value='" . $row["empname"] ."'>" . $row["empname"] . "</option>";
          }
        } else {
          echo "0 results";
        }

        ?>
            </select>
    </div>
    <div class="mb-3">
      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">From City</label>
      <select name="from_city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="">
      <option value="">--select--</option>
                <optgroup label="Tier 1 Cities">
                     <option value="Gurugram">Gurugram</option>
        <option value="Mumbai">Mumbai</option>
        <option value="Delhi">Delhi</option>
        <option value="Bangalore">Bangalore</option>
        <option value="Hyderabad">Hyderabad</option>
        <option value="Chennai">Chennai</option>
        <option value="Kolkata">Kolkata</option>
        <option value="Pune">Pune</option>
    </optgroup>
    <optgroup label="Tier 2 Cities">
    <option value="Visakhapatnam">Visakhapatnam</option>
        <option value="Ahmedabad">Ahmedabad</option>
        <option value="Coimbatore">Coimbatore</option>
        <option value="Indore">Indore</option>
        <option value="Jaipur">Jaipur</option>
        <option value="Kochi">Kochi</option>
        <option value="Lucknow">Lucknow</option>
        <option value="Nagpur">Nagpur</option>
        <option value="Patna">Patna</option>
        <option value="Vadodara">Vadodara</option>
    </optgroup>
    <optgroup label="Tier 3 Cities">
        <option value="Agra">Agra</option>
        <option value="Bhubaneswar">Bhubaneswar</option>
        <option value="Guwahati">Guwahati</option>
        <option value="Jalandhar">Jalandhar</option>
        <option value="Jammu">Jammu</option>
        <option value="Kanpur">Kanpur</option>
        <option value="Madurai">Madurai</option>
        <option value="Mysore">Mysore</option>
        <option value="Ranchi">Ranchi</option>
        <option value="Trivandrum">Trivandrum</option>
    </optgroup>
            </select>
    </div>
    <div class="mb-3">
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">To City</label>
       <select name="to_city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="">
       <option value="">--select--</option>
                <optgroup label="Tier 1 Cities">
                     <option value="Gurugram">Gurugram</option>
        <option value="Mumbai">Mumbai</option>
        <option value="Delhi">Delhi</option>
        <option value="Bangalore">Bangalore</option>
        <option value="Hyderabad">Hyderabad</option>
        <option value="Chennai">Chennai</option>
        <option value="Kolkata">Kolkata</option>
        <option value="Pune">Pune</option>
    </optgroup>
    <optgroup label="Tier 2 Cities">
    <option value="Visakhapatnam">Visakhapatnam</option>
        <option value="Ahmedabad">Ahmedabad</option>
        <option value="Coimbatore">Coimbatore</option>
        <option value="Indore">Indore</option>
        <option value="Jaipur">Jaipur</option>
        <option value="Kochi">Kochi</option>
        <option value="Lucknow">Lucknow</option>
        <option value="Nagpur">Nagpur</option>
        <option value="Patna">Patna</option>
        <option value="Vadodara">Vadodara</option>
     
    </optgroup>
    <optgroup label="Tier 3 Cities">
        <option value="Agra">Agra</option>
        <option value="Bhubaneswar">Bhubaneswar</option>
        <option value="Guwahati">Guwahati</option>
        <option value="Jalandhar">Jalandhar</option>
        <option value="Jammu">Jammu</option>
        <option value="Kanpur">Kanpur</option>
        <option value="Madurai">Madurai</option>
        <option value="Mysore">Mysore</option>
        <option value="Ranchi">Ranchi</option>
        <option value="Trivandrum">Trivandrum</option>
    </optgroup>
            </select> 
    </div>
      <div class="mb-3">
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Boarding</label>
        <input type="date" id="password" name="boarding_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
      </div>
      <div class="mb-3">
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departure</label>
        <input type="date" id="password" name="departure_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
      </div>
      <div class="mb-3">
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Duration</label>
        <select name="duration" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="">
            <option value="">--select--</option>
            <option value="less than 12 Hrs"> less than 12 Hrs</option>
            <option value="Exceeding 12 Hrs less than 24 Hrs"> Exceeding 12 Hrs less than 24 Hrs</option>
            <option value="Exceeding 24 Hrs"> Exceeding 24 Hrs</option>
        </select>
        <div class="mb-3">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Travel by</label>
            <select name="mode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="">
                <option value="">--select--</option>
                <option value="Railways"> Railways</option>
                <option value="Airways"> Airways</option>
                <option value="Roadways"> Roadways</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Policy Applicable</label>
           <select name="policies_policy" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                <option value="">--select--</option>
                <?php
        $sql = "SELECT policy_title FROM policies_policy WHERE status=1 ";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {

            echo "<option value='" . $row["policy_title"] . "'>" . $row["policy_title"] . "</option>";
          }
        } else {
          echo "0 results";
        }

        ?>
            </select>
        </div>
          <div class="mb-3">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ticket Cost</label>
            <input type="text" id="password" name="cost" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
          </div>
          <div class="mb-3">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Trans No.</label>
            <input type="text" id="password" name="transno" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
          </div>
          <div class="mb-3">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">Upload Ticket</label>
  <input name="ticket" accept=".jpeg, .jpg, .png .pdf" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="user_avatar" type="file">
          </div>
      </div>

  
              </div>
              <!-- Modal footer -->
              <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                  <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                  <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
              </div>
              </form>
          </div>
      </div>
  </div>
  

<div class="relative overflow-x-auto" style="margin-top: 50px;">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Employee name
                </th>
                <th scope="col" class="px-6 py-3">
                    From City
                </th>
                <th scope="col" class="px-6 py-3">
                    To City
                </th>
                <th scope="col" class="px-6 py-3">
                    Boarding
                </th>
                <th scope="col" class="px-6 py-3">
                    Departure
                </th>
                <th scope="col" class="px-6 py-3">
                    Duration
                </th>
                <th scope="col" class="px-6 py-3">
                    Travel By
                </th>
                <th scope="col" class="px-6 py-3">
                    Ticket Cost
                </th>
                <th scope="col" class="px-6 py-3">
                    Policy Applicable
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    View Ticket
                </th>
            </tr>
        </thead>
        <?php
                        $sql = "SELECT * FROM travel_voucher ";
                        $que = mysqli_query($con, $sql);
                        while ($result = mysqli_fetch_assoc($que)) {
                        ?>
        <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                <?php echo $result['empname']; ?>
                </th>
                <td class="px-6 py-4">
                <?php echo $result['from_city']; ?>
                </td>
                <td class="px-6 py-4">
                <?php echo $result['to_city']; ?>
                </td>
                <td class="px-6 py-4">
                <?php echo $result['boarding_date']; ?>
                </td>
                <td class="px-6 py-4">
                <?php echo $result['departure_date']; ?>
                </td>
                <td class="px-6 py-4">
                <?php echo $result['duration']; ?>
                </td>
                <td class="px-6 py-4">
                <?php echo $result['mode']; ?>
                </td>
                <td class="px-6 py-4">
                <?php echo $result['cost']; ?>
                </td>
                <td class="px-6 py-4">
                <?php echo $result['policies_policy']; ?>
                </td>
                <td class="px-6 py-4">
                <?php
            if (isset($result['status']) && $result['status'] == 1) {
                echo 'Approved';
            } else if (isset($result['status']) && $result['status'] == 2) {
                echo 'Rejected';
            } else {
                echo 'Pending for Approval';
            }
            ?>
                </td>
                <td class="px-6 py-4">
                    <a href="print_voucher.php?voucherno=<?php echo urlencode($result['voucherno']); ?>" target="_blank"><img src="./public/images-removebg-preview.png" width="25px" alt=""></a>
                </td> 
            </tr>
            
        </tbody>
        <?php } ?>
    </table>
</div>

        </div>
        <img class="tablerlogout-icon17" alt="" src="./public/tablerlogout.svg" />

        <a class="uitcalender17" id="uitcalender">
            <img class="vector-icon92" alt="" src="./public/vector4.svg" />
        </a>
       


     
    </div>
    <div id="loading-bar-spinner" class="spinner">
        <div class="spinner-icon"></div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"></script>

    <script>
    $(document).ready(function() {
        $("#modalForm").submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: "POST",
                url: "insert_voucher.php",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response); // Log the response for debugging

                    Swal.fire({
                        icon: 'success',
                        title: 'Done!',
                        text: response,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'travellog.php';
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr); // Log the error for debugging
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'There was an error processing your request.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>

    <script>
        var anikaHRM = document.getElementById("anikaHRM");
        if (anikaHRM) {
            anikaHRM.addEventListener("click", function (e) {
                window.location.href = "./index.php";
            });
        }

        var employeeManagement = document.getElementById("employeeManagement");
        if (employeeManagement) {
            employeeManagement.addEventListener("click", function (e) {
                window.location.href = "./index.php";
            });
        }

        var leaves = document.getElementById("leaves");
        if (leaves) {
            leaves.addEventListener("click", function (e) {
                window.location.href = "./leave-management.php";
            });
        }

        var onboarding = document.getElementById("onboarding");
        if (onboarding) {
            onboarding.addEventListener("click", function (e) {
                window.location.href = "./onboarding.php";
            });
        }

        var attendance = document.getElementById("attendance");
        if (attendance) {
            attendance.addEventListener("click", function (e) {
                window.location.href = "./attendence.php";
            });
        }

        var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
        if (fluentMdl2leaveUser) {
            fluentMdl2leaveUser.addEventListener("click", function (e) {
                window.location.href = "./onboarding.php";
            });
        }

        var fluentpersonClock20Regular = document.getElementById(
            "fluentpersonClock20Regular"
        );
        if (fluentpersonClock20Regular) {
            fluentpersonClock20Regular.addEventListener("click", function (e) {
                window.location.href = "./leave-management.php";
            });
        }

        var dashboard = document.getElementById("dashboard");
        if (dashboard) {
            dashboard.addEventListener("click", function (e) {
                window.location.href = "./index.php";
            });
        }

        var akarIconsdashboard = document.getElementById("akarIconsdashboard");
        if (akarIconsdashboard) {
            akarIconsdashboard.addEventListener("click", function (e) {
                window.location.href = "./index.php";
            });
        }

        var link = document.getElementById("link");
        if (link) {
            link.addEventListener("click", function (e) {
                window.location.href = "./employee-overview.php";
            });
        }

        var mohanReddy = document.getElementById("mohanReddy");
        if (mohanReddy) {
            mohanReddy.addEventListener("click", function (e) {
                window.location.href = "./employee-overview.php";
            });
        }

        var webDeveloper = document.getElementById("webDeveloper");
        if (webDeveloper) {
            webDeveloper.addEventListener("click", function (e) {
                window.location.href = "./employee-overview.php";
            });
        }

        var prabhdeepSinghMaan = document.getElementById("prabhdeepSinghMaan");
        if (prabhdeepSinghMaan) {
            prabhdeepSinghMaan.addEventListener("click", function (e) {
                window.location.href = "./employee-overview.php";
            });
        }

        var iT = document.getElementById("iT");
        if (iT) {
            iT.addEventListener("click", function (e) {
                window.location.href = "./employee-overview.php";
            });
        }

        var active = document.getElementById("active");
        if (active) {
            active.addEventListener("click", function (e) {
                window.location.href = "./employee-overview.php";
            });
        }

        var uitcalender = document.getElementById("uitcalender");
        if (uitcalender) {
            uitcalender.addEventListener("click", function (e) {
                window.location.href = "./attendence.php";
            });
        }

        var typcnplus = document.getElementById("typcnplus");
        if (typcnplus) {
            typcnplus.addEventListener("click", function (e) {
                window.location.href = "./add-employeee.php";
            });
        }

        var addEmployee = document.getElementById("addEmployee");
        if (addEmployee) {
            addEmployee.addEventListener("click", function (e) {
                window.location.href = "./add-employeee.php";
            });
        }

        var frameContainer1 = document.getElementById("frameContainer1");
        if (frameContainer1) {
            frameContainer1.addEventListener("click", function (e) {
                window.location.href = "./add-employeee.php";
            });
        }
    </script>
</body>

</html>