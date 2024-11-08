<?php include('inc/config.php'); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./css/global.css" />
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

    <div class="onboarding17">
      <div class="bg15"></div>
      <img class="onboarding-child" alt="" src="./public/rectangle-1@2x.png" />

      <img class="onboarding-item" alt="" src="./public/rectangle-2@2x.png" />

      <img class="logo-1-icon15" alt="" src="./public/logo-1@2x.png" />

      <a class="anikahrm15" href="./index.php" id="anikaHRM">
        <span>Anika</span>
        <span class="hrm15">HRM</span>
      </a>
      <a class="onboarding18" href="./index.php" id="onboarding"
        >Onboarding</a
      >
      <button class="onboarding-inner"><a href="logout.php" style="color:white; text-decoration:none; font-size:25px; margin-left:20px;">Logout</a></button>
      <a class="attendance15" id="attendance">Attendance</a>
      <a href="./Payroll/payroll.php" class="payroll15" style="text-decoration:none; color:black;">Payroll

      <?php if($count_payroll > 0) { ?>
        <span class="circle"><?php echo $count_payroll; ?></span>
      <?php } ?>
      </a>
      <a href="./Reports/reports.php" class="reports15">Reports</a>
      <img class="uitcalender-icon15" alt="" src="./public/uitcalender.svg" />

      <img
        class="arcticonsgoogle-pay15"
        alt=""
        src="./public/arcticonsgooglepay.svg"
      />

      <img
        class="streamlineinterface-content-c-icon15"
        alt=""
        src="./public/streamlineinterfacecontentchartproductdataanalysisanalyticsgraphlinebusinessboardchart.svg"
      />

      <!--<img class="onboarding-child1" alt="" src="./public/ellipse-1@2x.png" />-->

      <!--<img-->
      <!--  class="material-symbolsperson-icon15"-->
      <!--  alt=""-->
      <!--  src="./public/materialsymbolsperson.svg"-->
      <!--/>-->

      <img class="onboarding-child2" alt="" src="./public/rectangle-4@2x.png" />

      <a class="dashboard15" href="./index.php" id="dashboard">Dashboard</a>
      <a class="fluentpeople-32-regular15" id="fluentpeople32Regular">
        <img class="vector-icon78" alt="" src="./public/vector7.svg" />
      </a>
      <a class="employee-list15" id="employeeList">Employee List</a>
      <a
        class="akar-iconsdashboard15"
        href="./index.php"
        id="akarIconsdashboard"
      >
        <img class="vector-icon79" alt="" src="./public/vector3.svg" />
      </a>
      <img class="tablerlogout-icon15" alt="" src="./public/tablerlogout.svg" />

      <a class="uitcalender15" id="uitcalender">
        <img class="vector-icon80" alt="" src="./public/vector4.svg" />
      </a>
      <a class="leaves15" id="leaves">Leaves

      <?php if($count_leaves > 0) { ?>
        <span class="circle"><?php echo $count_leaves; ?></span>
      <?php } ?>
      </a>
      <a
        class="fluentperson-clock-20-regular15"
        id="fluentpersonClock20Regular"
      >
        <img class="vector-icon81" alt="" src="./public/vector1.svg" />
      </a>
      <a class="onboarding19">Onboarding</a>
      <a class="fluent-mdl2leave-user15">
        <img class="vector-icon82" alt="" src="./public/vector8.svg" />
      </a>
      <div class="rectangle-parent24 style="margin-left:300px;margin-top:20px;">
        <!-- <div class="frame-child203"></div> -->
    <table class="data w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" style=" margin-left:auto;margin-right:auto;">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                      <th scope="col" class="px-6 py-3">
                          S.No.
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Full Name
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Phone
                      </th>
                       <th scope="col" class="px-6 py-3">
                          Email
                      </th>
                      <th scope="col" class="px-6 py-3">
                          Action
                      </th>
                  </tr>
              </thead>
          <?php
          $sql = "SELECT * FROM onb  WHERE status=0 ORDER BY id DESC";
           $que = mysqli_query($con,$sql);
           $cnt = 1;
           if(mysqli_num_rows($que) > 0)
                                        {
                                            foreach($que as $result) 
                                            { ?>
          <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          <td class="px-6 py-4"><?php echo $cnt;?></td>
            <td class="px-6 py-4"><?php echo $result['empname'];?></td>
            <td class="px-6 py-4"><?php echo $result['empph'];?></td>
            <td class="px-6 py-4"><?php echo $result['empemail'];?></td>
            <td class="px-6 py-4"> <a style="text-decoration: none; color: goldenrod;" href="employee-approval.php?id=<?php echo $result['ID']; ?>" ><img src="./public/group.svg" width="25px" style="display:block;margin-left:auto; margin-right:auto;" /></a> </td>
          </tr>
          <?php $cnt++;
                                            }
                                        }
                                        else
                                        {
                                            ?>
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td class="px-6 py-4" colspan="5" style="text-align: center;">No Onboarding Requests</td>
                                            </tr>
                                            <?php 
                                        }
                                    ?>
                                    

        </table>
       

        
      </div>
    </div>

    <script>
      var anikaHRM = document.getElementById("anikaHRM");
      if (anikaHRM) {
        anikaHRM.addEventListener("click", function (e) {
          window.location.href = "./index.php";
        });
      }
      
      var onboarding = document.getElementById("onboarding");
      if (onboarding) {
        onboarding.addEventListener("click", function (e) {
          window.location.href = "./index.php";
        });
      }
      
      var attendance = document.getElementById("attendance");
      if (attendance) {
        attendance.addEventListener("click", function (e) {
          window.location.href = "./attendence.php";
        });
      }
      
      var dashboard = document.getElementById("dashboard");
      if (dashboard) {
        dashboard.addEventListener("click", function (e) {
          window.location.href = "./index.php";
        });
      }
      
      var fluentpeople32Regular = document.getElementById("fluentpeople32Regular");
      if (fluentpeople32Regular) {
        fluentpeople32Regular.addEventListener("click", function (e) {
          window.location.href = "./employee-management.php";
        });
      }
      
      var employeeList = document.getElementById("employeeList");
      if (employeeList) {
        employeeList.addEventListener("click", function (e) {
          window.location.href = "./employee-management.php";
        });
      }
      
      var akarIconsdashboard = document.getElementById("akarIconsdashboard");
      if (akarIconsdashboard) {
        akarIconsdashboard.addEventListener("click", function (e) {
          window.location.href = "./index.php";
        });
      }
      
      var uitcalender = document.getElementById("uitcalender");
      if (uitcalender) {
        uitcalender.addEventListener("click", function (e) {
          window.location.href = "./attendence.php";
        });
      }
      
      var leaves = document.getElementById("leaves");
      if (leaves) {
        leaves.addEventListener("click", function (e) {
          window.location.href = "./leave-management.php";
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
      
      var akarIconsedit9 = document.getElementById("akarIconsedit9");
      if (akarIconsedit9) {
        akarIconsedit9.addEventListener("click", function (e) {
          window.location.href = "./employee-approval.php";
        });
      }
      </script>
  </body>
</html>
