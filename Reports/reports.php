
<?php
session_start();
@include 'inc/config.php';

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  header('location:loginpage.php');
  exit();
}

$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
if ($user_name === '') {
  header('location:loginpage.php');
  exit();
}

$query = "SELECT user_type,user_type1 FROM user_form WHERE email = '$user_name'";
$result = mysqli_query($con, $query);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if ($row && isset($row['user_type']) && isset($row['user_type1'])) {
    $user_type = $row['user_type'];
    $user_type1 = $row['user_type1'];

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
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap"
    />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->
    <style>
       .rectangle-div1 {
    /* position: absolute; */
    /* top: 136px; */
    border-radius: 20px;
    /* background-color: var(--color-white); */
    background-color: #f4f1fa;
    width: 450px;
    height: 400px;
    box-shadow: 0 4px 4px rgba(0, 0, 0, 0.4);
  }
  .hidden{
    display: none;
  }

  .circle {
      background: #F56A12 !important;
      border-radius: 50%;
      display: inline-block;
      width: 30px;
      height: 30px;
      line-height: 30px;
      text-align: center;
      color: white;
      font-size: 15px;
      font-weight: bold;
      margin-left: 20px;
      position: relative;
      top: -5px;

      animation: circle 0.9s infinite;
    }

    @keyframes circle {
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

    </style>
  </head>
  <body>
    <?php
    $sql_leaves = "SELECT COUNT(*) AS count FROM leaves WHERE status = 0";
    $result_leaves = $con->query($sql_leaves);
    $row_leaves = $result_leaves->fetch_assoc();
    $count_leaves = $row_leaves['count'];
  
    $sql_onb = "SELECT COUNT(*) AS count FROM onb WHERE status = 0";
    $result_onb = $con->query($sql_onb);
    $row_onb = $result_onb->fetch_assoc();
    $count_onb = $row_onb['count'];
  
    $sql_payroll = "SELECT COUNT(*) AS count FROM payroll_schedule WHERE status = 7 AND approval = 0";
    $result_payroll = $con->query($sql_payroll);
    $row_payroll = $result_payroll->fetch_assoc();
    $count_payroll = $row_payroll['count'];
    ?>
    <div class="attendence4">
      <div class="bg14"></div>
     
      <div class="rectangle-parent23" style="margin-top: -70px; margin-left: -60px;">
      <div style="display: flex; gap: 220px;">
        <div class="rectangle-div">
         <div style="display: flex; gap: 10px;">
          <img src="./public/icons8-employee-50.png" width="35px" height="35px" style="margin-top: 22px; margin-left: 20px;" alt=""> 
          <p style="font-size: 27px;">Employee Reports</p>
         </div>
         <div style=" margin-top: 10px;">
          <a href="./empdetails_report.php" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">  <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg> Employee Details</a><hr style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
         <a href="./leavedetails_report.php" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">  <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg> Leave Details</a><hr style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
         <a href="./leavebalance_report.php" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">  <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg> Leave Balance</a><hr style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
         <a href="./attendance_report.php" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">  <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg> Attendance</a><hr style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
         <a href="./markabsent_report.php" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">  <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg> Marked Absent</a><hr style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
         <!--<a href="./sheet_report.html" class="hidden" id="qwer" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">Overall Attendance</a>-->
         <a href="./holiday_report.php" id="qwerty" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">  <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg> Holiday Report</a><hr id="qwertyu" style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
         <a href="./map_report.php" id="qwertyui" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">  <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg> CAMS User ID Mapping</a><hr id="qwertyuio" style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
         <a href="./designation_report.php" id="qwertyuiop" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">  <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg> Designations</a><hr id="asdf" style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
         <a href="./managers_report.php" id="asdfg" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">  <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg> Managers</a><hr id="asdfgh" style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
         
         </div>
         <!-- <p onclick="seeMoreFunc();" id="asdfghj" style="margin-top: -20px; cursor: pointer; margin-left: 340px; font-size: 18px; color: rgb(0, 110, 255); text-decoration: underline;">See More...</p> -->
         <!-- <p onclick="seeLessFunc();" class="hidden" id="asdfghjk" style="margin-top: -20px; cursor: pointer; margin-left: 340px; font-size: 18px; color: rgb(0, 110, 255); text-decoration: underline;">See Less...</p> -->
        </div>
        <div class="rectangle-div">
          <div style="display: flex; gap: 10px;">
            <img src="./public/payrollreport.png" width="35px" height="35px" style="margin-top: 22px; margin-left: 20px;" alt=""> 
            <p style="font-size: 27px;">Payroll Reports</p>
           </div>
           <a href="./PayrollStatement_report.php" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">  <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg> Payroll Statement</a><hr style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
           <a href="./salarytable_report.php" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">  <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg> Salary Report</a><hr style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
           <a href="./Bonus_report.php" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">  <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg> Bonus Report</a><hr style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
        </div>
        <div class="rectangle-div">
          <div style="display: flex; gap: 10px;">
            <img src="./public/statutoryreport.png" width="35px" height="35px" style="margin-top: 22px; margin-left: 20px;" alt=""> 
            <p style="font-size: 27px;">Statutory Reports</p>
           </div>
           <a href="./EPF_report.php" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;"> <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg>
           EPF Report</a><hr style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
           <a href="./ESI_report.php" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">  <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg> ESI Report</a><hr style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
        </div>
      </div>
      <div style="display: flex; gap: 220px; margin-top: 10px;">
        <div class="rectangle-div">
          <div style="display: flex; gap: 10px;">
            <img src="./public/deductionsreport.png" width="35px" height="35px" style="margin-top: 22px; margin-left: 20px;" alt=""> 
            <p style="font-size: 27px;">Deduction Reports</p>
           </div>
           <a href="./LOP_report.php" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">  <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg> LOP Statement</a><hr style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
           <a href="./Misc_report.php" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">  <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg> Misc. Deduction Report</a><hr style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
        </div>
        <div class="rectangle-div">
          <div style="display: flex; gap: 10px;">
            <img src="./public/loansreport-removebg-preview.png" width="35px" height="35px" style="margin-top: 22px; margin-left: 20px;" alt=""> 
            <p style="font-size: 27px;">Loan Reports</p>
           </div>
           <a href="./loans_report.php" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">  <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg> Loans Statement</a><hr style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
           <a href="./LoanEMIDeduct_report.php" style="font-size: 20px; margin-left: 110px; color: rgb(0, 110, 255); text-decoration: none;">  <svg class="w-[12px] h-[12px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="18" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
          </svg> Loan EMI Report</a><hr style="border: 1px dashed rgb(152, 152, 152); width: 70%; margin-left: 120px;">
        </div>
        <div class="rectangle-div"></div>
      </div>
      </div>
      <img class="attendence-child" alt="" src="./public/rectangle-1@2x.png" />

      <img class="attendence-item" alt="" src="./public/rectangle-2@2x.png" />

      <img class="logo-1-icon14" alt="" src="../public/logo-1@2x.png" />
      <a class="anikahrm14" href="./index.html" id="anikaHRM">
        <span>Anika</span>
        <span class="hrm14">HRM</span>
      </a>
      <a
        class="attendence-management4"
        href="reports.html"
        id="attendenceManagement"
        >Reports</a
      >
      <button class="attendence-inner"></button>
      <a href="../logout.php" style="color: rgb(255, 255, 255); text-decoration: none; z-index:9999;" class="logout14">Logout</a>
      <a class="payroll14" href="../Payroll/payroll.php" style="color: black; text-decoration: none; z-index:9999;">Payroll
<?php if ($count_payroll > 0) {?>
  <span class="circle"> <?php echo $count_payroll ?> </span>
<?php }?>
      </a>
      <a href="reports.html" class="reports14" style="color: rgb(255, 255, 255); text-decoration: none; z-index:9999;">Reports</a>
      <img class="uitcalender-icon14" alt="" src="./public/uitcalender.svg" />

      <img 
        class="arcticonsgoogle-pay14"
        alt=""
        src="./public/arcticonsgooglepay.svg"
      />

      <img style="-webkit-filter: grayscale(1) invert(1);
      filter: grayscale(1) invert(1); z-index:9999;"
        class="streamlineinterface-content-c-icon14"
        alt=""
        src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg"
      />

    

      <img class="attendence-child2" alt="" style="margin-top: 134px;" src="./public/rectangle-4@2x.png" />

      <a class="dashboard14" href="../index.php" style="z-index: 99999;" id="dashboard">Dashboard</a>
      <a class="fluentpeople-32-regular14" style="z-index: 99999;" id="fluentpeople32Regular">
        <img class="vector-icon73" alt="" src="./public/vector7.svg" />
      </a>
      <a class="employee-list14" href="../employee-management.php" style="z-index: 99999;" id="employeeList">Employee List</a>
      <a
        class="akar-iconsdashboard14" style="z-index: 99999;"
        href="../index.php"
        id="akarIconsdashboard"
      >
        <img class="vector-icon74" alt="" src="./public/vector3.svg" />
      </a>
      <img class="tablerlogout-icon14" style="z-index: 99999;" alt="" src="./public/tablerlogout.svg" />

      <a class="leaves14" id="leaves" style="z-index: 99999;" href="../leave-management.php">Leaves
      <?php if ($count_leaves > 0) { ?>
        <span class="circle">
          <?php echo $count_leaves ?>
        </span>
        <?php }
         ?>
      </a>
      <a
        class="fluentperson-clock-20-regular14"
        id="fluentpersonClock20Regular"
      >
        <img class="vector-icon75" style="z-index: 99999;" alt="" src="./public/vector1.svg" />
      </a>
      <a class="onboarding16" style="z-index: 99999;" id="onboarding" href="../onboarding.php">Onboarding
      <?php if ($count_onb > 0) { ?>
        <span class="circle">
          <?php echo $count_onb ?>
        </span>
      <?php
      }
      ?>
      </a>
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
       <!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- JavaScript code to handle loading animation -->
<script>
  $(document).ready(function() {
    // Function to show loading animation
    function showLoading() {
      Swal.fire({
        title: 'Loading...',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });
      
      // Close the loading animation after 1 second
      setTimeout(function() {
        Swal.close();
      }, 1500);
    }

    // Add click event listener to all href links
    $('a[href="./empdetails_report.php"],' +
      'a[href="./leavedetails_report.php"],' +
      'a[href="./leavebalance_report.php"],' +
      'a[href="./attendance_report.php"],' +
      'a[href="./markabsent_report.php"],' +
      'a[href="./holiday_report.php"],' +
      'a[href="./map_report.php"],' +
      'a[href="./designation_report.php"],' +
      'a[href="./managers_report.php"],' +
      'a[href="./PayrollStatement_report.php"],' +
      'a[href="./salarytable_report.php"],' +
      'a[href="./Bonus_report.php"],' +
      'a[href="./EPF_report.php"],' +
      'a[href="./ESI_report.php"],' +
      'a[href="./LOP_report.php"],' +
      'a[href="./Misc_report.php"],' +
      'a[href="./loans_report.php"],' +
      'a[href="./LoanEMIDeduct_report.php"]').click(function(event) {
      // Show loading animation when link is clicked
      showLoading();
    });

    // Show loading animation when the browser is unloading (navigating to a new page)
    $(window).on('beforeunload', function() {
      showLoading();
    });
  });
</script>


  </body>
  
</html>