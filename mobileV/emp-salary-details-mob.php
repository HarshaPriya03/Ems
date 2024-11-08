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
    <link rel="stylesheet" href="./empmobcss/emp-salary-details-mob.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap"
    />
  </head>
  <body>
    <div class="empsalarydetails-mob" style="height: 100svh;">
      <div class="logo-1-parent3">
        <img class="logo-1-icon5" alt="" src="./public/logo-1@2x.png" />

        <a class="employee-management" style="width: 300px;">Employee Management</a>
      </div>
      <div class="empsalarydetails-mob-child"></div>
      <div class="fluentperson-clock-20-regular-group">
        <a
          class="fluentperson-clock-20-regular5"
          id="fluentpersonClock20Regular"
        >
          <img
            class="vector-icon17"
            alt=""
            src="./public/vector1@2xleaves.png"
          />
        </a>
        <a class="uitcalender5" id="uitcalender">
          <img
            class="vector-icon18"
            alt=""
            src="./public/vector2@2xatten.png"
          />
        </a>
        <img
          class="arcticonsgoogle-pay5"
          alt=""
          src="./public/arcticonsgooglepay1@2x.png"
          id="arcticonsgooglePay"
        />

        <div class="frame-child17"></div>
        <a class="akar-iconsdashboard5" href="emp-dashboard-mob.php">
          <img
            class="vector-icon19"
            alt=""
            src="./public/vector.svg"
          />
        </a>
      </div>
      <div class="empsalarydetails-mob-item"></div>
      <div class="frame-group" style="height: 60px;">
        <div class="rectangle-parent5" id="frameContainer2">
          <a class="frame-child18"> </a>
          <a class="personal-details" id="personalDetails">Personal Details</a>
        </div>
        <div class="rectangle-parent6" id="frameContainer3">
          <a class="frame-child18"> </a>
          <a class="job" id="job">Job</a>
        </div>
        <div class="rectangle-parent7" id="frameContainer4">
          <a class="frame-child18"> </a>
          <a class="salary" id="salary">Salary</a>
        </div>
        <div class="rectangle-parent8">
          <a class="frame-child21"> </a>
          <a class="documents">Documents</a>
        </div>
        <div class="line-parent" id="frameContainer6">
          <div class="frame-child22"></div>
          <img
            class="bxhome-icon"
            alt=""
            src="./public/bxhome@2x.png"
            id="bxhomeIcon"
          />
        </div>
      </div>
      <?php
         $sql = "SELECT * FROM emp WHERE empemail = '".$_SESSION['user_name']."' ";
         $que = mysqli_query($con,$sql);
         $cnt = 1;
         $row=mysqli_fetch_array($que);
         ?>
      <div class="rectangle-parent9">
        <div class="frame-child23"></div>
        <a class="employee-management1">Employee Management</a>
        <h3 class="uploaded-docs">Uploaded Docs</h3>
        <h3 class="documentspdf" style="margin-left:-40px; width:250px" ><?php echo $row['pdf']; ?></h3>
        <h3 class="document-view">Document View</h3>
        <img class="frame-child24" alt="" src="./public/line-12@2x.png" />

        <button class="frame-child25" style="z-index:1000;"><a style="text-decoration:none;color:white;" href="../pdfs/<?php echo $row['pdf']; ?>" target="_blank">View File</a></button>
      
        <img class="frame-icon" alt="" src="./public/frame-174@2x.png" />

        <div class="frame-child26"></div>
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
      
      var salary = document.getElementById("salary");
      if (salary) {
        salary.addEventListener("click", function (e) {
          window.location.href = "./emp-salary-details-mob1.php";
        });
      }
      
      var frameContainer4 = document.getElementById("frameContainer4");
      if (frameContainer4) {
        frameContainer4.addEventListener("click", function (e) {
          window.location.href = "./emp-salary-details-mob1.php";
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