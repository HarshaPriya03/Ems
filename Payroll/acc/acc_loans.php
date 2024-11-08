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
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
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
  </style>
</head>

<body>
  <div class="attendence4">
    <div class="bg14"></div>
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

    <div class="rectangle-parent23" style="margin-left: 40px; margin-top:-60px;">
      <div class="rectangle-div"></div>
      <?php
      $sql4 = "SELECT COUNT(id) AS total_id FROM payroll_loan";
      $result = mysqli_query($con, $sql4);
      $row = mysqli_fetch_assoc($result);
      $total_id = $row['total_id'];

      $sql3 = "SELECT COUNT(*) AS total_open FROM payroll_loan WHERE status = 1";
      $result = mysqli_query($con, $sql3);
      $row = mysqli_fetch_assoc($result);
      $total_open = $row['total_open'];

      $sql2 = "SELECT COUNT(*) AS total_close FROM payroll_loan WHERE status = 0";
      $result = mysqli_query($con, $sql2);
      $row = mysqli_fetch_assoc($result);
      $total_close = $row['total_close'];
      ?>
      <p style="position: absolute; margin-left: 30px; top: 10px; font-size: 20px;">Total Loan Amount</p>
      <p style="position: absolute; margin-left: 30px; top: 50px; font-size: 30px; font-weight: 700;">₹ <?php echo $sum; ?></p>
      <p style="position: absolute; margin-left: 30px; top: 130px; font-size: 15px; width: 200px; color: rgb(141, 141, 141);">Updated on <?php echo date('d-m-Y H:i:s', strtotime('+5 hours 30 minutes', strtotime($last_created))); ?></p>
      <img src="../public/total.png" style="position: absolute; left: 260px; top: 70px;" width="130px" alt="">
      <div class="rectangle-div" style="margin-left: 420px;"></div>
      <p style="position: absolute; margin-left: 450px; top: 10px; font-size: 20px;">Balance Amount</p>
      <p style="position: absolute; margin-left: 450px; top: 50px; font-size: 30px; font-weight: 700;">₹ <?php echo $balance; ?></p>
      <p style="position: absolute; margin-left: 450px; top: 130px; font-size: 15px; width: 200px; color: rgb(141, 141, 141);">Updated on <?php echo date('d-m-Y H:i:s', strtotime('+5 hours 30 minutes', strtotime($last_created1))); ?></p>
      <img src="../public/balances.png" style="position: absolute; left: 700px; top: 70px;" width="115px" alt="">
      <div class="rectangle-div" style="margin-left: 840px;"></div>
      <p style="position: absolute; margin-left: 870px; top: 10px; font-size: 20px;">Total Loan's Issued</p>
      <p style="position: absolute; margin-left: 870px; top: 50px; font-size: 30px; font-weight: 700;"><?php echo $total_id ?></p>
      <div style="background-color:rgb(240, 240, 240); position: absolute; margin-left: 870px; top: 100px; width:100px; scale:1.1; height:80px; border-radius:10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);">
        <img src="../public/open.png" width="50px" style="margin-left:auto; margin-right:auto;">
        <p style="font-size: 11px; font-weight: normal; display:flex; align-items:center; justify-content:center; text-align:center;">OPEN LOANS <br> <?php echo $total_open; ?></p>
      </div>
      
      <div style="background-color:rgb(240, 240, 240); position: absolute; margin-left: 990px; top: 100px; width:110px; scale:1.1; height:80px; border-radius:10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.5);">
     
      <img src="../public/close.png" width="50px" style="margin-left:auto; margin-right:auto;">
        <p style="font-size: 11px; font-weight: normal; display:flex; align-items:center; justify-content:center; text-align:center;">CLOSED LOANS <br> <?php echo $total_close; ?>
      </p>
      </div>
      <button data-tooltip-target="tooltip-right" data-tooltip-placement="right" type="button" style="position:absolute; margin-left: 1060px; top: 20px;"><img src="./public/infosa.png" width="70px;"></button>
      <!--      <div id="tooltip-right" role="tooltip" style="background-color:#ffe2c6; " class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-600">-->
      <!--    <p style="color:#ff5400; font-weight:normal;">-->
      <!--        OPEN LOANS : 3 <br/>-->
      <!--    CLOSED LOANS : 27-->
      <!--    </p>-->
      <!--    <div class="tooltip-arrow" data-popper-arrow></div>-->
      <!--</div>-->
      <!--<p style="position: absolute; margin-left: 870px; top: 130px; font-size: 15px; width: 200px; color: rgb(141, 141, 141);">Updated on 2024-02-21 09:36AM</p>-->
      <img src="../public/activeloans.png" style="position: absolute; left: 1110px; top: 75px;" width="110px" alt="">
      <!-- <p style="position: absolute; top: 210px; left: 20px; font-weight: 700;">History:</p> -->
      <button style="position: absolute; top: 210px; left: 900px;" data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
        + Create New Loan
      </button>
      <button style="position: absolute; top: 210px; left: 1080px;" id="openModalBtn" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
        EMI Deductions
      </button>
      <!-- deductions modal  -->
      <div id="modal" class="modalemi" style="background:none; border-top-left-radius:20px;border-bottom-left-radius:20px;">
        <div class="modalemi-content slide-left" style="border:none;border-top-left-radius:20px;border-bottom-left-radius:20px; background-color:#f6f5fb; ">
          <div style="display:inline-block;position:relative;">
            <div class="close"><img src="../public/rightarrow.svg"></div>
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
            <img src="../public/totalamt.png" style="position: absolute; right:10px; top: 60px;" width="120px" alt="">
          </div>
          <div class="rectangle-div" style="margin-left:500px;">
            <p style="position: absolute; top: 10px; left:10px; font-size: 20px;">Deduction's this month</p>
            <p style="position: absolute; top: 60px; left:10px; font-size: 30px; font-weight: 700;">₹ <?php echo $total_cemi ?></p>
            <p style="position: absolute; top: 130px; left:10px; font-size: 15px; width: 200px; color: rgb(141, 141, 141);">Updated on <?php echo date('d-m-Y H:i:s', strtotime('+5 hours 30 minutes', strtotime($last_created1))); ?></p>
            <img src="../public/dedamt.png" style="position: absolute; right:10px; top: 60px;" width="120px" alt="">
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
            $sql = "SELECT * FROM payroll_emi  ORDER BY ID ASC";
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
      
      <div style="margin-top: 260px;">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="width: 1240px;">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 ">
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:text-blue-800 ">
              <td colspan="9">
                <div class="inline-flex self-center items-center" style="padding:10px;">
                  <a href="print-detailsloan.php" target="_blank" class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-blue-600 rounded-lg hover:bg-blue-200 focus:ring-4 focus:outline-none dark:text-white focus:ring-blue-50 dark:bg-blue-700 dark:hover:bg-blue-600 dark:focus:ring-blue-600">
                    <svg class="w-4 h-4 text-white dark:text-white hover:text-blue-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z" />
                      <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                    </svg> <span class="text-white hover:text-blue-800 focus:ring-4  font-medium rounded-lg text-sm text-center px-1">Download</span>
                  </a>
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
        ORDER BY pl.ID ASC";
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
                      <img src="../public/emi.svg" class="cursor-pointer " style="width:60px;">
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
                <?php @include("view_loandeduct.php"); ?>
              </div>
              <!-- Modal footer -->
              <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">

                <button data-modal-hide="default-modala" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
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
                    Create a New Loan
                  </h3>
                  <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                  </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4" style="margin-left: 65px;">
                  <label for="">Employee Name:</label>
                  <select name="empname" style="width: 300px; border-radius: 5px; ">
                    <option value="" disabled selected>--Select--</option>
                    <?php
                    $servername = "localhost";
                    $username = "Anika12";
                    $password = "Anika12";
                    $dbname = "ems";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT empname FROM emp where empstatus=0 ORDER BY emp_no ASC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["empname"] . "'>" . $row["empname"] . "</option>";
                      }
                    } else {
                      echo "0 results";
                    }

                    $conn->close();
                    ?>
                  </select>
                  <label for="">LoanNo. :</label>
                  <input type="text" style="width: 300px; border-radius: 5px; margin-left: 70px;margin-top: 20px;" name="lno"><br>

                  <div style="display: flex;">
                    <label for="">Loan Amount:</label>
                    <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px; margin-left: 30px;">₹</div>
                    <input type="text" name="loamt" style="font-size: 18px; width: 243px; height: 40px; border: 1px solid rgb(185,185,185);">
                    <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                  </div>
                  <div style="background-color: rgb(247, 247, 247); width: 460px; height: 50px; border-radius:10px; display: flex;">
                    <button type="button" id="tdisbtn" onclick="setSelectedButton('0');  myFuncdet2();" style="margin-left: 10px; margin-top: 5px; height: 40px; width: 210px; border-radius: 8px;" class="backclr">To be Disbursed</button>
                    <button type="button" id="disbtn" onclick="setSelectedButton('1');  myFuncdet3();" style="margin-left: 20px; margin-top: 5px; height: 40px; width: 210px; border-radius: 8px;"><span>Disbursed</span></button>
                    <input type="hidden" id="selectedValue" name="disbursed" value="0">
                  </div>

                  <div class="remove" id="scheper1">
                    <label for="">Mode of Payment:</label>
                    <select name="mop" style="width: 290px; border-radius: 5px; ">
                      <option value="" disabled selected>--Select--</option>
                      <option value="UPI">UPI</option>
                      <option value="Cheque">Cheque</option>
                      <option value="Bank Transfer">Bank Transfer</option>
                      <option value="Card Payment">Card Payment</option>

                    </select>
                    <label for="">Transaction No. :</label>
                    <input type="text" style="width: 300px; border-radius: 5px; margin-left: 4px;margin-top: 20px;" name="tno"><br>
                    <label for="">Paid Date:</label>
                    <input type="date" style="width: 300px; border-radius: 5px; margin-left: 60px;margin-top: 20px;" name="pdate">
                  </div>

                  <div style="background-color: rgb(247, 247, 247); width: 460px; height: 50px; border-radius:10px; display: flex;">
                    <button onclick="myFuncdet11(); myFuncdet1();" type="button" id="onebtn" style=" margin-left: 10px; margin-top: 5px; height: 40px; width: 210px; border-radius: 8px;" class="backclr">One-time repayment</button>
                    <button onclick="myFuncdet();" type="button" id="emibtn" style=" margin-left: 20px; margin-top: 5px; height: 40px; width: 210px; border-radius: 8px;"><span>EMI Payment</span> </button>
                  </div>
                  <div class="remove" id="scheper">
                    <div>
                      <label for="">Loan term:</label>
                      <select name="loterm" style="width: 300px; border-radius: 5px; margin-left: 57px;">
                        <option value="" disabled selected>--Select--</option>
                        <option value="1 Month" style="display:none;">1 Month</option>
                        <option value="2 Months">2 Months</option>
                        <option value="3 Months">3 Months</option>
                        <option value="6 Months">6 Months</option>
                        <option value="9 Months">9 Months</option>
                        <option value="10 Months">10 Months</option>
                        <option value="12 Months">12 Months</option>
                      </select>
                    </div>
                    <div style="display: flex; margin-top: 20px;">
                      <label for="">EMI per Month:</label>
                      <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px; margin-left: 20px;">₹</div>
                      <input type="text" name="emi" style="font-size: 18px; width: 243px; height: 40px; border: 1px solid rgb(185,185,185);">
                      <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                    </div>
                    <label for="">Term Start Month:</label>
                    <input name="stmonth" class="datepicker-without-calendar" type="text" style="width: 290px; border-radius: 5px; margin-top: 20px;" id="datepicker">
                  </div>
                  <div style="margin-top: 20px;">
                    <label for="">Notes:</label><br>
                    <textarea name="notes" cols="47" rows="3" style="border-radius: 5px;"></textarea>
                  </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                  <button data-modal-hide="default-modal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <img class="attendence-child" alt="" src="../public/rectangle-1@2x.png" />

    <img class="attendence-item" alt="" src="../public/rectangle-2@2x.png" />

    <img class="logo-1-icon14" alt="" src="../public/logo-1@2x.png" />
    <a class="anikahrm14" href="../../index.html" id="anikaHRM">
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
          url: "view_loandeduct.php",
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
              window.location.href = 'loans.php';
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