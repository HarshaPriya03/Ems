<?php
@include '../inc/config.php';
session_start();


if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
     echo "<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'warning',
        title: 'Session Expired',
        text: 'For your security, your session has timed out due to inactivity.',
        confirmButtonText: 'Log In Again',
        confirmButtonColor: '#3085d6',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        customClass: {
            container: 'session-expired-alert',
            title: 'font-weight-bold',
            content: 'text-left',
            confirmButton: 'btn btn-primary btn-lg'
        },
        backdrop: `
           #FFBF78
            url('https://apps.anikasterilis.com/ASPL.png')
            center center
            no-repeat
        `
    }).then(function() {
        window.location.href = 'login-mob.php';
    });
});
</script>";
    exit();
}
$sqlStatusCheck = "SELECT empstatus,work_location FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultStatusCheck = mysqli_query($con, $sqlStatusCheck);
$statusRow = mysqli_fetch_assoc($resultStatusCheck);


$work_location = $statusRow['work_location'];
$smonth = isset($_GET['smonth']) ? $_GET['smonth'] : '';
if ($statusRow['empstatus'] == 0) {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="initial-scale=1, width=device-width" />

        <link rel="stylesheet" href="./empmobcss/empjob-details-mob.css" />
        <link rel="stylesheet" href="./empmobcss/globalqw.css" />
        <link rel="stylesheet" href="./empmobcss/my-leaveemp-mob.css" />
        <link rel="stylesheet" href="./empmobcss/emp-salary-details-mob1.css" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
        <style>
            table {
                border: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                border-collapse: collapse;
                border-spacing: 0;
                box-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
            }

            table thead {
                background: #F0F0F0;
                height: 60px !important;
            }

            table thead tr th:first-child {
                padding-left: 45px;
            }

            table thead tr th {
                text-transform: uppercase;
                line-height: 60px !important;
                text-align: left;
                font-size: 11px;
                padding-top: 0px !important;
                padding-bottom: 0px !important;
            }

            table tbody {
                background: #fff;
            }

            table tbody tr {
                border-top: 1px solid #e5e5e5;
                height: 60px;
            }

            table tbody tr td:first-child {
                padding-left: 45px;
            }

            table tbody tr td {
                height: 60px;
                line-height: 60px !important;
                text-align: left;
                padding: 0 10px;
                font-size: 14px;
            }

            table tbody tr td i {
                margin-right: 8px;
            }

            @media screen and (max-width: 850px) {
                table {
                    border: 1px solid transparent;
                    box-shadow: none;
                }

                table thead {
                    display: none;
                }

                table tbody tr {
                    border-bottom: 20px solid #F6F5FB;
                }

                table tbody tr td:first-child {
                    padding-left: 10px;
                }

                table tbody tr td:before {
                    content: attr(data-label);
                    float: left;
                    font-size: 10px;
                    text-transform: uppercase;
                    font-weight: bold;
                }

                table tbody tr td {
                    display: block;
                    text-align: right;
                    font-size: 14px;
                    padding: 0px 10px !important;
                    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);
                }
            }
        </style>
    </head>

    <body>
        <div class="myleaveemp-mob" style="height: 100svh;">
            <?php
            $sql = "SELECT * FROM leavebalance WHERE empemail = '{$_SESSION['user_name']}'";
            $que = mysqli_query($con, $sql);
            $cnt = 1;
            if (mysqli_num_rows($que) == 0) {
                echo '<tr><td colspan="5" style="text-align:center;">Stay tuned for upcoming updates on your leave balance! Keep an eye on this space for exciting developments.</td></tr>';
            } else {
                while ($result = mysqli_fetch_assoc($que)) {
            ?>
                    <div class="frame-parent" style="height: 230px; margin-top: -20px;">

                        <div class="rectangle-container">
                            <div class="rectangle-div" style="background:#FFE2C6;width:190%;margin-left:10px;"></div>
                            <svg style="margin-left:90px;" class="vector-icon6 w-10 h-10 mr-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>

                            <p class="flex total-earned1" style="width:180%;color:black;">
                            <svg class="w-9 h-6 mr-2 text-green-500 " fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Payslips are crucial documents that provide a detailed breakdown of your earnings and deductions.
                            </p>

                            <div class="sick-leave flex items-center mb-3" style="white-space:nowrap;margin-top:-20px;">

                                <h2 class="text-m font-semibold dark:text-white" style="color:#FF5400;margin-left:60px;">Payroll Information</h2>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
         <?php
$user_name = $_SESSION['user_name'];

$sql = "SELECT emp.empname
        FROM emp
        INNER JOIN user_form ON emp.empemail = user_form.email
        WHERE user_form.email = '$user_name'";

$result = mysqli_query($con, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $empname = $row['empname'];
    } else {
        $empname = "Unknown"; 
    }
} else {
    $empname = "Unknown"; 
}

?>

            <div class="rectangle-parent23" style="margin-top: 240px; height: 240px;">
            <div class="table-container">
                <table class="data">
                    <thead>
                        <tr>
                             <th data-label="   PAYSLIP">    PAYSLIP</th>  
                            <th data-label="   SALARY TYPE">   SALARY TYPE</th>
                            <th data-label="Pay Period Details">Pay Period Details</th>
                            <th data-label="   PAID DAYS">   PAID DAYS</th>  
                            <th data-label="   Net Paycheck">   Net Paycheck</th>  
                            <th data-label="    PAYMENT MODE">     PAYMENT MODE</th>  
                            <th data-label="    PAYMENT STATUS">     PAYMENT STATUS</th>  
                        </tr>
                    </thead>
                    <tbody>
                    <?php
       $sql_vsp = "SELECT empname FROM payroll_ss_vsp WHERE empname = '$empname' AND salarymonth = '$smonth'";
       $result_vsp = mysqli_query($con, $sql_vsp);
       
       if (mysqli_num_rows($result_vsp) > 0) {
           $table = 'payroll_ss_vsp';
       } else {
           // Check if empname exists in payroll_ss_ggm
           $sql_ggm = "SELECT empname FROM payroll_ss_ggm WHERE empname = '$empname' AND salarymonth = '$smonth'";
           $result_ggm = mysqli_query($con, $sql_ggm);
       
           if (mysqli_num_rows($result_ggm) > 0) {
               $table = 'payroll_ss_ggm';
           } else {
               // Check if empname exists in payroll_ss_sp
               $sql_sp = "SELECT empname FROM payroll_ss_sp WHERE empname = '$empname' AND salarymonth = '$smonth'";
               $result_sp = mysqli_query($con, $sql_sp);
       
               if (mysqli_num_rows($result_sp) > 0) {
                   $table = 'payroll_ss_sp';
               } else {
                   // empname does not exist in any of the tables
                   echo json_encode(['error' => 'No data found']);
                   exit;
               }
           }
       }
       
       // Prepare the final query based on the determined table
       $sql = "
           SELECT 
               $table.*, 
               payroll_msalarystruc.salarytype, 
               payroll_msalarystruc.netpay
           FROM 
               $table
           LEFT JOIN 
               payroll_msalarystruc ON $table.empname = payroll_msalarystruc.empname
           WHERE 
               $table.salarymonth = '$smonth' 
               AND $table.empname = '$empname'
           ORDER BY 
               $table.ID ASC";
       
       

 $comparisonDate = DateTime::createFromFormat('F Y', 'April 2024');

          $que = mysqli_query($con, $sql);

          if (mysqli_num_rows($que) > 0) {
            while ($result = mysqli_fetch_assoc($que)) {
            //   $salaryMonthDate = DateTime::createFromFormat('F Y', $result['salarymonth']);
            //   if ($result['empname'] == "YERRAMSETTI SUSANTHA SANKAR" && $salaryMonthDate > $comparisonDate) {
            //     $result['netpay'] = "26320";
            //     $result['payout'] = "26320";
            // }
          ?>
                                <tr style="outline:2px solid #F46214;">
                   
                    <td data-label="  PAYSLIP:" style="margin-top:15px;padding:20px;">
                                    <button class="view-btn" data-empname="<?php echo $result['empname']; ?>" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example" data-drawer-placement="right" aria-controls="drawer-right-example">
                      <a class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-blue-600 rounded-lg hover:bg-blue-200 focus:ring-4 focus:outline-none dark:text-white focus:ring-blue-50 dark:bg-blue-700 dark:hover:bg-blue-600 dark:focus:ring-blue-600">
                        <svg class="w-4 h-4 text-white dark:text-white hover:text-blue-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z" />
                          <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                        </svg>
                      </a>
                    </button>
                                    </td>
                                    <td data-label="   SALARY TYPE:">
                                    <?php echo $result['salarytype']; ?>
                                    </td>
                                    <td data-label="   Pay Period Details:">
                                    <?php echo $result['salarymonth']; ?>
                                    </td>
                                    <td data-label="   PAID DAYS:">
                                    <?php echo $result['paydays']; ?>
                                    </td>
                                    <td data-label="   Net Paycheck:">
                                    ₹<?php echo $result['payout']; ?>
                                    </td>
                                    <td data-label="   PAYMENT MODE:">
                                    Bank Transfer
                                    </td>
                                    <td data-label="   PAYMENT STATUS:">
                                    <p class="text-green-400">PAID</p>   
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
                <div class="scroll-indicator"></div>
            </div>
            </div>

            <div class="logo-1-container">
                <img class="logo-1-icon2" alt="" src="./public/logo-1@2x.png" />

                <a class="leaves-list" style="width:120%;">Payroll Management</a>
            </div>
            <div class="myleaveemp-mob-item"></div>
            <div class="rectangle-parent1" style="margin-left:-48px">
                <a class="frame-child3" id="rectangleLink" style="width:50%;"> </a>
                <a class="frame-child4" style="background:#E8E8E8;"> </a>
                <a class="apply-leave" id="applyLeave" style="width:100%;">Personal Details</a>
                <a class="my-leaves" style="text-align:center;margin-left:-10px;color:black;">Job</a>
                <a class="frame-child3" href="lbhistory-mob.php" id="rectangleLink1" style="margin-left:200px;background:#FFE2C6;"> </a>
                <a class="apply-leave" href="lbhistory-mob.php" id="myLeaves" style="margin-left:200px; width:50px;text-align:center;color:#FF5400">Salary</a>
            </div>
            <div class="empsalarydetails-mob-inner"></div>
      <div class="fluentperson-clock-20-regular-container">
        <a
          class="fluentperson-clock-20-regular6"
          id="fluentpersonClock20Regular"
        >
          <img
            class="vector-icon21"
            alt=""
            src="./public/vector1@2xleaves.png"
          />
        </a>
        <a class="uitcalender6" id="uitcalender">
          <img
            class="vector-icon22"
            alt=""
            src="./public/vector2@2xatten.png"
          />
        </a>
        <img
          class="arcticonsgoogle-pay6"
          alt=""
          src="./public/arcticonsgooglepay1@2x.png"
          id="arcticonsgooglePay"
        />

        <div class="frame-child27"></div>
        <a class="akar-iconsdashboard6" href="emp-dashboard-mob.php">
          <img
            class="vector-icon23"
            alt=""
            src="./public/vector.svg"
          />
        </a>
      </div>
        </div>
        <div id="drawer-right-example" class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto overflow-x-hidden transition-transform translate-x-full bg-white w-80 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-right-label" style="width: 100vh; max-width:98%;height:100vh;max-height:100%;">
       
        <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4">
  <div class="flex items-center mb-2">
    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <p class="text-sm font-medium text-gray-500">Download your payslip</p>
  </div>
  <p class="text-gray-500 mb-2">Access your latest pay statement and view your earnings, deductions, and net pay.</p>
  <a id="downloadBtn" href="#" target="_blank" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
    </svg>
    Download Payslip
  </a>
</div>
  <p class="hidden payout inline-flex items-center mb-4 text-base font-normal text-gray-500 dark:text-gray-400"> </p>
        <button type="button" data-drawer-hide="drawer-right-example" aria-controls="drawer-right-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
        <span class="sr-only">Close menu</span>
      </button>

      <div style="width: 115%;margin-left:-30px; background-color: rgb(234, 255, 233); height: 40px;  display: flex; align-items: center; justify-content: center;">
        <svg class="w-6 h-6 text-green-400 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
          <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd" />
        </svg>
        <?php
      $sql = "SELECT paid FROM payroll_schedule WHERE smonth = '$smonth' ";
      $result = $con->query($sql);
      $row = $result->fetch_assoc();
      $paid = $row['paid'];
      $paidDate = date('d', strtotime($paid)); 
$paidMonthYear = date('F Y', strtotime($paid)); 

      ?>
        <?php
$date = strtotime($paid); 
$formatted_date = date("d-m-Y", $date); 
?>

        <p class="text-green-400" style="font-size: 14px;font-weight: 500;">Paid on <span class="text-green-400" ><?php echo $formatted_date ?></span> through <span class="text-green-400" style="font-weight: 500;">Manual Bank Transfer</span></p>
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
    
    </div>
        <script>
    // function openPayrollHistory(monthYear) {
    //   const thresholdMonthYear = new Date('2024-05-01');
    //   const currentMonthYear = new Date(monthYear + '-01');

    //   if (currentMonthYear >= thresholdMonthYear) {
    //     window.location.href = "latest_payslip1_new.php?smonth=" + monthYear;
    //   } else {
    //     window.location.href = "payslip1.php?smonth=" + monthYear;
    //   }
    // }
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
  const container = document.querySelector('.table-container');
  const indicator = document.querySelector('.scroll-indicator');

  function toggleScrollIndicator() {
    if (container.scrollHeight > container.clientHeight) {
      if (container.scrollTop + container.clientHeight >= container.scrollHeight - 20) {
        indicator.style.opacity = '0';
      } else {
        indicator.style.opacity = '1';
      }
    } else {
      indicator.style.opacity = '0';
    }
  }

  container.addEventListener('scroll', toggleScrollIndicator);
  window.addEventListener('resize', toggleScrollIndicator);

  // Initial check
  toggleScrollIndicator();
});
  </script>
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
                xhr.open('GET', '../Payroll/fetch_ss_details_new.php?smonth=<?php echo $smonth; ?>&empname=' + empname, true);
                xhr.send();
            });
        });

        function populateDrawer(data) {
            const empnameElement = drawer.querySelector('#drawer-right-label');
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
                downloadBtn.href = '../Payroll/print-details_pslip_new.php?smonth=<?php echo $smonth; ?>&empname=' + empname;

            });
        });
    });
