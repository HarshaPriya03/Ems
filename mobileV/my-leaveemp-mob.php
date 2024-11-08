<?php
@include '../inc/config.php';
session_start();


if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Account Terminated',
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

            <div class="rectangle-group">
              <div class="rectangle-div"></div>
              <img class="mingcuteflight-takeoff-line-icon" alt="" src="./public/mingcuteflighttakeoffline.svg" />

              <p class="total-earned" style="width:200px;">Total Earned: <?php echo $result['ico']; ?></p>
              <p class="total-remaining" style="width:200px;">Total Remaining: <?php echo $result['co']; ?></p>
              <h3 class="casual-leave">Comp. Off(s)</h3>
            </div>
            <div class="rectangle-container">
              <div class="rectangle-div"></div>
              <img class="vector-icon6" alt="" src="./public/vector4@2xsick.png" />

              <p class="total-earned1" style="width:200px;">Total Earned: <?php echo $result['icl'] + $result['isl']; ?></p>
              <p class="total-remaining1" style="width:200px;">Total Remaining: <?php echo $result['cl'] + $result['sl']; ?></p>
              <h3 class="sick-leave">Total Leaves</h3>
            </div>
            <div class="frame-div">
              <div class="rectangle-div"></div>
              <img class="vector-icon7" alt="" src="./public/vector5@2xtotal.png" />

              <p class="total-earned2" style="width:200px;">Total Earned: <?php echo $result['ico'] + $result['icl'] + $result['isl']; ?></p>
              <p class="total-remaining2" style="width:200px;">Total Remaining:<?php echo $result['co'] + $result['cl'] + $result['sl']; ?></p>
              <h3 class="total-leaves">Total Leaves</h3>
            </div>
          </div>
      <?php
        }
      }
      ?>
      <div class="rectangle-parent23" style="margin-top: 240px; height: 240px;">
        <table class="data">
          <thead>
            <tr>
              <th data-label="Leave Type">Leave Type</th>
              <th data-label="Applied On">Applied On</th>
              <th data-label="Leave Date(s)">Leave Date(s)</th>
              <th data-label="Reason">Reason</th>
              <th data-label="Leave Status">Leave Status</th>
            </tr>
          </thead>
          <tbody>
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
                  <td data-label="Leave Type:"><?php echo $result['leavetype']; ?></td>
                  <td data-label="Applied On:"><?php
                                                $status2 = isset($result['status2']) ? $result['status2'] : '';
                                                ?>
                    <?php echo date('d-m-Y', strtotime($result['applied'])); ?>
                    <span style='font-size:16px; white-space:nowrap;'>
                      (<?php echo ($status2 == '1') ? 'Thru HR' : 'self'; ?>)
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
              <td data-label="Reason:">
    <button style="margin-top:10px;" data-modal-target="default-modal" data-modal-toggle="default-modal" data-reason="<?php echo $result['reason']; ?>" class="view-reason-button text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
        View Reason
    </button>
</td>

                  <!-- Main modal -->
                  <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Reason for leave
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <p id="reason-content" class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    <!-- Reason content will be dynamically set here -->
                </p>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
            </div>
        </div>
    </div>
</div>
                  <td data-label="Leave Status:"> <?php
                                                  $status = $result['status'];
                                                  $status1 = $result['status1'];
                                                  ?>

                    <p class="pending" style="margin-top:10px;">
                      <?php
                      if ($status == '2' && $status1 == '0') {
                        echo '<span class=\'bg-pink-100 text-pink-800 text-xs font-medium me-2 px-2.5 py-0.5 inline-flex items-center rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400\'>
      <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 24 24" fill="none" stroke="#d0021b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v18H3zM15 9l-6 6m0-6l6 6"/></svg>
       Rejected
      </span>';
                      } elseif ($status == '2' && $status1 == '1') {
                        echo '<span class=\'bg-pink-100 text-pink-800 text-xs font-medium me-2 px-0=2.5 py-0.5 inline-flex items-center rounded dark:bg-gray-700 dark:text-pink-400 border border-pink-400\'>
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
                </tr>
          </tbody>
      <?php
              }
            }
      ?>
        </table>
      </div>
      <div class="logo-1-container">
        <img class="logo-1-icon2" alt="" src="./public/logo-1@2x.png" />

        <a class="leaves-list">Leaves List</a>
      </div>
      <div class="myleaveemp-mob-child"></div>
      <div class="myleaveemp-mob-item"></div>
      <div class="rectangle-parent1" style="margin-left:-48px">
        <a class="frame-child3" id="rectangleLink"> </a>
        <a class="frame-child4"> </a>
        <a class="apply-leave" id="applyLeave">Apply Leave</a>
        <a class="my-leaves">My Leaves</a>
        <a class="frame-child3" href="lbhistory-mob.php" id="rectangleLink1" style="margin-left:200px;"> </a>
        <a class="apply-leave" href="lbhistory-mob.php" id="myLeaves" style="margin-left:196px; width:100px">Leave History</a>
      </div>
      <div class="uitcalender-parent">
        <a class="uitcalender2" id="uitcalender">
          <img class="vector-icon8" alt="" src="./public/vector2@2xatten.png" />
        </a>
        <img class="arcticonsgoogle-pay2" alt="" src="./public/arcticonsgooglepay1@2x.png" id="arcticonsgooglePay" />

        <div class="frame-child5"></div>
        <a class="akar-iconsdashboard2" id="akarIconsdashboard">
          <img class="vector-icon9" alt="" src="./public/vector1dash.svg" />
        </a>
        <a class="fluentperson-clock-20-regular2">
          <img class="vector-icon10" alt="" src="./public/vector6@2xleaveblack.png" />
        </a>
      </div>
    </div>
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