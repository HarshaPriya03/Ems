<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
  header("Location: ../loginpage.php");
  exit();
}

// Connect to MySQL
@include 'inc/config.php';

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

// Retrieve smonth from the URL
$smonth = isset($_GET['smonth']) ? $_GET['smonth'] : '';

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  header('location:loginpage.php');
}
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
if ($user_name === '') {
  header('location:loginpage.php');
  exit();
}

$query = "SELECT * FROM user_form WHERE email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if ($row && isset($row['user_type']) && isset($row['user_type1'])) {
    $user_type = $row['user_type'];
    $user_type1 = $row['user_type1'];
    $work_location = $row['work_location'];

    if ($user_type1 !== 'admin' && $user_type !== 'user') {
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
</head>

<body>
  <div class="attendence4">


    <div class="bg14"></div>
    <div class="rectangle-parent23" style="margin-top: -40px; margin-left: -20px;">
      <div style="background-color: #f4f1fa; height: 100px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); margin-top: -40px;">
        <img src="./public/calend.png" width="90px" style="position: absolute; top: -35px; left: 10px;" alt="">
        <div style="position: absolute; left: 110px; top: -10px;">
          <label for="">Payroll Processed For </label> &nbsp;
          <input type="text" name="smonth" value="<?php echo $smonth; ?>" readonly style="border-radius: 5px;width:40%;text-align:center;" />
        </div>
      </div>
      <?php
      $dateParts = explode(' ', $smonth);
      $month = $dateParts[0];
      $year = $dateParts[1];

      $numDays = cal_days_in_month(CAL_GREGORIAN, date('n', strtotime($month)), $year);
      ?>

      <br>
      <div style="position: absolute; background-color: #fcfbff; border: 1px solid #dadada; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); width: 440px; height: 180px; border-radius: 10px;">
        <p style="font-size: 18px; color: #7e7e7e; position: absolute; left: 20px; top: 20px;">Period: <span style="font-size: 19px; color: rgb(88, 88, 88);">
            <?php echo $smonth ?></span> | <?php echo $numDays ?> Pay Days</p>
        <div style="position: absolute; left: 20px; top: 75px; display: flex; align-items: center; justify-content: center; background-color: #e4dfff; border-radius: 50%; width: 50px; height: 50px;">
          <img src="./public/Group-2.svg" width="20px" alt="">
        </div>
        <div style="position: absolute; right: 165px; top: 75px; display: flex; align-items: center; justify-content: center; background-color: #dfffef; border-radius: 50%; width: 50px; height: 50px;">
          <img src="./public/Vector-1231.svg" width="20px" alt="">
        </div>
        <div>

          <?php
          if ($work_location == 'All') {
            $sql = "SELECT SUM(total_payroll) AS total_payroll FROM (SELECT SUM(pv.payout + pv.epf1 + pv.epf2 + pv.esi1 + pv.esi2 + pv.misc + pv.pension) AS total_payroll
          FROM payroll_ss_vsp pv
          INNER JOIN payroll_schedule ps_vsp ON pv.salarymonth = ps_vsp.smonth
    WHERE salarymonth = '$smonth' 
          UNION ALL
          SELECT SUM(pg.payout + pg.epf1 + pg.epf2 + pg.esi1 + pg.esi2 + pg.misc + pg.pension) AS total_payroll
          FROM payroll_ss_ggm pg
          INNER JOIN payroll_schedule ps_ggm ON pg.salarymonth = ps_ggm.smonth
         WHERE salarymonth = '$smonth' 
          UNION ALL
          SELECT SUM(ps.sfee + ps.payout + ps.epf1 + ps.epf2 + ps.esi1 + ps.esi2 + ps.misc + ps.pension) AS total_payroll
          FROM payroll_ss_sp ps
          INNER JOIN payroll_schedule ps_sp ON ps.salarymonth = ps_sp.smonth
        WHERE salarymonth = '$smonth' 
          ) AS combined_sums";
          } elseif ($work_location == 'Gurugram') {
            $sql = "  SELECT SUM(total_payroll) AS total_payroll FROM (
                    SELECT SUM(pg.payout + pg.epf1 + pg.epf2 + pg.esi1 + pg.esi2 + pg.misc + pg.pension) AS total_payroll
                    FROM payroll_ss_ggm pg
                    INNER JOIN payroll_schedule ps_ggm ON pg.salarymonth = ps_ggm.smonth
                   WHERE salarymonth = '$smonth' 
                    UNION ALL
                    SELECT SUM(ps.payout + ps.epf1 + ps.epf2 + ps.esi1 + ps.esi2 + ps.misc + ps.pension) AS total_payroll
                    FROM payroll_ss_sp ps
                    INNER JOIN payroll_schedule ps_sp ON ps.salarymonth = ps_sp.smonth
                  WHERE salarymonth = '$smonth' 
                      ) AS combined_sums";
          } elseif ($work_location == 'Visakhapatnam') {
            $sql = "SELECT SUM(total_payroll) AS total_payroll FROM (SELECT SUM(pv.payout + pv.epf1 + pv.epf2 + pv.esi1 + pv.esi2 + pv.misc + pv.pension) AS total_payroll
                  FROM payroll_ss_vsp pv
                  INNER JOIN payroll_schedule ps_vsp ON pv.salarymonth = ps_vsp.smonth
            WHERE salarymonth = '$smonth' 
                  ) AS combined_sums";
          }

          $result = $con->query($sql);
          $row = $result->fetch_assoc();
          $total_payroll = $row['total_payroll'];
          if (($total_payroll - floor($total_payroll)) > 0.5) {
            $total_payroll = ceil($total_payroll);
          } elseif (($total_payroll - floor($total_payroll)) < 0.5) {
            $total_payroll = floor($total_payroll);
          }
          ?>

          <p style="position: absolute; left: 73px; top: 70px; font-size: 30px;">₹<?php echo $total_payroll; ?> </p>
          <p style="position: absolute; left: 76px; top: 110px; font-size: 15px; color: #7e7e7e;">PAYROLL COST</p>
        </div>
        <div>
          <?php
          if ($work_location == 'All') {
            $sql = "
              SELECT SUM(total_payout) AS total_payout FROM (
                  SELECT SUM(pv.payout) AS total_payout
                  FROM payroll_ss_vsp pv
                  INNER JOIN payroll_schedule ps_vsp ON pv.salarymonth = ps_vsp.smonth
                  WHERE pv.salarymonth = '$smonth'
                  
                  UNION ALL
                  
                  SELECT SUM(pg.payout) AS total_payout
                  FROM payroll_ss_ggm pg
                  INNER JOIN payroll_schedule ps_ggm ON pg.salarymonth = ps_ggm.smonth
                  WHERE pg.salarymonth = '$smonth'
                  
                  UNION ALL
                  
                  SELECT SUM(ps.payout) AS total_payout
                  FROM payroll_ss_sp ps
                  INNER JOIN payroll_schedule ps_sp ON ps.salarymonth = ps_sp.smonth
                  WHERE ps.salarymonth = '$smonth'
              ) AS combined_sums";
          } elseif ($work_location == 'Gurugram') {
            $sql = " SELECT SUM(total_payout) AS total_payout FROM (
                    SELECT SUM(pg.payout) AS total_payout
                    FROM payroll_ss_ggm pg
                    INNER JOIN payroll_schedule ps_ggm ON pg.salarymonth = ps_ggm.smonth
                    WHERE pg.salarymonth = '$smonth'
                    
                    UNION ALL
                    
                    SELECT SUM(ps.payout) AS total_payout
                    FROM payroll_ss_sp ps
                    INNER JOIN payroll_schedule ps_sp ON ps.salarymonth = ps_sp.smonth
                    WHERE ps.salarymonth = '$smonth'
                ) AS combined_sums";
          } elseif ($work_location == 'Visakhapatnam') {
            $sql = "SELECT   SUM(pv.payout) AS total_payout
      FROM 
          payroll_ss_vsp pv
          INNER JOIN payroll_schedule ps_vsp ON pv.salarymonth = ps_vsp.smonth
     WHERE salarymonth = '$smonth' ";
          }


          $result = $con->query($sql);
          $row = $result->fetch_assoc();
