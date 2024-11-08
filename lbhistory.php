<?php
@include 'inc/config.php';
session_start();


if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Account Terminated',
              text: 'Contact HR, also check your mail for more info.',
            }).then(function() {
              window.location.href = 'loginpage.php';
            });
          });
        </script>";
  exit();
}
$sqlStatusCheck = "SELECT empstatus FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultStatusCheck = mysqli_query($con, $sqlStatusCheck);
$statusRow = mysqli_fetch_assoc($resultStatusCheck);

if ($statusRow['empstatus'] == 0) {
  ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./my-leaves.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap"
    />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   
    <style>
       table {
        z-index: 100;
  border-collapse: collapse;
  /* border-radius: 200px; */
  background-color: white;
/*   overflow: hidden; */
}

th, td {
  padding: 1em;
  background: white;
  color: rgb(52, 52, 52);
  border-bottom: 2px solid rgb(193, 193, 193); 
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
    .udbtn:hover {
            color: black !important;
            background-color: white !important;
            outline: 1px solid #F46114;
        }
    </style>
  </head>
  <body>
    <div class="myleaves">
      <div class="bg6"></div>
      <div class="rectangle-parent7">
        <div class="frame-child89">
      </div>
            <a class="frame-child91" href="./apply-leave-emp.php "  style="margin-left: -300px;" id="rectangleLink2"> </a>
            <a class="frame-child92" href="./myleaves-emp.php"  style="margin-left: -300px; background-color:#E8E8E8;"> </a>
        <a class="apply-leave" href="./apply-leave-emp.php "  style="margin-left: -300px; margin-top:-4px;" id="applyLeave">Apply Leave</a>
        <a class="my-leaves" href="./myleaves-emp.php"  style="margin-left: -310px; margin-top:-4px; color:black;">My Leaves</a>
        <a class="frame-child92" href="./lbhistory.php"  style="margin-left: -65px; background-color:#ffe2c6"> </a>
        <a class="my-leaves" href="./lbhistory.php"  style="margin-left: -85px; margin-top:-4px; color:#ff5400; width:200px">Leave History</a>
      </div>
     
      
      <img class="myleaves-child" alt="" src="./public/rectangle-1@2x.png" />

      <img class="myleaves-item" alt="" src="./public/rectangle-2@2x.png" />

      <img class="logo-1-icon6" alt="" src="./public/logo-1@2x.png" />

      <a class="anikahrm6" href="./employee-dashboard.php" id="anikaHRM">
        <span>Anika</span>
        <span class="hrm6">HRM</span>
      </a>
      <a class="leave-management" href="./employee-dashboard.php" id="leaveManagement" style="margin-top:-4px;"
        >Leave Management</a
      >
      <button class="myleaves-inner"><a  href="logout.php" style="margin-left:25px; color:white; text-decoration:none; font-size:25px">Logout</a></button>
 
      <a class="attendance6" style="margin-top: -50px; z-index:999999;" href="./attendenceemp2.php" id="attendance">Attendance</a>
      <a class="payroll6" href="./card.php" style="margin-top: -50px; z-index:999999; color:black; text-decoration:none;">Directory</a>
      <img class="uitcalender-icon6" alt="" src="./public/uitcalender.svg" />

      <img style="margin-top: -50px;"
        class="arcticonsgoogle-pay6"
        alt=""
        src="./public/arcticonsgooglepay.svg"
      />

      <img class="myleaves-child2" alt="" src="./public/rectangle-4@2x.png" />

      <a class="dashboard6" style="margin-top: 50px; z-index:9999;" href="./employee-dashboard.php" id="dashboard">Dashboard</a>
      <a style="margin-top: 50px;"
        class="akar-iconsdashboard6"
        href="./employee-dashboard.php"
        id="akarIconsdashboard"
      >
        <img class="vector-icon34" alt=""  src="./public/vector3.svg" />
      </a>
      <img class="tablerlogout-icon6" alt="" src="./public/tablerlogout.svg" />

      <a class="uitcalender6" style="margin-top: -50px;" id="uitcalender">
        <img class="vector-icon35" alt="" src="./public/uitcalender.svg" />
      </a>
      <a class="leaves6" href="apply-leave-emp.php" style="z-index:9999;">Leaves</a>
      <a class="fluentperson-clock-20-regular6">
        <img class="vector-icon36" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector1.svg" />
      </a>
         <div style="position:absolute;  margin-top: 180px; left:0; padding-left:450px;
  right: 0; 
  margin-left: auto; 
  margin-right: auto; ">
         <table class="data" style="margin-left:auto; margin-right:auto; ">
         <tr class='header-row'>
            <th colspan="5" style="font-size:14px;">Indications: LB = Leave Balance , D/A = Deductions/Allocations</th>
          </tr>
          <tr>
    <th colspan="5" style="font-size:14px;">*Total Leave Balance Allocated</th>
    </tr>
    <tr>
        <th class="text-center">Transaction</th>
        <th >D/A</th>
        <th class="text-center">Description</th>
        <th></th>
        <th >Transaction Time</th>
    </tr>
    <?php
  $sql = "SELECT leaves.*, lb.iupdate, lb.icl, lb.isl, lb.ico,lb.cl, lb.sl, lb.co, leaves.status,  leaves.status1
  FROM leaves 
  INNER JOIN leavebalance lb ON leaves.empemail = lb.empemail
  WHERE leaves.empemail = '{$_SESSION['user_name']}'
  AND leaves.applied > '2024-02-01'
  ORDER BY leaves.ID DESC";

    $que = mysqli_query($con, $sql);
    $cnt = 1;
    $totalLeaves = 0;

    if (mysqli_num_rows($que) == 0) {
        echo '<tr><td colspan="5" style="text-align:center;">No Leave Records</td></tr>';
    } else {
        while ($result = mysqli_fetch_assoc($que)) {
            $employeeSql = "SELECT pic FROM emp WHERE empname = '{$result['empname']}'";
            $employeeQuery = mysqli_query($con, $employeeSql);
            $employeeData = mysqli_fetch_assoc($employeeQuery);
            ?>
            <?php
              $status = $result['status'];
              $status1 = $result['status1'];
if (($status == '1' && $status1 == '1') || ($status == '1' && $status1 == '0')) {
    ?>
            <tr>
                <td style="text-align:center;">Deducted</td>
                <td class="text-center">
                    <?php
                    $status = $result['status'];
                    $status1 = $result['status1'];

                    if (
                        (($status == '1' && $status1 == '1') || ($status == '1' && $status1 == '0')) &&
                        strtotime($result['from']) >= strtotime('2024-02-01')
                    ) {
                        $fromDate = new DateTime($result['from']);
                        $toDate = new DateTime($result['to']);
                        if ($result['leavetype'] === "HALF DAY") {
                            echo '<span style="color:red;">' . '- 0.5' . '</span>';
                        } else {
                            $toDate->modify('+1 day');

                            $interval = new DateInterval('P1D');
                            $dateRange = new DatePeriod($fromDate, $interval, $toDate);

                            $fetchHolidaysQuery = "SELECT `date` FROM holiday";
                            $holidaysResult = mysqli_query($con, $fetchHolidaysQuery);
                            $holidayDates = [];

                            while ($row = mysqli_fetch_assoc($holidaysResult)) {
                                $holidayDates[] = $row['date'];
                            }

                            $excludedDays = 0;

                            foreach ($dateRange as $date) {
                                if ($date->format('w') != 0 && !in_array($date->format('Y-m-d'), $holidayDates)) {
                                    $excludedDays++;
                                }
                            }

                            $totalDays = $excludedDays;
                            $totalLeaves += $totalDays;
                            echo '<span style="color:red;">' . '-' . $totalDays . '</span>';

                            $cl= $result['icl'];
                            $sl= $result['isl'];
                            $co= $result['ico'];
                            
                            $cl1= $result['cl'];
                            $sl1= $result['sl'];
                            $co1= $result['co'];
                            $itime= $result['iupdate'];
                            $allocated = $result['icl'] + $result['isl'] + $result['ico'];
                            $avail =($result['cl'] + $result['sl'] + $result['co']);
                            $deduct =  $allocated - ($result['cl'] + $result['sl'] + $result['co']);
                        }
                    } else {
                        echo "";
                    }
                    ?>
                </td>
                <td>for <?php echo $result['leavetype'];?>
               from <?php echo date('d-m-Y', strtotime($result['from'])); ?> to <?php echo date('d-m-Y', strtotime($result['to'])); ?></td>
               <td>

               </td>
              
                  <td><?php echo date('Y-m-d H:i:s', strtotime($result['mgrtime'] . ' +5 hours +30 minutes'));?></td>
            </tr>
            <?php
        }
    }
}
    ?>
    <?php 
    $sql = "SELECT lb.iupdate,lb.lastupdate, lb.icl, lb.isl, lb.ico, lb.cl, lb.sl, lb.co
    FROM leavebalance lb
    WHERE lb.empemail = '{$_SESSION['user_name']}'";

    
        $que = mysqli_query($con, $sql);
        if (mysqli_num_rows($que) == 0) {
            echo '<tr><td colspan="5" style="text-align:center;">No Leave Records</td></tr>';
        } else {
            while ($result = mysqli_fetch_assoc($que)) {
    $cl= $result['icl'];
                            $sl= $result['isl'];
                            $co= $result['ico'];
                            
                            $cl1= $result['cl'];
                            $sl1= $result['sl'];
                            $co1= $result['co'];
                            $itime= date('Y-m-d H:i:s', strtotime($result['iupdate'] . ' +5 hours +30 minutes'));
                            $ltime= date('Y-m-d H:i:s', strtotime($result['lastupdate'] . ' +5 hours +30 minutes'));
                            $allocated = $result['icl'] + $result['isl'] + $result['ico'];
                            $avail =($result['cl'] + $result['sl'] + $result['co']);
                            $deduct =  $allocated - ($result['cl'] + $result['sl'] + $result['co']);
                            ?>
    <tr style="border-top:3px solid black;">
        <td >Total LB Allocated* :</td>
        <td style="padding-left:-100px;color:green;">+<?php echo $allocated; ?></td>
        <td style="text-align:center;"></td>
        <td></td>
        <td><?php echo $itime; ?></td>
    </tr>
    <tr>
    <td colspan=2>Total Deductions : <span style="padding-left:60px !important;color:red;">-<?php echo $deduct; ?> </span></td>
    <td colspan=3 style="text-align:center;"></td>
    </tr>
    <tr style="border-bottom:2.5px solid black;">
    <td colspan=2 <?php echo ($avail >= 0) ? 'style="color:green;font-weight:bold;"' : 'style="color:red;font-weight:bold;"'; ?>>
    Available Balance: <span style="padding-left:70px;"><?php echo $avail; ?></span>
</td>
<td style="text-align:center;"></td>
<td colspan=2 ><span style="margin-left:-70px;">Updated as of <?php echo $ltime; ?></span></td>
    </tr>
    <?php
            }
        }
        ?>
        <tr>
            <td colspan="5">
            <a class="btn udbtn" style="background-color: #FB8A0B; color: white;" href="print-detailslh.php?user_name=<?php echo urlencode($_SESSION['user_name']); ?>" target="_blank">Download</a>
            </td>
        </tr>
</table>

      </div>
    </div>
    

    <script>
      var rectangleLink = document.getElementById("rectangleLink");
      if (rectangleLink) {
        rectangleLink.addEventListener("click", function (e) {
          window.location.href = "./leave-management.php";
        });
      }
      
      var rectangleLink1 = document.getElementById("rectangleLink1");
      if (rectangleLink1) {
        rectangleLink1.addEventListener("click", function (e) {
          window.location.href = "./assign-leave.php";
        });
      }
      
      var rectangleLink2 = document.getElementById("rectangleLink2");
      if (rectangleLink2) {
        rectangleLink2.addEventListener("click", function (e) {
          window.location.href = "./apply-leave.php";
        });
      }
      
      var leavesList = document.getElementById("leavesList");
      if (leavesList) {
        leavesList.addEventListener("click", function (e) {
          window.location.href = "./leave-management.php";
        });
      }
      
      var assignLeave = document.getElementById("assignLeave");
      if (assignLeave) {
        assignLeave.addEventListener("click", function (e) {
          window.location.href = "./assign-leave.php";
        });
      }
      
      var applyLeave = document.getElementById("applyLeave");
      if (applyLeave) {
        applyLeave.addEventListener("click", function (e) {
          window.location.href = "./apply-leave.php";
        });
      }
      
      var anikaHRM = document.getElementById("anikaHRM");
      if (anikaHRM) {
        anikaHRM.addEventListener("click", function (e) {
          window.location.href = "./employee-dashboard.php";
        });
      }
      
      var leaveManagement = document.getElementById("leaveManagement");
      if (leaveManagement) {
        leaveManagement.addEventListener("click", function (e) {
          window.location.href = "./employee-dashboard.php";
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
          window.location.href = "./attendenceemp2.php";
        });
      }
      
      var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
      if (fluentMdl2leaveUser) {
        fluentMdl2leaveUser.addEventListener("click", function (e) {
          window.location.href = "./onboarding.php";
        });
      }
      
      var dashboard = document.getElementById("dashboard");
      if (dashboard) {
        dashboard.addEventListener("click", function (e) {
          window.location.href = "./employee-dashboard.php";
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
          window.location.href = "./employee-dashboard.php";
        });
      }
      
      var uitcalender = document.getElementById("uitcalender");
      if (uitcalender) {
        uitcalender.addEventListener("click", function (e) {
          window.location.href = "./attendenceemp2.php";
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
              icon: 'error',
              title: 'Account Terminated',
              text: 'Contact HR, also check your mail for more info.',
            }).then(function() {
              window.location.href = 'loginpage.php';
            });
          });
        </script>";
  exit();
}
?>