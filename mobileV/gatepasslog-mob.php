<?php
$con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");
session_start();
$hrmsHost = "localhost";
$hrmsUser = "Anika12";
$hrmsPassword = "Anika12";
$hrmsDatabase = "ems";

$leaveManagementHost = "localhost";
$leaveManagementUser = "Anika12345";
$leaveManagementPassword = "Anika12345";
$leaveManagementDatabase = "simpleave";
$hrmsCon = mysqli_connect($hrmsHost, $hrmsUser, $hrmsPassword, $hrmsDatabase);

if (!$hrmsCon) {
  die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
  echo "";
  exit();
}

$sqlStatusCheck = "SELECT empstatus FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
$resultStatusCheck = mysqli_query($hrmsCon, $sqlStatusCheck);
$statusRow = mysqli_fetch_assoc($resultStatusCheck);

if ($statusRow['empstatus'] == 0) {
  $sqlHRMS = "SELECT * FROM emp WHERE empemail = '{$_SESSION['user_name']}'";
  $resultHRMS = mysqli_query($hrmsCon, $sqlHRMS);

  $rowHRMS = mysqli_fetch_assoc($resultHRMS);

  if ($resultHRMS) {
    $leaveManagementCon = mysqli_connect($leaveManagementHost, $leaveManagementUser, $leaveManagementPassword, $leaveManagementDatabase);

    if (!$leaveManagementCon) {
      die("Connection failed: " . mysqli_connect_error());
    }
?>
    <!DOCTYPE html>
    <html>

    <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="initial-scale=1, width=device-width" />

      <link rel="stylesheet" href="./empmobcss/globalqw.css" />
      <link rel="stylesheet" href="./empmobcss/gatepasslog-mob.css" />
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" />
    </head>

    <body>
      <div class="gatepasslog-mob" style="height: 100svh;">
        <div class="logo-1-parent2">
          <img class="logo-1-icon4" alt="" src="./public/logo-1@2x.png" />

          <a class="gatepass-log">Gatepass Log</a>
        </div>
        <div class="gatepasslog-mob-child"></div>
        <div class="fluentperson-clock-20-regular-parent">
          <a class="fluentperson-clock-20-regular4" id="fluentpersonClock20Regular">
            <img class="vector-icon14" alt="" src="./public/vector1@2xleaves.png" />
          </a>
          <a class="uitcalender4" id="uitcalender">
            <img class="vector-icon15" alt="" src="./public/vector2@2xatten.png" />
          </a>
          <img class="arcticonsgoogle-pay4" alt="" src="./public/arcticonsgooglepay1@2x.png" id="arcticonsgooglePay" />

          <div class="frame-child13"></div>
          <a class="akar-iconsdashboard4" href="emp-dashboard-mob.php">
            <img class="vector-icon16" alt="" src="./public/vector.svg" />
          </a>
        </div>
        <div class="tick-1-parent">
          <img class="tick-1-icon" alt="" src="./public/tick-1@2x.png" />

          <img class="cross-1-icon" alt="" src="./public/cross-1@2x.png" />

          <img class="image-2024-01-07-102229154-rem-icon" alt="" src="./public/image-20240107-102229154removebgpreview-1@2x.png" />

          <img class="screenshot-2024-01-07-101946-r-icon" alt="" src="./public/screenshot-20240107-101946removebgpreview-1@2x.png" />

          <div class="one-way-pass-container">
            <p class="one-way">One way</p>
            <p class="one-way">pass</p>
          </div>
          <div class="employee-marked-in-container">
            <p class="one-way">Employee</p>
            <p class="one-way">marked in</p>
          </div>
          <div class="gatepass-rejected">
            <p class="one-way">Gatepass</p>
            <p class="one-way">Rejected</p>
          </div>
          <div class="employee-yet-to-container">
            <p class="one-way">Employee yet</p>
            <p class="one-way">to mark in</p>
          </div>
        </div>
        <div class="rectangle-parent4" style="height:71svh; overflow-y:auto; width:450px">
          <?php
          $sqlLeaveManagement = "SELECT * FROM leaves WHERE mobile = '{$rowHRMS['empph']}' ORDER BY id DESC";
          $resultLeaveManagement = mysqli_query($leaveManagementCon, $sqlLeaveManagement);

          if ($resultLeaveManagement) {
          ?>

            <?php
            while ($rowLeaveManagement = mysqli_fetch_assoc($resultLeaveManagement)) {
            ?>
              <?php
              $timestamp = strtotime($rowLeaveManagement['leavedate']);
              $formattedDate = date('D', $timestamp);
              $formattedDate1 = date('d', $timestamp);
              $formattedDate2 = date('M', $timestamp);
              $formattedDate3 = date('H\H  i\M', $timestamp);
              $hours = date('H', $timestamp);
              $minutes = date('i', $timestamp);
              $formattedDateWithLabels = "$hours Hrs $minutes mins";

              $timestamp1 = strtotime($rowLeaveManagement['marktime']);
              $hours1 = date('H', $timestamp1);
              $minutes1 = date('i', $timestamp1);
              $formattedDateWithLabels1 = "$hours1 Hrs $minutes1 mins";

              ?>
              <table>
                <tr>
                  <td style="display: block; margin-bottom: -5px;">
                    <div class="frame-child14"></div>
                    <div class="frame-child15"></div>
                    <h3 style="color: white; font-size: 19px; margin-left: 18px; margin-top: -43px;"><?php echo $formattedDate; ?></h3>
                    <p style="font-size: 10px; margin-left: 10px; margin-top: -20px; color: white;"><?php echo $formattedDate1; ?> <?php echo $formattedDate2; ?></p>
                    <p style="font-size: 15px; color: white; margin-left: 19px; margin-top: -57px;"><?php echo $rowLeaveManagement['way'] ?></p>
                    <div class="line-div" style="margin-left: 149px; margin-top: -36px;"></div>
                    <div class="frame-child16" style="margin-left: 252px; margin-top: -40px;"></div>
                    <p style="font-size: 12px; margin-left: 75px; margin-top: -35px;">Gatepass ID:</p>
                    <p style="margin-left: 73px; margin-top: -6px; font-size: 8.5px;"><?php echo date('Ymd', strtotime($rowLeaveManagement['leavedate'])); ?>-000<?php echo $rowLeaveManagement['id']; ?></p>
                    <p style="margin-left: 86px; margin-top: -3px;">Issued By:</p>
                    <p style="margin-left: 86px; margin-top: -8px;"><?php echo $rowLeaveManagement['email'] ?></p>
                    <p style="font-size: 13px; margin-left: 153px; margin-top: -69px;">Out:</p>
                    <p style="font-size: 13px; margin-left: 163px; margin-top: -9px;">In:</p>
                    <p style="margin-top: -8px; margin-left: 150px;">Approved/Rejected By:</p>
                    <p style="margin-left: 150px; margin-top: -7px;"> <?php
                                                                      if (!empty($rowLeaveManagement['email1'])) {
                                                                        echo $rowLeaveManagement['email1'];
                                                                      } else {
                                                                        echo "[Action Pending]";
                                                                      }
                                                                      ?></p>
                    <p style="margin-left: 260px; margin-top: -33px;">Approval Status:</p>
                    <p style="margin-top: -8px; margin-left: 260px;"><?php
                                                                      if ($rowLeaveManagement['status'] == 0) {
                                                                        echo "<span style='color: #fcf99e;'>Pending </span>";
                                                                      } elseif ($rowLeaveManagement['status'] == 1) {
                                                                        echo "<span style='color: #00ff77;'>Approved</span>";
                                                                      } elseif ($rowLeaveManagement['status'] == 2) {
                                                                        echo "<span style='color: #f35c17;'>Rejected</span>";
                                                                      }

                                                                      ?></p>
                    <p style="margin-left: 180px; font-size: 10px; margin-top: -69px;"><?php
                                                                                        if ($rowLeaveManagement['status'] == 2) {
                                                                                          echo "<span class='badge badge-danger'>[GP Rejected]</span>";
                                                                                        } else {
                                                                                          echo $formattedDateWithLabels;
                                                                                        }
                                                                                        ?></p>
                    <p style="margin-left: 180px; font-size: 10px; margin-top: -3px;"><?php
                                                                                      if ($rowLeaveManagement['status'] == 2) {
                                                                                        echo "<span class='badge badge-danger'>[GP Rejected]</span>";
                                                                                      } elseif ($rowLeaveManagement['mark'] == 0 & $rowLeaveManagement['way'] == '2 WAY') {
                                                                                        echo "<span class='badge badge-danger'>[to be marked]</span>";
                                                                                      } elseif ($rowLeaveManagement['mark'] == 0 & $rowLeaveManagement['way'] == '1 WAY') {
                                                                                        echo "<span style='font-size:11px !important;' class='badge badge-default'>N/A</span>";
                                                                                      } else {
                                                                                        echo $formattedDateWithLabels1;
                                                                                      }

                                                                                      ?></p>
                    <p style="font-size: 13px; margin-left: 256px; margin-top: -44px;">Out Duration:</p>
                    <p style="margin-left: 260px; font-size: 11px; margin-top: -8px;"><?php if ($rowLeaveManagement['status'] == 2) {
                                                                                        echo "<span class='badge badge-danger'> [GP Rejected]</span>";
                                                                                      } elseif ($rowLeaveManagement['way'] == '1 WAY') {
                                                                                        echo "<span style='font-size:11px !important;' class='badge badge-default'>N/A</span>";
                                                                                      } elseif ($rowLeaveManagement['mark'] == 0 & $rowLeaveManagement['way'] == '2 WAY') {
                                                                                        echo "<span class='badge badge-danger'>[to be marked]</span>";
                                                                                      } elseif ($rowLeaveManagement['status'] == 0) {
                                                                                        echo "<span class='badge badge-warning'>Pending <br>for Approval </span>";
                                                                                      } else {
                                                                                        $date1 = new DateTime(date('Y-m-d H:i:s', strtotime('+12 hours +30 minutes', strtotime($rowLeaveManagement['marktime']))));
                                                                                        $date2 = new DateTime($rowLeaveManagement['leavedate']);
                                                                                        $interval = $date1->diff($date2);
                                                                                        echo $interval->format('%Hhrs %imins');
                                                                                      } ?></p>
                    <?php
                    if ((($rowLeaveManagement['status'] == 0 || $rowLeaveManagement['status'] == 2) & $rowLeaveManagement['way'] == '1 WAY')) {
                      echo "<svg style='margin-top: 10px;' xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='#4a90e2' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'><path d='M16 17l5-5-5-5M19.8 12H9M10 3H4v18h6'/></svg>
                                        ";
                    } elseif ($rowLeaveManagement['status'] == 2) {
                      echo "
                                      <svg style='margin-top: 10px;' xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='#e24a4a' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'><path d='M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z'/><path d='M14 3v5h5M9.9 17.1L14 13M9.9 12.9L14 17'/></svg>

                                  ";
                    } elseif ($rowLeaveManagement['status'] == 2 & $rowLeaveManagement['way'] == '2 WAY' & $rowLeaveManagement['mark'] == '0') {
                      echo "
                                        <img src='../public/cross.png'  width='35px' style='margin-top: 10px;'>
                                    ";
                    } else {
                      echo "
                                        <img src='../public/tick.png' width='25px' style='margin-top: 10px;'>
                                    ";
                    }

                    ?>
                  </td>
                <?php
              }
                ?>

              <?php
            } else {
              echo "Error in Leave Management System query: " . mysqli_error($leaveManagementCon);
            }
              ?>
                </tr>
              </table>
        </div>
      </div>
  <?php
    mysqli_close($leaveManagementCon);
  } else {
    echo "Error in HRMS query: " . mysqli_error($hrmsCon);
  }

  mysqli_close($hrmsCon);
} else {
  echo "";
  exit();
}
  ?>
  <script>
    var fluentpersonClock20Regular = document.getElementById(
      "fluentpersonClock20Regular"
    );
    if (fluentpersonClock20Regular) {
      fluentpersonClock20Regular.addEventListener("click", function(e) {
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
  </script>
    </body>

    </html>