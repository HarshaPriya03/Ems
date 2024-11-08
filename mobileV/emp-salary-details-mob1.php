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
    <link rel="stylesheet" href="./empmobcss/emp-salary-details-mob1.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap"
    />
    <style>
      .myButton {
	box-shadow:inset 0px 1px 0px 0px #fff6af;
	background:linear-gradient(to bottom, #ffec64 5%, #FB8A0C 100%);
	background-color:#FB8A0C;
	border-radius:6px;
	border:1px solid #ffaa22;
	display:inline-block;
	cursor:pointer;
	color:#333333;
	font-family:Arial;
	font-size:12px;
	font-weight:bold;
	padding:3px 5px;
	text-decoration:none;
	text-shadow:0px 1px 0px #ffee66;
  padding-right: 20px; 
}
.myButton:hover {
	background:linear-gradient(to bottom, #FB8A0C 5%, #ffec64 100%);
	background-color:#FB8A0C;
}
.myButton:active {
	position:relative;
	top:1px;
}
.salary-details {
    display: grid;
    justify-content: center;
    align-items: center;
    gap: 5px;
    width:100%;
    margin-top:-18px;
    margin-left:-18px;
}
.button-container {
    position: relative;
    display: inline-block;
}

.new-indicator {
    position: absolute;
    top: -10px;
    right: -25px;
    background-color: tomato;
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
    <div class="empsalarydetails-mob1" style="height: 100svh;">
      <div class="logo-1-parent4">
        <img class="logo-1-icon6" alt="" src="./public/logo-1@2x.png" />

        <a class="employee-management2" style="width: 300px;">Employee Management</a>
      </div>
      <div class="empsalarydetails-mob-inner"></div>
      <div class="fluentperson-clock-20-regular-container">
        <a
          class="fluentperson-clock-20-regular6"
          id="fluentpersonClock20Regular"
        >
          <img
            class="vector-icon21"
            alt=""
            src="./public/vector1@2xleaves.png"
          />
        </a>
        <a class="uitcalender6" id="uitcalender">
          <img
            class="vector-icon22"
            alt=""
            src="./public/vector2@2xatten.png"
          />
        </a>
        <img
          class="arcticonsgoogle-pay6"
          alt=""
          src="./public/arcticonsgooglepay1@2x.png"
          id="arcticonsgooglePay"
        />

        <div class="frame-child27"></div>
        <a class="akar-iconsdashboard6" href="emp-dashboard-mob.php">
          <img
            class="vector-icon23"
            alt=""
            src="./public/vector.svg"
          />
        </a>
      </div>
      <div class="empsalarydetails-mob-child1"></div>
      <div class="frame-container" style="height: 60px;">
        <div class="rectangle-parent10" id="frameContainer2">
          <a class="frame-child28"> </a>
          <a class="personal-details1" id="personalDetails">Personal Details</a>
        </div>
        <div class="rectangle-parent11" id="frameContainer3">
          <a class="frame-child28"> </a>
          <a class="job1" id="job">Job</a>
        </div>
        <div class="rectangle-parent12">
          <a class="frame-child30"> </a>
          <a class="salary1">Salary</a>
        </div>
        <div class="rectangle-parent13" id="frameContainer5">
          <a class="frame-child31"> </a>
          <a class="documents1" id="documents">Documents</a>
        </div>
        <div class="line-group" id="frameContainer6">
          <div class="frame-child32"></div>
          <img
            class="bxhome-icon1"
            alt=""
            src="./public/bxhome@2x.png"
            id="bxhomeIcon"
          />
        </div>
      </div>
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
      <div class="rectangle-parent14" style="overflow-x: hidden;">
        <div class="frame-child33"></div>
        <a class="employee-management3" style="margin-left:50px;">Salary Details</a>

        <h3 class="salary-details" >
        <a href="payslip.php" class="myButton">View / Download Pay Slip</a>
         <?php if ($work_location == "Visakhapatnam") {
          ?>
<!--        <div class="button-container">-->
<!--    <a href="perdaysalary.php" class="myButton">View Salary Breakdown as per Working Days</a>-->
<!--    <span class="new-indicator">NEW</span>-->
<!--</div>-->
  <?php
          }
          ?>
        </h3>

        <img class="frame-child34" alt="" src="./public/line-12@2x.png" />
        <?php
         $sql = "SELECT * FROM emp WHERE empemail = '".$_SESSION['user_name']."' ";
         $que = mysqli_query($con,$sql);
         $row=mysqli_fetch_array($que);
         $empname= $row['empname'];
         ?>

<?php
         $sql1 = "SELECT * FROM payroll_msalarystruc WHERE empname =  '$empname' ";
         $que1 = mysqli_query($con,$sql1);
         $row1=mysqli_fetch_array($que1);
         ?>
        <div class="rectangle-parent15" >
          <div class="frame-child35" ></div>
          <div class="cost-of-company">Cost to Company</div>
          <img class="mdirupee-icon" alt="" src="./public/mdirupee@2x.png" />

          <input class="input6" value="<?php echo ($row1 ? $row1['ctc'] : '0.00'); ?>" type="text" readonly/>
        </div>
       
        <div class="rectangle-parent16">
          <div class="frame-child35"></div>
          <div class="cost-of-company">Total Payable</div>
          <img class="mdirupee-icon" alt="" src="./public/mdirupee@2x.png" />

          <?php 
        //   $sum = $row['sald'] + $row['sald1'];
          ?>

          <input class="input6"  value="<?php echo ($row1 ? $row1['netpay'] : '0.00'); ?>" type="text" readonly/>
        </div>
        <div class="rectangle-parent17">
          <div class="frame-child35"></div>
          <div class="cost-of-company">Deductions</div>
          <img class="mdirupee-icon" alt="" src="./public/mdirupee@2x.png" />

          <input class="input6"  value="<?php echo ($row1 ? $row1['tde'] : '0.00'); ?>" type="text" readonly/>
        </div>
        <div class="rectangle-parent18">
          <div class="frame-child38"></div>'
          <img src="./public/line-17@2x.png" style="z-index:9999; position:absolute; margin-top:125px; margin-left:165px; height:2px; width:80px;" />
          <img src="./public/line-17@2x.png" style="z-index:9999; position:absolute; margin-top:65px; margin-left:100px; height:2px; width:10px;" />
          <img src="./public/line-17@2x.png" style="z-index:9999; position:absolute; margin-top:100px; margin-left:100px; height:2px; width:10px;" />
          <h3 class="deductions-breakdown">Deductions Breakdown</h3>
          <h3 class="pf">PF</h3>
          <input class="input9"    value="<?php echo ($row1 ? $row1['epf1'] : '0.00'); ?>" type="text" readonly/>
          <input class="input11"    value="<?php echo ($row1 ? $row1['esi1'] : '0.00'); ?>" type="text" readonly/>
          <input class="input10"  value="<?php echo ($row1 ? $row1['tde'] : '0.00'); ?>" type="text" readonly/>

          <h3 class="esi">ESI</h3>
          <img class="frame-child39" alt="" src="./public/line-13@2x.png" />

          <!--<img class="frame-child40" height="2px" alt="" src="./public/line-14@2x.png" />-->
        </div>
      </div>
    </div>

    <script>
      var fluentpersonClock20Regular = document.getElementById(
        "fluentpersonClock20Regular"
      );
      if (fluentpersonClock20Regular) {
        fluentpersonClock20Regular.addEventListener("click", function (e) {
          window.location.href = "./apply-leaveemp-mob.php";
        });
      }
      
      var uitcalender = document.getElementById("uitcalender");
      if (uitcalender) {
        uitcalender.addEventListener("click", function (e) {
          window.location.href = "./attendenceemp-mob.php";
        });
      }
      
      var arcticonsgooglePay = document.getElementById("arcticonsgooglePay");
      if (arcticonsgooglePay) {
        arcticonsgooglePay.addEventListener("click", function (e) {
          window.location.href = "./directoryemp-mob.php";
        });
      }
      
      var personalDetails = document.getElementById("personalDetails");
      if (personalDetails) {
        personalDetails.addEventListener("click", function (e) {
          window.location.href = "./emp-personal-details-mob.php";
        });
      }
      
      var frameContainer2 = document.getElementById("frameContainer2");
      if (frameContainer2) {
        frameContainer2.addEventListener("click", function (e) {
          window.location.href = "./emp-personal-details-mob.php";
        });
      }
      
      var job = document.getElementById("job");
      if (job) {
        job.addEventListener("click", function (e) {
          window.location.href = "./empjob-details-mob.php";
        });
      }
      
      var frameContainer3 = document.getElementById("frameContainer3");
      if (frameContainer3) {
        frameContainer3.addEventListener("click", function (e) {
          window.location.href = "./empjob-details-mob.php";
        });
      }
      
      var documents = document.getElementById("documents");
      if (documents) {
        documents.addEventListener("click", function (e) {
          window.location.href = "./emp-salary-details-mob.php";
        });
      }
      
      var frameContainer5 = document.getElementById("frameContainer5");
      if (frameContainer5) {
        frameContainer5.addEventListener("click", function (e) {
          window.location.href = "./emp-salary-details-mob.php";
        });
      }
      
      var bxhomeIcon = document.getElementById("bxhomeIcon");
      if (bxhomeIcon) {
        bxhomeIcon.addEventListener("click", function (e) {
          window.location.href = "./emp-dashboard-mob.php";
        });
      }
      
      var frameContainer6 = document.getElementById("frameContainer6");
      if (frameContainer6) {
        frameContainer6.addEventListener("click", function (e) {
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