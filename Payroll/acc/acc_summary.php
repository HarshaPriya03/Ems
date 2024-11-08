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
    <?php
    $servername = "localhost";
    $username = "Anika12";
    $password = "Anika12";
    $dbname = "ems";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT smonth FROM payroll_schedule WHERE status = 7 LIMIT 1";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $smonth = $row["smonth"];
    } else {
      $smonth = "No month found with status = 0";
    }
    ?>

    <div class="bg14"></div>
    <div class="rectangle-parent23" style="margin-top: -40px; margin-left: -20px;">
      <div style="background-color: #f4f1fa; height: 100px; border-radius: 10px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); margin-top: -40px;">
        <img src="../public/calend.png" width="90px" style="position: absolute; top: -35px; left: 10px;" alt="">
        <div style="position: absolute; left: 110px; top: -10px;">
          <label for="">Payroll Processed For </label> &nbsp;
          <input type="text" name="smonth" value="<?php echo $smonth; ?>" readonly style="border-radius: 5px;width:40%;text-align:center;" />
        </div>
        <!-- <button data-modal-target="default-modals" data-modal-toggle="default-modals" type="button" style="position: absolute; right: 60px; top: -10px;" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
          Record Payment</button> -->
      </div>

      <div id="default-modals" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <form id="employeeForm">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
              <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                Record Payment
              </h3>
              <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modals">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
              </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4" style="margin-left: 30px;">
              <p style="font-size: 16px; color: #858585; font-weight: lighter;">You are about to record payment for this payrun</p>
              <label for="">Employee's Paid on:</label>
             
              <input type="date" style="width: 300px; border-radius: 5px; margin-left: 20px;" name="paid">
              <div style="height: 200px; overflow-y: auto; margin-left: -10px;">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="width: 500px;">
                  <thead style="text-align: center;" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                      <th scope="col" class="px-6 py-3">
                        Emp Name
                      </th>
                      <th scope="col" class="px-6 py-3">
                        <input type="checkbox" style="margin-left:27px;" id="checkAll" onclick="toggleCheckboxes(this)" name="paid_emp">
                        <span id="selectedCount">(0)</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody style="text-align: center;">
                    <?php
                    $sql = "SELECT * FROM emp  ORDER BY emp_no ASC";
                    $que = mysqli_query($con, $sql);
                    $rowCount = mysqli_num_rows($que);

                    if ($rowCount > 0) {
                      while ($result = mysqli_fetch_assoc($que)) {
                    ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                          <td class="px-6 py-4"><?php echo $result['empname'] ?></td>
                          <td class="px-6 py-4"><input type="checkbox" class="absentCheckbox" name="absentCheckbox[]" value="<?php echo $result['empname'] ?>" onclick="updateSelectedCount()"></td>
                        </tr>
                      <?php
                      }
                    } else {
                      ?>
                      <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td colspan="2" class="px-6 py-4 text-center">No Employees</td>
                      </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <div style="display: flex; gap: 5px;">
                <input type="checkbox" name="notify" value="Yes">
                <p style="font-weight: 400; margin-top: -7px;">Send Payslip notification email's to all the employees</p>
              </div>
              <p style="font-size: 16px; color: #535353; background-color: #fcf1e2; font-weight: lighter; text-align: justify; display: flex; gap: 10px; padding: 10px; border-radius: 10px; width: 95%;">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0 0 26 26" style="fill:#FD7E14; margin-top: -14px;">
                  <path d="M 13 1.1875 C 6.476563 1.1875 1.1875 6.476563 1.1875 13 C 1.1875 19.523438 6.476563 24.8125 13 24.8125 C 19.523438 24.8125 24.8125 19.523438 24.8125 13 C 24.8125 6.476563 19.523438 1.1875 13 1.1875 Z M 15.460938 19.496094 C 14.851563 19.734375 14.367188 19.917969 14.003906 20.042969 C 13.640625 20.167969 13.222656 20.230469 12.742188 20.230469 C 12.007813 20.230469 11.433594 20.050781 11.023438 19.691406 C 10.617188 19.335938 10.414063 18.878906 10.414063 18.324219 C 10.414063 18.109375 10.429688 17.890625 10.460938 17.667969 C 10.488281 17.441406 10.539063 17.191406 10.605469 16.90625 L 11.367188 14.21875 C 11.433594 13.960938 11.492188 13.71875 11.539063 13.488281 C 11.585938 13.257813 11.605469 13.046875 11.605469 12.855469 C 11.605469 12.515625 11.535156 12.273438 11.394531 12.140625 C 11.25 12.003906 10.980469 11.9375 10.582031 11.9375 C 10.386719 11.9375 10.183594 11.96875 9.976563 12.027344 C 9.769531 12.089844 9.59375 12.148438 9.445313 12.203125 L 9.648438 11.375 C 10.144531 11.171875 10.621094 11 11.078125 10.855469 C 11.53125 10.710938 11.964844 10.636719 12.367188 10.636719 C 13.097656 10.636719 13.664063 10.816406 14.058594 11.167969 C 14.453125 11.519531 14.652344 11.980469 14.652344 12.542969 C 14.652344 12.660156 14.640625 12.867188 14.613281 13.160156 C 14.585938 13.453125 14.535156 13.722656 14.460938 13.972656 L 13.703125 16.652344 C 13.640625 16.867188 13.585938 17.113281 13.535156 17.386719 C 13.488281 17.660156 13.464844 17.871094 13.464844 18.011719 C 13.464844 18.367188 13.542969 18.613281 13.703125 18.742188 C 13.859375 18.871094 14.136719 18.933594 14.53125 18.933594 C 14.714844 18.933594 14.921875 18.902344 15.15625 18.839844 C 15.386719 18.773438 15.554688 18.71875 15.660156 18.667969 Z M 15.324219 8.617188 C 14.972656 8.945313 14.546875 9.109375 14.050781 9.109375 C 13.554688 9.109375 13.125 8.945313 12.769531 8.617188 C 12.414063 8.289063 12.238281 7.890625 12.238281 7.425781 C 12.238281 6.960938 12.417969 6.558594 12.769531 6.226563 C 13.125 5.894531 13.554688 5.730469 14.050781 5.730469 C 14.546875 5.730469 14.972656 5.894531 15.324219 6.226563 C 15.679688 6.558594 15.855469 6.960938 15.855469 7.425781 C 15.855469 7.890625 15.679688 8.289063 15.324219 8.617188 Z"></path>
                </svg>
                An email with a link to view the payslip will be emailed to portal-enabled employees whereas the payslip will be attached along with the email for those who don’t have the employee portal enabled.
              </p>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
       
           
                <input type="hidden" name="approval" value=1>
                <input type="hidden" name="smonth" value="<?php echo $smonth; ?>">
                <button id="steps" type="submit" class="text-white bg-blue-700 hover:bg-blue-800  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center ">
                  <svg class="w-6 h-6 me-2 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8.032 12 1.984 1.984 4.96-4.96m4.55 5.272.893-.893a1.984 1.984 0 0 0 0-2.806l-.893-.893a1.984 1.984 0 0 1-.581-1.403V7.04a1.984 1.984 0 0 0-1.984-1.984h-1.262a1.983 1.983 0 0 1-1.403-.581l-.893-.893a1.984 1.984 0 0 0-2.806 0l-.893.893a1.984 1.984 0 0 1-1.403.581H7.04A1.984 1.984 0 0 0 5.055 7.04v1.262c0 .527-.209 1.031-.581 1.403l-.893.893a1.984 1.984 0 0 0 0 2.806l.893.893c.372.372.581.876.581 1.403v1.262a1.984 1.984 0 0 0 1.984 1.984h1.262c.527 0 1.031.209 1.403.581l.893.893a1.984 1.984 0 0 0 2.806 0l.893-.893a1.985 1.985 0 0 1 1.403-.581h1.262a1.984 1.984 0 0 0 1.984-1.984V15.7c0-.527.209-1.031.581-1.403Z" />
                  </svg>
                  Confirm
                </button>
                <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
        
            </div>
            </form>
          </div>
        </div>
      </div><br>
      <div style="position: absolute; background-color: #fcfbff; border: 1px solid #dadada; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); width: 440px; height: 180px; border-radius: 10px;">
        <p style="font-size: 18px; color: #7e7e7e; position: absolute; left: 20px; top: 20px;">Period: <span style="font-size: 19px; color: rgb(88, 88, 88);">March 2024</span> | 31 Pay Days</p>
        <div style="position: absolute; left: 20px; top: 75px; display: flex; align-items: center; justify-content: center; background-color: #e4dfff; border-radius: 50%; width: 50px; height: 50px;">
          <img src="../public/Group-2.svg" width="20px" alt="">
        </div>
        <div style="position: absolute; right: 180px; top: 75px; display: flex; align-items: center; justify-content: center; background-color: #dfffef; border-radius: 50%; width: 50px; height: 50px;">
          <img src="../public/Vector-1231.svg" width="20px" alt="">
        </div>
        <div>
     
                <?php
    $sql = "SELECT SUM(payout + epf1 + epf2 + esi1 + esi2 + emi + pension) AS total_payroll FROM payroll_ss";
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
            $sql = "SELECT SUM(payout) AS total_payout FROM payroll_ss";
            $result = $con->query($sql);
            $row = $result->fetch_assoc();
            $sum = $row['total_payout'];
            ?>
          <p style="position: absolute; right: 60px; top: 70px; font-size: 30px;">₹<?php echo $sum; ?> </p>
          <p style="position: absolute; right: 21px; top: 110px; font-size: 15px; color: #7e7e7e;">EMPLOYEE'S NET PAY</p>
        </div>
      </div>
      <div style="position: absolute; background-color: rgb(255, 255, 255); box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2); width: 200px; height: 180px; border-radius: 10px; margin-left: 470px; border: 1px solid #e7e7e7;">
        <p style="position: absolute; left: 66px; color: #7e7e7e; top: 20px; font-size: 18px;">PAY DAY</p>
        <p style="position: absolute; left: 77px; top: 50px; font-size: 37px; font-weight: lighter;">06</p>
        <p style="position: absolute; top: 100px; font-size: 18px; border-bottom: 1px solid #e7e7e7; width: 200px; text-align: center; padding-bottom: 10px;">APR, 2024</p>
        <?php
         $sql4 = "SELECT COUNT(*) as count FROM emp WHERE empstatus= 0";

         $result4 = $con->query($sql4);
         $row4 = $result4->fetch_assoc();
         $count4 = $row4['count'];
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
      <a href="../print-details_ss.php" target="_blank">
      <div style="position: absolute; background-color: #fcfbff; border: 1px solid #dadada; width: 300px; height: 60px; border-radius: 10px; margin-left: 690px; margin-top: 50px; border: 1px solid #e7e7e7; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
        <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffffff; border-radius: 5px; width: 45px; height: 45px; left: 10px; top: 6px;">
          <img src="../public/pdf.svg" alt="">
        </div>
        <p style="position: absolute; left: 60px; top: 14px;">Statement [1]</p>
        <span class="bg-yellow-200 text-xs font-medium text-orange-800 text-center p-0.5 leading-none rounded-full px-2 dark:bg-blue-900 dark:text-orange-200 absolute -translate-y-1/2 translate-x-1/2 left-auto top-0 right-0 blink">NEW</span>
      </div>
       <a href="../print-details_bank.php" target="_blank">
      <div style="position: absolute; background-color: #fcfbff; border: 1px solid #dadada; width: 300px; height: 60px; border-radius: 10px; margin-left: 690px; border: 1px solid #e7e7e7; top: 210px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
      <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffffff; border-radius: 5px; width: 45px; height: 45px; left: 10px; top: 6px;">
          <img src="../public/pdf.svg" alt="">
        </div>
        <p style="position: absolute; left: 60px; top: 14px;">Bank Statement</p>
        <span class="bg-yellow-200 text-xs font-medium text-orange-800 text-center p-0.5 leading-none rounded-full px-2 dark:bg-blue-900 dark:text-orange-200 absolute -translate-y-1/2 translate-x-1/2 left-auto top-0 right-0 blink">NEW</span>
      </div>
       </a>
      <a href="../print-details_ssa.php" target="_blank">
      <div style="position: absolute; background-color: #fcfbff; border: 1px solid #dadada; width: 300px; height: 60px; border-radius: 10px; margin-left: 1010px; margin-top: 50px; border: 1px solid #e7e7e7; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
        <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffffff; border-radius: 5px; width: 45px; height: 45px; left: 10px; top: 6px;">
           <img src="../public/pdf.svg" alt="">
        </div>
        <p style="position: absolute; left: 60px; top: 14px;">Statement [2]</p>
        <span class="bg-yellow-200 text-xs font-medium text-orange-800 text-center p-0.5 leading-none rounded-full px-2 dark:bg-blue-900 dark:text-orange-200 absolute -translate-y-1/2 translate-x-1/2 left-auto top-0 right-0 blink">NEW</span>
      </div></a>
      <a href="../exportCSV_bank.php">
        <div style="position: absolute; background-color: #fcfbff; border: 1px solid #dadada; width: 300px; height: 60px; border-radius: 10px; margin-left: 1010px; border: 1px solid #e7e7e7; top: 210px; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2);">
        <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffffff; border-radius: 5px; width: 45px; height: 45px; left: 10px; top: 6px;">
       <img src="../public/xls.svg" alt="">
        </div>
        <p style="position: absolute; left: 60px; top: 14px;">Bank Statement XLS</p>
        <span class="bg-yellow-200 text-xs font-medium text-orange-800 text-center p-0.5 leading-none rounded-full px-2 dark:bg-blue-900 dark:text-orange-200 absolute -translate-y-1/2 translate-x-1/2 left-auto top-0 right-0 blink">NEW</span>
      </div>
    </a>
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
              <h3 class="text-lg text-gray-900 dark:text-white" style="text-align:center;">
              Please enter the <b>Transaction Ref. Number</b> to access <b><?php echo $currentMonthYear ?></b> salary statement.
              </h3>
             
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
           
              <button  type="submit" data-drawer-target="drawer-contact" data-drawer-show="drawer-contact" aria-controls="drawer-contact" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
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
      <?php
            $sql_1 = "SELECT SUM(epf1 + epf2  + pension) AS total_epf FROM payroll_ss";
            $result = $con->query($sql_1);
            $row = $result->fetch_assoc();
            $sumEpf = $row['total_epf'];
            if (($sumEpf - floor($sumEpf)) > 0.5) {
              $sumEpf = ceil($sumEpf);
          } elseif (($sumEpf - floor($sumEpf)) < 0.5) {
              $sumEpf = floor($sumEpf);
          }
          $sql_2 = "SELECT SUM(esi1 + esi2) AS total_esi FROM payroll_ss";
            $result = $con->query($sql_2);
            $row = $result->fetch_assoc();
            $sumEsi = $row['total_esi'];
            if (($sumEsi - floor($sumEsi)) > 0.5) {
              $sumEsi = ceil($sumEsi);
          } elseif (($sumEsi - floor($sumEsi)) < 0.5) {
              $sumEsi = floor($sumEsi);
          }
          $sql_3 = "SELECT SUM(emi) AS total_emi FROM payroll_ss";
          $result = $con->query($sql_3);
          $row = $result->fetch_assoc();
          $sumEmi = $row['total_emi'];
          if (($sumEmi - floor($sumEmi)) > 0.5) {
            $sumEmi = ceil($sumEmi);
        } elseif (($sumEmi - floor($sumEmi)) < 0.5) {
            $sumEmi = floor($sumEmi);
        }

        $total=$sum+$sumEpf+$sumEsi+$sumEmi;
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
                <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffdfdf; border-radius: 50%; top: 340px; width: 50px; height: 50px;">
                  <img src="../public/banktransfer.svg" width="20px" alt="">
                </div>
                <span style="margin-left: 60px;">BANK TRANSFER <br> <span  style="margin-left: 60px;">₹<?php echo $sum; ?></span></span>
              </td>
              <td class="px-6 py-4">
                <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffe8df; border-radius: 50%; top: 340px; width: 50px; height: 50px;">
                  <img src="../public/EPFESIC.svg" width="20px" alt="">
                </div>
                <span style="margin-left: 60px;">EPF <br> <span  style="margin-left: 60px;">₹<?php echo $sumEpf; ?></span></span>
              </td>
              <td class="px-6 py-4">
                <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #ffe8df; border-radius: 50%; top: 340px; width: 50px; height: 50px;">
                  <img src="../public/EPFESIC.svg" width="20px" alt="">
                </div>
                <span style="margin-left: 60px;">ESIC <br> <span  style="margin-left: 60px;">₹<?php echo $sumEsi; ?></span></span>
              </td>
              <td class="px-6 py-4">
                <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #fff1df; border-radius: 50%; top: 340px; width: 50px; height: 50px;">
                  <img src="../public/others.svg" width="20px" alt="">
                </div>
                <span style="margin-left: 60px;">OTHERS <br> <span  style="margin-left: 60px;">₹<?php echo $sumEmi; ?></span></span>
              </td>
              <td class="px-6 py-4">
                <div style="position: absolute; display: flex; align-items: center; justify-content: center; background-color: #dfedff; border-radius: 50%; top: 340px; width: 50px; height: 50px;">
                  <img src="../public/totalsvg.svg" width="20px" alt="">
                </div>
                <span style="margin-left: 60px;">TOTAL <br> <span  style="margin-left: 60px;">₹<?php echo $total; ?></span></span>
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
                Emp Name
              </th>
              <th scope="col" class="px-6 py-3">
                PAID DAYS
              </th>
              <th scope="col" class="px-6 py-3">
                NET PAY
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
          $sql = "SELECT * FROM payroll_ss  ORDER BY ID ASC";
          $que = mysqli_query($con, $sql);

          if (mysqli_num_rows($que) > 0) {
            while ($result = mysqli_fetch_assoc($que)) {
          ?>
          <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4"><?php echo $result['empname']; ?></td>
              <td class="px-6 py-4"><?php echo $result['monthdays']; ?></td>
              <td class="px-6 py-4"><?php echo $result['payout']; ?></td>
              <td class="px-6 py-4">
                      <a  class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-blue-600 rounded-lg hover:bg-blue-200 focus:ring-4 focus:outline-none dark:text-white focus:ring-blue-50 dark:bg-blue-700 dark:hover:bg-blue-600 dark:focus:ring-blue-600">
                        <svg class="w-4 h-4 text-white dark:text-white hover:text-blue-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z" />
                          <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                        </svg>
                      </a>
                    </td>
              <td class="px-6 py-4">Bank Transfer</td>
              <td class="px-6 py-4">
    <?php 
    if ($result['status'] == 1) {
        echo '<span>Confirmed</span>';
    } else {
        echo '<span>Yet to Confirm</span>';
    }
    ?>
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

    <img class="attendence-child" alt="" src="../public/rectangle-1@2x.png" />

    <img class="attendence-item" alt="" src="../public/rectangle-2@2x.png" />

    <img class="logo-1-icon14" alt="" src="../public/logo-1@2x.png" />
    <a class="anikahrm14" href="../../index.php" id="anikaHRM">
      <span>Anika</span>
      <span class="hrm14">HRM</span>
    </a>
    <a class="attendence-management4" href="../../index.php" id="attendenceManagement">Payroll Management</a>
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