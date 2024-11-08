<!DOCTYPE html>
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
<?php
include_once 'inc/config.php';
if ($work_location == 'All') {
  $sql = "select pdf from emp WHERE pdf != '' ";
} else {
$sql = "select pdf from emp WHERE work_location = '$work_location' AND pdf != '' ";
}
$result = mysqli_query($con, $sql);
?>

<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/index.css" />
    <link rel="stylesheet" href="./css/onboarding.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap"
    />
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
    </style>
  </head>
  <body>
    <div class="index1">
      <div class="bg18"></div>
      <img class="index-child" alt="" src="./public/rectangle-11@2x.png" />

      <img class="index-item" alt="" src="./public/rectangle-21@2x.png" />

      <img class="logo-1-icon18" alt="" src="./public/logo-1@2x.png" />
      <a class="anikahrm18">
        <span>Anika</span>
        <span class="hrm18">HRM</span>
      </a>
      <h5 class="hr-management">HR Management</h5>
      <h5 class="hr-management" style="margin-left: 300px;">/Documents</h5>
      <button class="index-inner"></button>
      <div class="logout18">Logout</div>
      <a class="employee-list18" id="employeeList" href="employee-management.php">Employee List</a>
      <a class="leaves18" id="leaves">Leaves</a>
      <a class="onboarding22" id="onboarding">Onboarding</a>
      <a class="attendance18" id="attendance">Attendance</a>
      <a href="./Payroll/payroll.php" style="text-decoration:none; color:black;" class="payroll18">Payroll</a>
      <div class="reports18">Reports</div>
      <a class="fluentpeople-32-regular18" id="fluentpeople32Regular">
        <img class="vector-icon94" alt="" src="./public/vector7.svg" />
      </a>
      <a class="fluent-mdl2leave-user18" id="fluentMdl2leaveUser">
        <img class="vector-icon95" alt="" src="./public/vector.svg" />
      </a>
      <a
        class="fluentperson-clock-20-regular18"
        id="fluentpersonClock20Regular"
      >
        <img class="vector-icon96" alt="" src="./public/vector1.svg" />
      </a>
      <a class="uitcalender18" id="uitcalender">
        <img class="vector-icon97" alt="" src="./public/vector4.svg" />
      </a>
      <img
        class="arcticonsgoogle-pay18"
        alt=""
        src="./public/arcticonsgooglepay.svg"
      />

      <img
        class="streamlineinterface-content-c-icon18"
        alt=""
        src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg"
      />

      <!--<img class="index-child1" alt="" src="./public/ellipse-1@2x.png" />-->

      <!--<img-->
      <!--  class="material-symbolsperson-icon18"-->
      <!--  alt=""-->
      <!--  src="./public/materialsymbolsperson.svg"-->
      <!--/>-->

      <img class="index-child2" alt="" src="./public/rectangle-4@2x.png" />

      <a class="dashboard18" href="index.php">Dashboard</a>
      <a class="akar-iconsdashboard18">
        <img class="vector-icon98" alt="" src="./public/vector14.svg" />
      </a>
      <div class="rectangle-parent24" style="overflow-y:auto;">
       
        <table class="data w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style="margin-left:auto; margin-right:auto;">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                      <th scope="col" class="px-6 py-3">
                          S.No.
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Document Name
                      </th>
                      <th scope="col" class="px-6 py-3">
                          View
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Download
                      </th>
                  </tr>
              </thead>
          <?php
                $i = 1;
                while($row = mysqli_fetch_array($result)) { ?>
          <tr class="bg-white  dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="px-6 py-4"><?php echo $i++; ?></td>
            <td class="px-6 py-4"><?php echo $row['pdf']; ?></td>
            <td class="px-6 py-4"><a target="_blank" href="pdfs/<?php echo $row['pdf']; ?>"><img src="./public/images-removebg-preview.png" width="30px" style="margin-left: 10px;" alt=""></a></td>
            <td class="px-6 py-4"><a download href="pdfs/<?php echo $row['pdf']; ?>"><img src="./public/image-removebg-preview.png" width="30px" style="margin-left: 40px;" alt=""></a></td>
          </tr>
          <?php }?>
        </table>
       

        
      </div>
      <img class="tablerlogout-icon18" alt="" src="./public/tablerlogout.svg" />
    </div>

    <script>
      var employeeList = document.getElementById("employeeList");
      if (employeeList) {
        employeeList.addEventListener("click", function (e) {
          window.location.href = "./employee-management.php";
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
      
      var fluentpeople32Regular = document.getElementById("fluentpeople32Regular");
      if (fluentpeople32Regular) {
        fluentpeople32Regular.addEventListener("click", function (e) {
          window.location.href = "./employee-management.php";
        });
      }
      
      var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
      if (fluentMdl2leaveUser) {
        fluentMdl2leaveUser.addEventListener("click", function (e) {
          window.location.href = "./onboarding.html";
        });
      }
      
      var fluentpersonClock20Regular = document.getElementById(
        "fluentpersonClock20Regular"
      );
      if (fluentpersonClock20Regular) {
        fluentpersonClock20Regular.addEventListener("click", function (e) {
          window.location.href = "./leave-management.html";
        });
      }
      
      var uitcalender = document.getElementById("uitcalender");
      if (uitcalender) {
        uitcalender.addEventListener("click", function (e) {
          window.location.href = "./attendence.html";
        });
      }
      
      var leavesList = document.getElementById("leavesList");
      if (leavesList) {
        leavesList.addEventListener("click", function (e) {
          window.location.href = "./leave-management.html";
        });
      }
      
      var attendanceReport = document.getElementById("attendanceReport");
      if (attendanceReport) {
        attendanceReport.addEventListener("click", function (e) {
          window.location.href = "./attendence.html";
        });
      }
      
      var onboarding1 = document.getElementById("onboarding1");
      if (onboarding1) {
        onboarding1.addEventListener("click", function (e) {
          window.location.href = "./onboarding.html";
        });
      }
      
      var employeeList1 = document.getElementById("employeeList1");
      if (employeeList1) {
        employeeList1.addEventListener("click", function (e) {
          window.location.href = "./employee-management.php";
        });
      }
      
      var applyLeave = document.getElementById("applyLeave");
      if (applyLeave) {
        applyLeave.addEventListener("click", function (e) {
          window.location.href = "./apply-leave.html";
        });
      }
      
      var solarnotesOutline = document.getElementById("solarnotesOutline");
      if (solarnotesOutline) {
        solarnotesOutline.addEventListener("click", function (e) {
          window.location.href = "./leave-management.html";
        });
      }
      
      var ionperson = document.getElementById("ionperson");
      if (ionperson) {
        ionperson.addEventListener("click", function (e) {
          window.location.href = "./employee-management.php";
        });
      }
      
      var fluentpersonClock24Filled = document.getElementById(
        "fluentpersonClock24Filled"
      );
      if (fluentpersonClock24Filled) {
        fluentpersonClock24Filled.addEventListener("click", function (e) {
          window.location.href = "./apply-leave.html";
        });
      }
      
      var uiscalender = document.getElementById("uiscalender");
      if (uiscalender) {
        uiscalender.addEventListener("click", function (e) {
          window.location.href = "./attendence.html";
        });
      }
      
      var fluentpersonArrowBack28Fi = document.getElementById(
        "fluentpersonArrowBack28Fi"
      );
      if (fluentpersonArrowBack28Fi) {
        fluentpersonArrowBack28Fi.addEventListener("click", function (e) {
          window.location.href = "./onboarding.html";
        });
      }
      </script>
  </body>
</html>
