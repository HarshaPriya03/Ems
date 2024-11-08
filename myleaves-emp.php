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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600&display=swap" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <style>
      table {
        z-index: 100;
        border-collapse: collapse;
        /* border-radius: 200px; */
        background-color: white;
        /*   overflow: hidden; */
      }

      th,
      td {
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
    </style>
  </head>

  <body>
    <div class="myleaves">
      <div class="bg6"></div>
      <div class="rectangle-parent7">
        <div class="frame-child89">
        </div>
        <a class="frame-child91" href="./apply-leave-emp.php " style="margin-left: -300px;" id="rectangleLink2"> </a>
        <a class="frame-child92" style="margin-left: -300px;"> </a>
        <a class="apply-leave" href="./apply-leave-emp.php " style="margin-left: -300px; margin-top:-4px;" id="applyLeave">Apply Leave</a>
        <a class="my-leaves" style="margin-left: -310px; margin-top:-4px;">My Leaves</a>
        <a class="frame-child92" href="./lbhistory.php" style="margin-left: -65px; background-color:#E8E8E8"> </a>
        <a class="my-leaves" href="./lbhistory.php" style="margin-left: -85px; margin-top:-4px; color:black; width:200px">Leave History</a>
      </div>


      <img class="myleaves-child" alt="" src="./public/rectangle-1@2x.png" />

      <img class="myleaves-item" alt="" src="./public/rectangle-2@2x.png" />

      <img class="logo-1-icon6" alt="" src="./public/logo-1@2x.png" />

      <a class="anikahrm6" href="./employee-dashboard.php" id="anikaHRM">
        <span>Anika</span>
        <span class="hrm6">HRM</span>
      </a>
      <a class="leave-management" href="./employee-dashboard.php" id="leaveManagement" style="margin-top:-4px;">Leave Management</a>
      <button class="myleaves-inner"><a href="logout.php" style="margin-left:25px; color:white; text-decoration:none; font-size:25px">Logout</a></button>

      <a class="attendance6" style="margin-top: -50px;" id="attendance">Attendance</a>
      <a class="payroll6" href="card.php" style="margin-top: -50px;">Directory</a>
      <img class="uitcalender-icon6" alt="" src="./public/uitcalender.svg" />

      <img style="margin-top: -50px;" class="arcticonsgoogle-pay6" alt="" src="./public/arcticonsgooglepay.svg" />

      <img class="myleaves-child2" alt="" src="./public/rectangle-4@2x.png" />

      <a class="dashboard6" style="margin-top: 50px;" href="./employee-dashboard.php" id="dashboard">Dashboard</a>
      <a style="margin-top: 50px;" class="akar-iconsdashboard6" href="./employee-dashboard.php" id="akarIconsdashboard">
        <img class="vector-icon34" alt="" src="./public/vector3.svg" />
      </a>
      <img class="tablerlogout-icon6" alt="" src="./public/tablerlogout.svg" />

      <a class="uitcalender6" style="margin-top: -50px;" id="uitcalender">
        <img class="vector-icon35" alt="" src="./public/uitcalender.svg" />
      </a>
      <a class="leaves6">Leaves</a>
      <a class="fluentperson-clock-20-regular6">
        <img class="vector-icon36" style="-webkit-filter: grayscale(1) invert(1);
        filter: grayscale(1) invert(1);" alt="" src="./public/vector1.svg" />
      </a>
      <div class="rectangle-parent8">
        <?php
        $sql = "SELECT * FROM leavebalance WHERE empemail = '{$_SESSION['user_name']}'";
        $que = mysqli_query($con, $sql);
        $cnt = 1;
        if (mysqli_num_rows($que) == 0) {
          echo '<tr><td colspan="5" style="text-align:center;">Stay tuned for upcoming updates on your leave balance! Keep an eye on this space for exciting developments.</td></tr>';
        } else {
          while ($result = mysqli_fetch_assoc($que)) {
        ?>
            <a class="my-leaves" style="margin-left: -500px;width:600px;">Last Leave Balance Update: <?php echo date('Y-m-d H:i:s', strtotime($result['lastupdate'] . ' +5 hours +30 minutes')); ?> </a>
            <div class="frame-child93"></div>
            <p class="total-earned-11" style="width:300px;">Total Earned: <?php echo $result['icl'] + $result['isl']; ?></p>
            <p class="total-remaining-08" style='margin-left:35px'> Remaining: <?php echo $result['cl'] + $result['sl']; ?></p>
            <h3 class="casual-leave">Total Leaves</h3>
            <div class="frame-child99"></div>
            <img class="icoutline-sick-icon" alt="" src="./public/icoutlinesick.svg" />

            <img class="mingcuteflight-takeoff-line-icon" alt="" src="./public/mingcuteflighttakeoffline.svg" />

            <p class="total-earned-111" style="width:300px;">Total Earned: <?php echo $result['ico']; ?></p>
            <img class="icon-park-outlinenotes" alt="" src="./public/iconparkoutlinenotes.svg" />
            <p class="total-remaining-10" style='margin-left:35px'> Remaining: <?php echo $result['co']; ?></p>
            <h3 class="sick-leave" style="width:300px;">Comp. Off(s)</h3>
            <div class="frame-child100"></div>
            <p class="total-earned-22" style="width:300px;">Total Earned: <?php echo $result['ico'] + $result['icl'] + $result['isl']; ?></p>
            <p class="total-remaining-18" style='margin-left:35px'> Remaining: <?php echo $result['co'] + $result['cl'] + $result['sl']; ?></p>
            <h3 class="total-leaves" style="width:300px;">Leave Balance</h3>
            <img class="tablernotes-icon" alt="" src="./public/tablernotes.svg" />
        <?php
          }
        }
        ?>
      </div>
      <div style="width:2350px; position:absolute; height:400px; overflow-y:auto; margin-top: 600px;">
        <table class="data" style="margin-left:auto; margin-right:auto;  ">
    
          <tr>
            <th>Leave Type</th>
            <th>Applied On</th>
            <th>Leave Date(s)</th>
            <th>Reason</th>
            <th>Leave Status</th>
            <!--<th>Withdrawn Leave Bal.</th>-->
          </tr>
          <?php
          $sql = "SELECT * FROM leaves WHERE empemail = '{$_SESSION['user_name']}' ORDER BY ID DESC";
          $que = mysqli_query($con, $sql);
          $cnt = 1;
          if (mysqli_num_rows($que) == 0) {
            echo '<tr><td colspan="5" style="text-align:center;">No Leave Records</td></tr>';
          } else {
            while ($result = mysqli_fetch_assoc($que)) {
              $employeeSql = "SELECT pic FROM emp WHERE empname = '{$result['empname']}'";
              $employeeQuery = mysqli_query($con, $employeeSql);
              $employeeData = mysqli_fetch_assoc($employeeQuery);
          ?>
              <tr>
                <td><?php echo $result['leavetype']; ?></td>
                <td><?php
                    $status2 = isset($result['status2']) ? $result['status2'] : '';
                    ?>
                  <?php echo date('d-m-Y ', strtotime('+12 hours +30 minutes', strtotime($result['applied']))); ?> <BR>
                  <span style='font-size:16px; border-top:0.1px solid black; white-space:nowrap;'>
                    <?php echo ($status2 == '1') ? 'Thru HR' : 'self'; ?>
                  </span>
                </td>
                <?php
                $leavetype2 = $result['leavetype2'];

                if ($leavetype2 === 'FN' || $leavetype2 === 'AN') {
                  echo '<td data-label="From Date:">' . date('d-m-Y H:i', strtotime($result['from'])) . ' to ' . date('d-m-Y H:i', strtotime($result['to'])) . '</td>';
                } else {
                  echo '<td data-label="From Date:">' . date('d-m-Y', strtotime($result['from'])) . ' to ' . date('d-m-Y', strtotime($result['to'])) . '</td>';
                }
                ?>
                <td><span style="display:inline-block; max-width:300px; overflow:auto;"><?php echo $result['reason']; ?></span></td>
                <td> <?php
                      $status = $result['status'];
                      $status1 = $result['status1'];
                      ?>

                  <p class="pending">
                    <?php
                    if ($status == '2' && $status1 == '0') {
                      echo '<span class=\'bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 inline-flex items-center rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400\'>
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 24 24" fill="none" stroke="#d0021b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v18H3zM15 9l-6 6m0-6l6 6"/></svg>
       Rejected
      </span>';
                    } elseif ($status == '2' && $status1 == '1') {
                      echo '<span class=\'bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 inline-flex items-center rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400\'>
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 24 24" fill="none" stroke="#d0021b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v18H3zM15 9l-6 6m0-6l6 6"/></svg>
      Approver Rejected
      </span>';
                    } elseif (($status == '1' && $status1 == '1') || ($status == '1' && $status1 == '0')) {
                      echo '<span class=\'bg-green-100 text-green-800 text-xs font-medium inline-flex items-center me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400\'>
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 24 24" fill="none" stroke="#417505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
    Approved
      </span>';
                    } elseif ($status == '0' && $status1 == '0') {
                      echo '<span class=\'bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 inline-flex items-center rounded dark:bg-gray-700 dark:text-red-400 border border-red-400\'>
      <svg xmlns=\'http://www.w3.org/2000/svg\' width=\'22\' height=\'20\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'#fb0b0b\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'>
          <path d=\'M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z\'></path>
          <line x1=\'12\' y1=\'9\' x2=\'12\' y2=\'13\'></line>
          <line x1=\'12\' y1=\'17\' x2=\'12.01\' y2=\'17\'></line>
      </svg>
      HR-Action Pending
      </span>';
                    } elseif ($status == '3' && $status1 == '0') {
                      echo '<span class=\'bg-yellow-100 text-yellow-800 text-xs font-medium inline-flex items-center px-3 py-1.5 rounded dark:bg-gray-700 dark:text-yellow-400 border border-yellow-400\'>
        <svg class=\'w-3.5 h-5.5 me-1\' aria-hidden=\'true\' xmlns=\'http://www.w3.org/2000/svg\' fill=\'currentColor\' viewBox=\'0 0 20 20\'>
        <path d=\'M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z\'/>
        </svg>Pending at Approver
        </span>  <br>     <span style="font-size:16px;white-space:nowrap;">' . $result['aprname'] . '</span> ';
                    }
                    ?>
                  </p>
                </td>
                <td class="text-center">
                  <?php
                  if (
                    (($status == '1' && $status1 == '1') || ($status == '1' && $status1 == '0')) &&
                    strtotime($result['from']) >= strtotime('2024-02-01')
                  ) {
                    $fromDate = new DateTime($result['from']);
                    $toDate = new DateTime($result['to']);
                    if ($result['leavetype'] === "HALF DAY") {
                      echo '0.5';
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
                      echo $totalDays;
                    }
                  } else
                    echo "";
                  ?>
                </td>
              </tr>
          <?php
            }
          }
          ?>
        </table>
      </div>
    </div>


    <script>
      var rectangleLink = document.getElementById("rectangleLink");
      if (rectangleLink) {
        rectangleLink.addEventListener("click", function(e) {
          window.location.href = "./leave-management.php";
        });
      }

      var rectangleLink1 = document.getElementById("rectangleLink1");
      if (rectangleLink1) {
        rectangleLink1.addEventListener("click", function(e) {
          window.location.href = "./assign-leave.php";
        });
      }

      var rectangleLink2 = document.getElementById("rectangleLink2");
      if (rectangleLink2) {
        rectangleLink2.addEventListener("click", function(e) {
          window.location.href = "./apply-leave.php";
        });
      }

      var leavesList = document.getElementById("leavesList");
      if (leavesList) {
        leavesList.addEventListener("click", function(e) {
          window.location.href = "./leave-management.php";
        });
      }

      var assignLeave = document.getElementById("assignLeave");
      if (assignLeave) {
        assignLeave.addEventListener("click", function(e) {
          window.location.href = "./assign-leave.php";
        });
      }

      var applyLeave = document.getElementById("applyLeave");
      if (applyLeave) {
        applyLeave.addEventListener("click", function(e) {
          window.location.href = "./apply-leave.php";
        });
      }

      var anikaHRM = document.getElementById("anikaHRM");
      if (anikaHRM) {
        anikaHRM.addEventListener("click", function(e) {
          window.location.href = "./employee-dashboard.php";
        });
      }

      var leaveManagement = document.getElementById("leaveManagement");
      if (leaveManagement) {
        leaveManagement.addEventListener("click", function(e) {
          window.location.href = "./employee-dashboard.php";
        });
      }

      var onboarding = document.getElementById("onboarding");
      if (onboarding) {
        onboarding.addEventListener("click", function(e) {
          window.location.href = "./onboarding.php";
        });
      }

      var attendance = document.getElementById("attendance");
      if (attendance) {
        attendance.addEventListener("click", function(e) {
          window.location.href = "./attendenceemp2.php";
        });
      }

      var fluentMdl2leaveUser = document.getElementById("fluentMdl2leaveUser");
      if (fluentMdl2leaveUser) {
        fluentMdl2leaveUser.addEventListener("click", function(e) {
          window.location.href = "./onboarding.php";
        });
      }

      var dashboard = document.getElementById("dashboard");
      if (dashboard) {
        dashboard.addEventListener("click", function(e) {
          window.location.href = "./employee-dashboard.php";
        });
      }

      var fluentpeople32Regular = document.getElementById("fluentpeople32Regular");
      if (fluentpeople32Regular) {
        fluentpeople32Regular.addEventListener("click", function(e) {
          window.location.href = "./employee-management.php";
        });
      }

      var employeeList = document.getElementById("employeeList");
      if (employeeList) {
        employeeList.addEventListener("click", function(e) {
          window.location.href = "./employee-management.php";
        });
      }

      var akarIconsdashboard = document.getElementById("akarIconsdashboard");
      if (akarIconsdashboard) {
        akarIconsdashboard.addEventListener("click", function(e) {
          window.location.href = "./employee-dashboard.php";
        });
      }

      var uitcalender = document.getElementById("uitcalender");
      if (uitcalender) {
        uitcalender.addEventListener("click", function(e) {
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