$sum = $row['total_payout'];
$sum = number_format($sum, 2, '.', '');

          ?>
          <p style="position: absolute; right: 0px; top: 70px; font-size: 30px;">₹<?php echo $sum; ?> </p>
          <p style="position: absolute; right: 15px; top: 110px; font-size: 15px; color: #7e7e7e;">EMPLOYEE'S NET PAY</p>
        </div>
      </div>
      <?php
      $sql = "SELECT paid FROM payroll_schedule WHERE smonth = '$smonth' ";
      $result = $con->query($sql);
      $row = $result->fetch_assoc();
      $paid = $row['paid'];
      $paidDate = date('d', strtotime($paid));
      $paidMonthYear = date('F Y', strtotime($paid));

      ?>
      <div style="position: absolute; background-color: rgb(255, 255, 255); box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); width: 200px; height: 180px; border-radius: 10px; margin-left: 470px; border: 1px solid #e7e7e7;">
        <p style="position: absolute; left: 60px; color: #7e7e7e; top: 20px; font-size: 18px;">PAID DATE</p>
        <p style="position: absolute; left: 77px; top: 50px; font-size: 37px; font-weight: lighter;"><?php echo $paidDate ?></p>
        <p style="position: absolute; top: 100px; font-size: 18px; border-bottom: 1px solid #e7e7e7; width: 200px; text-align: center; padding-bottom: 10px;"><?php echo $paidMonthYear ?> </p>
        <?php
        $sql4 = "SELECT paid_emp FROM payroll_schedule WHERE smonth = '$smonth' ";

        $result4 = $con->query($sql4);
        $row4 = $result4->fetch_assoc();
        $count4 = $row4['paid_emp'];
        ?>
        <p style="position: absolute; left: 46px; color: #7e7e7e; top: 145px; font-size: 15px;"><?php echo $count4; ?> EMPLOYEES</p>
      </div>



      <div style="position: absolute; background-color: #fcfbff; border: 1px solid #dadada; width: 620px; height: 43px; border-radius: 5px; margin-left: 690px; margin-top: 0px; border: 1px solid #e7e7e7; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
        <a style="margin-top: 10px; margin-left: 10px;" href="#" class="flex items-center mb-2 border-gray-200 md:pe-4 md:me-4 md:border-e md:mb-0 dark:border-gray-600">
          <svg class="w-6 h-6 text-blue-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd" />
          </svg>
        </a>
        <p style="position: absolute; color: #535353; font-size: 17px; top: 9px; left:35px;">You are advised to download these documents for future proof</p>
      </div>

      <a href="print-details_ss.php?smonth=<?php echo $smonth; ?>" target="_blank">
        <div style="position: absolute; background-color: #fcfbff; border: 1px solid #dadada; width: 220px; height: 60px; border-radius: 10px; margin-left: 690px; margin-top: 50px; border: 1px solid #e7e7e7; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
          <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffffff; border-radius: 5px; width: 45px; height: 45px; left: 10px; top: 6px;">
            <img src="public/pdf.svg" alt="">
          </div>
          <p style="position: absolute; left: 60px; top: 14px;">Statement [1]</p>

        </div>

        <a href="print-details_ssa.php?smonth=<?php echo $smonth; ?>" target="_blank">
          <div style="position: absolute; background-color: #fcfbff; border: 1px solid #dadada; width: 220px; height: 60px; border-radius: 10px; margin-left: 690px; border: 1px solid #e7e7e7; top: 210px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">

            <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffffff; border-radius: 5px; width: 45px; height: 45px; left: 10px; top: 6px;">
              <img src="public/pdf.svg" alt="">
            </div>
            <p style="position: absolute; left: 60px; top: 14px;">Statement [2]</p>


          </div>
        </a>
        <a type="button" data-modal-target="select-modal-xls" data-modal-toggle="select-modal-xls">
          <div style="position: absolute; background-color: #fcfbff; border: 1px solid #dadada; width: 220px; height: 60px; border-radius: 10px; margin-left: 1150px; margin-top: 98px; border: 1px solid #e7e7e7; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
            <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffffff; border-radius: 5px; width: 45px; height: 45px; left: 10px; top: 6px;">
              <img src="public/xls.svg" alt="">
            </div>
            <p style="position: absolute; left: 60px; top: 0px;">Salary<br>Statement</p>

          </div>
        </a>
        <a type="button" data-modal-target="select-modal-bs" data-modal-toggle="select-modal-bs">
          <div style="position: absolute; background-color: #fcfbff; border: 1px solid #dadada; width: 220px; height: 60px; border-radius: 10px; margin-left: 915px; margin-top: 27px; border: 1px solid #e7e7e7; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
            <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffffff; border-radius: 5px; width: 45px; height: 45px; left: 10px; top: 6px;">
              <img src="public/pdf.svg" alt="">
            </div>
            <p style="position: absolute; left: 60px; top: 14px;"> Bank Statement</p>

          </div>
        </a>

        <a type="button" data-modal-target="select-modal" data-modal-toggle="select-modal">
          <div style="position: absolute; background-color: #fcfbff; border: 1px solid #dadada; width: 220px; height: 60px; border-radius: 10px; margin-left: 1140px; margin-top:27px; border: 1px solid #e7e7e7; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
            <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffffff; border-radius: 5px; width: 45px; height: 45px; left: 10px; top: 6px;">
              <img src="public/pdf.svg" alt="">
            </div>
            <p style="position: absolute; left: 60px; top: 0px;">Salary Statement</p>

          </div>
        </a>


        <a type="button" data-modal-target="select-modal-bs-xls" data-modal-toggle="select-modal-bs-xls">
          <div style="position: absolute; background-color: #fcfbff; border: 1px solid #dadada; width: 220px; height: 60px; border-radius: 10px; margin-left: 905px; border: 1px solid #e7e7e7; top: 210px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
            <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffffff; border-radius: 5px; width: 45px; height: 45px; left: 10px; top: 6px;">
              <img src="public/xls.svg" alt="">
            </div>
            <p style="position: absolute; left: 60px; top: 14px;">Bank Statement </p>

          </div>
        </a>

        <script>
          $(document).ready(function() {
            $('.close-modal-button').on('click', function() {
              $('#crud-modal').addClass('hidden');
              $('#crud-modal-ggm').addClass('hidden');
              $('#crud-modal-sp').addClass('hidden');
            });

            $(window).on('click', function(event) {
              if ($(event.target).is('#crud-modal')) {
                $('#crud-modal').addClass('hidden');
              }
            });
          });
        </script>

        <!-- salary statement PDF-->
        <div id="select-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-1 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                  Download Salary Statements by Work Location
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="select-modal">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                  <span class="sr-only">Close modal</span>
                </button>
              </div>
              <!-- Modal body -->
              <div class="p-4 md:p-5">
                <p class="text-gray-500 dark:text-gray-400 mb-4">Select the location to download the Salary Statement as a PDF</p>
                <ul class="space-y-4 mb-4">
                  <?php
                  if ($work_location == 'Visakhapatnam' || $work_location == 'All') {
                  ?>
                    <li id="ss_vsp">
                      <input type="radio" id="job-1" name="job" value="job-1" class="hidden peer" required />
                      <label for="job-1" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                        <div class="block">
                          <div class="w-full text-lg font-semibold">Download the Salary Statement for </div>
                          <div class="w-full text-gray-500 dark:text-gray-400">Visakhapatnam</div>
                        </div>
                        <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                      </label>
                    </li>
                  <?php }
                  ?>
                  <?php
                  if ($work_location == 'Gurugram' || $work_location == 'All') {
                  ?>
                    <li id="ss_ggm">
                      <input type="radio" id="job-2" name="job" value="job-2" class="hidden peer">
                      <label for="job-2" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                        <div class="block">
                          <div class="w-full text-lg font-semibold">Download the Salary Statement for</div>
                          <div class="w-full text-gray-500 dark:text-gray-400">Gurugram</div>
                        </div>
                        <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                      </label>
                    </li>
                    <li id="ss_sp">
                      <input type="radio" id="job-3" name="job" value="job-3" class="hidden peer">
                      <label for="job-3" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                        <div class="block">
                          <div class="w-full text-lg font-semibold">Download the Salary Statement for</div>
                          <div class="w-full text-gray-500 dark:text-gray-400">Service Provider</div>
                        </div>
                        <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                      </label>
                    </li>
                  <?php }
                  ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- salary statement XLS-->
        <div id="select-modal-xls" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-1 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                  Download Salary Statements by Work Location
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="select-modal-xls">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                  <span class="sr-only">Close modal</span>
                </button>
              </div>
              <!-- Modal body -->
              <div class="p-4 md:p-5">
                <p class="text-gray-500 dark:text-gray-400 mb-4">Select the location to download the Salary Statement in Excel/CSV Format</p>
                <ul class="space-y-4 mb-4">
                  <?php
                  if ($work_location == 'Visakhapatnam' || $work_location == 'All') {
                  ?>
                    <li id="ss_vsp_xls">
                      <input type="radio" id="job-1" name="job" value="job-1" class="hidden peer" required />
                      <label for="job-1" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                        <div class="block">
                          <div class="w-full text-lg font-semibold">Download the Salary Statement for</div>
                          <div class="w-full text-gray-500 dark:text-gray-400">Visakhapatnam</div>
                        </div>
                        <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                      </label>
                    </li>
                  <?php }
                  ?>
                  <?php
                  if ($work_location == 'Gurugram' || $work_location == 'All') {
                  ?>
                    <li id="ss_ggm_xls">
                      <input type="radio" id="job-2" name="job" value="job-2" class="hidden peer">
                      <label for="job-2" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                        <div class="block">
                          <div class="w-full text-lg font-semibold">Download the Salary Statement for</div>
                          <div class="w-full text-gray-500 dark:text-gray-400">Gurugram</div>
                        </div>
                        <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                      </label>
                    </li>
                    <li id="ss_sp_xls">
                      <input type="radio" id="job-3" name="job" value="job-3" class="hidden peer">
                      <label for="job-3" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                        <div class="block">
                          <div class="w-full text-lg font-semibold">Download the Salary Statement for</div>
                          <div class="w-full text-gray-500 dark:text-gray-400">Service Provider</div>
                        </div>
                        <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                      </label>
                    </li>
                  <?php }
                  ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- salary statement BS PDF-->
        <div id="select-modal-bs" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                  Download Bank Statements by Work Location
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="select-modal-bs">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                  <span class="sr-only">Close modal</span>
                </button>
              </div>
              <!-- Modal body -->
              <div class="p-4 md:p-5">
                <p class="text-gray-500 dark:text-gray-400 mb-4">Select the location to download the Bank Statement as a PDF</p>
                <ul class="space-y-4 mb-4">
                  <?php
                  if ($work_location == 'Visakhapatnam' || $work_location == 'All') {
                  ?>
                    <li id="ss_vsp_bs">
                      <input type="radio" id="job-1" name="job" value="job-1" class="hidden peer" required />
                      <label for="job-1" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                        <div class="block">
                          <div class="w-full text-lg font-semibold">Download the Bank Statement for </div>
                          <div class="w-full text-gray-500 dark:text-gray-400">Visakhapatnam</div>
                        </div>
                        <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                      </label>
                    </li>
                  <?php }
                  ?>
                  <?php
                  if ($work_location == 'Gurugram' || $work_location == 'All') {
                  ?>
                    <li id="ss_ggm_bs">
                      <input type="radio" id="job-2" name="job" value="job-2" class="hidden peer">
                      <label for="job-2" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                        <div class="block">
                          <div class="w-full text-lg font-semibold">Download the Bank Statement for </div>
                          <div class="w-full text-gray-500 dark:text-gray-400">Gurugram</div>
                        </div>
                        <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                      </label>
                    </li>
                    <li id="ss_sp_bs">
                      <input type="radio" id="job-3" name="job" value="job-3" class="hidden peer">
                      <label for="job-3" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                        <div class="block">
                          <div class="w-full text-lg font-semibold">Download the Bank Statement for </div>
                          <div class="w-full text-gray-500 dark:text-gray-400">Service Provider</div>
                        </div>
                        <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                      </label>
                    </li>
                  <?php }
                  ?>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- salary statement BS XLS-->
        <div id="select-modal-bs-xls" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative p-1 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                  Download Bank Statements by Work Location
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="select-modal-bs-xls">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                  </svg>
                  <span class="sr-only">Close modal</span>
                </button>
              </div>
              <!-- Modal body -->
              <div class="p-4 md:p-5">
                <p class="text-gray-500 dark:text-gray-400 mb-4">Select the location to download the Bank Statement in Excel/CSV Format</p>
                <ul class="space-y-4 mb-4">
                  <?php
                  if ($work_location == 'Visakhapatnam' || $work_location == 'All') {
                  ?>
                    <li id="ss_vsp_bs_xls">
                      <input type="radio" id="job-1" name="job" value="job-1" class="hidden peer" required />
                      <label for="job-1" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                        <div class="block">
                          <div class="w-full text-lg font-semibold">Download the Bank Statement for</div>
                          <div class="w-full text-gray-500 dark:text-gray-400">Visakhapatnam</div>
                        </div>
                        <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                      </label>
                    </li>
                  <?php }
                  ?>
                  <?php
                  if ($work_location == 'Gurugram' || $work_location == 'All') {
                  ?>
                    <li id="ss_ggm_bs_xls">
                      <input type="radio" id="job-2" name="job" value="job-2" class="hidden peer">
                      <label for="job-2" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                        <div class="block">
                          <div class="w-full text-lg font-semibold">Download the Bank Statement for</div>
                          <div class="w-full text-gray-500 dark:text-gray-400">Gurugram</div>
                        </div>
                        <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                      </label>
                    </li>
                    <li id="ss_sp_bs_xls">
                      <input type="radio" id="job-3" name="job" value="job-3" class="hidden peer">
                      <label for="job-3" class="inline-flex items-center justify-between w-full p-5 text-gray-900 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-500 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-900 hover:bg-gray-100 dark:text-white dark:bg-gray-600 dark:hover:bg-gray-500">
                        <div class="block">
                          <div class="w-full text-lg font-semibold">Download the Bank Statement for</div>
                          <div class="w-full text-gray-500 dark:text-gray-400">Service Provider</div>
                        </div>
                        <svg class="w-4 h-4 ms-3 rtl:rotate-180 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                      </label>
                    </li>
                  <?php }
                  ?>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <script>
          document.addEventListener('DOMContentLoaded', function() {
            // Function to handle click events for each link
            function handleLinkClick(event, id, page) {
              if (event.target.closest(id)) {
                event.preventDefault();

                var smonth = '<?php echo $smonth; ?>'; // Replace with actual PHP variable value
                var url = page + encodeURIComponent(smonth);
                window.open(url, '_blank');
              }
            }

            // Event listener for ss_vsp
            document.getElementById('ss_vsp_bs').addEventListener('click', function(event) {
              handleLinkClick(event, '#ss_vsp_bs', 'print-details_bank_vsp.php?smonth=');
            });

            // Event listener for ss_ggm
            document.getElementById('ss_ggm_bs').addEventListener('click', function(event) {
              handleLinkClick(event, '#ss_ggm_bs', 'print-details_bank_ggm.php?smonth=');
            });

            // Event listener for ss_sp
            document.getElementById('ss_sp_bs').addEventListener('click', function(event) {
              handleLinkClick(event, '#ss_sp_bs', 'print-details_bank_sp.php?smonth=');
            });
          });
        </script>

        <script>
          document.addEventListener('DOMContentLoaded', function() {
            // Function to handle click events for each link
            function handleLinkClick(event, id, page) {
              if (event.target.closest(id)) {
                event.preventDefault();

                var smonth = '<?php echo $smonth; ?>'; // Replace with actual PHP variable value
                var url = page + encodeURIComponent(smonth);
                window.open(url, '_blank');
              }
            }

            // Event listener for ss_vsp
            document.getElementById('ss_vsp').addEventListener('click', function(event) {
              handleLinkClick(event, '#ss_vsp', 'print-details_main_vsp.php?smonth=');
            });

            // Event listener for ss_ggm
            document.getElementById('ss_ggm').addEventListener('click', function(event) {
              handleLinkClick(event, '#ss_ggm', 'print-details_main_ggm.php?smonth=');
            });

            // Event listener for ss_sp
            document.getElementById('ss_sp').addEventListener('click', function(event) {
              handleLinkClick(event, '#ss_sp', 'print-details_main_sp.php?smonth=');
            });
          });
        </script>

        <script>
          document.addEventListener('DOMContentLoaded', function() {
            // Event listener for ss_vsp_bs button click
            document.getElementById('ss_vsp_bs').addEventListener('click', function(event) {
              event.preventDefault(); // Prevent default link behavior

              var crudModal = document.getElementById('crud-modal');
              if (crudModal) {
                crudModal.classList.remove('hidden'); // Make sure the modal is visible
              } else {
                console.error('Crud Modal element not found in the DOM.');
              }
            });

            // Event listener for ss_ggm_bs button click
            document.getElementById('ss_ggm_bs').addEventListener('click', function(event) {
              event.preventDefault(); // Prevent default link behavior

              var crudModalGGM = document.getElementById('crud-modal-ggm');
              if (crudModalGGM) {
                crudModalGGM.classList.remove('hidden'); // Make sure the modal is visible
              } else {
                console.error('Crud Modal (GGM) element not found in the DOM.');
              }
            });

            // Event listener for ss_sp_bs button click
            document.getElementById('ss_sp_bs').addEventListener('click', function(event) {
              event.preventDefault(); // Prevent default link behavior

              var crudModalSP = document.getElementById('crud-modal-sp');
              if (crudModalSP) {
                crudModalSP.classList.remove('hidden'); // Make sure the modal is visible
              } else {
                console.error('Crud Modal (SP) element not found in the DOM.');
              }
            });
          });
        </script>




        <script>
          document.addEventListener('DOMContentLoaded', function() {
            // Function to handle click events for each link
            function handleLinkClick(event, id, page) {
              if (event.target.closest(id)) {
                event.preventDefault();

                var smonth1 = '<?php echo $smonth; ?>'; // Replace with actual PHP variable value
                var url1 = page + encodeURIComponent(smonth1);
                window.open(url1, '_blank');
              }
            }

            // Event listener for ss_vsp
            document.getElementById('ss_vsp_xls').addEventListener('click', function(event) {
              handleLinkClick(event, '#ss_vsp_xls', 'exportCSV_main_vsp.php?smonth=');
            });

            // Event listener for ss_ggm
            document.getElementById('ss_ggm_xls').addEventListener('click', function(event) {
              handleLinkClick(event, '#ss_ggm_xls', 'exportCSV_main_ggm.php?smonth=');
            });

            // Event listener for ss_sp
            document.getElementById('ss_sp_xls').addEventListener('click', function(event) {
              handleLinkClick(event, '#ss_sp_xls', 'exportCSV_main_sp.php?smonth=');
            });
          });
        </script>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            // Function to handle click events for each link
            function handleLinkClick(event, id, page) {
              if (event.target.closest(id)) {
                event.preventDefault();

                var smonth1 = '<?php echo $smonth; ?>'; // Replace with actual PHP variable value
                var url1 = page + encodeURIComponent(smonth1);
                window.open(url1, '_blank');
              }
            }

            // Event listener for ss_vsp
            document.getElementById('ss_vsp_bs_xls').addEventListener('click', function(event) {
              handleLinkClick(event, '#ss_vsp_bs_xls', 'exportCSV_bank_vsp.php?smonth=');
            });

            // Event listener for ss_ggm
            document.getElementById('ss_ggm_bs_xls').addEventListener('click', function(event) {
              handleLinkClick(event, '#ss_ggm_bs_xls', 'exportCSV_bank_ggm.php?smonth=');
            });

            // Event listener for ss_sp
            document.getElementById('ss_sp_bs_xls').addEventListener('click', function(event) {
              handleLinkClick(event, '#ss_sp_bs_xls', 'exportCSV_bank_sp.php?smonth=');
            });
          });
        </script>

      </a>
      <?php
      $sql_1 = "SELECT 
      SUM(pv.epf1 + pv.epf2 + pv.pension) AS total_epf
    FROM 
      payroll_ss_vsp pv
      INNER JOIN payroll_schedule ps_vsp ON pv.salarymonth = ps_vsp.smonth
  WHERE salarymonth = '$smonth'
    UNION ALL
    SELECT 
      SUM(pg.epf1 + pg.epf2 + pg.pension) AS total_epf
    FROM 
      payroll_ss_ggm pg
      INNER JOIN payroll_schedule ps_ggm ON pg.salarymonth = ps_ggm.smonth
  WHERE salarymonth = '$smonth'
    UNION ALL
    SELECT 
      SUM(ps.epf1 + ps.epf2 + ps.pension) AS total_epf
    FROM 
      payroll_ss_sp ps
      INNER JOIN payroll_schedule ps_sp ON ps.salarymonth = ps_sp.smonth
    WHERE salarymonth = '$smonth'";
      $result = $con->query($sql_1);
      $row = $result->fetch_assoc();
      $sumEpf = $row['total_epf'];
      if (($sumEpf - floor($sumEpf)) > 0.5) {
        $sumEpf = ceil($sumEpf);
      } elseif (($sumEpf - floor($sumEpf)) < 0.5) {
        $sumEpf = floor($sumEpf);
      }
      $sql_2 = "SELECT 
      SUM(pv.esi1 + pv.esi2) AS total_esi
    FROM 
      payroll_ss_vsp pv
      INNER JOIN payroll_schedule ps_vsp ON pv.salarymonth = ps_vsp.smonth
   WHERE salarymonth = '$smonth'
    UNION ALL
    SELECT 
      SUM(pg.esi1 + pg.esi2) AS total_esi
    FROM 
      payroll_ss_ggm pg
      INNER JOIN payroll_schedule ps_ggm ON pg.salarymonth = ps_ggm.smonth
   WHERE salarymonth = '$smonth'
    UNION ALL
    SELECT 
      SUM(ps.esi1 + ps.esi2) AS total_esi
    FROM 
      payroll_ss_sp ps
      INNER JOIN payroll_schedule ps_sp ON ps.salarymonth = ps_sp.smonth
   WHERE salarymonth = '$smonth'";
      $result = $con->query($sql_2);
      $row = $result->fetch_assoc();
      $sumEsi = $row['total_esi'];
      if (($sumEsi - floor($sumEsi)) > 0.5) {
        $sumEsi = ceil($sumEsi);
      } elseif (($sumEsi - floor($sumEsi)) < 0.5) {
        $sumEsi = floor($sumEsi);
      }
      $sql_3 = "SELECT 
      SUM(pv.misc) AS total_misc
    FROM 
      payroll_ss_vsp pv
      INNER JOIN payroll_schedule ps_vsp ON pv.salarymonth = ps_vsp.smonth
   WHERE salarymonth = '$smonth'
    UNION ALL
    SELECT 
      SUM(pg.misc) AS total_misc
    FROM 
      payroll_ss_ggm pg
      INNER JOIN payroll_schedule ps_ggm ON pg.salarymonth = ps_ggm.smonth
 WHERE salarymonth = '$smonth'
    UNION ALL
    SELECT 
      SUM(ps.misc) AS total_misc
    FROM 
      payroll_ss_sp ps
      INNER JOIN payroll_schedule ps_sp ON ps.salarymonth = ps_sp.smonth
   WHERE salarymonth = '$smonth'";
      $result = $con->query($sql_3);
      $row = $result->fetch_assoc();
      $sumMisc = $row['total_misc'];
      if (($sumMisc - floor($sumMisc)) > 0.5) {
        $sumMisc = ceil($sumMisc);
      } elseif (($sumMisc - floor($sumMisc)) < 0.5) {
        $sumMisc = floor($sumMisc);
      }

      $total = $sum + $sumEpf + $sumEsi + $sumMisc;
      ?>
      <div style="margin-top: 200px;">
        <table style="border: 1px solid rgb(219, 219, 219); box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 rounded-lg border">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3" colspan="5">
                Employee Payables
              </th>
            </tr>
          </thead>
          <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4" style="padding-bottom: 17px;">
                <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffdfdf; border-radius: 50%; top: 370px; width: 50px; height: 50px;">
                  <img src="./public/banktransfer.svg" width="20px" alt="">
                </div>
                <span style="margin-left: 60px;">BANK TRANSFER <br> <span style="margin-left: 60px;">₹<?php echo $sum; ?></span></span>
              </td>
              <td class="px-6 py-4">
                <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffe8df; border-radius: 50%; top: 370px; width: 50px; height: 50px;">
                  <img src="./public/EPFESIC.svg" width="20px" alt="">
                </div>
                <span style="margin-left: 60px;">EPF <br> <span style="margin-left: 60px;">₹<?php echo $sumEpf; ?></span></span>
              </td>
              <td class="px-6 py-4">
                <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffe8df; border-radius: 50%; top: 370px; width: 50px; height: 50px;">
                  <img src="./public/EPFESIC.svg" width="20px" alt="">
                </div>
                <span style="margin-left: 60px;">ESIC <br> <span style="margin-left: 60px;">₹<?php echo $sumEsi; ?></span></span>
              </td>
              <td class="px-6 py-4">
                <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #fff1df; border-radius: 50%; top: 370px; width: 50px; height: 50px;">
                  <img src="./public/others.svg" width="20px" alt="">
                </div>
                <span style="margin-left: 60px;">OTHERS <br> <span style="margin-left: 60px;">₹<?php echo $sumMisc; ?></span></span>
              </td>
              <td class="px-6 py-4">
                <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #dfedff; border-radius: 50%; top: 370px; width: 50px; height: 50px;">
                  <img src="./public/totalsvg.svg" width="20px" alt="">
                </div>
                <span style="margin-left: 60px;">TOTAL <br> <span style="margin-left: 60px;">₹<?php echo $total; ?></span></span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div style="margin-top: 10px;height:40%;overflow-x:auto;">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">
                Employee Name
              </th>
              <th scope="col" class="px-6 py-3">
                SALARY TYPE
              </th>
              <th scope="col" class="px-6 py-3">
                PAYOUT MONTH
              </th>
              <th scope="col" class="px-6 py-3">
                PAID DAYS
              </th>
              <th scope="col" class="px-6 py-3">
                Net Pay
              </th>
              <th scope="col" class="px-6 py-3">
                Net Paycheck
              </th>
              <th scope="col" class="px-6 py-3">
                PAYSLIP
              </th>
              <th scope="col" class="px-6 py-3">
                PAYMENT MODE
              </th>
              <th scope="col" class="px-6 py-3">
                PAYMENT STATUS
              </th>
            </tr>
          </thead>
          <?php
          if ($work_location == 'All') {
            $sql = "
       SELECT p.*, m.salarytype, m.netpay
       FROM (
           SELECT empname,salarymonth,paydays,payout FROM payroll_ss_vsp WHERE salarymonth = '$smonth'
           UNION ALL
           SELECT empname,salarymonth,paydays,payout  FROM payroll_ss_ggm WHERE salarymonth = '$smonth'
           UNION ALL
           SELECT empname,salarymonth,paydays,payout  FROM payroll_ss_sp WHERE salarymonth = '$smonth'
       ) AS p
       LEFT JOIN payroll_msalarystruc AS m ON p.empname = m.empname
   ";
          }
          if ($work_location == 'Gurugram') {
            $sql = "
    SELECT p.*, m.salarytype, m.netpay
    FROM (
           SELECT empname,salarymonth,paydays,payout  FROM payroll_ss_ggm WHERE salarymonth = '$smonth'
           UNION ALL
           SELECT empname,salarymonth,paydays,payout  FROM payroll_ss_sp WHERE salarymonth = '$smonth'
       ) AS p
    LEFT JOIN payroll_msalarystruc AS m ON p.empname = m.empname
";
          }
          if ($work_location == 'Visakhapatnam') {
            $sql = "
   SELECT p.*, m.salarytype, m.netpay
   FROM (
       SELECT empname,salarymonth,paydays,payout FROM payroll_ss_vsp WHERE salarymonth = '$smonth'
   ) AS p
   LEFT JOIN payroll_msalarystruc AS m ON p.empname = m.empname
";
          }
          $que = mysqli_query($con, $sql);

          if (mysqli_num_rows($que) > 0) {
            while ($result = mysqli_fetch_assoc($que)) {
          ?>
              <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['salarytype']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['salarymonth']; ?></td>
                  <td class="px-6 py-4"><?php echo $result['paydays']; ?></td>
                  <td class="px-6 py-4">₹<?php echo $result['netpay']; ?></td>
                  <td class="px-6 py-4">₹<?php echo $result['payout']; ?></td>
                  <td class="px-6 py-4">
                    <button class="view-btn" data-empname="<?php echo $result['empname']; ?>" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example" data-drawer-placement="right" aria-controls="drawer-right-example">
                      <a class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-blue-600 rounded-lg hover:bg-blue-200 focus:ring-4 focus:outline-none dark:text-white focus:ring-blue-50 dark:bg-blue-700 dark:hover:bg-blue-600 dark:focus:ring-blue-600">
                        <svg class="w-4 h-4 text-white dark:text-white hover:text-blue-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z" />
                          <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                        </svg>
                      </a>
                    </button>
                  </td>
                  <td class="px-6 py-4">Bank Transfer</td>
                  <td class="px-6 py-4 text-green-400">
                    Paid
                  </td>

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
      </div>
    </div>
    <div id="drawer-right-example" class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto overflow-x-hidden transition-transform translate-x-full bg-white w-80 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-right-label" style="width: 500px;">
      <h5 id="drawer-right-label" class="inline-flex items-center mb-4 text-base font-semibold text-blue-400 dark:text-blue-400">empname</h5><br>
      <p class="emp-id inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400">Emp. ID : </p>
      <p class="payout  inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="position: absolute; right: 70px; font-size: 32px;"></p>
      <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="position: absolute; right: 70px; top: 20px;">NET PAY</p>
      <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
        <span class="sr-only">Close menu</span>
      </button>

      <div style="width: 115%;margin-left:-20px; background-color: rgb(234, 255, 233); height: 40px;  display: flex; align-items: center; justify-content: center;">
        <svg class="w-6 h-6 text-green-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
          <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd" />
        </svg>
        <?php
        $date = strtotime($paid);
        $formatted_date = date("d-m-Y", $date);
        ?>

        <p class="text-green-400" style="font-size: 16px;">Paid on <span class="text-green-400" style="font-weight: 500;"><?php echo $formatted_date ?></span> through <span class="text-green-400" style="font-weight: 500;">Manual Bank Transfer</span></p>
      </div>
      <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 20px; font-size: 20px;">Payable Days</p>
      <p class="paydays inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 20px; font-size: 20px; position: absolute; right: 60px;"></p>
      <div>
        <hr style="margin-top: 10px;">
        <p class="inline-flex items-center mb-4 text-base font-normal text-green-400 dark:text-green-400" style="margin-top: 10px;">(+) Earnings</p>
        <p class="inline-flex items-center mb-4 text-base font-normal text-green-400 dark:text-green-400" style="margin-top: 10px; position: absolute; right: 60px;">Amount</p>
        <hr>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">Basic</p>
        <p class="bp inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p> <br>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">House Rent Allowance</p>
        <p class="hra inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p><br>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">Other Allowance</p>
        <p class="oa inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p><br>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">Bonus</p>
        <p class="bonus inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;">₹bonus</p>
        <hr>
        <p class="inline-flex items-center mb-4 text-base font-normal text-red-500 dark:text-red-400" style="margin-top: 10px;">(-) Deductions</p>
        <p class="inline-flex items-center mb-4 text-base font-normal text-red-500 dark:text-red-400" style="margin-top: 10px; position: absolute; right: 60px;">Amount</p>
        <hr>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">Provident Fund</p>
        <p class="epf1  inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p> <br>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">Employee State Insurance</p>
        <p class="esi1 inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p><br>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">Loan EMI</p>
        <p class="emi inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p><br>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">TDS</p>
        <p class="tds inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p><br>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">Miscellaneous</p>
        <p class="misc inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p><br>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px;">LOP</p>
        <p class="lop inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; position: absolute; right: 60px;"></p>
        <hr>
        <p class="inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; font-size: 22px; font-weight:500;">Netpay</p>
        <p class="payout1  inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400" style="margin-top: 10px; font-size: 22px; font-weight:500; position: absolute; right: 60px;"></p>
        <hr>
      </div>
      <div style="position: absolute; bottom: 0; width: 92%;" class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
        <a id="downloadBtn" target="_blank" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          Download Payslip
        </a>
        <!-- <button style="position: absolute; right: 20px;" data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Send Payslip</button> -->
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
</body>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.view-btn');
    const drawer = document.getElementById('drawer-right-example');
    const downloadBtn = document.getElementById('downloadBtn');

    buttons.forEach(button => {
      button.addEventListener('click', function() {
        const empname = this.dataset.empname;

        // AJAX request to fetch details from database based on empname
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === 4 && xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            populateDrawer(data);
          }
        };
        xhr.open('GET', 'fetch_ss_details_new.php?smonth=<?php echo $smonth; ?>&empname=' + empname, true);
        xhr.send();
      });
    });

    function populateDrawer(data) {
      const empnameElement = drawer.querySelector('#drawer-right-label');
      const empIDElement = drawer.querySelector('.emp-id');
      const payoutElement = drawer.querySelector('.payout');
      const paydaysElement = drawer.querySelector('.paydays');
      const payout1Element = drawer.querySelector('.payout1');
      const epfElement = drawer.querySelector('.epf1');
      const esiElement = drawer.querySelector('.esi1');
      const bpElement = drawer.querySelector('.bp');
      const hraElement = drawer.querySelector('.hra');
      const oaElement = drawer.querySelector('.oa');
      const bonusElement = drawer.querySelector('.bonus');
      const miscElement = drawer.querySelector('.misc');
      const emiElement = drawer.querySelector('.emi');
      const tdsElement = drawer.querySelector('.tds');
      const lopElement = drawer.querySelector('.lop');

      // Populate drawer elements with fetched data
      empnameElement.textContent = data.empname;
      empIDElement.textContent = 'Emp. ID: ' + data.emp_no;
      payoutElement.textContent = '₹' + data.payout;
      paydaysElement.textContent = data.paydays;
      payout1Element.textContent = '₹' + data.payout;
      epfElement.textContent = '₹' + data.epf1;
      esiElement.textContent = '₹' + data.esi1;
      bpElement.textContent = '₹' + data.bp;
      hraElement.textContent = '₹' + data.hra;
      oaElement.textContent = '₹' + data.oa;
      bonusElement.textContent = '₹' + data.bonus;
      miscElement.textContent = '₹' + data.misc;
      emiElement.textContent = '₹' + data.emi;
      tdsElement.textContent = '₹' + data.tds;
      lopElement.textContent = '₹' + data.lopamt;

      // Show the drawer
      drawer.classList.remove('hidden');
    }

    // Event listener for setting the href attribute of the download button
    buttons.forEach(button => {
      button.addEventListener('click', function() {
        const empname = this.dataset.empname;
        // Set the href attribute of the download button dynamically
        downloadBtn.href = 'print-details_pslip_new.php?smonth=<?php echo $smonth; ?>&empname=' + empname;

      });
    });
  });
</script>


<script>
  var count = 0; // Variable to store the count initially

  function toggleCheckboxes(checkbox) {
    var checkboxes = document.querySelectorAll('.absentCheckbox');
    checkboxes.forEach(function(cb) {
      cb.checked = checkbox.checked;
    });
    updateSelectedCount();
  }

  function updateSelectedCount() {
    count = document.querySelectorAll('.absentCheckbox:checked').length; // Update the count variable
    document.getElementById('selectedCount').textContent = '(' + count + ')';
  }

  updateSelectedCount();
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
  $(document).ready(function() {
    $('#steps').click(function(e) {
      e.preventDefault();

      // Get the count value from the span element
      var count = $('#selectedCount').text().replace(/\D/g, '');

      // Add the count value to the form data
      var formData = new FormData($('#employeeForm')[0]);
      formData.append('count', count);

      $.ajax({
        type: 'POST',
        url: 'update_steps1.php',
        data: formData,
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
              window.location.href = 'payroll.php';
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


</html>