</script>
        <script>
            // JavaScript to dynamically set the reason content in the modal
            document.addEventListener('DOMContentLoaded', function() {
                const viewReasonButtons = document.querySelectorAll('.view-reason-button');
                const reasonContent = document.getElementById('reason-content');

                viewReasonButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        const reason = this.getAttribute('data-reason');
                        reasonContent.textContent = reason;
                    });
                });
            });
        </script>
        <script>
            var rectangleLink = document.getElementById("rectangleLink");
            if (rectangleLink) {
                rectangleLink.addEventListener("click", function(e) {
                    window.location.href = "./apply-leaveemp-mob.php";
                });
            }

            var applyLeave = document.getElementById("applyLeave");
            if (applyLeave) {
                applyLeave.addEventListener("click", function(e) {
                    window.location.href = "./apply-leaveemp-mob.php";
                });
            }

            var uitcalender = document.getElementById("uitcalender");
            if (uitcalender) {
                uitcalender.addEventListener("click", function(e) {
                    window.location.href = "./attendenceemp-mob.php";
                });
            }

            var arcticonsgooglePay = document.getElementById("arcticonsgooglePay");
            if (arcticonsgooglePay) {
                arcticonsgooglePay.addEventListener("click", function(e) {
                    window.location.href = "./directoryemp-mob.php";
                });
            }

            var akarIconsdashboard = document.getElementById("akarIconsdashboard");
            if (akarIconsdashboard) {
                akarIconsdashboard.addEventListener("click", function(e) {
                    window.location.href = "./emp-dashboard-mob.php";
                });
            }
        </script>
    </body>

    </html>
<?php
} else {
    echo "<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'warning',
        title: 'Session Expired',
        text: 'For your security, your session has timed out due to inactivity.',
        confirmButtonText: 'Log In Again',
        confirmButtonColor: '#3085d6',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        customClass: {
            container: 'session-expired-alert',
            title: 'font-weight-bold',
            content: 'text-left',
            confirmButton: 'btn btn-primary btn-lg'
        },
        backdrop: `
           #FFBF78
            url('https://apps.anikasterilis.com/ASPL.png')
            center center
            no-repeat
        `
    }).then(function() {
        window.location.href = 'login-mob.php';
    });
});
</script>";
    exit();
}
?>