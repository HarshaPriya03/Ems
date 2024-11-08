<?php
@include '../inc/config.php';
session_start();


if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Session Terminated',
              text: 'Login Again, if your still facing issues Contact HR!',
            }).then(function() {
              window.location.href = 'login-mob.php';
            });
          });
        </script>";
  exit();
}
$sqlStatusCheck = "SELECT empstatus FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultStatusCheck = mysqli_query($con, $sqlStatusCheck);
$statusRow = mysqli_fetch_assoc($resultStatusCheck);

$sqlEmployeeName = "SELECT empname,desg,empph FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultEmployeeName = mysqli_query($con, $sqlEmployeeName);
$employeeNameRow = mysqli_fetch_assoc($resultEmployeeName);
$employeeName = $employeeNameRow['empname'];
$employeeDesg = $employeeNameRow['desg'];
$employeePhone = $employeeNameRow['empph'];

if ($statusRow['empstatus'] == 0) {
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="./empmobcss/globalqw.css" />
    <link rel="stylesheet" href="./empmobcss/apply-leaveemp-mob.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
      .logo-1-icon10 {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 55px;
        height: 55px;
        object-fit: cover;
      }

      table {
        border: 1px solid #ccc;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        width: 100%;
        table-layout: fixed;
        font-size: 10px !important;
      }

      table tr {
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        padding: .35em;
      }

      table th,
      table td {
        padding: .55em;
        text-align: center;
      }

      table th {
        font-size: .55em;
        letter-spacing: .1em;
        text-transform: uppercase;
      }

      @media screen and (max-width: 200px) {
        table {
          border: 0;
          font-size: 10px !important;
        }

        table caption {
          font-size: 1.3em;
        }

        table thead {
          border: none;
          clip: rect(0 0 0 0);
          height: 1px;
          margin: -1px;
          overflow: hidden;
          padding: 0;
          position: absolute;
          width: 1px;
        }

        table tr {
          border-bottom: 3px solid #ddd;
          display: block;
          margin-bottom: .625em;
        }

        table td {
          border-bottom: 1px solid #ddd;
          display: block;
          font-size: 10px;
          text-align: right;
        }

        table td::before {
          /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
          content: attr(data-label);
          float: left;
          font-weight: bold;
          text-transform: uppercase;
        }

        table td:last-child {
          border-bottom: 0;
        }
      }

      .udbtn:hover {
        color: black !important;
        background-color: white !important;
        outline: 1px solid #F46114;
      }
    </style>
  </head>

  <body>
    <div class="applyleaveemp-mob" style="height: 100svh;">
      <div class="rectangle-parent2">
        <table class="data" style="scale:0.95;">
          <tr class='header-row'>
            <th colspan="5" style="font-size:8px;white-space:nowrap;">Indications: LB = Leave Balance , D/A = Deductions/Allocations</th>
          </tr>
          <tr>
            <th colspan="5" style="font-size:8px;">*Total Leave Balance Allocated</th>
          </tr>
          <tr>
            <th class="text-center" style="font-size:8px;">Transaction</th>
            <th style="font-size:8px;">D/A</th>
            <th class="text-center" style="font-size:8px;">Description</th>
            <th></th>
           <th style="font-size:7.5px;">Transaction Time</th>
          </tr>
          <?php
          $sql = "SELECT leaves.*, lb.iupdate, lb.icl, lb.isl, lb.ico, lb.cl, lb.sl, lb.co, leaves.status,  leaves.status1
            FROM leaves 
            INNER JOIN leavebalance lb ON leaves.empemail = lb.empemail
            WHERE leaves.empemail = '{$_SESSION['user_name']}'
            AND leaves.applied > '2024-02-01'
            ORDER BY leaves.ID DESC";

          $que = mysqli_query($con, $sql);
          $totalLeaves = 0;

          if (mysqli_num_rows($que) == 0) {
            echo '<tr><td colspan="5" style="text-align:center;">No Leave Records</td></tr>';
          } else {
            while ($result = mysqli_fetch_assoc($que)) {
              $status = $result['status'];
              $status1 = $result['status1'];
              if (($status == '1' && $status1 == '1') || ($status == '1' && $status1 == '0')) {
                echo '<tr>';
                echo '<td style="text-align:center;">Withdrawn</td>';
                echo '<td class="text-center">';

                $status = $result['status'];
                $status1 = $result['status1'];

                if (($status == '1' && $status1 == '1') || ($status == '1' && $status1 == '0')) {
                  $fromDate = new DateTime($result['from']);
                  $toDate = new DateTime($result['to']);
                  if ($result['leavetype'] === "HALF DAY") {
                    // echo '-0.5';
                    echo '<span style="color:red;">-0.5</span>';
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
                    echo '<span style="color:red;">-' . $totalDays . '</span>';
                  }
                } else {
                  echo "";
                }
                echo '</td>';
                echo '<td  style="font-size:8px;">for ' . $result['leavetype'] . ' from ' . date('d-m-Y', strtotime($result['from'])) . ' to ' . date('d-m-Y', strtotime($result['to'])) . '</td>';
                echo '<td></td>';
                echo '<td style="font-size:8px;">' . date('Y-m-d H:i:s', strtotime($result['mgrtime'] . ' +5 hours +30 minutes')) . '</td>';
                echo '</tr>';
              }
            }
          }
          ?>
          <?php
          $sql = "SELECT lb.iupdate, lb.lastupdate, lb.icl, lb.isl, lb.ico, lb.cl, lb.sl, lb.co
            FROM leavebalance lb
            WHERE lb.empemail = '{$_SESSION['user_name']}'";


          $que = mysqli_query($con, $sql);
          if (mysqli_num_rows($que) > 0) {
            while ($result = mysqli_fetch_assoc($que)) {
              echo '<tr style="border-top:3px solid black;">';
              echo '<td>Total LB Allocated* :</td>';
              echo '<td style="padding-left:-100px;color:green;">+' . ($result['icl'] + $result['isl'] + $result['ico']) . '</td>';
              echo '<td style="text-align:center;"></td>';
              echo '<td></td>';
              echo '<td style="font-size:8px;">' . date('Y-m-d H:i:s', strtotime($result['iupdate'] . ' +5 hours +30 minutes')) . '</td>';
              echo '</tr>';
              echo '<tr>';
              echo '<td>Total Deductions:</td>';
              echo '<td><span style="margin-right:0px !important;color:red;">-' . ($result['icl'] + $result['isl'] + $result['ico'] - ($result['cl'] + $result['sl'] + $result['co'])) . '</span></td>';
              echo '<td colspan=3 style="text-align:center;"></td>';
              echo '</tr>';
              echo '<tr style="border-bottom:2.5px solid black;">';
              echo '<td colspan=2 style="' . (($result['cl'] + $result['sl'] + $result['co']) >= 0 ? 'color:green;font-weight:bold;' : 'color:red;font-weight:bold;') . '"><span style="margin-left:-15px">Available Balance:</span> <span style="padding-left:0px;">' . ($result['cl'] + $result['sl'] + $result['co']) . '</span></td>';
              echo '<td style="text-align:center;"></td>';
              echo '<td colspan=2 ><span style="margin-left:-70px;">Updated as of ' . date('Y-m-d H:i:s', strtotime($result['lastupdate'] . ' +5 hours +30 minutes')) . '</span></td>';
              echo '</tr>';
            }
          } else {
            echo '<tr><td colspan="5" style="text-align:center;">No Leave Records</td></tr>';
          }
          ?>
          <tr>
            <td colspan="5">
              <a class="btn udbtn" style="background-color: #FB8A0B; color: white;" href="../print-detailslh.php?user_name=<?php echo urlencode($_SESSION['user_name']); ?>" target="_blank">Download</a>
            </td>
          </tr>
        </table>

      </div>
      <div class="logo-1-parent1">
        <img class="logo-1-icon3" alt="" src="./public/logo-1@2x.png" />

        <a class="leaves-list1">Leaves List</a>
      </div>
      <a href="../logout.php"><img class="logo-1-icon10" alt="" src="./public/Logout-removebg-preview.png" /></a>
      <div class="applyleaveemp-mob-child"></div>
      <div class="applyleaveemp-mob-item"></div>
      <div class="uitcalender-group">
        <a class="uitcalender3" id="uitcalender">
          <img class="vector-icon11" alt="" src="./public/vector2@2xatten.png" />
        </a>
        <img class="arcticonsgoogle-pay3" alt="" src="./public/arcticonsgooglepay1@2x.png" id="arcticonsgooglePay" />

        <div class="frame-child10"></div>
        <a class="akar-iconsdashboard3" id="akarIconsdashboard">
          <img class="vector-icon12" alt="" src="./public/vector1dash.svg" />
        </a>
        <a class="fluentperson-clock-20-regular3">
          <img class="vector-icon13" alt="" src="./public/vector6@2xleaveblack.png" />
        </a>
      </div>
      <div class="rectangle-parent3" style="margin-left:-48px">
        <a class="frame-child11" style="background-color:#e8e8e8;" href="apply-leaveemp-mob.php"> </a>
        <a class="frame-child12" id="rectangleLink1"> </a>
        <a class="apply-leave2" style="color:black;" href="apply-leaveemp-mob.php">Apply Leave</a>
        <a class="my-leaves1" id="myLeaves">My Leaves</a>
        <a class="frame-child12" href="lbhistory-mob.php" id="rectangleLink1" style="margin-left:100px; background-color:#ffe2c6;"> </a>
        <a class="my-leaves1" href="lbhistory-mob.php" id="myLeaves" style="margin-left:93px; width:100px; color:#ff5400;">Leave History</a>
      </div>

      <script>
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

        var rectangleLink1 = document.getElementById("rectangleLink1");
        if (rectangleLink1) {
          rectangleLink1.addEventListener("click", function(e) {
            window.location.href = "./my-leaveemp-mob.php";
          });
        }

        var myLeaves = document.getElementById("myLeaves");
        if (myLeaves) {
          myLeaves.addEventListener("click", function(e) {
            window.location.href = "./my-leaveemp-mob.php";
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
              window.location.href = 'login-mob.php';
            });
          });
        </script>";
  exit();
}
?>