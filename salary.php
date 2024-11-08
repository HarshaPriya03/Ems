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

    <link rel="stylesheet" href="./global.css" />
    <link rel="stylesheet" href="./salary.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap" />
    <style>
      input {
        font-size: 20px;
      }

      .myButton {
        box-shadow: inset 0px 1px 0px 0px #fff6af;
        background: linear-gradient(to bottom, #ffec64 5%, #FB8A0C 100%);
        background-color: #FB8A0C;
        border-radius: 6px;
        border: 1px solid #ffaa22;
        display: inline-block;
        cursor: pointer;
        color: #333333;
        font-family: Arial;
        font-size: 15px;
        font-weight: bold;
        padding: 6px 24px;
        text-decoration: none;
        text-shadow: 0px 1px 0px #ffee66;
      }

      .myButton:hover {
        background: linear-gradient(to bottom, #FB8A0C 5%, #ffec64 100%);
        background-color: #FB8A0C;
      }

      .myButton:active {
        position: relative;
        top: 1px;
      }

      .button-container {
        position: relative;
        display: inline-block;
      }

      .new-indicator {
        position: absolute;
        top: -10px;
        right: -25px;
        background-color: red;
        color: white;
        font-size: 12px;
        padding: 2px 5px;
        border-radius: 5px;
        animation: blink 0.9s infinite;
      }

      @keyframes blink {
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
    <div class="salary1">
      <div class="bg1"></div>
      <img class="salary-child" alt="" src="./public1/rectangle-1@2x.png" />

      <img class="salary-item" alt="" src="./public1/rectangle-2@2x.png" />

      <a class="anikahrm1">
        <span>Anika</span>
        <span class="hrm1">HRM</span>
      </a>
      <a class="employee-management1" id="employeeManagement">Employee Management</a>
      <a style="display: block; left: 90%; margin-top: 5px; font-size: 27px;" href="./employee-dashboard.php" class="employee-management1" id="employeeManagement"></a>
      <button class="salary-inner"></button>
      <a href="logout.php">
        <div class="logout1">Logout</div>
      </a>
      <a class="leaves1" href="apply-leave-emp.php">Leaves</a>
      <a class="attendance1" href="attendenceemp2.php">Attendance</a>
      <a href="card.php" style="text-decoration: none; color: #222222;" class="payroll1">Directory</a>
      <a class="fluentperson-clock-20-regular1">
        <img class="vector-icon4" alt="" src="./public1/vector.svg" />
      </a>
      <img class="uitcalender-icon1" alt="" src="./public1/uitcalender.svg" />

      <img class="arcticonsgoogle-pay1" alt="" src="./public1/arcticonsgooglepay.svg" />
      <?php
      $sql = "SELECT * FROM emp WHERE empemail = '" . $_SESSION['user_name'] . "' ";
      $que = mysqli_query($con, $sql);
      $row = mysqli_fetch_array($que);
      $empname = $row['empname'];
      ?>
      <?php
      $user_name = $_SESSION['user_name'];

      $sql1 = "SELECT emp.empname,emp.work_location
        FROM emp
        INNER JOIN user_form ON emp.empemail = user_form.email
        WHERE user_form.email = '$user_name'";

      $result1 = mysqli_query($con, $sql1);

      if ($result1) {
        if (mysqli_num_rows($result1) > 0) {
          $row1 = mysqli_fetch_assoc($result1);
          $empname = $row1['empname'];
          $work_location = $row1['work_location'];
        } else {
          $empname = "Unknown";
        }
      } else {
        $empname = "Unknown";
      }

      ?>
      <img class="salary-child2" alt="" src="./public1/rectangle-4@2x.png" />

      <img class="tablerlogout-icon1" alt="" src="./public1/tablerlogout.svg" />

      <a class="uitcalender1">
        <img class="vector-icon5" alt="" src="./public1/vector1.svg" />
      </a>
      <a class="dashboard1" id="dashboard">Dashboard</a>
      <a class="akar-iconsdashboard1" id="akarIconsdashboard">
        <img class="vector-icon6" alt="" src="./public1/vector2.svg" />
      </a>
      <div class="rectangle-container">
        <div class="frame-child4"></div>
        <img class="frame-child5" alt="" src="./public1/line-39.svg" />

        <a href="./personal-details.php" class="frame-child6" id="rectangleLink"> </a>
        <a href="./personal-details.php" class="personal-details1" id="personalDetails">Personal Details</a>
        <a href="./job.php" class="frame-child7" id="rectangleLink1"> </a>
        <a href="./directory.php" class="frame-child8" id="rectangleLink2"> </a>
        <a class="frame-child9"> </a>
        <a href="./job.php" class="job1" id="job">Job</a>
        <a href="./directory.php" class="document1" id="document">Document</a>
        <a class="salary2">Salary</a>
        <a href="./employee-dashboard.php"> <img class="bxhome-icon1" alt="" src="./public1/bxhome.svg" id="bxhomeIcon" /></a>
      </div>
      <div class="frame-div">
        <div class="frame-child10"></div>
        <!-- <a class="next1">Next</a> -->
        <h3 class="salary-details" style="width:100%;">Salary Details
          <a href="payslip.php" class="myButton">View Pay Slip</a>
          <?php if ($work_location == "Visakhapatnam") {
          ?>
            <div class="button-container">
              <a href="perdaysalary.php" class="myButton">View Salary Breakdown as per Working Days</a>
              <span class="new-indicator">NEW</span>
            </div>
          <?php
          }
          ?>
        </h3>
        <img class="frame-child11" alt="" src="./public1/line-12@2x.png" />

        <?php
        $sql1 = "SELECT * FROM payroll_msalarystruc WHERE empname =  '$empname' ";
        $que1 = mysqli_query($con, $sql1);
        $row1 = mysqli_fetch_array($que1);
        ?>

        <div class="frame-child12"></div>
        <input class="input" value="<?php echo ($row1 ? $row1['ctc'] : '0.00'); ?>" type="text" defaultvalue="3,00,000" />

        <div class="cost-to-the">Cost to the company</div>
        <div class="frame-child13"></div>
        <div class="frame-child14"></div>
        <div class="pf">PF</div>
        <input class="input1" value="<?php echo ($row1 ? $row1['epf1'] : '0.00'); ?>" type="text" defaultvalue="1500/-" />

        <input class="input2" value="<?php echo ($row1 ? $row1['esi1'] : '0.00'); ?>" type="text" defaultvalue="100/-" />
        <?php

        // $sum = $row['sald'] + $row['sald1'];
        ?>

        <input class="input3" value="<?php echo ($row1 ? $row1['tde'] : '0.00'); ?>" type="text" defaultvalue="1600/-" />

        <div class="esi">ESI</div>
        <div class="frame-child15"></div>
        <img class="mdirupee-icon" alt="" src="./public1/mdirupee.svg" />

        <input class="input4" value="<?php echo ($row1 ? $row1['netpay'] : '0.00'); ?>" type="text" defaultvalue="2,80,000" />

        <div class="total-payable">Total Payable</div>
        <img class="mdirupee-icon1" alt="" src="./public1/mdirupee.svg" />

        <input class="input5" value="<?php echo ($row1 ? $row1['tde'] : '0.00'); ?>" type="text" defaultvalue="20,000" />

        <div class="deductions">Deductions</div>
        <img class="mdirupee-icon2" alt="" src="./public1/mdirupee.svg" />

        <h3 class="deductions-breakdown">Deductions Breakdown</h3>
        <img class="frame-child16" alt="" src="./public1/line-40@2x.png" />

        <img class="frame-child17" alt="" src="./public1/line-41@2x.png" />
      </div>
      <img class="logo-1-icon1" alt="" src="./public1/logo-1@2x.png" />
    </div>

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