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
    <link rel="stylesheet" href="./empmobcss/empjob-details-mob.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500&display=swap"
    />
  </head>
  <body>
    <div class="empjobdetails-mob" style="height: 100svh;">
      <div class="logo-1-parent5">
        <img class="logo-1-icon7" alt="" src="./public/logo-1@2x.png" />

        <a class="employee-management4" style="width: 300px;">Employee Management</a>
      </div>
      <div class="empjobdetails-mob-child"></div>
      <div class="fluentperson-clock-20-regular-parent1">
        <a
          class="fluentperson-clock-20-regular7"
          id="fluentpersonClock20Regular"
        >
          <img
            class="vector-icon25"
            alt=""
            src="./public/vector1@2xleaves.png"
          />
        </a>
        <a class="uitcalender7" id="uitcalender">
          <img
            class="vector-icon26"
            alt=""
            src="./public/vector2@2xatten.png"
          />
        </a>
        <img
          class="arcticonsgoogle-pay7"
          alt=""
          src="./public/arcticonsgooglepay1@2x.png"
          id="arcticonsgooglePay"
        />

        <div class="frame-child41"></div>
        <a class="akar-iconsdashboard7" href="emp-dashboard-mob.php">
          <img
            class="vector-icon27"
            alt=""
            src="./public/vector.svg"
          />
        </a>
      </div>
      <div class="empjobdetails-mob-item"></div>
      <div class="frame-parent1" style="height: 60px;">
        <div class="rectangle-parent19" id="frameContainer2">
          <a class="frame-child42"> </a>
          <a class="personal-details2" id="personalDetails">Personal Details</a>
        </div>
        <div class="rectangle-parent20">
          <a class="frame-child43"> </a>
          <a class="job2">Job</a>
        </div>
        <div class="rectangle-parent21" id="frameContainer4">
          <a class="frame-child44"> </a>
          <a class="salary2" id="salary">Salary</a>
        </div>
        <div class="rectangle-parent22" id="frameContainer5">
          <a class="frame-child44"> </a>
          <a class="documents2" id="documents">Documents</a>
        </div>
        <div class="line-container" id="frameContainer6">
          <div class="frame-child46"></div>
          <img
            class="bxhome-icon2"
            alt=""
            src="./public/bxhome@2x.png"
            id="bxhomeIcon"
          />
        </div>
      </div>
      <!-- <img class="vector-icon28" alt="" src="./public/vector7@2xarrow.png" /> -->
      <?php
         $sql = "SELECT * FROM emp WHERE empemail = '".$_SESSION['user_name']."' ";
         $que = mysqli_query($con,$sql);
         $cnt = 1;
         $row=mysqli_fetch_array($que);
         ?>

<?php
$employeeDesg = $row['desg']; 
$query = "SELECT empname FROM manager WHERE desg LIKE ?";

if ($stmt = $con->prepare($query)) {
    $searchDesg = "%".$employeeDesg."%";
    $stmt->bind_param("s", $searchDesg);

    $stmt->execute();

    $stmt->bind_result($managerName);

    if ($stmt->fetch()) {
        $managerName;
    } else {
 $employeeDesg;
    }

    $stmt->close();
} else {
    echo "Error preparing statement: " . $con->error;
}

?>

      <div class="rectangle-parent23">
        <div class="frame-child47"></div>
        <a class="employee-management5">Employee Management</a>
        <h3 class="employment-details">Employment Details</h3>
        <img class="frame-child48" alt="" src="./public/line-12@2x.png" />

        <label class="employee-id">Employee ID</label>
        <label class="date-of-joining">Date of Joining</label>
        <label class="reporting-manager">General Manager</label>
        <label class="employment-status">Reporting Manager</label>
        <label class="employment-type">Employment Type</label>
        <label class="salary-fixed" style="width:80%;">Work Location</label>
        <input class="frame-child49" type="text"  value="<?php echo $row['emp_no']; ?>" readonly/>

        <input class="frame-child50" type="text"  value="<?php echo $row['empdoj']; ?>" readonly/>

        <input class="frame-child51" type="text"  value="<?php echo $row['rm']; ?>" readonly/>

        <input class="frame-child52" type="text"  value="<?php echo $managerName; ?>" readonly/>

        <input class="frame-child53" type="text"  value="<?php echo $row['empty']; ?>" readonly/>
        <input class="frame-child54" type="text"  value="<?php echo $row['work_location']; ?>"  readonly/>
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