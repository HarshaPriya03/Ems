<?php

$con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");

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

  <link rel="stylesheet" href="../css/global.css" />
  <link rel="stylesheet" href="../css/attendence.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">
  <style>
    .rectangle-div {
      position: absolute;
      /* top: 136px; */
      border-radius: 20px;
      background-color: var(--color-white);
      width: 675px;
      height: 400px;
    }

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

    /* Hourglass animation */
    #hourglass {
      display: none;
      color: #007bff;
      opacity: 1;
      font-size: 5rem;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 9999;
    }

    #hourglass i {
      opacity: 0;
      animation: hourglass 2.4s ease-in infinite, hourglass-spin 2.4s ease-out infinite;
    }

    #hourglass>i:nth-child(1) {
      color: #F9810E;
      animation-delay: 0s, 0s;
    }

    #hourglass>i:nth-child(2) {
      color: #ffc400;
      animation-delay: 0.6s, 0s;
    }

    #hourglass>i:nth-child(3) {
      color: #ffab00;
      animation-delay: 1.2s, 0s;
    }

    #hourglass>i:nth-child(4) {
      color: #F9810E;
      animation-delay: 1.8s, 0s;
    }

    #hourglass>i:nth-child(4) {
      animation: hourglass-end 2.2s ease-in infinite, hourglass-spin 2.2s ease-out infinite;
    }

    #hourglass>i:nth-child(5) {
      color: #1E429F !important;
      opacity: 1;
      animation: hourglass-spin 2.2s ease-out infinite;
    }

    @keyframes hourglass {
      0% {
        opacity: 1;
      }

      24% {
        opacity: 0.9;
      }

      26% {
        opacity: 0;
      }
    }

    @keyframes hourglass-end {
      0% {
        opacity: 0;
      }

      70% {
        opacity: 0;
      }

      75% {
        opacity: 1;
      }

      100% {
        opacity: 1;
      }
    }

    @keyframes hourglass-spin {
      75% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(180deg);
      }
    }

    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 9998;
      display: none;
    }
  </style>
</head>

