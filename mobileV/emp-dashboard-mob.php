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

    <link rel="stylesheet" href="./empmobcss/globalqw.css" />
    <link rel="stylesheet" href="./empmobcss/emp-dashboard-mob.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <style>
      .calendar-container {
        height: auto;
        width: 450px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0px 0px 20px rgba(255, 255, 255, 0.4);
        padding: 20px 20px;
        border: 2px solid #F46114;
      }

      .calendar-week {
        display: flex;
        list-style: none;
        align-items: center;
        padding-inline-start: 0px;
      }

      .calendar-week-day {
        max-width: 57.1px;
        width: 100%;
        text-align: center;
        color: #525659;
      }

      .calendar-days {
        margin-top: 30px;
        list-style: none;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr 1fr;
        gap: 20px;
        padding-inline-start: 0px;
      }

      .calendar-day {
        text-align: center;
        color: #525659;
        padding: 10px;
      }

      .calendar-month-arrow-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
      }

      .calendar-month-year-container {
        padding: 10px 10px 20px 10px;
        color: #525659;
        cursor: pointer;
      }

      .calendar-arrow-container {
        margin-top: -5px;
      }

      .calendar-left-arrow,
      .calendar-right-arrow {
        height: 30px;
        width: 30px;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        color: #525659;
      }

      .calendar-today-button {
        margin-top: -10px;
        border-radius: 10px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        color: #525659;
        padding: 1px 1px;
      }

      .calendar-today-button {
        height: 27px;
        margin-right: 0px;
        background-color: #ec7625;
        color: white;
      }

      .calendar-months,
      .calendar-years {
        flex: 1;
        border-radius: 10px;
        height: 40px;
        border: none;
        cursor: pointer;
        outline: none;
        color: #525659;
        font-size: 15px;
      }

      .calendar-day-active {
        background-color: #ec7625;
        color: white;
        border-radius: 50%;
      }

      .calendar-day-holiday {
        color: #cc0000 !important;
      }

      .holiday-name {
        font-size: 10px;
        color: #ff0000;
        text-align: start !important;
        position: absolute;
        transform: translateX(-20%);
      }

      .holiday-style {
        background-color: #ffcccc !important;
        color: #cc0000 !important;
      }

      .holiday-name-style {
        font-size: 10px;
        color: #ff0000;
        text-align: start !important;
        position: absolute;
        transform: translateX(-20%);
      }

      .logo-1-icon10 {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 55px;
        height: 55px;
        object-fit: cover;
      }

      .calendar-icontainer {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #fb8b0b44;
        border: 2px solid #F46114;
      }

      .calendar-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #F7780F;
        margin-right: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .calendar-icon i {
        color: white;
        font-size: 22px;
      }

      .calendar-text {
        padding: 8px;
      }
      .dropdown-content1 {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 120px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
      top:-10px;
      left:220px;
    }

    .dropdown-content1 a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content1 a:hover {
      background-color: #f1f1f1;
    }

    .rectangle-parent32 {
      position: relative; 
    }

    .mobile-item{
  display: none;
}
     
    </style>
  </head>

  <body>
    <div class="empdashboard-mob" style="height: 100svh;">
      <div class="logo-1-parent7">
        <img class="logo-1-icon9" alt="" src="./public/logo-1@2x.png" />
        <a class="employee-management8" style="width: 300px;">Employee Management</a>
      </div>
      <a href="../logout.php"><img class="logo-1-icon10" alt="" src="./public/Logout-removebg-preview.png" /></a>
      <div class="empdashboard-mob-child"></div>

      <div class="fluentperson-clock-20-regular-parent3">
        <a  style="margin-left:10px;" class="fluentperson-clock-20-regular9" id="fluentpersonClock20Regular">
          <img class="vector-icon33" alt="" src="./public/vector1@2xleaves.png" />
        </a>
        <a style="margin-left:-20px;" class="uitcalender9" id="uitcalender">
          <img class="vector-icon34" alt="" src="./public/vector2@2xatten.png" />
        </a>
        <img style="margin-left:-55px;" class="arcticonsgoogle-pay9" alt="" src="./public/arcticonsgooglepay1@2x.png" id="arcticonsgooglePay" />

        <div style="margin-left:10px;" class="frame-child74"></div>
        <a style="margin-left:10px;" class="akar-iconsdashboard9">
          <img class="vector-icon35" alt="" src="./public/vector.svg" />
        </a>

        <a href="../module_transition_emp-policies/index.php?target=https://hrms.anikasterilis.com/emppolicy/emppolicy.php" >
        <img  class="arcticonsgoogle-pay9" alt="" src="../public1/policy-mob.svg" id="arcticonsgooglePay" />
        </a>
      </div>

      <div class="empdashboard-mob-item"></div>
      <div class="frame-parent3" style="height: 60px;">
        <div class="rectangle-parent29">
          <a class="frame-child75" id="rectangleLink"> </a>
          <a class="gatepass-log1" id="gatepassLog">Gatepass Log</a>
        </div>
        <div class="rectangle-parent30" id="frameContainer3">
          <a class="frame-child76"> </a>
          <a class="personal-details5" id="personalDetails">Personal Details</a>
        </div>
        <div class="rectangle-parent31" id="frameContainer4">
          <a class="frame-child76"> </a>
          <a class="job4" id="job">Job</a>
        </div>
        <div class="rectangle-parent32" id="frameContainer5">
  <a class="frame-child76"></a>
  <a class="salary4" id="salary">Payroll</a>
 
