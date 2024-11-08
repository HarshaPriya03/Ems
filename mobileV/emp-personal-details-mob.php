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
    <link rel="stylesheet" href="./empmobcss/emp-personal-details-mob.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap"
    />
  </head>
  <body>
    <div class="emppersonaldetails-mob" style="height: 100svh;">
      <div class="logo-1-parent6">
        <img class="logo-1-icon8" alt="" src="./public/logo-1@2x.png" />

        <a class="employee-management6" style="width: 300px;">Employee Management</a>
      </div>
      <div class="emppersonaldetails-mob-child"></div>
      <div class="fluentperson-clock-20-regular-parent2">
        <a
          class="fluentperson-clock-20-regular8"
          id="fluentpersonClock20Regular"
        >
          <img
            class="vector-icon29"
            alt=""
            src="./public/vector1@2xleaves.png"
          />
        </a>
        <a class="uitcalender8" id="uitcalender">
          <img
            class="vector-icon30"
            alt=""
            src="./public/vector2@2xatten.png"
          />
        </a>
        <img
          class="arcticonsgoogle-pay8"
          alt=""
          src="./public/arcticonsgooglepay1@2x.png"
          id="arcticonsgooglePay"
        />

        <div class="frame-child55"></div>
        <a class="akar-iconsdashboard8" href="emp-dashboard-mob.php">
          <img
            class="vector-icon31"
            alt=""
            src="./public/vector.svg"
          />
        </a>
      </div>
      <div class="emppersonaldetails-mob-item"></div>
      <div class="frame-parent2" style="height: 60px;">
        <div class="rectangle-parent24">
          <a class="frame-child56"> </a>
          <a class="personal-details3">Personal Details</a>
        </div>
        <div class="rectangle-parent25" id="frameContainer3">
          <a class="frame-child57"> </a>
          <a class="job3" id="job">Job</a>
        </div>
        <div class="rectangle-parent26" id="frameContainer4">
          <a class="frame-child57"> </a>
          <a class="salary3" id="salary">Salary</a>
        </div>
        <div class="rectangle-parent27" id="frameContainer5">
          <a class="frame-child57"> </a>
          <a class="documents3" id="documents">Documents</a>
        </div>
        <div class="line-parent1" id="frameContainer6">
          <div class="frame-child60"></div>
          <img
            class="bxhome-icon3"
            alt=""
            src="./public/bxhome@2x.png"
            id="bxhomeIcon"
          />
        </div>
        
      </div>
        <!-- <img class="vector-icon32" alt="" style="" src="./public/vector7@2xarrow.png" /> -->
        <?php
         $sql = "SELECT * FROM emp WHERE empemail = '".$_SESSION['user_name']."' ";
         $que = mysqli_query($con,$sql);
         $cnt = 1;
         $row=mysqli_fetch_array($que)
         ?>
      <div class="rectangle-parent28" style="width: 350px;">
        <div class="frame-child61"></div>
        <a class="employee-management7">Employee Management</a>
        <h3 class="personal-details4">Personal Details</h3>
        <img class="frame-child62" alt="" src="./public/line-12@2x.png" />

        <label class="employee-name1">Employee Name*</label>
        <label class="date-of-birth">Date of Birth</label>
        <label class="phone-number">Phone Number</label>
        <label class="email-id">Email ID</label>
        <label class="marital-status">Marital Status</label>
        <label class="gender">Gender</label>
        <label class="pan">PAN</label>
        <label class="aadhaar">Aadhaar</label>
        <label class="account-number">Account Number</label>
        <label class="ifsc-code">IFSC Code</label>
        <label class="bank-name">Bank Name</label>
        <input class="frame-child63" type="text" value=" <?php echo $row['empname']; ?>" readonly/>

        <input class="frame-child64" type="text"  value="<?php  $orgDate = $row['empdob']; $newDate = date("d-m-Y", strtotime($orgDate));   echo $newDate;  ?>" readonly/>

        <input class="frame-child65" type="text"  value=" <?php echo $row['empph']; ?>"readonly/>

        <input class="frame-child66" type="text"  value=" <?php echo $row['empemail']; ?>"readonly/>

        <input class="frame-child67" type="text"  value=" <?php echo $row['empms']; ?>" readonly/>

        <input class="frame-child68" type="text"  value=" <?php echo $row['empgen']; ?>" readonly/>

        <input class="frame-child69" type="text"  value=" <?php echo $row['pan']; ?>" readonly/>

        <input class="frame-child70" type="text"  value=" <?php echo $row['adn']; ?>" readonly/>

        <input class="frame-child71" type="text"  value=" <?php echo $row['ban']; ?>" readonly/>

        <input class="frame-child72" type="text"  value=" <?php echo $row['ifsc']; ?>" readonly/>

        <input class="frame-child73" type="text"  value=" <?php echo $row['bn']; ?>"readonly/>
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