<body>
  <?php
  $servername = "localhost";
  $username = "Anika12";
  $password = "Anika12";
  $dbname = "ems";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM payroll_schedule WHERE status != 8 LIMIT 1";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $smonth = $row["smonth"];
    $sdate = $row["sdate"];
  } else {
    $smonth = "No month found with status = 0";
  }


  // $currentDate = new DateTime();
  // list($month, $year) = explode(" ", $smonth);

  // $monthNumber = date('m', strtotime($month));

  // $targetDate = new DateTime("$year-$monthNumber-$sdate");

  // if ($targetDate > $currentDate) {
  //     $interval = $currentDate->diff($targetDate);
  //     $remainingDays = $interval->days;
  // } else {
  //     $remainingDays = 0;
  // }
  $currentDate = new DateTime();

  list($month, $year) = explode(" ", $smonth);

  $monthNumber = date('m', strtotime($month));

  $targetDate = new DateTime("$year-$monthNumber-$sdate");

  $targetDate->modify('+1 month');

  if ($targetDate > $currentDate) {
    $interval = $currentDate->diff($targetDate);
    $remainingDays = $interval->days;
  } else {
    $remainingDays = 0;
  }

  ?>
  <div class="attendence4">
    <div class="bg14"></div>
    <div class="rectangle-parent23" style="margin-top: -60px; margin-left: -25px;">
      <div style="background-color: #f4f1fa; border: 1px solid #dadada; height: 230px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
        <p style="position: absolute; left: 20px; top: 20px; font-size: 18px; color: #4d4d4d;">Payroll Processing for Pay Period:
          <span style="color: #ff8758;"> <?php echo $smonth; ?></span>
        </p>
        <a href="p1">
        </a>

        <div style="display: flex; gap: 5px; background-color: white; width: 280px; border-radius: 10px; position: absolute; top: 10px; right: 22px; padding: 7px;">
          <img src="../public/timer.png" width="30px" height="30px" style="margin-top: px;" alt="">
          <p style="font-size: 18px; color: #4d4d4d; "> <?php echo $remainingDays; ?> Days Until Next Payrun</p>
        </div>
        <div style="background-color: white; width: 88.2%; left: 5%; position: absolute; top: 65px; height: 150px; border-radius: 10px;">
          <div style="background-color: #EFEFFB; width: 300px; height: 130px; border-radius: 10px; position: absolute; left: 10px;top: 10px;">
            <p style="color: #4d4d4d; position: absolute; top: 10px; left: 10px;">Total Employee's</p>
            <?php
            $sql4 = "SELECT COUNT(*) as count FROM emp WHERE empstatus = 0";

            $result4 = $con->query($sql4);
            $row4 = $result4->fetch_assoc();
            $count4 = $row4['count'];

            $sql5 = "SELECT  max(exit_dt) AS latest_exit_dt FROM emp";

            $result4 = $con->query($sql5);
            $row4 = $result4->fetch_assoc();
            $latest_exit_dt = $row4['latest_exit_dt'];

            ?>
            <p style="color: #4d4d4d; font-weight: 400; position: absolute; top: 50px; left: 10px; font-size: 40px;"><?php echo $count4; ?></p>
            <p style="color: #4d4d4d; font-weight: 400; position: absolute; top: 110px; left: 10px; font-size: 13px;">Last Updated on:<?php echo $latest_exit_dt; ?></p>
            <img src="../public/totalemop.png" width="130px" style="position: absolute; right: 0; top: 5px;" alt="">
          </div>
          <div style="background-color: #EFEFFB; width: 300px; height: 130px; border-radius: 10px; position: absolute; left: 320px;top: 10px;">
            <p style="color: #4d4d4d; position: absolute; top: 10px; left: 10px;">LOP Day's</p>
            <?php
            $sql = "SELECT SUM(flop) AS total_flop,MAX(created) as created FROM payroll_lop";
            $result = $con->query($sql);
            $row = $result->fetch_assoc();
            $flop = $row['total_flop'];
            ?>
            <p style="color: #4d4d4d; font-weight: 400; position: absolute; top: 50px; left: 10px; font-size: 40px;"><?php echo $flop; ?></p>
            <p style="color: #4d4d4d; font-weight: 400; position: absolute; top: 110px; left: 10px; font-size: 13px;">Last Updated on: <?php echo date('d-m-Y H:i:s', strtotime('+5 hours 30 minutes', strtotime($row['created']))); ?></p>
            <img src="../public/LOPdays.png" width="90px" style="position: absolute; right: 10px; top: 25px;" alt="">
          </div>
          <div style="background-color: #EFEFFB; width: 300px; height: 130px; border-radius: 10px; position: absolute; left: 630px;top: 10px;">
            <p style="color: #4d4d4d; position: absolute; top: 10px; left: 10px;">Loans Amount</p>
            <?php
            $sql = "SELECT SUM(loamt) AS total_loamt,MAX(created) as created FROM payroll_loan";
            $result = $con->query($sql);
            $row = $result->fetch_assoc();
            $loan = $row['total_loamt'];
            ?>
            <p style="color: #4d4d4d; font-weight: 400; position: absolute; top: 50px; left: 10px; font-size: 40px;">₹ <?php echo $loan; ?></p>
            <p style="color: #4d4d4d; font-weight: 400; position: absolute; top: 110px; left: 10px; font-size: 13px;">Last Updated on: <?php echo date('d-m-Y H:i:s', strtotime('+5 hours 30 minutes', strtotime($row['created']))); ?></p>
            <img src="../public/loansamt.png" width="90px" style="position: absolute; right: 10px; top: 30px;" alt="">
          </div>
          <div style="background-color: #EFEFFB; width: 300px; height: 130px; border-radius: 10px; position: absolute; left: 940px;top: 10px;">
            <p style="color: #4d4d4d; position: absolute; top: 10px; left: 10px;">Total Deduction's</p>
            <?php
            $sql = "SELECT SUM(damt) AS total_damt,MAX(created) as created FROM payroll_misc";
            $result = $con->query($sql);
            $row = $result->fetch_assoc();
            $misc = $row['total_damt'];
            ?>
            <p style="color: #4d4d4d; font-weight: 400; position: absolute; top: 50px; left: 10px; font-size: 40px;">₹ <?php echo $misc; ?></p>
            <p style="color: #4d4d4d; font-weight: 400; position: absolute; top: 110px; left: 10px; font-size: 13px;">Last Updated on: <?php echo date('d-m-Y H:i:s', strtotime('+5 hours 30 minutes', strtotime($row['created']))); ?></p>
            <img src="../public/dedtotal.png" width="90px" style="position: absolute; right: 10px; top: 30px;" alt="">
          </div>
        </div>
      </div>
      <div style="background-color: #f4f1fa; border: 1px solid #dadada; height: 620px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); margin-top: 10px; width: 69%; position: absolute; left: 0;">
        <div>
          <div style="background-color: #ffffff; width: 473px; border-radius: 10px; position: absolute; left: 10px; top: 10px; display: flex; align-items: center; justify-content: center; height: 294px;">
            <div style="width: 400px;">
              <canvas id="myChart"></canvas>
            </div>
          </div>
          <div style="background-color: #ffffff; width: 473px; border-radius: 10px; position: absolute; right: 10px; top: 10px; display: flex; align-items: center; justify-content: center; height: 294px;">
            <div style="width: 290px;">
              <canvas id="myChart1"></canvas>
            </div>
          </div>
          <div style="background-color: #ffffff; width: 473px; border-radius: 10px; position: absolute; left: 10px; bottom: 10px; display: flex; align-items: center; justify-content: center; height: 294px;">
            <div style="width: 290px;">
              <canvas id="myChart2"></canvas>
            </div>
          </div>
          <div style="background-color: #ffffff; width: 473px; border-radius: 10px; position: absolute; right: 10px; bottom: 10px; display: flex; align-items: center; justify-content: center; height: 294px;">
            <div style="width: 290px;">
              <canvas id="myChart3"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div style="background-color: #f4f1fa; border: 1px solid #dadada; height: 130px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); margin-top: 10px; width: 30%; position: absolute; right: 0;">
        <div class="border border-blue-300 dark:border-blue-800 bg-gray-50 dark:bg-gray-800" style=" position: absolute; right: 10px; top: 0px; border-radius: 10px;"><img src="../public/initiate.png" width="110px" alt=""></div>
        <div style="position:absolute;width:70%;height:95px;" id="alert-additional-content-1" class="ml-1 p-1.5 text-blue-800 border border-blue-300 rounded-lg bg-gray-50 dark:bg-gray-800  dark:text-blue-400 dark:border-blue-800" role="alert">
          <div class="flex items-center">
            <img src="../public/cpu.svg" style="height:30px;">
            <h3 class="text-lg font-medium ml-1">Payroll Run</h3>
          </div>
          <div class="mt-1 mb-4 text-sm ml-2">
            Click this button to start the process
          </div>
          <div class="flex">
            <a id="createPayrunBtn" href="#" style="position: absolute; top: 50px; scale: 0.6; left: -20px;" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded text-lg px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
              Confirm Payrun</a>
          </div>

        </div>

        <div style="position:relative;left: 5px; top: 97px !important;width:97%;" class="p-1 flex items-center border border-blue-300 rounded-lg text-sm text-gray-800 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300" role="alert">
          <img src="../public/megaphone.svg" style="height:20px;">&nbsp;&nbsp;
          <p style="font-size: 12px;"> Stay tuned to this area for Payrun progress and updates!</p>

        </div>
      </div>
      <div id="hourglass" class="fa-stack fa-4x">
        <i class="fa fa-stack-1x fa-hourglass-start"></i>
        <i class="fa fa-stack-1x fa-hourglass-half"></i>
        <i class="fa fa-stack-1x fa-hourglass-end"></i>
        <i class="fa fa-stack-1x fa-hourglass-end"></i>
        <i class="fa fa-stack-1x fa-hourglass-o"></i>
      </div>
      <div class="overlay"></div>
      <div style="background-color: #f4f1fa; border: 1px solid #dadada; height: 480px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); margin-top: 148px; width: 30%; position: absolute; right: 0;">
        <p style="position: absolute; left: 10px; top: 10px; color: #4d4d4d; font-weight: 500;">PAYROLL MODULES</p>
        <hr style="color: #292929; margin-top: 44px; width: 97%; margin-left: 5px;">
        <div style="height: 430px; overflow-y: auto;">
          <div style="display: flex;">

            <a href="acc_salarytable.php">
              <div style="background-color: #eeeeee; border: 1px solid #a8a8a8; width: 190px; height: 130px; margin-left: 10px; margin-top: 20px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.4);">
                <img src="../public/salarystructable-removebg-preview.png" style="width: 80px; height: 80px; margin-left: 45px;" alt="">
                <p style="text-align: center; font-size: 18px; color: #4d4d4d;">Salary Table</p>
              </div>
            </a>
            <a href="#">
              <div style="background-color: #eeeeee; border: 1px solid #a8a8a8; width: 190px; height: 130px; margin-left: 17px; margin-top: 20px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.4);">
                <img src="../public/salarystruc-removebg-preview.png" style="width: 80px; height: 80px; margin-left: 55px;" alt="">
                <p style="text-align: center; font-size: 18px; color: #4d4d4d;">Statements</p>
              </div>
            </a>
          </div>
          <div style="display: flex; margin-top: -12px;">
            <a href="acc_lop.php">
              <div style="background-color: #eeeeee; border: 1px solid #a8a8a8; width: 190px; height: 130px; margin-left: 17px; margin-top: 20px; padding-top: 10px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.4);">
                <img src="../public/lop123-removebg-preview.png" style="width: 70px; height: 70px; margin-left: 55px;" alt="">
                <p style="text-align: center; font-size: 18px; color: #4d4d4d;">Loss of Pay</p>
              </div>
            </a>
            <a href="acc_bonus.php">
              <div style="background-color: #eeeeee; border: 1px solid #a8a8a8; width: 190px; height: 130px; margin-left: 10px; margin-top: 20px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.4);">
                <img src="../public/bonus3d-removebg-preview.png" style="width: 80px; height: 80px; margin-left: 50px;" alt="">
                <p style="text-align: center; font-size: 18px; color: #4d4d4d;">Bonus</p>
              </div>
            </a>
          </div>
          <div style="display: flex; margin-top: -12px;">
            <a href="acc_misc.php">
              <div style="background-color: #eeeeee; border: 1px solid #a8a8a8; width: 190px; height: 130px; margin-left: 17px; margin-top: 20px; padding-top: 10px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.4);">
                <img src="../public/miscdeduct-removebg-preview.png" style="width: 70px; height: 70px; margin-left: 55px;" alt="">
                <p style="text-align: center; font-size: 18px; color: #4d4d4d;">Misc. Deductions</p>
              </div>
            </a>
            <a href="acc_loans.php">
              <div style="background-color: #eeeeee; border: 1px solid #a8a8a8; width: 190px; height: 130px; margin-left: 10px; margin-top: 20px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.4);">
                <img src="../public/loans-removebg-preview.png" style="width: 80px; height: 80px; margin-left: 50px;" alt="">
                <p style="text-align: center; font-size: 18px; color: #4d4d4d;">Loans</p>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <img class="attendence-child" alt="" src="../public/rectangle-1@2x.png" />

    <img class="attendence-item" alt="" src="../public/rectangle-2@2x.png" />

    <img class="logo-1-icon14" alt="" src="../public/logo-1@2x.png" />
    <a class="anikahrm14" href="../../index.php" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="./index.html" id="attendenceManagement">Payroll Management</a>
    <button class="attendence-inner"></button>
    <a href="../../logout.php" style="margin-top:-5px;" class="logout14">Logout</a>
    <a class="payroll14" href="./acc_payroll.php" style="color: white; z-index:9999; margin-top:-200px">Payroll</a>
    <div class="reports14" style="margin-top:-70px;">Reports</div>
    <img class="uitcalender-icon14" alt="" src="../public/uitcalender.svg" />

    <img style="-webkit-filter: grayscale(1) invert(1);
      filter: grayscale(1) invert(1); z-index:9999; margin-top:-200px" class="arcticonsgoogle-pay14" alt="" src="../public/arcticonsgooglepay.svg" />

    <img class="streamlineinterface-content-c-icon14" style="margin-top:-70px;" alt="" src="../public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg" />

     

    <img class="attendence-child2" alt="" style="margin-top: -130px;" src="../public/rectangle-4@2x.png" />

    <!--<a class="dashboard14" href="../index.php" style="z-index: 99999;" id="dashboard">Dashboard</a>-->
    <!--<a class="fluentpeople-32-regular14" style="z-index: 99999;" id="fluentpeople32Regular">-->
    <!--    <img class="vector-icon73" alt="" src="../public/vector7.svg" />-->
    <!--</a>-->
    <!--<a class="employee-list14" href="../employee-management.php" style="z-index: 99999;" id="employeeList">Employee List</a>-->
    <!--<a class="akar-iconsdashboard14" style="z-index: 99999;" href="../index.php" id="akarIconsdashboard">-->
    <!--    <img class="vector-icon74" alt="" src="../public/vector3.svg" />-->
    <!--</a>-->
    <img class="tablerlogout-icon14" style="z-index: 99999;" alt="" src="../public/tablerlogout.svg" />

    <a class="leaves14" id="leaves" style="z-index: 99999; margin-top:70px;" href="./leave-management.php">Leaves</a>
    <a class="fluentperson-clock-20-regular14" style=" margin-top:70px;" id="fluentpersonClock20Regular">
      <img class="vector-icon75" style="z-index: 99999;" alt="" src="../public/vector1.svg" />
    </a>
    <!--<a class="onboarding16" style="z-index: 99999;" id="onboarding" href="../onboarding.php">Onboarding</a>-->
    <!--<a class="fluent-mdl2leave-user14" style="z-index: 99999;" id="fluentMdl2leaveUser">-->
    <!--    <img class="vector-icon76" alt="" src="../public/vector.svg" />-->
    <!--</a>-->
    <a class="attendance14" href="./attendence.php" style="color: black; z-index: 99999;">Attendance</a>
    <a class="uitcalender14">
      <img class="vector-icon77" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1); z-index: 99999;" alt="" src="../public/vector11.svg" />
    </a>
    <div class="oouinext-ltr3"></div>
  </div>
</body>
<script>
  document.getElementById('createPayrunBtn').addEventListener('click', function(e) {
    e.preventDefault();

    // Show loading hourglass
    document.getElementById('hourglass').style.display = 'block';
    // Show overlay
    document.querySelector('.overlay').style.display = 'block';

    // Wait for 5 seconds
    setTimeout(function() {
      // Redirect to payrun.php
      window.location.href = 'acc_payrun.php';
    }, 5000);
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr'],
      datasets: [{
        label: 'Payout Data',
        data: [12, 19, 3, 5, 2, 3],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
  const ctx1 = document.getElementById('myChart1');

  new Chart(ctx1, {
    type: 'doughnut',
    data: {
      labels: ['Net Pay', 'HRA', 'OA', 'Basic Pay'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
  const ctx2 = document.getElementById('myChart2');

  new Chart(ctx2, {
    type: 'polarArea',
    data: {
      labels: ['EPF', 'ESI', 'LOANS', 'MISC'],
      datasets: [{
        label: '# of Votes',
        data: [12, 19, 3, 5],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
  const ctx3 = document.getElementById('myChart3');

  new Chart(ctx3, {
    type: 'radar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr'],
      datasets: [{
        label: 'Payout Data',
        data: [12, 19, 3, 5],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

</html>