</div>

        <div class="rectangle-parent33" id="frameContainer6">
          <a class="frame-child76"> </a>
          <a class="documents4" id="documents">Documents</a>
        </div>
      </div>
      <?php
      $sql = "SELECT * FROM emp WHERE (empemail = '" . $_SESSION['user_name'] . "' && empstatus= 0 )";
      $que = mysqli_query($con, $sql);
      $cnt = 1;
      $row = mysqli_fetch_array($que);
      ?>
      <div class="frame-parent4" style="width: 450px; overflow-x: hidden;">
      <div class="dropdown-content1" id="dropdown-content1" >
    <a href="emp-salary-details-mob1.php">Salary Details</a>
    <a href="payslip.php">Payslip</a>
    <a href="emploan.php">Employee Loan</a>
  </div>
        <div class="rectangle-parent34">
          <div class="frame-child80" style="border: 2px solid #F46114;"></div>
          <input class="input12" style="font-size:12px; background:transparent; margin-top:px; margin-left:-90px;" value="<?php $orgDate = $row['empdob'];
                                                                                                                              $newDate = date("d-m-Y", strtotime($orgDate));
                                                                                                                              echo $newDate;  ?>" type="text" readonly />

          <img style="border-radius:100px;" class="screenshot-2023-10-27-141446-1" alt="" src="../pics/<?php echo $row['pic']; ?>" />

          <img class="frame-child81" alt="" src="./public/frame-153@2x.png" style="margin-top:-10px"/>

          <h3 class="basic-info" style="text-transform: uppercase;margin-top:-10px">Basic Info</h3>
          <p class="gender1" style="margin-top:-15px"><b>Gender:</b></p>
          <input class="male" style="font-size:12px; background:transparent; margin-top:-10px;margin-left:-60px;" value="<?php echo $row['empgen']; ?>" type="text" readonly />

          <p class="marital-status1" style="margin-top:-10px;"><b>Marital Status:</b></p>
          <input class="single" style="font-size:12px; background:transparent; margin-top:-8px;margin-left:-98px;" value="<?php echo $row['empms']; ?>" type="text" readonly />

          <p class="date-of-birth1" style="margin-top:-4px;"><b>Date of Birth:</b></p>
          <img style="margin-top:15px" class="solarsuitcase-outline-icon" alt="" src="./public/solarsuitcaseoutline.svg" />

          <h3 class="job-info" style="text-transform: uppercase;margin-top:10px">Job Info</h3>
          <!-- <p class="joining-date24112022"><b>Joining Date:</b> <?php echo $row['empdoj']; ?></p> -->
          <p class="department-it" style="margin-top:-15px"><b>Designation:</b> <?php echo $row['desg']; ?></p>
          <input class="aspl202211240019" style="font-size:12px; background:transparent; margin-top:-10px;" value="<?php echo $row['emp_no']; ?>" type="text" readonly />
          <input class="aspl202211240019" style="margin-top: 12px; width: 250px; font-size:12px; background:transparent;" value="<?php echo $row['empname']; ?>" type="text" readonly />
        </div>
        <div class="rectangle-parent35">
          <div class="frame-child82" style="border: 2px solid #F46114;"></div>
          <?php
          $currentDate = date('Y-m-d');

          $user_name = $_SESSION['user_name'];
          $sql = "SELECT serviceTagId FROM emp WHERE empemail = '$user_name'";
          $result = $con->query($sql);
          
          if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              $serviceTagId = $row['serviceTagId'];
          
              // Determine the table name based on serviceTagId
              if ($serviceTagId == 'ZXQI19009096') {
                  $tableName = 'CamsBiometricAttendance';
              } elseif ($serviceTagId == 'ZYSA07001899') {
                  $tableName = 'CamsBiometricAttendance_GGM';
              } else {
                  die("No attendance table associated with this serviceTagId.");
              }

          }


          $sql = "SELECT emp.*, $tableName.*
              FROM emp
              INNER JOIN $tableName ON emp.UserID = $tableName.UserID
              WHERE empemail = '{$_SESSION['user_name']}'
              AND DATE($tableName.AttendanceTime) = '$currentDate'";

          $que = mysqli_query($con, $sql);
          $userCheckOut = array();
          $userEntriesCount = array();
          $prevDay = null;

          while ($result = mysqli_fetch_assoc($que)) {
            $userId = $result['UserID'];
            $dayOfMonth = date('j', strtotime($result['AttendanceTime']));
            $formattedDate = date('D j M', strtotime($result['AttendanceTime']));

            if ($result['AttendanceType'] == 'CheckOut') {
              $userCheckOut[$userId] = array(
                'AttendanceTime' => $result['AttendanceTime'],
                'InputType' => $result['InputType'],
                'Department' => $result['dept']
              );
            } elseif ($result['AttendanceType'] == 'CheckIn') {
              $currentDay = date('j', strtotime($result['AttendanceTime']));
          ?>
              <input class="input13" style="margin-top:-47px; font-size:12px; background:transparent; margin-left:90px;" value=" <?php echo isset($result['AttendanceTime']) ? date('H:i:s', strtotime($result['AttendanceTime'])) : ''; ?>" type="tel" readonly />


              <?php
              if (isset($userCheckOut[$userId])) {
                $inTime = strtotime($result['AttendanceTime']);
                $outTime = strtotime($userCheckOut[$userId]['AttendanceTime']);

                // Calculate the difference in seconds
                $secondsDiff = $outTime - $inTime;

                // Calculate hours and minutes
                $hours = floor($secondsDiff / 3600);
                $minutes = floor(($secondsDiff % 3600) / 60);

                echo $hours . ' hrs ' . $minutes . ' mins';
              } else {
                $timeInput = strtotime($result['AttendanceTime']);
                $origin = new DateTime(date('Y-m-d H:i:s', $timeInput));
                $target = new DateTime(); // Current time
                $target->modify('+5 hours 30 minutes');
                $interval = $origin->diff($target);

                echo $interval->format('%h hrs %i mins') . PHP_EOL;
              ?>
                <input class="naradamohan1gmailcom" style="margin-top:-22px; font-size:12px; background:transparent; margin-left:95px; width:300px;" value=" <?php echo $interval->format('%h hrs %i mins') . PHP_EOL; ?>" type="text" readonly />
          <?php
              }
            }
          }
          ?>


          <?php
          $empname = $_SESSION['user_name'];

          $sql = "SELECT dept.*
            FROM emp
            INNER JOIN dept ON emp.desg = dept.desg
            WHERE emp.empemail = '$empname'";

          $result = $con->query($sql);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              // Convert fromshifttime1 and toshifttime1 to DateTime objects
              $fromShiftTime = new DateTime($row['fromshifttime1']);
              $toShiftTime = new DateTime($row['toshifttime1']);

              // Calculate the difference between the times
              $interval = $fromShiftTime->diff($toShiftTime);

              // Format the difference
              $duration = $interval->format('%h hrs %i mins');

              // echo $duration;
            }
          } else {
            echo "No designation found for this employee";
          }
          ?>

          <?php
          $sql_last_record = "SELECT emp.*, $tableName.*
                    FROM emp
                    INNER JOIN $tableName ON emp.UserID = $tableName.UserID
                    WHERE empemail = '{$_SESSION['user_name']}'
                    AND DATE($tableName.AttendanceTime) != '$currentDate'
                    ORDER BY $tableName.AttendanceTime DESC
                    LIMIT 1";

          $que_last_record = mysqli_query($con, $sql_last_record);

          // Fetch the last record other than currentDate
          if ($result_last_record = mysqli_fetch_assoc($que_last_record)) {
          ?>
            <input class="naradamohan1gmailcom" style="margin-top:-48px; font-size:12px; background:transparent; margin-left:93px; width:300px;" value=" <?php echo $result_last_record['AttendanceTime']; ?>" type="text" readonly />
          <?php
          }
          ?>



          <input class="naradamohan1gmailcom" style="margin-top:2px; font-size:12px; background:transparent; margin-left:95px; width:300px;" value=" <?php echo $duration ?>" type="text" readonly />


          <div class="vector-wrapper">
            <img style="height:20px;margin-left: -60px;" class="vector-icon36" alt="" src="./public/vector8contact.svg" />

          </div>
          <h3 class="basic-info" style="margin-left: -60px;margin-top:-10px;text-transform: uppercase;">Duty Hours Info</h3>
          <!--<h3 class="contact-info">Contact Info</h3>-->
          <p class="phone" style="margin-top:-35px"><b>Check IN Time:</b></p>
          <p class="email">
            <span class="email1" style="margin-top:-37px; width:300px;"><b>Recent Check IN/OUT:</b></span>
          </p>
          <p class="email">
            <span class="email1" style="margin-top:-13px; width:300px;"><b>Total Worked Hours:</b></span>
          </p>
          <p class="email">
            <span class="email1" style="margin-top:12px; width:300px;"><b>Actual Work Hours:</b></span>
          </p>

        </div>
        <div class="rectangle-parent36">
          <?php
          $sql = "SELECT * FROM leavebalance WHERE empemail = '{$_SESSION['user_name']}'";
          $que = mysqli_query($con, $sql);
          $cnt = 1;
          if (mysqli_num_rows($que) == 0) {
            echo '<tr><td colspan="5" style="text-align:center;">Stay tuned for upcoming updates on your leave balance! Keep an eye on this space for exciting developments.</td></tr>';
          } else {
            while ($result = mysqli_fetch_assoc($que)) {
          ?>
              <div class="frame-child83" style="border: 2px solid #F46114;height:250px">
                <div>
                  <p style="font-size:9px; font-weight:400;margin-left:12px; margin-top:30px; color:#8a7561">(Updated as of <b><?php echo date('Y-m-d H:i:s', strtotime($result['lastupdate'] . ' +5 hours +30 minutes')); ?> </b>)</p>
                </div>
                <div style="position:absolute; z-index:9; display:flex; scale:0.63; margin-left:-120px; margin-top:-60px">
                  <div style="background-color:#f6f5fb; width:250px; height:310px; border-radius:20px; margin-left:30px;"> <br />
                    <div style="border:2px solid #dadada; width:90%;margin-left:auto; margin-right:auto; border-radius:20px">
                      <img src="../public/Casualleavee.png" width="70px" style="margin-left:85px; margin-top:10px;" />
                      <p style="font-size:18px; font-weight:400;margin-left:15px;">Leave Balance(SL + CL)*</p>
                      <p style="font-size:16px; font-weight:400;margin-left:10px; margin-top:-10px; color:#8a7561">*Leave Balance Allocated</p>
                      <p style="font-size:16px; font-weight:400;margin-left:15px; margin-top:-5px; color:#8a7561"></p>
                    </div>
              <p style="font-size:16px; font-weight:400;margin-left:10px; margin-top: 10px;">*Allocated Leave balance - <b><?php echo  $result['icl'] + $result['isl']; ?></b></p>
                    <p style="font-size:16px; font-weight:400;margin-left:10px; margin-top: 10px;">*Remaining Leave balance - <b class="text-green-500"><?php echo  $result['cl'] + $result['sl']; ?></b></p>
                  </div>
                  <div style="background-color:#f6f5fb; width:250px; height:310px; border-radius:20px; margin-left:30px;"> <br />
                    <div style="border:2px solid #dadada; width:90%;margin-left:auto; margin-right:auto; border-radius:20px">
                      <img src="../public/Compoff.png" width="70px" style="margin-left:85px; margin-top:10px;" />
                      <p style="font-size:18px; font-weight:400;margin-left:15px;">Comp. Off's*</p>

                      <p style="font-size:16px; font-weight:400;margin-left:15px; margin-top:-10px; color:#8a7561">*Comp.Off(s) Earned
                        <!-- <a style="margin-top:20px;">
                      <svg width="24" height="24" style="scale:0.6" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                        <path d="M14.851 11.923c-.179-.641-.521-1.246-1.025-1.749-1.562-1.562-4.095-1.563-5.657 0l-4.998 4.998c-1.562 1.563-1.563 4.095 0 5.657 1.562 1.563 4.096 1.561 5.656 0l3.842-3.841.333.009c.404 0 .802-.04 1.189-.117l-4.657 4.656c-.975.976-2.255 1.464-3.535 1.464-1.28 0-2.56-.488-3.535-1.464-1.952-1.951-1.952-5.12 0-7.071l4.998-4.998c.975-.976 2.256-1.464 3.536-1.464 1.279 0 2.56.488 3.535 1.464.493.493.861 1.063 1.105 1.672l-.787.784zm-5.703.147c.178.643.521 1.25 1.026 1.756 1.562 1.563 4.096 1.561 5.656 0l4.999-4.998c1.563-1.562 1.563-4.095 0-5.657-1.562-1.562-4.095-1.563-5.657 0l-3.841 3.841-.333-.009c-.404 0-.802.04-1.189.117l4.656-4.656c.975-.976 2.256-1.464 3.536-1.464 1.279 0 2.56.488 3.535 1.464 1.951 1.951 1.951 5.119 0 7.071l-4.999 4.998c-.975.976-2.255 1.464-3.535 1.464-1.28 0-2.56-.488-3.535-1.464-.494-.495-.863-1.067-1.107-1.678l.788-.785z" />
                      </svg>
                    </a> -->
                      </p>
                      <p style="font-size:16px; font-weight:400;margin-left:15px; margin-top:-5px; color:#8a7561"></p>
                    </div>
                   <p style="font-size:16px; font-weight:400;margin-left:15px; margin-top: 10px;">*Earned Comp.Off(s) - <b><?php echo $result['ico']; ?></b></p>
                    <p style="font-size:16px; font-weight:400;margin-left:15px; margin-top: 10px;" >Remaining Comp.Off(s)- <b class="text-green-500"><?php echo $result['co']; ?></b></p>

                  </div>
                </div>
              </div>
          <?php
            }
          }
          ?>
          <!--<div class="casual-leaves">Coming Soon !!!</div>-->
          <!-- <div class="sick-leaves">Sick Leaves:</div>
          <div class="total-leaves1">Total Leaves:</div> -->
          <h3 class="leave-balance">Leave Balance</h3><a href="my-leaveemp-mob.php" class="leave-balance" style="margin-left:120px;margin-top:-5px"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="25" viewBox="0 0 24 24" fill="none" stroke="#F46214" stroke-width="2.5" stroke-linecap="butt" stroke-linejoin="bevel">
              <g fill="none" fill-rule="evenodd">
                <path d="M18 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8c0-1.1.9-2 2-2h5M15 3h6v6M10 14L20.2 3.8" />
              </g>
            </svg></a>
          <img class="frame-child84" alt="" src="./public/line-30@2x.png" />

          <!-- <input class="input14" value="12" type="text" readonly/>

          <input class="input15" value="12" type="text" readonly/>

          <input class="input16" value="24" type="text" readonly/> -->
        </div>
        <div class="rectangle-parent37">
          <div class="calendar-container" style="scale: 0.75; margin-left: -53px; margin-top: -22px;">
            <div class="calendar-icontainer">
              <div class="calendar-icon">
                <i class="fas fa-calendar"></i>
              </div>
              <span class="calendar-text">Holiday Calendar 2024</span>
            </div>

            <div class="calendar-month-arrow-container">
              <div class="calendar-month-year-container">
                <select class="calendar-years"></select>
                <select class="calendar-months">
                </select>
              </div>
              <div class="calendar-month-year">
              </div>
              <div class="calendar-arrow-container">
                <button class="calendar-today-button"></button>
                <a href="../Reports/print_holiday_report.php" target="_blank" class="calendar-today-button" style="padding:3px;">PDF</a>
                <button class="calendar-left-arrow">
                  ← </button>
                <button class="calendar-right-arrow"> →</button>
              </div>
            </div>
            <ul class="calendar-week">
            </ul>
            <ul class="calendar-days">
            </ul>
          </div>
        </div>
        <div class="rectangle-parent35" style="margin-top:850px;">
          <div class="frame-child82" style="border: 2px solid #F46114;"></div>

          <?php
          $sql1 = "SELECT * FROM inet_access WHERE (empemail = '" . $_SESSION['user_name'] . "')";
          $que = mysqli_query($con, $sql1);
          $row = mysqli_fetch_array($que);

          if (!$row) {
            echo '<button style="position:absolute; left:25px; top:10px; display:flex; gap:10px" data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line></svg> Request office Wi-Fi/LAN access
          </button>';
          } else {
            if ($row['status'] == 0) {
              echo '<span style="white-space:nowrap;position:absolute; left:3px; top:10px; display:flex; gap:10px"> 
              <span class="bg-blue-100 text-blue-800 text-xs font-medium inline-flex items-center px-1.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">
              <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            
            Pending approval for access to the office Wi-Fi/LAN
      </span>
              </span>';
            } elseif ($row['status'] == 1) {
              echo '<span style="position:absolute; left:10px; top:10px; display:flex; gap:10px"> 
              <span class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-green-400 border border-green-400">
              <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 11.5 11 14l4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>You now have access to the office Wi-Fi/LAN
      </span>
              </span>';
            } elseif ($row['status'] == 2) {
              echo '<span style="white-space:nowrap;position:absolute; left:5px; top:10px; display:flex; gap:10px"> 
              <span class="bg-red-100 text-red-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded me-2 dark:bg-red-700 dark:text-red-400 border border-red-500 ">
              <svg class="w-4 h-4 me-1.5"  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 9-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            Regrettably,you cant access the office Wi-Fi/LAN
      </span>
              </span>';
            } else{
              echo '<button style="position:absolute; left:10px; top:10px; display:flex; gap:10px" data-modal-target="default-modal" data-modal-toggle="default-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line></svg> Request office internet access
            </button>';
            }
          }
          ?>

          <?php
          $sql = "SELECT * FROM emp WHERE (empemail = '" . $_SESSION['user_name'] . "' && empstatus= 0 )";
          $que = mysqli_query($con, $sql);
          $row = mysqli_fetch_array($que);
          ?>
          <form id="employeeForm">
            <!-- Main modal -->
            <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
              <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                  <!-- Modal header -->
                  <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Request Office Internet Access
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
                    <label>DEVICE TYPE:</label>
                    <div style="display:flex; gap:30px">
                      <div class="flex items-center mb-4">
                        <input id="country-option-1" type="radio" name="dtype" value="Mobile" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                        <label for="country-option-1" class="block ms-2  text-sm font-medium text-gray-900 dark:text-gray-300">
                          Mobile
                        </label>
                      </div>

                      <div class="flex items-center mb-4">
                        <input id="country-option-2" type="radio" name="dtype" value="Laptop/PC" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                        <label for="country-option-2" class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                          Laptop/PC
                        </label>
                      </div>
                    </div>
                    <label>DEVICE OWNERSHIP:</label>
                    <div style="display:flex; gap:30px">
                      <div class="flex items-center mb-4">
                        <input id="country-option-3" type="radio" name="downer" value="Personal" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:bg-gray-700 dark:border-gray-600">
                        <label for="country-option-3" class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                          Personal
                        </label>
                      </div>

                      <div class="flex items-center mb-4">
                        <input id="country-option-4" type="radio" name="downer" value="Office" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus-ring-blue-600 dark:bg-gray-700 dark:border-gray-600">
                        <label for="country-option-4" class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                          Office
                        </label>
                      </div>
                    </div>
                    <label class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">DEVICE NAME:</label>
                    <input name="dname" type="text" id="password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
                    <label class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">MODEL NAME:</label>
                    <input name="mname" type="text" id="password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
                    <label class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">S/N NUMBER:</label>
                    <input name="srno" type="text" id="password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
                    <label class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">PHYSICAL ADDRESS(MAC):</label>
                    <input name="mac" type="text" id="password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
                    <label class="block ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">REASON:</label>
                    <textarea name="reason" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a reason..."></textarea>
                  </div>
                  <input type="hidden" name="status" value="0">
                  <input type="hidden" name="empname" value="<?php echo $row['empname']; ?>">
                  <input type="hidden" name="empemail" value="<?php echo $row['empemail']; ?>">
                  <!-- Modal footer -->
                  <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                    <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
            <a href="../faqs/faq.php"><button style="position:absolute; left:25px; top:60px; display:flex; gap:10px" class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" type="button">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.03v13m0-13c-2.819-.831-4.715-1.076-8.029-1.023A.99.99 0 0 0 3 6v11c0 .563.466 1.014 1.03 1.007 3.122-.043 5.018.212 7.97 1.023m0-13c2.819-.831 4.715-1.076 8.029-1.023A.99.99 0 0 1 21 6v11c0 .563-.466 1.014-1.03 1.007-3.122-.043-5.018.212-7.97 1.023"/>
</svg>
 User Guide (FAQ's)
          </button></a>
        </div>
      </div>
    </div>
    <script>
  document.getElementById('salary').addEventListener('click', function(event) {
    event.preventDefault();
    var dropdownContent = document.getElementById('dropdown-content1');
    if (dropdownContent.style.display === 'block') {
      dropdownContent.style.display = 'none';
    } else {
      dropdownContent.style.display = 'block';
    }
  });

  // Close the dropdown if the user clicks outside of it
  window.onclick = function(event) {
    if (!event.target.matches('#salary')) {
      var dropdowns = document.getElementsByClassName('dropdown-content1');
      for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.style.display === 'block') {
          openDropdown.style.display = 'none';
        }
      }
    }
  }
</script>
    <script>
      $(document).ready(function() {
        $('#employeeForm').submit(function(e) {
          e.preventDefault();

          $.ajax({
            type: 'POST',
            url: '../insert_inet.php',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
              console.log('Success:', response);
              Swal.fire({
                icon: 'success',
                title: 'Done!',
                text: response,
                confirmButtonText: 'OK'
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = 'emp-dashboard-mob.php';
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

  </body>

<script>
    const weekArray = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    const monthArray = [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ];
    const current = new Date();
    const todaysDate = current.getDate();
    const currentYear = current.getFullYear();
    const currentMonth = current.getMonth();
    let holidaysData = [];

    async function fetchHolidaysAndGenerateCalendar() {
        let workLocation = "<?php echo $row['work_location']; ?>";
        let fetchUrl;

        if (workLocation === 'Visakhapatnam') {
            fetchUrl = '../fetchHolidays.php';
        } else if (workLocation === 'Gurugram') {
            fetchUrl = '../fetchHolidays_ggm.php';
        } else {
            console.error('Unknown work location:', workLocation);
            return;
        }

        try {
            const response = await fetch(fetchUrl);
            holidaysData = await response.json();
            updateCalendarWithHolidays(holidaysData);
            generateCalendarDays(new Date());
        } catch (error) {
            console.error('Error fetching holidays:', error);
        }
    }

    function updateCalendarWithHolidays(holidays) {
      console.log('Received holidays:', holidays);
      const holidayDates = holidays.map(holiday => holiday.date);
      console.log('Holiday dates:', holidayDates);
      const calendarDays = document.getElementsByClassName("calendar-day");

      Array.from(calendarDays).forEach((dayElement, index) => {
        const day = index + 1;
        const currentDate = new Date(currentYear, currentMonth, day);

        const matchingHoliday = holidays.find(holiday =>
          holiday.date === currentDate.toISOString().split('T')[0]
        );

        if (matchingHoliday) {
          console.log(`Adding holiday styles to day ${day}`);

          dayElement.style.backgroundColor = "#ffcccc";
          dayElement.style.color = "#cc0000";

          const holidayName = document.createElement("div");
          holidayName.textContent = matchingHoliday.name;
          holidayName.classList.add("holiday-name");

          holidayName.style.fontSize = "10px";
          holidayName.style.color = "#ff0000";
          holidayName.style.textAlign = "start";
          holidayName.style.position = "absolute";
          holidayName.style.transform = "translateX(-20%)";

          dayElement.appendChild(holidayName);
        }
      });
    }

    function applyHolidayStyles() {
      const holidayElements = document.querySelectorAll(".calendar-day-holiday");
      holidayElements.forEach(holidayElement => {
        holidayElement.classList.add("holiday-style");
      });

      const holidayNameElements = document.querySelectorAll(".holiday-name");
      holidayNameElements.forEach(nameElement => {
        nameElement.classList.add("holiday-name-style");
      });
    }

    window.onload = function() {
      const currentDate = new Date();
      generateCalendarDays(currentDate);

      let calendarWeek = document.getElementsByClassName("calendar-week")[0];
      let calendarTodayButton = document.getElementsByClassName("calendar-today-button")[0];
      calendarTodayButton.textContent = "Today";

      calendarTodayButton.addEventListener("click", () => {
        generateCalendarDays(currentDate);
      });

      weekArray.forEach((week) => {
        let li = document.createElement("li");
        li.textContent = week;
        li.classList.add("calendar-week-day");
        calendarWeek.appendChild(li);
      });

      const calendarMonths = document.getElementsByClassName("calendar-months")[0];
      const calendarYears = document.getElementsByClassName("calendar-years")[0];
      const monthYear = document.getElementsByClassName("calendar-month-year")[0];

      const selectedMonth = parseInt(monthYear.getAttribute("data-month") || 0);
      const selectedYear = parseInt(monthYear.getAttribute("data-year") || currentYear);

      monthArray.forEach((month, index) => {
        let option = document.createElement("option");
        option.textContent = month;
        option.value = index;
        option.selected = index === selectedMonth;
        calendarMonths.appendChild(option);
      });

      const startYear = currentYear - 60;
      const endYear = currentYear + 60;
      let newYear = startYear;
      while (newYear <= endYear) {
        let option = document.createElement("option");
        option.textContent = newYear;
        option.value = newYear;
        option.selected = newYear === selectedYear;
        calendarYears.appendChild(option);
        newYear++;
      }

      const leftArrow = document.getElementsByClassName("calendar-left-arrow")[0];

      leftArrow.addEventListener("click", () => {
        const monthYear = document.getElementsByClassName("calendar-month-year")[0];
        const month = parseInt(monthYear.getAttribute("data-month") || 0);
        const year = parseInt(monthYear.getAttribute("data-year") || currentYear);

        let newMonth = month === 0 ? 11 : month - 1;
        let newYear = month === 0 ? year - 1 : year;
        let newDate = new Date(newYear, newMonth, 1);
        generateCalendarDays(newDate);
      });

      const rightArrow = document.getElementsByClassName("calendar-right-arrow")[0];

      rightArrow.addEventListener("click", () => {
        const monthYear = document.getElementsByClassName("calendar-month-year")[0];
        const month = parseInt(monthYear.getAttribute("data-month") || 0);
        const year = parseInt(monthYear.getAttribute("data-year") || currentYear);
        let newMonth = month + 1;
        newMonth = newMonth === 12 ? 0 : newMonth;
        let newYear = newMonth === 0 ? year + 1 : year;
        let newDate = new Date(newYear, newMonth, 1);
        generateCalendarDays(newDate);
      });

      calendarMonths.addEventListener("change", function() {
        let newDate = new Date(calendarYears.value, calendarMonths.value, 1);
        generateCalendarDays(newDate);
      });

      calendarYears.addEventListener("change", function() {
        let newDate = new Date(calendarYears.value, calendarMonths.value, 1);
        generateCalendarDays(newDate);
      });

      fetchHolidaysAndGenerateCalendar();
    };

    function generateCalendarDays(currentDate) {
      const newDate = new Date(currentDate);
      const year = newDate.getFullYear();
      const month = newDate.getMonth();
      const totalDaysInMonth = getTotalDaysInAMonth(year, month);
      const firstDayOfWeek = getFirstDayOfWeek(year, month);
      let calendarDays = document.getElementsByClassName("calendar-days")[0];

      removeAllChildren(calendarDays);

      let firstDay = 1;
      while (firstDay <= firstDayOfWeek) {
        let li = document.createElement("li");
        li.classList.add("calendar-day");
        calendarDays.appendChild(li);
        firstDay++;
      }

      let day = 1;
      while (day <= totalDaysInMonth) {
        let li = document.createElement("li");
        li.textContent = day;
        li.classList.add("calendar-day");
        if (todaysDate === day && currentMonth === month && currentYear === year) {
          li.classList.add("calendar-day-active");
        }
        calendarDays.appendChild(li);

        const matchingHoliday = holidaysData.find(holiday =>
          holiday.date === new Date(Date.UTC(year, month, day)).toISOString().split('T')[0]
        );

        if (matchingHoliday) {
          li.classList.add("calendar-day-holiday");
          const holidayName = document.createElement("div");
          holidayName.textContent = matchingHoliday.name;
          holidayName.classList.add("holiday-name");
          li.appendChild(holidayName);
        }

        day++;
      }

      const monthYear = document.getElementsByClassName("calendar-month-year")[0];
      monthYear.setAttribute("data-month", month);
      monthYear.setAttribute("data-year", year);
      const calendarMonths = document.getElementsByClassName("calendar-months")[0];
      const calendarYears = document.getElementsByClassName("calendar-years")[0];
      calendarMonths.value = month;
      calendarYears.value = year;
    }

    function getTotalDaysInAMonth(year, month) {
      return new Date(year, month + 1, 0).getDate();
    }

    function getFirstDayOfWeek(year, month) {
      return new Date(year, month, 1).getDay();
    }

    function removeAllChildren(parent) {
      while (parent.firstChild) {
        parent.removeChild(parent.firstChild);
      }
    }
</script>
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

    var rectangleLink = document.getElementById("rectangleLink");
    if (rectangleLink) {
      rectangleLink.addEventListener("click", function(e) {
        window.location.href = "./gatepasslog-mob.php";
      });
    }

    var gatepassLog = document.getElementById("gatepassLog");
    if (gatepassLog) {
      gatepassLog.addEventListener("click", function(e) {
        window.location.href = "./gatepasslog-mob.php";
      });
    }

    var personalDetails = document.getElementById("personalDetails");
    if (personalDetails) {
      personalDetails.addEventListener("click", function(e) {
        window.location.href = "./emp-personal-details-mob.php";
      });
    }

    var frameContainer3 = document.getElementById("frameContainer3");
    if (frameContainer3) {
      frameContainer3.addEventListener("click", function(e) {
        window.location.href = "./emp-personal-details-mob.php";
      });
    }

    var job = document.getElementById("job");
    if (job) {
      job.addEventListener("click", function(e) {
        window.location.href = "./empjob-details-mob.php";
      });
    }

    var frameContainer4 = document.getElementById("frameContainer4");
    if (frameContainer4) {
      frameContainer4.addEventListener("click", function(e) {
        window.location.href = "./empjob-details-mob.php";
      });
    }

    // var salary = document.getElementById("salary");
    // if (salary) {
    //   salary.addEventListener("click", function(e) {
    //     window.location.href = "./emp-salary-details-mob1.php";
    //   });
    // }

    // var frameContainer5 = document.getElementById("frameContainer5");
    // if (frameContainer5) {
    //   frameContainer5.addEventListener("click", function(e) {
    //     window.location.href = "./emp-salary-details-mob1.php";
    //   });
    // }

    var documents = document.getElementById("documents");
    if (documents) {
      documents.addEventListener("click", function(e) {
        window.location.href = "./emp-salary-details-mob.php";
      });
    }

    var frameContainer6 = document.getElementById("frameContainer6");
    if (frameContainer6) {
      frameContainer6.addEventListener("click", function(e) {
        window.location.href = "./emp-salary-details-mob.php";
      });
    }
  </script>

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